@extends('layouts.app')
@section('title', 'Dashboard Agriculteur')
@section('content')
<div class="bg-gradient-to-br from-green-50 to-emerald-50 min-h-screen">
    <!-- Header -->
    <div class="bg-green-700 text-white py-8">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-2xl font-bold">🧑‍🌾 Tableau de bord</h1>
            <p id="welcome-msg" class="text-green-100 mt-1"></p>
        </div>
    </div>

    <!-- Auth check -->
    <div id="auth-required" class="hidden max-w-lg mx-auto px-4 py-20 text-center">
        <span class="text-5xl">🔒</span>
        <p class="text-gray-600 text-lg mt-4">Connectez-vous pour accéder à votre tableau de bord</p>
        <a href="/connexion" class="inline-block mt-4 px-6 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition">Se connecter</a>
    </div>

    <div id="dashboard-content" class="hidden max-w-7xl mx-auto px-4 py-8 space-y-8">
        <!-- Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                <p class="text-3xl font-bold text-green-700" id="stat-products">-</p>
                <p class="text-sm text-gray-500 mt-1">Produits</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                <p class="text-3xl font-bold text-blue-600" id="stat-active">-</p>
                <p class="text-sm text-gray-500 mt-1">Actifs</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                <p class="text-3xl font-bold text-orange-600" id="stat-orders">-</p>
                <p class="text-sm text-gray-500 mt-1">Commandes</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                <p class="text-3xl font-bold text-emerald-600" id="stat-revenue">-</p>
                <p class="text-sm text-gray-500 mt-1">Revenus (Ar)</p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex gap-2 border-b border-gray-200 pb-0">
            <button onclick="showTab('products')" id="tab-products"
                class="px-4 py-2 text-sm font-semibold border-b-2 border-green-600 text-green-700 -mb-px">
                Mes produits
            </button>
            <button onclick="showTab('orders')" id="tab-orders"
                class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 -mb-px border-b-2 border-transparent">
                Commandes reçues
            </button>
            <button onclick="showTab('add-product')" id="tab-add-product"
                class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 -mb-px border-b-2 border-transparent">
                ➕ Nouveau produit
            </button>
        </div>

        <!-- Tab: Products -->
        <div id="panel-products">
            <div id="my-products-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"></div>
            <p id="no-products" class="hidden text-center text-gray-400 py-12">Aucun produit. Ajoutez votre premier produit !</p>
        </div>

        <!-- Tab: Orders -->
        <div id="panel-orders" class="hidden">
            <div id="my-orders-list" class="space-y-3"></div>
            <p id="no-orders" class="hidden text-center text-gray-400 py-12">Aucune commande reçue pour le moment</p>
        </div>

        <!-- Tab: Add Product -->
        <div id="panel-add-product" class="hidden">
            <div class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Ajouter un nouveau produit</h3>
                <div id="add-product-success" class="hidden mb-4 p-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg"></div>
                <div id="add-product-error" class="hidden mb-4 p-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg"></div>
                <form id="add-product-form" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom du produit *</label>
                            <input type="text" name="name" required
                                class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="Riz blanc premium">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom malgache</label>
                            <input type="text" name="name_mg"
                                class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="Vary fotsy">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie *</label>
                        <select name="category_id" required id="product-category-select"
                            class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Choisir…</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Description de votre produit…"></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prix (Ar) *</label>
                            <input type="number" name="price" required min="0"
                                class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="2500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Unité *</label>
                            <select name="unit" required
                                class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="kg">Kilogramme (kg)</option>
                                <option value="tonne">Tonne</option>
                                <option value="litre">Litre</option>
                                <option value="pièce">Pièce</option>
                                <option value="botte">Botte</option>
                                <option value="sac">Sac</option>
                                <option value="panier">Panier</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantité dispo *</label>
                            <input type="number" name="quantity_available" required min="0"
                                class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date de récolte</label>
                        <input type="date" name="harvest_date"
                            class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <button type="submit" id="add-product-btn"
                        class="w-full py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition">
                        Ajouter le produit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
