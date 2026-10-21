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
├── page.php                   # Template halaman statis (Tentang, Kontak, dll.)
├── sidebar.php                # Bilah sisi kanan (Pasang Loker, Kategori, Lokasi, Tips & Widget WP)
├── template-with-sidebar.php  # Template halaman statis dengan sidebar kanan
├── template-full-width.php   # Template halaman statis lebar penuh tanpa sidebar
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
- **WhatsApp Langsung ke HRD (Format Profesional Otomatis):** Tombol WhatsApp yang otomatis membuka chat dengan nomor HRD disertai draf pesan terstruktur standar rekrutmen: salam pembuka formal, posisi yang dilamar, tautan lowongan sebagai referensi, ringkasan profil pelamar (Nama, Domisili, Pendidikan/Pengalaman), kesiapan berkas CV/portofolio, dan salam penutup.
- **Kirim Email Lamaran (Mailto Surat Resmi):** Membuka aplikasi email dengan subjek standar HR (`Lamaran Pekerjaan: [Posisi] - [Nama Lengkap Pelamar]`) serta format surat lamaran resmi (cover letter) lengkap dengan detail posisi, sumber informasi situs, profil ringkas, lampiran berkas (CV & Portofolio), dan tanda tangan kontak pelamar.
- **Tautan Eksternal:** Menghubungkan langsung ke Google Form pendaftaran atau portal karir resmi perusahaan.

#### 🏷️ Tag Dinamis Template Lamaran:
Admin dapat mengkustomisasi template pesan WhatsApp maupun Email di Meta Box setiap lowongan menggunakan tag berikut:
- `{posisi}` / `{job_title}` : Judul posisi lowongan kerja otomatis.
- `{perusahaan}` / `{company}` : Nama perusahaan pemasang loker.
- `{website}` / `{site_name}` : Nama situs portal lowongan kerja Anda.
- `{link}` / `{url}` / `{permalink}` : Tautan lengkap ke halaman detail lowongan.

*(Jika kolom template dikosongkan, sistem otomatis menerapkan template standar HRD profesional secara default).*

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
- Tipe Pekerjaan (Full-Time, Part-Time, Kontrak, Magang, Freelance)
- Tingkat Pengalaman (Fresh Graduate, 1-3 Tahun, > 3 Tahun)
- Urutan (Terbaru, Terpopuler, Deadline Terdekat)

### 6. 1-Klik Pasang Data Demo (Sample Data Seeder)
Tersedia menu **Lowongan Kerja > Pasang Data Demo** di dashboard WordPress. Cukup klik satu tombol, dan 6+ contoh lowongan kerja realistis di Indonesia langsung terbuat beserta kategori, kota, dan konfigurasinya.

### 7. Countdown & Status Kedaluwarsa Otomatis (Deadline Expired Badge) — v1.0.13
Menjaga informasi lowongan selalu akurat dan terpercaya bagi pelamar maupun rekruter:
- **Deteksi Otomatis:** Sistem mendeteksi tanggal batas akhir lamaran (`_hakajobs_deadline`) secara otomatis terhadap zona waktu WordPress.
- **Badge "Segera Berakhir" (⏳ 1–3 Hari Tersisa):** Memberikan sinyal urgensi bagi pencari kerja dengan label oranye dan countdown sisa hari.
- **Label Merah "Pendaftaran Ditutup" (🚫):** Muncul otomatis ketika batas waktu telah lewat atau saat status ditandai `tutup`.
- **Nonaktifkan Tombol Lamar Otomatis:** Tombol kirim lamaran (WhatsApp / Email / Web Portal) otomatis dinonaktifkan sehingga pelamar tidak mengirimkan berkas ke loker yang sudah kedaluwarsa.
- **Notifikasi Ramah:** Dilengkapi banner peringatan dan tombol pengalihan untuk mencari lowongan kerja serupa lainnya.

