# 🎭 Yukostum - Sistem Informasi Penyewaan Kostum & Aksesoris

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

**Yukostum** adalah sebuah Sistem Informasi berbasis web untuk mengelola transaksi penyewaan kostum (Cosplay, Acara Sekolah, Pentas Tari, dll). Aplikasi ini dibangun khusus untuk memenuhi standar **Uji Kompetensi (Ujikom) / Tugas Akhir**, dengan arsitektur kode yang bersih, aman, dan fitur yang sangat komprehensif.

Aplikasi ini menggunakan tema desain visual **Premium Dark & Golden** (Hitam Elegan dan Kuning Emas) dengan antarmuka yang 100% mendukung mode *offline* (Bootstrap & Fonts dijalankan secara lokal).

---

## ✨ Fitur Utama

Sistem ini mendukung 3 Hak Akses (Role) berbeda: **Admin, Petugas Gudang, dan Pelanggan**.

### 👤 Fitur Pelanggan
* **Katalog Interaktif:** Mencari dan memfilter kostum berdasarkan tipe.
* **Sistem Pemesanan (Booking):** Memilih tanggal pinjam & kembali dengan kalkulasi harga otomatis.
* **Riwayat Transaksi:** Melacak status pesanan (Menunggu, Disetujui, Dikembalikan, Ditolak).
* **Manajemen Profil:** Memperbarui data diri, alamat pengiriman, dan kata sandi.

### 💼 Fitur Petugas Gudang
* **Manajemen Etalase (CRUD Kostum):** Menambah, mengedit, menghapus, dan memantau stok serta kondisi kostum.
* **Validasi Pesanan:** Menyetujui pesanan masuk yang sudah dibayar.
* **Proses Pengembalian:** Memvalidasi kondisi kostum yang dikembalikan, mengunggah bukti foto, dan menghitung **Denda** secara sistematis (Keterlambatan/Kerusakan/Kehilangan).

### 👑 Fitur Admin (Pemilik)
* *Semua fitur Petugas Gudang, ditambah:*
* **Dashboard Analitik BI:** Ringkasan pendapatan (termasuk denda), total transaksi, stok, dan papan peringkat (*Leaderboard*) Top 5 Kostum Terlaris.
* **Cetak Laporan Keuangan:** Menghasilkan laporan rekapitulasi pendapatan dengan filter waktu yang siap dicetak.
* **Manajemen Pengguna (CRUD Akun):** Mengelola akun seluruh staf dan pelanggan.
* **Log Aktivitas (CCTV Sistem):** Memantau seluruh rekam jejak digital (siapa melakukan apa, dan kapan).

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** PHP (Laravel Framework)
* **Frontend:** Blade Templating, HTML5, CSS3
* **UI Framework:** Bootstrap 5.3 (Terintegrasi Offline)
* **Tipografi:** Plus Jakarta Sans (Terintegrasi Offline)
* **Database:** MySQL / MariaDB
* **Keamanan:** Hash Password, CSRF Protection, Controller Middleware Protection.

---

## 🚀 Panduan Instalasi (Cara Menjalankan di Lokal)

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek Yukostum di komputer/laptop Anda:

### 1. Kloning Repositori
```bash
git clone [https://github.com/rangga229/ujikom-peminjaman-kostum.git](https://github.com/rangga229/ujikom-peminjaman-kostum.git)
cd ujikom-peminjaman-kostum
