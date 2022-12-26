<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddressReceive extends Model
{
    use HasFactory, SoftDeletes;
    
    public $table = "address_receive";

    protected $fillable = [
        'customerId',
        'nameReceiver',
        'numberPhoneReceiver',
        'addressReceiver',
        'numberApartment',
        'defaultAddress',
    ];
}
