<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected  $table = 'order';

    protected $fillable = [
        'user_id',
        'cart_id',
        'subtotal',
        'total',
        'promo',
        'status',
        'address_id',
        'payment',
        'payment_status',
        'resi',
        'code_transfer',
        'transfer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }
}
