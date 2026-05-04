@extends('layouts.app')

@section('title', 'Edit Store - Ticket Processor')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Store</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Update store information</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form method="POST" action="{{ route('stores.update', $store) }}">
            @csrf
            @method('PATCH')

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $store->name) }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required>
                @error('name')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keywords -->
            <div class="mb-6">
                <label for="match_keywords" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Match Keywords *</label>
                <textarea name="match_keywords" id="match_keywords"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    rows="4"
                    required>{{ old('match_keywords', implode(', ', $store->match_keywords)) }}</textarea>
                @error('match_keywords')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                    Keywords separated by commas
                </p>
            </div>

            <!-- Active -->
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="active" value="1" {{ old('active', $store->active) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-2 focus:ring-blue-500">
                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Store is active</span>
                </label>
            </div>

            <!-- Info -->
            <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <strong>Slug:</strong> <code>{{ $store->slug }}</code>
                </p>
            </div>

            <!-- Actions -->
            <div class="flex space-x-3">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                    Save Changes
                </button>
                <a href="{{ route('stores.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

