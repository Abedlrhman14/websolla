<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
      use HasFactory;

    protected $fillable =[
        'name',
        'description',
        'price',
        'image',
    ];

    // the product have many items
    public function orderItem(){
        return $this->hasMany(OrderItem::class);
    }
}
