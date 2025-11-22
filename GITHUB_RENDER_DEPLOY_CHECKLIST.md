# Checklist Deployment ke GitHub dan Render

## Persiapan Repository Baru di GitHub

1. Buat repository baru di GitHub dengan nama yang kamu inginkan
2. Jangan centang "Initialize this repository with a README", "Add .gitignore", atau "Choose a license"
3. Copy URL repository yang baru dibuat

## Update Remote Origin di Lokal

1. Di folder aplikasi kamu (d:\code\cobacobaaja), jalankan perintah berikut:
   ```
   git remote set-url origin [URL_REPOSITORY_BARU]
   ```

   Contoh:
   ```
   git remote set-url origin https://github.com/nama-kamu/nama-repository-baru.git
   ```

2. Periksa apakah remote sudah berubah:
   ```
   git remote -v
   ```

## Push ke Repository Baru

1. Push semua kode ke repository baru:
   ```
   git add .
   git commit -m "Prepare for Render deployment"
   git push -u origin main
   ```

## Setup Deployment Otomatis ke Render

1. Buka dashboard.render.com
2. Klik "New +" > "Web Service"
3. Pilih repository GitHub yang baru
4. Render akan otomatis membaca file `render.yaml` yang sudah disiapkan
5. Tunggu proses deployment selesai

## Verifikasi Deployment

1. Setelah deployment selesai, buka URL aplikasi
2. Pastikan semuanya berjalan dengan baik
3. Uji beberapa fitur penting dari aplikasi kamu

## Troubleshooting

Jika kamu mendapatkan error "branch already exists" saat push:
- Ganti nama branch lokal: `git branch -M main`
- Atau gunakan force push dengan hati-hati: `git push -f origin main`

Jika kamu mendapatkan error permission:
- Pastikan kamu sudah login ke GitHub di local (melalui credential helper atau SSH key)

## Auto-deployment

Setelah setup selesai, setiap kali kamu push ke branch main di GitHub, Render akan otomatis melakukan redeployment aplikasi kamu.