<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MarketPrice;
use Illuminate\Http\Request;

class MarketPriceController extends Controller
{
    public function index(Request $request)
    {
        $prices = MarketPrice::with('category')
            ->when($request->region, fn($q) =>
                $q->where('region', $request->region)
            )
            ->when($request->category, fn($q) =>
                $q->whereHas('category', fn($q) =>
                    $q->where('slug', $request->category)
                )
            )
            ->when($request->date, fn($q) =>
                $q->where('price_date', $request->date)
            )
            ->latest('price_date')
            ->paginate(20);

        return response()->json($prices);
    }

    public function store(Request $request)
    {
        if (! $request->user()->isAdmin()) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $validated = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'product_name' => 'required|string',
            'region'       => 'required|string',
            'min_price'    => 'required|numeric|min:0',
            'max_price'    => 'required|numeric|min:0',
            'avg_price'    => 'required|numeric|min:0',
            'unit'         => 'required|string',
            'price_date'   => 'required|date',
            'source'       => 'nullable|string',
        ]);

        $price = MarketPrice::create($validated);

        return response()->json([
            'message' => 'Prix créé',
            'price'   => $price,
        ], 201);
    }

    public function update(Request $request, MarketPrice $price)
    {
        if (! $request->user()->isAdmin()) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $validated = $request->validate([
            'min_price'  => 'sometimes|numeric|min:0',
            'max_price'  => 'sometimes|numeric|min:0',
            'avg_price'  => 'sometimes|numeric|min:0',
            'price_date' => 'sometimes|date',
        ]);

        $price->update($validated);

        return response()->json(['message' => 'Prix mis à jour', 'price' => $price]);
    }

    public function destroy(Request $request, MarketPrice $price)
    {
        if (! $request->user()->isAdmin()) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $price->delete();

        return response()->json(['message' => 'Prix supprimé']);
    }
}