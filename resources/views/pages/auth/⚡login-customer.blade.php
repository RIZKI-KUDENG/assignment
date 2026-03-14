<?php

use Livewire\Component;
use App\Services\AuthService;

new class extends Component {
    public string $username = '';
    public string $password = '';
    public string $type = 'customer';

    public function mount($type = 'customer')
    {
        $this->type = $type;
    }

    public function authenticate(AuthService $authService)
    {
        $this->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = $authService->login($this->username, $this->password);

        if (!$user) {
            session()->flash('error', 'Invalid username or password');
            return;
        }

        if ($user->role == 'customer') {
            return redirect()->route('customer.list-transactions');
        }else{
            session()->flash('error', 'You are not a customer');
            return;
        }

        
    }
};
?>


    <div class="flex flex-col justify-center items-center h-screen">
    @if(session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <form wire:submit="authenticate" class="flex flex-col gap-4 max-w-md mx-auto border p-4 rounded">
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
            <input type="text" wire:model="username" class="border border-gray-300 rounded-md w-full px-3 py-2">
            @error('username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
            <input type="password" wire:model="password" class="border border-gray-300 rounded-md w-full px-3 py-2">
            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
            Login {{ ucfirst($type) }}
        </button>
    </form>
</div>
