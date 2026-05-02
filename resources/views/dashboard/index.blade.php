@extends('layouts.app')

@section('title', 'Dashboard - Ticket Processor')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Manage and view all your processed tickets</p>
        </div>
        <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
            + Upload Ticket
        </a>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Tickets</div>
        <div class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
            {{ \App\Models\Ticket::count() }}
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Processed</div>
        <div class="text-3xl font-bold text-green-600 mt-2">
            {{ \App\Models\Ticket::where('status', 'processed')->count() }}
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Processing</div>
        <div class="text-3xl font-bold text-yellow-600 mt-2">
            {{ \App\Models\Ticket::where('status', 'processing')->count() }}
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="text-gray-500 dark:text-gray-400 text-sm font-medium">Failed</div>
        <div class="text-3xl font-bold text-red-600 mt-2">
            {{ \App\Models\Ticket::where('status', 'failed')->count() }}
        </div>
    </div>
</div>

<!-- Tickets Table -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Store</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Products</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse ($tickets as $ticket)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">#{{ $ticket->id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $ticket->store }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $ticket->purchased_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">${{ number_format($ticket->total, 2) }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="inline-block px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded text-xs font-medium">
                            {{ ucfirst($ticket->category->value) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if ($ticket->status->value === 'processed')
                            <span class="inline-block px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded text-xs font-medium">
                                ✓ Processed
                            </span>
                        @elseif ($ticket->status->value === 'processing')
                            <span class="inline-block px-2 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded text-xs font-medium">
                                ⟳ Processing
                            </span>
                        @elseif ($ticket->status->value === 'queued')
                            <span class="inline-block px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded text-xs font-medium">
                                ◌ Queued
                            </span>
                        @else
                            <span class="inline-block px-2 py-1 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded text-xs font-medium">
                                ✗ Failed
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                        {{ $ticket->products->count() }} item(s)
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <div class="flex space-x-2">
                            <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-600 dark:text-blue-400 hover:underline">View</a>
                            @if ($ticket->status->value === 'processed')
                                <a href="{{ route('tickets.edit', $ticket) }}" class="text-blue-600 dark:text-blue-400 hover:underline">Edit</a>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                        <div class="text-lg font-medium mb-2">No tickets yet</div>
                        <p class="text-sm">Upload your first receipt to get started</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if ($tickets->hasPages())
    <div class="mt-6">
        {{ $tickets->links() }}
    </div>
@endif
@endsection

