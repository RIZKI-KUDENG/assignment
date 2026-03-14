<?php

use Livewire\Component;
use App\Controller\AuthController;

new class extends Component
{
   public function logout(){
    $isAdmin = auth()->user()->role === 'admin';

    Auth::logout();

    if($isAdmin){
        return redirect()->route('login.admin');
    }

    return redirect()->route('login.customer');
}
};
?>
<div>
@auth
<aside class="w-64 bg-gray-900 text-white flex flex-col shadow-2xl h-screen">
    <div class="h-16 flex items-center justify-center border-b border-gray-800">
        <h1 class="text-xl font-bold uppercase tracking-wider text-pink-500">Menu</h1>
    </div>
    
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.list-products') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors">📦 Product List</a>
            <a href="{{ route('admin.create-product') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors">➕ Create Product</a>
            <a href="{{ route('admin.list-transactions') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors">💸 Transactions List</a>
            
        @elseif(auth()->user()->role === 'customer')
            <a href="{{ route('customer.list-transactions') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors">💸 Transactions List</a>
        @endif
    </nav>

    <div class="p-4 border-t border-gray-800">
            @csrf
            <button wire:click="logout" type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors">
                Logout
            </button>
    </div>
</aside>
@endauth
</div>