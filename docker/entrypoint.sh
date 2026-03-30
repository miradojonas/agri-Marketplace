#!/bin/sh
set -e

# Set Nginx port from environment variable
export PORT=${PORT:-80}
sed -i "s/__PORT__/$PORT/g" /etc/nginx/http.d/default.conf

echo "🌾 Agri-Marketplace — Démarrage du conteneur sur le port $PORT…"

cd /var/www/html

# Ensure .env file exists (Railway injects env vars at runtime, not via .env)
if [ ! -f .env ]; then
    echo "📄 Création du fichier .env…"
    touch .env
fi

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    echo "⚙️  Génération de la clé d'application…"
    php artisan key:generate --force
fi

# Wait for DB to be ready
if [ -n "$DB_HOST" ]; then
    if [ "$DB_CONNECTION" = "pgsql" ]; then
        echo "⏳ Attente de PostgreSQL ($DB_HOST:${DB_PORT:-5432})…"
        export PGPASSWORD="$DB_PASSWORD"
        max_tries=30
        counter=0
        until psql -h "$DB_HOST" -p "${DB_PORT:-5432}" -U "$DB_USERNAME" -d "$DB_DATABASE" -c '\q' > /dev/null 2>&1; do
            counter=$((counter + 1))
            if [ $counter -ge $max_tries ]; then
                echo "❌ PostgreSQL non disponible après ${max_tries} tentatives. Abandon."
                exit 1
            fi
            echo "   Tentative $counter/$max_tries…"
            sleep 2
        done
        echo "✅ PostgreSQL est prêt !"
    elif [ "$DB_CONNECTION" = "mysql" ]; then
        echo "⏳ Attente de MySQL ($DB_HOST:${DB_PORT:-3306})…"
        max_tries=30
        counter=0
        until mysql -h "$DB_HOST" -P "${DB_PORT:-3306}" -u "$DB_USERNAME" -p"$DB_PASSWORD" -e "SELECT 1" > /dev/null 2>&1; do
            counter=$((counter + 1))
            if [ $counter -ge $max_tries ]; then
                echo "❌ MySQL non disponible après ${max_tries} tentatives. Abandon."
                exit 1
            fi
            echo "   Tentative $counter/$max_tries…"
            sleep 2
        done
        echo "✅ MySQL est prêt !"
    fi
fi

# Run migrations
echo "🗄️  Exécution des migrations…"
php artisan migrate --force

# Cache configuration for production
echo "🚀 Optimisation pour production…"
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ensure storage link
php artisan storage:link --force 2>/dev/null || true

# Fix permissions
chown -R www-data:www-data storage bootstrap/cache

echo "✅ Agri-Marketplace est prêt !"

exec "$@"
