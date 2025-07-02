# 📦 Changelog – Proyek E-Library BRIDA (ilkom-22-cloud-5)

## ✅ Commit: Login & Session Setup
- Menambahkan halaman login dengan validasi database
- Menyimpan sesi login untuk akses halaman terbatas
- Proteksi terhadap login kosong dan akun tidak valid

## ✅ Commit: CRUD Penelitian
- Menambahkan form input untuk tambah penelitian
- Validasi dan filter data sebelum insert ke database
- Menambahkan fitur edit dan update data penelitian
- Tambahan logging untuk update data (`log_update.txt`)

## ✅ Commit: Delete Data Modular
- Fungsi hapus data berdasarkan tipe (instansi, rak, kategori, fakultas)
- Menggunakan JSON response untuk kebutuhan frontend AJAX

## ✅ Commit: Dynamic Filtering & Pagination
- Menerapkan filter dinamis berdasarkan tahun, kategori, penulis, fakultas, dll.
- Ditambahkan pagination dengan sistem `limit` dan `offset`
- Data disusun berdasarkan tanggal masuk terbaru

## ✅ Commit: Log Akses File Panduan
- Tambahan log download dan preview panduan (`log_download.txt`)
- Menjaga jejak akses file oleh pengguna

## ✅ Commit: Chatbot Integration (ELBi)
- Menyiapkan backend untuk asisten virtual ELBi menggunakan API Gemini
- Input pesan dari user dikirim ke model, dan response dikembalikan sebagai JSON

## ✅ Commit: Tes Awal & Autoload
- Menambahkan struktur testing (`phpunit`, autoload PSR-4)
- Menyusun struktur file sesuai standar composer

## ✅ Commit: Tampilan Profil Pengguna
- Membuat file `profile.php` yang menampilkan info login pengguna
- Menggunakan Bootstrap 5 untuk tampilan rapi dan modern

## ✅ Commit: Halaman 404 & Perlindungan Routing
- Menambahkan halaman `404.php` untuk akses yang tidak valid
- Redirect otomatis ke 404 jika file tidak ditemukan
- Meningkatkan UX saat pengguna salah membuka URL

## ✅ Commit: Pembersihan & Struktur Direktori
- Menambahkan folder `panduan/` untuk menyimpan file PDF
- Menata file konfigurasi `.env` agar tidak terbuka publik
- Memisahkan `function.php` dan `cek.php` dari direktori utama

---
