<?php

namespace App\Http\Controllers\Ussd;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\MarketPrice;
use App\Models\Product;
use App\Models\UssdSession;
use Illuminate\Http\Request;

class UssdController extends Controller
{
    public function handle(Request $request)
    {
        $sessionId   = $request->input('sessionId');
        $phoneNumber = $request->input('phoneNumber');
        $text        = $request->input('text', '');

        $session = UssdSession::firstOrCreate(
            ['session_id' => $sessionId],
            [
                'phone'        => $phoneNumber,
                'current_menu' => 'main',
                'session_data' => [],
                'is_active'    => true,
                'farmer_id'    => Farmer::where('phone', $phoneNumber)->value('id'),
            ]
        );

        $session->update(['last_interaction_at' => now()]);

        $inputs = ($text === '' || $text === null) ? [] : explode('*', $text);
        $level  = count($inputs);

        $response = $this->processMenu($session, $inputs, $level, $phoneNumber);

        return response($response)->header('Content-Type', 'text/plain');
    }

    private function processMenu(UssdSession $session, array $inputs, int $level, string $phone): string
    {
        if ($level === 0) {
            return "CON Bienvenue sur AgriMarketplace\n" .
                   "1. Publier un produit\n" .
                   "2. Prix du marche\n" .
                   "3. Mes commandes\n" .
                   "4. Mon compte";
        }

        $choice = $inputs[0];

        // ── Option 1 : Publier un produit ──
        if ($choice === '1') {
            $farmer = Farmer::where('phone', $phone)->first();

            if (! $farmer) {
                return "END Vous n'etes pas enregistre\ncomme agriculteur.";
            }

            if ($level === 1) {
                return "CON Publier un produit\nEntrez le nom du produit:";
            }

            if ($level === 2) {
                return "CON Entrez la quantite (kg):";
            }

            if ($level === 3) {
                return "CON Entrez le prix par kg (Ar):";
            }

            if ($level === 4) {
                $name     = $inputs[1];
                $quantity = $inputs[2];
                $price    = $inputs[3];

                if (! is_numeric($quantity) || ! is_numeric($price)) {
                    return "END Donnees invalides.\nVeuillez reessayer.";
                }

                $category = \App\Models\Category::first();

                Product::create([
                    'farmer_id'          => $farmer->id,
                    'category_id'        => $category->id,
                    'name'               => $name,
                    'price'              => (float) $price,
                    'unit'               => 'kg',
                    'quantity_available' => (float) $quantity,
                    'status'             => 'available',
                ]);

                return "END Produit publie avec succes!\n" .
                       "Produit: {$name}\n" .
                       "Quantite: {$quantity}kg\n" .
                       "Prix: {$price} Ar/kg";
            }
        }

        // ── Option 2 : Prix du marché ──
        if ($choice === '2') {
            if ($level === 1) {
                return "CON Prix du marche\n" .
                       "1. Riz\n" .
                       "2. Carottes\n" .
                       "3. Mangues\n" .
                       "4. Pommes de terre";
            }

            $produits = [
                '1' => 'Riz blanc',
                '2' => 'Carottes',
                '3' => 'Mangues',
                '4' => 'Pommes de terre',
            ];

            $productName = $produits[$inputs[1]] ?? null;

            if (! $productName) {
                return "END Choix invalide.";
            }

            $price = MarketPrice::where('product_name', $productName)
                ->latest('price_date')
                ->first();

            if (! $price) {
                return "END Aucun prix disponible\npour {$productName}.";
            }

            return "END Prix: {$productName}\n" .
                   "Min: {$price->min_price} Ar/{$price->unit}\n" .
                   "Max: {$price->max_price} Ar/{$price->unit}\n" .
                   "Moyen: {$price->avg_price} Ar/{$price->unit}\n" .
                   "Region: {$price->region}\n" .
                   "Date: " . $price->price_date->format('d/m/Y');
        }

        // ── Option 3 : Mes commandes ──
        if ($choice === '3') {
            $farmer = Farmer::where('phone', $phone)->first();

            if (! $farmer) {
                return "END Vous n'etes pas enregistre\ncomme agriculteur.";
            }

            $items = $farmer->orderItems()
                ->with(['order', 'product'])
                ->latest()
                ->take(3)
                ->get();

            if ($items->isEmpty()) {
                return "END Vous n'avez aucune commande.";
            }

            $response = "END Vos dernieres commandes:\n";
            foreach ($items as $item) {
                $productName = $item->product ? $item->product->name : 'Produit';
                $status      = $item->order ? $item->order->status : 'inconnu';
                $response   .= "- {$productName}: {$item->quantity}kg - {$status}\n";
            }

            return $response;
        }

        // ── Option 4 : Mon compte ──
        if ($choice === '4') {
            $farmer = Farmer::where('phone', $phone)->with('user')->first();

            if (! $farmer) {
                return "END Compte non trouve.\nContactez l'administrateur.";
            }

            $totalProducts = $farmer->products()->count();
            $totalRevenue  = $farmer->orderItems()->sum('subtotal');

            return "END Mon compte\n" .
                   "Nom: {$farmer->farm_name}\n" .
                   "Region: {$farmer->region}\n" .
                   "Produits: {$totalProducts}\n" .
                   "Revenus: " . number_format($totalRevenue, 0, ',', ' ') . " Ar";
        }

        return "END Option invalide.\nVeuillez reessayer.";
    }
}