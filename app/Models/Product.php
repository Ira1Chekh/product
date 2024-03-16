<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'price', 'currency_id'];

    public function currency(): HasOne
    {
        return $this->hasOne(Currency::class);
    }
}
