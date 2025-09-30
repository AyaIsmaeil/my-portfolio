<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'sender_name', 'sender_email', 'subject', 'message', 'status', 'user_id',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
