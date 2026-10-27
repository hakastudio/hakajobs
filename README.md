# Hakajobs — Tema WordPress Portal Lowongan Kerja (Tanpa Login)

Tema WordPress profesional, modern, dan berkecepatan tinggi yang dirancang khusus untuk situs portal info lowongan kerja (*job board*) **tanpa sistem login yang rumit** bagi pelamar maupun perusahaan.

---

## 🌟 Mengapa Model "Tanpa Login"?

Sebagian besar portal loker lokal dan kurasi karir di Indonesia sukses karena **tanpa hambatan (*zero friction*)**:
1. **Untuk Pencari Kerja:** Pelamar tidak perlu membuat akun, menghafal kata sandi, atau memverifikasi email hanya untuk melihat info loker. Pelamar cukup mencari posisi, membaca kualifikasi, lalu klik tombol **Lamar via WhatsApp HRD**, **Kirim Email**, atau **Portal Resmi**.
2. **Untuk Bookmark:** Pencari kerja tetap dapat menandai dan menyimpan lowongan favorit menggunakan fitur **Browser LocalStorage Bookmark** yang terintegrasi langsung tanpa perlu login.
3. **Untuk Perusahaan / Rekruter:** Perusahaan menghubungi admin situs via WhatsApp/Email untuk mempublikasikan lowongan mereka, sehingga admin memiliki kendali penuh atas kurasi lowongan (mencegah spam dan penipuan).

---

## 📁 Struktur Berkas Tema

```text
Hakajobs/
├── style.css                  # Header metadata tema & deklarasi versi WordPress
├── functions.php              # Inisialisasi tema, enqueue script & style terkompresi, query filter
├── header.php                 # Header bar, menu navigasi responsif, tombol bookmark, mobile drawer
├── footer.php                 # Footer 4 kolom, anti-fraud banner, modal lowongan tersimpan, tombol Back to Top
├── front-page.php             # Template Beranda (Hero search, lowongan prioritas, daftar loker, sidebar)
├── single-lowongan.php        # Halaman Detail Lowongan (Deskripsi, kualifikasi, benefit, sticky apply box)
├── archive-lowongan.php       # Direktori Lowongan (Filter sidebar, sorting, pagination)
├── taxonomy.php               # Template arsip kategori, kota/wilayah, dan tipe pekerjaan
├── search.php                 # Template hasil pencarian lowongan
├── single.php                 # Template artikel berita/blog standar
├── page.php                   # Template halaman statis standar
├── category.php               # Template arsip artikel blog & kategori tips karir
├── sidebar.php                # Bilah sisi kanan (Widget Pasang Loker, Kategori, Lokasi, Lowongan Terpopuler)
├── template-with-sidebar.php  # Template halaman statis dengan sidebar kanan
├── template-full-width.php   # Template halaman statis lebar penuh tanpa sidebar
├── page-pasang-loker.php      # Landing page Pasang Loker (Daftar paket harga & formulir pengajuan)
├── page-tes-karir.php         # Template Pusat Tes & Karir (Soal SKD/BUMN, Psikotes, Panduan CV, Kuis CAT, E-Book)
├── page-saved.php             # Template khusus halaman "Lowongan Tersimpan"
├── 404.php                    # Halaman 404 ramah pengguna
├── OneSignalSDKWorker.js      # Service Worker OneSignal untuk Web Push Notification
├── screenshot.png             # Gambar pratinjau tema di dashboard WordPress
├── assets/
│   ├── css/
│   │   ├── main.css           # Sumber stylesheet utama tema
│   │   ├── main.min.css       # Versi minified produksi (otomatis dimuat)
│   │   ├── pasang-loker.css   # Stylesheet khusus halaman pasang loker
│   │   ├── pasang-loker.min.css # Versi minified pasang loker
│   │   ├── tes-karir.css      # Stylesheet khusus halaman Pusat Tes & Karir
│   │   └── tes-karir.min.css  # Versi minified tes-karir
│   ├── downloads/
│   │   └── E-Book-Kit-Persiapan-Kerja-2026.pdf # Modul e-book panduan karir & ringkasan rumus siap unduh
│   └── js/
│       ├── main.js            # Skrip interaktif (LocalStorage bookmark, drawer, modal, back to top)
│       └── main.min.js        # Versi minified produksi (otomatis dimuat)
└── inc/
    ├── post-types.php         # Custom Post Type 'lowongan' & Taksonomi (Kategori, Lokasi, Tipe, Pengalaman)
    ├── meta-boxes.php         # Custom Meta Box (Nama Perusahaan, Gaji, WhatsApp, Email, Batas Waktu)
    ├── customizer.php         # Panel pengaturan visual WordPress Customizer
    ├── push-notification.php  # Modul Web Push OneSignal resmi v16 (Pop-up Asli OneSignal.com)
    ├── template-tags.php      # Helper fungsi (Avatar inisial perusahaan, badge, format gaji)
    ├── sample-data.php        # Fitur 1-Klik Pasang Data Demo Lowongan
    ├── seo.php                # Fast-indexing engine & Google Schema JobPosting JSON-LD
    ├── ads.php                # Integrasi Google AdSense & slot penempatan iklan responsif
    ├── performance.php        # Optimasi kecepatan PageSpeed & eliminasi bloat WordPress
    ├── updater.php            # Handler pembaruan otomatis tema via GitHub Releases
    └── plugin-update-checker/ # Library resmi Plugin Update Checker (PUC)
```

