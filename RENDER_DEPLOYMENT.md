# Deployment ke Render

## Cara Deploy Aplikasi Laravel ke Render

1. Pastikan kamu sudah membuat repository GitHub untuk proyek ini
2. Push kode kamu ke GitHub:
   ```bash
   git add .
   git commit -m "Setup for Render deployment"
   git push origin main
   ```

3. Buka [https://dashboard.render.com](https://dashboard.render.com)
4. Klik "New +" > "Web Service"
5. Pilih repository GitHub kamu
6. Render seharusnya akan otomatis membaca file `render.yaml` dan mengkonfigurasi deployment

## Konfigurasi yang Digunakan

- **Environment**: PHP
- **Build Command**: Install dependencies dan build assets
- **Start Command**: `php -S 0.0.0.0:$PORT -t public/`
- **Database**: SQLite (dengan file `database/database.sqlite`)
- **Environment Variables**: Sudah diatur di `render.yaml`

## Environment Variables yang Diperlukan

Aplikasi ini dikonfigurasi untuk bekerja di environment production dengan:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `DB_CONNECTION=sqlite`
- `DB_DATABASE=/var/www/html/database/database.sqlite`

## Catatan Penting

1. Render akan otomatis deploy ketika kamu push ke branch yang ditentukan
2. Database SQLite disimpan di disk persisten
3. Pastikan semua dependencies terdaftar di `composer.json`
4. Assets frontend dibuild dengan npm

## Troubleshooting

Jika terjadi error saat deployment:
1. Cek log deployment di dashboard Render
2. Pastikan semua environment variables terisi dengan benar
3. Verifikasi bahwa build command tidak ada error