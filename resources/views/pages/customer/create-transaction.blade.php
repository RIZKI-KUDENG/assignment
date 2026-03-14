<?php

use Livewire\Component;
use App\Models\Product;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    public $products;
    public $quantities = []; 

    public function mount()
    {
        $this->products = Product::all();
        
        foreach ($this->products as $product) {
            $this->quantities[$product->id] = 0;
        }
    }

    public function store(TransactionService $transactionService)
    {
        $items = [];

        foreach ($this->products as $product) {
            $qty = (int) ($this->quantities[$product->id] ?? 0);
            
            if ($qty > 0) {
                $items[] = [
                    'id' => $product->id,
                    'quantity' => $qty,
                    'price' => $product->price ?? 0 
                ];
            }
        }

        if (count($items) === 0) {
            session()->flash('error', 'Please select at least one product.');
            return;
        }
        $transactionService->createTransaction(Auth::id(), $items);

        session()->flash('success', 'Transaction created successfully!');
        return redirect()->route('customer.list-transactions');
    }

    public function render()
    {
        return view('pages.customer.create-transaction');
    }
}
?>

<div class="flex">
    <livewire:sidebar />
    <div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Create New Transaction</h2>

    @if (session()->has('error'))
        <div class="bg-red-500 text-white p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">
        <table class="w-full text-left border-collapse" id="transaction-table">
            <thead>
                <tr>
                    <th class="border-b p-2">Nama Produk</th>
                    <th class="border-b p-2">Harga</th>
                    <th class="border-b p-2">Kuantitas</th>
                    <th class="border-b p-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="product-row">
                        <td class="border-b p-2">{{ $product->name }}</td> <td class="border-b p-2 product-price" data-price="{{ $product->price }}">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        
                        <td class="border-b p-2">
                            <input type="number" 
                                   min="0" 
                                   class="qty-input border rounded p-1 w-20"
                                   wire:model="quantities.{{ $product->id }}" 
                                   oninput="calculateTotal()"
                                   value="0">
                        </td>
                        
                        <td class="border-b p-2 product-subtotal font-semibold text-gray-700">Rp 0</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6 flex justify-between items-center">
            <h3 class="text-xl font-bold">Total Harga: <span id="grand-total" class="text-blue-600">Rp 0</span></h3>

            <h3 class="text-xl font-bold">Total Quantity: <span id="grand-qty" class="text-blue-600">0</span></h3>
            
            <button wire:click="store" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Buat Transaksi
            </button>
        </div>
    </div>

    <script>
        function calculateTotal() {
            let grandTotal = 0;
            let grandQty = 0;
            const rows = document.querySelectorAll('.product-row');

            rows.forEach(row => {
                const priceElement = row.querySelector('.product-price');
                const qtyInput = row.querySelector('.qty-input');
                const subtotalElement = row.querySelector('.product-subtotal');

                if(priceElement && qtyInput && subtotalElement) {
                    const price = parseFloat(priceElement.getAttribute('data-price')) || 0;
                    const qty = parseInt(qtyInput.value) || 0;


                    const subtotal = price * qty;
                    

                    subtotalElement.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');


                    grandTotal += subtotal;
                    grandQty += qty;
                }
            });


            document.getElementById('grand-total').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
            document.getElementById('grand-qty').innerText = grandQty;

        }


        document.addEventListener('DOMContentLoaded', function() {
            calculateTotal();
        });
    </script>
</div>
</div>