# Sistem Cek Stok Barang (Laravel + Supabase)

Aplikasi ini digunakan untuk mengecek stok barang berdasarkan PLU.
Backend menggunakan Laravel, frontend asset menggunakan Vite (npm),
dan database menggunakan PostgreSQL dari Supabase.

=====================================================================

## TUTORIAL INSTALL & MENJALANKAN APLIKASI (WAJIB IKUT URUTAN)

=====================================================================

1. PERSIAPAN AWAL

Pastikan di komputer sudah terinstall:
- PHP
- Composer
- Node.js + NPM
- Git

Cek versi (opsional):
php -v
composer -V
node -v
npm -v

=====================================================================

2. CLONE PROJECT

Clone repository ke komputer:

git clone https://github.com/username/nama-project.git
cd nama-project

=====================================================================

3. INSTALL DEPENDENCY LARAVEL

Jalankan perintah berikut:

composer install

Copy file environment:

cp .env.example .env

Generate app key:

php artisan key:generate

=====================================================================

4. KONFIGURASI DATABASE SUPABASE

Aplikasi menggunakan database Supabase (PostgreSQL) yang sudah disiapkan.

Buka file .env lalu isi:

DB_CONNECTION=pgsql
DB_HOST=xxxxx.supabase.co
DB_PORT=5432
DB_DATABASE=nama_database
DB_USERNAME=postgres
DB_PASSWORD=password_database

=====================================================================

5. IMPORT DATABASE

Database sudah tersedia dalam bentuk file .sql.

Import database dengan salah satu cara berikut:

- Melalui Supabase Dashboard → SQL Editor → paste isi file .sql → Run
ATAU
- Melalui terminal:

psql -h host_supabase -U postgres -d nama_database -f database.sql

=====================================================================

6. INSTALL DEPENDENCY FRONTEND (VITE)

Install dependency frontend:

npm install

=====================================================================

7. MENJALANKAN APLIKASI (WAJIB 2 TERMINAL)

Terminal 1 – Jalankan Vite:

npm run dev

Terminal 2 – Jalankan Laravel:

php artisan serve

Aplikasi bisa diakses di browser:

http://127.0.0.1:8000

Terminal 3 - Build Apps:

npm run build

=====================================================================

8. FORMAT PLU (TEMPLATE)

Aplikasi menggunakan PLU (Price Look-Up) untuk identifikasi barang.

Format PLU:

[KK][XXXX]

Keterangan:
- KK   = Kode kategori barang
- XXXX = 4 digit setelah 2 digit dari UPC barang

Jenis Kategori:
[43] = Makanan/Snack
[44] = Bahan Masakan/Bumbu
[46] = Minuman
[47] = Kosmetik
[58] = Perabotan Rumah
[59] = Pembersih (Detergen, sabun cuci piring, dll)
[61] = Alat Tulis Kerja
[63] = Obat-obatan

Contoh :

GOLDA COFFEE CAPPUCCINO 200 ML
Kategori: Minuman
UPC: 8998866202893
Yang diambil: 89[9886]6202893

46 [nomor_kategori]
9886 [4 digit setelah 2 digit UPC barang]


=====================================================================

9. CARA CEK STOK

Contoh cek stok menggunakan query:

/cek-stock?plu=43968601

Atau menggunakan form input PLU pada tampilan aplikasi.

=====================================================================

10. TROUBLESHOOTING

Jika terjadi error:

php artisan optimize:clear

Jika masih bermasalah:
- Pastikan npm run dev masih berjalan
- Pastikan php artisan serve masih berjalan
- Pastikan koneksi Supabase benar

Cek log Laravel:
storage/logs/laravel.log

=====================================================================

11. CATATAN PENTING

- Jangan matikan npm run dev saat aplikasi berjalan
- Jangan mengubah struktur database tanpa update kode
- PLU harus sesuai format

=====================================================================

12. AUTHOR

Dikembangkan oleh:
(Viking0207)

=====================================================================

13. LISENSI

Project ini boleh dipake asalkan dimodif lagi (Jangan Copy paste mentah-mentah euyy!).
