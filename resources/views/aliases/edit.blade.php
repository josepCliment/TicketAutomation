@extends('layouts.app')

@section('title', 'Edit Product Alias - Ticket Processor')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Product Alias</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Update the alias mapping</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form method="POST" action="{{ route('aliases.update', $alias) }}">
            @csrf
            @method('PATCH')

            <!-- Alias -->
            <div class="mb-6">
                <label for="alias" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Product Alias *
                    <span class="text-gray-500 dark:text-gray-400 text-xs font-normal">(as it appears on receipts)</span>
                </label>
                <input type="text" name="alias" id="alias" value="{{ old('alias', $alias->alias) }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required>
                @error('alias')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Canonical Name -->
            <div class="mb-6">
                <label for="canonical_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Canonical Name *
                    <span class="text-gray-500 dark:text-gray-400 text-xs font-normal">(normalized/standard name)</span>
                </label>
                <input type="text" name="canonical_name" id="canonical_name" value="{{ old('canonical_name', $alias->canonical_name) }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required>
                @error('canonical_name')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Metadata -->
            <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <label class="text-gray-500 dark:text-gray-400">Created</label>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $alias->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500 dark:text-gray-400">Updated</label>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $alias->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex space-x-3">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                    Update Alias
                </button>
                <a href="{{ route('aliases.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Cancel
                </a>
            </div>
        </form>

        <!-- Delete Button -->
        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ route('aliases.destroy', $alias) }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to delete this alias?')" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition">
                    Delete Alias
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