---

## 🚀 Fitur Unggulan

### 1. Metode Lamaran Fleksibel (WhatsApp / Email / Web)
Admin dapat menentukan saluran pengiriman berkas lamaran untuk setiap lowongan:
- **WhatsApp Langsung ke HRD:** Tombol WhatsApp yang otomatis membuka chat dengan nomor HRD disertai draf pesan terstruktur standar rekrutmen: salam pembuka formal, posisi yang dilamar, tautan lowongan referensi, ringkasan profil pelamar, kesiapan berkas CV/portofolio, dan salam penutup.
- **Kirim Email Lamaran:** Membuka aplikasi email dengan subjek standar HR (`Lamaran Pekerjaan: [Posisi] - [Nama Lengkap Pelamar]`) serta draf surat lamaran resmi (*cover letter*) lengkap.
- **Tautan Eksternal:** Menghubungkan langsung ke Google Form pendaftaran atau portal karir resmi perusahaan.

#### 🏷️ Tag Dinamis Template Lamaran:
Admin dapat mengkustomisasi template pesan WhatsApp maupun Email di Meta Box setiap lowongan menggunakan tag berikut:
- `{posisi}` / `{job_title}` : Judul posisi lowongan kerja otomatis.
- `{perusahaan}` / `{company}` : Nama perusahaan pemasang loker.
- `{website}` / `{site_name}` : Nama situs portal lowongan kerja Anda.
- `{link}` / `{url}` / `{permalink}` : Tautan lengkap ke halaman detail lowongan.

*(Jika kolom template dikosongkan, sistem otomatis menerapkan template standar HRD profesional secara default).*

### 2. Fitur "Simpan Lowongan" (LocalStorage Bookmark)
Pelamar dapat menandai lowongan favorit mereka tanpa perlu registrasi akun:
- Indikator jumlah lowongan tersimpan di header.
- Modal drawer samping untuk melihat daftar simpanan kapan saja.
- Template halaman penuh khusus `page-saved.php`.

### 3. Otomatis Terindeks di Google Jobs (Schema.org JSON-LD)
Tema otomatis menyematkan kode Schema `JobPosting` terstruktur berstandar Google:
- **`baseSalary` Terstruktur:** Otomatis membaca nominal gaji dan mengubahnya ke format Google `MonetaryAmount` (`IDR`), rentang nilai `minValue`/`maxValue`, dan satuan waktu `MONTH`.
- **`streetAddress` & `postalCode`:** Memetakan alamat penempatan kantor dan kode pos.
- **Dukungan Pekerjaan Remote / WFH:** Menambahkan tag `"jobLocationType": "TELECOMMUTE"` otomatis jika lowongan bertipe Remote.

