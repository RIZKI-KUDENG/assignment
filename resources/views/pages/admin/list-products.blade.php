<?php
use Livewire\Component;
use App\Services\ProductService;
use Livewire\WithPagination;
use App\Models\Product;

new class extends Component {
    use WithPagination;
    public $search = '';
    public $sort = 'asc';

    public $showModal = false;

    public $editId;
    public $name;
    public $price;

    protected $queryString = ['search', 'sort'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render(ProductService $productService)
    {
        return view('pages.admin.list-products', [
            'products' => $productService->getPaginated($this->search, $this->sort),
        ]);
    }
    public function delete($id, ProductService $service)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $service->delete($id);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $this->editId = $product->id;
        $this->name = $product->name;
        $this->price = $product->price;

        $this->showModal = true;
    }

    public function update(ProductService $service)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        $service->update($this->editId, [
            'name' => $this->name,
            'price' => $this->price,
        ]);

        $this->showModal = false;
    }
};
?>

<div class="flex">

    <livewire:sidebar />

    <div class="flex-1 p-6">

        <h1 class="text-2xl font-bold mb-4">Halaman List Produk</h1>
        <div class="flex justify-between mb-4">

            <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search produk..."
                class="border px-3 py-2 rounded w-64">

            <select wire:model.live="sort" class="border px-3 py-2 rounded">

                <option value="asc">
                    Harga Termurah
                </option>

                <option value="desc">
                    Harga Termahal
                </option>

            </select>

        </div>
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
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>

                        <td class="p-2 border flex gap-2">

                            <button wire:click="edit({{ $product->id }})"
                                class="bg-blue-500 text-white px-3 py-1 rounded">
                                Update
                            </button>

                            <button
                                onclick="confirm('Yakin ingin menghapus produk?') || event.stopImmediatePropagation()"
                                wire:click="delete({{ $product->id }})"
                                class="bg-red-500 text-white px-3 py-1 rounded">
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
@if($showModal)

<div class="fixed inset-0 bg-black/50 flex items-center justify-center">

    <div class="bg-white p-6 rounded w-96">

        <h2 class="text-lg font-bold mb-4">
            Edit Produk
        </h2>

        <input
            type="text"
            wire:model="name"
            class="border w-full p-2 mb-3"
        >

        <input
            type="number"
            wire:model="price"
            class="border w-full p-2 mb-3"
        >

        <div class="flex gap-2 justify-end">

            <button
                wire:click="$set('showModal',false)"
                class="bg-gray-400 text-white px-3 py-1 rounded"
            >
                Cancel
            </button>

            <button
                wire:click="update"
                class="bg-green-500 text-white px-3 py-1 rounded"
            >
                Save
            </button>

        </div>

    </div>

</div>

@endif
</div>
