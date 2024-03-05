<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class NicController extends Controller
{
    public function getNicStock($id)
    {
        $product = Product::find($id);
        $productDetail = ProductDetail::where('product_id', $id)->get();
        return response()->json([
            //'product' => $product,
            'productDetail' => $productDetail
        ]);
    }
}
