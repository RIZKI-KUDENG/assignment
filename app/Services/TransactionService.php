<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;

use App\Models\Transaction;
use App\Models\TransactionDetail;

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
public function createTransaction($userId, $items){
    $totalQuantity = 0;
    $totalPrice = 0;

    foreach($items as $item){
        $totalQuantity += $item['quantity'];
        $totalPrice += $item['quantity'] * $item['price'];
    }
    if($totalQuantity == 0) return false;

    $transaction = Transaction::create([
        'user_id' => $userId,
        'transaction_date' => now(),
        'total_quantity' => $totalQuantity,
        'total_price'=> $totalPrice
    ]);
    foreach($items as $item){
        if($item['quantity'] > 0){
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['quantity'] * $item['price']
            ]);
        }
    }
}
}
