<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Agri-Marketplace') — Tsena Mpamboly</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans min-h-screen flex flex-col">

    {{-- ═══════════ NAVBAR ═══════════ --}}
    <nav class="bg-green-700 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="/" class="flex items-center gap-2">
                    <span class="text-2xl">🌾</span>
                    <span class="text-white font-bold text-xl tracking-tight">Agri-Marketplace</span>
                </a>
                <div class="hidden md:flex items-center gap-1">
                    <a href="/" class="px-3 py-2 rounded-md text-sm font-medium text-green-100 hover:text-white hover:bg-green-600 transition">Accueil</a>
                    <a href="/produits" class="px-3 py-2 rounded-md text-sm font-medium text-green-100 hover:text-white hover:bg-green-600 transition">Produits</a>
                    <a href="/prix-marche" class="px-3 py-2 rounded-md text-sm font-medium text-green-100 hover:text-white hover:bg-green-600 transition">Prix du marché</a>
                    <a href="/a-propos" class="px-3 py-2 rounded-md text-sm font-medium text-green-100 hover:text-white hover:bg-green-600 transition">À propos</a>
                </div>
                <div id="auth-links" class="hidden md:flex items-center gap-3">
                    <a href="/connexion" class="px-4 py-2 text-sm font-medium text-white border border-green-400 rounded-lg hover:bg-green-600 transition">Connexion</a>
                    <a href="/inscription" class="px-4 py-2 text-sm font-medium bg-white text-green-700 rounded-lg hover:bg-green-50 transition font-semibold">Inscription</a>
                </div>
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="md:hidden text-white p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-green-800 pb-4 px-4">
            <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-green-100 hover:text-white hover:bg-green-600">Accueil</a>
            <a href="/produits" class="block px-3 py-2 rounded-md text-base font-medium text-green-100 hover:text-white hover:bg-green-600">Produits</a>
            <a href="/prix-marche" class="block px-3 py-2 rounded-md text-base font-medium text-green-100 hover:text-white hover:bg-green-600">Prix du marché</a>
            <a href="/a-propos" class="block px-3 py-2 rounded-md text-base font-medium text-green-100 hover:text-white hover:bg-green-600">À propos</a>
            <div id="auth-links-mobile" class="mt-4 flex flex-col gap-2">
                <a href="/connexion" class="block text-center px-4 py-2 text-sm font-medium text-white border border-green-400 rounded-lg">Connexion</a>
                <a href="/inscription" class="block text-center px-4 py-2 text-sm font-medium bg-white text-green-700 rounded-lg font-semibold">Inscription</a>
            </div>
        </div>
    </nav>

    <main class="flex-1">@yield('content')</main>

    {{-- ═══════════ FOOTER ═══════════ --}}
    <footer class="bg-green-900 text-green-100 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-4"><span class="text-2xl">🌾</span><span class="text-white font-bold text-xl">Agri-Marketplace</span></div>
                    <p class="text-green-300 text-sm leading-relaxed max-w-md">Connecter les agriculteurs malgaches aux acheteurs. Plateforme inclusive avec support USSD pour les zones rurales.</p>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-3">Navigation</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/produits" class="text-green-300 hover:text-white transition">Produits</a></li>
                        <li><a href="/prix-marche" class="text-green-300 hover:text-white transition">Prix du marché</a></li>
                        <li><a href="/a-propos" class="text-green-300 hover:text-white transition">À propos</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-3">Contact</h3>
                    <ul class="space-y-2 text-sm text-green-300">
                        <li>📞 USSD : *123#</li>
                        <li>📧 contact@agri-marketplace.mg</li>
                        <li>📍 Antananarivo, Madagascar</li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-green-800 text-center text-sm text-green-400">© {{ date('Y') }} Agri-Marketplace Madagascar. Tous droits réservés.</div>
        </div>
    </footer>
</body>
</html>
