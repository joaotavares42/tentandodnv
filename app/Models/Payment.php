<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['amount, account_id', 'payment_number'];
    use HasFactory;


    protected function account()
    {
        return $this->belongsTo(Account::class);
    }
}

