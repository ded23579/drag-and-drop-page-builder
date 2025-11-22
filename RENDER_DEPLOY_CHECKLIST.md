# Checklist Deployment ke Render

## Sebelum Deploy ke Render

### 1. Persiapan Repository GitHub
- [ ] Repository sudah dibuat di GitHub
- [ ] Kode sudah dipush ke GitHub (`git add .`, `git commit`, `git push`)
- [ ] Repository tidak mengandung credential sensitif di dalam file

### 2. File Konfigurasi
- [ ] File `render.yaml` sudah ada dan dikonfigurasi dengan benar
- [ ] File `server.php` siap untuk routing Laravel
- [ ] File `.renderignore` sudah dibuat untuk mengecualikan file tidak penting
- [ ] File `composer.json` dan `composer.lock` sudah diperbarui

### 3. Environment Variables
- [ ] Semua environment variables penting terdaftar di `render.yaml`
- [ ] Database (SQLite atau PostgreSQL) sudah dikonfigurasi
- [ ] Storage untuk file upload sudah disiapkan jika diperlukan

### 4. Dependencies
- [ ] Semua PHP dependencies terdaftar di `composer.json`
- [ ] Semua Node.js dependencies terdaftar di `package.json`
- [ ] Tidak ada development dependencies yang diperlukan di production

### 5. Assets
- [ ] Frontend assets bisa dibuild dengan `npm run build`
- [ ] Assets disimpan dengan benar di `public/` folder

## Proses Deployment

### 1. Setup di Render Dashboard
- [ ] Login ke dashboard.render.com
- [ ] Klik "New +" > "Web Service"
- [ ] Pilih repository GitHub kamu
- [ ] Render harus otomatis mendeteksi file `render.yaml`

### 2. Konfigurasi Manual (jika render.yaml tidak digunakan otomatis)
- [ ] Build Command: `composer install --no-dev --optimize-autoloader --no-interaction && npm install --production=false --ignore-scripts && npm run build && php artisan key:generate --force && php artisan migrate --force`
- [ ] Start Command: `php -S 0.0.0.0:$PORT server.php`
- [ ] Environment variables disetel sesuai kebutuhan aplikasi

### 3. Monitor Deployment
- [ ] Cek log deployment di dashboard Render
- [ ] Pastikan tidak ada error selama build
- [ ] Aplikasi berhasil start tanpa error

## Setelah Deployment Berhasil

### 1. Testing
- [ ] Buka URL aplikasi dan pastikan load dengan benar
- [ ] Cek semua fitur utama berfungsi
- [ ] Test form, authentication, dan database functionality

### 2. Environment Variables (jika perlu ditambahkan manual)
- [ ] Tambahkan environment variables tambahan di dashboard Render jika diperlukan
- [ ] Contoh: API keys, SMTP credentials, dll.

## Troubleshooting

Jika deployment gagal:
- [ ] Cek log deployment untuk error messages
- [ ] Pastikan semua dependencies bisa diinstall di environment Render
- [ ] Pastikan tidak ada path hardcoded yang salah
- [ ] Pastikan konfigurasi database benar untuk environment production

## Auto-Deployment
- [ ] Render otomatis akan redeploy ketika kamu push ke branch yang ditentukan
- [ ] Kamu bisa konfigurasi branch yang digunakan untuk deployment di settings service