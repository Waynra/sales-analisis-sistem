<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'date',
        'product_name',
        'quantity',
        'price',
        'ads_cost',
        'affiliate_fee',
        'total',
    ];
}
