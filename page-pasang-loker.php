<?php
/**
 * Template Name: Pasang Loker
 * Template Post Type: page
 *
 * Halaman landing untuk perusahaan yang ingin memasang lowongan kerja.
 * Menampilkan paket tarif, keunggulan, form pengiriman info loker, dan konten custom.
 * Dapat diedit dan disetting sepenuhnya melalui WP Dashboard > Kustomisasi / Sesuaikan
 * dan Editor Laman WordPress.
 *
 * @package Hakajobs
 */

get_header();

// Ambil pengaturan kontak dari Customizer
$wa_number  = get_theme_mod('hakajobs_contact_wa', '');
$wa_clean   = preg_replace('/[^0-9]/', '', $wa_number);
if (substr($wa_clean, 0, 1) === '0') {
    $wa_clean = '62' . substr($wa_clean, 1);
}
$contact_email = get_theme_mod('hakajobs_contact_email', get_bloginfo('admin_email'));
$site_name     = get_bloginfo('name');

// Pengaturan Tampilan & Konten dari Customizer (Section 10)
$pl_hero_badge     = get_theme_mod('hakajobs_pl_hero_badge', __('Platform Loker Terpercaya', 'hakajobs'));
$pl_hero_title     = get_theme_mod('hakajobs_pl_hero_title', __('Pasang Lowongan Kerja,', 'hakajobs'));
$pl_hero_highlight = get_theme_mod('hakajobs_pl_hero_highlight', __('Temukan Kandidat Terbaik', 'hakajobs'));
$pl_hero_sub       = get_theme_mod('hakajobs_pl_hero_sub', __('Jangkau ribuan pencari kerja aktif di wilayah Anda. Proses cepat, tayang dalam 1×24 jam, langsung ke target yang tepat.', 'hakajobs'));

$pl_stat1_num   = get_theme_mod('hakajobs_pl_stat1_num', '10rb+');
$pl_stat1_label = get_theme_mod('hakajobs_pl_stat1_label', __('Pencari Kerja Aktif', 'hakajobs'));
$pl_stat2_num   = get_theme_mod('hakajobs_pl_stat2_num', '500+');
$pl_stat2_label = get_theme_mod('hakajobs_pl_stat2_label', __('Lowongan Tayang', 'hakajobs'));
$pl_stat3_num   = get_theme_mod('hakajobs_pl_stat3_num', '1×24 Jam');
$pl_stat3_label = get_theme_mod('hakajobs_pl_stat3_label', __('Waktu Tayang', 'hakajobs'));

// Visibilitas Bagian
$pl_show_features     = get_theme_mod('hakajobs_pl_show_features', '1');
$pl_show_how          = get_theme_mod('hakajobs_pl_show_how', '1');
$pl_show_form         = get_theme_mod('hakajobs_pl_show_form', '1');
$pl_show_faq          = get_theme_mod('hakajobs_pl_show_faq', '1');
$pl_show_cta          = get_theme_mod('hakajobs_pl_show_cta', '1');
$pl_show_page_content = get_theme_mod('hakajobs_pl_show_page_content', '1');

// Bagian Tarif
$pl_pricing_badge = get_theme_mod('hakajobs_pl_pricing_badge', __('Pilih Paket', 'hakajobs'));
$pl_pricing_title = get_theme_mod('hakajobs_pl_pricing_title', __('Tarif Pasang Loker', 'hakajobs'));
$pl_pricing_sub   = get_theme_mod('hakajobs_pl_pricing_subtitle', __('Pilih paket yang sesuai kebutuhan rekrutmen Anda', 'hakajobs'));
$pl_pricing_note  = get_theme_mod('hakajobs_pl_pricing_note', __('💡 Catatan: Harga dapat disesuaikan. Hubungi admin untuk paket bundling atau diskon khusus pengguna pertama.', 'hakajobs'));

// Paket 1 (Basic)
$pl_basic_name     = get_theme_mod('hakajobs_pl_basic_name', 'Basic');
$pl_basic_price    = get_theme_mod('hakajobs_pl_basic_price', 'Gratis');
$pl_basic_period   = get_theme_mod('hakajobs_pl_basic_period', '');
$pl_basic_desc     = get_theme_mod('hakajobs_pl_basic_desc', __('Cocok untuk UKM dan startup yang baru mulai rekrut', 'hakajobs'));
$pl_basic_features = get_theme_mod('hakajobs_pl_basic_features', '');
$pl_basic_btn      = get_theme_mod('hakajobs_pl_basic_btn', (!empty($wa_clean) ? __('Chat Admin', 'hakajobs') : __('Email Admin', 'hakajobs')));

// Paket 2 (Featured)
$pl_featured_badge    = get_theme_mod('hakajobs_pl_featured_badge', __('Paling Populer', 'hakajobs'));
$pl_featured_name     = get_theme_mod('hakajobs_pl_featured_name', 'Featured');
$pl_featured_price    = get_theme_mod('hakajobs_price_featured', 'Rp 50.000');
$pl_featured_period   = get_theme_mod('hakajobs_pl_featured_period', '/ 30 hari');
$pl_featured_desc     = get_theme_mod('hakajobs_pl_featured_desc', __('Untuk perusahaan yang ingin mendapat lebih banyak pelamar berkualitas', 'hakajobs'));
$pl_featured_features = get_theme_mod('hakajobs_pl_featured_features', '');
$pl_featured_btn      = get_theme_mod('hakajobs_pl_featured_btn', (!empty($wa_clean) ? __('Pasang Sekarang', 'hakajobs') : __('Hubungi Admin', 'hakajobs')));

