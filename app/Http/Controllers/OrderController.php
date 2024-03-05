<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $query = Order::query();


            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            }


            $data = $query->with(['cart.product', 'user'])
                ->get()
                ->groupBy('code_transfer');


            $dataTableData = collect();

            foreach ($data as $codeTransfer => $orders) {

                $products = $orders->map(function ($order) {
                    return [
                        'name' => $order->cart->product->name,
                        'total' => $order->cart->qty * $order->cart->productDetail->where('product_id', $order->cart->product_id)->where('nic', $order->cart->nic)->first()->price,
                    ];
                });


                $username = $orders->first()->user ? $orders->first()->user->name : 'Not Registered';


                $total = $products->sum('total');


                $dataTableData->push([
                    'code_transfer' => $codeTransfer,
                    'username' => $username,
                    'total' => $total,
                    'created_at' => Carbon::parse($orders->first()->created_at)->translatedFormat('d F Y H:i'),
                    'payment_status' => $orders->first()->payment_status,
                    'action' => '<a href="/dashboard/order/detail-product-' . $orders->first()->code_transfer . '" class="info btn btn-info btn-sm"><i class="fa-solid fa-circle-info" style="color: #ffffff;"></i></a> <a onclick="deleteConfirmation(' . $orders->first()->id . ')" class="delete btn btn-danger btn-sm"><i class="fas fa-trash" style="color: white;"></i></a>',
                    //<a href="/dashboard/order/detail-' . $orders->first()->id . '" class="success btn btn-success btn-sm"><i class="fa-solid fa-bag-shopping" style="color: #ffffff;"></i></a> <a href="/dashboard/order/cost-' . $orders->first()->id . '" class="info btn btn-warning btn-sm"><i class="fa-solid fa-receipt" style="color: #ffffff;"></i> </a>
                ]);
            }

            return DataTables::of($dataTableData)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('order.all');
    }



    public function reqOrder()
    {
        if (request()->ajax()) {
            $data = Order::latest()->get();
            return DataTables::of($data)
                ->addColumn('name', function ($data) {
                    $name = $data->cart->product->name;
                    return $name;
                })
                ->addColumn('username', function ($data) {
                    $username = $data->user->name ?? 'Not Registered';
                    return $username;
                })
                ->addColumn('qty', function ($data) {
                    $qty = $data->cart->qty;
                    return $qty;
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    if ($data->payment_status == 'success') {
                        $actionBtn = '<a href="/dashboard/order/success-detail-' . $data->id . '" class="info btn btn-primary btn-sm"><i class="fa-solid fa-circle-info" style="color: #ffffff;"></i></a> <a href="/dashboard/order/resi-' . $data->id . '" class="edit btn btn-secondary btn-sm"><i class="fas fa-pen" style="color: #ffffff;"></i></a>';
                    } else if ($data->payment_status == 'failed') {
                        $actionBtn = '<a href="/dashboard/order/failed-detail-' . $data->id . '" class="info btn btn-primary btn-sm"><i class="fa-solid fa-circle-info" style="color: #ffffff;"></i></a>';
                    } else {
                        $actionBtn = '
                        <form action="/dashboard/order/accept-order-' . $data->id . '" method="post" style="display: inline;">' . csrf_field() .
                            '<button type="submit" class="info btn btn-success btn-sm mr-2" style="background-color: #198754;">' .
                            '<i class="fa-solid fa-check" style="color: #ffffff;"></i>' .
                            '</button>' .
                            '</form>' .
                            '<form action="/dashboard/order/reject-order-' . $data->id . '" method="post" style="display: inline;">' .
                            csrf_field() .
                            '<button type="submit" class="delete btn btn-danger btn-sm" style="background-color: #dc3545;">' .
                            '<i class="fa-solid fa-x" style="color: white;"></i>' .
                            '</button>' .
                            '</form>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('order.orderreq');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function resi($id)
    {
        $order = Order::find($id);
        $cart = Cart::where('id', $order->cart_id)->first();
        $address = Address::where('id', $order->address_id)->first();
        $productDetail = ProductDetail::where('nic', $cart->nic)->first();
        $randomNumber = mt_rand(10, 999999999999);
        return view('order.resi', compact('order', 'cart', 'address', 'productDetail', 'randomNumber'));
    }

    public function updateResi(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $cart = Cart::where('id', $order->cart_id)->first();
        $address = Address::where('id', $order->address_id)->first();
        $productDetail = ProductDetail::where('nic', $cart->nic)->first();
        $randomNumber = mt_rand(10, 999999999999);

        $request->validate([
            'resi' => 'required',
        ]);

        $order->update([
            'resi' => $request->resi
        ]);

        return redirect()->route('order.reqOrder')->with('success', 'Berhasil mengubah resi!');
    }

    public function exportPdf()
    {
        $orders = Order::where('status', 'success')->get();


        $groupedOrders = $orders->groupBy('code_transfer');


        $pdfData = [];

        foreach ($groupedOrders as $codeTransfer => $orders) {
            $customerName = $orders->first()->user->name ?? ($orders->first()->address->fullname ?? 'Not Registered');
            $productNames = $orders->pluck('cart.product.name')->implode(', ');
            $quantities = $orders->pluck('cart.qty')->implode(', ');
            $totalPrices = $orders->sum('total');

            $pdfData[] = [
                'code_transfer' => $codeTransfer,
                'customer' => $customerName,
                'product' => $productNames,
                'qty' => $quantities,
                'total' => $totalPrices,
            ];
        }


        $view = View::make('order.PDF', compact('pdfData'));
        $html = $view->render();

        $dompdf = new Dompdf();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isPhpEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream('Daftar-Order.pdf');
    }


    public function detailFailed($id)
    {
        $order = Order::find($id);
        return view('transfer.detailfailed', compact('order'));
    }

    public function detailSuccess($id)
    {
        $order = Order::find($id);
        return view('transfer.detailSuccess', compact('order'));
    }
    public function pendingPayment($id, Request $request)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'transfer' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($request->hasFile('transfer')) {
            $image = $request->file('transfer');
            $image->move(public_path('/assets/transfer'), $image->getClientOriginalName());
        }
        $order->update([
            'transfer' => $image->getClientOriginalName(),
            'payment_status' => 'pending',
            'status' => 'pending',
        ]);

        return redirect()->route('order.reqOrder')->with('success', 'Berhasil mengupload ulang bukti pembayaran!');
    }


    public function detailProduct($code_transfer)
    {
        $orders = Order::where('code_transfer', $code_transfer)->get();
        $orderDetails = [];
        $totalSubtotal = 0;
        $totalPromo = 0;
        $totalAll = 0;

        foreach ($orders as $order) {
            $date = Carbon::parse($order->created_at)->translatedFormat('d F Y H:i');
            $price = ProductDetail::where('product_id', $order->cart->product_id)
                ->where('nic', $order->cart->nic)->first()->price;

            $subtotal = $price * $order->cart->qty;
            $totalSubtotal += $subtotal;

            $totalPromo += (int) $order->promo;

            $totalAll = $totalSubtotal - $totalPromo;

            $orderDetails[] = [
                'order' => $order,
                'date' => $date,
                'price' => $price,
                'subtotal' => $subtotal,
            ];
        }

        return view('order.detailproduct', compact('orderDetails', 'orders' , 'totalSubtotal', 'totalPromo', 'totalAll'));
        //return response()->json($orderDetails);
    }


    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);
        $order->status = $request->status;
        $order->payment_status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Berhasil mengubah status!');
    }

    public function accPayment($id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'payment_status' => 'success',
            'status' => 'success',
        ]);

        return redirect()->back()->with('success', 'Berhasil menyetujui pembayaran!');
    }

    public function rejectPayment($id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'payment_status' => 'failed',
            'status' => 'failed',
            'transfer' => null,
        ]);

        return redirect()->back()->with('success', 'Berhasil menolak pembayaran!');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    public function cost(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $cart = Cart::where('id', $order->cart_id)->first();
        $address = Address::where('id', $order->address_id)->first();

        //  $name = session('name');
        // $costs = session('costs');

        return view('order.cost', compact('order', 'cart', 'address'));
    }

    public function postCost(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);

            $response = Http::post("https://pro.rajaongkir.com/api/cost", [
                'key'           => 'd9cc3e0463ce8ea9546ea9b012d7aba6',
                'originType'    => 'city',
                'destinationType' => 'city',
                'origin'        => $request->origin,
                'destination'   => $request->destination,
                'weight'        => $request->weight,
                'courier'       => $request->courier,
            ]);

            $response = json_decode($response->body(), true);

            if (isset($response['rajaongkir']['results'])) {
                $results = $response['rajaongkir']['results'];
                $allCosts = [];

                foreach ($results as $result) {
                    $name = $result['name'];
                    $costs = [];

                    foreach ($result['costs'] as $cost) {
                        $description = $cost['description'];
                        $value = $cost['cost'][0]['value'];

                        $costs[] = [
                            'description' => $description,
                            'value' => $value,
                            'etd' => $cost['cost'][0]['etd'],
                            'note' => $cost['cost'][0]['note'],
                        ];
                    }

                    $allCosts[] = [
                        'name' => $name,
                        'costs' => $costs,
                    ];
                }

                $cart = Cart::where('id', $order->cart_id)->first();
                $address = Address::where('id', $order->address_id)->first();


                if ($request->wantsJson()) {
                    return $this->postSuccessResponse('Berhasil mengambil data ongkos kirim!', [
                        'allCosts' => $allCosts,
                        'order' => $order,
                        'address' => $address,
                    ]);
                }


                return redirect()->back()->with('success', [
                    'order' => $order,
                    'allCosts' => json_encode($allCosts),
                    'cart' => $cart,
                    'address' => $address,
                ]);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show($id)
    {
        $order = Order::find($id);
        $price = ProductDetail::where('nic', $order->cart->nic)->first();
        $total = $price->price * $order->cart->qty - $order->promo;
        return view('order.detail', compact('order', 'total', 'price'));
    }
    public function filterByDate(Request $request)
    {

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');


        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date = date('Y-m-d', strtotime($end_date));


        $orders = Order::with('user', 'cart')->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->get();

        return response()->json($orders);
    }


    public function updateCart(Request $request, $id)
    {
        try {
            $request->validate([
                'qty' => 'required|integer|min:0',
                'coupon' => 'nullable|string',
            ]);

            $order = Order::find($id);
            if (!$order) {
                if ($request->wantsJson()) {
                    return $this->notFoundResponse(null);
                }
            }

            $cart = Cart::where('id', $order->cart_id)->first();
            $coupon = Promo::where('code', $request->coupon)->first();
            $oldQty = $cart->qty;
            $cart->update([
                'qty' => $request->qty,
            ]);

            $productDetail = ProductDetail::where('nic', $cart->nic)->first();

            $productDetail->update([
                'stock' => $productDetail->stock + $oldQty - $request->input('qty'),
            ]);


            $order->update([
                'promo' => $coupon->discount ?? 0,
                'subtotal' => $productDetail->price * $cart->qty,
                'total' => $order->subtotal - ($coupon->discount ?? 0),
            ]);

            if ($coupon) {
                $order->update([
                    'promo' => $coupon->discount ?? 0,
                    'subtotal' => $productDetail->price * $cart->qty,
                    'total' => $order->subtotal - $coupon->discount ?? 0,
                ]);

                $message = 'Berhasil! Kuantitas diubah dan diskon berhasil ditetapkan.';
            } else {
                // Jika kupon tidak diupdate
                $order->update([
                    'subtotal' => $productDetail->price * $cart->qty,
                    'total' => $order->subtotal,
                ]);

                $message = 'Berhasil! Kuantitas diubah.';
            }

            if ($request->wantsJson()) {
                return $this->postSuccessResponse($message, [
                    'order' => $order,
                    'qty' => $cart->qty,
                ]);
            }
            return redirect()->back()->with('success', 'Berhasil mengubah jumlah produk!');
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return $this->failedResponse($th->getMessage());
            }
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function uploadTransfer($id, Request $request)
    {
        $order = Order::find($id);
        $request->validate([
            'transfer' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($request->hasFile('transfer')) {
            $image = $request->file('transfer');
            $image->move(public_path('/assets/transfer'), $image->getClientOriginalName());
        }
        $order->update([
            'transfer' => $image->getClientOriginalName(),
        ]);

        return redirect()->route('order.reqOrder')->with('success', 'Berhasil mengupload bukti transfer!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function payment(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $cart = Cart::where('id', $order->cart_id)->first();
        $address = Address::where('id', $order->address_id)->first();
        $productDetail = ProductDetail::where('nic', $cart->nic)->first();
        $numeric = rand(100, 999);
        return view('order.payment', compact('order', 'cart', 'address', 'productDetail', 'numeric'));
    }

    public function updatePayment(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $cart = Cart::where('id', $order->cart_id)->first();
        $address = Address::where('id', $order->address_id)->first();
        $productDetail = ProductDetail::where('nic', $cart->nic)->first();
        $numeric = rand(100, 999);

        $request->validate([
            'payment' => 'required',
        ]);

        $order->update([
            'payment' => $request->payment
        ]);

        return redirect()->back()->with('success', 'Berhasil mengubah pembayaran!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            if ($request->wantsJson()) {
                return $this->notFoundResponse(null);
            }
        }
        $order->delete();

        if ($request->wantsJson()) {
            return $this->postSuccessResponse('Berhasil menghapus data order!', $order);
        }

        return redirect()->route('order.all')->with('success', 'Berhasil menghapus data order!');
    }
}
