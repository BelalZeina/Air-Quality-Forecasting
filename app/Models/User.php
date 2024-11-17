<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mobile',
        'password',
        'img',
        'is_active',
        'code_verified',
        'expire_at',
        'job',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function generate_code()
    {
        $this->timestamps =false;
        // $this->code_verified=rand(100000,999999);
        $this->code_verified=123456;
        $this->expire_at=now()->addMinutes(15);
        $this->save();
    }
    public function rest_code()
    {
        $this->timestamps =false;
        $this->code_verified=null;
        $this->expire_at=null;
        $this->save();
    }




}
