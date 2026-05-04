@extends('layouts.app')

@section('title', 'Stores - Ticket Processor')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Stores</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Manage retail stores and their keywords</p>
    </div>
    <a href="{{ route('stores.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
        ➕ New Store
    </a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    @if ($stores->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Keywords</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($stores as $store)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $store->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex flex-wrap gap-2">
                                @foreach ($store->match_keywords as $keyword)
                                    <span class="inline-block px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded text-xs">{{ $keyword }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if ($store->active)
                                <span class="inline-block px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full text-xs font-medium">
                                    ✓ Active
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full text-xs font-medium">
                                    ○ Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <a href="{{ route('stores.edit', $store) }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium text-sm">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('stores.destroy', $store) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this store?')" class="text-red-600 dark:text-red-400 hover:underline font-medium text-sm">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $stores->links() }}
        </div>
    @else
        <div class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
            <svg class="mx-auto h-12 w-12 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-lg font-medium">No stores found</p>
            <a href="{{ route('stores.create') }}" class="text-blue-600 dark:text-blue-400 hover:underline mt-2 inline-block">
                Create the first store
            </a>
        </div>
    @endif
</div>
@endsection

