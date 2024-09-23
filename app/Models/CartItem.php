<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_key', 'product_id', 'quantity' , 'name'];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_key', 'unique_key');
    }
}
