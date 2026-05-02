@extends('layouts.app')

@section('title', 'Create Product Alias - Ticket Processor')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create Product Alias</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Map a product name variant to a canonical name</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form method="POST" action="{{ route('aliases.store') }}">
            @csrf

            <!-- Alias -->
            <div class="mb-6">
                <label for="alias" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Product Alias *
                    <span class="text-gray-500 dark:text-gray-400 text-xs font-normal">(as it appears on receipts)</span>
                </label>
                <input type="text" name="alias" id="alias" value="{{ old('alias') }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="e.g., ESPUMA POLIURET 650ML"
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
                <input type="text" name="canonical_name" id="canonical_name" value="{{ old('canonical_name') }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="e.g., ESPUMA POLIURETANO EXPANDIBLE"
                    required>
                @error('canonical_name')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Help Box -->
            <div class="mb-6 bg-amber-50 dark:bg-amber-900 border border-amber-200 dark:border-amber-700 rounded-lg p-4">
                <div class="flex">
                    <svg class="h-5 w-5 text-amber-600 dark:text-amber-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="text-sm text-amber-700 dark:text-amber-300">
                        <p><strong>Example:</strong> If products appear as "ESPUMA POLIURET 650ML" on receipts but you want them stored as "ESPUMA POLIURETANO EXPANDIBLE", create an alias mapping between them.</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex space-x-3">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                    Create Alias
                </button>
                <a href="{{ route('aliases.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

