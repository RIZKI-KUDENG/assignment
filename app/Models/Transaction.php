<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        "user_id",
        "total_quantity",
        "total_price",
        "transaction_date"
    ];
}