### 8. Panel Penyesuaian WordPress Lengkap (WordPress Customizer)
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
5. **🏠 Halaman Beranda & Cara Melamar:** Atur judul H1 hero, subjudul, placeholder pencarian, tombol cari, judul & subjudul Lowongan Sorotan/Spotlight berorientasi CTA (contoh: *🔥 Lamar Sekarang! Lowongan Prioritas & Dibutuhkan Segera*), serta kustomisasi lengkap blok "Cara Melamar Kerja" (otomatis mengikuti nama situs Anda atau kustom) dan detail 3 langkah melamar.
6. **🛡️ Peringatan Anti Penipuan:** Tampilkan/sembunyikan banner anti-penipuan di atas footer, ubah judul & isi peringatan rekrutmen.
7. **📋 Footer & Hak Cipta:** Ubah paragraf "Tentang Kami" footer, teks hak cipta/copyright kustom, serta pengaturan lengkap deretan ikon **"Media Sosial Pemilik Website"** (ikon SVG modern WhatsApp, Telegram, LinkedIn, Facebook, dan Instagram lengkap dengan URL profil resmi pemilik website).
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
10. **💼 Halaman Pasang Loker & Tarif:** Kustomisasi warna aksen hero, harga paket Featured, harga paket Urgent, nomor WhatsApp admin penerima pesanan iklan, dan email alternatif perusahaan.
11. **📢 Saluran WhatsApp & Broadcast Loker (v1.0.12):**
   - Input kustom link Saluran WhatsApp resmi (`https://whatsapp.com/channel/...` atau link grup/komunitas WA).
   - Generator teks broadcast otomatis terstruktur (Emoji, Posisi, Perusahaan, Lokasi, Tipe, Gaji, Deadline, dan Link).
   - Bilah alat khusus admin di halaman detail loker: tombol 1-klik kirim ke WhatsApp, tombol salin format teks ke clipboard, dan tombol buka Saluran WA.
   - Tombol aksi cepat *"📢 Broadcast WA"* langsung pada tabel daftar lowongan kerja di dashboard admin WordPress.
   - Banner ajakan bergabung Saluran WhatsApp untuk pengunjung umum di halaman detail loker dan integrasi tautan footer untuk memperbanyak followers secara gratis.

12. **✉️ Standar Format Lamaran Profesional & Template WhatsApp/Email (v1.0.19):**
   - Format pesan WhatsApp lamaran kerja terstruktur dan santun standar rekrutmen: posisi, referensi URL loker, profil singkat, dan konfirmasi pengiriman dokumen.
   - Format surat lamaran email resmi (cover letter) lengkap dengan subjek standar HR, salam pembuka formal, ringkasan kualifikasi, checklist berkas lampiran (CV & Portofolio), dan penutup.
   - Kolom kustomisasi baru pada Meta Box WordPress: opsi menyunting template isi pesan email lamaran per-lowongan atau menggunakan template default otomatis.
   - Penyempurnaan format siaran / broadcast loker WhatsApp dengan penambahan catatan resmi anti-penipuan (*Proses rekrutmen GRATIS*).
   - Pembaruan template WhatsApp pengajuan pasang lowongan dari perusahaan (Paket Basic, Featured, Urgent) dan formulir interaktif di halaman Pasang Loker.
   - Pembaruan tombol notifikasi dashboard WordPress: *"🔄 Cek Pembaruan Thema Sekarang"*.

13. **🔄 Fix Pembaruan Tema Otomatis via GitHub Releases (v1.0.20):**
   - Fix critical: folder hasil ekstrak ZIP GitHub Releases otomatis di-rename dari `hakajobs-1.0.x/` → `hakajobs/` sehingga proses **Update Now** dari dashboard WordPress tidak lagi error *"Tema ini tidak memiliki style.css stylesheet"*.
   - Validasi rename dengan pesan error informatif jika direktori `wp-content/themes/` tidak dapat ditulisi.

