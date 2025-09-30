<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    protected $fillable=[
        'title',
        'description',
        'image',
        'url',
        'category_id',
        'user_id'
    ];
    function user(){
        return $this->belongsTo(User::class);
    }
    function category(){
        return $this->belongsTo(Category::class);
    }
}
