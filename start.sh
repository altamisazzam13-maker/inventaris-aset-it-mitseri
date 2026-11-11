#!/bin/bash
set -e

echo "=== Memulai Aplikasi Inventaris Aset IT ==="

# ============================================================
# STEP 1: Paksa semua variabel DB, Session, Cache ke SQLite/file
# (override variabel Railway yang mungkin mengarah ke MySQL)
# ============================================================
export DB_CONNECTION=sqlite
export DB_DATABASE=/app/database/database.sqlite
export SESSION_DRIVER=file
export CACHE_STORE=file
export QUEUE_CONNECTION=sync

# Pastikan APP_KEY tersedia (fallback bila tidak di-set di Railway)
if [ -z "$APP_KEY" ]; then
    export APP_KEY="base64:QSXpJqTh5tV1bsyeahj7c3WbNySvNFq+XqxrLbmRQ+M="
fi

# ============================================================
# STEP 2: Buat direktori yang diperlukan dan set permission
# ============================================================
mkdir -p storage/framework/{sessions,views,cache} bootstrap/cache database 2>/dev/null || true
chmod -R 777 storage bootstrap/cache 2>/dev/null || true

# Buat file SQLite
touch database/database.sqlite 2>/dev/null || true
chmod 666 database/database.sqlite 2>/dev/null || true

# ============================================================
# STEP 3: Buat .env dari .env.example bila belum ada
# ============================================================
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Tulis semua variabel penting ke .env (override nilai lama)
sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=sqlite|" .env || true
sed -i "s|^DB_DATABASE=.*|DB_DATABASE=database/database.sqlite|" .env || true
sed -i "s|^SESSION_DRIVER=.*|SESSION_DRIVER=file|" .env || true
sed -i "s|^CACHE_STORE=.*|CACHE_STORE=file|" .env || true
sed -i "s|^QUEUE_CONNECTION=.*|QUEUE_CONNECTION=sync|" .env || true

# Tulis APP_KEY ke .env bila kosong
if ! grep -q '^APP_KEY=base64:' .env; then
    sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" .env || true
fi

# ============================================================
# STEP 4: Bersihkan cache konfigurasi
# ============================================================
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true

# ============================================================
# STEP 5: Link storage
# ============================================================
php artisan storage:link --force || true

# ============================================================
# STEP 6: Jalankan migrasi database (SQLite)
# ============================================================
echo "=== Menjalankan Database Migration ==="
php artisan migrate --force 2>&1 || echo "Peringatan: Migrasi gagal. Melanjutkan..."

# ============================================================
# STEP 7: Jalankan seeder admin
# ============================================================
echo "=== Menjalankan User Seeder ==="
php artisan db:seed --class=UserSeeder --force 2>&1 || echo "Peringatan: Seeder gagal. Melanjutkan..."

# ============================================================
# STEP 8: Jalankan web server Laravel
# ============================================================
echo "=== Menjalankan Web Server di Port ${PORT:-8080} ==="
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
