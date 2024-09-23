<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'present_address',
        'permanent_address',
        'payment_method',
        'transaction_id',
        'transaction_date',
        'cart_key',
        'is_accept',
    ];

    protected $dates = ['transaction_date'];
}
