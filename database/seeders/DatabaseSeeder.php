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
    User::factory(10)->create([
        'role' => 'customer'
    ]);

    Product::factory(15)->create();

    User::factory()->create([
        'username' => 'admin',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);

    User::where('role', 'customer')->get()->each(function ($user) {

        Transaction::factory(15)->create([
            'user_id' => $user->id
        ])->each(function ($transaction) {

            $details = TransactionDetail::factory(rand(1, 4))->create([
                'transaction_id' => $transaction->id,
            ]);

            $transaction->update([
                'total_quantity' => $details->sum('quantity'),
                'total_price' => $details->sum('subtotal'),
            ]);

        });

    });
}
}