### 4. Countdown & Label Kedaluwarsa Otomatis
- **Deteksi Otomatis:** Sistem mendeteksi tanggal batas akhir lamaran (`_hakajobs_deadline`) terhadap zona waktu WordPress.
- **Badge "Segera Berakhir" (1–3 Hari Tersisa):** Memberikan sinyal urgensi bagi pencari kerja dengan label oranye.
- **Label "Pendaftaran Ditutup":** Muncul otomatis saat batas waktu telah lewat atau status ditandai tutup.
- **Nonaktifkan Tombol Lamar Otomatis:** Tombol lamaran dinonaktifkan otomatis agar pelamar tidak mengirim berkas ke loker yang sudah kedaluwarsa.

### 5. Filter Pencarian Canggih
Pencari kerja dapat menyaring direktori lowongan berdasarkan:
- Kata Kunci (Nama jabatan, keahlian, nama perusahaan)
- Kategori Industri / Profesi
- Kota / Lokasi (termasuk filter Remote / WFH)
- Tipe Pekerjaan (Full-Time, Part-Time, Kontrak, Magang, Freelance)
- Tingkat Pengalaman (Fresh Graduate, 1-3 Tahun, > 3 Tahun)
- Urutan Hasil (Terbaru, Terpopuler, Batas Waktu Terdekat)

### 6. Peringatan Resmi Anti-Penipuan
Mencegah pencari kerja tertipu oleh calo atau oknum berbayar dengan banner edukasi resmi pada footer dan catatan peringatan pada halaman detail lowongan (*"Seluruh proses rekrutmen GRATIS"*).

### 7. Saluran WhatsApp & Generator Broadcast Loker
- Tombol integrasi Saluran WhatsApp resmi untuk menambah followers situs.
- Generator teks broadcast otomatis siap salin di halaman admin & detail loker: rapi dengan emoji, posisi, nama perusahaan, kota, gaji, batas waktu, dan tautan resmi.
- Tombol aksi cepat *"📢 Broadcast WA"* langsung pada tabel daftar lowongan kerja di dashboard admin WordPress.

### 8. Kecepatan Tinggi & Bebas Bloat (PageSpeed Optimized)
- Otomatis memuat aset terkompresi produksi (`.min.css` dan `.min.js`).
- Eliminasi render-blocking JavaScript dengan atribut `defer`.
- Preconnect Google Fonts untuk mempercepat waktu First Contentful Paint (FCP).
- Pembersihan aset bloat WordPress bawaan yang tidak terpakai di frontend.

### 9. 1-Klik Pasang Data Demo (Sample Data Seeder)
Tersedia menu **Lowongan Kerja > Pasang Data Demo** di dashboard WordPress untuk mengisi situs baru dengan contoh lowongan kerja, kategori, dan kota realistis dalam satu klik.

### 10. Web Push Notifikasi Handphone (OneSignal Web SDK v16)
Kirim pemberitahuan instan langsung ke layar kunci (*lockscreen*) dan bilah notifikasi smartphone pengunjung (Android & iOS 16.4+) setiap kali loker atau artikel baru diterbitkan:
- **Pop-up Izin Resmi OneSignal:** Pop-up native OneSignal.com (browser prompt / slidedown) yang terstandarisasi, bersih, responsif, dan langsung dikonfigurasi dari dashboard OneSignal.
- **Pengiriman Otomatis via REST API:** WordPress otomatis menghubungi server OneSignal saat status loker/artikel beralih menjadi *Publish*.
- **Kendali Penuh di Editor Postingan:** Meta box panel khusus pada halaman tulis lowongan/artikel untuk mengatur apakah notifikasi ingin dikirim, kirim ulang saat revisi (*update*), atau kustomisasi judul & ringkasan pesan khusus.
- **Dukungan Rich Image:** Otomatis melampirkan poster/gambar unggulan (*Featured Image*) loker ukuran besar di layar HP penerima.
- **Berjalan Native di Browser:** Tidak membutuhkan aplikasi pihak ketiga atau instalasi PWA, berjalan langsung pada Chrome, Samsung Internet, Edge, dan Safari iOS.

