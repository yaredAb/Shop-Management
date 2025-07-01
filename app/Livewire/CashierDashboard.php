<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Mockery\Exception;

class CashierDashboard extends Component
{
    public $selectedSale = null;

    public function mount()
    {
        $this->sales = Sale::where('status', 'pending')->with(['pharmacist', 'items.product'])->orderBy('created_at', 'desc')->get();
    }

    public function displaySale($saleId)
    {
        $this->selectedSale = Sale::with('items.product', 'pharmacist')->find($saleId);
    }

    public function proceedSale() {
        if(!$this->selectedSale) return;

        DB::beginTransaction();

        try{
            $this->selectedSale->update([
                'status' => 'completed',
                'cashier_id' => Auth::id(),
                'sold_at' => Carbon::now(),
            ]);

            foreach ($this->selectedSale->items as $item) {
                $product = $item->product; // Now this should work
                $product->decrement('quantity', $item->quantity);

                if ($product->quantity <= $product->stock_threshold) {
                    try {
                        \App\Helper\TelegramHelper::sendTelegramMessage("⚠️ Low Stock Alert!\nProduct: {$product->name}\nRemaining: {$product->quantity}");
                    } catch (\Exception $e) {
                        log_to_db('error', 'Telegram alert failed for product: ' . $product->name);
                    }
                }
            }
            DB::commit();

            $this->selectedSale = null;

            session()->flash('message', 'Sale has been proceeded');

        } catch(Exception $e){
            DB::rollBack();
            session()->flash('error', 'Failed to proceed');
        }
    }


    public function render()
    {
        $sales = Sale::with('pharmacist')->where('status', 'pending')->latest()->get();
        return view('livewire.cashier-dashboard', [
            'sales' => $sales
        ]);
    }
}
