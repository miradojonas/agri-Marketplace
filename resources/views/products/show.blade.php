@extends('layouts.app')
@section('title', 'Détail Produit')
@section('content')
<div class="bg-gradient-to-br from-green-50 to-emerald-50 min-h-screen py-8">
    <div class="max-w-5xl mx-auto px-4">
        <!-- Back -->
        <a href="/produits" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800 mb-6 text-sm font-medium">
            ← Retour aux produits
        </a>

        <!-- Loading skeleton -->
        <div id="product-skeleton" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 animate-pulse">
            <div class="flex flex-col md:flex-row gap-8">
                <div class="w-full md:w-1/2 h-80 bg-gray-200 rounded-2xl"></div>
                <div class="flex-1 space-y-4">
                    <div class="h-6 bg-gray-200 rounded w-3/4"></div>
                    <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                    <div class="h-8 bg-gray-200 rounded w-1/3"></div>
                    <div class="h-20 bg-gray-200 rounded"></div>
                </div>
            </div>
        </div>

        <!-- Product detail (hidden until loaded) -->
        <div id="product-detail" class="hidden">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <!-- Image -->
                    <div class="w-full md:w-1/2">
                        <img id="prod-image" src="" alt="" class="w-full h-80 md:h-full object-cover"
                             onerror="this.src='https://images.unsplash.com/photo-1595855759920-86582396756a?w=600'">
                    </div>
                    <!-- Info -->
                    <div class="flex-1 p-8">
                        <span id="prod-category" class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full mb-3"></span>
                        <h1 id="prod-name" class="text-2xl font-bold text-gray-900"></h1>
                        <p id="prod-name-mg" class="text-sm text-gray-400 italic mt-1"></p>

                        <div class="flex items-baseline gap-2 mt-4">
                            <span id="prod-price" class="text-3xl font-bold text-green-700"></span>
                            <span id="prod-unit" class="text-gray-500"></span>
                        </div>

                        <div id="prod-description" class="text-gray-600 mt-4 leading-relaxed"></div>

                        <div class="border-t border-gray-100 mt-6 pt-4 space-y-2 text-sm text-gray-600">
                            <p id="prod-stock"></p>
                            <p id="prod-harvest"></p>
                        </div>

                        <!-- Farmer info -->
                        <div class="bg-green-50 rounded-xl p-4 mt-6">
                            <h3 class="font-semibold text-green-800 text-sm mb-2">🧑‍🌾 Agriculteur</h3>
                            <p id="farmer-name" class="font-medium text-gray-900"></p>
                            <p id="farmer-farm" class="text-sm text-gray-500"></p>
                            <p id="farmer-region" class="text-sm text-gray-500"></p>
                        </div>

                        <!-- Order form (only for logged-in buyers) -->
                        <div id="order-section" class="hidden mt-6 border-t border-gray-100 pt-6">
                            <h3 class="font-semibold text-gray-900 mb-3">📦 Passer commande</h3>
                            <div id="order-success" class="hidden mb-3 p-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg"></div>
                            <div id="order-error" class="hidden mb-3 p-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg"></div>
                            <form id="order-form" class="space-y-3">
                                <div class="flex gap-3">
                                    <div class="flex-1">
                                        <label class="block text-xs text-gray-500 mb-1">Quantité</label>
                                        <input type="number" name="quantity" min="0.1" step="0.1" required
                                            class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-xs text-gray-500 mb-1">Paiement</label>
                                        <select name="payment_method"
                                            class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                                            <option value="mvola">MVola</option>
                                            <option value="orange_money">Orange Money</option>
                                            <option value="cash">Espèces</option>
                                            <option value="bank">Virement</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Adresse de livraison</label>
                                    <input type="text" name="delivery_address"
                                        class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                                        placeholder="Lot II A 23 Antananarivo">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Notes</label>
                                    <textarea name="notes" rows="2"
                                        class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                                        placeholder="Instructions particulières…"></textarea>
                                </div>
                                <button type="submit" id="order-btn"
                                    class="w-full py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition">
                                    Confirmer la commande
                                </button>
                            </form>
                        </div>

                        <!-- Not logged in -->
                        <div id="login-prompt" class="hidden mt-6 border-t border-gray-100 pt-6 text-center">
                            <p class="text-gray-500 text-sm">Connectez-vous pour commander ce produit</p>
                            <a href="/connexion" class="inline-block mt-2 px-6 py-2 bg-green-600 text-white rounded-xl text-sm font-semibold hover:bg-green-700 transition">
                                Se connecter
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related products -->
        <div id="related-section" class="hidden mt-12">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Produits similaires</h2>
            <div id="related-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"></div>
        </div>
    </div>
</div>

<script>
let currentProduct = null;

