<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected  $table = 'product';

    protected $fillable = [
        'name',
        'information',
        'description',
        'weight',
        'image',
    ];

   // public function nic()
    //{
     //   return $this->belongsTo(Nic::class);
    //}

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function productDetail()
    {
        return $this->hasMany(ProductDetail::class , 'product_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
