<?php
use Livewire\Component;
use App\Services\ProductService;

new class extends Component {
    public $name = '';
    public $price = '';

    public function addProduct(ProductService $service)
    {
        $service->create([
            'name' => $this->name,
            'price' => $this->price,
        ]);

        session()->flash('success', 'Produk berhasil ditambahkan');

        $this->reset(['name', 'price']);
    }
};
?>

<div class="flex ">


    <livewire:sidebar />

    <div class=" flex-1 p-8">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Tambah Produk
        </h1>

        <div class="bg-white shadow-lg rounded-xl p-6 max-w-md">
            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            <form wire:submit.prevent="addProduct" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Produk
                    </label>

                    <input type="text" wire:model="name" placeholder="Contoh: Ayam Geprek"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Harga
                    </label>

                    <input type="number" wire:model="price" placeholder="Contoh: 15000"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white font-medium py-2 rounded-lg hover:bg-blue-700 transition">
                    Tambah Produk
                </button>

            </form>

        </div>

    </div>

</div>
