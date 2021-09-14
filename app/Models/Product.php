<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'image_path',
    ];

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order');
    }

    public static function getProducts($cartIds = null)
    {
        return self::when($cartIds != null, function ($query) use($cartIds) {
            $query->whereNotIn('id', $cartIds);
        })
            ->get();
    }
}
