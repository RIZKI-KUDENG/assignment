<?php
use Livewire\Component;
use App\Services\ProductService;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    public function render(ProductService $productService){
        return view('pages.admin.list-products', [
            'products' => $productService->getPaginated()
        ]);
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
                    <th class="p-2 border">No</th>
                    <th class="p-2 border">Nama Produk</th>
                    <th class="p-2 border">Harga</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($products as $index => $product)
                <tr>

                    <td class="p-2 border">
                        {{ $products->firstItem() + $index }}
                    </td>

                    <td class="p-2 border">
                        {{ $product->name }}
                    </td>

                    <td class="p-2 border">
                        Rp {{ number_format($product->price,0,',','.') }}
                    </td>

                    <td class="p-2 border flex gap-2">

                        <button class="bg-blue-500 text-white px-3 py-1 rounded">
                            Update
                        </button>

                        <button
                            wire:click="delete({{ $product->id }})"
                            class="bg-red-500 text-white px-3 py-1 rounded"
                        >
                            Delete
                        </button>

                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>

        <div class="mt-4">
            {{ $products->links() }}
        </div>

    </div>

</div>
