<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;

use App\Models\Transaction;

class TransactionService
{
    public function getPaginated($search, $sort)
    {
        return Transaction::query()
            ->when($search, function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where('username', 'like', "%$search%");
                });
            })
            ->orderBy('transaction_date', $sort)
            ->paginate(10);
    }
   public function getPaginatedCustomer($search, $sort)
{
    return Transaction::query()
        ->where('user_id', Auth::user()->id) 
        ->when($search, fn($q) => $q->where('total_quantity', 'like', "%$search%"))
        ->orderBy('transaction_date', $sort)
        ->paginate(10);
}
}