---

## 🎨 Panel Pengaturan WordPress (WordPress Customizer)

Seluruh elemen tampilan dapat diatur secara visual melalui **Tampilan (Appearance) > Sesuaikan (Customize) > 🎨 Penyesuaian Tema Hakajobs**:

1. **🎨 Skema Warna & Branding:**
   - Warna Primer (*Primary Color*).
   - Warna Hover Primer.
   - Warna Latar Belakang Situs (*Body Background*).
   - Warna Gelap Bar (*Topbar & Footer*).
   - Warna Tombol WhatsApp (*WhatsApp Green*).
2. **🧭 Header & Navigasi:**
   - Slider tinggi logo gambar (20px – 70px) agar proporsional dan tidak kebesaran.
   - Slider ukuran teks nama situs (14px – 32px) jika tidak menggunakan logo gambar.
   - Slider besar/kecil ikon emoji (16px – 44px).
   - Opsi Sticky Header (header tetap di atas saat scroll).
   - Tampilkan / sembunyikan slogan situs (*tagline*).
   - Ikon logo emoji kustom (contoh: 💼, 🚀, 🏢).
   - Teks & tautan tombol CTA utama header (default: *Pasang Loker*).
   - Tampilkan / sembunyikan tombol Simpan Loker (*Bookmark*).
3. **📢 Bilah Pengumuman (Topbar):**
   - Tampilkan / sembunyikan topbar.
   - Teks badge pengumuman (contoh: *Terverifikasi*).
   - Pesan pengumuman utama dan tautan cepat.
4. **⬆️ Tombol Kembali ke Atas (Back to Top):**
   - Aktifkan / nonaktifkan tombol Back to Top melayang.
   - Pilihan warna tombol Back to Top.
5. **🏠 Halaman Beranda:**
   - Pilihan gaya Hero (*Navy Sleek, Clean Light, Split Modern, Compact Search*).
   - Judul H1 hero, subjudul, placeholder input pencarian, dan tombol cari.
   - Tampilkan / sembunyikan bagian Lowongan Prioritas (*Spotlight*).
   - Teks badge, judul section, dan subjudul Lowongan Prioritas.
   - Kustomisasi blok "Cara Melamar Kerja" (3 langkah panduan melamar).
6. **🛡️ Peringatan Anti-Penipuan:**
   - Tampilkan / sembunyikan banner anti-penipuan di atas footer.
   - Kustomisasi judul dan isi pesan peringatan.
7. **📋 Footer & Hak Cipta:**
   - Paragraf "Tentang Kami" footer.
   - Teks hak cipta / copyright kustom.
   - Konfigurasi tautan media sosial pemilik situs (WhatsApp, Telegram, LinkedIn, Facebook, Instagram) dengan ikon SVG modern.
8. **🔍 SEO & Verifikasi Mesin Pencari:**
   - Mesin SEO otomatis (Meta Description dinamis, Canonical URL, Open Graph, Twitter Cards).
   - Kolom verifikasi resmi Google Search Console dan Bing Webmaster Tools.
   - Schema JSON-LD WebSite (Sitelinks Searchbox) dan BreadcrumbList.
9. **💰 Google AdSense & Penempatan Iklan:**
   - Saklar aktifkan/nonaktifkan penayangan iklan.
   - Kolom ID Klien AdSense (`ca-pub-XXXXX`) untuk mengaktifkan Auto Ads otomatis.
   - Kolom skrip verifikasi peninjauan situs (*Site Review Script*).
   - Slot unit iklan responsif berlabel resmi:
     - **Slot Header** (Leaderboard 728×90 / Responsif)
     - **Slot Sidebar** (300×250 / 300×600)
     - **Slot Dalam Lowongan — Atas Deskripsi**
     - **Slot Dalam Lowongan — Bawah Deskripsi**
     - **Slot Banner Bawah** (Sebelum Footer)
   - Mode Pratinjau Iklan (*Placeholder*) untuk melihat tata letak slot iklan sebelum akun disetujui.
