<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'product_name',
        'description',
        'quantity',
        'sub_total',
        'tax_amount',
        'total_amount',
        'status',
    ];
}