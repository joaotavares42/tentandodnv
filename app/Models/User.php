<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'gender', 'document_type', 'document_number', 'birth_date', 'password','telephone'];
    //protected $with = ['account'];

    protected $hidden = ['password'];

    public function account()
    {
        return $this->hasOne(Account::class);

    }
    public function address()
    {
        return $this->hasOne(Address::class);
    }
    public function AauthAccessToken()
    {
        return $this->hasMany(OauthAccessToken::class);
    }


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
