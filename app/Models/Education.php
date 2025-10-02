<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Education extends Model
{
    use SoftDeletes;
    protected $table='education';
    protected $fillable = [
        'degree',
        'institution',
        'start_date',
        'end_date',
        'user_id',
    ];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
