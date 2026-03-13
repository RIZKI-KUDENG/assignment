<?php

namespace App\Services;

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
}
