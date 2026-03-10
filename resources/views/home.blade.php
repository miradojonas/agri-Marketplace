@extends('layouts.app')
@section('title', 'Accueil')
@section('content')

    {{-- ═══════════ HERO ═══════════ --}}
    <section class="relative bg-gradient-to-br from-green-700 via-green-600 to-emerald-500 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 text-9xl">🌿</div>
            <div class="absolute bottom-10 right-10 text-9xl">🌾</div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[12rem]">🌍</div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="max-w-3xl">
                <h1 class="text-4xl lg:text-6xl font-bold text-white leading-tight mb-6">
                    Le marché agricole de <span class="text-yellow-300">Madagascar</span> à portée de main
                </h1>
                <p class="text-lg lg:text-xl text-green-100 mb-8 leading-relaxed">
                    Connectez-vous directement aux agriculteurs malgaches. Achetez des produits frais, consultez les prix du marché en temps réel — même par USSD (*123#).
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/produits" class="inline-flex items-center justify-center px-8 py-3.5 bg-white text-green-700 font-bold rounded-xl shadow-lg hover:bg-green-50 hover:shadow-xl transition-all text-lg">
                        🛒 Voir les produits
                    </a>
                    <a href="/inscription" class="inline-flex items-center justify-center px-8 py-3.5 border-2 border-white text-white font-semibold rounded-xl hover:bg-white/10 transition-all text-lg">
                        🌱 Devenir agriculteur
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════ STATS ═══════════ --}}
    <section class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 text-center" id="stats-bar">
                <div><div class="text-3xl font-bold text-green-700" id="stat-farmers">—</div><div class="text-sm text-gray-500 mt-1">Agriculteurs</div></div>
                <div><div class="text-3xl font-bold text-green-700" id="stat-products">—</div><div class="text-sm text-gray-500 mt-1">Produits disponibles</div></div>
                <div><div class="text-3xl font-bold text-green-700">22</div><div class="text-sm text-gray-500 mt-1">Régions couvertes</div></div>
                <div><div class="text-3xl font-bold text-green-700">USSD</div><div class="text-sm text-gray-500 mt-1">Accessible sans internet</div></div>
            </div>
        </div>
    </section>

    {{-- ═══════════ CATÉGORIES ═══════════ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Catégories de produits</h2>
            <p class="text-gray-500 mt-2">Parcourez nos catégories agricoles</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6" id="categories-grid">
            <div class="col-span-full text-center text-gray-400 py-8">Chargement des catégories…</div>
        </div>
    </section>

    {{-- ═══════════ PRODUITS RÉCENTS ═══════════ --}}
    <section class="bg-green-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Produits récents</h2>
                    <p class="text-gray-500 mt-1">Fraîchement ajoutés par nos agriculteurs</p>
                </div>
                <a href="/produits" class="hidden sm:inline-flex items-center gap-1 text-green-700 font-semibold hover:text-green-800 transition">Voir tout →</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="recent-products">
                <div class="col-span-full text-center text-gray-400 py-8">Chargement des produits…</div>
            </div>
            <div class="text-center mt-8 sm:hidden">
                <a href="/produits" class="text-green-700 font-semibold">Voir tous les produits →</a>
            </div>
        </div>
    </section>

    {{-- ═══════════ COMMENT ÇA MARCHE ═══════════ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Comment ça marche ?</h2>
            <p class="text-gray-500 mt-2">Simple, rapide et accessible à tous</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4">📱</div>
                <h3 class="font-bold text-lg mb-2">1. Inscrivez-vous</h3>
                <p class="text-gray-500 text-sm">Créez votre compte en tant qu'agriculteur ou acheteur. Accessible aussi via USSD *123#.</p>
            </div>
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4">🔍</div>
                <h3 class="font-bold text-lg mb-2">2. Parcourez</h3>
                <p class="text-gray-500 text-sm">Explorez les produits par catégorie, consultez les prix du marché en temps réel.</p>
            </div>
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4">🤝</div>
                <h3 class="font-bold text-lg mb-2">3. Commandez</h3>
                <p class="text-gray-500 text-sm">Passez commande directement auprès de l'agriculteur. Notification par SMS.</p>
            </div>
        </div>
    </section>

    {{-- ═══════════ CTA USSD ═══════════ --}}
    <section class="bg-gradient-to-r from-green-700 to-emerald-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-3">Pas d'internet ? Pas de problème !</h2>
                    <p class="text-green-100 text-lg max-w-lg">Accédez au marché agricole par USSD depuis n'importe quel téléphone.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 text-center border border-white/20">
                    <div class="text-5xl font-bold text-yellow-300 mb-2">*123#</div>
                    <p class="text-green-100 text-sm">Composez depuis votre téléphone</p>
                </div>
            </div>
        </div>
    </section>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    // Charger catégories
    const catRes = await App.get('/categories');
    if (catRes?.ok) {
        const cats = await catRes.json();
        const grid = document.getElementById('categories-grid');
        grid.innerHTML = cats.map(c => `
            <a href="/produits?category=${c.slug}" class="group bg-white rounded-2xl p-6 text-center shadow-sm border border-gray-100 hover:shadow-md hover:border-green-200 transition-all hover:-translate-y-1">
                <div class="text-5xl mb-3">${c.icon || '📦'}</div>
                <div class="font-semibold text-gray-800 group-hover:text-green-700 transition">${c.name}</div>
            </a>
        `).join('');
    }

    // Charger produits récents
    const prodRes = await App.get('/products?per_page=6');
    if (prodRes?.ok) {
        const data = await prodRes.json();
        const products = data.data || data;
        document.getElementById('stat-products').textContent = data.total || products.length;
        const grid = document.getElementById('recent-products');
        grid.innerHTML = products.map(p => `
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition-all group">
                <div class="h-48 overflow-hidden">
                    <img src="${p.image || 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=800'}"
                         alt="${p.name}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                         onerror="this.src='https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=800'">
                </div>
                <div class="p-5">
                    <div class="flex items-start justify-between mb-2">
                        <h3 class="font-bold text-gray-900 text-lg">${p.name}</h3>
                        <span class="inline-flex items-center px-2 py-0.5 bg-green-100 text-green-800 text-xs font-medium rounded-full shrink-0">${p.category?.icon || ''} ${p.category?.name || ''}</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-3">
                        👨‍🌾 ${p.farmer?.user?.name || '—'} · 📍 ${p.farmer?.region || '—'}
                    </p>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-2xl font-bold text-green-700">${App.formatPrice(p.price)}</span>
                            <span class="text-sm text-gray-500"> Ar/${p.unit}</span>
                        </div>
                        <a href="/produits/${p.id}" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">Voir</a>
                    </div>
                </div>
            </div>
        `).join('');
    }

    // Charger stats farmers
    const farmRes = await App.get('/farmers');
    if (farmRes?.ok) {
        const fData = await farmRes.json();
        document.getElementById('stat-farmers').textContent = fData.total || fData.data?.length || '—';
    }
});
</script>
@endsection
