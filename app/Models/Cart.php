<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_name', 'user_email', 'unique_key' ,'total'];
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'cart_key', 'unique_key');
    }
}
