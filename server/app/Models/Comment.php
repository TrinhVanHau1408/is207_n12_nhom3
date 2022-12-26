<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    public $table = "comment";

    protected $attributes = [
        'like' => 0,
        'dislike' => 0,
    ];

    protected $fillable = [
        'customerId',
        'phoneId',
        'content',
        'like',
        'dislike',
    ];
}
