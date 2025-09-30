<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class About extends Model
{
    use SoftDeletes;
    protected $fillable=[
        'title',
        'subtitle',
        'description',
        'cv',
        'image',
        'linkedin',
        'github',
        'facebook',
        'instagram',
        'user_id'
    ];
    function user(){
        return $this->belongsTo(User::class);
    }
}
