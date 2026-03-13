<?php 
use Livewire\Component;
use App\Services\TransactionService;
use Livewire\WithPagination;



new class extends Component {
use WithPagination;
public $search = '';
public $sort = 'desc';

protected $queryString = ['search', 'sort'];

public function updatingSearch()
{
    $this->resetPage();
}

public function render(TransactionService $transactionService)
{
    return view('pages.admin.list-transactions', [
        'transactions' => $transactionService->getPaginated($this->search, $this->sort),
    ]);
}


}

?>

<div class="flex">
    <livewire:sidebar/>
    <div class="flex-1 p-6">
        <h1 class="text-2xl font-bold mb-4">List Transaction Page</h1>
        <div class="flex justify-between mb-4">
            <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search transaction..." class="border px-3 py-2 rounded w-64">
            <select wire:model.live="sort" class="border px-3 py-2 rounded">

                <option value="asc">
                    Oldest
                </option>

                <option value="desc">
                    Newest
                </option>
            </select>
        </div>
        <table class="w-full border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border">No</th>
                    <th class="p-2 border">Customer Name</th>
                    <th class="p-2 border">Quantity</th>
                    <th class="p-2 border">Total Price</th>
                    <th class="p-2 border">Date</th>
                    <th class="p-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $index => $transaction)
                    <tr>
                        <td class="p-2 border">
                            {{ $transactions->firstItem() + $index }}
                        </td>
                        <td class="p-2 border">
                            {{ $transaction->user_id }}
                        </td>
                        <td class="p-2 border">
                            {{ $transaction->total_quantity }}
                        </td>
                        <td class="p-2 border">
                            Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                        </td>
                        <td class="p-2 border">{{ $transaction->transaction_date }}</td>
                        <td class="p-2 border flex gap-2">
                            <button wire:click="delete({{ $transaction->id }})" class="bg-slate-500 text-white px-3 py-1 rounded">Get Detail</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>