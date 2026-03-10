@extends('layouts.app')
@section('title', 'Prix du Marché')
@section('content')
<div class="bg-gradient-to-br from-green-50 to-emerald-50 min-h-screen">
    <!-- Header -->
    <div class="bg-green-700 text-white py-10">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-3xl font-bold">📊 Prix du Marché</h1>
            <p class="text-green-100 mt-2">Consultez les prix actuels des produits agricoles à Madagascar</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Filters -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Catégorie</label>
                    <select id="mp-category"
                        class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Toutes</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Région</label>
                    <select id="mp-region"
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
                <div class="flex-1 min-w-[160px]">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Date</label>
                    <input type="date" id="mp-date"
                        class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <button onclick="loadPrices(1)" class="px-6 py-2 bg-green-600 text-white rounded-xl text-sm font-semibold hover:bg-green-700 transition">
                    Filtrer
                </button>
            </div>
        </div>

        <!-- Price table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-green-50 border-b border-green-100">
                        <tr>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-green-800">Produit</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-green-800">Catégorie</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-green-800">Région</th>
                            <th class="text-right px-6 py-4 text-sm font-semibold text-green-800">Prix min</th>
                            <th class="text-right px-6 py-4 text-sm font-semibold text-green-800">Prix moy</th>
                            <th class="text-right px-6 py-4 text-sm font-semibold text-green-800">Prix max</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-green-800">Unité</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-green-800">Date</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-green-800">Source</th>
                        </tr>
                    </thead>
                    <tbody id="prices-body">
                        <!-- Skeleton rows -->
                        @for($i = 0; $i < 5; $i++)
                        <tr class="animate-pulse border-b border-gray-50">
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-24"></div></td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-20"></div></td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-24"></div></td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-16 ml-auto"></div></td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-16 ml-auto"></div></td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-16 ml-auto"></div></td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-12"></div></td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-20"></div></td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-16"></div></td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div id="prices-pagination" class="flex justify-center gap-2 mt-6"></div>

        <!-- Info box -->
        <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-2xl p-6">
            <h3 class="font-semibold text-yellow-800 mb-2">📱 Accès USSD</h3>
            <p class="text-sm text-yellow-700">
                Consultez les prix directement depuis votre téléphone en composant <strong>*123#</strong>.
                Sélectionnez l'option « Prix du marché » pour voir les prix actualisés sans connexion internet.
            </p>
        </div>
    </div>
</div>

<script>
async function loadCategories() {
    try {
        const res = await App.get('/categories');
        const cats = await res.json();
        const sel = document.getElementById('mp-category');
        cats.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.slug;
            opt.textContent = c.name;
            sel.appendChild(opt);
        });
    } catch(e) { console.error(e); }
}

async function loadPrices(page = 1) {
    const category = document.getElementById('mp-category').value;
    const region = document.getElementById('mp-region').value;
    const date = document.getElementById('mp-date').value;
    const params = new URLSearchParams({ page });
    if (category) params.set('category', category);
    if (region) params.set('region', region);
    if (date) params.set('date', date);

    try {
        const res = await App.get(`/market-prices?${params}`);
        const data = await res.json();
        renderPrices(data.data || []);
        renderPagination(data);
    } catch (e) {
        console.error(e);
        document.getElementById('prices-body').innerHTML =
            '<tr><td colspan="9" class="px-6 py-12 text-center text-red-500">Erreur de chargement</td></tr>';
    }
}

function renderPrices(prices) {
    const body = document.getElementById('prices-body');
    if (!prices.length) {
        body.innerHTML = `
            <tr><td colspan="9" class="px-6 py-12 text-center text-gray-400">
                <span class="text-4xl block mb-2">📭</span>
                Aucun prix disponible pour ces critères
            </td></tr>`;
        return;
    }
    body.innerHTML = prices.map((p, i) => `
        <tr class="${i % 2 === 0 ? 'bg-white' : 'bg-gray-50'} border-b border-gray-50 hover:bg-green-50 transition">
            <td class="px-6 py-3 font-medium text-gray-900 text-sm">${p.product_name}</td>
            <td class="px-6 py-3 text-sm">
                <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded-full">${p.category?.name || '-'}</span>
            </td>
            <td class="px-6 py-3 text-sm text-gray-600">📍 ${p.region}</td>
            <td class="px-6 py-3 text-sm text-right text-gray-600">${App.formatPrice(p.min_price)}</td>
            <td class="px-6 py-3 text-sm text-right font-bold text-green-700">${App.formatPrice(p.avg_price)}</td>
            <td class="px-6 py-3 text-sm text-right text-gray-600">${App.formatPrice(p.max_price)}</td>
            <td class="px-6 py-3 text-sm text-gray-500">${p.unit}</td>
            <td class="px-6 py-3 text-sm text-gray-500">${App.formatDate(p.price_date)}</td>
            <td class="px-6 py-3 text-xs text-gray-400">${p.source || '-'}</td>
        </tr>
    `).join('');
}

function renderPagination(data) {
    const pag = document.getElementById('prices-pagination');
    if (data.last_page <= 1) { pag.innerHTML = ''; return; }
    pag.innerHTML = Array.from({length: data.last_page}, (_, i) => i + 1).map(pg => `
        <button onclick="loadPrices(${pg})"
            class="px-3 py-1 rounded-lg text-sm font-medium transition
            ${pg === data.current_page ? 'bg-green-600 text-white' : 'bg-white text-gray-600 hover:bg-green-50 border border-gray-200'}">
            ${pg}
        </button>
    `).join('');
}

document.addEventListener('DOMContentLoaded', () => {
    loadCategories();
    loadPrices(1);
});
</script>
@endsection
