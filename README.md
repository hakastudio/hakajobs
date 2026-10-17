# Hakajobs — Tema WordPress Portal Lowongan Kerja (Tanpa Login)

Tema WordPress profesional, modern, dan berkecepatan tinggi yang dirancang khusus untuk situs portal info lowongan kerja (job board) **tanpa sistem login yang rumit** bagi pelamar maupun perusahaan.

---

## 🌟 Mengapa Model "Tanpa Login"?

Sebagian besar portal loker lokal dan kurasi karir di Indonesia sukses karena **tanpa hambatan (zero friction)**:
1. **Untuk Pencari Kerja:** Pelamar tidak perlu membuat akun, menghafal password, atau memverifikasi email hanya untuk melihat info loker. Mereka cukup mencari posisi, membaca kualifikasi, lalu klik tombol **Lamar via WhatsApp HRD**, **Kirim Email**, atau **Portal Resmi**.
2. **Untuk Bookmark:** Pencari kerja tetap dapat menandai dan menyimpan lowongan favorit menggunakan fitur **Browser LocalStorage Bookmark** yang sudah terintegrasi tanpa perlu login!
3. **Untuk Perusahaan / Rekruter:** Perusahaan menghubungi admin website via WhatsApp/Email untuk mempublikasikan lowongan mereka, sehingga admin memiliki kontrol penuh atas kurasi lowongan (mencegah spam dan penipuan).

---

## 📁 Struktur Berkas Tema

```
Hakajobs/
├── style.css                  # Header metadata tema & deklarasi WordPress
├── functions.php              # Pengaturan tema, enqueue script & style, query filter
├── header.php                 # Header bar, menu navigasi, tombol bookmark, mobile drawer
├── footer.php                 # Footer 4 kolom, anti-fraud banner, modal lowongan tersimpan
├── front-page.php             # Halaman Beranda (Hero search, spotlight, daftar loker, sidebar)
├── single-lowongan.php        # Halaman Detail Lowongan (Deskripsi, benefit, sticky apply box)
├── archive-lowongan.php       # Direktori Lowongan (Filter sidebar, sorting, pagination)
├── taxonomy.php               # Template arsip kategori & kota
├── search.php                 # Halaman hasil pencarian
├── single.php                 # Template artikel blog standar
├── page.php                   # Template halaman statis (Tentang, Kontak, Pasang Loker)
├── page-saved.php             # Template khusus "Lowongan Tersimpan"
├── 404.php                    # Halaman 404 ramah pengguna
├── screenshot.png             # Gambar pratinjau tema di dashboard WordPress
├── assets/
│   ├── css/
│   │   └── main.css           # Sistem desain CSS modern, token warna, responsif
│   └── js/
│       └── main.js            # Sistem bookmark LocalStorage, drawer modal, copy link
└── inc/
    ├── post-types.php         # Custom Post Type 'lowongan' & Taksonomi (Kategori, Lokasi, Tipe, dll.)
    ├── meta-boxes.php         # Custom Meta Box (Nama Perusahaan, Gaji, WhatsApp, Email, Deadline)
    ├── template-tags.php      # Helper fungsi (Logo/Inisial avatar, Schema JobPosting SEO)
    └── sample-data.php        # Fitur 1-Klik Pasang Data Demo Lowongan Realistis
```

---

## 🚀 Fitur Unggulan

### 1. Metode Lamaran Fleksibel (WhatsApp / Email / Web)
Pada setiap lowongan, admin dapat memilih metode pengiriman berkas:
- **WhatsApp Langsung:** Tombol hijau WhatsApp yang otomatis membuka chat dengan nomor HRD serta pesan pembuka yang sudah disiapkan (pre-filled text).
- **Email Lamaran:** Membuka aplikasi email pelamar dengan alamat email HRD dan subjek yang sudah otomatis terisi.
- **Tautan Eksternal:** Menghubungkan langsung ke Google Form pendaftaran atau portal karir resmi perusahaan.

### 2. Fitur "Simpan Lowongan" (LocalStorage Bookmark)
Pelamar dapat menandai lowongan favorit mereka. Data disimpan langsung di peramban (browser) pengguna:
- Ada indikator jumlah lowongan tersimpan di header.
- Terdapat modal drawer untuk melihat daftar simpanan kapan saja.
- Terdapat template halaman penuh `page-saved.php`.

### 3. Otomatis Terindeks di Google Jobs (Schema.org JSON-LD)
Tema ini otomatis menyisipkan kode Schema `JobPosting` terstruktur pada setiap halaman single lowongan kerja sehingga peluang muncul di hasil pencarian Google Jobs meningkat drastis.