// Paket 3 (Urgent) — Tanpa emoji 🔥
$pl_urgent_name     = get_theme_mod('hakajobs_pl_urgent_name', 'Urgent');
$pl_urgent_price    = get_theme_mod('hakajobs_price_urgent', 'Rp 75.000');
$pl_urgent_period   = get_theme_mod('hakajobs_pl_urgent_period', '/ 14 hari');
$pl_urgent_desc     = get_theme_mod('hakajobs_pl_urgent_desc', __('Rekrut cepat! Untuk posisi yang harus diisi dalam waktu singkat', 'hakajobs'));
$pl_urgent_features = get_theme_mod('hakajobs_pl_urgent_features', '');
$pl_urgent_btn      = get_theme_mod('hakajobs_pl_urgent_btn', (!empty($wa_clean) ? __('Pasang Urgent', 'hakajobs') : __('Hubungi Admin', 'hakajobs')));

// Cara Pasang (Langkah)
$pl_how_title   = get_theme_mod('hakajobs_pl_how_title', __('Cara Pasang Loker', 'hakajobs'));
$pl_how_sub     = get_theme_mod('hakajobs_pl_how_subtitle', __('Hanya 3 langkah, loker Anda langsung tayang', 'hakajobs'));
$pl_step1_title = get_theme_mod('hakajobs_pl_step1_title', __('Kirim Detail Lowongan', 'hakajobs'));
$pl_step1_desc  = get_theme_mod('hakajobs_pl_step1_desc', __('Hubungi admin via WhatsApp atau email dengan info lengkap: nama perusahaan, posisi, lokasi, gaji, dan kontak HRD.', 'hakajobs'));
$pl_step2_title = get_theme_mod('hakajobs_pl_step2_title', __('Verifikasi & Pembayaran', 'hakajobs'));
$pl_step2_desc  = get_theme_mod('hakajobs_pl_step2_desc', __('Admin memverifikasi data dan mengkonfirmasi paket pilihan Anda. Pembayaran untuk paket berbayar bisa via transfer bank atau dompet digital.', 'hakajobs'));
$pl_step3_title = get_theme_mod('hakajobs_pl_step3_title', __('Loker Tayang!', 'hakajobs'));
$pl_step3_desc  = get_theme_mod('hakajobs_pl_step3_desc', __('Lowongan Anda langsung tayang dan dapat ditemukan oleh ribuan pencari kerja aktif, termasuk melalui Google Jobs.', 'hakajobs'));

// Form Pengajuan
$pl_form_title = get_theme_mod('hakajobs_pl_form_title', __('Kirim Data Lowongan', 'hakajobs'));
$pl_form_desc  = get_theme_mod('hakajobs_pl_form_desc', __('Isi form di bawah ini dan admin akan segera menghubungi Anda dalam waktu 1×24 jam.', 'hakajobs'));
$pl_form_btn   = get_theme_mod('hakajobs_pl_form_btn', __('Kirim via WhatsApp', 'hakajobs'));

// CTA Bawah
$pl_cta_title = get_theme_mod('hakajobs_pl_cta_title', __('Siap Menemukan Karyawan Terbaik?', 'hakajobs'));
$pl_cta_desc  = get_theme_mod('hakajobs_pl_cta_desc', '');
if (empty($pl_cta_desc)) {
    $pl_cta_desc = sprintf(__('Bergabung bersama ratusan perusahaan yang sudah mempercayakan rekrutmen mereka di %s', 'hakajobs'), $site_name);
}
$pl_cta_btn   = get_theme_mod('hakajobs_pl_cta_btn', __('Chat WhatsApp Admin', 'hakajobs'));

// Pesan template WhatsApp untuk paket
$wa_msg_basic = rawurlencode(
    "Halo Tim Admin {$site_name},\n\n" .
    "Saya ingin mengajukan pemasangan lowongan kerja untuk *Paket {$pl_basic_name}*. Berikut rincian informasinya:\n\n" .
    "📋 *DATA LOWONGAN KERJA:*\n" .
    "━━━━━━━━━━━━━━━━━━━━\n" .
    "• Nama Perusahaan : \n" .
    "• Posisi Lowongan : \n" .
    "• Lokasi Kerja    : \n" .
    "• Tipe Pekerjaan  : (Full-Time / Part-Time / Freelance / Magang)\n" .
    "• Kisaran Gaji    : \n" .
    "• Batas Lamaran   : \n" .
    "• Kontak HRD      : (No. WhatsApp / Email Lamaran)\n\n" .
    "📝 *Deskripsi Singkat & Kualifikasi:*\n" .
    "(Tuliskan kualifikasi singkat dan persyaratan)\n\n" .
    "━━━━━━━━━━━━━━━━━━━━\n" .
    "Mohon bantuan untuk verifikasi dan proses penayangannya. Terima kasih!"
);

$wa_msg_featured = rawurlencode(
    "Halo Tim Admin {$site_name},\n\n" .
    "Saya ingin mengajukan pemasangan lowongan kerja untuk *Paket {$pl_featured_name}*. Berikut rincian informasinya:\n\n" .
    "📋 *DATA LOWONGAN KERJA:*\n" .
    "━━━━━━━━━━━━━━━━━━━━\n" .
    "• Nama Perusahaan : \n" .
    "• Posisi Lowongan : \n" .
    "• Lokasi Kerja    : \n" .
    "• Tipe Pekerjaan  : \n" .
    "• Kisaran Gaji    : \n" .
    "• Batas Lamaran   : \n" .
    "• Kontak HRD      : (No. WhatsApp / Email Lamaran)\n\n" .
    "📝 *Deskripsi Singkat & Kualifikasi:*\n" .
    "(Tuliskan kualifikasi singkat dan persyaratan)\n\n" .
    "━━━━━━━━━━━━━━━━━━━━\n" .
    "Mohon informasi rekening pembayaran dan konfirmasi penayangannya. Terima kasih!"
);