10. **💼 Halaman Pasang Loker & Tarif:**
    - Kustomisasi gaya hero pasang loker (*Navy Klasik, Split Converter, Minimalist*).
    - Penyesuaian harga dan rincian benefit paket Featured & Urgent.
    - Nomor WhatsApp admin dan email penerima pesanan pemasangan iklan.
11. **🔔 Notifikasi Web Push OneSignal:**
    - Saklar aktifkan/nonaktifkan Web Push OneSignal.
    - **OneSignal App ID:** ID unik aplikasi OneSignal (contoh: `fa8d0207-13ae-4f12-9058-d910ade5f80a`).
    - **OneSignal REST API Key:** Kunci API otorisasi server OneSignal (tipe *Admin Key*).
    - **OneSignal Safari Web ID (Opsional):** ID dukungan browser Safari (contoh: `web.onesignal.auto.xxxxxx`).
    - Saklar kirim otomatis: saat Lowongan Kerja baru terbit & saat Artikel baru terbit.
    - Pilihan kirim notifikasi otomatis saat konten diedit / diperbarui (*update*).
    - Format judul notifikasi dinamis (mendukung tag `{title}`, `{company}`, `{site_name}`).
    - Opsi tampilkan poster gambar unggulan (*Featured Image*) berukuran besar di layar HP.
    - **Pop-up Izin Bawaan OneSignal:** Notifikasi izin browser langsung ditangani oleh skrip resmi OneSignal tanpa popup kartu manual tema, menghindari prompt ganda dan menjamin kepatuhan browser modern.

---

## 🛠️ Petunjuk Instalasi & Setup Cepat

1. Unggah folder tema `Hakajobs` ke direktori WordPress Anda di:
   ```text
   wp-content/themes/Hakajobs
   ```
2. Buka dashboard WordPress: **Tampilan (Appearance) > Tema (Themes)**.
3. Cari tema **Hakajobs** lalu klik **Aktifkan (Activate)**.
4. Buka **Pengaturan (Settings) > Permalinks**, pilih format **Nama Tulisan (Post name)**, lalu klik **Simpan Perubahan**.
5. Buka menu **Lowongan Kerja > Pasang Data Demo** dan klik **Pasang Sekarang** untuk langsung mengisi situs dengan data contoh.
6. **Mengatur Menu Navigasi:**
   - Buka **Tampilan > Menu**.
   - Buat menu baru, centang lokasi **Menu Utama (Header)**.
   - Tambahkan item menu (Beranda, Semua Lowongan, Remote / WFH, Magang, Pasang Loker, dll.).
   - Atur menu footer pada lokasi kolom yang tersedia jika diperlukan.
7. **Kustomisasi Tampilan:**
   - Buka **Tampilan > Sesuaikan (Customize)** untuk mengatur logo, warna branding, hero, dan iklan AdSense sesuai kebutuhan.

---

## 📝 Cara Menambahkan Lowongan Kerja Baru

1. Masuk ke dashboard WordPress > **Lowongan Kerja > Tambah Baru**.
2. Masukkan **Judul Posisi** (Contoh: *Senior Frontend Developer*).
3. Isi deskripsi pekerjaan, tanggung jawab, dan kualifikasi pada editor teks.
4. Pada panel **Detail Pekerjaan & Perusahaan**:
   - Masukkan Nama Perusahaan & Lokasi/Alamat Penempatan.
   - Masukkan Kisaran Gaji (Contoh: *Rp 8.000.000 - Rp 12.000.000* atau *Kompetitif*).
   - Tentukan Batas Akhir Lamaran (*Deadline*).
   - Centang opsi *Sorotan (Featured)* atau *Urgent* jika lowongan berbayar/diprioritaskan.
5. Pada panel **Metode Lamaran Kerja**:
   - Pilih WhatsApp, Email, atau Link Web.
   - Masukkan nomor WhatsApp HRD atau email penerima lamaran.
