<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // دالة آمنة بترجع 0 لو الجدول ما موجود - دي الأساس لي قدام
    private function safeCount($table, $model = null){
        try {
            if(!Schema::hasTable($table)) return 0;
            if($model) return $model::count();
            return DB::table($table)->count();
        } catch(\Exception $e){ return 0; }
    }
    private function safeSum($table, $column, $model = null){
        try {
            if(!Schema::hasTable($table)) return 0;
            if($model) return $model::sum($column);
            return DB::table($table)->sum($column);
        } catch(\Exception $e){ return 0; }
    }

    public function index(){
        $stats = [
            'products'    => $this->safeCount('products', \App\Models\Product::class),
            'customers'   => $this->safeCount('customers', \App\Models\Customer::class),
            'invoices'    => $this->safeCount('invoices', \App\Models\Invoice::class),
            'employees'   => $this->safeCount('employees'),
            'sales_all'   => $this->safeSum('invoices', 'total', \App\Models\Invoice::class),
            'sales_today' => 0, // بنفعله لما نضيف تاريخ للفاتورة
            'treasury'    => $this->safeSum('treasuries', 'balance'),
            'stock_value' => $this->safeSum('products', DB::raw('price * quantity')),
        ];

        $lowStock = $this->safeCount('products') ? \App\Models\Product::where('quantity','<',5)->take(5)->get() : collect();
        $latestInvoices = $this->safeCount('invoices') ? \App\Models\Invoice::latest()->take(5)->get() : collect();
        $latestProducts = $this->safeCount('products') ? \App\Models\Product::latest()->take(5)->get() : collect();

        return view('dashboard', [
            'stats' => $stats,
            'low' => $lowStock,
            'lowStock' => $lowStock,
            'latestInvoices' => $latestInvoices,
            'latestProducts' => $latestProducts
        ]);
    }
}