14. **🚀 Optimasi Lengkap Google JobPosting Schema & Rich Snippets (v1.0.21):**
   - **`baseSalary` Terstruktur:** Parser otomatis yang mengonversi input nominal gaji (contoh: `Rp 6.000.000 - Rp 9.000.000`) menjadi format resmi Google `MonetaryAmount` (`IDR`), `QuantitativeValue` (`minValue`/`maxValue`), dan satuan waktu (`MONTH`/`YEAR`).
   - **`streetAddress` Pemetaan:** Mengaitkan alamat fisik kantor (`_hakajobs_company_location`) langsung ke atribut `jobLocation.address.streetAddress`.
   - **Input & Fallback Cerdas `postalCode`:** Field baru Kode Pos di metabox, auto-ekstraksi 5 digit dari alamat kantor, dan fallback otomatis berdasarkan nama kota di Indonesia.
   - **Dukungan Pekerjaan Remote / WFH:** Otomatis menambahkan `"jobLocationType": "TELECOMMUTE"` ke schema Google jika lowongan bertipe Remote / WFH.

15. **⚡ Peningkatan Kecepatan PageSpeed & Standarisasi Tipe Kerja (v1.0.22):**
   - **Standarisasi Tipe Pekerjaan:** Mengubah istilah *Paruh Waktu* → *Part-Time* dan *Penuh Waktu* → *Full-Time* secara konsisten pada template, chip filter, fallback menu, formulir pasang loker, dan sinkronisasi otomatis database WordPress.
   - **Pemuatan Aset Terkompresi (.min):** Otomatis memuat versi minified (`main.min.css`, `main.min.js`, `pasang-loker.min.css`) menghemat ~40KB transfer dan waktu render.
   - **Preconnect & DNS-Prefetch Resource Hints:** Koneksi paralel ke Google Fonts sebelum rendering dimulai untuk memangkas FCP dan LCP.
   - **Eliminasi Render-Blocking JavaScript:** Penambahan atribut `defer` otomatis pada skrip tema utama.
   - **Pembersihan Bloat WordPress Core:** Menghapus skrip/style emoji bawaan, wp-embed, dan inline duotone SVG yang tidak diperlukan di frontend.
   - **Optimasi Gambar Anti-CLS:** Atribut dimensi lebar/tinggi eksplisit, `decoding="async"`, dan `fetchpriority="high"` untuk logo hero lowongan kerja.
   - **Conditional Gutenberg Block CSS:** Melepas CSS blok yang tidak digunakan pada halaman lowongan kerja untuk memperingan ukuran halaman.


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

## 🖼️ Panduan Ukuran & Format Logo Lowongan

Untuk memastikan tampilan kartu lowongan terlihat proporsional dan memenuhi standar Google Rich Results:

| Parameter | Rekomendasi | Keterangan |
| :--- | :--- | :--- |
| **Rasio Gambar** | **1:1 (Persegi / Square)** | Wajib rasio 1:1 agar logo tidak terdistorsi atau terpotong saat dipotong membulat |
| **Dimensi Ideal** | **`512 x 512 px`** | Resolusi paling tajam di layar Retina / smartphone modern |
| **Dimensi Minimal** | **`256 x 256 px`** | Batas minimal yang dianjurkan (Google Jobs mewajibkan min. `112 x 112 px`) |
| **Format File** | **PNG Transparan** atau **WebP / JPG** | PNG dengan background transparan atau putih bersih sangat disarankan |
| **Ukuran Berkas** | **< 150 KB** | Kompres gambar agar loading halaman tetap super cepat |

### Di mana Logo Perusahaan Ditampilkan?
1. **Daftar Lowongan (Job Card / Halaman Depan / Arsip):** Ditampilkan otomatis pada dimensi **`52 x 52 px`**.
2. **Detail Lowongan (Single Job Header):** Ditampilkan otomatis pada dimensi **`80 x 80 px`**.
3. **Google Schema `JobPosting`:** Diinput otomatis ke atribut `hiringOrganization.logo` untuk memunculkan logo perusahaan di cuplikan pencarian Google for Jobs.
4. **Fallback Otomatis (Tanpa Upload):** Jika gambar logo tidak diunggah, Hakajobs secara otomatis membuatkan avatar inisial nama perusahaan berbasis teks dengan palet warna pastel yang menarik.

---

## ✍️ Pedoman Penulisan Artikel Lowongan Kerja (SEO & Rank Math 100/100)

