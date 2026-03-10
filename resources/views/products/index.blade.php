@extends('layouts.app')
@section('title', 'Nos Produits')
@section('content')
<div class="bg-gradient-to-br from-green-50 to-emerald-50 min-h-screen">
    <!-- Header -->
    <div class="bg-green-700 text-white py-10">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-3xl font-bold">🛒 Nos Produits</h1>
            <p class="text-green-100 mt-2">Produits frais directement des agriculteurs malgaches</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar filters -->
            <aside class="w-full lg:w-72 shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24 space-y-6">
                    <h2 class="font-semibold text-gray-900 text-lg">Filtres</h2>
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Rechercher</label>
                        <input type="text" id="filter-search" placeholder="Nom du produit…"
                            class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Catégorie</label>
                        <select id="filter-category"
                            class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Toutes</option>
                        </select>
                    </div>
                    <!-- Region -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Région</label>
                        <select id="filter-region"
                            class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Toutes</option>
                            <option value="Vakinankaratra">Vakinankaratra</option>
                            <option value="Itasy">Itasy</option>
                            <option value="Alaotra-Mangoro">Alaotra-Mangoro</option>
                            <option value="SAVA">SAVA</option>
                            <option value="Atsinanana">Atsinanana</option>
                            <option value="Analamanga">Analamanga</option>
                            <option value="Boeny">Boeny</option>
                            <option value="Atsimo-Andrefana">Atsimo-Andrefana</option>
                        </select>
                    </div>
                    <button onclick="applyFilters(1)" class="w-full py-2 bg-green-600 text-white rounded-xl text-sm font-semibold hover:bg-green-700 transition">
                        Appliquer les filtres
                    </button>
                    <button onclick="resetFilters()" class="w-full py-2 bg-gray-100 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-200 transition">
                        Réinitialiser
                    </button>
                </div>
            </aside>

            <!-- Product grid -->
            <main class="flex-1">
                <div class="flex items-center justify-between mb-6">
                    <p id="results-count" class="text-sm text-gray-500"></p>
                    <div id="pagination-top" class="flex gap-2"></div>
                </div>

                <div id="products-grid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    <!-- Skeleton loaders -->
                    @for($i = 0; $i < 6; $i++)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 animate-pulse">
                        <div class="h-48 bg-gray-200 rounded-t-2xl"></div>
                        <div class="p-4 space-y-3">
                            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                            <div class="h-3 bg-gray-200 rounded w-1/2"></div>
                            <div class="h-6 bg-gray-200 rounded w-1/3"></div>
                        </div>
                    </div>
                    @endfor
                </div>

                <div id="pagination-bottom" class="flex justify-center gap-2 mt-8"></div>
            </main>
        </div>
    </div>
</div>

<script>
let currentPage = 1;

async function loadCategories() {
    try {
        const res = await App.get('/categories');
        const cats = await res.json();
        const sel = document.getElementById('filter-category');
        cats.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.slug;
            opt.textContent = c.name;
            sel.appendChild(opt);
        });
    } catch(e) { console.error(e); }
}

async function applyFilters(page = 1) {
    currentPage = page;
    const search = document.getElementById('filter-search').value;
    const category = document.getElementById('filter-category').value;
    const region = document.getElementById('filter-region').value;
    const params = new URLSearchParams({ page });
    if (search) params.set('search', search);
    if (category) params.set('category', category);
    if (region) params.set('region', region);

    try {
        const res = await App.get(`/products?${params}`);
        const data = await res.json();
        renderProducts(data.data);
        renderPagination(data);
        document.getElementById('results-count').textContent = `${data.total} produit(s) trouvé(s)`;
    } catch (e) {
        console.error(e);
        document.getElementById('products-grid').innerHTML =
            '<p class="col-span-full text-center text-red-500 py-12">Erreur de chargement des produits</p>';
    }
}

function resetFilters() {
    document.getElementById('filter-search').value = '';
    document.getElementById('filter-category').value = '';
    document.getElementById('filter-region').value = '';
    applyFilters(1);
}

function renderProducts(products) {
    const grid = document.getElementById('products-grid');
    if (!products.length) {
        grid.innerHTML = `
            <div class="col-span-full text-center py-16">
                <span class="text-5xl">🔍</span>
                <p class="text-gray-500 mt-4 text-lg">Aucun produit trouvé</p>
                <p class="text-gray-400 text-sm mt-1">Essayez de modifier vos filtres</p>
            </div>`;
        return;
    }
    grid.innerHTML = products.map(p => `
        <a href="/produits/${p.id}" class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all group overflow-hidden">
            <div class="relative h-48 overflow-hidden">
                <img src="${p.image || 'https://images.unsplash.com/photo-1595855759920-86582396756a?w=400'}"
                     alt="${p.name}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                     onerror="this.src='https://images.unsplash.com/photo-1595855759920-86582396756a?w=400'">
                <span class="absolute top-3 left-3 bg-green-600 text-white text-xs font-medium px-3 py-1 rounded-full">
                    ${p.category?.name || ''}
                </span>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 group-hover:text-green-700 transition">${p.name}</h3>
                ${p.name_mg ? `<p class="text-xs text-gray-400 italic">${p.name_mg}</p>` : ''}
                <div class="flex items-center justify-between mt-3">
                    <span class="text-green-700 font-bold text-lg">${App.formatPrice(p.price)}</span>
                    <span class="text-xs text-gray-400">/ ${p.unit}</span>
                </div>
                <div class="flex items-center gap-2 mt-2 text-xs text-gray-500">
                    <span>📍 ${p.farmer?.region || ''}</span>
                    <span>•</span>
                    <span>🧑‍🌾 ${p.farmer?.user?.name || ''}</span>
                </div>
                <p class="text-xs mt-2 ${p.quantity_available > 0 ? 'text-green-600' : 'text-red-500'}">
                    ${p.quantity_available > 0 ? `✅ ${p.quantity_available} ${p.unit} dispo` : '❌ Rupture de stock'}
                </p>
            </div>
        </a>
    `).join('');
}

function renderPagination(data) {
    if (data.last_page <= 1) {
        document.getElementById('pagination-bottom').innerHTML = '';
        document.getElementById('pagination-top').innerHTML = '';
        return;
    }
    const html = Array.from({length: data.last_page}, (_, i) => i + 1).map(pg => `
        <button onclick="applyFilters(${pg})"
            class="px-3 py-1 rounded-lg text-sm font-medium transition
            ${pg === data.current_page ? 'bg-green-600 text-white' : 'bg-white text-gray-600 hover:bg-green-50 border border-gray-200'}">
            ${pg}
        </button>
    `).join('');
    document.getElementById('pagination-bottom').innerHTML = html;
    document.getElementById('pagination-top').innerHTML = html;
}

// Init
document.addEventListener('DOMContentLoaded', () => {
    loadCategories();
    // Check URL params
    const urlP = new URLSearchParams(window.location.search);
    if (urlP.get('category')) document.getElementById('filter-category').value = urlP.get('category');
    if (urlP.get('region')) document.getElementById('filter-region').value = urlP.get('region');
    if (urlP.get('search')) document.getElementById('filter-search').value = urlP.get('search');
    applyFilters(1);
});

// Enter key triggers search
document.getElementById('filter-search')?.addEventListener('keypress', e => {
    if (e.key === 'Enter') applyFilters(1);
});
</script>
@endsection