async function initDashboard() {
    const user = JSON.parse(localStorage.getItem('user') || 'null');
    const token = App.getToken();

    if (!token || !user) {
        document.getElementById('auth-required').classList.remove('hidden');
        return;
    }

    document.getElementById('dashboard-content').classList.remove('hidden');
    document.getElementById('welcome-msg').textContent = `Bienvenue, ${user.name}`;

    // If buyer, show orders differently
    if (user.role === 'buyer') {
        document.getElementById('tab-add-product').classList.add('hidden');
        document.getElementById('tab-products').textContent = 'Mes commandes';
        loadBuyerOrders();
        return;
    }

    // Farmer dashboard
    try {
        const res = await App.get('/farmer/dashboard');
        if (res.status === 401) {
            App.clearAuth();
            window.location.href = '/connexion';
            return;
        }
        const data = await res.json();

        document.getElementById('stat-products').textContent = data.total_products;
        document.getElementById('stat-active').textContent = data.active_products;
        document.getElementById('stat-orders').textContent = data.total_orders;
        document.getElementById('stat-revenue').textContent = new Intl.NumberFormat('fr-FR').format(data.total_revenue || 0);

        renderMyProducts(data.recent_products || []);
    } catch (e) {
        console.error(e);
    }

    loadCategories();
    loadFarmerOrders();
}

function showTab(tab) {
    ['products', 'orders', 'add-product'].forEach(t => {
        document.getElementById(`panel-${t}`).classList.toggle('hidden', t !== tab);
        const btn = document.getElementById(`tab-${t}`);
        if (t === tab) {
            btn.classList.add('border-green-600', 'text-green-700', 'font-semibold');
            btn.classList.remove('border-transparent', 'text-gray-500');
        } else {
            btn.classList.remove('border-green-600', 'text-green-700', 'font-semibold');
            btn.classList.add('border-transparent', 'text-gray-500');
        }
    });
}

function renderMyProducts(products) {
    const list = document.getElementById('my-products-list');
    const noProducts = document.getElementById('no-products');
    if (!products.length) {
        list.innerHTML = '';
        noProducts.classList.remove('hidden');
        return;
    }
    noProducts.classList.add('hidden');
    list.innerHTML = products.map(p => `
        <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm flex justify-between items-start">
            <div>
                <h4 class="font-semibold text-gray-900">${p.name}</h4>
                <p class="text-sm text-gray-500">${p.category?.name || ''} — ${App.formatPrice(p.price)} / ${p.unit}</p>
                <span class="inline-block mt-1 text-xs px-2 py-0.5 rounded-full font-medium
                    ${p.status === 'available' ? 'bg-green-100 text-green-700' : p.status === 'out_of_stock' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700'}">
                    ${p.status === 'available' ? 'Disponible' : p.status === 'out_of_stock' ? 'Épuisé' : 'En attente'}
                </span>
                <span class="text-xs text-gray-400 ml-2">${p.quantity_available} ${p.unit}</span>
            </div>
            <div class="flex gap-2">
                <button onclick="deleteProduct(${p.id})" class="text-xs px-3 py-1 text-red-600 hover:bg-red-50 rounded-lg transition" title="Supprimer">🗑️</button>
            </div>
        </div>
    `).join('');
}

async function loadFarmerOrders() {
    try {
        const res = await App.get('/farmer/orders');
        const data = await res.json();
        renderOrders(data.data || []);
    } catch(e) { console.error(e); }
}

