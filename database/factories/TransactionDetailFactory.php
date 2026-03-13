<?php

namespace Database\Factories;

use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TransactionDetail>
 */
class TransactionDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();
        $quantity = fake()->numberBetween(1, 10);
        return [
            'transaction_id' => Transaction::inRandomOrder()->first()->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'subtotal' => $product->price * $quantity
        ];
    }
}