$wa_msg_urgent = rawurlencode(
    "Halo Tim Admin {$site_name},\n\n" .
    "Saya ingin mengajukan pemasangan lowongan kerja untuk *Paket {$pl_urgent_name}*. Berikut rincian informasinya:\n\n" .
    "📋 *DATA LOWONGAN KERJA:*\n" .
    "━━━━━━━━━━━━━━━━━━━━\n" .
    "• Nama Perusahaan : \n" .
    "• Posisi Lowongan : \n" .
    "• Lokasi Kerja    : \n" .
    "• Tipe Pekerjaan  : \n" .
    "• Kisaran Gaji    : \n" .
    "• Batas Lamaran   : \n" .
    "• Kontak HRD      : (No. WhatsApp / Email Lamaran)\n\n" .
    "📝 *Deskripsi Singkat & Kualifikasi:*\n" .
    "(Tuliskan kualifikasi singkat dan persyaratan)\n\n" .
    "━━━━━━━━━━━━━━━━━━━━\n" .
    "Mohon informasi rekening pembayaran dan konfirmasi penayangan prioritas 1x24 jam. Terima kasih!"
);

$wa_url_basic    = !empty($wa_clean) ? "https://wa.me/{$wa_clean}?text={$wa_msg_basic}" : "mailto:{$contact_email}";
$wa_url_featured = !empty($wa_clean) ? "https://wa.me/{$wa_clean}?text={$wa_msg_featured}" : "mailto:{$contact_email}";
$wa_url_urgent   = !empty($wa_clean) ? "https://wa.me/{$wa_clean}?text={$wa_msg_urgent}" : "mailto:{$contact_email}";

// Helper untuk render fitur paket
if (!function_exists('hakajobs_render_pl_feature_list')) {
    function hakajobs_render_pl_feature_list($custom_text, $defaults) {
        if (!empty(trim($custom_text))) {
            $lines = explode("\n", str_replace("\r", "", trim($custom_text)));
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;
                $is_muted = (0 === strpos($line, '-') || 0 === strpos($line, 'x ') || 0 === strpos($line, 'x:') || 0 === strpos($line, '✗'));
                $clean = preg_replace('/^[-x✗!:\s]+/', '', $line);
                if ($is_muted) {
                    echo '<li><span class="hkpl-muted">✗</span> ' . esc_html($clean) . '</li>';
                } else {
                    echo '<li><span class="hkpl-check">✓</span> ' . wp_kses_post($clean) . '</li>';
                }
            }
        } else {
            foreach ($defaults as $item) {
                if (!empty($item['muted'])) {
                    echo '<li><span class="hkpl-muted">✗</span> ' . $item['text'] . '</li>';
                } else {
                    echo '<li><span class="hkpl-check">✓</span> ' . $item['text'] . '</li>';
                }
            }
        }
    }
}

// Enqueue styles
if (!wp_style_is('hakajobs-pasang-loker', 'enqueued')) {
    $min = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
    $pl_css = file_exists(HAKAJOBS_DIR . '/assets/css/pasang-loker' . $min . '.css') ? '/assets/css/pasang-loker' . $min . '.css' : '/assets/css/pasang-loker.css';
    wp_enqueue_style('hakajobs-pasang-loker', HAKAJOBS_URI . $pl_css, array('hakajobs-main-style'), HAKAJOBS_VERSION);
}
?>