### 4. Kotak Informasi & Banner Anti Penipuan
Mencegah pencari kerja tertipu oleh calo/oknum berbayar dengan peringatan resmi pada footer dan setiap halaman lowongan.

### 5. Filter Pencarian Canggih
Pencari kerja dapat menyaring loker berdasarkan:
- Kata Kunci (Nama jabatan, skill, perusahaan)
- Kategori Industri
- Kota / Lokasi (termasuk tag Remote / WFH)
- Tipe Pekerjaan (Penuh Waktu, Paruh Waktu, Kontrak, Magang, Freelance)
- Tingkat Pengalaman (Fresh Graduate, 1-3 Tahun, > 3 Tahun)
- Urutan (Terbaru, Terpopuler, Deadline Terdekat)

### 6. 1-Klik Pasang Data Demo (Sample Data Seeder)
Tersedia menu **Lowongan Kerja > Pasang Data Demo** di dashboard WordPress. Cukup klik satu tombol, dan 6+ contoh lowongan kerja realistis di Indonesia langsung terbuat beserta kategori, kota, dan konfigurasinya.

### 7. Panel Penyesuaian WordPress Lengkap (WordPress Customizer)
Seluruh elemen tampilan dapat diatur secara visual melalui **Tampilan (Appearance) > Sesuaikan (Customize) > 🎨 Penyesuaian Tema Hakajobs**:
1. **🎨 Skema Warna & Branding:** Atur warna primer, hover, warna latar belakang (body bg), aksen, dan warna WhatsApp langsung dengan color picker langsung (live preview).
2. **🧭 Header & Navigasi:**
   - **📏 Pengaturan Besar Kecil Logo Gambar:** Slider tinggi logo gambar (20px - 70px, default: 42px) agar logo gambar pas dengan header dan tidak kebesaran. Dapat diakses juga di menu bawaan **Identitas Situs (Site Identity)**.
   - **🔤 Pengaturan Ukuran Teks Nama Situs:** Slider ukuran font nama situs (14px - 32px) jika tidak memakai logo gambar.
   - **✨ Pengaturan Ukuran Ikon Logo Emoji:** Slider besar/kecil ikon emoji (16px - 44px).
   - Aktifkan/nonaktifkan Sticky Header (header melayang saat scroll).
   - Tampilkan/sembunyikan Slogan (Tagline) situs.
   - Ganti emoji/ikon logo brand header (contoh: 💼, 🚀, 🏢).
   - Ganti teks & URL tombol CTA utama header (default: *Pasang Loker*).
   - Aktifkan/nonaktifkan tombol Simpan Loker (Bookmark).
   - Atur label & URL dua tautan cepat di bilah pengumuman atas.
3. **📢 Bilah Pengumuman (Topbar):** Tampilkan/sembunyikan topbar, ganti teks badge (contoh: *Terverifikasi*), dan ganti pesan pengumuman utama.
4. **⬆️ Tombol Kembali ke Atas (Back to Top):** Tombol melayang di pojok kanan bawah yang muncul otomatis saat scroll, lengkap dengan kontrol warna tombol.
5. **🏠 Halaman Beranda (Hero):** Atur judul H1, paragraf subjudul, teks placeholder pencarian, dan teks tombol pencarian.
6. **🛡️ Peringatan Anti Penipuan:** Tampilkan/sembunyikan banner anti-penipuan di atas footer, ubah judul & isi peringatan rekrutmen.
7. **📋 Footer & Hak Cipta:** Ubah paragraf "Tentang Kami" footer dan teks hak cipta/copyright kustom.
8. **🔍 SEO & Verifikasi Mesin Pencari:**
   - Aktifkan mesin SEO otomatis (Meta Description dinamis, Canonical URL, Open Graph untuk WhatsApp/Facebook, Twitter Cards, robots indexing tag).
   - Kolom verifikasi resmi Google Search Console dan Bing Webmaster Tools.
   - Schema JSON-LD terstruktur: WebSite (Sitelinks Searchbox), BreadcrumbList, dan Google JobPosting otomatis.
