<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // STATISTIK UTAMA
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalCustomers = Customer::count();
        $totalTransactions = Transaction::count();

        $totalRevenue = Transaction::where('status', 'completed')
            ->sum('total_price');

        $totalStock = Product::sum('stock');

        // PRODUK DENGAN STOK MENIPIS
        $lowStock = Product::with('category')
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->get();

        // TRANSAKSI TERBARU
        $recentTransactions = Transaction::with([
            'customer',
            'product'
        ])
            ->latest()
            ->take(5)
            ->get();

        // GRAFIK PENJUALAN BULANAN
        $salesData = Transaction::select(
                DB::raw('MONTH(transaction_date) as month'),
                DB::raw('SUM(total_price) as total')
            )
            ->where('status', 'completed')
            ->whereYear('transaction_date', now()->year)
            ->groupBy(DB::raw('MONTH(transaction_date)'))
            ->orderBy('month')
            ->pluck('total', 'month');

        $salesLabels = [
            'Jan', 'Feb', 'Mar', 'Apr',
            'Mei', 'Jun', 'Jul', 'Agu',
            'Sep', 'Okt', 'Nov', 'Des'
        ];

        $salesChart = [];

        for ($i = 1; $i <= 12; $i++) {
            $salesChart[] = (float) ($salesData[$i] ?? 0);
        }

        // DONUT CHART PRODUK BERDASARKAN OPERATOR
        $categoryData = Category::withCount('products')->get();

        $categoryLabels = $categoryData->pluck('name');

        $categoryCounts = $categoryData->pluck('products_count');

        // GRAFIK JUMLAH TRANSAKSI SETIAP OPERATOR PER BULAN
        $operatorMonthlyRows = DB::table('transactions as t')
            ->join('products as p', 't.product_id', '=', 'p.id')
            ->join('categories as c', 'p.category_id', '=', 'c.id')
            ->select(
                'c.id as category_id',
                'c.name as operator',
                DB::raw('MONTH(t.transaction_date) as month'),
                DB::raw('COUNT(t.id) as total')
            )
            ->where('t.status', 'completed')
            ->whereYear('t.transaction_date', now()->year)
            ->groupBy(
                'c.id',
                'c.name',
                DB::raw('MONTH(t.transaction_date)')
            )
            ->get();

        // Mengelompokkan data berdasarkan kategori dan bulan
        $operatorMonthlyLookup = $operatorMonthlyRows->keyBy(
            fn($row) => $row->category_id . '-' . $row->month
        );

        $operatorMonthlyDatasets = [];

        foreach ($categoryData as $category) {

            $monthlyValues = [];

            for ($month = 1; $month <= 12; $month++) {

                $key = $category->id . '-' . $month;

                $monthlyValues[] = (int) (
                    $operatorMonthlyLookup->get($key)->total ?? 0
                );
            }

            $operatorMonthlyDatasets[] = [
                'label' => $category->name,
                'data' => $monthlyValues
            ];
        }

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalCustomers',
            'totalTransactions',
            'totalRevenue',
            'totalStock',
            'lowStock',
            'recentTransactions',
            'salesLabels',
            'salesChart',
            'categoryLabels',
            'categoryCounts',
            'operatorMonthlyDatasets'
        ));
    }
}
