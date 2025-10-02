<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $fillable=[
        'title',
        'description',
        'user_id'
    ];
    function user(){
        return $this->belongsTo(User::class);
    }
}
