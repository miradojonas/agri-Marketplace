@extends('layouts.app')
@section('title', 'Inscription')
@section('content')
<div class="min-h-[80vh] flex items-center justify-center bg-gradient-to-br from-green-50 to-emerald-50 px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <span class="text-5xl">🌱</span>
            <h1 class="text-2xl font-bold text-gray-900 mt-4">Créer un compte</h1>
            <p class="text-gray-500 mt-1">Rejoignez Agri-Marketplace aujourd'hui</p>
        </div>
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div id="register-error" class="hidden mb-4 p-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg"></div>
            <form id="register-form" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                    <input type="text" name="name" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="Rakoto Jean">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                    <input type="tel" name="phone" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="+261340000001">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-gray-400">(optionnel)</span></label>
                    <input type="email" name="email"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="rakoto@example.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Je suis un…</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-3 p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-green-400 transition has-[:checked]:border-green-600 has-[:checked]:bg-green-50">
                            <input type="radio" name="role" value="farmer" class="accent-green-600" checked>
                            <span class="text-sm font-medium">🧑‍🌾 Agriculteur</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-green-400 transition has-[:checked]:border-green-600 has-[:checked]:bg-green-50">
                            <input type="radio" name="role" value="buyer" class="accent-green-600">
                            <span class="text-sm font-medium">🛒 Acheteur</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                    <input type="password" name="password" required minlength="6"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="••••••••">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" required minlength="6"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="••••••••">
                </div>
                <button type="submit" id="register-btn"
                    class="w-full py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-all shadow-sm hover:shadow-md">
                    Créer mon compte
                </button>
            </form>
            <div class="mt-6 text-center text-sm text-gray-500">
                Déjà inscrit ? <a href="/connexion" class="text-green-600 font-semibold hover:text-green-700">Connectez-vous</a>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('register-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const form = e.target;
    const btn = document.getElementById('register-btn');
    const errorDiv = document.getElementById('register-error');
    errorDiv.classList.add('hidden');
    btn.disabled = true;
    btn.textContent = 'Inscription en cours…';

    const body = {
        name: form.name.value,
        phone: form.phone.value,
        role: form.role.value,
        password: form.password.value,
        password_confirmation: form.password_confirmation.value,
    };
    if (form.email.value) body.email = form.email.value;

    try {
        const res = await App.post('/auth/register', body);
        const data = await res.json();
        if (res.ok) {
            App.setAuth(data.token, data.user);
            window.location.href = data.user.role === 'farmer' ? '/dashboard' : '/produits';
        } else {
            const msgs = data.errors ? Object.values(data.errors).flat().join('<br>') : data.message;
            errorDiv.innerHTML = msgs;
            errorDiv.classList.remove('hidden');
        }
    } catch {
        errorDiv.textContent = 'Erreur de connexion au serveur';
        errorDiv.classList.remove('hidden');
    }
    btn.disabled = false;
    btn.textContent = 'Créer mon compte';
});
</script>
@endsection
