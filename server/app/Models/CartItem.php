<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use HasFactory, SoftDeletes;
    
    public $table = "cart_item";

    protected $fillable = [
        'customerId',
        'phoneName',
        'imgUrl',
        'phoneDetailId',
        'quantity',
        'priceSale',
        'totalMoney',
    ];
}
