<?php
/**
 * Sample Demo Data Installer for Hakajobs
 *
 * @package Hakajobs
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Demo Data submenu under Lowongan Kerja in WP Admin
 */
function hakajobs_add_demo_menu() {
    add_submenu_page(
        'edit.php?post_type=lowongan',
        __('Pasang Data Demo Loker', 'hakajobs'),
        __('Pasang Data Demo', 'hakajobs'),
        'manage_options',
        'hakajobs-demo-data',
        'hakajobs_render_demo_page'
    );
}
add_action('admin_menu', 'hakajobs_add_demo_menu');

/**
 * Render Demo Data Page
 */
function hakajobs_render_demo_page() {
    if (isset($_POST['hakajobs_install_demo']) && check_admin_referer('hakajobs_demo_nonce_action', 'hakajobs_demo_nonce')) {
        $count = hakajobs_generate_sample_jobs();
        if (function_exists('hakajobs_create_default_pages')) {
            hakajobs_create_default_pages();
        }
        if (function_exists('hakajobs_generate_starter_articles')) {
            hakajobs_generate_starter_articles();
        }
        echo '<div class="notice notice-success is-dismissible"><p><strong>Berhasil!</strong> ' . esc_html($count) . ' data lowongan kerja demo dan artikel panduan karir telah berhasil dibuat ke menu Pos dan Lowongan Kerja.</p></div>';
    }

    if (isset($_POST['hakajobs_install_articles']) && check_admin_referer('hakajobs_demo_nonce_action', 'hakajobs_demo_nonce')) {
        $art_count = function_exists('hakajobs_generate_starter_articles') ? hakajobs_generate_starter_articles() : 0;
        echo '<div class="notice notice-success is-dismissible"><p><strong>Berhasil!</strong> ' . esc_html($art_count) . ' artikel panduan tes & karir telah berhasil diterbitkan ke menu <strong>Pos &gt; Semua Pos</strong>.</p></div>';
    }
    ?>
    <div class="wrap" style="max-width:800px;">
        <h1>📦 Pasang Data Demo Lowongan & Artikel Karir</h1>
        <p>Fitur ini akan secara otomatis membuat contoh lowongan kerja dan artikel edukasi karir lengkap agar website Anda langsung terlihat aktif, profesional, dan siap digunakan.</p>

        <div style="background:#fff; border:1px solid #cbd5e1; border-radius:8px; padding:20px; margin-top:20px;">
            <h3>1. Data Demo Lowongan Kerja:</h3>
            <ul style="list-style:disc; margin-left:20px; line-height:1.8;">
                <li><strong>Kategori:</strong> IT & Rekayasa Software, Pemasaran Digital, Desain Grafis, Akuntansi, Layanan Pelanggan.</li>
                <li><strong>Lokasi & Tipe:</strong> Jakarta Pusat, Bandung, Surabaya, Yogyakarta, dan Remote / WFH.</li>
                <li><strong>Contoh Loker:</strong> 6+ posisi lowongan kerja realistis lengkap dengan gaji, persyaratan, dan nomor WhatsApp lamaran.</li>
            </ul>

            <form method="post" style="margin-top:20px;">
                <?php wp_nonce_field('hakajobs_demo_nonce_action', 'hakajobs_demo_nonce'); ?>
                <button type="submit" name="hakajobs_install_demo" class="button button-primary button-hero" onclick="return confirm('Apakah Anda yakin ingin membuat data demo lowongan kerja?');">
                    🚀 Pasang Semua Demo (Loker + Artikel)
                </button>
            </form>
        </div>

        <div style="background:#fff; border:1px solid #cbd5e1; border-radius:8px; padding:20px; margin-top:20px;">
            <h3>2. Khusus Artikel Panduan & Soal Karir (Menu Pos):</h3>
            <p>Terbitkan <strong>16 artikel panduan karir komprehensif</strong> (Latihan Soal SKD CPNS 2026 HOTS, Simulasi 10 Soal AKHLAK BUMN, Rahasia Tes Kraepelin, Panduan Tes Wartegg &amp; Gambar Pohon/Orang, Panduan CV ATS, Cara Bikin Portofolio Fresh Graduate, 20 Tanya Jawab Interview STAR, Strategi Interview User, Trik Negosiasi Gaji UMR, Panduan K3 Kemenaker, TOEFL BUMN, Sertifikasi BNSP, Panduan Career Switch, Memahami Kontrak Kerja PKWT/PKWTT, dan 3 Template Surat Lamaran Kerja) ke dalam menu <strong>Pos &gt; Semua Pos</strong> agar Anda bisa mengedit tulisan, kategori, atau menambah materi secara bebas.</p>

            <form method="post" style="margin-top:20px;">
                <?php wp_nonce_field('hakajobs_demo_nonce_action', 'hakajobs_demo_nonce'); ?>
                <button type="submit" name="hakajobs_install_articles" class="button button-secondary" onclick="return confirm('Terbitkan 16 artikel materi karir ke menu Pos?');">
                    📝 Terbitkan 16 Artikel Materi Karir ke Menu Pos
                </button>
            </form>
        </div>

        <div style="background:#f0f9ff; border:1px solid #bae6fd; border-radius:8px; padding:20px; margin-top:20px;">
            <h3 style="color:#0369a1; margin-top:0;">⚙️ Pengaturan Kotak CTA "Sudah Siap Melamar Pekerjaan?":</h3>
            <p style="color:#0c4a6e; line-height:1.6;">Anda dapat menyesuaikan teks judul, deskripsi ajakan, teks tombol, dan tautan link kotak CTA <strong>"Sudah Siap Melamar Pekerjaan?"</strong> secara langsung melalui WP Dashboard:</p>
            <ul style="list-style:disc; margin-left:20px; line-height:1.8; color:#0c4a6e;">
                <li><strong>Halaman Pusat Tes &amp; Karir</strong>: Masuk ke <em>Tampilan &gt; Sesuaikan &gt; Halaman Pusat Tes &amp; Karir &gt; Kotak CTA Siap Melamar Pekerjaan (Sidebar)</em>.</li>
                <li><strong>Sidebar Kanan Beranda &amp; Blog</strong>: Masuk ke <em>Tampilan &gt; Sesuaikan &gt; Sidebar Kanan &gt; Widget CTA Pencari Kerja</em>.</li>
                <li><strong>Widget Fleksibel</strong>: Masuk ke <em>Tampilan &gt; Widget</em>, gunakan widget <strong>[Hakajobs] CTA Siap Melamar Pekerjaan</strong> pada area sidebar atau footer manapun.</li>
            </ul>
            <div style="margin-top:16px;">
                <a href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=hakajobs_teskarir_section')); ?>" class="button button-primary" target="_blank">
                    🎨 Buka Pengaturan di WP Customizer &rarr;
                </a>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Populate Sample Jobs
 */
function hakajobs_generate_sample_jobs() {
    $jobs = array(
        array(
            'title'            => 'Senior Frontend Developer (React / Vue)',
            'company'          => 'PT Digital Kreasi Nusantara',
            'location'         => 'Jakarta Pusat',
            'category'         => 'IT & Rekayasa Software',
            'type'             => 'Full-Time',
            'experience'       => '3-5 Tahun',
            'salary'           => 'Rp 14.000.000 - Rp 20.000.000',
            'apply_type'       => 'whatsapp',
            'apply_wa'         => '081234567890',
            'apply_email'      => 'recruitment@digitalkreasi.co.id',
            'is_featured'      => '1',
            'is_urgent'        => '1',
            'deadline'         => date('Y-m-d', strtotime('+30 days')),
            'benefits'         => "BPJS Ketenagakerjaan & Kesehatan\nAsuransi Rawat Inap Swasta\nLaptop Kerja MacBook Pro M3\nJatah Cuti 15 Hari/Tahun\nSubsidi Pelatihan & Sertifikasi",
            'content'          => "<h3>Tentang Pekerjaan</h3>
<p>Kami mencari Senior Frontend Developer yang berpengalaman dalam membangun antarmuka web modern berskala besar. Anda akan bekerja sama erat dengan tim UI/UX designer, backend engineer, dan product manager untuk menghadirkan pengalaman pengguna terbaik.</p>

<h3>Tanggung Jawab:</h3>
<ul>
    <li>Mengembangkan arsitektur komponen frontend yang modular, reusable, dan berkinerja tinggi.</li>
    <li>Mengoptimalkan waktu pemuatan halaman (Core Web Vitals) dan aksesibilitas web.</li>
    <li>Melakukan integrasi API RESTful dan GraphQL bersama tim backend.</li>
    <li>Melakukan code review dan memberikan mentoring kepada junior engineer.</li>
</ul>

<h3>Kualifikasi:</h3>
<ul>
    <li>Pengalaman minimal 3 tahun menggunakan React.js, Next.js, atau Vue.js modern.</li>
    <li>Mahir dalam CSS modern, responsive design, dan state management.</li>
    <li>Familiar dengan Git, testing library (Jest/Cypress), dan CI/CD pipeline.</li>
    <li>Memiliki komunikasi yang baik dan mampu bekerja mandiri maupun kolaboratif.</li>
</ul>",
        ),
        array(
            'title'            => 'Digital Marketing & Social Media Specialist',
            'company'          => 'PT Ruang Media Kreatif',
            'location'         => 'Bandung',
            'category'         => 'Pemasaran Digital & Media Sosial',
            'type'             => 'Full-Time',
            'experience'       => '1-3 Tahun',
            'salary'           => 'Rp 6.500.000 - Rp 9.000.000',
            'apply_type'       => 'whatsapp',
            'apply_wa'         => '082198765432',
            'apply_email'      => 'hrd@ruangmedia.id',
            'is_featured'      => '1',
            'is_urgent'        => '0',
            'deadline'         => date('Y-m-d', strtotime('+20 days')),
            'benefits'         => "Gaji Pokok & Bonus Insentif Kampanye\nBPJS Ketenagakerjaan\nTunjangan Makan Siang\nLingkungan Kerja Kasual & Dinamis\nKamera & Gadget Kantor",
            'content'          => "<h3>Deskripsi Pekerjaan</h3>
<p>PT Ruang Media Kreatif sedang membuka kesempatan bagi talenta kreatif untuk bergabung sebagai Digital Marketing & Social Media Specialist untuk mengelola kanal digital dan strategi pertumbuhan brand klien.</p>

<h3>Tanggung Jawab:</h3>
<ul>
    <li>Merancang content calendar bulanan untuk Instagram, TikTok, dan LinkedIn.</li>
    <li>Menjalankan dan mengoptimalkan kampanye berbayar (Meta Ads & TikTok Ads).</li>
    <li>Menganalisis metrik pertumbuhan akun serta menyusun laporan performa mingguan.</li>
    <li>Bekerja sama dengan tim desainer grafis dan videografer dalam memproduksi aset kreatif.</li>
</ul>

<h3>Kualifikasi:</h3>
<ul>
    <li>Pendidikan minimal D3/S1 Komunikasi, Pemasaran, atau jurusan terkait.</li>
    <li>Memahami copywriting, tren konten media sosial terkini, dan algoritma platform.</li>
    <li>Berpengalaman mengelola Meta Ads Manager dengan ROAS positif.</li>
    <li>Kreatif, inisiatif tinggi, dan memiliki portofolio kampanye konten yang terbukti.</li>
</ul>",
        ),
        array(
            'title'            => 'UI/UX Product Designer (Remote / WFH)',
            'company'          => 'Studio Cipta Global',
            'location'         => 'Remote / WFH',
            'category'         => 'Desain Grafis & Kreatif',
            'type'             => 'Remote / WFH',
            'experience'       => '1-3 Tahun',
            'salary'           => 'Rp 9.000.000 - Rp 13.000.000',
            'apply_type'       => 'email',
            'apply_wa'         => '',
            'apply_email'      => 'career@studiocipta.com',
            'is_featured'      => '1',
            'is_urgent'        => '1',
            'deadline'         => date('Y-m-d', strtotime('+14 days')),
            'benefits'         => "100% Full Remote (Kerja Bebas Dari Mana Saja)\nTunjangan Internet & Workspace Bulanan\nJam Kerja Fleksibel Berbasis Output\nBudget Langganan Software & Figma",
            'content'          => "<h3>Tentang Posisi Ini</h3>
<p>Kami mencari UI/UX Designer yang berfokus pada produk SaaS dan aplikasi mobile. Pekerjaan ini 100% remote tanpa perlu hadir ke kantor fisik.</p>

<h3>Tanggung Jawab:</h3>
<ul>
    <li>Merancang alur pengguna (user flow), wireframe, dan prototype interaktif di Figma.</li>
    <li>Mengembangkan dan memelihara Design System perusahaan.</li>
    <li>Melakukan usability testing dan wawancara pengguna untuk validasi ide fitur.</li>
    <li>Handoff desain ke tim developer dengan dokumentasi spesifikasi yang jelas.</li>
</ul>

<h3>Kualifikasi:</h3>
<ul>
    <li>Wajib menyertakan portofolio desain UI/UX (Figma / Behance / Web Pribadi).</li>
    <li>Mahir menggunakan Figma (Auto-layout, Components, Variables, Variants).</li>
    <li>Memahami prinsip User-Centered Design, micro-interaction, dan mobile accessibility.</li>
    <li>Memiliki disiplin tinggi untuk bekerja secara remote dan asynchronous.</li>
</ul>",
        ),
        array(
            'title'            => 'Staff Administrasi & Keuangan Junior',
            'company'          => 'CV Sinar Jaya Abadi',
            'location'         => 'Surabaya',
            'category'         => 'Akuntansi & Keuangan',
            'type'             => 'Full-Time',
            'experience'       => 'Fresh Graduate',
            'salary'           => 'Rp 5.200.000 - Rp 6.500.000',
            'apply_type'       => 'whatsapp',
            'apply_wa'         => '085712348899',
            'apply_email'      => 'admin.hrd@sinarjaya.co.id',
            'is_featured'      => '0',
            'is_urgent'        => '0',
            'deadline'         => date('Y-m-d', strtotime('+25 days')),
            'benefits'         => "BPJS Kesehatan & Ketenagakerjaan\nUang Makan & Transport\nBonus Tahunan\nPelatihan Akuntansi Perpajakan",
            'content'          => "<h3>Ringkasan Pekerjaan</h3>
<p>CV Sinar Jaya Abadi membuka lowongan untuk Staff Administrasi & Keuangan penempatan kantor operasional Surabaya. Terbuka bagi lulusan baru (Fresh Graduate) jurusan Akuntansi atau Manajemen.</p>

<h3>Tanggung Jawab:</h3>
<ul>
    <li>Mencatat transaksi harian kas kecil (petty cash) dan arus kas keluar-masuk.</li>
    <li>Menyiapkan faktur penjualan, tagihan (invoice), dan surat jalan.</li>
    <li>Melakukan rekonsiliasi bank bulanan dan pengarsipan dokumen keuangan.</li>
    <li>Membantu pembuatan laporan keuangan bulanan sederhana.</li>
</ul>

<h3>Kualifikasi:</h3>
<ul>
    <li>Minimal SMK Akuntansi / D3 / S1 Akuntansi atau Manajemen Keuangan.</li>
    <li>Mahir mengoperasikan Microsoft Excel (VLOOKUP, HLOOKUP, Pivot Table).</li>
    <li>Teliti, jujur, rapi dalam administrasi, dan berintegritas tinggi.</li>
    <li>Fresh graduate dipersilakan melamar!</li>
</ul>",
        ),
        array(
            'title'            => 'Customer Support & Live Chat Officer',
            'company'          => 'PT Solusi Layanan Hebat',
            'location'         => 'Yogyakarta',
            'category'         => 'Layanan Pelanggan & Administrasi',
            'type'             => 'Part-Time',
            'experience'       => 'Fresh Graduate',
            'salary'           => 'Rp 3.500.000 - Rp 4.500.000',
            'apply_type'       => 'whatsapp',
            'apply_wa'         => '087811223344',
            'apply_email'      => 'rekrutmen@solusihebat.id',
            'is_featured'      => '0',
            'is_urgent'        => '1',
            'deadline'         => date('Y-m-d', strtotime('+10 days')),
            'benefits'         => "Jadwal Shift Fleksibel (Cocok untuk Mahasiswa Tingkat Akhir)\nInsentif Kepuasan Pelanggan (CSAT)\nSnack & Kopi Gratis di Kantor\nSuasana Kerja Nyaman",
            'content'          => "<h3>Tentang Peran Ini</h3>
<p>Kami mencari Customer Support Officer yang ramah, komunikatif, dan responsif untuk melayani pertanyaan pelanggan melalui WhatsApp, Live Chat website, dan email.</p>

<h3>Tanggung Jawab:</h3>
<ul>
    <li>Menjawab pertanyaan dan keluhan pelanggan secara cepat, santun, dan solutif.</li>
    <li>Mencatat tiket keluhan dan meneruskan ke tim teknis jika memerlukan eskalasi.</li>
    <li>Memandu pengguna mengenai cara penggunaan produk aplikasi.</li>
</ul>

<h3>Kualifikasi:</h3>
<ul>
    <li>Pendidikan minimal SMA/SMK/D3/S1 segala jurusan.</li>
    <li>Memiliki kemampuan mengetik cepat dan tata bahasa Indonesia yang baik.</li>
    <li>Sabar, ramah, dan berorientasi pada kepuasan pelanggan.</li>
    <li>Bersedia bekerja dalam sistem shift (Pagi / Sore / Akhir Pekan).</li>
</ul>",
        ),
        array(
            'title'            => 'Magang Web Content Writer & SEO (Internship)',
            'company'          => 'Nusantara Media Network',
            'location'         => 'Remote / WFH',
            'category'         => 'Pemasaran Digital & Media Sosial',
            'type'             => 'Magang (Internship)',
            'experience'       => 'Fresh Graduate',
            'salary'           => 'Rp 2.000.000 - Rp 3.000.000',
            'apply_type'       => 'url',
            'apply_wa'         => '',
            'apply_email'      => 'intern@nusantaramedia.id',
            'apply_url'        => 'https://forms.google.com/sample-internship-form',
            'is_featured'      => '0',
            'is_urgent'        => '0',
            'deadline'         => date('Y-m-d', strtotime('+15 days')),
            'benefits'         => "Sertifikat Magang Resmi Industri\nUang Saku Bulanan\nBimbingan Langsung Dari Senior SEO Editor\nPeluang Diangkat Menjadi Karyawan Tetap",
            'content'          => "<h3>Tentang Program Magang</h3>
<p>Program magang berbayar selama 3 bulan untuk mahasiswa tingkat akhir atau fresh graduate yang ingin mendalami dunia Content Writing dan Search Engine Optimization (SEO).</p>

<h3>Tanggung Jawab:</h3>
<ul>
    <li>Riset kata kunci dan menulis 2-3 artikel blog informatif per hari.</li>
    <li>Menerapkan prinsip on-page SEO pada setiap tulisan yang dipublikasikan.</li>
    <li>Melakukan proofreading dan pembaruan pada artikel-artikel lama.</li>
</ul>

<h3>Kualifikasi:</h3>
<ul>
    <li>Mahasiswa semester akhir atau lulusan baru jurusan Sastra, Jurnalistik, Komunikasi, atau sejenis.</li>
    <li>Gemar menulis dan membaca artikel teknologi / karir / gaya hidup.</li>
    <li>Memiliki kemauan belajar tinggi dan disiplin tenggat waktu.</li>
</ul>",
        ),
    );

    $count = 0;
    foreach ($jobs as $job) {
        // Check if post with same title already exists
        $existing = get_page_by_title($job['title'], OBJECT, 'lowongan');
        if ($existing) {
            continue;
        }

        $post_id = wp_insert_post(array(
            'post_title'    => $job['title'],
            'post_content'  => $job['content'],
            'post_status'   => 'publish',
            'post_type'     => 'lowongan',
            'post_author'   => get_current_user_id(),
        ));

        if ($post_id && !is_wp_error($post_id)) {
            // Set Meta Fields
            update_post_meta($post_id, '_hakajobs_company_name', $job['company']);
            update_post_meta($post_id, '_hakajobs_company_location', $job['location']);
            update_post_meta($post_id, '_hakajobs_salary', $job['salary']);
            update_post_meta($post_id, '_hakajobs_salary_period', 'bulan');
            update_post_meta($post_id, '_hakajobs_deadline', $job['deadline']);
            update_post_meta($post_id, '_hakajobs_status', 'aktif');
            update_post_meta($post_id, '_hakajobs_is_featured', $job['is_featured']);
            update_post_meta($post_id, '_hakajobs_is_urgent', $job['is_urgent']);
            update_post_meta($post_id, '_hakajobs_apply_type', $job['apply_type']);
            update_post_meta($post_id, '_hakajobs_apply_wa', $job['apply_wa']);
            update_post_meta($post_id, '_hakajobs_apply_email', $job['apply_email']);
            update_post_meta($post_id, '_hakajobs_apply_url', isset($job['apply_url']) ? $job['apply_url'] : '');
            update_post_meta($post_id, '_hakajobs_benefits', $job['benefits']);
            update_post_meta($post_id, '_hakajobs_views_count', rand(40, 380));

            // Set Taxonomies
            wp_set_object_terms($post_id, $job['category'], 'kategori_lowongan');
            wp_set_object_terms($post_id, $job['location'], 'lokasi_lowongan');
            wp_set_object_terms($post_id, $job['type'], 'tipe_pekerjaan');
            wp_set_object_terms($post_id, $job['experience'], 'pengalaman_kerja');

            $count++;
        }
    }

    return $count;
}
