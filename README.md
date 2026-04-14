# Yukostum - Sistem Informasi Penyewaan Kostum & Aksesoris

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

Yukostum adalah sebuah Sistem Informasi berbasis web untuk mengelola transaksi penyewaan kostum (Cosplay, Acara Sekolah, Pentas Tari, dll). Aplikasi ini dibangun khusus untuk memenuhi standar Uji Kompetensi (Ujikom) / Tugas Akhir, dengan arsitektur kode yang bersih, aman, dan fitur yang sangat komprehensif.

Aplikasi ini menggunakan tema desain visual Premium Dark & Golden (Hitam Elegan dan Kuning Emas) dengan antarmuka yang 100% mendukung mode offline (Bootstrap & Fonts dijalankan secara lokal).

---

## Fitur Utama

Sistem ini mendukung 3 Hak Akses (Role) berbeda: Admin, Petugas Gudang, dan Pelanggan.

### Fitur Pelanggan
* Katalog Interaktif: Mencari dan memfilter kostum berdasarkan tipe.
* Sistem Pemesanan (Booking): Memilih tanggal pinjam & kembali dengan kalkulasi harga otomatis.
* Riwayat Transaksi: Melacak status pesanan (Menunggu, Disetujui, Dikembalikan, Ditolak).
* Manajemen Profil: Memperbarui data diri, alamat pengiriman, dan kata sandi.

### Fitur Petugas Gudang
* Manajemen Etalase (CRUD Kostum): Menambah, mengedit, menghapus, dan memantau stok serta kondisi kostum.
* Validasi Pesanan: Menyetujui pesanan masuk yang sudah dibayar.
* Proses Pengembalian: Memvalidasi kondisi kostum yang dikembalikan, mengunggah bukti foto, dan menghitung Denda secara sistematis (Keterlambatan/Kerusakan/Kehilangan).

### Fitur Admin (Pemilik)
* Semua fitur Petugas Gudang, ditambah:
* Dashboard Analitik BI: Ringkasan pendapatan (termasuk denda), total transaksi, stok, dan papan peringkat (Leaderboard) Top 5 Kostum Terlaris.
* Cetak Laporan Keuangan: Menghasilkan laporan rekapitulasi pendapatan dengan filter waktu yang siap dicetak.
* Manajemen Pengguna (CRUD Akun): Mengelola akun seluruh staf dan pelanggan.
* Log Aktivitas (CCTV Sistem): Memantau seluruh rekam jejak digital (siapa melakukan apa, dan kapan).

---

## Teknologi yang Digunakan

* Backend: PHP (Laravel Framework versi 12)
* Frontend: Blade Templating, HTML5, CSS3
* UI Framework: Bootstrap 5.3 (Terintegrasi Offline)
* Tipografi: Plus Jakarta Sans (Terintegrasi Offline)
* Database: MySQL 
* Keamanan: Hash Password, CSRF Protection, Controller Middleware Protection.

---

## Panduan Instalasi (Cara Menjalankan di Lokal)

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek Yukostum di komputer/laptop Anda:

### 1. Kloning Repositori
git clone https://github.com/rangga229/ujikom-peminjaman-kostum.git
cd ujikom-peminjaman-kostum

### 2. Instalasi Dependensi (Composer)
Pastikan Anda sudah menginstal PHP dan Composer.
composer install

### 3. Konfigurasi Environment (Database)
Gandakan file konfigurasi dan sesuaikan pengaturan database Anda.
cp .env.example .env

Buka file .env di teks editor, lalu ubah bagian ini sesuai nama database di phpMyAdmin Anda:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=yukostum
DB_USERNAME=root
DB_PASSWORD=

### 4. Generate Application Key
php artisan key:generate

### 5. Migrasi Database
Jalankan migrasi untuk membuat seluruh tabel di MySQL. Jika Anda memiliki seeder untuk akun dummy, tambahkan --seed.
php artisan migrate
(Catatan: Anda juga bisa langsung mengimpor file yukostum.sql ke dalam phpMyAdmin Anda jika tidak menggunakan migrasi artisan).

### 6. Jalankan Server Lokal
php artisan serve

Aplikasi sekarang dapat diakses melalui browser di: http://localhost:8000

---

   ```
## 💻 Cara Menjalankan Aplikasi
Setelah proses instalasi selesai, jalankan *server* lokal Laravel dengan perintah:
```bash
php artisan serve

```
Aplikasi sekarang dapat diakses melalui *browser* di alamat: **http://127.0.0.1:8000**
### 🔑 Akun Default (Login Uji Coba)
 * **Admin:** * Email: admin@yukostum.com
   * Password: password (atau sesuaikan dengan seeder Anda)
 * **Pelanggan:** * Email: user@gmail.com
   * Password: password (atau sesuaikan dengan seeder Anda)
## 📖 Panduan Penggunaan Singkat
### Alur Pelanggan (Menyewa Baju):
 1. Buka halaman utama, lakukan **Registrasi** atau **Login**.
 2. Masuk ke menu **Katalog Kostum**, pilih baju yang tersedia, lalu klik **Lihat Detail** > **Sewa Sekarang**.
 3. Pilih tanggal peminjaman dan pengembalian.
 4. Pilih metode pembayaran dan unggah **Foto Bukti Transfer**.
 5. Setelah selesai dipakai, buka menu **Riwayat Sewa**, klik **Kembalikan Barang**, dan unggah foto kondisi fisik barang saat dikembalikan.
### Alur Admin (Memproses Pesanan):
 1. Login menggunakan akun Admin.
 2. Masuk ke menu **Pesanan Masuk**.
 3. Jika ada pesanan berstatus *Pending*, klik **Cek Pembayaran**, lihat bukti transfer, lalu klik **Setujui** (Stok akan otomatis berkurang).
 4. Jika pelanggan sudah mengembalikan barang (Status *Menunggu Validasi*), klik **Validasi & Selesai**.
 5. Cek kondisi fisik barang secara langsung. Jika aman pilih *Aman* (Rp 0), jika telat sistem akan memunculkan nominal denda otomatis, lalu klik **Simpan**. Selesai!

## Struktur Database Utama (ERD Konseptual)

Proyek ini ditopang oleh 4 tabel relasional utama:
1. users : Menyimpan entitas akun pelanggan dan staf.
2. costumes : Menyimpan atribut data baju/barang sewaan.
3. rentals : Menyimpan riwayat transaksi (Pivot/Jembatan antara Users dan Costumes).
4. activity_logs : Menyimpan rekam jejak sistem untuk keperluan audit.

---

## Pengembang
Dikembangkan oleh Rangga untuk keperluan Proyek / Uji Kompetensi.

Dilisensikan secara terbuka untuk keperluan pembelajaran.
