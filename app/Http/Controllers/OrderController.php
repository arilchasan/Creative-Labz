<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\Promo;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
                ->addColumn('action', function ($data) {
                    $actionBtn = '<a href="/dashboard/order/detail-' . $data->id . '" class="info btn btn-info btn-sm"><i class="fa-solid fa-circle-info" style="color: #ffffff;"></i></a> <a href="/dashboard/order/cost-' . $data->id . '" class="info btn btn-warning btn-sm"><i class="fa-solid fa-receipt" style="color: #ffffff;"></i> </a> <a onclick="deleteConfirmation(' . $data->id . ')" class="delete btn btn-danger btn-sm"><i class="fas fa-trash" style="color: white;"></i></a>';

                    return $actionBtn;
                })
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