Panduan wajib bagi admin/penulis sebelum mempublikasikan lowongan agar lulus semua tes Rank Math, cepat terindeks Google, dan nyaman dibaca pelamar di ponsel.

### Ringkasan Aturan Cepat (Cheat Sheet)

| Elemen | Batas Karakter | Contoh |
| :--- | :---: | :--- |
| **Title SEO (Judul Artikel)** | **45 – 60 char** | `Loker Admin & Kasir – PT Sinar Jaya Lampung` |
| **Slug (URL Permalink)** | **Maks ≤ 48 char** | `loker-admin-kasir-sinar-jaya-lampung` |
| **Total Panjang URL** | **Maks ≤ 75 char** | `https://situsanda.com/lowongan/loker-admin-kasir-sinar-jaya-lampung/` |
| **Meta Description** | **120 – 155 char** | `Info loker PT Sinar Jaya Lampung posisi Admin & Kasir. Cek kualifikasi, gaji, dan cara melamar langsung via WhatsApp!` |
| **H1 (Judul Halaman)** | **Bebas (boleh > 60)** | `Lowongan Kerja Admin & Kasir – PT Sinar Jaya Lampung` |
| **Focus Keyword (Rank Math)** | **2 – 4 kata** | `loker admin lampung` |

> **Aturan Emas:** Total panjang URL (domain + path + slug + trailing slash) **tidak boleh melebihi 75 karakter** agar lulus tes URL Length Rank Math. Tema sudah menyediakan meta box "Asisten SEO Rank Math" di sidebar kanan editor yang menghitung ini secara real-time.

---

### 1. Cara Menulis Judul Artikel (Title SEO) — Maks 60 Karakter

**Pola yang Direkomendasikan:**
```
Loker [Posisi] – [Nama Perusahaan] [Kota]
```

**Contoh Benar (✅):**
| Judul | Panjang |
| :--- | :---: |
| `Loker Admin & Kasir – PT Sinar Jaya Lampung` | 46 char ✅ |
| `Loker AMM Group Lampung: GRO, Waiter, Kasir` | 46 char ✅ |
| `Lowongan Kerja Barista – Kopi Nusantara Bandung` | 50 char ✅ |

**Contoh Salah (❌):**
| Judul | Panjang | Masalah |
| :--- | :---: | :--- |
| `Guest Relationship Officer, Cashier, Waiter, Commis Cook – AMM Group Lampung` | 78 char ❌ | Terpotong di Google, nama perusahaan hilang |
| `INFO LOKER TERBARU 2026 GAJI BESAR BURUAN DAFTAR` | 50 char ❌ | Clickbait, bukan nama jabatan resmi |

**Tips Judul:**
- Awali dengan kata **"Loker"** atau **"Lowongan Kerja"** (kata kunci pencarian terbesar).
- Jika posisi terlalu banyak, singkat dengan akronim (`GRO`, `CS`) atau ambil 2–3 posisi utama saja.
- Hindari kata huruf besar semua (`ALL CAPS`) dan kata clickbait seperti *"HOT"*, *"VIRAL"*, *"CEPAT LAMAR"*.
- Google for Jobs membaca judul murni sebagai nama jabatan resmi (`title`) — bukan slogan promosi.

---

### 2. Cara Membuat Slug URL — Maks 48 Karakter

Slug adalah bagian URL setelah `/lowongan/`. Tema Hakajobs **secara otomatis memotong slug > 48 karakter** saat post disimpan, tetapi hasilnya lebih baik jika Anda tulis manual.

**Pola Slug:**
```
loker-[posisi-utama]-[perusahaan]-[kota]
```

**Contoh Benar (✅):**
| Slug | Panjang |
| :--- | :---: |
| `loker-admin-kasir-sinar-jaya-lampung` | 37 char ✅ |
| `loker-amm-group-lampung` | 24 char ✅ |
| `loker-barista-kopi-nusantara-bandung` | 37 char ✅ |

