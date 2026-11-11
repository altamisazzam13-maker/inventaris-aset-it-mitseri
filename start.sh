#!/bin/bash
set -e

echo "=== Memulai Aplikasi Inventaris Aset IT ==="

# Fallback APP_KEY jika belum diset di Railway Variables
if [ -z "$APP_KEY" ]; then
    export APP_KEY="base64:up4y0gc5iu9K+p/CbqGrGziR1AYz2RTMu7DarGu6u4Y="
fi

# Pastikan folder storage dan cache writable
mkdir -p storage/framework/{sessions,views,cache} bootstrap/cache database 2>/dev/null || true
chmod -R 777 storage bootstrap/cache 2>/dev/null || true

# Siapkan database SQLite jika tidak ada konfigurasi database MySQL/Postgres
touch database/database.sqlite 2>/dev/null || true
chmod 666 database/database.sqlite 2>/dev/null || true

# Pastikan .env ada; jika tidak, salin dari contoh
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Ensure APP_KEY exists in .env; generate if empty
if ! grep -q '^APP_KEY=' .env || grep -q '^APP_KEY=$' .env; then
    KEY=$(php artisan key:generate --show)
    echo "APP_KEY=base64:${KEY}" >> .env
fi

# Link storage jika belum ada
php artisan storage:link || true

# Bersihkan cache konfigurasi (menghindari APP_KEY lama yang dicache)
php artisan config:clear || true
php artisan cache:clear || true

# Jalankan migrasi database (jika database belum siap, jangan gagalkan startup server)
echo "=== Menjalankan Database Migration ==="
php artisan migrate --force || echo "Peringatan: Migrasi database gagal atau database belum terhubung. Melanjutkan startup..."

# Jalankan seeder admin
echo "=== Menjalankan User Seeder ==="
php artisan db:seed --class=UserSeeder --force || echo "Peringatan: Seeder gagal. Melanjutkan startup..."

# Jalankan web server Laravel
echo "=== Menjalankan Web Server di Port $PORT ==="
exec php artisan serve --host=0.0.0.0 --port=$PORT