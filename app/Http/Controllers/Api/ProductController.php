<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['farmer.user', 'category'])
            ->when($request->category, fn($q) =>
                $q->whereHas('category', fn($q) => $q->where('slug', $request->category))
            )
            ->when($request->region, fn($q) =>
                $q->whereHas('farmer', fn($q) => $q->where('region', $request->region))
            )
            ->when($request->search, fn($q) =>
                $q->where('name', 'like', "%{$request->search}%")
            )
            ->where('status', 'available')
            ->latest()
            ->paginate(15);

        return response()->json($products);
    }

    public function show(Product $product)
    {
        return response()->json(
            $product->load(['farmer.user', 'category'])
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'        => 'required|exists:categories,id',
            'name'               => 'required|string|max:255',
            'name_mg'            => 'nullable|string|max:255',
            'description'        => 'nullable|string',
            'price'              => 'required|numeric|min:0',
            'unit'               => 'required|string',
            'quantity_available' => 'required|numeric|min:0',
            'harvest_date'       => 'nullable|date',
        ]);

        $farmer = $request->user()->farmer;

        if (! $farmer) {
            return response()->json(['message' => 'Profil agriculteur requis.'], 403);
        }

        $product = $farmer->products()->create($validated);

        return response()->json([
            'message' => 'Produit créé avec succès',
            'product' => $product->load('category'),
        ], 201);
    }

    public function update(Request $request, Product $product)
    {
        $farmer = $request->user()->farmer;

        if (! $farmer || $product->farmer_id !== $farmer->id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $validated = $request->validate([
            'name'               => 'sometimes|string|max:255',
            'price'              => 'sometimes|numeric|min:0',
            'quantity_available' => 'sometimes|numeric|min:0',
            'status'             => 'sometimes|in:available,out_of_stock,pending',
        ]);

        $product->update($validated);

        return response()->json([
            'message' => 'Produit mis à jour',
            'product' => $product,
        ]);
    }

    public function destroy(Request $request, Product $product)
    {
        $farmer = $request->user()->farmer;

        if (! $farmer || $product->farmer_id !== $farmer->id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $product->delete();

        return response()->json(['message' => 'Produit supprimé']);
    }

    public function categories()
    {
        return response()->json(Category::where('is_active', true)->get());
    }
}