async function loadBuyerOrders() {
    try {
        const res = await App.get('/orders');
        const data = await res.json();
        const list = document.getElementById('my-products-list');
        const noProducts = document.getElementById('no-products');
        if (!data.data?.length) {
            list.innerHTML = '';
            noProducts.textContent = 'Aucune commande passée';
            noProducts.classList.remove('hidden');
            return;
        }
        noProducts.classList.add('hidden');
        list.innerHTML = data.data.map(o => `
            <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-semibold text-gray-900">#${o.reference || o.id}</p>
                        <p class="text-sm text-gray-500">${App.formatDate(o.created_at)}</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full font-medium
                        ${o.status === 'delivered' ? 'bg-green-100 text-green-700' : o.status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700'}">
                        ${o.status}
                    </span>
                </div>
                <p class="text-green-700 font-bold mt-2">${App.formatPrice(o.total_amount)}</p>
                <p class="text-xs text-gray-400 mt-1">${o.items?.length || 0} article(s)</p>
            </div>
        `).join('');
    } catch(e) { console.error(e); }
}

function renderOrders(orders) {
    const list = document.getElementById('my-orders-list');
    const noOrders = document.getElementById('no-orders');
    if (!orders.length) {
        list.innerHTML = '';
        noOrders.classList.remove('hidden');
        return;
    }
    noOrders.classList.add('hidden');
    list.innerHTML = orders.map(item => `
        <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-semibold text-gray-900">${item.product?.name || 'Produit'}</p>
                    <p class="text-sm text-gray-500">Quantité: ${item.quantity} — ${App.formatPrice(item.subtotal)}</p>
                    <p class="text-xs text-gray-400 mt-1">Acheteur: ${item.order?.buyer?.name || '-'}</p>
                </div>
                <span class="text-xs px-2 py-1 rounded-full font-medium
                    ${item.order?.status === 'delivered' ? 'bg-green-100 text-green-700' : item.order?.status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700'}">
                    ${item.order?.status || 'pending'}
                </span>
            </div>
        </div>
    `).join('');
}

async function deleteProduct(id) {
    if (!confirm('Supprimer ce produit ?')) return;
    try {
        const res = await App.del(`/products/${id}`);
        if (res.ok) {
            // Refresh
            initDashboard();
        } else {
            const data = await res.json();
            alert(data.message || 'Erreur');
        }
    } catch { alert('Erreur de connexion'); }
}

async function loadCategories() {
    try {
        const res = await App.get('/categories');
        const cats = await res.json();
        const sel = document.getElementById('product-category-select');
        cats.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.id;
            opt.textContent = c.name;
            sel.appendChild(opt);
        });
    } catch(e) { console.error(e); }
}

// Add product form
document.getElementById('add-product-form')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const form = e.target;
    const btn = document.getElementById('add-product-btn');
    const errorDiv = document.getElementById('add-product-error');
    const successDiv = document.getElementById('add-product-success');
    errorDiv.classList.add('hidden');
    successDiv.classList.add('hidden');
    btn.disabled = true;
    btn.textContent = 'Envoi en cours…';

    const body = {
        category_id: parseInt(form.category_id.value),
        name: form.name.value,
        name_mg: form.name_mg.value || null,
        description: form.description.value || null,
        price: parseFloat(form.price.value),
        unit: form.unit.value,
        quantity_available: parseFloat(form.quantity_available.value),
        harvest_date: form.harvest_date.value || null,
    };

    try {
        const res = await App.post('/products', body);
        const data = await res.json();
        if (res.ok) {
            successDiv.textContent = `✅ ${data.message}`;
            successDiv.classList.remove('hidden');
            form.reset();
            initDashboard();
        } else {
            const msgs = data.errors ? Object.values(data.errors).flat().join(', ') : data.message;
            errorDiv.textContent = msgs;
            errorDiv.classList.remove('hidden');
        }
    } catch {
        errorDiv.textContent = 'Erreur de connexion au serveur';
        errorDiv.classList.remove('hidden');
    }
    btn.disabled = false;
    btn.textContent = 'Ajouter le produit';
});

document.addEventListener('DOMContentLoaded', initDashboard);
</script>
@endsection
