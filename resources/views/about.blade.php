@extends('layouts.app')
@section('title', 'À Propos')
@section('content')
<!-- Hero -->
<section class="bg-gradient-to-br from-green-700 to-emerald-800 text-white py-20">
    <div class="max-w-5xl mx-auto px-4 text-center">
        <span class="text-6xl">🌾</span>
        <h1 class="text-4xl font-bold mt-6">Agri-Marketplace</h1>
        <p class="text-xl text-green-100 mt-4 max-w-2xl mx-auto leading-relaxed">
            La première plateforme digitale qui connecte les agriculteurs malgaches
            directement aux acheteurs, pour un commerce agricole plus juste et plus efficace.
        </p>
    </div>
</section>

<!-- Mission -->
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">🎯 Notre Mission</h2>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Madagascar dispose d'un potentiel agricole immense, mais les agriculteurs font face à
                    de nombreux défis : accès limité aux marchés, prix dictés par les intermédiaires, et
                    manque d'information sur les prix du marché.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    <strong class="text-green-700">Agri-Marketplace</strong> a été conçu pour résoudre ces problèmes
                    en créant un lien direct entre producteurs et consommateurs, tout en fournissant
                    des outils accessibles à tous, y compris via USSD pour les zones rurales.
                </p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-green-50 rounded-2xl p-6 text-center">
                    <span class="text-3xl">👨‍🌾</span>
                    <p class="font-bold text-2xl text-green-700 mt-2" id="count-farmers">-</p>
                    <p class="text-sm text-gray-500 mt-1">Agriculteurs</p>
                </div>
                <div class="bg-emerald-50 rounded-2xl p-6 text-center">
                    <span class="text-3xl">📦</span>
                    <p class="font-bold text-2xl text-emerald-700 mt-2" id="count-products">-</p>
                    <p class="text-sm text-gray-500 mt-1">Produits</p>
                </div>
                <div class="bg-lime-50 rounded-2xl p-6 text-center">
                    <span class="text-3xl">🏷️</span>
                    <p class="font-bold text-2xl text-lime-700 mt-2" id="count-categories">-</p>
                    <p class="text-sm text-gray-500 mt-1">Catégories</p>
                </div>
                <div class="bg-teal-50 rounded-2xl p-6 text-center">
                    <span class="text-3xl">📊</span>
                    <p class="font-bold text-2xl text-teal-700 mt-2" id="count-prices">-</p>
                    <p class="text-sm text-gray-500 mt-1">Prix suivis</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="py-16 bg-gradient-to-br from-green-50 to-emerald-50">
    <div class="max-w-5xl mx-auto px-4">
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-12">🚀 Fonctionnalités clés</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center">
                <span class="text-4xl">🛒</span>
                <h3 class="font-bold text-gray-900 mt-4 mb-2">Vente directe</h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Les agriculteurs vendent directement leurs produits sans intermédiaires,
                    à des prix plus justes.
                </p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center">
                <span class="text-4xl">📊</span>
                <h3 class="font-bold text-gray-900 mt-4 mb-2">Prix du marché</h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Accès en temps réel aux prix des produits agricoles par région,
                    pour des décisions éclairées.
                </p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center">
                <span class="text-4xl">📱</span>
                <h3 class="font-bold text-gray-900 mt-4 mb-2">Accès USSD</h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Composez <strong>*123#</strong> pour accéder aux prix et gérer vos produits
                    même sans internet.
                </p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center">
                <span class="text-4xl">💳</span>
                <h3 class="font-bold text-gray-900 mt-4 mb-2">Paiement mobile</h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Paiement via MVola, Orange Money ou espèces pour s'adapter
                    à toutes les situations.
                </p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center">
                <span class="text-4xl">📍</span>
                <h3 class="font-bold text-gray-900 mt-4 mb-2">Multi-régions</h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Couverture de toutes les régions de Madagascar :
                    Vakinankaratra, SAVA, Atsinanana, et bien plus.
                </p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center">
                <span class="text-4xl">🔒</span>
                <h3 class="font-bold text-gray-900 mt-4 mb-2">Sécurisé</h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Authentification sécurisée par token Sanctum et protection
                    de vos données personnelles.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- How it works -->
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4">
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-12">📋 Comment ça marche ?</h2>
        <div class="grid md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="w-12 h-12 bg-green-600 text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto">1</div>
                <h3 class="font-semibold text-gray-900 mt-4 mb-2">Inscription</h3>
                <p class="text-sm text-gray-500">Créez votre compte en tant qu'agriculteur ou acheteur</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-green-600 text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto">2</div>
                <h3 class="font-semibold text-gray-900 mt-4 mb-2">Publication</h3>
                <p class="text-sm text-gray-500">Les agriculteurs publient leurs produits avec prix et quantités</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-green-600 text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto">3</div>
                <h3 class="font-semibold text-gray-900 mt-4 mb-2">Commande</h3>
                <p class="text-sm text-gray-500">Les acheteurs parcourent et commandent directement</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-green-600 text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto">4</div>
                <h3 class="font-semibold text-gray-900 mt-4 mb-2">Livraison</h3>
                <p class="text-sm text-gray-500">La livraison est organisée et le paiement sécurisé</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-green-700 text-white text-center">
    <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-3xl font-bold">Prêt à rejoindre Agri-Marketplace ?</h2>
        <p class="text-green-100 mt-3 text-lg">Inscrivez-vous gratuitement et commencez à vendre ou acheter des produits agricoles malgaches.</p>
        <div class="flex flex-wrap justify-center gap-4 mt-8">
            <a href="/inscription" class="px-8 py-3 bg-white text-green-700 font-bold rounded-xl hover:bg-green-50 transition shadow-lg">
                Créer un compte
            </a>
            <a href="/produits" class="px-8 py-3 border-2 border-white text-white font-bold rounded-xl hover:bg-white/10 transition">
                Voir les produits
            </a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    try {
        const [farmersRes, productsRes, catsRes, pricesRes] = await Promise.all([
            App.get('/farmers?per_page=1'),
            App.get('/products?per_page=1'),
            App.get('/categories'),
            App.get('/market-prices?per_page=1'),
        ]);
        const farmers = await farmersRes.json();
        const products = await productsRes.json();
        const cats = await catsRes.json();
        const prices = await pricesRes.json();

        document.getElementById('count-farmers').textContent = farmers.total || 0;
        document.getElementById('count-products').textContent = products.total || 0;
        document.getElementById('count-categories').textContent = cats.length || 0;
        document.getElementById('count-prices').textContent = prices.total || 0;
    } catch(e) { console.error(e); }
});
</script>
@endsection
