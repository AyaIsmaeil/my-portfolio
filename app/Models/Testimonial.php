<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable=[
        'name',
        'job',
        'message',
        'image',
        'rating',
        'user_id'

    ];
    function user(){
        return $this->belongsTo(User::class);
    }
}
