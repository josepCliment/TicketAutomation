<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function index(): View
    {
        $stores = Store::paginate(10);
        return view('stores.index', ['stores' => $stores]);
    }

    public function create(): View
    {
        return view('stores.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:stores,name'],
            'match_keywords' => ['required', 'string'],
            'active' => ['boolean'],
        ]);

        $keywords = collect(explode(',', $validated['match_keywords']))
            ->map(fn($k) => trim($k))
            ->filter()
            ->toArray();

        Store::create([
            'name' => $validated['name'],
            'slug' => \Str::slug($validated['name']),
            'match_keywords' => $keywords,
            'active' => $request->boolean('active', true),
        ]);

        return redirect()->route('stores.index')
            ->with('success', 'Store created successfully.');
    }

    public function edit(Store $store): View
    {
        return view('stores.edit', ['store' => $store]);
    }

    public function update(Request $request, Store $store): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:stores,name,' . $store->id],
            'match_keywords' => ['required', 'string'],
            'active' => ['boolean'],
        ]);

        $keywords = collect(explode(',', $validated['match_keywords']))
            ->map(fn($k) => trim($k))
            ->filter()
            ->toArray();

        $store->update([
            'name' => $validated['name'],
            'slug' => \Str::slug($validated['name']),
            'match_keywords' => $keywords,
            'active' => $request->boolean('active', true),
        ]);

        return redirect()->route('stores.index')
            ->with('success', 'Store updated successfully.');
    }

    public function destroy(Store $store): RedirectResponse
    {
        $store->delete();

        return redirect()->route('stores.index')
            ->with('success', 'Store deleted successfully.');
    }
}

