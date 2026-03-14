<?php
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\TransactionService;
use App\Models\TransactionDetail;
use App\Models\Transaction;


new class extends Component {
    use WithPagination;
    public $search = '';
    public $sort = 'desc';

    public $isModalOpen = false;
    public $transactionDetails = [];
    public $selectedTransaction = null;
    public $selectedTransactionData = null;

    protected $queryString = ['search', 'sort'];

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function openModal($transactionId)
    {
        $transaction = Transaction::with(['user', 'transactionDetails.product'])->findOrFail($transactionId);

        $this->selectedTransactionData = $transaction;
        $this->transactionDetails = $transaction->transactionDetails;
        $this->selectedTransaction = $transaction->id;
        $this->isModalOpen = true;
    }
    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->transactionDetails = [];
        $this->selectedTransaction = null;
    }
    public function render(TransactionService $transactionService)
    {
        return view('pages.customer.list-transactions', [
            'transactions' => $transactionService->getPaginatedCustomer($this->search, $this->sort),
        ]);
    }
};

?>
<div>
    <div class="flex">
        <livewire:sidebar />
        <div class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-4">Hallo, {{ auth()->user()->username }}</h1>
            <h1 class="text-xl font-bold mb-4">Here is your transaction History</h1>
            <div class="flex justify-between mb-4">
                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search transaction By Quantity"
                    class="border px-3 py-2 rounded w-64">
                <select wire:model.live="sort" class="border px-3 py-2 rounded">
                    <option value="asc">Oldest</option>
                    <option value="desc">Newest</option>
                </select>
            </div>

            <table class="w-full border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">No</th>
                        <th class="p-2 border">Quantity</th>
                        <th class="p-2 border">Total Price</th>
                        <th class="p-2 border">Date</th>
                        <th class="p-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $index => $transaction)
                        <tr>
                            <td class="p-2 border text-center">
                                {{ $transactions->firstItem() + $index }}
                            </td>
                            <td class="p-2 border text-center">
                                {{ $transaction->total_quantity }}
                            </td>
                            <td class="p-2 border">
                                Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                            </td>
                            <td class="p-2 border text-center">{{ $transaction->transaction_date }}</td>
                            <td class="p-2 border text-center">

                                <button wire:click="openModal({{ $transaction->id }})"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                    Get Detail
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>


    @if ($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg w-1/2 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center px-6 py-4 border-b">
                    <h3 class="text-xl font-semibold">Transaction Details </h3>
                    <button wire:click="closeModal"
                        class="text-gray-500 hover:text-red-500 text-2xl font-bold">&times;</button>
                </div>
                <div class="p-6 border-b space-y-2">

                    <p>
                        <strong>Customer :</strong>
                        {{ $selectedTransactionData->user->username ?? 'Unknown User' }}
                    </p>

                    <p>
                        <strong>Date :</strong>
                        {{ $selectedTransactionData->transaction_date }}
                    </p>

                    <p>
                        <strong>Total Quantity :</strong>
                        {{ $selectedTransactionData->total_quantity }}
                    </p>

                    <p>
                        <strong>Total Price :</strong>
                        Rp {{ number_format($selectedTransactionData->total_price, 0, ',', '.') }}
                    </p>

                </div>

                <div class="p-6">
                    @if (count($transactionDetails) > 0)
                        <table class="w-full border border-gray-300 mt-2">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2 border">Product Name</th>
                                    <th class="p-2 border">Qty</th>
                                    <th class="p-2 border">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactionDetails as $detail)
                                    <tr>
                                        <td class="p-2 border">{{ $detail->product->name ?? 'Deleted Product' }}</td>
                                        <td class="p-2 border text-center">{{ $detail->quantity }}</td>
                                        <td class="p-2 border text-right">Rp
                                            {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500 italic">No details found for this transaction.</p>
                    @endif
                </div>

                <div class="px-6 py-4 border-t flex justify-end">
                    <button wire:click="closeModal" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>