6. Pilih Kategori, Lokasi, dan Tipe Pekerjaan di panel taksonomi sebelah kanan.
7. Unggah logo perusahaan pada bagian **Gambar Unggulan (Featured Image)**. Jika tidak diunggah, sistem otomatis membuatkan avatar inisial perusahaan yang rapi dan elegan.
8. Klik **Terbitkan (Publish)**.

---

## 🖼️ Panduan Ukuran & Format Logo Perusahaan

Untuk memastikan tampilan kartu lowongan terlihat tajam dan memenuhi standar Google Rich Results:

| Parameter | Rekomendasi | Keterangan |
| :--- | :--- | :--- |
| **Rasio Gambar** | **1:1 (Persegi / Square)** | Wajib 1:1 agar logo proporsional saat ditampilkan pada kartu loker |
| **Dimensi Ideal** | **`512 x 512 px`** | Resolusi paling tajam di layar Retina / smartphone modern |
| **Dimensi Minimal** | **`256 x 256 px`** | Batas minimal yang dianjurkan (Google Jobs mewajibkan min. `112 x 112 px`) |
| **Format Berkas** | **PNG Transparan / WebP / JPG** | PNG transparan atau latar belakang putih sangat disarankan |
| **Ukuran Berkas** | **< 150 KB** | Kompres gambar agar loading halaman tetap cepat |

- **Daftar Lowongan (Job Card):** Ditampilkan otomatis pada dimensi `52 x 52 px`.
- **Detail Lowongan (Single Header):** Ditampilkan otomatis pada dimensi `80 x 80 px`.
- **Fallback Otomatis:** Jika gambar logo tidak diunggah, Hakajobs otomatis menampilkan avatar inisial nama perusahaan berbasis teks.

---

## 💼 Alur Monetisasi & Pasang Loker

Karena tema ini dirancang tanpa registrasi login umum, fitur **"Pasang Loker"** bekerja melalui alur kurasi admin yang aman dan terbukti efektif:

1. **Pengunjung Membuka Halaman `/pasang-loker/`:**
   Perusahaan atau rekruter yang ingin memasang lowongan dapat melihat paket penayangan (Basic, Featured, Urgent) dan membaca ketentuan.
2. **Pengajuan via WhatsApp atau Formulir:**
   Perusahaan mengirimkan materi lowongan melalui WhatsApp Admin atau formulir pengajuan yang tersedia.
3. **Penerbitan Dilakukan oleh Admin:**
   Admin memverifikasi keaslian lowongan, menerima pembayaran biaya publikasi, lalu menerbitkan loker dari dashboard WordPress.
4. **Keuntungan Model Ini:**
   - 🛡️ **Bebas Spam:** Mencegah bot atau pihak tidak bertanggung jawab memasang lowongan palsu/penipuan secara sembarangan.
   - 💰 **Monetisasi Penuh:** Pemilik situs memegang kendali 100% atas pembayaran iklan.
   - ⚡ **Ringan & Aman:** Basis data situs tidak terbebani oleh akun pengguna yang tidak aktif.

---

## 🔔 Panduan Integrasi Web Push OneSignal

Tema Hakajobs sudah dilengkapi integrasi Web Push OneSignal langsung tanpa memerlukan instalasi plugin tambahan pihak ketiga. Notifikasi akan otomatis muncul di handphone pengunjung (Android & iOS 16.4+) setiap kali loker atau artikel baru diterbitkan.

