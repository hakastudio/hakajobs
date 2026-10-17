<?php
/**
 * Front Page Template for Hakajobs
 *
 * @package Hakajobs
 */

get_header();
?>

<?php
$hero_style        = get_theme_mod('hakajobs_hero_style', 'pasang-loker');
$hero_badge        = get_theme_mod('hakajobs_hero_badge', __('💼 Portal Loker Terpercaya & Lamar Langsung', 'hakajobs'));
$hero_title        = get_theme_mod('hakajobs_hero_title', __('Temukan Lowongan Kerja Impian & Lamar Langsung ke Rekruter', 'hakajobs'));
$hero_highlight    = get_theme_mod('hakajobs_hero_highlight', __('Lamar Langsung ke Rekruter', 'hakajobs'));
$hero_subtitle     = get_theme_mod('hakajobs_hero_subtitle', __('Ribuan info loker terkurasi setiap hari. Terhubung langsung melalui WhatsApp HRD, Email, dan Karir Resmi tanpa proses pembuatan akun yang berbelit.', 'hakajobs'));
$hero_placeholder  = get_theme_mod('hakajobs_hero_search_placeholder', __('Posisi, keahlian, atau perusahaan...', 'hakajobs'));
$hero_search_btn   = get_theme_mod('hakajobs_hero_search_btn', __('Cari Loker', 'hakajobs'));

$show_stats        = get_theme_mod('hakajobs_hero_show_stats', '1');
$stat1_num         = get_theme_mod('hakajobs_hero_stat1_num', '');
$stat1_label       = get_theme_mod('hakajobs_hero_stat1_label', __('Lowongan Aktif', 'hakajobs'));
$stat2_num         = get_theme_mod('hakajobs_hero_stat2_num', '');
$stat2_label       = get_theme_mod('hakajobs_hero_stat2_label', __('Kategori Bidang', 'hakajobs'));
$stat3_num         = get_theme_mod('hakajobs_hero_stat3_num', __('1×24 Jam', 'hakajobs'));
$stat3_label       = get_theme_mod('hakajobs_hero_stat3_label', __('Respon Rekruter', 'hakajobs'));
$show_wave         = get_theme_mod('hakajobs_hero_show_wave', '1');

// Hitung statistik otomatis jika kosong
if (empty($stat1_num)) {
    $counts    = wp_count_posts('lowongan');
    $stat1_num = (isset($counts->publish) && $counts->publish > 0) ? number_format_i18n($counts->publish) . '+' : '100+';
}
if (empty($stat2_num)) {
    $total_cats = wp_count_terms(array('taxonomy' => 'kategori_lowongan', 'hide_empty' => false));
    $stat2_num  = (!is_wp_error($total_cats) && $total_cats > 0) ? $total_cats . '+' : '20+';
}

// Render judul dengan efek gradien highlight
if (!empty($hero_highlight) && strpos($hero_title, $hero_highlight) !== false) {
    $escaped_title = esc_html($hero_title);
    $escaped_high  = esc_html($hero_highlight);
    $display_title = str_replace(
        $escaped_high,
        '<span class="hk-hero-highlight">' . $escaped_high . '</span>',
        $escaped_title
    );
} else {
    $display_title = esc_html($hero_title);
}
?>

