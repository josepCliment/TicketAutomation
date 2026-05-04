@extends('layouts.app')

@section('title', 'Categories - Ticket Processor')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Categories</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Manage ticket categories</p>
    </div>
    <a href="{{ route('categories.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
        ➕ New Category
    </a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    @if ($categories->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Slug</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($categories as $category)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $category->slug }}</td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium text-sm">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('categories.destroy', $category) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this category?')" class="text-red-600 dark:text-red-400 hover:underline font-medium text-sm">
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
            {{ $categories->links() }}
        </div>
    @else
        <div class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
            <svg class="mx-auto h-12 w-12 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-lg font-medium">No categories found</p>
            <a href="{{ route('categories.create') }}" class="text-blue-600 dark:text-blue-400 hover:underline mt-2 inline-block">
                Create the first category
            </a>
        </div>
    @endif
</div>
@endsection

