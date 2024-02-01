<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model implements AuthAuthenticatable
{
    use HasFactory , AuthenticatableTrait;

    protected $table='admin';
    protected $fillable = ['name','password'];
    protected $hidden = ['created_at', 'updated_at'];

}
