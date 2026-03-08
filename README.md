# 🌾 Agri-Marketplace Madagascar

API REST pour connecter agriculteurs et acheteurs à Madagascar, avec support USSD pour les zones rurales.

## Stack technique

- **Backend** : Laravel 12 / PHP 8.2
- **Base de données** : MySQL
- **Auth** : Laravel Sanctum (tokens API)
- **CI/CD** : GitHub Actions

## Fonctionnalités

- Inscription / Connexion (Sanctum)
- Gestion des produits (CRUD agriculteur)
- Catégories de produits
- Commandes (acheteur → agriculteur)
- Prix du marché en temps réel
- Interface USSD pour zones sans internet
- Notifications SMS

## Installation locale

git clone https://github.com/TON_USERNAME/agri-marketplace.git
cd agri-marketplace
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve

## Tests

php artisan test

## Endpoints API

| Méthode | Route                  | Description              |
|---------|------------------------|--------------------------|
| POST    | /api/register          | Inscription              |
| POST    | /api/login             | Connexion                |
| GET     | /api/profile           | Profil utilisateur       |
| GET     | /api/products          | Liste des produits       |
| POST    | /api/products          | Créer un produit         |
| GET     | /api/categories        | Liste des catégories     |
| POST    | /api/orders            | Passer une commande      |
| POST    | /api/ussd              | Point d'entrée USSD      |

## Auteur

Mirado — Projet portfolio 2026