**Aturan Slug:**
1. **Gunakan huruf kecil semua** — jangan huruf besar.
2. **Pisahkan kata dengan tanda hubung** (`-`) — bukan garis bawah (`_`) atau spasi.
3. **Buang semua stop words:** *dan, di, ke, dari, untuk, pada, yang, atau, adalah, dengan, ini, itu*.
4. **Buang kata redundan:** *info, loker, lowongan, kerja, terbaru, rekrutmen, pt, cv, group*.
5. **Jangan copy-paste judul langsung.** Ringkas hanya kata kunci inti.
6. **Gunakan tombol "⚡ Bersihkan & Ringkas Slug Otomatis"** di meta box Asisten SEO Rank Math untuk membersihkan stop words otomatis.

**Rumus Hitung Total URL:**
```
Total URL = panjang(https://situsanda.com/lowongan/) + panjang(slug) + 1 (trailing slash)
```
Contoh: `https://hakajobs.com/lowongan/` = 30 char → slug maksimal = 75 - 30 - 1 = **44 char**.
Sesuaikan dengan panjang domain Anda!

---

### 3. Cara Menulis Meta Description — 120 sampai 155 Karakter

Meta description adalah teks ringkasan yang muncul di bawah judul di Google. Jika menggunakan Rank Math, isi di kolom "Description" Rank Math. Jika tidak ada Rank Math, tema otomatis membuat deskripsi dari meta box.

**Pola:**
```
Info loker [Perusahaan] [Kota] posisi [Posisi]. Cek kualifikasi lengkap dan cara melamar [via WhatsApp/Email] di sini!
```

**Contoh Benar (✅):**
- `Info loker AMM Group Lampung untuk posisi GRO, Cashier, Waiter, & Commis Cook. Cek kualifikasi lengkap dan cara melamarnya di sini!` (133 char ✅)

**Yang Harus Dihindari (❌):**
- **Jangan tulis alamat email/nomor WA di deskripsi** — pencari kerja akan langsung menghubungi tanpa masuk ke website Anda (kehilangan trafik).
- **Jangan melebihi 160 karakter** — Google akan memotong dengan "...".
- **Jangan biarkan kosong** — Google akan mengambil teks acak dari konten halaman.

---

### 4. Cara Menentukan Focus Keyword Rank Math

Focus keyword adalah kata kunci utama yang ingin Anda ranking di Google. Masukkan di kolom "Focus Keyword" Rank Math.

**Aturan:**
- Gunakan **2 hingga 4 kata** yang benar-benar diketik orang di Google.
- Pastikan focus keyword **ada di judul, slug, paragraf pertama, dan minimal 1 heading H2**.
- Pisahkan keyword tambahan (secondary) di kolom terpisah Rank Math.

**Pola Focus Keyword untuk Loker:**
```
loker [posisi/perusahaan] [kota]
```

**Contoh:**
| Focus Keyword (Utama) | Keyword Tambahan |
| :--- | :--- |
| `loker amm group lampung` | `loker waiter lampung`, `loker fnb lampung` |
| `loker admin bandar lampung` | `loker sma lampung`, `lowongan admin lampung` |
| `loker barista bandung` | `loker cafe bandung`, `loker part time bandung` |

---

### 5. Pengisian Meta Box Lowongan (Wajib Diisi)

| Kolom Meta Box | Aturan Pengisian | Contoh |
| :--- | :--- | :--- |
| **Nama Perusahaan** | Nama resmi PT/CV/Brand | `PT AMM Group Indonesia` |
| **Website Perusahaan** | (Opsional) URL situs resmi | `https://ammgroup.co.id` |
| **Alamat Kantor** | Alamat spesifik penempatan kerja | `Jl. Raden Intan No. 12, Tanjung Karang` |
| **Kode Pos** | 5 digit kode pos kantor | `35111` |
| **Rentang Gaji** | Format: `Rp X.XXX.XXX - Rp X.XXX.XXX` | `Rp 3.500.000 - Rp 5.000.000` |
| **Deadline** | Tanggal batas akhir lamaran | `2026-10-31` |
| **Metode Lamaran** | WhatsApp HRD / Email / Link Eksternal | `628123456789` (tanpa spasi/+) |

