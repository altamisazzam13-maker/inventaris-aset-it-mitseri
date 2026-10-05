# Inventaris Aset IT MITSERI

A modern Laravel‑based asset management system for IT equipment.  
The application provides a sleek, glass‑morphism UI (Tailwind CSS, Alpine JS) and role‑based access control for **admin** and **pegawai** users.

---

## 📋 Project Overview

- **Core**: Laravel 10 (PHP 8.2) with Breeze authentication.
- **Frontend**: Tailwind CSS, Alpine JS, custom gradients & glass‑morphism styling.
- **Database**: MySQL / PostgreSQL (compatible with Railway add‑ons).
- **Roles**:
  - `admin` – full CRUD on users, assets, maintenance, etc.
  - `staff` (pegawai) – limited access to asset view & maintenance.
- **Features**:
  - Asset list, PDF/Excel export, import via Excel.
  - Maintenance logs, vendor & technician handling.
  - Responsive design with dark mode.

---

## ⚙️ Installation (Local Development)

```bash
# Clone the repo (once you push it to GitHub)
git clone https://github.com/your-username/inventaris-aset-it-mitseri.git
cd inventaris-aset-it-mitseri

# Install PHP dependencies
composer install

# Install Node dependencies (for Tailwind / Vite)
npm ci   # or `npm install`

# Build assets (optional for local dev, required for production)
npm run build

# Copy example env and generate app key
cp .env.example .env
php artisan key:generate

# Run migrations & seeders (creates admin & staff accounts)
php artisan migrate:fresh --seed

# Serve locally
php artisan serve --host=127.0.0.1 --port=8000
```

### Default credentials (after seeding)
| Role | Email | Password |
|------|-------|----------|
| **Admin** | `admin@example.com` | `Admin123!` |
| **Pegawai** | `pegawai@example.com` | `Pegawai123!` |

---

## 🚀 Deployment to Railway

1. **Push the project to GitHub** (see the `push_to_github.sh` script in the repo).
2. In Railway, click **New Project → Deploy from GitHub** and select the repository.
3. Add the following environment variables in Railway (Settings → Variables):
   - `APP_KEY` – generated with `php artisan key:generate --show`.
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - Database vars (`DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`). Railway will auto‑populate these when you attach a PostgreSQL/MySQL add‑on.
   - Any other custom vars you may need (e.g., `MAIL_MAILER`, `MAIL_HOST`).
4. **Procfile** (already in repo) tells Railway how to start the app:
   ```text
   web: php artisan serve --host=0.0.0.0 --port=$PORT
   ```
5. (Optional) Add a *Deploy Script* in Railway to run migrations automatically:
   ```bash
   php artisan migrate --force
   ```
6. Deploy – Railway will clone, install Composer & NPM dependencies, build assets, run migrations, and expose the app at the generated `*.railway.app` URL.

---

## 🛡️ Environment Variables

| Variable | Description | Example |
|----------|-------------|---------|
| `APP_KEY` | Encryption key for Laravel | `base64:xxxxxxxxxxxx` |
| `APP_ENV` | Environment (`local`, `production`) | `production` |
| `APP_DEBUG` | Show debug info (`true`/`false`) | `false` |
| `DB_CONNECTION` | Database driver (`mysql`, `pgsql`) | `pgsql` |
| `DB_HOST` | Host address provided by Railway | `containers-us-west-123.railway.app` |
| `DB_PORT` | Port number (usually `5432` for Postgres) | `5432` |
| `DB_DATABASE` | Database name | `railway` |
| `DB_USERNAME` | Username | `postgres` |
| `DB_PASSWORD` | Password | `********` |

---

## 🤝 Contributing

1. Fork the repository.
2. Create a feature branch (`git checkout -b feature/awesome-feature`).
3. Commit your changes and push to your fork.
4. Open a Pull Request describing the changes.

Please keep the coding style consistent (PSR‑12 for PHP, Prettier for JS/CSS) and write tests where applicable.

---

## 📜 License

This project is licensed under the **MIT License** – see the `LICENSE` file for details.

---

*Created with ❤️ by the MITSERI development team.*
