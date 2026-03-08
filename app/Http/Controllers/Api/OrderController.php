<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $orders = Order::with(['items.product', 'items.farmer.user', 'buyer'])
            ->when($user->role === 'buyer', fn($q) =>
                $q->where('buyer_id', $user->id)
            )
            ->when($user->role === 'farmer', fn($q) =>
                $q->whereHas('items', fn($q) =>
                    $q->where('farmer_id', $user->farmer->id)
                )
            )
            ->latest()
            ->paginate(15);

        return response()->json($orders);
    }

    public function show(Request $request, Order $order)
    {
        $user = $request->user();

        $isBuyer  = $order->buyer_id === $user->id;
        $isFarmer = $user->farmer &&
            $order->items()->where('farmer_id', $user->farmer->id)->exists();
        $isAdmin  = $user->isAdmin();

        if (! $isBuyer && ! $isFarmer && ! $isAdmin) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        return response()->json($order->load(['items.product', 'items.farmer.user', 'buyer']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items'                => 'required|array|min:1',
            'items.*.product_id'   => 'required|exists:products,id',
            'items.*.quantity'     => 'required|numeric|min:0.1',
            'delivery_address'     => 'nullable|string',
            'delivery_region'      => 'nullable|string',
            'payment_method'       => 'nullable|in:mvola,orange_money,cash,bank',
            'notes'                => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $totalAmount = 0;
            $orderItems  = [];

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                if (! $product->isAvailable()) {
                    return response()->json([
                        'message' => "Le produit '{$product->name}' n'est plus disponible.",
                    ], 422);
                }

                if ($product->quantity_available < $item['quantity']) {
                    return response()->json([
                        'message' => "Quantité insuffisante pour '{$product->name}'. Disponible: {$product->quantity_available} {$product->unit}",
                    ], 422);
                }

                $subtotal     = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $orderItems[] = [
                    'product_id'  => $product->id,
                    'farmer_id'   => $product->farmer_id,
                    'quantity'    => $item['quantity'],
                    'unit_price'  => $product->price,
                    'subtotal'    => $subtotal,
                ];

                // Réduire le stock
                $product->decrement('quantity_available', $item['quantity']);
                if ($product->quantity_available <= 0) {
                    $product->update(['status' => 'out_of_stock']);
                }
            }

            $order = Order::create([
                'buyer_id'         => $request->user()->id,
                'total_amount'     => $totalAmount,
                'delivery_address' => $validated['delivery_address'] ?? null,
                'delivery_region'  => $validated['delivery_region'] ?? null,
                'payment_method'   => $validated['payment_method'] ?? null,
                'notes'            => $validated['notes'] ?? null,
            ]);

            $order->items()->createMany($orderItems);

            DB::commit();

            return response()->json([
                'message' => 'Commande créée avec succès',
                'order'   => $order->load('items.product'),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la création de la commande.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Order $order)
    {
        $user = $request->user();

        // Seul l'admin ou l'agriculteur concerné peut changer le statut
        if (! $user->isAdmin() && ! ($user->farmer &&
            $order->items()->where('farmer_id', $user->farmer->id)->exists())) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $validated = $request->validate([
            'status'         => 'sometimes|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'payment_status' => 'sometimes|in:unpaid,paid,refunded',
        ]);

        $order->update($validated);

        return response()->json([
            'message' => 'Commande mise à jour',
            'order'   => $order,
        ]);
    }

    public function destroy(Request $request, Order $order)
    {
        if ($order->buyer_id !== $request->user()->id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        if (! $order->isPending()) {
            return response()->json([
                'message' => 'Impossible d\'annuler une commande déjà traitée.',
            ], 422);
        }

        // Remettre le stock
        foreach ($order->items as $item) {
            $item->product->increment('quantity_available', $item->quantity);
            $item->product->update(['status' => 'available']);
        }

        $order->delete();

        return response()->json(['message' => 'Commande annulée']);
    }
}