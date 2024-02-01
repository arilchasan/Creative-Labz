<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = "address";

    protected $fillable = [
        'user_id',
        'address',
        'province',
        'city',
        'subdistrict',
        'zip_code',
        'phone',
        'fullname',
        'full_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'address_id');
    }

    
}
