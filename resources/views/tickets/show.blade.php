@extends('layouts.app')

@section('title', 'Ticket #' . $ticket->id . ' - Ticket Processor')

@section('content')
<div class="mb-8 flex justify-between items-start">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Ticket #{{ $ticket->id }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">
            Uploaded on {{ $ticket->created_at->format('F j, Y \a\t g:i A') }}
        </p>
    </div>
    <div class="flex space-x-3">
        @if ($ticket->status->value === 'processed')
            <a href="{{ route('tickets.edit', $ticket) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                Edit
            </a>
        @endif
        <form method="POST" action="{{ route('tickets.destroy', $ticket) }}" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Are you sure?')" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition">
                Delete
            </button>
        </form>
    </div>
</div>

<!-- Status Banner -->
<div class="mb-6 p-4 rounded-lg {{ $ticket->status->value === 'processed' ? 'bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700' : ($ticket->status->value === 'processing' ? 'bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700' : ($ticket->status->value === 'queued' ? 'bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600' : 'bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700')) }}">
    <div class="flex items-center">
        @if ($ticket->status->value === 'processed')
            <svg class="h-6 w-6 text-green-600 dark:text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h3 class="font-medium text-green-900 dark:text-green-100">Successfully Processed</h3>
                <p class="text-sm text-green-800 dark:text-green-200">This ticket has been processed and the data has been extracted.</p>
            </div>
        @elseif ($ticket->status->value === 'processing')
            <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400 mr-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            <div>
                <h3 class="font-medium text-yellow-900 dark:text-yellow-100">Processing</h3>
                <p class="text-sm text-yellow-800 dark:text-yellow-200">Your receipt is being processed. Please check back in a moment.</p>
            </div>
        @elseif ($ticket->status->value === 'queued')
            <svg class="h-6 w-6 text-gray-600 dark:text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zm0-10a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h3 class="font-medium text-gray-900 dark:text-gray-100">Queued</h3>
                <p class="text-sm text-gray-800 dark:text-gray-200">Your receipt is in the queue and will be processed soon.</p>
            </div>
        @else
            <svg class="h-6 w-6 text-red-600 dark:text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h3 class="font-medium text-red-900 dark:text-red-100">Processing Failed</h3>
                <p class="text-sm text-red-800 dark:text-red-200">There was an error processing this receipt. Please try uploading again.</p>
            </div>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <!-- Ticket Info -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Ticket Information</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-500 dark:text-gray-400">Store</label>
                    <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $ticket->store }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500 dark:text-gray-400">Date</label>
                    <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $ticket->purchased_at->format('F j, Y') }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500 dark:text-gray-400">Category</label>
                    <span class="inline-block px-3 py-1 mt-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded font-medium text-sm">
                        {{ ucfirst($ticket->category->value) }}
                    </span>
                </div>
                <div>
                    <label class="text-sm text-gray-500 dark:text-gray-400">Total</label>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($ticket->total, 2) }}</p>
                </div>
            </div>
            @if ($ticket->processor)
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <label class="text-sm text-gray-500 dark:text-gray-400">Processor</label>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ class_basename($ticket->processor) }}</p>
                </div>
            @endif
        </div>

        <!-- Products Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Products ({{ $ticket->products->count() }})</h2>
            </div>
            @if ($ticket->products->count() > 0)
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Product Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Qty</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Unit Price</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($ticket->products as $product)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $product->name }}</div>
                                    @if ($product->original_name && $product->original_name !== $product->name)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Original: {{ $product->original_name }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $product->quantity }}</td>
                                <td class="px-6 py-4 text-right text-sm text-gray-600 dark:text-gray-400">${{ number_format($product->unit_price, 2) }}</td>
                                <td class="px-6 py-4 text-right text-sm font-medium text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-medium text-gray-900 dark:text-white">Total:</td>
                            <td class="px-6 py-4 text-right text-lg font-bold text-gray-900 dark:text-white">${{ number_format($ticket->products->sum('price'), 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            @else
                <div class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                    <p>No products extracted from this ticket.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Raw JSON -->
        @if ($ticket->raw_text)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Raw JSON</h3>
                <details class="cursor-pointer">
                    <summary class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                        Show raw extraction data
                    </summary>
                    <pre class="mt-3 p-3 bg-gray-900 dark:bg-gray-950 text-gray-100 rounded text-xs overflow-x-auto whitespace-pre-wrap break-words">{{ $ticket->raw_text }}</pre>
                </details>
            </div>
        @endif

        <!-- Metadata -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Metadata</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <label class="text-gray-500 dark:text-gray-400">Status</label>
                    <p class="font-medium text-gray-900 dark:text-white">{{ ucfirst($ticket->status->value) }}</p>
                </div>
                <div>
                    <label class="text-gray-500 dark:text-gray-400">Created</label>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $ticket->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <label class="text-gray-500 dark:text-gray-400">Updated</label>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $ticket->updated_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <label class="text-gray-500 dark:text-gray-400">Item Count</label>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $ticket->products->count() }} item(s)</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

