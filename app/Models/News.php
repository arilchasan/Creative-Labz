<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected  $table = 'news';
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'thumbnail',
        'author',
        'created_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
