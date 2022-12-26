<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReplyComment extends Model
{
    use HasFactory, SoftDeletes;
    public $table = "reply_comment";
    
    protected $fillable = [
        'commentId',
        'customerId',
        'content',
        'like',
        'dislike',
    ];
}
