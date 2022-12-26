<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhoneDetail extends Model
{
   
    use HasFactory, SoftDeletes;
    public $table = "phone_detail";
    protected $fillable = [
        'phoneId',
        'imgUrl',
        'ramId',
        'romId',
        'quantity',
        'colorId',
        'percentPrice',
    ];
}