### 1. Buat Akun & Aplikasi di OneSignal
1. Kunjungi [OneSignal.com](https://onesignal.com) dan daftar akun gratis *(Free tier s/d 10.000 subscriber)*.
2. Klik **New App/Website**.
3. Masukkan nama aplikasi Anda (contoh: `Loker Lampung`), pilih platform **Web Push**, lalu klik **Next: Configure Platform**.

### 2. Konfigurasi Web Push
1. Pada pilihan integrasi, pilih **Custom Code** (atau **Typical Site**).
2. Isi informasi website Anda:
   - **Site Name:** Nama website Anda (contoh: `Info Loker Lampung`).
   - **Site URL:** Alamat lengkap website Anda ber-HTTPS (contoh: `https://infolokerlampung.com`).
   - **Auto Resubscribe (HTTPS Only):** Aktifkan (*ON*).
   - **Default Icon URL:** Masukkan link logo situs rasio 1:1 (min. `192x192 px`).
3. Klik **Save**.
4. **Pop-up Izin Resmi OneSignal:** Pada bagian **Permission Prompt Setup**, Anda dapat menyesuaikan tampilan prompt bawaan OneSignal (misal: Slidedown prompt, Native Browser Prompt, atau Bell Icon) langsung dari dashboard OneSignal. Pop-up ini akan tampil secara native dan terintegrasi di website.
5. OneSignal akan menampilkan kode script HTML. **PENTING: Jangan salin tag `<script>` ke WordPress**, karena tema Hakajobs sudah mengintegrasikan OneSignal Web SDK v16 secara otomatis.

### 3. Ambil Kunci & ID dari OneSignal
1. Buka menu **Settings** di bilah atas OneSignal, lalu pilih **Keys & IDs** (atau **API Keys**).
2. Salin nilai berikut:
   - **OneSignal App ID:** Kode UUID 36 karakter (contoh: `fa8d0207-13ae-4f12-9058-d910ade5f80a`).
   - **OneSignal Safari Web ID (Opsional):** Kode Safari jika ada (contoh: `web.onesignal.auto.xxxxxx`).
3. Pada bagian **REST API Keys**, klik tombol **+ Add Key** (atau **+ Tambahkan Kunci**):
   - Pilih tipe: **Admin Key** (Kunci Admin).
   - Beri nama: `WordPress Server Key`.
   - Klik **Create** / **Simpan**, lalu salin kunci panjang yang muncul (diawali `os_v2_app_...`).

### 4. Masukkan Kunci ke Dashboard WordPress
1. Buka dashboard WordPress Anda.
2. Masuk ke **Tampilan** > **Sesuaikan** > **🔔 Notifikasi Web Push OneSignal**.
3. Masukkan kode bersih ke kolom masing-masing:
   - **OneSignal App ID:** `fa8d0207-13ae-4f12-9058-d910ade5f80a` *(HANYA kodenya saja, tanpa tanda kutip atau tag script)*.
   - **OneSignal REST API Key:** Masukkan kunci Admin Key (`os_v2_app_...`).
   - **OneSignal Safari Web ID (Opsional):** Masukkan ID Safari Anda jika ada.
4. Gulir ke bagian paling atas sebelah kiri, lalu klik tombol biru **"Terbitkan"** (*Publish*).

### 5. Cara Kerja Notifikasi
- **Izin Berlangganan Pengunjung:** Pop-up izin resmi OneSignal.com akan tampil secara bersih sesuai aturan browser modern.
- **Pengiriman Otomatis:** Setiap kali Anda mempublikasikan loker kerja atau artikel baru, notifikasi otomatis terkirim ke HP pengunjung lengkap dengan judul, ringkasan, dan banner gambar.
- **Pengaturan Per-Postingan:** Pada halaman edit loker/artikel, tersedia panel meta box di sebelah kanan untuk menyalakan/mematikan notifikasi untuk postingan tertentu atau mengubah teks notifikasi khusus.

---

## 🔄 Pembaruan Tema Otomatis (GitHub Releases)

Tema **Hakajobs** sudah dilengkapi engine pembaruan otomatis bawaan menggunakan library **Plugin Update Checker (PUC)** yang terhubung langsung ke GitHub Releases.

### Cara Kerja:
1. Ketika rilis versi baru diterbitkan di GitHub, dashboard WordPress akan otomatis menampilkan notifikasi pembaruan di menu **Dashboard > Pembaruan** atau **Tampilan > Tema**.
2. Anda cukup klik **Perbarui Sekarang (Update Now)** dan WordPress akan mengunduh serta memperbarui berkas tema secara otomatis.
3. Sistem secara otomatis menstandarkan penamaan folder tema menjadi `hakajobs/` saat ekstraksi rilis sehingga terhindar dari error stylesheet hilang.

---

© Hakajobs. Dibuat dengan standar WordPress modern, berkecepatan tinggi, dan ramah SEO.
