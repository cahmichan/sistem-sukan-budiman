# Sistem Pendaftaran Peserta Sukan Rakyat Kampung Budiman

Sistem ini ialah aplikasi pendaftaran peserta untuk Sukan Rakyat / Sukan SULAM Kampung Budiman. Peserta awam boleh mendaftar melalui pautan atau QR code tanpa log masuk, menerima kod pendaftaran unik, dan menyemak status pendaftaran. Sebarang pembetulan maklumat dibuat oleh admin melalui panel pengurusan.

## Stack

- Laravel 12
- PHP 8.2+
- MySQL/MariaDB untuk produksi
- SQLite boleh digunakan untuk pembangunan tempatan
- Blade, Tailwind CSS, Flowbite, Vite
- Laravel Breeze authentication

## Pemasangan

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

## Tetapan `.env`

Untuk MySQL/MariaDB:

```env
APP_NAME="Sukan Budiman"
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sukan_budiman
DB_USERNAME=root
DB_PASSWORD=
```

Untuk SQLite tempatan:

```env
DB_CONNECTION=sqlite
```

Pastikan fail `database/database.sqlite` wujud jika menggunakan SQLite.

## Database

```bash
php artisan migrate:fresh --seed
```

Seeder akan mencipta:

- Admin default
- Contoh rumah sukan
- Data acara Sukan SULAM

## Login Admin Default

- Emel: `admin@budiman.test`
- Kata laluan: `password`

Tukar kata laluan ini sebelum digunakan secara sebenar.

## Run Local

```bash
npm run dev
php artisan serve
```

Buka `http://127.0.0.1:8000`.

Untuk build aset produksi:

```bash
npm run build
```

## Route Awam

- `/` - Landing page
- `/daftar` - Borang pendaftaran peserta
- `/berjaya/{registration_code}` - Paparan berjaya
- `/semak` - Semak pendaftaran
- `/status/{registration_code}` - Status pendaftaran

## Route Admin

- `/login` - Log masuk admin
- `/admin/dashboard` - Dashboard
- `/admin/participants` - Pengurusan peserta
- `/admin/houses` - Pengurusan rumah sukan
- `/admin/sports` - Pengurusan acara sukan
- `/admin/reports` - Laporan dan eksport CSV
- `/admin/reports/print` - Senarai cetakan peserta
- `/admin/audit-logs` - Audit log tindakan admin
- `/admin/settings` - Tetapan pendaftaran dan maklumat acara

## Ciri Utama

- Pendaftaran peserta awam tanpa log masuk
- Kod pendaftaran unik
- Peserta awam tidak boleh edit selepas hantar
- Maklumat penjaga wajib untuk peserta kanak-kanak
- Kategori peserta dikira automatik berdasarkan umur: bawah 12 tahun `Kanak-Kanak`, 12 tahun ke atas `Dewasa`
- Acara `Terbuka` boleh dipilih oleh peserta kanak-kanak dan dewasa
- Admin boleh tambah, lihat, edit dan padam peserta
- Admin boleh urus rumah sukan dan acara
- Assign peserta kepada acara
- Eksport CSV
- Senarai cetakan mesra printer
- Link WhatsApp peringatan ringkas
- Audit log untuk tindakan create, update dan delete admin
- Tetapan buka/tutup pendaftaran, tarikh akhir, tarikh acara, masa, tempat dan kontak admin
- Kawalan kapasiti acara dengan status `Diterima` dan `Senarai Menunggu`
- Pautan login admin tidak dipaparkan di halaman awam; admin boleh terus buka `/login`

## Ujian

```bash
php artisan test
```

## Had Semasa

- Tiada integrasi SMS atau WhatsApp API berbayar.
- Role management penuh dengan Spatie belum dipasang kerana hanya admin asas diperlukan pada fasa ini.
- Sistem belum menjana PDF automatik; cetakan dibuat melalui halaman print-friendly.

## Cadangan Penambahbaikan

- QR code generator untuk pautan `/daftar`.
- Role tambahan seperti petugas pendaftaran atau penyelaras acara.
