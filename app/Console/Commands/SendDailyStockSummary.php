<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendDailyStockSummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-stock-summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a daily stock summary';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lowStockProducts = Product::where('quantity', '<=', 5)->get();

        if($lowStockProducts->isEmpty()) {
            $this->info('No low stock products to info');
            return 0;
        }

        $message = "📦 *Daily Stock Alert*\n\n";
        foreach ($lowStockProducts as $product) {
            $message .= "- {$product->name}: {$product->quantity} left\n";
        }

        Http::post("https://api.telegram.org/bot" . config('services.telegram.bot_token') . "/sendMessage", [
            'chat_id' => config('services.telegram.chat_id'),
            'text' => $message,
            'parse_mode' => 'Markdown'
        ]);

        $this->info('Daily stock summary send to telegram');
        return 0;
    }
}