async function loadProduct() {
    const pathParts = window.location.pathname.split('/');
    const productId = pathParts[pathParts.length - 1];

    try {
        const res = await App.get(`/products/${productId}`);
        if (!res.ok) throw new Error('Produit introuvable');
        currentProduct = await res.json();
        renderProduct(currentProduct);
        loadRelated(currentProduct.category?.slug);
    } catch (e) {
        document.getElementById('product-skeleton').innerHTML = `
            <div class="text-center py-16">
                <span class="text-5xl">😕</span>
                <p class="text-gray-600 text-lg mt-4">Produit introuvable</p>
                <a href="/produits" class="inline-block mt-4 text-green-600 font-semibold hover:text-green-700">
                    ← Retour aux produits
                </a>
            </div>`;
    }
}

function renderProduct(p) {
    document.getElementById('product-skeleton').classList.add('hidden');
    document.getElementById('product-detail').classList.remove('hidden');
    document.title = `${p.name} — Agri-Marketplace`;

    document.getElementById('prod-image').src = p.image || 'https://images.unsplash.com/photo-1595855759920-86582396756a?w=600';
    document.getElementById('prod-image').alt = p.name;
    document.getElementById('prod-category').textContent = p.category?.name || '';
    document.getElementById('prod-name').textContent = p.name;
    document.getElementById('prod-name-mg').textContent = p.name_mg || '';
    document.getElementById('prod-price').textContent = App.formatPrice(p.price);
    document.getElementById('prod-unit').textContent = `/ ${p.unit}`;
    document.getElementById('prod-description').textContent = p.description || '';
    document.getElementById('prod-stock').innerHTML = p.quantity_available > 0
        ? `✅ <strong>${p.quantity_available} ${p.unit}</strong> disponible(s)`
        : '❌ Rupture de stock';
    document.getElementById('prod-harvest').textContent = p.harvest_date
        ? `🗓️ Récolte : ${App.formatDate(p.harvest_date)}`
        : '';

    // Farmer info
    document.getElementById('farmer-name').textContent = p.farmer?.user?.name || '';
    document.getElementById('farmer-farm').textContent = p.farmer?.farm_name || '';
    document.getElementById('farmer-region').textContent = `📍 ${p.farmer?.region || ''}, ${p.farmer?.district || ''}`;

    // Auth-dependent UI
    const user = App.getUser();
    if (user && user.role !== 'farmer') {
        document.getElementById('order-section').classList.remove('hidden');
    } else if (!user) {
        document.getElementById('login-prompt').classList.remove('hidden');
    }
}

async function loadRelated(categorySlug) {
    if (!categorySlug) return;
    try {
        const res = await App.get(`/products?category=${categorySlug}&per_page=4`);
        const data = await res.json();
        const related = (data.data || []).filter(p => p.id !== currentProduct.id).slice(0, 4);
        if (!related.length) return;

        document.getElementById('related-section').classList.remove('hidden');
        document.getElementById('related-grid').innerHTML = related.map(p => `
            <a href="/produits/${p.id}" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                <img src="${p.image || 'https://images.unsplash.com/photo-1595855759920-86582396756a?w=300'}"
                     alt="${p.name}" class="w-full h-32 object-cover group-hover:scale-105 transition-transform duration-300"
                     onerror="this.src='https://images.unsplash.com/photo-1595855759920-86582396756a?w=300'">
                <div class="p-3">
                    <h4 class="font-medium text-gray-900 text-sm">${p.name}</h4>
                    <p class="text-green-700 font-bold text-sm mt-1">${App.formatPrice(p.price)} / ${p.unit}</p>
                </div>
            </a>
        `).join('');
    } catch(e) { console.error(e); }
}

// Order form submission
document.getElementById('order-form')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const form = e.target;
    const btn = document.getElementById('order-btn');
    const errorDiv = document.getElementById('order-error');
    const successDiv = document.getElementById('order-success');
    errorDiv.classList.add('hidden');
    successDiv.classList.add('hidden');
    btn.disabled = true;
    btn.textContent = 'Envoi en cours…';

    try {
        const res = await App.post('/orders', {
            items: [{ product_id: currentProduct.id, quantity: parseFloat(form.quantity.value) }],
            delivery_address: form.delivery_address.value,
            payment_method: form.payment_method.value,
            notes: form.notes.value,
        });
        const data = await res.json();
        if (res.ok) {
            successDiv.textContent = `✅ ${data.message} — Référence : ${data.order?.reference || data.order?.id}`;
            successDiv.classList.remove('hidden');
            form.reset();
        } else {
            errorDiv.textContent = data.message || 'Erreur lors de la commande';
            errorDiv.classList.remove('hidden');
        }
    } catch {
        errorDiv.textContent = 'Erreur de connexion au serveur';
        errorDiv.classList.remove('hidden');
    }
    btn.disabled = false;
    btn.textContent = 'Confirmer la commande';
});

document.addEventListener('DOMContentLoaded', loadProduct);
</script>
@endsection