<main id="hk-main" class="hk-site-main">

    <!-- Hero Search Section (Aksen Pasang Loker / Terang) -->
    <section class="hk-hero-section <?php echo ($hero_style === 'pasang-loker') ? 'hk-hero-pasangloker-theme' : 'hk-hero-light-theme'; ?>">
        <div class="hk-container">
            <div class="hk-hero-content">
                <?php if (!empty($hero_badge)): ?>
                    <div class="hk-hero-badge">
                        <?php echo esc_html($hero_badge); ?>
                    </div>
                <?php endif; ?>

                <h1 class="hk-hero-title">
                    <?php echo $display_title; ?>
                </h1>

                <p class="hk-hero-desc">
                    <?php echo nl2br(esc_html($hero_subtitle)); ?>
                </p>

                <!-- Main Hero Search Bar -->
                <div class="hk-hero-search-box">
                    <form action="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" method="get" class="hk-search-form">
                        <input type="hidden" name="post_type" value="lowongan">

                        <div class="hk-search-field-group">
                            <div class="hk-search-field hk-field-keyword">
                                <label for="hk-search-keyword" class="hk-sr-only"><?php _e('Kata Kunci', 'hakajobs'); ?></label>
                                <svg class="hk-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <input type="text" id="hk-search-keyword" name="s_keyword" placeholder="<?php echo esc_attr($hero_placeholder); ?>" autocomplete="off" />
                            </div>

                            <div class="hk-search-field hk-field-category">
                                <label for="hk-search-category" class="hk-sr-only"><?php _e('Kategori', 'hakajobs'); ?></label>
                                <svg class="hk-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                                <select id="hk-search-category" name="kategori">
                                    <option value=""><?php _e('Semua Kategori', 'hakajobs'); ?></option>
                                    <?php
                                    $cats = get_terms(array('taxonomy' => 'kategori_lowongan', 'hide_empty' => false));
                                    if (!empty($cats) && !is_wp_error($cats)) {
                                        foreach ($cats as $cat) {
                                            echo '<option value="' . esc_attr($cat->slug) . '">' . esc_html($cat->name) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="hk-search-field hk-field-location">
                                <label for="hk-search-location" class="hk-sr-only"><?php _e('Lokasi', 'hakajobs'); ?></label>
                                <svg class="hk-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <select id="hk-search-location" name="lokasi">
                                    <option value=""><?php _e('Semua Lokasi / Kota', 'hakajobs'); ?></option>
                                    <?php
                                    $locs = get_terms(array('taxonomy' => 'lokasi_lowongan', 'hide_empty' => false));
                                    if (!empty($locs) && !is_wp_error($locs)) {
                                        foreach ($locs as $loc) {
                                            echo '<option value="' . esc_attr($loc->slug) . '">' . esc_html($loc->name) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <button type="submit" class="hk-search-submit-btn">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <span><?php echo esc_html($hero_search_btn); ?></span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Popular Quick Filters -->
                <div class="hk-quick-filters">
                    <span class="hk-quick-label"><?php _e('Pencarian Populer:', 'hakajobs'); ?></span>
                    <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>?tipe=remote" class="hk-chip">🌐 Remote / WFH</a>
                    <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>?pengalaman=fresh-graduate" class="hk-chip">🎓 Fresh Graduate</a>
                    <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>?tipe=magang" class="hk-chip">💼 Magang (Intern)</a>
                    <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>?tipe=penuh-waktu" class="hk-chip">⏰ Penuh Waktu</a>
                </div>

                <?php if ($show_stats === '1'): ?>
                <!-- Hero Live Stats Strip (Aksen Pasang Loker) -->
                <div class="hk-hero-stats">
                    <div class="hk-stat-item">
                        <span class="hk-stat-num"><?php echo esc_html($stat1_num); ?></span>
                        <span class="hk-stat-label"><?php echo esc_html($stat1_label); ?></span>
                    </div>
                    <div class="hk-stat-sep"></div>
                    <div class="hk-stat-item">
                        <span class="hk-stat-num"><?php echo esc_html($stat2_num); ?></span>
                        <span class="hk-stat-label"><?php echo esc_html($stat2_label); ?></span>
                    </div>
                    <div class="hk-stat-sep"></div>
                    <div class="hk-stat-item">
                        <span class="hk-stat-num"><?php echo esc_html($stat3_num); ?></span>
                        <span class="hk-stat-label"><?php echo esc_html($stat3_label); ?></span>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>

        <?php if ($show_wave === '1' && $hero_style === 'pasang-loker'): ?>
        <!-- Hero Wave Bottom Transition (Identik Pasang Loker) -->
        <div class="hk-hero-wave" aria-hidden="true">
            <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 60L60 50C120 40 240 20 360 16.7C480 13.3 600 26.7 720 33.3C840 40 960 40 1080 33.3C1200 26.7 1320 13.3 1380 6.7L1440 0V60H1380C1320 60 1200 60 1080 60C960 60 840 60 720 60C600 60 480 60 360 60C240 60 120 60 60 60H0Z" fill="var(--hk-bg-body, #f8fafc)" />
            </svg>
        </div>
        <?php endif; ?>
    </section>

    <!-- Urgently Needed / Featured Jobs Section -->
    <?php
    $featured_query = new WP_Query(array(
        'post_type'      => 'lowongan',
        'posts_per_page' => 4,
        'meta_query'     => array(
            'relation' => 'OR',
            array(
                'key'     => '_hakajobs_is_urgent',
                'value'   => '1',
                'compare' => '=',
            ),
            array(
                'key'     => '_hakajobs_is_featured',
                'value'   => '1',
                'compare' => '=',
            ),
        ),
    ));

    if ($featured_query->have_posts()):
    ?>
    <section class="hk-spotlight-section">
        <div class="hk-container">
            <?php
            $featured_title = get_theme_mod('hakajobs_featured_section_title', __('🔥 Lamar Sekarang! Lowongan Prioritas & Dibutuhkan Segera', 'hakajobs'));
            $featured_sub   = get_theme_mod('hakajobs_featured_section_subtitle', __('Peluang karir terbaik dengan respon rekrutmen tercepat. Kirim lamaranmu sebelum kuota penuh!', 'hakajobs'));
            $featured_link  = get_theme_mod('hakajobs_featured_section_link_text', __('Lihat Semua', 'hakajobs'));
            ?>
            <div class="hk-section-header">
                <div>
                    <span class="hk-section-badge"><?php _e('🔥 Lowongan Prioritas', 'hakajobs'); ?></span>
                    <h2 class="hk-section-title"><?php echo esc_html($featured_title); ?></h2>
                    <?php if (!empty($featured_sub)): ?>
                        <p class="hk-section-subtitle"><?php echo esc_html($featured_sub); ?></p>
                    <?php endif; ?>
                </div>
                <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" class="hk-link-arrow">
                    <?php echo esc_html($featured_link); ?> &rarr;
                </a>
            </div>

            <div class="hk-jobs-grid">
                <?php
                while ($featured_query->have_posts()) {
                    $featured_query->the_post();
                    hakajobs_render_job_card(get_the_ID());
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Header Ad Slot -->
    <?php if (function_exists('hakajobs_render_ad_slot')) { hakajobs_render_ad_slot('header'); } ?>

    <!-- Main Jobs & Sidebar Section -->
    <section class="hk-content-section">
        <div class="hk-container">
            <div class="hk-layout-with-sidebar">

                <!-- Left Column: Latest Jobs Feed -->
                <div class="hk-main-feed">
                    <div class="hk-section-header hk-feed-header">
                        <div>
                            <h2 class="hk-section-title"><?php _e('Lowongan Kerja Terbaru', 'hakajobs'); ?></h2>
                            <p class="hk-section-subtitle"><?php _e('Diperbarui secara berkala setiap hari.', 'hakajobs'); ?></p>
                        </div>
                        <div class="hk-feed-view-all">
                            <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" class="hk-btn hk-btn-subtle">
                                <?php _e('Buka Direktori Lengkap', 'hakajobs'); ?> &rarr;
                            </a>
                        </div>
                    </div>

                    <?php
                    $latest_query = new WP_Query(array(
                        'post_type'      => 'lowongan',
                        'posts_per_page' => 8,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    ));

                    if ($latest_query->have_posts()):
                    ?>
                        <div class="hk-jobs-list">
                            <?php
                            while ($latest_query->have_posts()) {
                                $latest_query->the_post();
                                hakajobs_render_job_card(get_the_ID());
                            }
                            wp_reset_postdata();
                            ?>
                        </div>

                        <div class="hk-load-more-wrap">
                            <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" class="hk-btn hk-btn-primary hk-btn-large">
                                <?php _e('Jelajahi Semua Lowongan Kerja Lainnya', 'hakajobs'); ?> &rarr;
                            </a>
                        </div>

                    <?php else: ?>
                        <!-- Friendly Empty State -->
                        <div class="hk-empty-state">
                            <div class="hk-empty-icon">💼</div>
                            <h3><?php _e('Belum Ada Lowongan Kerja yang Dipublikasikan', 'hakajobs'); ?></h3>
                            <p><?php _e('Anda dapat menambahkan lowongan kerja baru melalui dashboard WordPress atau menggunakan fitur 1-Klik Pasang Data Demo.', 'hakajobs'); ?></p>
                            <?php if (current_user_can('manage_options')): ?>
                                <a href="<?php echo esc_url(admin_url('edit.php?post_type=lowongan&page=hakajobs-demo-data')); ?>" class="hk-btn hk-btn-primary">
                                    🚀 <?php _e('Pasang Data Demo Lowongan Sekarang', 'hakajobs'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Right Column: Sidebar -->
                <aside class="hk-sidebar" aria-label="<?php esc_attr_e('Sidebar Beranda', 'hakajobs'); ?>">
                    
                    <!-- Post a Job Callout for Recruiters -->
                    <div class="hk-widget-card hk-card-post-job">
                        <div class="hk-post-job-badge"><?php _e('Untuk Perusahaan / Rekruter', 'hakajobs'); ?></div>
                        <h3 class="hk-widget-title"><?php _e('Punya Lowongan Kerja?', 'hakajobs'); ?></h3>
                        <p class="hk-widget-text">
                            <?php _e('Pasang info lowongan kerja Anda di Hakajobs dan dapatkan pelamar berkualitas langsung ke WhatsApp atau Email perusahaan Anda.', 'hakajobs'); ?>
                        </p>
                        <a href="<?php echo esc_url(home_url('/pasang-loker/')); ?>" class="hk-btn hk-btn-accent hk-btn-block">
                            <?php _e('Pasang Iklan Loker', 'hakajobs'); ?> &rarr;
                        </a>
                    </div>

                    <!-- Sidebar Ad Slot -->
                    <?php if (function_exists('hakajobs_render_ad_slot')) { hakajobs_render_ad_slot('sidebar'); } ?>

                    <!-- Popular Job Categories -->
                    <div class="hk-widget-card">
                        <h3 class="hk-widget-title"><?php _e('Kategori Populer', 'hakajobs'); ?></h3>
                        <ul class="hk-widget-list">
                            <?php
                            $side_cats = get_terms(array(
                                'taxonomy'   => 'kategori_lowongan',
                                'number'     => 6,
                                'hide_empty' => false,
                            ));
                            if (!empty($side_cats) && !is_wp_error($side_cats)) {
                                foreach ($side_cats as $sc) {
                                    echo '<li>';
                                    echo '<a href="' . esc_url(get_term_link($sc)) . '" class="hk-widget-link">';
                                    echo '<span>' . esc_html($sc->name) . '</span>';
                                    echo '<span class="hk-badge-count">' . $sc->count . '</span>';
                                    echo '</a>';
                                    echo '</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>

                    <!-- Popular Locations -->
                    <div class="hk-widget-card">
                        <h3 class="hk-widget-title"><?php _e('Lokasi Kerja Teratas', 'hakajobs'); ?></h3>
                        <div class="hk-pills-cloud">
                            <?php
                            $side_locs = get_terms(array(
                                'taxonomy'   => 'lokasi_lowongan',
                                'number'     => 8,
                                'hide_empty' => false,
                            ));
                            if (!empty($side_locs) && !is_wp_error($side_locs)) {
                                foreach ($side_locs as $sl) {
                                    echo '<a href="' . esc_url(get_term_link($sl)) . '" class="hk-cloud-pill">';
                                    echo esc_html($sl->name);
                                    echo '</a>';
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Job Seeker Tips -->
                    <div class="hk-widget-card hk-tips-card">
                        <h3 class="hk-widget-title">💡 <?php _e('Tips Melamar Efektif', 'hakajobs'); ?></h3>
                        <ul class="hk-tips-list">
                            <li><?php _e('Sesuaikan CV Anda dengan kata kunci yang diminta pada kualifikasi lowongan.', 'hakajobs'); ?></li>
                            <li><?php _e('Gunakan format PDF dengan nama file yang jelas (contoh: CV_NamaLengkap_Posisi.pdf).', 'hakajobs'); ?></li>
                            <li><?php _e('Saat melamar via WhatsApp, gunakan bahasa yang santun dan perkenalkan diri secara ringkas.', 'hakajobs'); ?></li>
                        </ul>
                    </div>

                </aside>

            </div>
        </div>
    </section>

    <?php
    $show_how = get_theme_mod('hakajobs_show_how_it_works', '1');
    if ($show_how === '1'):
        $site_name    = get_bloginfo('name');
        $custom_title = get_theme_mod('hakajobs_how_it_works_title', '');
        $how_title    = !empty($custom_title) ? $custom_title : sprintf(__('Cara Melamar Kerja di %s', 'hakajobs'), $site_name);
        $how_subtitle = get_theme_mod('hakajobs_how_it_works_subtitle', __('Tanpa perlu daftar akun, verifikasi email yang panjang, atau mengingat password.', 'hakajobs'));
        $step1_title  = get_theme_mod('hakajobs_step1_title', __('Cari & Pilih Lowongan', 'hakajobs'));
        $step1_desc   = get_theme_mod('hakajobs_step1_desc', __('Gunakan filter lokasi, tipe kerja, atau bidang industri untuk menemukan posisi yang sesuai dengan keahlian Anda.', 'hakajobs'));
        $step2_title  = get_theme_mod('hakajobs_step2_title', __('Siapkan Dokumen', 'hakajobs'));
        $step2_desc   = get_theme_mod('hakajobs_step2_desc', __('Pastikan berkas resume/CV dan tautan portofolio terbaru Anda sudah siap dikirimkan kepada tim rekruter.', 'hakajobs'));
        $step3_title  = get_theme_mod('hakajobs_step3_title', __('Kirim Lamaran Langsung', 'hakajobs'));
        $step3_desc   = get_theme_mod('hakajobs_step3_desc', __('Klik tombol Lamar untuk terhubung langsung ke WhatsApp HRD, kirim email, atau isi formulir karir resmi perusahaan.', 'hakajobs'));
    ?>
    <!-- How It Works (Tanpa Login) -->
    <section class="hk-how-section">
        <div class="hk-container">
            <div class="hk-section-center-head">
                <span class="hk-section-badge"><?php _e('Panduan Loker', 'hakajobs'); ?></span>
                <h2 class="hk-section-title"><?php echo esc_html($how_title); ?></h2>
                <?php if (!empty($how_subtitle)): ?>
                    <p class="hk-section-subtitle"><?php echo esc_html($how_subtitle); ?></p>
                <?php endif; ?>
            </div>

            <div class="hk-steps-grid">
                <div class="hk-step-card">
                    <div class="hk-step-number">1</div>
                    <h3 class="hk-step-title"><?php echo esc_html($step1_title); ?></h3>
                    <p class="hk-step-desc"><?php echo esc_html($step1_desc); ?></p>
                </div>

                <div class="hk-step-card">
                    <div class="hk-step-number">2</div>
                    <h3 class="hk-step-title"><?php echo esc_html($step2_title); ?></h3>
                    <p class="hk-step-desc"><?php echo esc_html($step2_desc); ?></p>
                </div>

                <div class="hk-step-card">
                    <div class="hk-step-number">3</div>
                    <h3 class="hk-step-title"><?php echo esc_html($step3_title); ?></h3>
                    <p class="hk-step-desc"><?php echo esc_html($step3_desc); ?></p>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php
get_footer();
