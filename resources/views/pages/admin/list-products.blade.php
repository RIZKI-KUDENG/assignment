<?php
use Livewire\Component;
use App\Services\ProductService;

new class extends Component
{
   public $products = [];

   public function mount(ProductService $productService){
       $this->products = $productService->getAll();
   }
};
?>

<div class="flex">
    <livewire:sidebar />

    <div class="flex-1 p-6">
        <h1 class="text-2xl font-bold mb-4">Halaman List Produk</h1>

        <table class="w-full border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border">ID</th>
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">Harga</th>
                </tr>
            </thead>

            <tbody>
                @foreach($products as $product)
                <tr>
                    <td class="p-2 border tetx">{{ $product->id }}</td>
                    <td class="p-2 border">{{ $product->name }}</td>
                    <td class="p-2 border">{{ $product->price }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>