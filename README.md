# SISTEM PEMBAYARAN EKSTRAKURIKULER SEKOLAH DASAR NEGERI (SDN) KAWUNG LUWUK BOGOR UTARA

![Image](https://github.com/user-attachments/assets/eb669a96-ca04-4a05-83e4-02996968e56a)
![Image](https://github.com/user-attachments/assets/fa2fed86-d06f-4020-a88b-bfc72b6a3237)
![Image](https://github.com/user-attachments/assets/831706fb-535a-436d-83d9-83029477d5c7)

---

## Fitur Utama

Sistem ini dilengkapi dengan berbagai fitur untuk mendukung pengelolaan pembayaran ekstrakurikuler:

### 1. Autentikasi Pengguna
* **Multi-Level User:** Mendukung tiga jenis pengguna:
    * **Super Admin:** Memiliki hak akses penuh, termasuk mengelola akun Admin.
    * **Admin:** Mengelola data master (kelas, siswa, ekskul) dan memverifikasi pembayaran.
    * **Siswa:** Mengunggah bukti pembayaran dan melihat riwayat pembayaran pribadi.
* **Sistem Login:** Halaman login terpadu untuk semua peran pengguna.

### 2. Modul Super Admin
* **Manajemen Admin:** CRUD (Create, Read, Update, Delete) akun Admin.

### 3. Modul Admin
* **Dashboard Informatif:** Ringkasan data penting seperti jumlah siswa, ekskul, dan status pembayaran (pending/terverifikasi).
* **Manajemen Kelas:** CRUD data kelas (contoh: 1A, 2B, 3C).
* **Manajemen Ekskul:** CRUD data ekstrakurikuler (nama, deskripsi, biaya).
* **Manajemen Siswa:** CRUD data siswa, termasuk informasi NISN, kelas, tanggal lahir, alamat, dan pembuatan akun login siswa.
* **Pendaftaran Siswa ke Ekskul:** Mengelola pendaftaran siswa ke ekstrakurikuler, termasuk status keanggotaan (aktif/non-aktif).
* **Verifikasi Pembayaran:** Admin dapat melihat detail pembayaran yang diunggah siswa, memverifikasi status pembayaran (pending, terverifikasi, ditolak), dan menambahkan catatan verifikasi.
* **Ekspor Data (Excel):** Fitur untuk mengunduh data siswa, kelas, pendaftaran ekskul, dan pembayaran dalam format Excel.

### 4. Modul Siswa
* **Dashboard Pribadi:** Melihat ringkasan pembayaran pending dan terverifikasi.
* **Daftar Ekskul Saya:** Melihat daftar ekstrakurikuler yang diikuti.
* **Pembayaran Online:** Mengunggah bukti pembayaran untuk ekskul yang diikuti dengan opsi menambahkan catatan.
* **Riwayat Pembayaran:** Melihat semua riwayat pembayaran yang pernah dilakukan beserta status verifikasinya.

### 5. Notifikasi Real-time (WhatsApp via Fonnte.com)
* Integrasi dengan **Fonnte.com API** untuk pengiriman notifikasi WhatsApp otomatis.
* Notifikasi ke Siswa: Saat berhasil mengunggah bukti pembayaran dan saat pembayaran diverifikasi (terverifikasi/ditolak) oleh Admin.
* Notifikasi ke Admin: Saat ada siswa yang mengunggah bukti pembayaran baru.

## Teknologi yang Digunakan

* **Backend:** PHP (CodeIgniter 3)
* **Database:** MySQL
* **Frontend:** HTML, CSS (Bootstrap 4), JavaScript
* **API Pihak Ketiga:** Fonnte.com (untuk notifikasi WhatsApp)

## Persyaratan Sistem

* Web Server (Apache / Nginx)
* PHP 5.6+ (disarankan PHP 7.x untuk CodeIgniter 3)
* MySQL Database
* Ekstensi PHP: `php_curl`, `php_mysqli`, `php_gd` (untuk upload gambar)

---

## Instalasi dan Cara Menjalankan Proyek

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut:

1.  **Clone Repositori:**
    ```bash
    git clone https://github.com/ucupdev23/sistem-pembayaran-ekskul-sd.git
    ```
2.  **Masuk ke Direktori Proyek:**
    ```bash
    cd sistem-pembayaran-ekskul-sd
    ```
3.  **Konfigurasi Database:**
    * Buat database baru di MySQL dengan nama `pembayaran_ekskul`.
    * Import file `pembayaran_ekskul.sql` (terletak di folder `database`) ke database yang baru Anda buat.
4.  **Konfigurasi Aplikasi:**
    * Buka file konfigurasi database Anda (di folder `application/config/database.php`).
    * Sesuaikan kredensial database (username, password, nama database) dengan pengaturan lokal Anda.
5.  **Tempatkan Proyek di Web Server:**
    * Pindahkan seluruh folder proyek ke direktori `htdocs` (untuk XAMPP/WAMP) atau direktori root web server Anda.
6.  **Akses Aplikasi:**
    * Buka browser Anda dan akses proyek melalui `http://localhost/sistem-pembayaran-ekskul-sd`.
    * Login menggunakan kredensial default Super Admin:
        * **Username:** `superadmin`
        * **Password:** `superadmin123`

---

## Kontribusi

Proyek ini merupakan hasil dari skripsi. Jika ada ide atau saran untuk pengembangan lebih lanjut, silakan buka *issue* atau *pull request*.

---

## Lisensi

Proyek ini dilisensikan di bawah Vira Hapitri 2111010011.

---

## Kontak

Jika Anda memiliki pertanyaan lebih lanjut, Anda bisa menghubungi saya:

* **Nama:** Yusuf Abdilhaq
* **Email:** ucup.dev23@gmail.com
* **LinkedIn:** https://www.linkedin.com/in/yusuf-abdilhaq/

---

**Terima kasih telah mengunjungi repositori ini!**
