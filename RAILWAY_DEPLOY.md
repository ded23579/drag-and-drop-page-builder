# Deployment ke Railway - Panduan Terbaru

## File-file yang dibutuhkan
- `railway.json` - Konfigurasi deployment Railway
- `Procfile` - Perintah untuk menjalankan aplikasi
- `railway.config.json` - Alternatif konfigurasi
- `.nixpacks.toml` - Konfigurasi build pack
- `build.sh` - Script build kustom

## Environment Variables yang harus diatur di Railway

### Basic Configuration
```
APP_NAME=NamaAplikasiAnda
APP_ENV=production
APP_KEY=  # Generate dengan: php artisan key:generate --show
APP_DEBUG=false
APP_URL=https://nama-project-anda.railway.app
```

### Database Configuration (akan otomatis terisi jika menggunakan database Railway)
```
DB_CONNECTION=pgsql  # Ganti dari sqlite agar kompatibel dengan Railway
# DB_HOST=  # Akan otomatis terisi
# DB_PORT=  # Akan otomatis terisi
# DB_DATABASE=  # Akan otomatis terisi
# DB_USERNAME=  # Akan otomatis terisi
# DB_PASSWORD=  # Akan otomatis terisi
```

CATATAN PENTING: Ganti DB_CONNECTION dari 'sqlite' ke 'pgsql' atau 'mysql' karena SQLite tidak bekerja dengan baik di lingkungan deployment.

### File Storage Configuration
Karena Railway memiliki sistem file sementara, Anda mungkin perlu mengkonfigurasi storage untuk:
- File uploads
- Logs
- Cache

Direkomendasikan menggunakan layanan storage eksternal seperti AWS S3.

## Deployment Steps

1. Commit semua perubahan ke GitHub:
   ```bash
   git add .
   git commit -m "Add Railway configuration files"
   git push origin main
   ```

2. Di dashboard Railway:
   - Buat project baru
   - Pilih "Deploy from GitHub"
   - Pilih repositori ini
   - Tambahkan environment variables di tab "Variables"
   - Pastikan DB_CONNECTION diubah ke 'pgsql' di environment variables

3. Setelah deployment selesai:
   - Buka console di Railway
   - Jalankan migration: `php artisan migrate --force`
   - (Opsional) Jalankan seed: `php artisan db:seed`

## Alternatif Pendekatan Deployment

Jika pendekatan utama gagal, coba ini:

### Opsi 1: Gunakan perintah artisan serve
- Pastikan railway.json menggunakan: `"startCommand": "php artisan serve --host=0.0.0.0 --port=$PORT"`

### Opsi 2: Gunakan PHP built-in server
- Pastikan railway.json menggunakan: `"startCommand": "php -S 0.0.0.0:$PORT -t public/"`

## Catatan Penting

- Railway menggunakan sistem file sementara, jadi file yang disimpan di lokal akan hilang saat restart
- Untuk production, pastikan untuk menggunakan database eksternal (bukan SQLite)
- Cache dan session sebaiknya diarahkan ke Redis (jika tersedia di Railway)
- File .env harus diset di dashboard Railway, bukan disertakan di repo

## Troubleshooting Umum

### 1. Build gagal karena memory atau timeout
- Kurangi jumlah dependency development
- Gunakan `composer install --no-dev` di build command

### 2. Aplikasi tidak bisa start
- Pastikan PORT diakses melalui environment variable
- Coba ganti start command ke: `php -S 0.0.0.0:$PORT -t public/`

### 3. Migration gagal
- Pastikan database telah dibuat dan environment variables database benar
- Coba jalankan migration secara manual melalui console

### 4. Error karena SQLite
- Ganti DB_CONNECTION ke pgsql atau mysql
- Tidak bisa menggunakan database file di Railway

## Cek Logs di Railway
Jika masih bermasalah:
- Buka tab "Deployments" di dashboard Railway
- Klik deployment yang gagal
- Baca error log secara teliti untuk identifikasi masalah spesifik