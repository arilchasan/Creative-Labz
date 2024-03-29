<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Cart::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    $name = $data->product->name;
                    return $name;
                })
                ->addColumn('price', function ($data) {
                    $price = $data->productDetail->where('product_id', $data->product_id)
                        ->where('nic', $data->nic)->first()->price * $data->qty;
                    return $price;
                })
                ->addColumn('nic', function ($data) {
                    $nic = $data->nic;
                    return $nic;
                })
                ->addColumn('qty', function ($data) {
                    $qty = $data->qty;
                    return $qty;
                })
                ->addColumn('action', function ($data) {
                    $actionBtn = '<a href="/dashboard/cart/detail-' . $data->id . '" class="info btn btn-info btn-sm"><i class="fa-solid fa-circle-info" style="color: #ffffff;"></i></a> <a onclick="deleteConfirmation(' . $data->id . ')" class="delete btn btn-danger btn-sm"><i class="fas fa-trash" style="color: white;"></i></a>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('cart.all');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    public function list()
    {
        $carts = Cart::latest()->get();
        $products = Product::all();
        //$productDetails = ProductDetail::all();
        return view('cart.list', compact('carts', 'products'));
    }

    public function addToCart(Request $request, $id)
    {
        try {
            $productDetailId = $request->input('nic');
            $qty = $request->input('qty') ?? 1;

            $productDetail = ProductDetail::where('product_id', $id)->first();

            $stock = ProductDetail::where('nic', $productDetailId)->where('product_id', $id)->first();

            if (!$productDetail) {
                return $this->notFoundResponse([
                    'message' => 'Product detail not found',
                    'error' => 'Product detail not found.'
                ]);
            }

            if ($qty > $productDetail->stock) {
                return $this->notFoundResponse([
                    'message' => 'Not enough stock',
                    'error' => 'Requested quantity exceeds available stock.'
                ]);
            }

            $cart = Cart::create([
                'product_id' => $id,
                'nic' => $productDetailId,
                'qty' => $qty,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            if ($stock) {
                $stock->update([
                    'stock' => $stock->stock - $qty,
                ]);
            }

            if ($request->wantsJson()) {
                return $this->postSuccessResponse('Berhasil ditambahkan ke Keranjang', $cart);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }

        return redirect('/dashboard/cart/all')->with('success', 'Product Berhasil Ditambahkan ke Keranjang');
    }


    public function removeFromCart(Request $request, $id)
    {
        try {
            $cart = Cart::find($id);

            if (!$cart) {
                return $this->notFoundResponse(null);
            }

            $productDetail = ProductDetail::where('nic', $cart->nic)->first();


            if (!$productDetail) {
                return $this->notFoundResponse(null);
            }

            $productDetail->update([
                'stock' => $productDetail->stock + $cart->qty,
            ]);

            $cart->delete();

            if ($request->wantsJson()) {
                return $this->postSuccessResponse('Berhasil menghapus dari Keranjang', $cart);
            }

            return redirect('/dashboard/cart/all')->with('success', 'Product Berhasil Dihapus dari Keranjang');
        } catch (\Exception $e) {
            return redirect('/dashboard/cart/all')->with('error', $e->getMessage());
            if ($request->wantsJson()) {
                return $this->notFoundResponse([
                    'message' => 'Something went wrong',
                    'error' => $e->getMessage()
                ]);
            }
        }
    }


    public function order(Request $request)
    {
        $cartIds = json_decode($request->cart_id);

        if (count($cartIds) > 1) {
            $orders = [];
            $serialNumber = null;

            foreach ($cartIds as $cartId) {
                $cartId = trim($cartId);
                $cart = Cart::find($cartId);

                if (!$cart) {
                    return $this->notFoundResponse([
                        'message' => "Cart with ID $cartId not found",
                        'error' => "Cart with ID $cartId not found."
                    ]);
                }

                $product = Product::find($cart->product_id);
                $subtotal = ProductDetail::where('product_id', $cart->product_id)
                    ->where('nic', $cart->nic)
                    ->first()->price * $cart->qty;
                $total = $subtotal;

                $latestOrder = Order::latest()->first();
                $serialNumber = Carbon::now()->format('His');
                $serialNumber = str_pad($serialNumber, 5, '0', STR_PAD_LEFT);

                $appName = 'CL';
                $transactionCode = $appName . '.' . date('d.m.Y') . '.' . $serialNumber;

                $order = Order::create([
                    'user_id' => Auth::user()->id ?? null,
                    'cart_id' => $cart->id,
                    'subtotal' => $subtotal,
                    'total' => $total,
                    'promo' => 0,
                    'status' => 'pending',
                    'address_id' => null,
                    'payment' => null,
                    'payment_status' => 'pending',
                    'resi' => 0,
                    //'code_transfer' => $transactionCode,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

                if ($order) {
                    $product->update([
                        'stock' => $product->stock - $cart->qty,
                    ]);
                }

                $orders[] = $order;

                $order->update([
                    'code_transfer' => $transactionCode,
                ]);
            }

            if ($request->wantsJson()) {
                return $this->postSuccessResponse('Berhasil menambahkan ke Order', $orders);
            }

            return redirect('/dashboard/order/all')->with('success', 'Order Berhasil Dibuat');
        } else {

            $cartId = trim($cartIds[0]);
            $cart = Cart::find($cartId);

            if (!$cart) {
                return $this->notFoundResponse([
                    'message' => 'Cart not found',
                    'error' => 'Cart not found.'
                ]);
            }

            $product = Product::find($cart->product_id);
            $subtotal = ProductDetail::where('product_id', $cart->product_id)
                ->where('nic', $cart->nic)
                ->first()->price * $cart->qty;
            $total = $subtotal;

            $latestOrder = Order::latest()->first();
            $serialNumber = $latestOrder ? $latestOrder->id + 1 : 1;
            $serialNumber = str_pad($serialNumber, 5, '0', STR_PAD_LEFT); // Ensure 5 digits serial number

            $appName = 'CL';
            $transactionCode = $appName . '.' . date('d.m.Y') . '.' . $serialNumber;
            $order = Order::create([
                'user_id' => Auth::user()->id ?? null,
                'cart_id' => $cart->id,
                'subtotal' => $subtotal,
                'total' => $total,
                'promo' => 0,
                'status' => 'pending',
                'address_id' => null,
                'payment' => null,
                'payment_status' => 'pending',
                'resi' => 0,
                'code_transfer' => $transactionCode,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            if ($order) {
                $product->update([
                    'stock' => $product->stock - $cart->qty,
                ]);
            }

            if ($request->wantsJson()) {
                return $this->postSuccessResponse('Berhasil menambahkan ke Order', [$order]);
            }

            return redirect('/dashboard/order/all')->with('success', 'Order Berhasil Dibuat');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cart = Cart::find($id);
        $info = strip_tags($cart->product->information);
        $desc = strip_tags($cart->product->description);
        $productDetail = ProductDetail::where('nic', $cart->nic)->first();
        $price = $productDetail->where('product_id', $cart->product_id)
            ->where('nic', $cart->nic)->first()->price;
        return view('cart.detail', compact('cart', 'info', 'desc', 'productDetail', 'price'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
