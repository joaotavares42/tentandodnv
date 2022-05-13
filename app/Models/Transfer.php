<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = ['from_account_id', 'to_account_id', 'description', 'amount'];
    use HasFactory;


    protected function account()
    {
        return $this->belongsTo(Account::class);
    }
}
