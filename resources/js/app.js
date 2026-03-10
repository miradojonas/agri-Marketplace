import './bootstrap';

// ═══════════════════════════════════════════════
// Agri-Marketplace — App Module
// ═══════════════════════════════════════════════

window.App = {
    API: '/api',

    // ── Auth ──
    getToken()  { return localStorage.getItem('token'); },
    getUser()   { try { return JSON.parse(localStorage.getItem('user')); } catch { return null; } },
    isLogged()  { return !!this.getToken(); },
    isFarmer()  { return this.getUser()?.role === 'farmer'; },

    setAuth(token, user) {
        localStorage.setItem('token', token);
        localStorage.setItem('user', JSON.stringify(user));
    },

    clearAuth() {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
    },

    // ── API calls ──
    async api(endpoint, options = {}) {
        const headers = { 'Accept': 'application/json', 'Content-Type': 'application/json' };
        const token = this.getToken();
        if (token) headers['Authorization'] = `Bearer ${token}`;

        const res = await fetch(this.API + endpoint, { ...options, headers });

        if (res.status === 401 && !endpoint.startsWith('/auth')) {
            this.clearAuth();
            if (!window.location.pathname.includes('connexion')) {
                window.location.href = '/connexion';
            }
        }

        return res;
    },

    async get(endpoint)        { return this.api(endpoint); },
    async post(endpoint, data) { return this.api(endpoint, { method: 'POST', body: JSON.stringify(data) }); },
    async put(endpoint, data)  { return this.api(endpoint, { method: 'PUT', body: JSON.stringify(data) }); },
    async del(endpoint)        { return this.api(endpoint, { method: 'DELETE' }); },

    // ── Formatage ──
    formatPrice(price) {
        return new Intl.NumberFormat('fr-MG').format(Math.round(price)) + ' Ar';
    },

    formatDate(dateStr) {
        if (!dateStr) return '—';
        return new Date(dateStr).toLocaleDateString('fr-FR', { day: '2-digit', month: 'short', year: 'numeric' });
    },

    // ── UI Navbar update ──
    updateNavbar() {
        const authLinks     = document.getElementById('auth-links');
        const authLinksMob  = document.getElementById('auth-links-mobile');
        if (!authLinks) return;

        if (this.isLogged()) {
            const user = this.getUser();
            const dashLink = this.isFarmer() ? '/dashboard' : '/mes-commandes';
            const html = `
                <a href="${dashLink}" class="px-3 py-2 rounded-md text-sm font-medium text-green-100 hover:text-white hover:bg-green-600 transition">
                    👤 ${user.name}
                </a>
                <button onclick="App.logout()" class="px-4 py-2 text-sm font-medium text-white border border-green-400 rounded-lg hover:bg-green-600 transition">
                    Déconnexion
                </button>
            `;
            authLinks.innerHTML = html;
            if (authLinksMob) authLinksMob.innerHTML = `
                <a href="${dashLink}" class="block text-center px-4 py-2 text-sm font-medium text-white border border-green-400 rounded-lg">👤 ${user.name}</a>
                <button onclick="App.logout()" class="w-full text-center px-4 py-2 text-sm font-medium bg-white text-green-700 rounded-lg font-semibold">Déconnexion</button>
            `;
        }
    },

    async logout() {
        await this.post('/auth/logout', {});
        this.clearAuth();
        window.location.href = '/';
    },
};

// Auto-update navbar on page load
document.addEventListener('DOMContentLoaded', () => App.updateNavbar());