<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view("layouts.app");
    }

    public function home()
    {
        $admin = Admin::count();
        $contact = Contact::count();
        $product = Product::count();
        $user = User::count();

        $userPerMonth = User::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->get();


        $allMonths = collect([]);
        $labels = [];
        $data = [];

        for ($i = 1; $i >= 0; $i--) {
            $allMonths->push(Carbon::now()->subMonths($i)->format('Y-m'));
        }


        foreach ($allMonths as $month) {
            $foundData = $userPerMonth->where('month', $month)->first();


            $formattedDate = Carbon::createFromFormat('Y-m', $month)->format('F Y');


            $labels[] = $formattedDate;
            $data[] = $foundData ? $foundData->total : 0;
        }
        $data = [
            'labels' => $labels,
            'data' => $data,
        ];

        $order = Order::where('status', 'success')->get();
        $totalSales = $order->count();

        $chartData = [
            'labels' => ['Total Penjualan'],
            'data' => [$totalSales],
        ];


        $totalIncome = Order::where('status', 'success')->sum('total');

        return view("menu.home", ['admin' => $admin, 'user' => $user, 'contact' => $contact, 'product' => $product, 'data' => $data, 'chartData' => $chartData , 'totalIncome' => $totalIncome]);
    }
}