9. **💰 Google AdSense & Penempatan Iklan:**
   - Saklar utama aktifkan/nonaktifkan penayangan iklan.
   - Kolom ID Klien AdSense (contoh: `ca-pub-XXXXX`) untuk mengaktifkan Auto Ads secara otomatis di header.
   - Kolom skrip verifikasi peninjauan situs (*Site Review Script*).
   - Unit slot iklan strategis yang mematuhi kebijakan Google AdSense (*AdSense Policy Compliant*):
     - **Slot Header / Banner Atas** (Leaderboard 728x90 atau Responsif)
     - **Slot Sidebar** (Kotak 300x250 atau 300x600)
     - **Slot Dalam Lowongan — Atas Deskripsi** (In-Article Responsif)
     - **Slot Dalam Lowongan — Bawah Deskripsi** (In-Article Responsif)
     - **Slot Banner Bawah** (Sebelum Footer)
   - Mode Preview Iklan (Placeholder) untuk melihat tata letak kotak iklan sebelum akun AdSense aktif.

---

## 🔍 Panduan Optimasi SEO & Indeks Cepat Google

1. **Google Search Console:**
   - Buka Google Search Console, tambahkan properti URL website Anda.
   - Salin kode verifikasi tag HTML, lalu tempelkan di **Tampilan > Sesuaikan > 🎨 Penyesuaian Tema Hakajobs > 🔍 SEO & Verifikasi Mesin Pencari**.
2. **Kaya Snippet Google Jobs:**
   - Setiap lowongan otomatis menghasilkan data terstruktur `JobPosting` dengan format resmi Google.
3. **Pratinjau Medsos / WhatsApp:**
   - Saat link lowongan dibagikan ke WhatsApp atau media sosial, gambar thumbnail, judul posisi, nama perusahaan, serta kisaran gaji otomatis muncul sebagai kartu preview yang menarik.

---

## 💰 Panduan Pemasangan Google AdSense

1. **Pendaftaran AdSense:**
   - Daftarkan domain website Anda di Google AdSense.
2. **Memasang Kode Verifikasi / Auto Ads:**
   - Masuk ke **Tampilan > Sesuaikan > 🎨 Penyesuaian Tema Hakajobs > 💰 Google AdSense & Penempatan Iklan**.
   - Masukkan ID Klien Anda (contoh: `ca-pub-1234567890123456`) pada kolom **ID Klien Google AdSense**.
3. **Memasang Unit Iklan Manual (Opsional):**
   - Buat unit iklan Responsif di dashboard AdSense.
   - Salin dan tempel kode `<ins class="adsbygoogle" ...></ins>` ke slot yang diinginkan (Header, Sidebar, atau Dalam Lowongan).
4. **Kepatuhan Kebijakan AdSense:**
   - Tema ini secara otomatis menyertakan label resmi **"IKLAN"** di atas setiap unit iklan sesuai aturan ketat AdSense agar terhindar dari invalid click atau penolakan akun.

## 💼 Cara Kerja Tombol "Pasang Loker" (Monetisasi & Alur Kerja)

Karena tema ini dirancang **tanpa sistem login/registrasi pengguna luar**, tombol **"Pasang Loker"** di header & menu bekerja melalui alur kurasi admin yang aman dan terbukti ampuh:

1. **Tombol Mengarah ke Halaman Informasi / Kontak:**
   - Secara default, tombol mengarah ke `/pasang-loker/` (bisa diubah ke URL formulir Google Form, WhatsApp Admin, atau halaman panduan tarif pasang iklan).
2. **Alur Perusahaan Memasang Loker:**
   - Perusahaan / rekruter yang ingin memasang lowongan membuka link tersebut dan membaca syarat & ketentuan.
   - Perusahaan mengirim materi lowongan ke Admin melalui **WhatsApp Admin**, **Email**, atau mengisi **Google Form / WPForms**.
   - Admin dapat menetapkan biaya publikasi (monetisasi berbayar atau gratis).
3. **Penerbitan Dilakukan oleh Admin:**
   - Admin memasukkan lowongan ke dashboard WordPress (**Lowongan Kerja > Tambah Baru**).
   - Keuntungan model ini:
     - 🛡️ **Bebas Spam:** Mencegah bot atau oknum nakal memasang loker palsu/penipuan langsung di situs Anda.
     - 💰 **Monetisasi Penuh:** Anda sebagai pemilik web memegang kendali penuh atas pembayaran iklan loker dari perusahaan.
     - ⚡ **Ringan & Aman:** Website tidak terbebani database ratusan user perusahaan yang tidak aktif.

---

## 🛠️ Petunjuk Instalasi & Pengaturan Menu

1. Salin atau unggah folder `Hakajobs` ke dalam direktori WordPress Anda di:
   ```
   wp-content/themes/Hakajobs
   ```
