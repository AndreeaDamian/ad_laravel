<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_details',
        'comment',
    ];

    protected $dates = ['created_at'];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }

    public function getCreatedAtAttribute($value)
    {
        return (new Carbon($value))->format('d-m-Y H:i:s');
    }
}
