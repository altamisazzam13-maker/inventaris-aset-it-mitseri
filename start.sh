#!/bin/bash
set -e

echo "=== Memulai Aplikasi Inventaris Aset IT ==="

# Pastikan folder storage dan cache writable
chmod -R 777 storage bootstrap/cache 2>/dev/null || true

# Link storage jika belum ada
php artisan storage:link || true

# Jalankan migrasi database (jika database belum siap, jangan gagalkan startup server)
echo "=== Menjalankan Database Migration ==="
php artisan migrate --force || echo "Peringatan: Migrasi database gagal atau database belum terhubung. Melanjutkan startup..."

# Jalankan seeder admin
echo "=== Menjalankan User Seeder ==="
php artisan db:seed --class=UserSeeder --force || echo "Peringatan: Seeder gagal. Melanjutkan startup..."

# Jalankan web server Laravel
echo "=== Menjalankan Web Server di Port $PORT ==="
exec php artisan serve --host=0.0.0.0 --port=$PORT

