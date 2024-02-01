<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';
    protected $fillable = ['product_id', 'nic', 'qty'];

    public function product()
    {
        return $this->belongsTo(Product::class , 'product_id');
    }

    public function nic()
    {
        return $this->belongsTo(Cart::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class , 'product_id', 'product_id');
    }
}
