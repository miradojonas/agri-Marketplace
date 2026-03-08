<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
    public function index(Request $request)
    {
        $farmers = Farmer::with('user')
            ->when($request->region, fn($q) =>
                $q->where('region', $request->region)
            )
            ->paginate(15);

        return response()->json($farmers);
    }

    public function show(Farmer $farmer)
    {
        return response()->json(
            $farmer->load(['user', 'products' => fn($q) =>
                $q->where('status', 'available')->with('category')
            ])
        );
    }

    public function profile(Request $request)
    {
        $farmer = $request->user()->farmer;

        if (! $farmer) {
            return response()->json(['message' => 'Profil agriculteur introuvable.'], 404);
        }

        return response()->json($farmer->load('user', 'products.category'));
    }

    public function updateProfile(Request $request)
    {
        $farmer = $request->user()->farmer;

        if (! $farmer) {
            return response()->json(['message' => 'Profil agriculteur introuvable.'], 404);
        }

        $validated = $request->validate([
            'farm_name'   => 'sometimes|string|max:255',
            'region'      => 'sometimes|string',
            'district'    => 'nullable|string',
            'description' => 'nullable|string',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
        ]);

        $farmer->update($validated);

        return response()->json([
            'message' => 'Profil mis à jour',
            'farmer'  => $farmer,
        ]);
    }

    public function orders(Request $request)
    {
        $farmer = $request->user()->farmer;

        if (! $farmer) {
            return response()->json(['message' => 'Profil agriculteur introuvable.'], 404);
        }

        $orders = $farmer->orderItems()
            ->with(['order.buyer', 'product'])
            ->latest()
            ->paginate(15);

        return response()->json($orders);
    }

    public function dashboard(Request $request)
    {
        $farmer = $request->user()->farmer;

        if (! $farmer) {
            return response()->json(['message' => 'Profil agriculteur introuvable.'], 404);
        }

        $totalProducts  = $farmer->products()->count();
        $activeProducts = $farmer->products()->where('status', 'available')->count();
        $totalOrders    = $farmer->orderItems()->distinct('order_id')->count();
        $totalRevenue   = $farmer->orderItems()->sum('subtotal');

        return response()->json([
            'farmer'          => $farmer->load('user'),
            'total_products'  => $totalProducts,
            'active_products' => $activeProducts,
            'total_orders'    => $totalOrders,
            'total_revenue'   => $totalRevenue,
            'recent_products' => $farmer->products()
                ->with('category')->latest()->take(5)->get(),
        ]);
    }
}