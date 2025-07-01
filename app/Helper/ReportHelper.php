<?php

namespace App\Helper;

use App\Models\Log;
use App\Models\Product;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportHelper
{

    public static function sendDailyReport() {
        $today = Carbon::today();
        $sales = Sale::with('items.product')->whereDate('sold_at', $today)->get();

        $totalRevenue = $sales->sum(function ($sale) {
            return $sale->items->sum(function ($item) {
                return $item->price * $item->quantity;
            });
        });


        $lowStockProducts = Product::whereColumn('quantity', '<=', 'stock_threshold')->get();

        $now = Carbon::now();
        $sixMonthsFromNow = Carbon::now()->addMonth(6);
        $expiringSoon = Product::whereBetween('expiry_date', [$now, $sixMonthsFromNow])->orderBy('expiry_date', 'asc')->get();

        $pdf = Pdf::loadView('report.d_report', [
            'sales' => $sales,
            'totalRevenue' => $totalRevenue,
            'lowStockProducts' => $lowStockProducts,
            'expiringSoon' => $expiringSoon,
            'date' => $today->toFormattedDateString()
        ]);

        $fileName = 'daily_report_'. $today->format('Y_m_d'). '.pdf';

        $filePath = storage_path('app/' . $fileName);

        if (file_exists($filePath)) {
            Log::info("✅ PDF successfully saved at: $filePath");
            return response()->download($filePath); // ← Optional: lets you download it in the browser
        } else {
            Log::error("❌ Failed to save PDF at: $filePath");
        }

        file_put_contents($filePath, $pdf->output());
        $caption = "Daily Sales Report for " . $today->toFormattedDateString();
        //send to telegram
        TelegramHelper::sendTelegramMessageFile($filePath, $fileName, $caption);
        Log::saveLog('green', 'Daily report is sent successfully');

        //unlink($filePath);
        return back()->with('success', 'Daily report send to Telegram');
    }


    public static function sendNewDailyReport()
    {
        $today = \Carbon\Carbon::today();
        $sales = \App\Models\Sale::whereDate('sold_at', $today)->with('items.product')->get();

        $totalRevenue = $sales->flatMap->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $lowStockProducts = \App\Models\Product::whereColumn('quantity', '<=', 'stock_threshold')->get();

        $expiringSoon = \App\Models\Product::whereBetween('expiry_date', [now(), now()->addMonths(6)])
            ->orderBy('expiry_date', 'asc')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('sales.rep', [
            'sales' => $sales,
            'totalRevenue' => $totalRevenue,
            'lowStockProducts' => $lowStockProducts,
            'expiringSoon' => $expiringSoon,
            'date' => $today->toFormattedDateString()
        ]);

        $fileName = 'new_daily_report_' . $today->format('Y_m_d') . '.pdf';
        $filePath = storage_path('app/' . $fileName);
        file_put_contents($filePath, $pdf->output());

        $caption = "🆕 New Daily Sales Report for " . $today->toFormattedDateString();

        \App\Helper\TelegramHelper::sendTelegramMessageFile($filePath, $fileName, $caption);
        \App\Models\Log::saveLog('green', 'New daily report sent successfully');

        unlink($filePath);
    }

}