2. Buka dashboard WordPress Anda: **Tampilan (Appearance) > Tema (Themes)**.
3. Cari **Hakajobs** lalu klik **Aktifkan (Activate)**.
4. Buka **Pengaturan (Settings) > Permalinks**, pilih **Nama Tulisan (Post name)**, lalu klik **Simpan Perubahan**.
5. Buka menu **Lowongan Kerja > Pasang Data Demo** dan klik **Pasang Sekarang** untuk langsung melihat website Anda terisi data contoh yang rapi.
6. **Mengatur Menu Navigasi:**
   - Buka **Tampilan > Menu**.
   - Buat menu baru (misal: "Menu Utama"), centang lokasi **Menu Utama (Header)**.
   - Tambahkan item menu seperti: Beranda, Semua Lowongan, Remote / WFH, Magang, Kontak, dll.
   - Buat menu untuk **Menu Footer** jika ingin tautan navigasi khusus di bagian bawah.
7. **Kustomisasi Tampilan:**
   - Buka **Tampilan > Sesuaikan (Customize)**.
   - Masuk ke tab **🎨 Penyesuaian Tema Hakajobs** untuk mengubah warna, teks header, hero beranda, dan banner pengumuman.

---

## 📝 Cara Menambahkan Lowongan Kerja Baru

1. Masuk ke dashboard WordPress > **Lowongan Kerja > Tambah Baru**.
2. Masukkan **Judul Posisi** (Contoh: *Staff Administrasi Gudang*).
3. Isi deskripsi pekerjaan, tanggung jawab, dan kualifikasi pada editor teks.
4. Pada kotak **Detail Pekerjaan & Perusahaan**:
   - Masukkan Nama Perusahaan & Lokasi/Alamat.
   - Masukkan Kisaran Gaji (Contoh: *Rp 5.500.000 - Rp 7.000.000* atau *Kompetitif*).
   - Tentukan Batas Akhir Lamaran (Deadline).
   - Centang opsi *Sorotan (Featured)* atau *Urgent* jika dibutuhkan.
5. Pada kotak **Metode Lamaran Kerja**:
   - Pilih WhatsApp, Email, atau Link Web.
   - Masukkan nomor WhatsApp HRD atau email penerima lamaran.
6. Pilih Kategori, Lokasi, dan Tipe Pekerjaan di panel sebelah kanan.
7. Unggah logo perusahaan pada bagian **Logo Perusahaan / Banner** (Featured Image). Jika tidak diunggah, sistem akan secara otomatis membuat avatar inisial perusahaan yang elegan.
8. Klik **Terbitkan (Publish)**!

---

## 🔄 Pembaruan Tema Otomatis (GitHub Releases)

Tema **Hakajobs** sudah dilengkapi dengan engine pembaruan otomatis bawaan menggunakan library **Plugin Update Checker (PUC)** yang terhubung langsung ke GitHub Releases.

### Cara Kerja:
1. Ketika Anda merilis versi baru di GitHub (misalnya rilis `v1.0.1`), dashboard WordPress akan otomatis menampilkan notifikasi pembaruan di menu **Dashboard > Pembaruan** atau **Tampilan > Tema**.
2. Anda cukup klik **Perbarui Sekarang (Update Now)** dan WordPress akan mengunduh serta mengganti tema dengan versi terbaru secara otomatis tanpa perlu mengunggah ulang file zip.
3. Fitur **Background Auto-Update** juga sudah aktif secara bawaan untuk tema ini.

### Konfigurasi URL Repository GitHub:
Secara bawaan tema mengarah ke `https://github.com/hakastudio/hakajobs`. Anda dapat mengubah URL repository ke akun GitHub pribadi/organisasi Anda dengan menambahkan konfigurasi berikut di file `wp-config.php`:

```php
// URL Repository GitHub tema Anda
define('HAKAJOBS_GITHUB_REPO', 'https://github.com/USERNAME_ANDA/NAMA_REPO');

// Opsional: Jika repository Anda bersifat Private, gunakan Personal Access Token GitHub
define('HAKAJOBS_GITHUB_TOKEN', 'ghp_yourPersonalAccessTokenHere');

// Opsional: Cabang Git (default: main)
define('HAKAJOBS_GITHUB_BRANCH', 'main');
```

Atau menggunakan filter hook di child theme / mu-plugins:
```php
add_filter('hakajobs_github_repo_url', function() {
    return 'https://github.com/USERNAME_ANDA/NAMA_REPO';
});
```

---

© Hakajobs Studio. Dibuat dengan standar WordPress modern & ramah SEO.