> **Tips Gaji:** Lowongan yang mencantumkan nominal gaji mendapatkan klik hingga **2x lebih tinggi** di Google Jobs dibanding yang bertuliskan "Kompetitif".

---

### 6. Struktur Isi Konten (Content Body)

Gunakan heading H2 dan bullet list seperti pola berikut di editor WordPress:

```markdown
## Tentang Perusahaan
[1-2 paragraf singkat profil perusahaan, bidang usaha, dan budaya kerja]

## Deskripsi Pekerjaan (Job Description)
- Mengelola pesanan pelanggan yang masuk melalui WhatsApp dan marketplace.
- Melakukan follow-up pembayaran dan menjawab pertanyaan seputar produk secara ramah.
- Berkoordinasi dengan tim operasional dan logistik untuk kelancaran pengiriman barang.

## Kualifikasi & Persyaratan (Requirements)
- Pria / Wanita, usia maksimal 28 tahun.
- Pendidikan minimal SMA / SMK / D3 / S1 semua jurusan.
- Pengalaman minimal 1 tahun di posisi Customer Service (fresh graduate dipersilakan melamar).
- Memiliki kemampuan komunikasi yang baik dan mampu mengetik dengan cepat.
- Bersedia bekerja dalam sistem shifting di kantor Surabaya.

## Benefit & Fasilitas
- Gaji Pokok + Tunjangan Makan & Transport.
- Bonus performa bulanan & reward tahunan.
- BPJS Ketenagakerjaan & Kesehatan.

## Cara Melamar
Kirimkan berkas lamaran berupa Surat Lamaran, CV terbaru, dan Portofolio ke kontak HRD yang tertera pada tombol di bawah sebelum tanggal batas waktu berakhir.
```

**Aturan Konten:**
- Paragraf pertama **wajib menyebut focus keyword** dalam 100 kata pertama.
- Gunakan **minimal 3 heading H2** (Tentang Perusahaan, Job Description, Kualifikasi).
- Gunakan **bullet list** (`-` atau `*`) untuk setiap poin persyaratan — bukan paragraf panjang.
- Panjang konten minimal **300 kata** agar Rank Math memberikan skor hijau pada Content Length Test.

---

### 7. Checklist Final Sebelum Publish (Rank Math 100/100)

Periksa semua poin ini sebelum menekan tombol **Publikasikan**:

- [ ] ✅ **Title SEO** ≤ 60 karakter, mengandung focus keyword + nama kota.
- [ ] ✅ **Slug URL** ≤ 48 karakter, total URL ≤ 75 karakter (cek di meta box Asisten SEO).
- [ ] ✅ **Meta Description** 120–155 karakter, ada CTA, TIDAK ada email/WA langsung.
- [ ] ✅ **Focus Keyword** Rank Math terisi 2–4 kata.
- [ ] ✅ **Focus keyword muncul di:** judul, slug, paragraf pertama, minimal 1 heading H2.
- [ ] ✅ **Konten** minimal 300 kata, menggunakan H2 terstruktur & bullet list.
- [ ] ✅ **Meta box lowongan** terisi: Nama Perusahaan, Gaji, Lokasi, Deadline, Metode Lamaran.
- [ ] ✅ **Featured Image** (logo perusahaan) terunggah, rasio 1:1, minimal 256x256 px.
- [ ] ✅ **Taksonomi** terisi: Kategori Loker, Lokasi, Tipe Pekerjaan.

---

### 8. Contoh Kasus Lengkap: Artikel AMM Group

Berikut contoh pengisian yang **benar** untuk lowongan dengan banyak posisi:

| Elemen | Contoh Pengisian |
| :--- | :--- |
| **Title SEO** | `Loker AMM Group Lampung: GRO, Waiter, Kasir` (46 char) |
| **H1 Halaman** | `Lowongan Kerja AMM Group Lampung: GRO, Cashier, Waiter, Commis Cook` |
| **Slug** | `loker-amm-group-lampung` (24 char) |
| **Meta Description** | `Info loker AMM Group Lampung untuk posisi GRO, Cashier, Waiter, & Commis Cook. Cek kualifikasi lengkap dan cara melamarnya di sini!` (133 char) |
| **Focus Keyword** | `loker amm group lampung` |
| **Secondary Keywords** | `loker waiter lampung`, `loker fnb lampung`, `loker cashier bandar lampung` |

