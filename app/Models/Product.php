<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'image',
        'stock',
        'price'
    ];

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
