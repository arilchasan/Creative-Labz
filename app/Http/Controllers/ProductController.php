<?php

namespace App\Http\Controllers;

use App\Models\Nic;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Product::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    $image = asset('assets/product/' . $data->images[0]->image);
                    return $image;
                })
                ->addColumn('action', function ($data) {
                    $actionBtn = '<a href="/dashboard/product/detail-' .  $data->name . '" class="info btn btn-info btn-sm"><i class="fa-solid fa-circle-info" style="color: #ffffff;"></i></a> <a href="/dashboard/product/edit-' .  $data->name . '" class="edit btn btn-secondary btn-sm"><i class="fas fa-pen"></i></a> <a class="delete btn btn-danger btn-sm" onclick="deleteConfirmation(' . $data->id . ')"><i class="fas fa-trash" style="color: white;"></i></a>' . '<a href="/dashboard/product/cart-' .  $data->name . '" class="cart btn btn-primary btn-sm"><i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i></a> .'
                        //'<form method="post" action="/dashboard/cart/add/' .  $data->id . '" style="display:inline;">' .
                        //csrf_field() .
                        //'<button type="submit" class="info btn btn-link btn-sm" style="border: none; background-color: inherit; cursor: pointer;">Add to Cart</button>' .
                        //'</form>'
                    ;

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('product.all');
    }

    public function all()
    {
        $product = Product::with('productDetail')->get();
        if ($product->isEmpty()) {
            return $this->notFoundResponse(null);
        }
        return $this->getSuccessResponse($product);
    }

    public function detail($name)
    {
        $product = Product::with('productDetail')->where('name', $name)->first();
        if (!$product) {
            return $this->notFoundResponse(null);
        }
        return $this->getSuccessResponse($product);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nic = Nic::all();
        return view('product.create', ['nic' => $nic]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'information' => 'required',
                'description' => 'required',
                'weight' => 'required',
                'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $imagePaths = [];

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $imageName = Str::random(5) . '-' . $image->getClientOriginalName();
                    $image->move(public_path('/assets/product'), $imageName);

                    $imagePaths[] = ['image' => $imageName];
                }
            }

            $product = Product::create([
                'name' => $request->name,
                'information' => $request->information,
                'description' => $request->description,
                'weight' => $request->weight,
            ]);

            $product->images()->createMany($imagePaths);

            $data2 = [];

            if (count($request->stock) > 0) {
                foreach ($request->stock as $item => $v) {
                    $price = isset($request->price[$item]) ? $request->price[$item] : null;
                    $nicId = isset($request->nic[$item]) ? $request->nic[$item] : null;
                    $stock = isset($request->stock[$item]) ? $request->stock[$item] : null;


                    $nicId = is_array($nicId) ? $nicId : [$nicId];
                    $price = is_array($price) ? $price : [$price];
                    $stock = is_array($stock) ? $stock : [$stock];


                    if ($price[0] !== null) {
                        $data2[] = [
                            'product_id' => $product->id,
                            'nic' => $nicId[0],
                            'price' => $price[0],
                            'stock' => $stock[0],
                        ];
                    }
                }
                if (!empty($data2)) {
                    ProductDetail::insert($data2);
                }
            }
            //dd($data2);
            return redirect()->route('product.all')->with('success', 'Product Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::where('name', $id)->first();
        $info = strip_tags($product->information);
        $desc = strip_tags($product->description);
        $productDetails = ProductDetail::where('product_id', $product->id)->get();
        return view('product.detail', compact('product', 'info', 'desc', 'productDetails'));
    }

    public function cart($id)
    {
        $product = Product::where('name', $id)->first();
        $info = strip_tags($product->information);
        $desc = strip_tags($product->description);
        $productDetails = ProductDetail::where('product_id', $product->id)->get();
        return view('product.cart', compact('product', 'info', 'desc', 'productDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::where('name', $id)->first();
        $info = strip_tags($product->information);
        $desc = strip_tags($product->description);
        $productDetails = ProductDetail::where('product_id', $product->id)->get();
        $nic = Nic::all();
        return view('product.edit', compact('product', 'info', 'desc', 'productDetails', 'nic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'price' => 'required',
                'information' => 'required',
                'description' => 'required',
                'weight' => 'required',
                'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                'nic' => 'required',
                'stock' => 'required',
            ]);

            $product = Product::where('name', $id)->first();
            $imagePaths = [];

            if ($request->hasFile('image')) {
                foreach ($product->images as $oldImage) {
                    $oldImagePath = public_path('assets/product/' . $oldImage->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                    $oldImage->delete();
                }



                foreach ($request->file('image') as $image) {
                    $imageName = Str::random(5) . '-' . $image->getClientOriginalName();
                    $image->move(public_path('/assets/product'), $imageName);

                    $imagePaths[] = ['image' => $imageName];
                }
            }


            $product->update([
                'name' => $request->name,
                'information' => $request->information,
                'description' => $request->description,
                'weight' => $request->weight,
            ]);

            
            $product->images()->createMany($imagePaths);

            $data2 = [];
            foreach ($request->nic as $key => $nicId) {
                $price = $request->price[$key] ?? null;
                $stock = $request->stock[$key] ?? null;

                if ($price !== null) {
                    $data2[] = [
                        'product_id' => $product->id,
                        'nic' => $nicId,
                        'price' => $price,
                        'stock' => $stock,
                    ];
                }
            }

            if (!empty($data2)) {
                ProductDetail::where('product_id', $product->id)->delete();
                ProductDetail::insert($data2);
            }

            return redirect()->route('product.all')->with('success', 'Product Berhasil Diubah');
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $oldImageName = $product->image;
        $oldImagePath = public_path('/assets/product') . '/' . $oldImageName;
        if (File::exists($oldImagePath)) {
            File::delete($oldImagePath);
        }
        $product->delete();
        return redirect()->route('product.all')->with('success', 'Product Berhasil Dihapus');
    }
}
