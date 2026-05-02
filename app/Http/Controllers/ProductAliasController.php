<?php

namespace App\Http\Controllers;

use App\Models\ProductAlias;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class ProductAliasController extends Controller
{
    public function index(): View
    {
        $aliases = ProductAlias::paginate(20);

        return view('aliases.index', [
            'aliases' => $aliases,
        ]);
    }

    public function create(): View
    {
        return view('aliases.create');
    }

    public function store(): RedirectResponse
    {
        $validated = request()->validate([
            'alias' => ['required', 'string', 'max:100', 'unique:product_aliases'],
            'canonical_name' => ['required', 'string', 'max:255'],
        ]);

        ProductAlias::create($validated);

        return redirect()->route('aliases.index')
            ->with('success', 'Alias created successfully.');
    }

    public function edit(ProductAlias $alias): View
    {
        return view('aliases.edit', [
            'alias' => $alias,
        ]);
    }

    public function update(ProductAlias $alias): RedirectResponse
    {
        $validated = request()->validate([
            'alias' => ['required', 'string', 'max:100', 'unique:product_aliases,alias,' . $alias->id],
            'canonical_name' => ['required', 'string', 'max:255'],
        ]);

        $alias->update($validated);

        return redirect()->route('aliases.index')
            ->with('success', 'Alias updated successfully.');
    }

    public function destroy(ProductAlias $alias): RedirectResponse
    {
        $alias->delete();

        return redirect()->route('aliases.index')
            ->with('success', 'Alias deleted successfully.');
    }
}