<main id="hk-main" class="hk-pasang-loker-page">

    <?php
    $pl_hero_style = get_theme_mod('hakajobs_pl_hero_style', 'default');
    $pl_hero_class = 'hkpl-hero-default';
    if ($pl_hero_style === 'converter') {
        $pl_hero_class = 'hkpl-hero-converter';
    } elseif ($pl_hero_style === 'minimal') {
        $pl_hero_class = 'hkpl-hero-minimal';
    }
    ?>
    <!-- ===================== HERO SECTION ===================== -->
    <section class="hkpl-hero <?php echo esc_attr($pl_hero_class); ?>">
        <div class="hk-container">
            <?php if ($pl_hero_style === 'converter'): ?>
                <div class="hkpl-converter-grid">
                    <div class="hkpl-converter-left">
                        <?php if (!empty($pl_hero_badge)): ?>
                        <div class="hkpl-hero-badge">
                            <span>💼</span> <?php echo esc_html($pl_hero_badge); ?>
                        </div>
                        <?php endif; ?>

                        <h1 class="hkpl-hero-title">
                            <?php echo esc_html($pl_hero_title); ?><br>
                            <span class="hkpl-hero-highlight"><?php echo esc_html($pl_hero_highlight); ?></span>
                        </h1>

                        <?php if (!empty($pl_hero_sub)): ?>
                        <p class="hkpl-hero-sub">
                            <?php echo esc_html($pl_hero_sub); ?>
                        </p>
                        <?php endif; ?>

                        <div class="hkpl-converter-benefits">
                            <div class="hkpl-benefit-row">
                                <span class="hkpl-check">✓</span>
                                <span><?php _e('Tayang Cepat 1×24 Jam setelah konfirmasi admin', 'hakajobs'); ?></span>
                            </div>
                            <div class="hkpl-benefit-row">
                                <span class="hkpl-check">✓</span>
                                <span><?php _e('Pelamar langsung menghubungi WhatsApp / Email HRD Anda', 'hakajobs'); ?></span>
                            </div>
                            <div class="hkpl-benefit-row">
                                <span class="hkpl-check">✓</span>
                                <span><?php _e('Paket fleksibel mulai dari Gratis hingga Prioritas Urgent', 'hakajobs'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="hkpl-converter-right">
                        <div class="hkpl-converter-card">
                            <span class="hkpl-card-badge"><?php _e('FAST TRACK REKRUTMEN', 'hakajobs'); ?></span>
                            <h3 class="hkpl-card-title"><?php _e('Pasang Lowongan Sekarang', 'hakajobs'); ?></h3>
                            <p class="hkpl-card-desc"><?php _e('Konsultasikan kebutuhan rekrutmen atau kirim draft info loker langsung ke tim admin kami.', 'hakajobs'); ?></p>
                            
                            <a href="<?php echo esc_url($wa_url_featured); ?>" target="_blank" rel="noopener noreferrer" class="hk-btn hkpl-btn-consult-wa">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                <span><?php _e('Hubungi WhatsApp Admin', 'hakajobs'); ?></span>
                            </a>

                            <div class="hkpl-card-note">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                <span><?php _e('100% Aman • Langsung Dibalas Tim Admin', 'hakajobs'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Default / Minimal Layout -->
                <?php if (!empty($pl_hero_badge)): ?>
                <div class="hkpl-hero-badge">
                    <span>💼</span> <?php echo esc_html($pl_hero_badge); ?>
                </div>
                <?php endif; ?>

                <h1 class="hkpl-hero-title">
                    <?php echo esc_html($pl_hero_title); ?><br>
                    <span class="hkpl-hero-highlight"><?php echo esc_html($pl_hero_highlight); ?></span>
                </h1>

                <?php if (!empty($pl_hero_sub)): ?>
                <p class="hkpl-hero-sub">
                    <?php echo esc_html($pl_hero_sub); ?>
                </p>
                <?php endif; ?>

                <div class="hkpl-hero-stats">
                    <div class="hkpl-stat">
                        <span class="hkpl-stat-num"><?php echo esc_html($pl_stat1_num); ?></span>
                        <span class="hkpl-stat-label"><?php echo esc_html($pl_stat1_label); ?></span>
                    </div>
                    <div class="hkpl-stat-sep"></div>
                    <div class="hkpl-stat">
                        <span class="hkpl-stat-num"><?php echo esc_html($pl_stat2_num); ?></span>
                        <span class="hkpl-stat-label"><?php echo esc_html($pl_stat2_label); ?></span>
                    </div>
                    <div class="hkpl-stat-sep"></div>
                    <div class="hkpl-stat">
                        <span class="hkpl-stat-num"><?php echo esc_html($pl_stat3_num); ?></span>
                        <span class="hkpl-stat-label"><?php echo esc_html($pl_stat3_label); ?></span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php if ($pl_hero_style === 'default'): ?>
        <div class="hkpl-hero-wave">
            <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0 60L60 50C120 40 240 20 360 16.7C480 13.3 600 26.7 720 33.3C840 40 960 40 1080 33.3C1200 26.7 1320 13.3 1380 6.7L1440 0V60H1380C1320 60 1200 60 1080 60C960 60 840 60 720 60C600 60 480 60 360 60C240 60 120 60 60 60H0Z" fill="var(--hk-bg-body, #f8fafc)"/></svg>
        </div>
        <?php endif; ?>
    </section>

    <!-- ===================== KEUNGGULAN ===================== -->
    <?php if ($pl_show_features === '1'): ?>
    <section class="hkpl-features">
        <div class="hk-container">
            <div class="hkpl-features-grid">
                <div class="hkpl-feature-card">
                    <div class="hkpl-feature-icon">🎯</div>
                    <h3><?php _e('Tepat Sasaran', 'hakajobs'); ?></h3>
                    <p><?php _e('Lowongan Anda tampil ke pencari kerja yang aktif mencari di daerah & bidang yang relevan.', 'hakajobs'); ?></p>
                </div>
                <div class="hkpl-feature-card">
                    <div class="hkpl-feature-icon">⚡</div>
                    <h3><?php _e('Tayang Cepat', 'hakajobs'); ?></h3>
                    <p><?php _e('Verifikasi & publikasi dalam 1×24 jam. Hubungi admin sekarang dan loker langsung naik.', 'hakajobs'); ?></p>
                </div>
                <div class="hkpl-feature-card">
                    <div class="hkpl-feature-icon">🛡️</div>
                    <h3><?php _e('Bebas Spam', 'hakajobs'); ?></h3>
                    <p><?php _e('Setiap lowongan diverifikasi admin. Tidak ada loker palsu atau penipuan yang merugikan brand Anda.', 'hakajobs'); ?></p>
                </div>
                <div class="hkpl-feature-card">
                    <div class="hkpl-feature-icon">🔍</div>
                    <h3><?php _e('SEO Google Jobs', 'hakajobs'); ?></h3>
                    <p><?php _e('Loker Anda otomatis muncul di Google Jobs berkat schema JobPosting terstruktur.', 'hakajobs'); ?></p>
                </div>
                <div class="hkpl-feature-card">
                    <div class="hkpl-feature-icon">📲</div>
                    <h3><?php _e('Lamaran via WA', 'hakajobs'); ?></h3>
                    <p><?php _e('Kandidat melamar langsung ke WhatsApp / email HRD Anda. Tidak perlu sistem login rumit.', 'hakajobs'); ?></p>
                </div>
                <div class="hkpl-feature-card">
                    <div class="hkpl-feature-icon">📊</div>
                    <h3><?php _e('Branding Perusahaan', 'hakajobs'); ?></h3>
                    <p><?php _e('Logo perusahaan tampil menonjol di setiap kartu lowongan. Tingkatkan brand awareness Anda.', 'hakajobs'); ?></p>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ===================== PAKET TARIF ===================== -->
    <section class="hkpl-pricing" id="paket-loker">
        <div class="hk-container">
            <div class="hkpl-section-header">
                <?php if (!empty($pl_pricing_badge)): ?>
                <span class="hkpl-section-badge"><?php echo esc_html($pl_pricing_badge); ?></span>
                <?php endif; ?>
                <h2><?php echo esc_html($pl_pricing_title); ?></h2>
                <?php if (!empty($pl_pricing_sub)): ?>
                <p><?php echo esc_html($pl_pricing_sub); ?></p>
                <?php endif; ?>
            </div>

            <div class="hkpl-pricing-grid">

                <!-- Paket Basic -->
                <div class="hkpl-pricing-card">
                    <div class="hkpl-pricing-header">
                        <div class="hkpl-pricing-icon">📋</div>
                        <h3 class="hkpl-pricing-name"><?php echo esc_html($pl_basic_name); ?></h3>
                        <div class="hkpl-pricing-price">
                            <span class="hkpl-price-amount"><?php echo esc_html($pl_basic_price); ?></span>
                            <?php if (!empty($pl_basic_period)): ?>
                            <span class="hkpl-price-period"><?php echo esc_html($pl_basic_period); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($pl_basic_desc)): ?>
                        <p class="hkpl-pricing-desc"><?php echo esc_html($pl_basic_desc); ?></p>
                        <?php endif; ?>
                    </div>
                    <ul class="hkpl-pricing-features">
                        <?php
                        $basic_defaults = array(
                            array('text' => __('Tayang 30 hari', 'hakajobs'), 'muted' => false),
                            array('text' => __('Tampil di halaman arsip loker', 'hakajobs'), 'muted' => false),
                            array('text' => __('Logo perusahaan (avatar inisial)', 'hakajobs'), 'muted' => false),
                            array('text' => __('Muncul di Google Jobs (SEO)', 'hakajobs'), 'muted' => false),
                            array('text' => __('Lamaran via WA / Email / Web', 'hakajobs'), 'muted' => false),
                            array('text' => __('Badge Featured / Urgent', 'hakajobs'), 'muted' => true),
                            array('text' => __('Prioritas tampil di atas', 'hakajobs'), 'muted' => true),
                            array('text' => __('Logo perusahaan (upload sendiri)', 'hakajobs'), 'muted' => true),
                        );
                        hakajobs_render_pl_feature_list($pl_basic_features, $basic_defaults);
                        ?>
                    </ul>
                    <a href="<?php echo esc_url($wa_url_basic); ?>" class="hkpl-btn hkpl-btn-outline" target="_blank" rel="noopener" id="hkpl-btn-basic">
                        <?php echo esc_html($pl_basic_btn); ?>
                    </a>
                </div>

                <!-- Paket Featured (POPULER) -->
                <div class="hkpl-pricing-card hkpl-pricing-popular">
                    <?php if (!empty($pl_featured_badge)): ?>
                    <div class="hkpl-popular-badge"><?php echo esc_html($pl_featured_badge); ?></div>
                    <?php endif; ?>
                    <div class="hkpl-pricing-header">
                        <div class="hkpl-pricing-icon">🌟</div>
                        <h3 class="hkpl-pricing-name"><?php echo esc_html($pl_featured_name); ?></h3>
                        <div class="hkpl-pricing-price">
                            <span class="hkpl-price-amount"><?php echo esc_html($pl_featured_price); ?></span>
                            <?php if (!empty($pl_featured_period)): ?>
                            <span class="hkpl-price-period"><?php echo esc_html($pl_featured_period); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($pl_featured_desc)): ?>
                        <p class="hkpl-pricing-desc"><?php echo esc_html($pl_featured_desc); ?></p>
                        <?php endif; ?>
                    </div>
                    <ul class="hkpl-pricing-features">
                        <?php
                        $featured_defaults = array(
                            array('text' => __('Tayang 30 hari', 'hakajobs'), 'muted' => false),
                            array('text' => __('Badge <strong>"Featured"</strong> di kartu loker', 'hakajobs'), 'muted' => false),
                            array('text' => __('Prioritas tampil di urutan atas', 'hakajobs'), 'muted' => false),
                            array('text' => __('Upload logo perusahaan sendiri', 'hakajobs'), 'muted' => false),
                            array('text' => __('Muncul di Google Jobs (SEO)', 'hakajobs'), 'muted' => false),
                            array('text' => __('Lamaran via WA / Email / Web', 'hakajobs'), 'muted' => false),
                            array('text' => __('Preview kartu loker sebelum tayang', 'hakajobs'), 'muted' => false),
                            array('text' => __('Notifikasi WhatsApp ke Admin', 'hakajobs'), 'muted' => false),
                        );
                        hakajobs_render_pl_feature_list($pl_featured_features, $featured_defaults);
                        ?>
                    </ul>
                    <a href="<?php echo esc_url($wa_url_featured); ?>" class="hkpl-btn hkpl-btn-primary" target="_blank" rel="noopener" id="hkpl-btn-featured">
                        <?php echo esc_html($pl_featured_btn); ?>
                    </a>
                </div>

                <!-- Paket Urgent (Tanpa emoji 🔥) -->
                <div class="hkpl-pricing-card">
                    <div class="hkpl-pricing-header">
                        <div class="hkpl-pricing-icon">⚡</div>
                        <h3 class="hkpl-pricing-name"><?php echo esc_html($pl_urgent_name); ?></h3>
                        <div class="hkpl-pricing-price">
                            <span class="hkpl-price-amount"><?php echo esc_html($pl_urgent_price); ?></span>
                            <?php if (!empty($pl_urgent_period)): ?>
                            <span class="hkpl-price-period"><?php echo esc_html($pl_urgent_period); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($pl_urgent_desc)): ?>
                        <p class="hkpl-pricing-desc"><?php echo esc_html($pl_urgent_desc); ?></p>
                        <?php endif; ?>
                    </div>
                    <ul class="hkpl-pricing-features">
                        <?php
                        $urgent_defaults = array(
                            array('text' => __('Tayang 14 hari (rekrut cepat)', 'hakajobs'), 'muted' => false),
                            array('text' => __('Badge <strong>"Urgent"</strong> mencolok', 'hakajobs'), 'muted' => false),
                            array('text' => __('<strong>Posisi teratas</strong> di atas Featured', 'hakajobs'), 'muted' => false),
                            array('text' => __('Upload logo perusahaan sendiri', 'hakajobs'), 'muted' => false),
                            array('text' => __('Muncul di Google Jobs (SEO)', 'hakajobs'), 'muted' => false),
                            array('text' => __('Lamaran via WA / Email / Web', 'hakajobs'), 'muted' => false),
                            array('text' => __('Preview kartu loker sebelum tayang', 'hakajobs'), 'muted' => false),
                            array('text' => __('Prioritas respons admin hari ini', 'hakajobs'), 'muted' => false),
                        );
                        hakajobs_render_pl_feature_list($pl_urgent_features, $urgent_defaults);
                        ?>
                    </ul>
                    <a href="<?php echo esc_url($wa_url_urgent); ?>" class="hkpl-btn hkpl-btn-urgent" target="_blank" rel="noopener" id="hkpl-btn-urgent">
                        <?php echo esc_html($pl_urgent_btn); ?>
                    </a>
                </div>

            </div>

            <?php if (!empty($pl_pricing_note)): ?>
            <p class="hkpl-pricing-note">
                <?php echo esc_html($pl_pricing_note); ?>
            </p>
            <?php endif; ?>
        </div>
    </section>

    <!-- ===================== KONTEN DARI EDITOR LAMAN WORDPRESS ===================== -->
    <?php if ($pl_show_page_content === '1' && have_posts()): ?>
        <?php while (have_posts()): the_post(); ?>
            <?php 
            $page_content = get_the_content();
            if (!empty(trim($page_content))): ?>
                <section class="hkpl-custom-content">
                    <div class="hk-container">
                        <div class="hkpl-content-card hk-typography">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php endif; ?>

    <!-- ===================== CARA PASANG ===================== -->
    <?php if ($pl_show_how === '1'): ?>
    <section class="hkpl-how">
        <div class="hk-container">
            <div class="hkpl-section-header">
                <h2><?php echo esc_html($pl_how_title); ?></h2>
                <?php if (!empty($pl_how_sub)): ?>
                <p><?php echo esc_html($pl_how_sub); ?></p>
                <?php endif; ?>
            </div>
            <div class="hkpl-steps">
                <div class="hkpl-step">
                    <div class="hkpl-step-num">1</div>
                    <div class="hkpl-step-body">
                        <h3><?php echo esc_html($pl_step1_title); ?></h3>
                        <p><?php echo esc_html($pl_step1_desc); ?></p>
                    </div>
                </div>
                <div class="hkpl-step-arrow">→</div>
                <div class="hkpl-step">
                    <div class="hkpl-step-num">2</div>
                    <div class="hkpl-step-body">
                        <h3><?php echo esc_html($pl_step2_title); ?></h3>
                        <p><?php echo esc_html($pl_step2_desc); ?></p>
                    </div>
                </div>
                <div class="hkpl-step-arrow">→</div>
                <div class="hkpl-step">
                    <div class="hkpl-step-num">3</div>
                    <div class="hkpl-step-body">
                        <h3><?php echo esc_html($pl_step3_title); ?></h3>
                        <p><?php echo esc_html($pl_step3_desc); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ===================== FORM KIRIM LOKER ===================== -->
    <?php if ($pl_show_form === '1'): ?>
    <section class="hkpl-form-section" id="form-loker">
        <div class="hk-container">
            <div class="hkpl-form-wrap">
                <div class="hkpl-form-info">
                    <h2><?php echo esc_html($pl_form_title); ?></h2>
                    <?php if (!empty($pl_form_desc)): ?>
                    <p><?php echo esc_html($pl_form_desc); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($wa_clean)): ?>
                    <a href="https://wa.me/<?php echo esc_attr($wa_clean); ?>" class="hkpl-contact-wa" target="_blank" rel="noopener" id="hkpl-contact-wa-link">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        <?php _e('WhatsApp Admin Sekarang', 'hakajobs'); ?>
                    </a>
                    <?php endif; ?>

                    <?php if (!empty($contact_email)): ?>
                    <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="hkpl-contact-email" id="hkpl-contact-email-link">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
                        <?php echo esc_html($contact_email); ?>
                    </a>
                    <?php endif; ?>
                </div>

                <form class="hkpl-form" id="hkpl-submission-form" novalidate>
                    <div class="hkpl-form-row hkpl-form-row-2">
                        <div class="hkpl-form-group">
                            <label for="hkpl-company"><?php _e('Nama Perusahaan', 'hakajobs'); ?> <span class="hkpl-required">*</span></label>
                            <input type="text" id="hkpl-company" name="company" class="hkpl-input" placeholder="<?php esc_attr_e('PT Maju Bersama', 'hakajobs'); ?>" required>
                        </div>
                        <div class="hkpl-form-group">
                            <label for="hkpl-position"><?php _e('Posisi / Jabatan', 'hakajobs'); ?> <span class="hkpl-required">*</span></label>
                            <input type="text" id="hkpl-position" name="position" class="hkpl-input" placeholder="<?php esc_attr_e('Staff Administrasi', 'hakajobs'); ?>" required>
                        </div>
                    </div>
                    <div class="hkpl-form-row hkpl-form-row-2">
                        <div class="hkpl-form-group">
                            <label for="hkpl-location"><?php _e('Lokasi Kerja', 'hakajobs'); ?> <span class="hkpl-required">*</span></label>
                            <input type="text" id="hkpl-location" name="location" class="hkpl-input" placeholder="<?php esc_attr_e('Bandar Lampung / Jakarta / Remote', 'hakajobs'); ?>">
                        </div>
                        <div class="hkpl-form-group">
                            <label for="hkpl-jobtype"><?php _e('Tipe Pekerjaan', 'hakajobs'); ?></label>
                            <select id="hkpl-jobtype" name="jobtype" class="hkpl-select">
                                <option value="">-- <?php _e('Pilih Tipe', 'hakajobs'); ?> --</option>
                                <option>Full-Time</option>
                                <option>Part-Time</option>
                                <option>Magang (Internship)</option>
                                <option>Freelance / Kontrak</option>
                                <option>Remote / WFH</option>
                            </select>
                        </div>
                    </div>
                    <div class="hkpl-form-row hkpl-form-row-2">
                        <div class="hkpl-form-group">
                            <label for="hkpl-salary"><?php _e('Kisaran Gaji', 'hakajobs'); ?></label>
                            <input type="text" id="hkpl-salary" name="salary" class="hkpl-input" placeholder="<?php esc_attr_e('Rp 3.000.000 – Rp 5.000.000', 'hakajobs'); ?>">
                        </div>
                        <div class="hkpl-form-group">
                            <label for="hkpl-deadline"><?php _e('Deadline Lamaran', 'hakajobs'); ?></label>
                            <input type="date" id="hkpl-deadline" name="deadline" class="hkpl-input">
                        </div>
                    </div>
                    <div class="hkpl-form-group">
                        <label for="hkpl-desc"><?php _e('Deskripsi Singkat Pekerjaan', 'hakajobs'); ?> <span class="hkpl-required">*</span></label>
                        <textarea id="hkpl-desc" name="description" rows="4" class="hkpl-textarea" placeholder="<?php esc_attr_e('Tugas utama, syarat & kualifikasi yang dibutuhkan...', 'hakajobs'); ?>" required></textarea>
                    </div>
                    <div class="hkpl-form-row hkpl-form-row-2">
                        <div class="hkpl-form-group">
                            <label for="hkpl-contact"><?php _e('Kontak HRD (WA/Email)', 'hakajobs'); ?> <span class="hkpl-required">*</span></label>
                            <input type="text" id="hkpl-contact" name="contact" class="hkpl-input" placeholder="<?php esc_attr_e('08xxxxxxxxxx / hrd@perusahaan.com', 'hakajobs'); ?>" required>
                        </div>
                        <div class="hkpl-form-group">
                            <label for="hkpl-package"><?php _e('Paket yang Dipilih', 'hakajobs'); ?></label>
                            <select id="hkpl-package" name="package" class="hkpl-select">
                                <option value="<?php echo esc_attr($pl_basic_name); ?>"><?php echo esc_html($pl_basic_name); ?> (<?php echo esc_html($pl_basic_price); ?>)</option>
                                <option value="<?php echo esc_attr($pl_featured_name); ?>" selected><?php echo esc_html($pl_featured_name); ?> (<?php echo esc_html($pl_featured_price); ?>)</option>
                                <option value="<?php echo esc_attr($pl_urgent_name); ?>"><?php echo esc_html($pl_urgent_name); ?> (<?php echo esc_html($pl_urgent_price); ?>)</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="hkpl-btn hkpl-btn-primary hkpl-btn-submit" id="hkpl-submit-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2L15 22 11 13 2 9l20-7z"/></svg>
                        <?php echo esc_html($pl_form_btn); ?>
                    </button>
                    <p class="hkpl-form-note"><?php _e('Form ini akan membuka WhatsApp dengan data yang sudah terisi otomatis.', 'hakajobs'); ?></p>
                </form>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ===================== FAQ ===================== -->
    <?php if ($pl_show_faq === '1'): ?>
    <section class="hkpl-faq">
        <div class="hk-container">
            <div class="hkpl-section-header">
                <h2><?php _e('Pertanyaan Umum', 'hakajobs'); ?></h2>
            </div>
            <div class="hkpl-faq-list" id="hkpl-faq-list">
                <?php
                $faqs = array(
                    array(
                        'q' => __('Berapa lama loker saya akan tayang?', 'hakajobs'),
                        'a' => __('Admin akan memproses dan mempublikasikan lowongan Anda dalam 1×24 jam setelah data diterima dan (untuk paket berbayar) pembayaran dikonfirmasi.', 'hakajobs')
                    ),
                    array(
                        'q' => __('Format apa yang harus saya kirimkan?', 'hakajobs'),
                        'a' => __('Anda bisa mengisi form di halaman ini dan otomatis terformat, atau kirim langsung via WhatsApp dengan format: Nama Perusahaan, Posisi, Lokasi, Gaji, Deadline, Deskripsi, dan Kontak HRD.', 'hakajobs')
                    ),
                    array(
                        'q' => __('Apakah lowongan saya muncul di Google?', 'hakajobs'),
                        'a' => __('Ya! Setiap lowongan yang tayang otomatis dilengkapi schema JobPosting yang diakui Google. Loker Anda berpotensi muncul di Google Jobs dan hasil pencarian organik.', 'hakajobs')
                    ),
                    array(
                        'q' => __('Metode pembayaran apa yang diterima?', 'hakajobs'),
                        'a' => __('Transfer bank (BCA, BRI, BNI, Mandiri), GoPay, OVO, DANA, dan ShopeePay. Hubungi admin untuk rekening terbaru.', 'hakajobs')
                    ),
                    array(
                        'q' => __('Bisakah loker diperpanjang setelah habis?', 'hakajobs'),
                        'a' => __('Tentu! Hubungi admin sebelum masa tayang berakhir untuk memperpanjang dengan harga yang sama atau memperbarui isi lowongan.', 'hakajobs')
                    ),
                    array(
                        'q' => __('Apakah ada diskon untuk beberapa posisi sekaligus?', 'hakajobs'),
                        'a' => __('Ada! Hubungi admin untuk mendapatkan penawaran paket bundling jika Anda ingin memasang 3 lowongan atau lebih sekaligus.', 'hakajobs')
                    ),
                );
                foreach ($faqs as $i => $faq): ?>
                <div class="hkpl-faq-item" id="hkpl-faq-<?php echo $i; ?>">
                    <button class="hkpl-faq-q" aria-expanded="false" aria-controls="hkpl-faq-ans-<?php echo $i; ?>">
                        <span><?php echo esc_html($faq['q']); ?></span>
                        <svg class="hkpl-faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div class="hkpl-faq-a" id="hkpl-faq-ans-<?php echo $i; ?>" hidden>
                        <p><?php echo esc_html($faq['a']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ===================== CTA BOTTOM ===================== -->
    <?php if ($pl_show_cta === '1'): ?>
    <section class="hkpl-cta-bottom">
        <div class="hk-container">
            <h2><?php echo esc_html($pl_cta_title); ?></h2>
            <p><?php echo esc_html($pl_cta_desc); ?></p>
            <div class="hkpl-cta-actions">
                <?php if (!empty($wa_clean)): ?>
                <a href="https://wa.me/<?php echo esc_attr($wa_clean); ?>" class="hkpl-btn hkpl-btn-wa" target="_blank" rel="noopener" id="hkpl-cta-wa-bottom">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    <?php echo esc_html($pl_cta_btn); ?>
                </a>
                <?php endif; ?>
                <a href="#paket-loker" class="hkpl-btn hkpl-btn-outline-white" id="hkpl-cta-lihat-paket"><?php _e('Lihat Paket →', 'hakajobs'); ?></a>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<script>
(function() {
    // FAQ Accordion
    document.querySelectorAll('.hkpl-faq-q').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var expanded = this.getAttribute('aria-expanded') === 'true';
            document.querySelectorAll('.hkpl-faq-q').forEach(function(b) {
                b.setAttribute('aria-expanded', 'false');
                var ans = document.getElementById(b.getAttribute('aria-controls'));
                if (ans) ans.hidden = true;
                b.closest('.hkpl-faq-item').classList.remove('hkpl-faq-open');
            });
            if (!expanded) {
                this.setAttribute('aria-expanded', 'true');
                var ans = document.getElementById(this.getAttribute('aria-controls'));
                if (ans) ans.hidden = false;
                this.closest('.hkpl-faq-item').classList.add('hkpl-faq-open');
            }
        });
    });

    // Form → WhatsApp
    var form = document.getElementById('hkpl-submission-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            var company  = document.getElementById('hkpl-company').value.trim();
            var position = document.getElementById('hkpl-position').value.trim();
            var location = document.getElementById('hkpl-location').value.trim();
            var jobtype  = document.getElementById('hkpl-jobtype').value;
            var salary   = document.getElementById('hkpl-salary').value.trim();
            var deadline = document.getElementById('hkpl-deadline').value;
            var desc     = document.getElementById('hkpl-desc').value.trim();
            var contact  = document.getElementById('hkpl-contact').value.trim();
            var pkg      = document.getElementById('hkpl-package').value;

            if (!company || !position || !contact || !desc) {
                alert('Mohon isi field yang wajib diisi (Nama Perusahaan, Posisi, Deskripsi, Kontak HRD).');
                return;
            }

            var siteName = '<?php echo esc_js($site_name); ?>';
            var msg = "Halo Tim Admin " + siteName + ",\n\n"
                + "Saya ingin mengajukan pemasangan lowongan kerja melalui form website. Berikut rincian informasinya:\n\n"
                + "📋 *DATA PENGAJUAN LOKER:*\n"
                + "━━━━━━━━━━━━━━━━━━━━\n"
                + "• Pilihan Paket : " + pkg + "\n"
                + "• Perusahaan    : " + company + "\n"
                + "• Posisi / Role : " + position + "\n"
                + "• Lokasi Kerja  : " + (location || '-') + "\n"
                + "• Tipe Kerja    : " + (jobtype || '-') + "\n"
                + "• Kisaran Gaji  : " + (salary || '-') + "\n"
                + "• Batas Lamaran : " + (deadline || '-') + "\n"
                + "• Kontak HRD    : " + contact + "\n\n"
                + "📝 *Deskripsi & Kualifikasi:*\n"
                + desc + "\n\n"
                + "━━━━━━━━━━━━━━━━━━━━\n"
                + "Mohon konfirmasi verifikasi data dan penayangan lowongan ini. Terima kasih!";

            var waNumber = '<?php echo esc_js($wa_clean); ?>';
            var adminEmail = '<?php echo esc_js($contact_email); ?>';

            if (waNumber) {
                window.open('https://wa.me/' + waNumber + '?text=' + encodeURIComponent(msg), '_blank');
            } else {
                var emailSubject = 'Pengajuan Pasang Loker [' + pkg + '] - ' + company + ' (' + position + ')';
                window.location.href = 'mailto:' + adminEmail + '?subject=' + encodeURIComponent(emailSubject) + '&body=' + encodeURIComponent(msg);
            }
        });
    }
})();
</script>

<?php get_footer(); ?>
