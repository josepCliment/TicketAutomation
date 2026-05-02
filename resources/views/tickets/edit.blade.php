@extends('layouts.app')

@section('title', 'Edit Ticket #' . $ticket->id . ' - Ticket Processor')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Ticket #{{ $ticket->id }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Correct the extracted ticket information</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form method="POST" action="{{ route('tickets.update', $ticket) }}">
            @csrf
            @method('PATCH')

            <!-- Store -->
            <div class="mb-6">
                <label for="store" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store Name *</label>
                <input type="text" name="store" id="store" value="{{ old('store', $ticket->store) }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required>
                @error('store')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-6">
                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category *</label>
                <select name="category" id="category"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->value }}" {{ old('category', $ticket->category->value) === $category->value ? 'selected' : '' }}>
                            {{ ucfirst($category->value) }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date -->
            <div class="mb-6">
                <label for="purchased_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Purchase Date *</label>
                <input type="date" name="purchased_at" id="purchased_at" value="{{ old('purchased_at', $ticket->purchased_at->format('Y-m-d')) }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required>
                @error('purchased_at')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Total -->
            <div class="mb-6">
                <label for="total" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Total Amount *</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-600 dark:text-gray-400">$</span>
                    <input type="number" name="total" id="total" value="{{ old('total', $ticket->total) }}" step="0.01" min="0"
                        class="w-full pl-8 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                </div>
                @error('total')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Products Section -->
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Products ({{ $ticket->products->count() }})</h3>
                @if ($ticket->products->count() > 0)
                    <div class="space-y-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        @foreach ($ticket->products as $index => $product)
                            <div class="bg-white dark:bg-gray-800 p-4 rounded border border-gray-200 dark:border-gray-600">
                                <div class="grid grid-cols-2 gap-4 mb-2">
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400">Product Name</label>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $product->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400">Original Name</label>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $product->original_name }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400">Quantity</label>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $product->quantity }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400">Unit Price</label>
                                        <p class="text-sm text-gray-900 dark:text-white">${{ number_format($product->unit_price, 2) }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400">Total</label>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                        ℹ️ To edit individual products or aliases, go to the <a href="{{ route('aliases.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Aliases</a> section.
                    </p>
                @else
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded text-center text-gray-500 dark:text-gray-400">
                        No products extracted from this ticket.
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="flex space-x-3">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                    Save Changes
                </button>
                <a href="{{ route('tickets.show', $ticket) }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

