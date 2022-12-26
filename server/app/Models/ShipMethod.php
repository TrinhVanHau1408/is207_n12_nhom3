<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipMethod extends Model
{
    use HasFactory, SoftDeletes;
    public $table = "ship_method";

    protected $fillable = [
        'name',
        'feePrice',
        'deliveryTime',
    ];
}
