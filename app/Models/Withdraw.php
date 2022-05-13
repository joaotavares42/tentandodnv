<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $table = 'withdrawals';
    //protected $with = ['account'];
    protected $fillable = ['amount'];
    use HasFactory;
    protected function account()
    {
        return $this->belongsTo(Account::class);
    }
}
