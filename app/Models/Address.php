<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['street', 'number', 'district', 'city', 'complement', 'estate', 'cep'];
    // protected $with = ['user'];
    use HasFactory;
    public  function user()
    {
        $this->belongsTo(User::class);
    }
}
