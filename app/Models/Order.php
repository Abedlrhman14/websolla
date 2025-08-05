<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'phone',
        'address',
    ];
    public function items(){
        return $this->hasMany(OrderItem::class);
    }
}
