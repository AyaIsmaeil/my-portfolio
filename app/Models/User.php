<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Home;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasApiTokens,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'job',
        'phone',
        'profile_image',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    function about(){
        return $this->hasOne(About::class);
    }
    function experiences(){
        return $this->hasMany(Experience::class);
    }
    function educations(){
        return $this->hasMany(Education::class);
    }
    function projects(){
        return $this->hasMany(Project::class);
    }
    function testimonials(){
        return $this->hasMany(Testimonial::class);
    }
    function contacts(){
        return $this->hasMany(Contact::class);
    }
    function services(){
        return $this->hasMany(Service::class);
    }
}
