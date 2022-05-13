<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = ['password', 'user_id'];
    //protected $with = ['user' , 'withdraw'];
    protected $hidden = ['password'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->agency_id = 1;
            $model->balance = 10000;
            $model->account_number = rand(1000, 9999);
        });
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function withdraw()
    {
        return $this->hasOne(Withdraw::class);
    }
    public function transfer()
    {
        return $this->hasOne(Transfer::class);
    }
    public function payment()
    {
        return $this->hasOne(Transfer::class);
    }
}
