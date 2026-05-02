@extends('layouts.app')

@section('title', 'Product Aliases - Ticket Processor')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Product Aliases</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Manage product name normalization mappings</p>
    </div>
    <a href="{{ route('aliases.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
        + Add Alias
    </a>
</div>

<!-- Info Box -->
<div class="mb-6 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
    <div class="flex">
        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"/>
        </svg>
        <div class="text-sm text-blue-700 dark:text-blue-300">
            <p><strong>What are aliases?</strong> Aliases map abbreviated or varied product names from receipts to a canonical name. For example, "ESPUMA POLIURET 650ML" might map to "ESPUMA POLIURETANO EXPANDIBLE".</p>
        </div>
    </div>
</div>

<!-- Aliases Table -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Alias</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Canonical Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse ($aliases as $alias)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                        <code class="bg-gray-100 dark:bg-gray-900 px-2 py-1 rounded text-xs">{{ $alias->alias }}</code>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $alias->canonical_name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $alias->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-sm">
                        <div class="flex space-x-3">
                            <a href="{{ route('aliases.edit', $alias) }}" class="text-blue-600 dark:text-blue-400 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('aliases.destroy', $alias) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 dark:text-red-400 hover:underline">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                        <div class="text-lg font-medium mb-2">No aliases yet</div>
                        <p class="text-sm">Create your first alias to map product names</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if ($aliases->hasPages())
    <div class="mt-6">
        {{ $aliases->links() }}
    </div>
@endif
@endsection

