<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nic extends Model
{
    use HasFactory;

    protected $table = 'nic';

    protected $fillable = [
        'nic',
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
