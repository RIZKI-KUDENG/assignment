<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        Product::factory(10)->create();

        User::factory()->create([
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        Transaction::factory(10)->create()->each(function ($transaction) {
            $details = TransactionDetail::factory(rand(1, 4))->create([
                'transaction_id' => $transaction->id,
            ]);
            $transaction->update([
                'total_quantity' => $details->sum('quantity'),
                'total_price' => $details->sum('subtotal'),
            ]);
        });
     
    }
}
