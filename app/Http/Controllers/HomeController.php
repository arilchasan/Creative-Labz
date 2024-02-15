<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Exports\FilterUser;
use Illuminate\Http\Request;
use App\Exports\OrderExports;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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

        $userPerMonth = User::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $allMonths = [];
        $labels = [];
        $data = [];


        $startDate = Carbon::now()->startOfYear();
        for ($i = 0; $i < 12; $i++) {
            $currentMonth = $startDate->copy()->addMonths($i);
            $allMonths[$currentMonth->format('Y-m')] = 0;
            $labels[] = $currentMonth->format('F Y');
        }


        foreach ($userPerMonth as $userData) {
            $allMonths[$userData->month] = $userData->total;
        }


        foreach ($allMonths as $month => $total) {
            $data[] = $total;
        }

        $data = [
            'labels' => $labels,
            'data' => $data,
        ];



        $chartData = [
            'labels' => [],
            'data' => [],
        ];

        for ($month = 1; $month <= 12; $month++) {
            $totalSales = Order::where('status', 'success')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', date('Y'))
                ->count();

            $chartData['labels'][] = $labels[$month - 1];
            $chartData['data'][] = $totalSales;
        }


        $totalIncome = Order::where('status', 'success')->sum('total');

        return view("menu.home", ['admin' => $admin, 'user' => $user, 'contact' => $contact, 'product' => $product, 'data' => $data, 'chartData' => $chartData, 'totalIncome' => $totalIncome]);
    }

    public function filterData(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;


        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;


        $data = [];


        for ($i = 1; $i <= $daysInMonth; $i++) {
            $data[$i] = 0;
        }


        $userPerMonth = User::select(
            DB::raw('DAY(created_at) as day'),
            DB::raw('COUNT(*) as total')
        )
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->groupBy(DB::raw('DAY(created_at)'))
            ->orderBy(DB::raw('DAY(created_at)'), 'asc')
            ->get();


        foreach ($userPerMonth as $userData) {
            $day = $userData->day;
            $data[$day] = $userData->total;
        }


        $labels = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $labels[] = sprintf('%02d', $i) . ' ' . date('F Y', strtotime("$tahun-$bulan"));
        }


        $filteredData = [
            'labels' => $labels,
            'data' => array_values($data),
        ];

        return response()->json($filteredData);
    }
    public function filterDataProduct(Request $request)
    {
        $bulan = $request->bulanProduct;
        $tahun = $request->tahunProduct;

        $daysInMonth = Carbon::create($tahun, $bulan, 1)->daysInMonth;

        $data = [];

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $data[$i] = 0;
        }

        $ordersPerDay = Order::select(
            DB::raw('DAY(created_at) as day'),
            DB::raw('COUNT(*) as total')
        )
            ->where('status', 'success')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->groupBy(DB::raw('DAY(created_at)'))
            ->orderBy(DB::raw('DAY(created_at)'), 'asc')
            ->get();

        foreach ($ordersPerDay as $orderData) {
            $day = $orderData->day;
            $data[$day] = $orderData->total;
        }

        $labels = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $labels[] = sprintf('%02d', $i) . ' ' . Carbon::create($tahun, $bulan, $i)->format('F Y');
        }

        $filteredDataProduct = [
            'labels' => $labels,
            'data' => array_values($data),
        ];

        return response()->json($filteredDataProduct);
    }

    public function downloadExcel(Request $request)
    {
        $filteredData = User::all();



        $dataArray = $filteredData->toArray();


        return Excel::download(new FilterUser($dataArray), 'Data-User.xlsx');
    }
    public function downloadExcelOrder(Request $request)
    {
        $orders = Order::where('status', 'success')
            ->get();

       
        $orders->transform(function ($order) {
            $order->user_id = $order->user->name ?? 'N/A';
            $order->address_id = $order->address->address;

            $order->subtotal = 'Rp ' . number_format($order->subtotal, 0, ',', '.');
            $order->total = 'Rp ' . number_format($order->total, 0, ',', '.');
            return $order;
        });

        $data = $orders->makeHidden(['user', 'address', 'cart_id', 'payment_status', 'created_at', 'updated_at'])->toArray();

        return Excel::download(new OrderExports($data), 'Order-Data.xlsx');
    }
}
