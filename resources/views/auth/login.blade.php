@extends('layouts.app')
@section('title', 'Connexion')
@section('content')
<div class="min-h-[80vh] flex items-center justify-center bg-gradient-to-br from-green-50 to-emerald-50 px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <span class="text-5xl">🌾</span>
            <h1 class="text-2xl font-bold text-gray-900 mt-4">Connexion</h1>
            <p class="text-gray-500 mt-1">Accédez à votre compte Agri-Marketplace</p>
        </div>
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div id="login-error" class="hidden mb-4 p-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg"></div>
            <form id="login-form" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                    <input type="tel" name="phone" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="+261340000002">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="••••••••">
                </div>
                <button type="submit" id="login-btn"
                    class="w-full py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-all shadow-sm hover:shadow-md">
                    Se connecter
                </button>
            </form>
            <div class="mt-6 text-center text-sm text-gray-500">
                Pas encore de compte ? <a href="/inscription" class="text-green-600 font-semibold hover:text-green-700">Inscrivez-vous</a>
            </div>
        </div>
        <p class="text-center text-xs text-gray-400 mt-6">📱 Accès USSD disponible : composez <strong>*123#</strong></p>
    </div>
</div>
<script>
document.getElementById('login-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const form = e.target;
    const btn = document.getElementById('login-btn');
    const errorDiv = document.getElementById('login-error');
    errorDiv.classList.add('hidden');
    btn.disabled = true;
    btn.textContent = 'Connexion en cours…';

    try {
        const res = await App.post('/auth/login', {
            phone: form.phone.value,
            password: form.password.value,
        });
        const data = await res.json();
        if (res.ok) {
            App.setAuth(data.token, data.user);
            window.location.href = data.user.role === 'farmer' ? '/dashboard' : '/produits';
        } else {
            errorDiv.textContent = data.message || data.errors?.phone?.[0] || 'Identifiants incorrects';
            errorDiv.classList.remove('hidden');
        }
    } catch {
        errorDiv.textContent = 'Erreur de connexion au serveur';
        errorDiv.classList.remove('hidden');
    }
    btn.disabled = false;
    btn.textContent = 'Se connecter';
});
</script>
@endsection