---

## ⚙️ Panduan Pengaturan Rank Math SEO untuk Hakajobs

Tema Hakajobs sudah dilengkapi dengan **Fast-Indexing Engine** dan **Schema `JobPosting` JSON-LD** bawaan. Tema mendeteksi plugin Rank Math secara otomatis agar tidak terjadi konflik duplikasi meta tag.

Berikut langkah konfigurasi Rank Math yang direkomendasikan:

### 1. Pengaturan Judul & Meta (`Rank Math` > `Titles & Meta` > `Lowongan`)
* **Single Lowongan Title:**
  ```text
  %title% %sep% %sitename%
  ```
* **Single Lowongan Description:**
  ```text
  Info lowongan kerja %title% terbaru. Cek persyaratan, rentang gaji, lokasi kerja, dan kirim lamaran langsung ke HRD via WhatsApp/Email.
  ```
* **Schema Type (Tipe Schema):**
  - **Rekomendasi:** Pilih **None (Nonaktifkan Schema di Rank Math khusus post type Lowongan)**.
  - *Alasan:* Hakajobs sudah menyematkan script Schema JSON-LD `JobPosting` bawaan yang sudah terhubung langsung ke meta box (tipe pekerjaan `FULL_TIME`/`PART_TIME`/`INTERN`, nominal gaji, deadline `validThrough`, logo perusahaan, dan alamat lokasi penempatan).

### 2. Pengaturan Peta Situs (`Rank Math` > `Sitemap Settings`)
* **Post Types:**
  - `Lowongan`: Pastikan **Include in Sitemap = ON**.
* **Taxonomies:**
  - `Kategori Loker` (`kategori_lowongan`): **Include in Sitemap = ON**
  - `Lokasi Loker` (`lokasi_lowongan`): **Include in Sitemap = ON**
  - `Tipe Pekerjaan` (`tipe_pekerjaan`): **Include in Sitemap = ON**
  *(Membuat Google mengindeks ribuan halaman kategori profesi dan arsip kota secara menyeluruh)*.

### 3. Aktifkan Fitur IndexNow (Instant Indexing)
* Masuk ke **Rank Math Dashboard** > aktifkan modul **Instant Indexing**.
* Setiap kali admin mempublikasikan lowongan baru atau memperbarui info loker, Rank Math akan langsung mengirimkan sinyal ping API ke mesin pencari (Bing, Yandex, IndexNow) agar langsung di-crawl dalam hitungan menit tanpa menunggu antrean rutin.

### 4. Menentukan Focus Keyword pada Loker
Saat menyunting artikel lowongan kerja, masukkan kata kunci yang spesifik dengan intensi pencarian kerja lokal, misalnya:
- `loker admin lampung`
- `loker waiter bandar lampung`
- `lowongan kerja barista bandung`

### 5. Meta Box "Asisten SEO Rank Math" (Fitur Bawaan Hakajobs)
Tema ini menyediakan panel bantuan SEO di **sidebar kanan editor** yang menampilkan:
- **Live URL Length Counter** — Menghitung panjang total URL secara real-time dan membandingkannya dengan batas 75 karakter Rank Math.
- **Slug Editor** — Kolom input slug terpisah yang bisa diedit langsung dari sidebar.
- **Tombol Optimasi Otomatis** — Menghapus stop words (dan, di, ke, untuk, pt, cv, group, dll.) dan memotong slug ke panjang aman dalam 1 klik.
- **Title Length Indicator** — Memantau panjang judul dan memberi badge hijau/merah.
- **Checklist Rank Math** — Daftar cek manual poin-poin penting untuk mencapai skor 100/100.

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

© Haka Digital Network. Dibuat dengan standar WordPress modern & ramah SEO.


