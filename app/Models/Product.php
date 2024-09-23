<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'Product';
    protected $fillable = ['name','description','price','created_at','updated_at','available','category','image'];
}
