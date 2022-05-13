<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Agency extends Model
{
    use HasFactory;

    protected $fillable = ['agency_number'];
    protected $with = ['bank'];


    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->agency_number = rand(1000,1999);
      });
    }


    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
    public function account()
    {
        return $this->hasMany(Account::class);
    }
}
