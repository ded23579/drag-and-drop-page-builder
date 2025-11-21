# Deployment ke Railway

## File-file yang dibutuhkan
- `railway.json` - Konfigurasi deployment Railway
- `Procfile` - Perintah untuk menjalankan aplikasi

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
DB_CONNECTION=pgsql
# DB_HOST=  # Akan otomatis terisi
# DB_PORT=  # Akan otomatis terisi
# DB_DATABASE=  # Akan otomatis terisi
# DB_USERNAME=  # Akan otomatis terisi
# DB_PASSWORD=  # Akan otomatis terisi
```

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

3. Setelah deployment pertama selesai:
   - Buka console di Railway
   - Jalankan migration: `php artisan migrate --force`
   - (Opsional) Jalankan seed: `php artisan db:seed`

## Catatan Penting

- Railway menggunakan sistem file sementara, jadi file yang disimpan di lokal akan hilang saat restart
- Untuk production, pastikan untuk menggunakan database eksternal
- Cache dan session sebaiknya diarahkan ke Redis (jika tersedia di Railway)

## Troubleshooting

Jika deployment gagal:
- Cek logs di tab "Deployments"
- Pastikan semua dependency terdaftar di composer.json
- Pastikan environment variables sudah lengkap