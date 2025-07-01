<?php

namespace App\Http\Controllers;

use App\Helper\TelegramHelper;
use App\Helper\UserHelper;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SaleController extends Controller
{

    public function index() {
        if(UserHelper::userInfo()['privilage'] == 'user') {
            return redirect('/');
        }
        $orders = Sale::with(['items.product', 'cashier', 'pharmacist'])
            ->orderBy('sold_at', 'desc')
            ->get();


        return view('sales.index', compact('orders'));
    }


    public function monthlyReport(Request $request) {
        if(UserHelper::userInfo()['privilage'] == 'user') {
            return redirect('/');
        }
        $month = $request->input('month', now()->format('Y-m'));

        //parse the input
        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end = $start->copy()->endOfMonth();

        //$sales = Sale::whereBetween('sold_at', [$start, $end])->get();

        $totalRevenue = SaleItem::whereHas('sale', function ($query) use ($start, $end) {
            $query->whereBetween('sold_at', [$start, $end])
                ->where('status', 'completed');
        })->sum(DB::raw('price * quantity'));


        $topProduct = SaleItem::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->whereHas('sale', function ($query) use ($start, $end) {
                $query->whereBetween('sold_at', [$start, $end])->where('status', 'completed');
            })
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->with('product')
            ->first();


        $topDay = SaleItem::select(DB::raw('DATE(sales.sold_at) as day'), DB::raw('SUM(sale_items.price * sale_items.quantity) as total'))
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->whereBetween('sales.sold_at', [$start, $end])
            ->where('sales.status', 'completed')
            ->groupBy('day')
            ->orderByDesc('total')
            ->first();


        $dailySales = SaleItem::select(DB::raw('DATE(sales.sold_at) as date'), DB::raw('SUM(sale_items.price * sale_items.quantity) as total'))
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->whereBetween('sales.sold_at', [$start, $end])
            ->where('sales.status', 'completed')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = $dailySales->pluck('date')->toArray();
        $chartData = $dailySales->pluck('total')->toArray();



        $top5Products = SaleItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('sale', function ($query) use ($start, $end) {
                $query->whereBetween('sold_at', [$start, $end])->where('status', 'completed');
            })
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        $pieLabels = $top5Products->pluck('product.name');
        $pieData = $top5Products->pluck('total_sold');



        $hourlySales = SaleItem::select(DB::raw('HOUR(sales.sold_at) as hour'), DB::raw('SUM(sale_items.price * sale_items.quantity) as total'))
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->whereBetween('sales.sold_at', [$start, $end])
            ->where('sales.status', 'completed')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        $hourLabels = $hourlySales->pluck('hour')->map(function ($h) {
            return str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
        });
        $hourData = $hourlySales->pluck('total');


        return view('sales.report', [
            'month' => $month,
            'totalRevenue' => $totalRevenue,
            'topProduct' => $topProduct,
            'topDay' => $topDay,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'pieLabels' => $pieLabels,
            'pieData' => $pieData,
            'hourLabels' => $hourLabels,
            'hourData' => $hourData
        ]);
    }

    public function exportPDF(Request $request) {
        $month = $request->input('month', now()->format('Y-m'));
        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $sales = Sale::whereBetween('sold_at', [$start, $end])->get();

        $totalRevenue = $sales->sum(fn($sale) => $sale->price * $sale->quantity);

        $topProduct = Sale::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->whereBetween('sold_at', [$start, $end])
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->with('product')
            ->first();

        $topDay = Sale::select(DB::raw('DATE(sold_at) as day'), DB::raw('SUM(price * quantity) as total'))
            ->whereBetween('sold_at', [$start, $end])
            ->groupBy('day')
            ->orderByDesc('total')
            ->first();

        $pdf = FacadePdf::loadView('sales.report_pdf', [
            'month' => $month,
            'totalRevenue' => $totalRevenue,
            'topProduct' => $topProduct,
            'topDay' => $topDay
        ]);

        return $pdf->download('Monthly_Sales_Report_' . $month . '.pdf');
    }

}
