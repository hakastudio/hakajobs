<?php
/**
 * Template Name: Pusat Tes & Karir
 * Template Post Type: page
 *
 * Halaman pusat pembelajaran, kisi-kisi tes, dan persiapan karir pelamar kerja.
 * Menyediakan latihan soal SKD CPNS, AKHLAK BUMN, psikotes kerja,
 * panduan resume ATS, serta tips wawancara kerja.
 *
 * Dapat diedit dan disetting sepenuhnya melalui WP Dashboard:
 * 1. WP Admin > Tampilan > Sesuaikan > Penyesuaian Tema Hakajobs > Halaman Pusat Tes & Karir
 * 2. WP Admin > Laman > Edit Laman "Pusat Tes & Karir" (Editor Konten WP)
 *
 * @package Hakajobs
 */

get_header();

// =========================================================================
// PENGATURAN KONTEN DARI CUSTOMIZER (SECTION 14)
// =========================================================================
$tk_hero_badge       = get_theme_mod('hakajobs_tk_hero_badge', __('Pusat Persiapan Karir & Latihan Tes Kerja', 'hakajobs'));
$tk_hero_title       = get_theme_mod('hakajobs_tk_hero_title', __('Pusat Persiapan Karir &', 'hakajobs'));
$tk_hero_highlight   = get_theme_mod('hakajobs_tk_hero_highlight', __('Latihan Tes Kerja', 'hakajobs'));
$tk_hero_desc        = get_theme_mod('hakajobs_tk_hero_desc', __('Tingkatkan peluang lolos seleksi kerja Anda. Pelajari kisi-kisi resmi soal CPNS, BUMN, psikotes kerja perusahaan swasta, hingga panduan resume ATS & teknik wawancara.', 'hakajobs'));
$tk_search_ph        = get_theme_mod('hakajobs_tk_search_placeholder', __('Cari soal atau materi (contoh: TWK, AKHLAK, Psikotes, CV ATS)...', 'hakajobs'));
$tk_search_btn       = get_theme_mod('hakajobs_tk_search_btn_text', __('Cari Materi', 'hakajobs'));
$tk_quick_tags_str   = get_theme_mod('hakajobs_tk_quick_tags', 'SKD CPNS, AKHLAK BUMN, Kraepelin, CV ATS, K3 Umum');
$tk_quick_tags       = array_filter(array_map('trim', explode(',', $tk_quick_tags_str)));

$tk_show_page_content= get_theme_mod('hakajobs_tk_show_page_content', '1');

// Modul Utama
$tk_show_modules     = get_theme_mod('hakajobs_tk_show_modules', '1');
$tk_modules_title    = get_theme_mod('hakajobs_tk_modules_title', __('Kategori Modul Utama', 'hakajobs'));
$tk_modules_sub      = get_theme_mod('hakajobs_tk_modules_subtitle', __('Pilih kategori persiapan sesuai kebutuhan tahapan seleksi kerja Anda', 'hakajobs'));

$tk_mod1_title       = get_theme_mod('hakajobs_tk_mod1_title', __('Soal SKD CPNS & BUMN', 'hakajobs'));
$tk_mod1_desc        = get_theme_mod('hakajobs_tk_mod1_desc', __('Materi latihan resmi standar BKN & BUMN meliputi TWK, TIU, TKP, serta Core Values AKHLAK BUMN.', 'hakajobs'));
$tk_mod1_btn         = get_theme_mod('hakajobs_tk_mod1_btn', __('Buka Modul CPNS/BUMN', 'hakajobs'));

$tk_mod2_title       = get_theme_mod('hakajobs_tk_mod2_title', __('Psikotes & Ujian Swasta', 'hakajobs'));
$tk_mod2_desc        = get_theme_mod('hakajobs_tk_mod2_desc', __('Kisi-kisi tes psikologi kerja perusahaan swasta dan BUMN untuk mengukur ketahanan kerja & intelegensi.', 'hakajobs'));
$tk_mod2_btn         = get_theme_mod('hakajobs_tk_mod2_btn', __('Buka Modul Psikotes', 'hakajobs'));

$tk_mod3_title       = get_theme_mod('hakajobs_tk_mod3_title', __('Persiapan Berkas & CV ATS', 'hakajobs'));
$tk_mod3_desc        = get_theme_mod('hakajobs_tk_mod3_desc', __('Panduan penyusunan resume standar Applicant Tracking System (ATS) agar lolos seleksi berkas HRD.', 'hakajobs'));
$tk_mod3_btn         = get_theme_mod('hakajobs_tk_mod3_btn', __('Buka Panduan CV', 'hakajobs'));

$tk_mod4_title       = get_theme_mod('hakajobs_tk_mod4_title', __('Interview & Sertifikasi', 'hakajobs'));
$tk_mod4_desc        = get_theme_mod('hakajobs_tk_mod4_desc', __('Trik menjawab pertanyaan wawancara HRD & User serta info sertifikasi penunjang karir bergaji tinggi.', 'hakajobs'));
$tk_mod4_btn         = get_theme_mod('hakajobs_tk_mod4_btn', __('Buka Modul Interview', 'hakajobs'));

// Kuis Simulator
$tk_show_quiz        = get_theme_mod('hakajobs_tk_show_quiz', '1');
$tk_quiz_badge       = get_theme_mod('hakajobs_tk_quiz_badge', __('Simulasi Interaktif', 'hakajobs'));
$tk_quiz_title       = get_theme_mod('hakajobs_tk_quiz_title', __('Uji Pemahaman: Simulasi Soal Tes Kerja', 'hakajobs'));
$tk_quiz_sub         = get_theme_mod('hakajobs_tk_quiz_subtitle', __('Pilih jawaban Anda di bawah untuk melihat kunci jawaban dan pembahasan lengkap secara instan.', 'hakajobs'));

// Bank Soal & Artikel
$tk_articles_title   = get_theme_mod('hakajobs_tk_articles_title', __('Bank Soal & Panduan Karir Lengkap', 'hakajobs'));
$tk_articles_sub     = get_theme_mod('hakajobs_tk_articles_subtitle', __('Materi edukasi mendalam yang disusun untuk mempermudah persiapan tes Anda.', 'hakajobs'));

// Sidebar E-Book & Sertifikasi
$tk_show_ebook       = get_theme_mod('hakajobs_tk_show_ebook', '1');
$tk_ebook_badge      = get_theme_mod('hakajobs_tk_ebook_badge', __('Gratis Modul PDF', 'hakajobs'));
$tk_ebook_title      = get_theme_mod('hakajobs_tk_ebook_title', __('E-Book Kit Persiapan Kerja 2026', 'hakajobs'));
$tk_ebook_desc       = get_theme_mod('hakajobs_tk_ebook_desc', __('Dapatkan kumpulan ringkasan rumus matematika cepat TIU, kisi-kisi psikotes, panduan wawancara kerja, dan template CV ATS Word siap pakai.', 'hakajobs'));
$tk_ebook_btn        = get_theme_mod('hakajobs_tk_ebook_btn', __('Unduh E-Book Lengkap (PDF)', 'hakajobs'));
$tk_ebook_url        = get_theme_mod('hakajobs_tk_ebook_url', '');
if (empty($tk_ebook_url)) {
    $tk_ebook_url = get_template_directory_uri() . '/assets/downloads/E-Book-Kit-Persiapan-Kerja-2026.pdf';
}
$tk_cert_title       = get_theme_mod('hakajobs_tk_cert_title', __('Info Pelatihan & Sertifikasi', 'hakajobs'));

// Profil Penulis & Kurator
$tk_author_name      = get_theme_mod('hakajobs_tk_author_name', __('Tim Litbang Karir & Edukasi', 'hakajobs'));
$tk_author_bio       = get_theme_mod('hakajobs_tk_author_bio', __('Materi pembelajaran resmi dan kisi-kisi soal yang dikurasi oleh praktisi rekrutmen profesional untuk mempermudah persiapan tes karir pencari kerja di Indonesia.', 'hakajobs'));
$tk_author_avatar    = get_theme_mod('hakajobs_tk_author_avatar', '');
if (empty($tk_author_avatar)) {
    $tk_author_avatar = 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&auto=format&fit=crop&q=80';
}

// Enqueue styles jika belum terpanggil oleh wp_enqueue_scripts
if (!wp_style_is('hakajobs-tes-karir', 'enqueued')) {
    $min = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
    $tk_css = file_exists(HAKAJOBS_DIR . '/assets/css/tes-karir' . $min . '.css') ? '/assets/css/tes-karir' . $min . '.css' : '/assets/css/tes-karir.css';
    wp_enqueue_style('hakajobs-tes-karir', HAKAJOBS_URI . $tk_css, array('hakajobs-main-style'), HAKAJOBS_VERSION);
}
?>

<!-- Hero Banner Section -->
<section class="hk-tk-hero">
    <div class="hk-container">
        <div class="hk-tk-hero-content">
            <?php if (!empty($tk_hero_badge)): ?>
            <span class="hk-tk-hero-badge">
                <?php echo esc_html($tk_hero_badge); ?>
            </span>
            <?php endif; ?>
            <h1 class="hk-tk-hero-title">
                <?php echo esc_html($tk_hero_title); ?> <span class="hk-hero-highlight"><?php echo esc_html($tk_hero_highlight); ?></span>
            </h1>
            <?php if (!empty($tk_hero_desc)): ?>
            <p class="hk-tk-hero-desc">
                <?php echo esc_html($tk_hero_desc); ?>
            </p>
            <?php endif; ?>

            <!-- Search Form -->
            <div class="hk-tk-search-box">
                <div class="hk-tk-search-field">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" id="hkTkSearchInput" placeholder="<?php echo esc_attr($tk_search_ph); ?>" aria-label="<?php esc_attr_e('Cari materi karir', 'hakajobs'); ?>">
                </div>
                <button type="button" id="hkTkSearchBtn" class="hk-tk-search-btn">
                    <span><?php echo esc_html($tk_search_btn); ?></span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            </div>

            <!-- Quick Search Tags -->
            <?php if (!empty($tk_quick_tags)): ?>
            <div class="hk-tk-quick-tags">
                <span class="hk-tk-quick-label"><?php _e('Pencarian Populer:', 'hakajobs'); ?></span>
                <?php foreach ($tk_quick_tags as $tag_item): ?>
                <button type="button" class="hk-tk-tag-chip" data-query="<?php echo esc_attr($tag_item); ?>"><?php echo esc_html($tag_item); ?></button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Breadcrumbs Bar -->
<?php hakajobs_breadcrumbs(); ?>

<!-- Main Page Content -->
<div id="hk-career-hub-view">
<main id="hk-main" class="hk-tk-page-body">
    <div class="hk-container">

        <!-- WordPress Page Editor Content (Jika ada isi dari WP Admin > Laman > Edit) -->
        <?php if ($tk_show_page_content === '1' && have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <?php 
                $page_content = get_the_content();
                if (!empty(trim($page_content))): ?>
                    <div class="hk-tk-custom-editor-content" style="background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; padding:24px 28px; margin-bottom:32px; box-shadow:0 1px 3px rgba(0,0,0,0.04);">
                        <div class="hk-typography" style="line-height:1.75; color:#334155;">
                            <?php the_content(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>

        <?php if ($tk_show_modules === '1'): ?>
        <!-- 1. Grid 4 Modul Utama -->
        <div class="hk-tk-section-header">
            <h2 class="hk-tk-section-title"><?php echo esc_html($tk_modules_title); ?></h2>
            <p class="hk-tk-section-subtitle"><?php echo esc_html($tk_modules_sub); ?></p>
        </div>

        <div class="hk-tk-modules-grid">
            
            <!-- Modul 1: SKD CPNS & BUMN -->
            <div class="hk-tk-module-card">
                <div>
                    <div class="hk-tk-icon-wrap hk-tk-icon-blue">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M3 10h18M5 10v11M9 10v11M15 10v11M19 10v11M12 2l10 5H2l10-5z"></path></svg>
                    </div>
                    <h3 class="hk-tk-module-title"><?php echo esc_html($tk_mod1_title); ?></h3>
                    <p class="hk-tk-module-desc"><?php echo esc_html($tk_mod1_desc); ?></p>
                    <ul class="hk-tk-topic-list">
                        <li class="hk-tk-topic-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Tes Wawasan Kebangsaan (TWK)</li>
                        <li class="hk-tk-topic-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Tes Inteligensi Umum (TIU)</li>
                        <li class="hk-tk-topic-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Tes Karakteristik Pribadi (TKP)</li>
                        <li class="hk-tk-topic-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Core Values AKHLAK BUMN</li>
                    </ul>
                </div>
                <button type="button" class="hk-tk-module-btn" onclick="openCareerArticle('skd')">
                    <?php echo esc_html($tk_mod1_btn); ?> &rarr;
                </button>
            </div>

            <!-- Modul 2: Psikotes & Ujian Swasta -->
            <div class="hk-tk-module-card">
                <div>
                    <div class="hk-tk-icon-wrap hk-tk-icon-indigo">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a9 9 0 0 1 9 9c0 3.6-2.1 6.7-5.2 8.2-.5.3-.8.8-.8 1.4V21a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-.4c0-.6-.3-1.1-.8-1.4C6.1 17.7 4 14.6 4 11a9 9 0 0 1 9-9z"></path><path d="M9 22h6"></path></svg>
                    </div>
                    <h3 class="hk-tk-module-title"><?php echo esc_html($tk_mod2_title); ?></h3>
                    <p class="hk-tk-module-desc"><?php echo esc_html($tk_mod2_desc); ?></p>
                    <ul class="hk-tk-topic-list">
                        <li class="hk-tk-topic-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Tes Kraepelin & Pauli (Koran)</li>
                        <li class="hk-tk-topic-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Tes Gambar Wartegg & Pohon</li>
                        <li class="hk-tk-topic-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Logika Penalaran & Figural</li>
                        <li class="hk-tk-topic-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Kemampuan Verbal & Deret Angka</li>
                    </ul>
                </div>
                <button type="button" class="hk-tk-module-btn" onclick="openCareerArticle('psikotes')">
                    <?php echo esc_html($tk_mod2_btn); ?> &rarr;
                </button>
            </div>

            <!-- Modul 3: Persiapan Berkas & CV -->
            <div class="hk-tk-module-card">
                <div>
                    <div class="hk-tk-icon-wrap hk-tk-icon-emerald">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    </div>
                    <h3 class="hk-tk-module-title"><?php echo esc_html($tk_mod3_title); ?></h3>
                    <p class="hk-tk-module-desc"><?php echo esc_html($tk_mod3_desc); ?></p>
                    <ul class="hk-tk-topic-list">
                        <li class="hk-tk-topic-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Template CV ATS Word & PDF</li>
                        <li class="hk-tk-topic-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Surat Lamaran Kerja (Cover Letter)</li>
                        <li class="hk-tk-topic-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Portofolio Hasil Karya Kerja</li>
                        <li class="hk-tk-topic-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Etika Kirim Lamaran Email/WA</li>
                    </ul>
                </div>
                <button type="button" class="hk-tk-module-btn" onclick="openCareerArticle('cv')">
                    <?php echo esc_html($tk_mod3_btn); ?> &rarr;
                </button>
            </div>

            <!-- Modul 4: Interview & Sertifikasi -->
            <div class="hk-tk-module-card">
                <div>
                    <div class="hk-tk-icon-wrap hk-tk-icon-amber">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <h3 class="hk-tk-module-title"><?php echo esc_html($tk_mod4_title); ?></h3>
                    <p class="hk-tk-module-desc"><?php echo esc_html($tk_mod4_desc); ?></p>
                    <ul class="hk-tk-topic-list">
                        <li class="hk-tk-topic-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> 20 Pertanyaan HRD & Jawaban STAR</li>
                        <li class="hk-tk-topic-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Teknik Negosiasi Gaji & Benefit</li>
                        <li class="hk-tk-topic-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Info Sertifikasi K3 & BNSP</li>
                        <li class="hk-tk-topic-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> Persiapan Tes TOEFL / English Test</li>
                    </ul>
                </div>
                <button type="button" class="hk-tk-module-btn" onclick="openCareerArticle('interview')">
                    <?php echo esc_html($tk_mod4_btn); ?> &rarr;
                </button>
            </div>

        </div>
        <?php endif; ?>

        <?php if ($tk_show_quiz === '1'): ?>
        <!-- 2. Interactive Quiz Simulator Card -->
        <div class="hk-tk-quiz-card" id="hk-quiz-simulator">
            <div class="hk-tk-quiz-top">
                <div>
                    <?php if (!empty($tk_quiz_badge)): ?>
                    <span class="hk-tk-quiz-badge"><?php echo esc_html($tk_quiz_badge); ?></span>
                    <?php endif; ?>
                    <h2 class="hk-tk-quiz-heading"><?php echo esc_html($tk_quiz_title); ?></h2>
                    <p class="hk-tk-quiz-sub"><?php echo esc_html($tk_quiz_sub); ?></p>
                </div>
                <div class="hk-tk-quiz-tabs" id="hkQuizTabs">
                    <button type="button" class="hk-tk-tab-btn is-active" data-cat="twk">TWK CPNS</button>
                    <button type="button" class="hk-tk-tab-btn" data-cat="tiu">TIU Analogi</button>
                    <button type="button" class="hk-tk-tab-btn" data-cat="akhlak">AKHLAK BUMN</button>
                    <button type="button" class="hk-tk-tab-btn" data-cat="psikotes">Psikotes Logika</button>
                </div>
            </div>

            <div id="hkQuizContainer" class="hk-tk-quiz-body">
                <!-- Injected via JavaScript -->
            </div>
        </div>
        <?php endif; ?>

        <!-- 3. Artikel Karir & Modul Lengkap Section -->
        <div class="hk-tk-main-grid">
            
            <!-- Left Column: Articles List -->
            <div>
                <div class="hk-section-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                    <div>
                        <h2 class="hk-section-title" style="font-size:20px; margin:0;">
                            <?php echo esc_html($tk_articles_title); ?>
                        </h2>
                        <p class="hk-section-subtitle" style="font-size:13px; margin:2px 0 0;">
                            <?php echo esc_html($tk_articles_sub); ?>
                        </p>
                    </div>
                </div>

                <div class="hk-tk-articles-list">
                    
                    <?php
                    // Query artikel tips & karir dari Pos WordPress jika ada
                    $career_wp_query = new WP_Query(array(
                        'post_type'      => 'post',
                        'posts_per_page' => 6,
                        'post_status'    => 'publish',
                        'category_name'  => 'tips-karir,tes-karir,cpns,bumn,psikotes,karir,tips-melamar,interview,sertifikasi,cv',
                    ));

                    if ($career_wp_query->have_posts()):
                        while ($career_wp_query->have_posts()): $career_wp_query->the_post();
                    ?>
                        <article class="hk-tk-article-card">
                            <div class="hk-tk-article-thumb-wrap">
                                <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('medium', array('class' => 'hk-tk-article-thumb')); ?>
                                <?php else: ?>
                                    <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=500&auto=format&fit=crop&q=80" alt="<?php the_title_attribute(); ?>" class="hk-tk-article-thumb">
                                <?php endif; ?>
                                <span class="hk-tk-article-category-badge">
                                    <?php 
                                    $cats = get_the_category();
                                    echo !empty($cats) ? esc_html($cats[0]->name) : __('Tips Karir', 'hakajobs');
                                    ?>
                                </span>
                            </div>
                            <div class="hk-tk-article-info">
                                <div>
                                    <div class="hk-tk-article-meta-row">
                                        <span><?php echo get_the_date('d M Y'); ?></span>
                                        <span>•</span>
                                        <span>Oleh <?php the_author(); ?></span>
                                    </div>
                                    <h3 class="hk-tk-article-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                    <p class="hk-tk-article-excerpt">
                                        <?php echo wp_trim_words(get_the_excerpt(), 22, '...'); ?>
                                    </p>
                                </div>
                                <div class="hk-tk-article-footer">
                                    <span class="hk-tk-read-count">Artikel Edukasi</span>
                                    <a href="<?php the_permalink(); ?>" class="hk-tk-read-link">
                                        <?php _e('Baca Selengkapnya', 'hakajobs'); ?> &rarr;
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                    
                    <!-- Article Card 1 -->
                    <article class="hk-tk-article-card">
                        <div class="hk-tk-article-thumb-wrap">
                            <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=500&auto=format&fit=crop&q=80" alt="Soal SKD CPNS" class="hk-tk-article-thumb">
                            <span class="hk-tk-article-category-badge">CPNS & BUMN</span>
                        </div>
                        <div class="hk-tk-article-info">
                            <div>
                                <div class="hk-tk-article-meta-row">
                                    <span>24 Okt 2026</span>
                                    <span>•</span>
                                    <span>6 Menit Baca</span>
                                </div>
                                <h3 class="hk-tk-article-title">
                                    <a href="javascript:void(0)" onclick="openCareerArticle('skd')">
                                        Latihan Soal SKD CPNS 2026: Materi TWK Integritas & Pengamalan Pancasila
                                    </a>
                                </h3>
                                <p class="hk-tk-article-excerpt">
                                    Kumpulan contoh soal TWK tipe HOTS (Higher Order Thinking Skills) sesuai kisi-kisi resmi BKN lengkap dengan kunci jawaban, teknik eliminasi opsi, dan pembahasan mendalam...
                                </p>
                            </div>
                            <div class="hk-tk-article-footer">
                                <span class="hk-tk-read-count">2.4k dibaca</span>
                                <a href="javascript:void(0)" onclick="openCareerArticle('skd')" class="hk-tk-read-link">
                                    Pelajari Soal &amp; Jawaban &rarr;
                                </a>
                            </div>
                        </div>
                    </article>

                    <!-- Article Card 2 -->
                    <article class="hk-tk-article-card">
                        <div class="hk-tk-article-thumb-wrap">
                            <img src="https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=500&auto=format&fit=crop&q=80" alt="Panduan CV ATS" class="hk-tk-article-thumb">
                            <span class="hk-tk-article-category-badge" style="background:#10b981;">CV &amp; Berkas</span>
                        </div>
                        <div class="hk-tk-article-info">
                            <div>
                                <div class="hk-tk-article-meta-row">
                                    <span>22 Okt 2026</span>
                                    <span>•</span>
                                    <span>8 Menit Baca</span>
                                </div>
                                <h3 class="hk-tk-article-title">
                                    <a href="javascript:void(0)" onclick="openCareerArticle('cv')">
                                        Panduan Lengkap Membuat CV ATS Friendly Bahasa Indonesia (+ Free Template Word &amp; PDF)
                                    </a>
                                </h3>
                                <p class="hk-tk-article-excerpt">
                                    Pelajari struktur resume standar sistem pelacak pelamar kerja ATS (Applicant Tracking System), urutan kronologis pengalaman, kata kunci relevan, dan tips lolos screening awal HRD...
                                </p>
                            </div>
                            <div class="hk-tk-article-footer">
                                <span class="hk-tk-read-count">4.1k dibaca</span>
                                <a href="javascript:void(0)" onclick="openCareerArticle('cv')" class="hk-tk-read-link">
                                    Baca &amp; Download Template &rarr;
                                </a>
                            </div>
                        </div>
                    </article>

                    <!-- Article Card 3 -->
                    <article class="hk-tk-article-card">
                        <div class="hk-tk-article-thumb-wrap">
                            <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=500&auto=format&fit=crop&q=80" alt="Tes Koran Kraepelin" class="hk-tk-article-thumb">
                            <span class="hk-tk-article-category-badge" style="background:#6366f1;">Psikotes</span>
                        </div>
                        <div class="hk-tk-article-info">
                            <div>
                                <div class="hk-tk-article-meta-row">
                                    <span>19 Okt 2026</span>
                                    <span>•</span>
                                    <span>5 Menit Baca</span>
                                </div>
                                <h3 class="hk-tk-article-title">
                                    <a href="javascript:void(0)" onclick="openCareerArticle('psikotes')">
                                        Cara Mengerjakan Tes Koran (Kraepelin &amp; Pauli) Agar Grafik Stabil &amp; Skor Tinggi
                                    </a>
                                </h3>
                                <p class="hk-tk-article-excerpt">
                                    Rahasia menjaga konsentrasi, stabilitas ritme tangan, dan ketahanan mental tanpa mudah lelah saat menjumlahkan ratusan angka pada lembar tes koran psikotes...
                                </p>
                            </div>
                            <div class="hk-tk-article-footer">
                                <span class="hk-tk-read-count">3.2k dibaca</span>
                                <a href="javascript:void(0)" onclick="openCareerArticle('psikotes')" class="hk-tk-read-link">
                                    Pelajari Trik Psikotes &rarr;
                                </a>
                            </div>
                        </div>
                    </article>

                    <!-- Article Card 4 -->
                    <article class="hk-tk-article-card">
                        <div class="hk-tk-article-thumb-wrap">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=500&auto=format&fit=crop&q=80" alt="Wawancara Kerja HRD" class="hk-tk-article-thumb">
                            <span class="hk-tk-article-category-badge" style="background:#f59e0b;">Wawancara</span>
                        </div>
                        <div class="hk-tk-article-info">
                            <div>
                                <div class="hk-tk-article-meta-row">
                                    <span>15 Okt 2026</span>
                                    <span>•</span>
                                    <span>7 Menit Baca</span>
                                </div>
                                <h3 class="hk-tk-article-title">
                                    <a href="javascript:void(0)" onclick="openCareerArticle('interview')">
                                        20 Pertanyaan Interview HRD Paling Sering Muncul &amp; Cara Menjawab dengan Metode STAR
                                    </a>
                                </h3>
                                <p class="hk-tk-article-excerpt">
                                    Panduan taktis menjawab pertanyaan seperti "Ceritakan tentang diri Anda", "Kelemahan terbesar Anda", dan cara elegan bernegosiasi gaji agar diterima dengan nilai terbaik...
                                </p>
                            </div>
                            <div class="hk-tk-article-footer">
                                <span class="hk-tk-read-count">5.0k dibaca</span>
                                <a href="javascript:void(0)" onclick="openCareerArticle('interview')" class="hk-tk-read-link">
                                    Pelajari Contoh Jawaban &rarr;
                                </a>
                            </div>
                        </div>
                    </article>

                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <aside class="hk-tk-sidebar">
                
                <?php if ($tk_show_ebook === '1'): ?>
                <!-- E-Book Download Card -->
                <div class="hk-tk-ebook-card">
                    <span class="hk-tk-ebook-badge"><?php echo esc_html($tk_ebook_badge); ?></span>
                    <h3 class="hk-tk-ebook-title"><?php echo esc_html($tk_ebook_title); ?></h3>
                    <p class="hk-tk-ebook-desc">
                        <?php echo esc_html($tk_ebook_desc); ?>
                    </p>
                    <a href="<?php echo esc_url($tk_ebook_url); ?>" download="E-Book-Kit-Persiapan-Kerja-InfoLoker-Lampung-2026.pdf" class="hk-tk-ebook-btn" style="text-decoration:none;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span><?php echo esc_html($tk_ebook_btn); ?></span>
                    </a>
                </div>
                <?php endif; ?>

                <!-- Info Sertifikasi Resmi -->
                <div class="hk-tk-links-card">
                    <h3 class="hk-tk-links-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                        <span><?php echo esc_html($tk_cert_title); ?></span>
                    </h3>
                    <ul class="hk-tk-fast-links-list">
                        <li class="hk-tk-fast-link-item">
                            <a href="javascript:void(0)" onclick="openCareerArticle('k3')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                <span>Panduan Sertifikasi Ahli K3 Umum Kemenaker untuk Fresh Graduate</span>
                            </a>
                        </li>
                        <li class="hk-tk-fast-link-item">
                            <a href="javascript:void(0)" onclick="openCareerArticle('toefl')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                <span>Perbedaan Skor TOEFL ITP, Prediction, dan IELTS untuk Syarat BUMN</span>
                            </a>
                        </li>
                        <li class="hk-tk-fast-link-item">
                            <a href="javascript:void(0)" onclick="openCareerArticle('bnsp')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                <span>Cara Memperoleh Sertifikat Profesi BNSP untuk Meningkatkan Nilai Gaji</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- CTA Back to Jobs -->
                <div class="hk-tk-cta-loker-card">
                    <h4 class="hk-tk-cta-loker-title"><?php _e('Sudah Siap Melamar Pekerjaan?', 'hakajobs'); ?></h4>
                    <p class="hk-tk-cta-loker-desc"><?php _e('Cek ribuan lowongan kerja perusahaan terbaru di Hakajobs yang aktif dan buka minggu ini.', 'hakajobs'); ?></p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" class="hk-btn hk-btn-primary hk-btn-block">
                        <?php _e('Jelajahi Lowongan Kerja Terbaru', 'hakajobs'); ?> &rarr;
                    </a>
                </div>

            </aside>

        </div>

    </div>
</main>
</div>

<!-- Dedicated Real Career Article Reader (Non-Modal) -->
<div id="hk-career-article-view" style="display:none;" class="hk-career-single-article">
    <div class="hk-container hk-career-article-container">
        <!-- Top Navigation & Breadcrumbs -->
        <div class="hk-article-top-nav">
            <button type="button" class="hk-btn-back-career" onclick="closeCareerArticle()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                <span><?php _e('Kembali ke Pusat Tes & Karir', 'hakajobs'); ?></span>
            </button>
            <nav class="hk-breadcrumbs" aria-label="Breadcrumb">
                <ol class="hk-breadcrumbs-list" style="margin:0; padding:0; list-style:none; display:flex; gap:6px; font-size:12.5px; color:var(--hk-text-muted); align-items:center;">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>" style="color:var(--hk-text-muted); text-decoration:none;"><?php _e('Beranda', 'hakajobs'); ?></a></li>
                    <li>/</li>
                    <li><a href="javascript:void(0)" onclick="closeCareerArticle()" style="color:var(--hk-text-muted); text-decoration:none;"><?php _e('Tes & Karir', 'hakajobs'); ?></a></li>
                    <li>/</li>
                    <li id="hkArticleBreadcrumbTitle" style="color:var(--hk-dark); font-weight:600; max-width:280px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Artikel</li>
                </ol>
            </nav>
        </div>

        <!-- Main Article Card -->
        <article class="hk-career-article-card">
            <header class="hk-career-header">
                <span class="hk-career-header-category" id="hkArticleCatBadge" style="background:#0284c7;">CPNS &amp; BUMN</span>
                <h1 class="hk-career-header-title" id="hkArticleMainTitle">Judul Artikel Karir</h1>
                <div class="hk-career-header-meta">
                    <span id="hkArticleDate">24 Okt 2026</span>
                    <span>•</span>
                    <span id="hkArticleReadTime">10 Menit Baca</span>
                    <span>•</span>
                    <span id="hkArticleAuthor"><?php printf(esc_html__('Oleh %s', 'hakajobs'), esc_html($tk_author_name)); ?></span>
                    <span>•</span>
                    <span>3.8k dibaca</span>
                </div>
            </header>

            <!-- Featured Image -->
            <img src="" alt="Banner Artikel" class="hk-career-featured-img" id="hkArticleBanner">

            <!-- Quick Table of Contents -->
            <div class="hk-career-toc" id="hkArticleToc">
                <h4 class="hk-career-toc-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                    <span>Daftar Isi Materi:</span>
                </h4>
                <ol class="hk-career-toc-list" id="hkArticleTocList">
                    <!-- Injected dynamically -->
                </ol>
            </div>

            <!-- Article Body Typography -->
            <div class="hk-typography" id="hkArticleFullContent">
                <!-- Full in-depth content & 10 questions injected dynamically -->
            </div>

            <!-- Share Bar -->
            <div class="hk-article-share-bar">
                <span style="font-size:13px; font-weight:700; color:var(--hk-dark);">Bagikan Panduan Ini:</span>
                <div class="hk-share-buttons">
                    <button type="button" class="hk-share-btn hk-share-wa" onclick="alert('Tautan panduan disalin untuk WhatsApp')">
                        WhatsApp
                    </button>
                    <button type="button" class="hk-share-btn hk-share-tg" onclick="alert('Tautan panduan disalin untuk Telegram')">
                        Telegram
                    </button>
                    <button type="button" class="hk-share-btn hk-share-li" onclick="alert('Tautan panduan disalin untuk LinkedIn')">
                        LinkedIn
                    </button>
                </div>
            </div>

            <!-- Author Box -->
            <div class="hk-article-author-box">
                <img src="<?php echo esc_url($tk_author_avatar); ?>" alt="<?php echo esc_attr($tk_author_name); ?>" class="hk-author-avatar" id="hkArticleAuthorAvatar">
                <div class="hk-author-info">
                    <h4 id="hkArticleAuthorBoxName"><?php echo esc_html($tk_author_name); ?></h4>
                    <p id="hkArticleAuthorBoxBio"><?php echo esc_html($tk_author_bio); ?></p>
                </div>
            </div>

            <!-- Bottom Nav Back -->
            <div style="margin-top:32px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                <button type="button" class="hk-btn-back-career" onclick="closeCareerArticle()">
                    &larr; <?php _e('Kembali ke Pusat Tes & Karir', 'hakajobs'); ?>
                </button>
                <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" class="hk-btn hk-btn-primary">
                    <?php _e('Cari Lowongan Kerja Terbaru', 'hakajobs'); ?> &rarr;
                </a>
            </div>

        </article>
    </div>
</div>

<!-- Embedded Interactive Logic & Articles Database -->
<script>
(function() {
    // 1. Database Artikel Nyata Lengkap
    var fullCareerArticles = {"skd":{"title":"Latihan Soal SKD CPNS 2026: Materi TWK Integritas & Pengamalan Pancasila (10 Soal Lengkap + Pembahasan)","category":"CPNS & BUMN","catClass":"hk-tk-icon-blue","badgeBg":"#0284c7","date":"24 Okt 2026","readTime":"12 Menit Baca","author":"Tim Litbang Karir Hakajobs","banner":"https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=1000&auto=format&fit=crop&q=80","toc":[{"id":"regulasi","label":"1. Regulasi Resmi & Passing Grade SKD CPNS 2026"},{"id":"karakteristik-hots","label":"2. Karakteristik Soal TWK Tipe HOTS (Penalaran)"},{"id":"manajemen-waktu","label":"3. Trik Manajemen Waktu 100 Menit untuk 110 Soal"},{"id":"bank-soal-10","label":"4. Bank Soal Latihan Mandiri (10 Soal + Pembahasan Lengkap)"},{"id":"kesimpulan","label":"5. Kesimpulan & Rekomendasi Belajar Harian"}],"body":"\n            <div class=\"hk-callout-box\">\n                <strong>📌 Ringkasan Eksekutif:</strong> Artikel ini memuat panduan komprehensif menghadapi Seleksi Kompetensi Dasar (SKD) CPNS 2026 berdasarkan pedoman Badan Kepegawaian Negara (BKN) dan KemenPAN-RB. Dilengkapi analisis materi HOTS dan <strong>10 latihan soal lengkap dengan kunci serta pembahasan mendalam</strong> untuk menguji kesiapan Anda.\n            </div>\n\n            <h2 id=\"regulasi\">1. Regulasi Resmi &amp; Nilai Ambang Batas (Passing Grade) SKD CPNS 2026</h2>\n            <p>Seleksi Kompetensi Dasar (SKD) menggunakan sistem <em>Computer Assisted Test</em> (CAT) BKN dengan total <strong>110 butir soal</strong> yang wajib diselesaikan dalam tempo <strong>100 menit</strong> (130 menit untuk penyandang disabilitas sensori netra). Komposisi sub-tes meliputi:</p>\n            <ul>\n                <li><strong>Tes Wawasan Kebangsaan (TWK)</strong>: 30 butir soal. Bobot nilai jawaban benar = +5, salah/kosong = 0. Nilai Ambang Batas (Passing Grade) = <strong>65</strong> (skor maksimal 150).</li>\n                <li><strong>Tes Inteligensi Umum (TIU)</strong>: 35 butir soal. Bobot nilai jawaban benar = +5, salah/kosong = 0. Nilai Ambang Batas = <strong>80</strong> (skor maksimal 175).</li>\n                <li><strong>Tes Karakteristik Pribadi (TKP)</strong>: 45 butir soal. Sistem penilaian bertingkat skor 1 sampai 5 (tidak ada jawaban bernilai 0). Nilai Ambang Batas = <strong>166</strong> (skor maksimal 225).</li>\n            </ul>\n            <p><strong>Total Skor Maksimal SKD adalah 550 poin</strong>. Untuk lolos ke tahapan Seleksi Kompetensi Bidang (SKB), Anda wajib memenuhi ambang batas di ketiga sub-tes tersebut DAN masuk dalam kuota perankingan 3 kali formasi yang dibutuhkan.</p>\n\n            <h2 id=\"karakteristik-hots\">2. Karakteristik Soal TWK Tipe HOTS (Higher Order Thinking Skills)</h2>\n            <p>Sejak beberapa tahun terakhir, BKN merombak total pola soal TWK. Soal berbasis hafalan tekstual (seperti tanggal konferensi atau nomor pasal undang-undang) telah digantikan oleh <strong>soal penalaran studi kasus nyata di tempat kerja</strong>. Karakteristik utamanya:</p>\n            <ol>\n                <li><strong>Studi Kasus Dilematis</strong>: Soal menyajikan narasi seorang ASN yang dihadapkan pada dua pilihan sulit (misalnya antara loyalitas atasan vs kepatuhan pada aturan hukum).</li>\n                <li><strong>Pengamalan Sila Pancasila</strong>: Bukan sekadar menyebutkan butir sila, melainkan menentukan opsi tindakan mana yang paling mencerminkan keadilan sosial atau persatuan nasional.</li>\n                <li><strong>9 Nilai Integritas Antikorupsi KPK</strong>: Meliputi <em>Jujur, Peduli, Mandiri, Disiplin, Tanggung Jawab, Kerja Keras, Sederhana, Berani, dan Adil</em> dalam birokrasi pemerintahan.</li>\n                <li><strong>Bela Negara Kontemporer</strong>: Menyoroti pertahanan non-fisik, pencegahan radikalisme, ketahanan siber, dan kedaulatan ekonomi produk dalam negeri.</li>\n            </ol>\n\n            <h2 id=\"manajemen-waktu\">3. Trik Manajemen Waktu 100 Menit untuk 110 Soal</h2>\n            <p>Banyak peserta cerdas gagal bukan karena tidak mampu mengerjakan soal, melainkan karena kehabisan waktu di sub-tes hitungan matematika TIU. Terapkan urutan pengerjaan berikut:</p>\n            <ul>\n                <li><strong>Menit 01 - 30 (TKP - 45 Soal)</strong>: Kerjakan TKP di awal saat konsentrasi masih segar. Jangan pernah mengosongkan soal TKP karena semua opsi memiliki nilai 1 sampai 5. Alokasikan maksimal 40 detik per soal.</li>\n                <li><strong>Menit 31 - 55 (TWK - 30 Soal)</strong>: Baca kalimat tanya terakhir pada paragraf cerita untuk menangkap inti persoalan. Eliminasi 2 opsi ekstrem terlebih dahulu. Alokasikan maksimal 50 detik per soal.</li>\n                <li><strong>Menit 56 - 95 (TIU - 35 Soal)</strong>: Kerjakan terlebih dahulu analogi kata dan silogisme verbal. Untuk hitungan numerik, jika dalam 45 detik Anda belum menemukan polanya, lewati dulu dan tandai untuk dikerjakan terakhir.</li>\n                <li><strong>Menit 96 - 100 (Review Jawaban)</strong>: Cek lembar navigasi soal CAT untuk memastikan tidak ada soal yang terlewat.</li>\n            </ul>\n\n            <h2 id=\"bank-soal-10\">4. Bank Soal Latihan Mandiri (10 Soal Lengkap + Pembahasan Mendalam)</h2>\n            <p>Uji pemahaman Anda sekarang juga dengan mengerjakan 10 latihan soal HOTS di bawah ini. Klik tombol <strong>\"Buka Kunci Jawaban & Pembahasan\"</strong> pada tiap butir soal setelah Anda memilih jawaban:</p>\n\n            \n<div class=\"hk-exam-score-card\">\n    <div class=\"hk-exam-score-left\">\n        <span class=\"hk-exam-score-label\">📊 Lembar Evaluasi Interaktif SKD CPNS 2026:</span>\n        <div class=\"hk-exam-score-val\" id=\"hk-exam-score-display\">0 / 10 Soal Terjawab</div>\n        <div class=\"hk-exam-score-sub\" id=\"hk-exam-score-status\">Pilih jawaban Anda (opsi A, B, C, D, E) pada setiap butir soal di bawah lalu klik \"Periksa Jawaban\" untuk mengecek ambang batas kelulusan Anda secara instan.</div>\n    </div>\n    <div class=\"hk-exam-score-right\">\n        <button type=\"button\" class=\"hk-btn hk-btn-subtle\" onclick=\"resetAllArticleAnswers()\">\n            🔄 Ulangi Semua Soal\n        </button>\n    </div>\n</div>\n\n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-1\" data-soal-num=\"1\" data-key=\"B\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #1</span>\n                <span class=\"hk-soal-category-tag\">TWK HOTS • Pengamalan Sila ke-1 Pancasila</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-1\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">Seorang aparatur sipil negara (ASN) yang bertugas di loket pelayanan kependudukan dihadapkan pada situasi di mana rekan satu timnya menolak melayani warga dengan alasan perbedaan keyakinan dan penampilan keagamaan warga tersebut. Tindakan yang paling mencerminkan integritas nilai Ketuhanan Yang Maha Esa dan profesionalisme ASN adalah...</div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-1\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-1-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(1, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">Membiarkan tindakan rekannya karena menghormati kebebasan berkeyakinan dan hak individu setiap rekan kerja.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-1-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(1, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">Mengambil alih pelayanan warga tersebut secara ramah dan profesional, kemudian mendiskusikan serta mengingatkan rekan kerja secara bijak tentang kewajiban ASN bersikap netral tanpa diskriminasi.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-1-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(1, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">Melaporkan rekan kerja tersebut secara anonim ke media sosial agar mendapat sanksi sosial dari masyarakat luas.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-1-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(1, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">Menegur rekan kerja tersebut dengan keras di hadapan warga umum agar menimbulkan efek jera seketika.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-1-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(1, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">Menyarankan warga tersebut untuk mencari petugas lain di meja sebelah yang memiliki keyakinan serupa.</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-1\" onclick=\"checkArticleAnswer(1)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-1\" onclick=\"toggleSoalExplanation('exp-1')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(1)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-1\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: B</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> Sila ke-1 'Ketuhanan Yang Maha Esa' dalam konteks pelayanan publik mewajibkan setiap abdi negara untuk menjamin kebebasan dan kesetaraan hak setiap warga negara tanpa diskriminasi SARA (Pasal 29 UUD 1945). Tindakan B mencerminkan tanggung jawab ganda: mengedepankan pelayanan prima bagi masyarakat tanpa penundaan, serta melakukan pembinaan internal secara etis dan konstruktif.</div>\n        </div>\n    </div>\n    \n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-2\" data-soal-num=\"2\" data-key=\"C\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #2</span>\n                <span class=\"hk-soal-category-tag\">TWK HOTS • 9 Nilai Integritas Antikorupsi KPK</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-2\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">Sebagai staf bagian pengadaan barang dan jasa instansi, Anda menerima bingkisan mewah berupa gawai elektronik dari salah satu vendor pemenang lelang tender proyek sebagai ucapan terima kasih atas kerja sama selama 1 tahun. Vendor menyatakan bahwa bingkisan ini murni silaturahmi pribadi di luar kontrak resmi. Sikap integritas yang wajib diambil adalah...</div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-2\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-2-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(2, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">Menerima gawai tersebut karena proses lelang telah selesai secara sah dan vendor telah dinyatakan menang.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-2-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(2, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">Menerima bingkisan tersebut lalu membagikannya kepada seluruh staf divisi agar tidak dinikmati secara pribadi.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-2-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(2, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">Menolak bingkisan dengan sopan dan menjelaskan aturan gratifikasi, atau jika tidak dapat ditolak, segera melaporkannya ke Unit Pengendalian Gratifikasi (UPG) / KPK dalam waktu maksimal 30 hari kerja.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-2-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(2, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">Menjual gawai tersebut dan mendonasikan uang hasil penjualannya ke yayasan panti asuhan.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-2-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(2, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">Menyimpan barang tersebut di kantor tanpa membukanya sama sekali hingga masa jabatan berakhir.</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-2\" onclick=\"checkArticleAnswer(2)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-2\" onclick=\"toggleSoalExplanation('exp-2')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(2)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-2\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: C</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> Berdasarkan Pasal 12B UU No. 20 Tahun 2001 tentang Tindak Pidana Korupsi, setiap penerimaan fasilitas, uang, atau barang oleh penyelenggara negara yang berhubungan dengan jabatannya dikategorikan sebagai gratifikasi ilegal kecuali dilaporkan ke KPK dalam waktu paling lambat 30 hari kerja sejak tanggal penerimaan. Pilihan C adalah satu-satunya prosedur hukum yang benar.</div>\n        </div>\n    </div>\n    \n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-3\" data-soal-num=\"3\" data-key=\"B\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #3</span>\n                <span class=\"hk-soal-category-tag\">TWK HOTS • Bela Negara & Ketahanan Siber</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-3\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">Dalam era transformasi digital, ancaman terhadap keutuhan bangsa tidak hanya berbentuk agresi militer fisik, melainkan perang siber (*cyber warfare*) dan infiltrasi informasi palsu (hoaks terkoordinasi). Perwujudan nilai dasar Bela Negara 'Kemampuan Awal Bela Negara' oleh seorang tenaga profesional di bidang teknologi informasi adalah...</div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-3\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-3-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(3, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">Melakukan peretasan balasan (*counter hack*) ke situs pemerintah negara lain secara mandiri.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-3-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(3, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">Menerapkan protokol keamanan siber yang ketat, mengamankan data rahasia instansi, serta aktif memverifikasi dan mengedukasi literasi digital anti-hoaks di lingkungan kerja.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-3-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(3, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">Menghapus seluruh akun media sosial pribadi agar tidak menjadi sasaran empuk serangan phising.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-3-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(3, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">Mengganti seluruh perangkat lunak kerja dengan aplikasi bajakan yang dimodifikasi tanpa izin lisensi.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-3-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(3, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">Menyerahkan seluruh tanggung jawab keamanan sistem kepada pihak vendor luar negeri.</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-3\" onclick=\"checkArticleAnswer(3)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-3\" onclick=\"toggleSoalExplanation('exp-3')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(3)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-3\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: B</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> Kemampuan awal bela negara secara psikis dan fisik di era modern diwujudkan melalui penguasaan kompetensi profesional untuk menjaga kedaulatan informasi nasional. Mengamankan aset data instansi dan meningkatkan literasi digital publik adalah wujud nyata pertahanan nir-militer yang diamanatkan UU No. 23 Tahun 2019 tentang Pengelolaan Sumber Daya Nasional untuk Pertahanan Negara.</div>\n        </div>\n    </div>\n    \n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-4\" data-soal-num=\"4\" data-key=\"B\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #4</span>\n                <span class=\"hk-soal-category-tag\">TWK HOTS • Sila ke-3 Persatuan Indonesia</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-4\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">Pemerintah menugaskan ASN muda dari Pulau Jawa untuk memimpin proyek pemberdayaan ekonomi masyarakat adat di wilayah pedalaman Papua. Pada pertemuan awal, beberapa tokoh adat menunjukkan sikap resistan karena trauma masa lalu dengan pejabat luar daerah. Pendekatan yang paling tepat sesuai semangat Bhinneka Tunggal Ika adalah...</div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-4\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-4-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(4, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">Memaksakan prosedur standar operasional pusat dengan ancaman pembatalan bantuan dana anggaran proyek.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-4-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(4, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">Melakukan pendekatan kultural dengan mendengarkan aspirasi para tetua adat, menghormati hukum adat lokal yang tidak bertentangan dengan hukum nasional, dan melibatkan putra daerah dalam kepengurusan.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-4-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(4, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">Meminta bantuan aparat keamanan bersenjata lengkap untuk mengawal setiap sesi rapat bersama warga.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-4-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(4, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">Mengalihkan lokasi proyek ke desa lain yang masyarakatnya lebih mudah diatur dan bersikap ramah.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-4-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(4, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">Hanya berinteraksi dengan warga pendatang yang memiliki kesamaan suku dan budaya asal.</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-4\" onclick=\"checkArticleAnswer(4)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-4\" onclick=\"toggleSoalExplanation('exp-4')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(4)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-4\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: B</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> Pengamalan Sila ke-3 dalam keberagaman menuntut empati kultural dan pendekatan persuasif partisipatif. Menghargai kearifan lokal (local wisdom) dan melibatkan masyarakat adat sebagai subjek pembangunan memperkuat kohesi nasional tanpa mencabut identitas budaya mereka.</div>\n        </div>\n    </div>\n    \n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-5\" data-soal-num=\"5\" data-key=\"C\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #5</span>\n                <span class=\"hk-soal-category-tag\">TWK HOTS • UUD 1945 Pasal 28 & Batasan Etika ASN</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-5\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">Pasal 28E ayat (3) UUD 1945 menyatakan bahwa setiap orang berhak atas kebebasan berserikat, berkumpul, dan mengeluarkan pendapat. Namun bagi seorang Pegawai Negeri Sipil (PNS), kebebasan ini memiliki batasan etika profesi khusus, yaitu...</div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-5\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-5-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(5, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">PNS sama sekali tidak boleh memiliki opini pribadi dalam urusan politik kebangsaan.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-5-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(5, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">PNS bebas mengkritik kebijakan instansinya sendiri secara terbuka di media sosial dengan menggunakan akun anonim.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-5-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(5, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">PNS wajib menjaga netralitas, tidak boleh terlibat dalam politik praktis/kampanye pemilu, serta tidak menyebarkan rahasia negara atau ujaran kebencian yang meruntuhkan marwah korps ASN.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-5-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(5, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">PNS hanya boleh menyampaikan pendapat setelah mendapatkan surat izin tertulis dari menteri terkait.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-5-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(5, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">PNS tidak diperbolehkan menjadi anggota organisasi profesi resmi apapun.</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-5\" onclick=\"checkArticleAnswer(5)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-5\" onclick=\"toggleSoalExplanation('exp-5')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(5)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-5\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: C</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> UU No. 20 Tahun 2023 tentang Aparatur Sipil Negara secara tegas mengatur asas netralitas ASN (Pasal 2 f dan Pasal 9 ayat 2). Hak asasi mengemukakan pendapat dijamin konstitusi, namun terikat pada kode etik pegawai negeri sipil untuk tidak memihak kepentingan politik praktis demi menjaga objektivitas pelayanan publik.</div>\n        </div>\n    </div>\n    \n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-6\" data-soal-num=\"6\" data-key=\"B\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #6</span>\n                <span class=\"hk-soal-category-tag\">TIU • Analogi Kata Hubungan Fungsi & Sarana</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-6\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">STETOSKOP : DOKTER = ... : ...</div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-6\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-6-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(6, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">PENA : TINTA</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-6-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(6, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">CANGKUL : PETANI</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-6-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(6, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">PASIEN : RUMAH SAKIT</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-6-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(6, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">TERMOMETER : SUHU</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-6-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(6, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">RESEP : APOTEKER</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-6\" onclick=\"checkArticleAnswer(6)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-6\" onclick=\"toggleSoalExplanation('exp-6')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(6)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-6\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: B</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> Hubungan analogi alat kerja utama terhadap profesinya: Stetoskop adalah alat kerja khas yang digunakan oleh Dokter saat bertugas, sebagaimana Cangkul adalah alat kerja khas yang digunakan oleh Petani di sawah.</div>\n        </div>\n    </div>\n    \n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-7\" data-soal-num=\"7\" data-key=\"B\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #7</span>\n                <span class=\"hk-soal-category-tag\">TIU • Silogisme Logika 3 Premis</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-7\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">Premis 1: Semua pelamar yang lolos seleksi SKD CPNS wajib mengikuti tes SKB.<br>Premis 2: Sebagian pelamar yang mengikuti tes SKB memiliki sertifikat pendidik (serdik).<br>Kesimpulan yang paling sah secara logika adalah...</div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-7\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-7-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(7, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">Semua pelamar yang memiliki serdik pasti lolos tes SKD.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-7-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(7, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">Sebagian pelamar yang lolos seleksi SKD CPNS memiliki sertifikat pendidik (serdik).</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-7-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(7, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">Semua pelamar yang mengikuti tes SKB pasti diterima menjadi ASN.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-7-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(7, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">Pelamar yang tidak memiliki serdik tidak boleh mengikuti tes SKD.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-7-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(7, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">Tidak ada pelamar yang lolos SKD yang memiliki serdik.</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-7\" onclick=\"checkArticleAnswer(7)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-7\" onclick=\"toggleSoalExplanation('exp-7')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(7)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-7\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: B</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> Menggunakan aturan silogisme partikular (sebagian): Jika Semua A adalah B, dan Sebagian B adalah C, maka kesimpulannya Sebagian A adalah C. Dalam konteks ini: Sebagian pelamar yang lolos seleksi SKD (A) memiliki sertifikat pendidik (C).</div>\n        </div>\n    </div>\n    \n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-8\" data-soal-num=\"8\" data-key=\"C\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #8</span>\n                <span class=\"hk-soal-category-tag\">TIU • Deret Angka Bertingkat Kombinasi</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-8\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">Tentukan angka berikutnya dari deret angka berikut:<br><strong>4, 7, 13, 25, 49, ...?</strong></div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-8\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-8-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(8, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">75</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-8-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(8, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">87</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-8-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(8, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">97</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-8-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(8, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">99</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-8-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(8, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">102</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-8\" onclick=\"checkArticleAnswer(8)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-8\" onclick=\"toggleSoalExplanation('exp-8')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(8)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-8\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: C</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> Analisis selisih deret:<br>4 ke 7 selisih +3<br>7 ke 13 selisih +6 (+3 x 2)<br>13 ke 25 selisih +12 (+6 x 2)<br>25 ke 49 selisih +24 (+12 x 2)<br>Maka selisih berikutnya adalah +24 x 2 = +48.<br>Angka berikutnya: 49 + 48 = <strong>97</strong>. (Atau pola $2n - 1$: $4 \\times 2 - 1 = 7$, $7 \\times 2 - 1 = 13$, $13 \\times 2 - 1 = 25$, $25 \\times 2 - 1 = 49$, $49 \\times 2 - 1 = 97$).</div>\n        </div>\n    </div>\n    \n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-9\" data-soal-num=\"9\" data-key=\"B\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #9</span>\n                <span class=\"hk-soal-category-tag\">TIU • Soal Cerita Aljabar & Kecepatan</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-9\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">Budi berkendara mobil dari Kota A ke Kota B dengan kecepatan rata-rata 60 km/jam pada pukul 08.00 WIB. Pada saat yang sama, Doni berkendara dari Kota B menuju Kota A melalui jalur yang sama dengan kecepatan rata-rata 80 km/jam. Jika jarak Kota A dan Kota B adalah 280 km, pada pukul berapakah mereka akan berpapasan di jalan?</div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-9\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-9-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(9, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">09.30 WIB</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-9-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(9, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">10.00 WIB</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-9-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(9, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">10.15 WIB</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-9-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(9, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">10.30 WIB</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-9-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(9, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">11.00 WIB</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-9\" onclick=\"checkArticleAnswer(9)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-9\" onclick=\"toggleSoalExplanation('exp-9')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(9)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-9\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: B</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> Rumus waktu berpapasan ($t$):<br>$t = \\frac{\\text{Jarak Total}}{V_1 + V_2} = \\frac{280}{60 + 80} = \\frac{280}{140} = 2 \\text{ jam}$.<br>Karena mereka berangkat bersamaan pukul 08.00 WIB, maka mereka akan berpapasan pada pukul: $08.00 + 02.00 = \\mathbf{10.00 \\text{ WIB}}$.</div>\n        </div>\n    </div>\n    \n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-10\" data-soal-num=\"10\" data-key=\"B\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #10</span>\n                <span class=\"hk-soal-category-tag\">TIU • Penalaran Analitis Urutan & Jadwal</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-10\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">Enam orang calon pegawai (A, B, C, D, E, dan F) diwawancarai secara berurutan dalam satu hari kerja:<br>1. D diwawancarai tepat setelah B.<br>2. A diwawancarai sebelum C.<br>3. E diwawancarai pada urutan pertama.<br>4. F diwawancarai tepat sebelum B.<br>Jika C diwawancarai pada urutan terakhir (ke-6), maka siapa yang diwawancarai pada urutan ke-4?</div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-10\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-10-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(10, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">A</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-10-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(10, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">B</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-10-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(10, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">D</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-10-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(10, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">F</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-10-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(10, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">C</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-10\" onclick=\"checkArticleAnswer(10)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-10\" onclick=\"toggleSoalExplanation('exp-10')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(10)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-10\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: B</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> Urutan 1 = E, Urutan 6 = C. Blok berturutan: F tepat sebelum B, dan D tepat setelah B -> [F, B, D]. Sisa slot untuk A dan [F, B, D] adalah slot 2, 3, 4, 5. Susunan yang tepat: Urutan 1: E, Urutan 2: A, Urutan 3: F, <strong>Urutan 4: B</strong>, Urutan 5: D, Urutan 6: C.<br>Kandidat pada urutan ke-4 adalah <strong>B</strong>.</div>\n        </div>\n    </div>\n    \n\n            <h2 id=\"kesimpulan\">5. Kesimpulan &amp; Rekomendasi Belajar Harian</h2>\n            <p>Konsistensi adalah kunci utama keberhasilan menembus formasi ASN. Luangkan waktu minimal <strong>90 menit setiap hari</strong> untuk mengerjakan minimal 50 latihan soal dengan batas waktu stopwatch. Evaluasi setiap kesalahan pada lembar pembahasan untuk membangun insting eliminasi opsi yang tajam saat hari ujian sesungguhnya.</p>\n        "},"cv":{"title":"Panduan Lengkap Membuat CV ATS Friendly Bahasa Indonesia (+ Free Template Word & PDF)","category":"CV & Berkas","catClass":"hk-tk-icon-emerald","badgeBg":"#10b981","date":"22 Okt 2026","readTime":"10 Menit Baca","author":"Tim Karir & HRD Specialist Hakajobs","banner":"https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=1000&auto=format&fit=crop&q=80","toc":[{"id":"apa-itu-ats","label":"1. Apa itu Sistem ATS & Cara Kerjanya"},{"id":"kesalahan-fatal","label":"2. 7 Kesalahan Fatal yang Menggugurkan CV"},{"id":"struktur-anatomi","label":"3. Struktur Anatomi Ideal Resume ATS Bahasa Indonesia"},{"id":"formula-star","label":"4. Menulis Deskripsi Pengalaman dengan Formula STAR / Google XYZ"},{"id":"format-teknis","label":"5. Rekomendasi Font, Spasi, Margin & Format File"},{"id":"template-teks","label":"6. Template Teks Utuh Siap Edit (Copy-Paste)"}],"body":"\n            <div class=\"hk-callout-box\">\n                <strong>📌 Catatan Penting:</strong> Lebih dari 75% CV pelamar kerja di perusahaan multinasional, BUMN, dan korporasi terkemuka otomatis tersaring oleh sistem <em>Applicant Tracking System</em> (ATS) sebelum pernah dibaca oleh rekruter manusia. Pelajari panduan praktis ini untuk memastikan resume Anda tembus screening awal 100%.\n            </div>\n\n            <h2 id=\"apa-itu-ats\">1. Apa itu Sistem ATS &amp; Bagaimana Cara Kerjanya?</h2>\n            <p><strong>Applicant Tracking System (ATS)</strong> adalah perangkat lunak manajemen rekrutmen yang digunakan HRD untuk menyaring, mengindeks, dan memeringkat ribuan berkas lamaran kerja secara otomatis. Sistem ini bekerja dengan menggunakan algoritma <em>parsing</em> teks:</p>\n            <ul>\n                <li>Bot ATS membaca file resume Anda dari kiri ke kanan, atas ke bawah.</li>\n                <li>Bot memindai kata kunci (<em>keywords</em>) penting seperti jabatan, nama software, bahasa pemrograman, sertifikasi, dan keterampilan spesifik.</li>\n                <li>Sistem memberikan skor kecocokan (<em>match rate percentage</em>) antara resume Anda dengan kriteria yang diminta pada iklan lowongan kerja.</li>\n            </ul>\n\n            <h2 id=\"kesalahan-fatal\">2. 7 Kesalahan Fatal yang Menggugurkan CV di Sistem ATS</h2>\n            <ol>\n                <li><strong>Menggunakan Layout Multi-Kolom Rumit</strong>: Layout dua kolom atau tiga kolom sering dibaca secara acak dan teracak oleh parser bot, sehingga pengalaman kerja Anda bisa tertukar dengan riwayat hobi.</li>\n                <li><strong>Menyisipkan Grafik Rating Keahlian</strong>: Grafik batang (progress bar 80%) atau rating bintang 4/5 tidak memiliki arti semantik teks bagi bot ATS dan justru memakan ruang berharga.</li>\n                <li><strong>Menempatkan Teks di Dalam Text Box Mengambang</strong>: Kotak teks (*text box*) di Microsoft Word sering diabaikan total oleh parser ATS sehingga seluruh teks di dalamnya dianggap kosong.</li>\n                <li><strong>Menggunakan Font Kaligrafi / Dekoratif</strong>: Font non-standar sering berubah menjadi karakter aneh atau kotak-kotak (*tofu*) pada sistem pembaca teks.</li>\n                <li><strong>Menaruh Kontak di Header / Footer Word</strong>: Beberapa software ATS lama tidak membaca area header dan footer margin dokumen. Pastikan kontak berada di badan utama teks.</li>\n                <li><strong>Format File yang Salah</strong>: Mengirim format JPG/PNG adalah jaminan 100% gagal screening. Selalu gunakan format <strong>.docx</strong> atau <strong>PDF teks</strong> (bukan scan PDF).</li>\n                <li><strong>Tidak Menyesuaikan Kata Kunci</strong>: Mengirimkan satu CV yang sama persis untuk 50 jenis lowongan berbeda tanpa menyelaraskan istilah kualifikasi loker.</li>\n            </ol>\n\n            <h2 id=\"struktur-anatomi\">3. Struktur Anatomi Ideal Resume ATS Bahasa Indonesia</h2>\n            <p>Susunlah resume Anda dalam format satu kolom kronologis terbalik (*Reverse Chronological*) dengan urutan baku berikut:</p>\n            <ol>\n                <li><strong>Header Kontak</strong>: Nama Lengkap (Bold, 18-20pt), Nomor WhatsApp (+62), Email Profesional, Tautan Profil LinkedIn, Kota Domisili (cukup: Kota, Provinsi). <em>Tidak perlu mencantumkan agama, status pernikahan, atau alamat lengkap RT/RW.</em></li>\n                <li><strong>Ringkasan Profesional (*Professional Summary*)</strong>: 3-4 kalimat padat yang merangkum posisi keahlian Anda, jumlah tahun pengalaman kerja, dan pencapaian angka terbesar.</li>\n                <li><strong>Pengalaman Kerja (*Work Experience*)</strong>: Dari yang paling baru ke yang paling lama. Tuliskan Jabatan, Nama Perusahaan, Lokasi Kota, dan Periode Kerja (Bulan Tahun – Bulan Tahun).</li>\n                <li><strong>Riwayat Pendidikan (*Education*)</strong>: Gelar, Jurusan, Nama Universitas, Kota, Tahun Kelulusan, dan Nilai IPK (jika di atas 3.25).</li>\n                <li><strong>Keahlian (*Skills*)</strong>: Hard skills teknis (software/tools) dan soft skills profesional.</li>\n                <li><strong>Sertifikasi &amp; Pelatihan (*Certifications*)</strong>: Nama Sertifikat, Lembaga Penerbit, dan Tahun Terbit.</li>\n            </ol>\n\n            <h2 id=\"formula-star\">4. Menulis Deskripsi Pengalaman dengan Formula Google XYZ / STAR</h2>\n            <p>Hindari menuliskan sekadar daftar tugas harian pasif seperti: <em>\"Bertanggung jawab mengelola media sosial\"</em>. Ubah menjadi kalimat aktif berbasis pencapaian metrik angka:</p>\n            <div class=\"hk-callout-box\">\n                <strong>Rumus Google:</strong> <em>\"Berhasil mencapai [X], yang diukur dengan metrik [Y], melalui tindakan nyata [Z].\"</em><br><br>\n                <strong>❌ Contoh Pasif:</strong> Mengelola akun Instagram perusahaan dan membuat konten mingguan.<br>\n                <strong>✅ Contoh Standar ATS:</strong> Meningkatkan jumlah pengikut Instagram organik sebesar 45% dalam 4 bulan dan menaikkan tingkat interaksi (engagement rate) dari 1.8% menjadi 4.2% melalui eksekusi 20 video edukatif berdurasi pendek.\n            </div>\n\n            <h2 id=\"format-teknis\">5. Rekomendasi Font, Spasi, Margin &amp; Format Dokumen</h2>\n            <ul>\n                <li><strong>Pilihan Font Standar</strong>: Calibri, Arial, Helvetica, Georgia, atau Roboto.</li>\n                <li><strong>Ukuran Font</strong>: 10 - 11pt untuk paragraf isi, 12 - 14pt untuk judul sub-bab (Bold), 18 - 20pt untuk nama pelamar di bagian teratas.</li>\n                <li><strong>Margin Dokumen</strong>: 1 inci (2.54 cm) pada semua sisi (Top, Bottom, Left, Right).</li>\n                <li><strong>Spasi Baris</strong>: 1.15 dengan spasi antar paragraf 4-6pt.</li>\n                <li><strong>Panjang Resume</strong>: 1 halaman untuk fresh graduate hingga 3 tahun pengalaman; maksimal 2 halaman untuk profesional senior di atas 5 tahun pengalaman.</li>\n            </ul>\n\n            <h2 id=\"template-teks\">6. Template Teks Utuh Siap Edit (Copy-Paste)</h2>\n            <p>Salin teks di bawah ini ke Microsoft Word atau Google Docs Anda dan sesuaikan dengan data riwayat Anda:</p>\n\n            <div class=\"hk-template-display-box\">NAMA LENGKAP PELAMAR\nKota Bandar Lampung, Lampung | +62 812-3456-7890 | nama.email@gmail.com | linkedin.com/in/namaprofil\n\nRINGKASAN PROFESIONAL\nProfesional Digital Marketing berpengalaman 2+ tahun dalam mengelola kampanye iklan berbayar (Meta Ads, Google Ads) dan optimasi SEO website e-commerce. Terbukti berhasil meningkatkan omzet penjualan digital sebesar 38% dalam waktu 6 bulan dengan efisiensi biaya akuisisi pelanggan (CAC) turun 18%. Memiliki sertifikasi resmi Google Digital Garage dan BNSP Digital Marketing.\n\nPENGALAMAN KERJA\nDigital Marketing Specialist | PT Inovasi Niaga Digital, Jakarta Selatan (Remote)\nMaret 2024 – Sekarang\n• Merancang dan mengeksekusi strategi iklan berbayar Meta Ads & Google Search Ads dengan anggaran Rp 35.000.000 per bulan, menghasilkan ROAS rata-rata 4.8x.\n• Mengembangkan 15 artikel pilar SEO ramah mesin pencari yang berhasil menembus halaman pertama Google, meningkatkan traffic organik website dari 12.000 menjadi 45.000 kunjungan bulanan.\n• Berkolaborasi bersama tim kreatif dan copywriting untuk memproduksi konten visual yang menaikkan CTR (Click-Through Rate) kampanye promosi dari 1.2% menjadi 3.4%.\n\nSocial Media Officer | CV Kreasi Media Mandiri, Bandar Lampung\nJanuari 2023 – Februari 2024\n• Mengelola jadwal publikasi konten Instagram dan TikTok dengan rata-rata 5 konten per minggu, menumbuhkan audiens dari 8.000 menjadi 28.000 followers dalam tempo 1 tahun.\n• Menangani interaksi customer relation via Direct Message (DM) dan WhatsApp Business dengan waktu respons rata-rata di bawah 5 menit dan tingkat kepuasan pelanggan 96%.\n\nRIWAYAT PENDIDIKAN\nSarjana Ilmu Komunikasi (S.I.Kom) | Universitas Lampung (UNILA)\nTahun Kelulusan: 2022 | IPK: 3.72 / 4.00 (Predikat Pujian / Cumlaude)\n\nKEAHLIAN TEKNIS & BAHASA\n• Hard Skills: Search Engine Optimization (SEO), Meta Ads Manager, Google Analytics 4 (GA4), WordPress CMS, Canva Pro, Copywriting.\n• Soft Skills: Negosiasi, Analisis Data Metrik, Komunikasi Antar Divisi, Manajemen Waktu.\n• Bahasa: Bahasa Indonesia (Penutur Asli), Bahasa Inggris (Skor TOEFL ITP 540).\n\nSERTIFIKASI PROFESI\n• Sertifikasi Profesi Digital Marketing Specialist – BNSP (Tahun 2024)\n• Google Ads Search Certification – Google Skillshop (Tahun 2023)</div>\n        "},"psikotes":{"title":"Cara Mengerjakan Tes Koran (Kraepelin & Pauli) Agar Skor Tinggi & Grafik Stabil (10 Latihan & Trik)","category":"Psikotes Kerja","catClass":"hk-tk-icon-indigo","badgeBg":"#6366f1","date":"19 Okt 2026","readTime":"11 Menit Baca","author":"Konsultan Psikologi Kerja Hakajobs","banner":"https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=1000&auto=format&fit=crop&q=80","toc":[{"id":"tujuan-psikotes","label":"1. Apa yang Sebenarnya Dinilai Psikolog?"},{"id":"beda-kraepelin-pauli","label":"2. Perbedaan Fundamental Kraepelin vs Pauli"},{"id":"4-grafik","label":"3. 4 Bentuk Grafik Hasil Tes & Maknanya bagi Rekruter"},{"id":"trik-fisik-mental","label":"4. 7 Trik Rahasia Menjaga Ketahanan Fisik & Mental"},{"id":"latihan-soal","label":"5. 10 Latihan Soal Angka Koran & Pola Logika Psikotes"}],"body":"\n            <div class=\"hk-callout-box\">\n                <strong>📌 Fakta Penting:</strong> Tes koran bukan ujian kepintaran matematika. Banyak sarjana teknik dan matematika justru gagal karena tidak memahami bahwa tes ini dirancang untuk membaca ritme kerja bawah sadar, daya tahan kelelahan, dan stabilitas emosi di bawah tekanan instruksi berulang.\n            </div>\n\n            <h2 id=\"tujuan-psikotes\">1. Apa yang Sebenarnya Dinilai Psikolog dalam Tes Koran?</h2>\n            <p>Tes Kraepelin dan Pauli mengukur 4 parameter profil psikologis kerja utama:</p>\n            <ul>\n                <li><strong>Kecepatan Kerja (*Tempo Kerja*)</strong>: Dinilai dari jumlah angka yang berhasil Anda jumlahkan per kolom. Menunjukkan apakah Anda tipe pekerja lambat, sedang, atau gesit.</li>\n                <li><strong>Ketelitian Kerja (*Akurasi*)</strong>: Dinilai dari seberapa sedikit kesalahan hitung atau angka yang terlewati. Menunjukkan tingkat kecermatan saat mengerjakan tugas rutin.</li>\n                <li><strong>Ketahanan Kerja (*Kestabilan*)</strong>: Dinilai dari konsistensi tinggi grafik dari kolom pertama hingga kolom terakhir. Menunjukkan ketahanan fisik dan daya tahan stres.</li>\n                <li><strong>Pengendalian Emosi (*Emotional Stability*)</strong>: Dinilai dari fluktuasi grafik. Grafik yang naik turun tajam menandakan individu yang mudah panik atau moody.</li>\n            </ul>\n\n            <h2 id=\"beda-kraepelin-pauli\">2. Perbedaan Fundamental Kraepelin vs Pauli</h2>\n            <table style=\"width:100%; border-collapse:collapse; margin:20px 0; font-size:13.5px;\">\n                <thead>\n                    <tr style=\"background:#f1f5f9; border-bottom:2px solid #cbd5e1;\">\n                        <th style=\"padding:10px 14px; text-align:left;\">Parameter</th>\n                        <th style=\"padding:10px 14px; text-align:left;\">Tes Kraepelin</th>\n                        <th style=\"padding:10px 14px; text-align:left;\">Tes Pauli (Koran)</th>\n                    </tr>\n                </thead>\n                <tbody>\n                    <tr style=\"border-bottom:1px solid #e2e8f0;\">\n                        <td style=\"padding:10px 14px; font-weight:700;\">Arah Penjumlahan</td>\n                        <td style=\"padding:10px 14px;\">Dari Bawah ke Atas</td>\n                        <td style=\"padding:10px 14px;\">Dari Atas ke Bawah</td>\n                    </tr>\n                    <tr style=\"border-bottom:1px solid #e2e8f0;\">\n                        <td style=\"padding:10px 14px; font-weight:700;\">Ukuran Lembar</td>\n                        <td style=\"padding:10px 14px;\">Kertas ukuran A4 / Folio (50 kolom)</td>\n                        <td style=\"padding:10px 14px;\">Kertas koran lebar raksasa</td>\n                    </tr>\n                    <tr style=\"border-bottom:1px solid #e2e8f0;\">\n                        <td style=\"padding:10px 14px; font-weight:700;\">Instruksi Pindah</td>\n                        <td style=\"padding:10px 14px;\">Instruksi: \"PINDAH!\" setiap 15-30 detik</td>\n                        <td style=\"padding:10px 14px;\">Instruksi: \"GARIS!\" setiap beberapa menit</td>\n                    </tr>\n                    <tr style=\"border-bottom:1px solid #e2e8f0;\">\n                        <td style=\"padding:10px 14px; font-weight:700;\">Total Waktu Ujian</td>\n                        <td style=\"padding:10px 14px;\">Singkat: sekitar 15 - 20 menit</td>\n                        <td style=\"padding:10px 14px;\">Sangat lama: 60 menit penuh tanpa henti</td>\n                    </tr>\n                </tbody>\n            </table>\n\n            <h2 id=\"4-grafik\">3. 4 Bentuk Grafik Hasil Tes &amp; Maknanya bagi Rekruter</h2>\n            <ol>\n                <li><strong>Grafik Menurun (*Desenden*)</strong>: Jumlah angka di kolom awal sangat tinggi, lalu merosot drastis di pertengahan hingga akhir. <em>Arti Psikologis:</em> Tipe pelari cepat yang tidak punya stamina; cepat lelah dan mudah kehilangan fokus saat menghadapi pekerjaan panjang. <strong>(Potensi Gagal Tinggi)</strong>.</li>\n                <li><strong>Grafik Zig-Zag Ekstrem (*Fluktuatif*)</strong>: Naik turun tajam tak berpola. <em>Arti Psikologis:</em> Suasana hati tidak stabil, mudah terdistraksi oleh lingkungan, dan rentan melakukan kesalahan saat berada di bawah tekanan deadline. <strong>(Kurang Disukai)</strong>.</li>\n                <li><strong>Grafik Rata Datar (*Konstan*)</strong>: Garis horizontal stabil dari awal sampai akhir. <em>Arti Psikologis:</em> Disiplin, dapat diandalkan, namun cenderung bermain aman dan kurang berinisiatif mengambil tantangan lebih. <strong>(Cukup Baik)</strong>.</li>\n                <li><strong>Grafik Menanjak Stabil (*Asenden Moderat*)</strong>: Garis grafik naik secara bertahap dan konsisten. <em>Arti Psikologis:</em> Memiliki adaptasi kerja yang sangat prima, semakin lama bekerja semakin fokus, berdaya tahan tinggi, dan mampu meningkatkan performa seiring waktu. <strong>(Sangat Direkomendasikan / Lolos)</strong>.</li>\n            </ol>\n\n            <h2 id=\"trik-fisik-mental\">4. 7 Trik Rahasia Menjaga Ketahanan Fisik &amp; Mental</h2>\n            <ul>\n                <li><strong>Jangan Terpancing Peserta Lain</strong>: Bunyi desiran pensil peserta di sebelah Anda yang membalik halaman bukan berarti mereka lebih benar. Fokus pada lembar Anda sendiri.</li>\n                <li><strong>Teknik Pensil 2B Berkualitas</strong>: Siapkan minimal 3 batang pensil 2B yang telah diraut runcing. Jangan gunakan pensil mekanik karena mata pensilnya mudah patah saat ditekan cepat.</li>\n                <li><strong>Posisi Duduk Ergonomis</strong>: Duduk tegak dengan punggung menempel sandaran kursi, jarak mata sekitar 30 cm dari lembar kertas. Jangan membungkuk karena otot leher akan cepat kaku di menit ke-10.</li>\n                <li><strong>Pernapasan Rileks</strong>: Gunakan pernapasan perut/diafragma yang teratur agar asupan oksigen ke otak tetap optimal.</li>\n                <li><strong>Jangan Pernah Menghapus</strong>: Jika salah menuliskan angka, cukup coret satu garis pada angka yang salah dan tuliskan angka yang benar di samping kanannya. Menghapus dengan karet penghapus membuang waktu 4-5 detik yang berharga.</li>\n            </ul>\n\n            <h2 id=\"latihan-soal\">5. 10 Latihan Soal Angka Koran &amp; Pola Logika Psikotes</h2>\n            <p>Berikut adalah 10 butir soal latihan mencakup trik angka koran dan deret penalaran psikotes yang paling sering diujikan:</p>\n\n            \n    <div class=\"hk-interactive-soal\" id=\"soal-box-1\" data-soal-num=\"1\" data-key=\"B\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #1</span>\n                <span class=\"hk-soal-category-tag\">Psikotes Deret • Pola Geometri Pecahan</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-1\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">Berapakah nilai lanjutan dari deret berikut:<br><strong>64, 32, 16, 8, 4, ...?</strong></div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-1\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-1-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(1, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">3</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-1-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(1, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">2</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-1-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(1, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">1</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-1-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(1, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">0.5</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-1-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(1, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">0</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-1\" onclick=\"checkArticleAnswer(1)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-1\" onclick=\"toggleSoalExplanation('exp-1')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(1)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-1\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: B</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> Pola pembagian konstan: setiap suku dibagi 2. $4 \\div 2 = 2$.</div>\n        </div>\n    </div>\n    \n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-2\" data-soal-num=\"2\" data-key=\"B\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #2</span>\n                <span class=\"hk-soal-category-tag\">Psikotes Deret • Pola Selisih Melompat</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-2\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">Berapakah dua suku berikutnya dari deret:<br><strong>2, 3, 5, 8, 12, 17, ..., ...?</strong></div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-2\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-2-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(2, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">22, 28</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-2-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(2, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">23, 30</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-2-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(2, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">24, 31</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-2-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(2, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">23, 29</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-2-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(2, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">25, 32</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-2\" onclick=\"checkArticleAnswer(2)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-2\" onclick=\"toggleSoalExplanation('exp-2')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(2)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-2\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: B</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> Pola penambahan selisih berurutan: +1, +2, +3, +4, +5, +6, +7.<br>$17 + 6 = 23$, dan $23 + 7 = 30$. Jawaban: <strong>23, 30</strong>.</div>\n        </div>\n    </div>\n    \n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-3\" data-soal-num=\"3\" data-key=\"C\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #3</span>\n                <span class=\"hk-soal-category-tag\">Psikotes Deret • Pola Angka Kembar Berseling</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-3\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">Tentukan angka selanjutnya dari deret:<br><strong>5, 10, 7, 14, 11, 22, ...?</strong></div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-3\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-3-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(3, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">15</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-3-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(3, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">17</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-3-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(3, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">19</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-3-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(3, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">26</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-3-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(3, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">44</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-3\" onclick=\"checkArticleAnswer(3)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-3\" onclick=\"toggleSoalExplanation('exp-3')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(3)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-3\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: C</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> Pola berseling: dikali 2, lalu dikurangi 3.<br>$5 \\times 2 = 10$, $10 - 3 = 7$, $7 \\times 2 = 14$, $14 - 3 = 11$, $11 \\times 2 = 22$, $22 - 3 = \\mathbf{19}$.</div>\n        </div>\n    </div>\n    \n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-4\" data-soal-num=\"4\" data-key=\"C\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #4</span>\n                <span class=\"hk-soal-category-tag\">Psikotes Angka Koran • Trik Digit Satuan</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-4\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">Pada tes Pauli/Kraepelin, jika Anda menjumlahkan dua angka berturut-turut $8$ dan $9$, hasil penjumlahan adalah $17$. Angka yang wajib Anda tuliskan di lembar jawaban adalah...</div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-4\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-4-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(4, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">Tulis angka 17 lengkap</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-4-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(4, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">Tulis angka 1 (angka puluhan)</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-4-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(4, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">Tulis angka 7 (hanya angka satuan)</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-4-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(4, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">Tulis angka 8</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-4-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(4, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">Tulis angka 0</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-4\" onclick=\"checkArticleAnswer(4)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-4\" onclick=\"toggleSoalExplanation('exp-4')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(4)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-4\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: C</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> Aturan baku tes koran internasional: jika hasil penjumlahan menghasilkan dua digit (10 ke atas), Anda hanya boleh menuliskan **angka satuan belakangnya saja**. Untuk $8 + 9 = 17$, maka yang ditulis adalah angka <strong>7</strong>.</div>\n        </div>\n    </div>\n    \n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-5\" data-soal-num=\"5\" data-key=\"A\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #5</span>\n                <span class=\"hk-soal-category-tag\">Psikotes Angka Koran • Penjumlahan Puluhan</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-5\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">Dalam lajur tes Pauli, Anda menjumpai deretan vertikal: 6, 4, 9, 3. Hasil penjumlahan bertahap dari atas ke bawah yang benar adalah...</div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-5\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-5-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(5, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">0 (dari 6+4=10), lalu 3 (dari 4+9=13), lalu 2 (dari 9+3=12)</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-5-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(5, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">10, 13, 12</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-5-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(5, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">6, 4, 9</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-5-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(5, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">0, 4, 2</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-5-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(5, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">1, 1, 1</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-5\" onclick=\"checkArticleAnswer(5)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-5\" onclick=\"toggleSoalExplanation('exp-5')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(5)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-5\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: A</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> Langkah per langkah:<br>1. $6 + 4 = 10 \\rightarrow$ tulis <strong>0</strong>.<br>2. $4 + 9 = 13 \\rightarrow$ tulis <strong>3</strong>.<br>3. $9 + 3 = 12 \\rightarrow$ tulis <strong>2</strong>.<br>Deret jawaban di antara spasi angka: <strong>0, 3, 2</strong>.</div>\n        </div>\n    </div>\n    \n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-6\" data-soal-num=\"6\" data-key=\"C\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #6</span>\n                <span class=\"hk-soal-category-tag\">Psikotes Penalaran Figural • Rotasi Objek 90 Derajat</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-6\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">Sebuah panah mengarah ke Atas (Utara). Kemudian berputar searah jarum jam sebesar 90°, lalu berputar lagi 180°, dan terakhir berputar berlawanan arah jarum jam sebesar 90°. Ke manakah arah panah sekarang?</div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-6\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-6-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(6, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">Utara</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-6-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(6, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">Timur</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-6-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(6, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">Selatan</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-6-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(6, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">Barat</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-6-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(6, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">Tenggara</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-6\" onclick=\"checkArticleAnswer(6)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-6\" onclick=\"toggleSoalExplanation('exp-6')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(6)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-6\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: C</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> Total putaran = +90° + 180° - 90° = +180° dari posisi awal Utara, mengarah tepat ke arah sebaliknya, yaitu <strong>Selatan</strong>.</div>\n        </div>\n    </div>\n    \n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-7\" data-soal-num=\"7\" data-key=\"A\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #7</span>\n                <span class=\"hk-soal-category-tag\">Psikotes Logika Aritmatika • Rasio Pekerja & Waktu</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-7\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">Sebuah proyek gedung dapat diselesaikan oleh 15 pekerja dalam waktu 30 hari. Jika kontraktor ingin proyek tersebut selesai hanya dalam waktu 10 hari, berapakah jumlah pekerja tambahan yang harus direkrut?</div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-7\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-7-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(7, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">30 orang</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-7-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(7, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">45 orang</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-7-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(7, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">15 orang</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-7-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(7, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">60 orang</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-7-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(7, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">25 orang</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-7\" onclick=\"checkArticleAnswer(7)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-7\" onclick=\"toggleSoalExplanation('exp-7')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(7)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-7\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: A</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> Perbandingan berbalik nilai: $15 \\times 30 = X \\times 10 \\rightarrow X = 45 \\text{ pekerja total}$. Pekerja tambahan = $45 - 15 = \\mathbf{30 \\text{ orang}}$.</div>\n        </div>\n    </div>\n    \n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-8\" data-soal-num=\"8\" data-key=\"B\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #8</span>\n                <span class=\"hk-soal-category-tag\">Psikotes Logika Kata • Lawan Kata (Antonim)</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-8\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">ANTONIM dari kata: <strong>PASIF</strong> adalah...</div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-8\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-8-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(8, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">STATIS</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-8-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(8, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">PROAKTIF</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-8-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(8, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">STABIL</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-8-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(8, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">NEGATIF</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-8-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(8, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">REAKTIF</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-8\" onclick=\"checkArticleAnswer(8)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-8\" onclick=\"toggleSoalExplanation('exp-8')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(8)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-8\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: B</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> Pasif berarti tidak aktif, hanya menerima saja tanpa inisiatif. Lawan kata yang paling tepat adalah <strong>Proaktif</strong>.</div>\n        </div>\n    </div>\n    \n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-9\" data-soal-num=\"9\" data-key=\"D\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #9</span>\n                <span class=\"hk-soal-category-tag\">Psikotes Analitis Logika • Kategori Benda Berbeda (Odd One Out)</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-9\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">Manakah di antara kata berikut yang TIDAK termasuk dalam kelompoknya?</div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-9\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-9-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(9, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">BCA</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-9-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(9, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">MANDIRI</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-9-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(9, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">BRI</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-9-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(9, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">BEI (Bursa Efek Indonesia)</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-9-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(9, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">BNI</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-9\" onclick=\"checkArticleAnswer(9)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-9\" onclick=\"toggleSoalExplanation('exp-9')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(9)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-9\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: D</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> BCA, Mandiri, BRI, dan BNI adalah lembaga perbankan komersial (Bank). Sedangkan BEI adalah penyelenggara pasar modal / bursa efek.</div>\n        </div>\n    </div>\n    \n\n    <div class=\"hk-interactive-soal\" id=\"soal-box-10\" data-soal-num=\"10\" data-key=\"B\">\n        <div class=\"hk-soal-header\">\n            <div style=\"display:flex; align-items:center; gap:8px;\">\n                <span class=\"hk-soal-number-badge\">Latihan Soal #10</span>\n                <span class=\"hk-soal-category-tag\">Psikotes Kraepelin • Manajemen Emosi Saat Kelelahan</span>\n            </div>\n            <span class=\"hk-soal-status-badge\" id=\"soal-status-10\" style=\"display:none; font-size:12px; font-weight:700;\"></span>\n        </div>\n        <div class=\"hk-soal-text\">Ketika aba-aba 'Pindah!' diteriakkan dan Anda baru menyelesaikan setengah kolom sedangkan peserta di samping Anda tampak jauh lebih cepat, respon psikologis paling efektif adalah...</div>\n        <div class=\"hk-soal-options-group\" id=\"options-group-10\">\n            <button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-10-A\" data-letter=\"A\" onclick=\"selectArticleAnswer(10, 'A')\">\n            <span class=\"hk-soal-opt-badge\">A</span>\n            <span class=\"hk-soal-opt-label\">Panik dan langsung mempercepat tulisan tanpa memperhatikan keakuratan penjumlahan.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-10-B\" data-letter=\"B\" onclick=\"selectArticleAnswer(10, 'B')\">\n            <span class=\"hk-soal-opt-badge\">B</span>\n            <span class=\"hk-soal-opt-label\">Tetap tenang, langsung pindah ke kolom baru tanpa menoleh ke kolom sebelumnya, dan mempertahankan ritme stabil sesuai kemampuan diri sendiri.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-10-C\" data-letter=\"C\" onclick=\"selectArticleAnswer(10, 'C')\">\n            <span class=\"hk-soal-opt-badge\">C</span>\n            <span class=\"hk-soal-opt-label\">Berhenti mengerjakan dan menunggu sesi istirahat.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-10-D\" data-letter=\"D\" onclick=\"selectArticleAnswer(10, 'D')\">\n            <span class=\"hk-soal-opt-badge\">D</span>\n            <span class=\"hk-soal-opt-label\">Mencoba menyontek kolom jawaban peserta di sebelah.</span>\n        </button>\n<button type=\"button\" class=\"hk-soal-opt-btn\" id=\"opt-btn-10-E\" data-letter=\"E\" onclick=\"selectArticleAnswer(10, 'E')\">\n            <span class=\"hk-soal-opt-badge\">E</span>\n            <span class=\"hk-soal-opt-label\">Mengisi jawaban secara acak di baris tersisa pada kolom sebelumnya.</span>\n        </button>\n        </div>\n        <div class=\"hk-soal-action-row\" style=\"display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-top:14px;\">\n            <button type=\"button\" class=\"hk-btn hk-btn-primary hk-btn-sm\" id=\"btn-check-10\" onclick=\"checkArticleAnswer(10)\" disabled>\n                Periksa Jawaban\n            </button>\n            <button type=\"button\" class=\"hk-soal-toggle-btn\" id=\"btn-toggle-10\" onclick=\"toggleSoalExplanation('exp-10')\">\n                <svg width=\"14\" height=\"14\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"></circle><polyline points=\"12 16 12 12 12 8\"></polyline></svg>\n                <span>Kunci &amp; Pembahasan</span>\n            </button>\n            <button type=\"button\" class=\"hk-btn hk-btn-subtle hk-btn-sm\" onclick=\"resetArticleAnswer(10)\" style=\"margin-left:auto;\">\n                Ulangi Soal\n            </button>\n        </div>\n        <div class=\"hk-soal-explanation is-hidden\" id=\"exp-10\">\n            <span class=\"hk-soal-kunci-badge\">Kunci Jawaban Resmi: B</span>\n            <div style=\"margin-top: 6px; font-size:13.5px; line-height:1.65;\"><strong>Pembahasan:</strong> Karakteristik yang dinilai psikolog dalam tes koran adalah ketahanan terhadap tekanan (*resilience*) dan fokus internal. Memaksakan diri mengejar kecepatan orang lain akan merusak akurasi dan menciptakan grafik zigzag ekstrem yang berujung pada penilaian ketidakstabilan emosional.</div>\n        </div>\n    </div>\n    \n        "},"interview":{"title":"20 Pertanyaan Interview HRD Paling Sering Muncul & Cara Menjawab dengan Metode STAR","category":"Wawancara Kerja","catClass":"hk-tk-icon-amber","badgeBg":"#f59e0b","date":"15 Okt 2026","readTime":"14 Menit Baca","author":"Head of Talent Acquisition Hakajobs","banner":"https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=1000&auto=format&fit=crop&q=80","toc":[{"id":"metode-star","label":"1. Konsep & Rumus Metode STAR"},{"id":"etika-bahasa-tubuh","label":"2. Bahasa Tubuh & Etika Wawancara Offline vs Online"},{"id":"10-pertanyaan","label":"3. 10 Pertanyaan Wawancara Inti & Contoh Jawaban Sempurna"},{"id":"pertanyaan-balik","label":"4. Trik Bertanya Balik ke HRD di Sesi Akhir"}],"body":"\n            <div class=\"hk-callout-box\">\n                <strong>📌 Rahasia Wawancara:</strong> Wawancara kerja bukan ajang interogasi menguji hafalan, melainkan dialog bisnis dua arah untuk mencocokkan apakah kepribadian dan keahlian Anda dapat menyelesaikan masalah perusahaan. Kuasai <strong>Metode STAR</strong> untuk menjawab setiap pertanyaan berbasis perilaku dengan percaya diri.\n            </div>\n\n            <h2 id=\"metode-star\">1. Konsep &amp; Rumus Metode STAR (Situation, Task, Action, Result)</h2>\n            <p>Metode STAR adalah teknik teruji secara internasional untuk merespons pertanyaan wawancara berbasis perilaku (*Behavioral Interview Questions*):</p>\n            <ul>\n                <li><strong>Situation (Situasi - 15% waktu)</strong>: Gambarkan latar belakang masalah atau tantangan spesifik yang pernah Anda hadapi di masa lalu. Buatlah ringkas dan berkonteks jelas.</li>\n                <li><strong>Task (Tugas - 15% waktu)</strong>: Jelaskan tanggung jawab spesifik apa yang harus Anda selesaikan dalam situasi tersebut.</li>\n                <li><strong>Action (Aksi Nyata - 50% waktu)</strong>: Ini adalah bagian paling penting. Uraikan langkah konkret apa yang <em>Anda sendiri</em> ambil untuk mengatasi masalah tersebut. Gunakan kata \"Saya\" (bukan hanya \"Kami\").</li>\n                <li><strong>Result (Hasil Akhir - 20% waktu)</strong>: Paparkan hasil positif yang dicapai. Sertakan data angka atau metrik kuantitatif (contoh: efisiensi waktu 30%, kenaikan omzet 20%, atau penghargaan dari atasan).</li>\n            </ul>\n\n            <h2 id=\"etika-bahasa-tubuh\">2. Bahasa Tubuh &amp; Etika Wawancara Offline vs Online</h2>\n            <ul>\n                <li><strong>Wawancara Tatap Muka (Offline)</strong>: Jabat tangan tegas (firm handshake), tersenyum hangat, tatap mata pewawancara (eye contact) secara wajar tanpa melotot, dan letakkan kedua tangan di atas paha atau meja dengan santai tanpa melipat tangan di dada.</li>\n                <li><strong>Wawancara Daring (Online via Zoom / GMeet)</strong>: Posisikan kamera sejajar dengan mata (eye level), pastikan pencahayaan terang dari arah depan (bukan backlight), gunakan mikrofon/headset jernih, dan lihat langsung ke lensa webcam saat Anda sedang berbicara (bukan melihat gambar diri sendiri di layar).</li>\n            </ul>\n\n            <h2 id=\"10-pertanyaan\">3. 10 Pertanyaan Wawancara Inti Beserta Contoh Jawaban Sempurna</h2>\n            <p>Berikut adalah 10 pertanyaan wawancara paling sering muncul di perusahaan BUMN, multinasional, dan swasta lengkap dengan jebakan yang harus dihindari serta contoh jawaban terbaik:</p>\n\n            \n    <div class=\"hk-soal-box\" id=\"interview-1\">\n        <div class=\"hk-soal-header\">\n            <span class=\"hk-soal-number-badge\">Pertanyaan 1: 'Ceritakan tentang diri Anda!'</span>\n            <span class=\"hk-soal-category-tag\">Pertanyaan Pembuka (Ice Breaking & Elevator Pitch)</span>\n        </div>\n        <div style=\"background:#fff1f2; border:1px solid #fecdd3; border-radius:8px; padding:10px 14px; margin-bottom:12px; font-size:13px; color:#9f1239;\">\n            <strong>⚠️ Jebakan yang Harus Dihindari:</strong> Menceritakan riwayat hidup dari SD atau menyebutkan hobi yang tidak relevan dengan pekerjaan.\n        </div>\n        <div style=\"font-size:14px; line-height:1.65; color:var(--hk-text-main);\">\n            <strong>✅ Panduan Jawaban Terbaik &amp; Contoh Naskah:</strong>\n            <div style=\"margin-top:8px;\">Gunakan rumus <strong>Present (Masa Kini) &rarr; Past (Masa Lalu) &rarr; Future (Masa Depan)</strong> dalam waktu 90 detik:\n<div class=\"hk-template-display-box\">\"Terima kasih atas kesempatannya Bapak/Ibu. Saat ini saya adalah seorang fresh graduate S1 Manajemen Bisnis dari Universitas Lampung dengan fokus pada Manajemen Sumber Daya Manusia dan operasional bisnis. \n\nSelama masa perkuliahan, saya aktif memimpin divisi rekrutmen organisasi mahasiswa di mana saya mengelola seleksi lebih dari 150 pendaftar. Saya juga telah menyelesaikan magang di PT XYZ sebagai HR Assistant selama 6 bulan, di mana saya berhasil mempercepat proses screening awal berkas pelamar sebesar 25% menggunakan template evaluasi baru.\n\nSaya sangat antusias dengan posisi HR Officer di perusahaan ini karena reputasi perusahaan dalam budaya kerja kolaboratif dan saya ingin mendedikasikan kemampuan analisis talenta saya untuk memajukan divisi SDM perusahaan.\"</div></div>\n        </div>\n    </div>\n\n\n    <div class=\"hk-soal-box\" id=\"interview-2\">\n        <div class=\"hk-soal-header\">\n            <span class=\"hk-soal-number-badge\">Pertanyaan 2: 'Apa kelebihan terbesar Anda?'</span>\n            <span class=\"hk-soal-category-tag\">Pertanyaan Kekuatan Diri (Self-Awareness & Value Proposition)</span>\n        </div>\n        <div style=\"background:#fff1f2; border:1px solid #fecdd3; border-radius:8px; padding:10px 14px; margin-bottom:12px; font-size:13px; color:#9f1239;\">\n            <strong>⚠️ Jebakan yang Harus Dihindari:</strong> Menyebutkan klaim klise tanpa bukti: 'Saya orangnya pekerja keras dan jujur'.\n        </div>\n        <div style=\"font-size:14px; line-height:1.65; color:var(--hk-text-main);\">\n            <strong>✅ Panduan Jawaban Terbaik &amp; Contoh Naskah:</strong>\n            <div style=\"margin-top:8px;\">Sebutkan keahlian spesifik yang selaras dengan kualifikasi loker, lalu sertakan contoh proyek nyata:\n<div class=\"hk-template-display-box\">\"Kelebihan utama saya adalah ketelitian data dan pemecahan masalah secara analitis. Ketika menangani laporan audit persediaan di tempat magang sebelumnya, saya menemukan selisih pencatatan stok senilai puluhan juta rupiah yang terlewatkan selama 2 bulan. Saya membuat formula rekonsiliasi otomatis di spreadsheet yang memangkas waktu pengecekan bulanan dari 3 hari menjadi 4 jam saja.\"</div></div>\n        </div>\n    </div>\n\n\n    <div class=\"hk-soal-box\" id=\"interview-3\">\n        <div class=\"hk-soal-header\">\n            <span class=\"hk-soal-number-badge\">Pertanyaan 3: 'Apa kelemahan terbesar Anda?'</span>\n            <span class=\"hk-soal-category-tag\">Pertanyaan Kejujuran & Upaya Perbaikan</span>\n        </div>\n        <div style=\"background:#fff1f2; border:1px solid #fecdd3; border-radius:8px; padding:10px 14px; margin-bottom:12px; font-size:13px; color:#9f1239;\">\n            <strong>⚠️ Jebakan yang Harus Dihindari:</strong> Mengaku tidak punya kelemahan, atau memberi kelemahan palsu: 'Saya terlalu perfeksionis'.\n        </div>\n        <div style=\"font-size:14px; line-height:1.65; color:var(--hk-text-main);\">\n            <strong>✅ Panduan Jawaban Terbaik &amp; Contoh Naskah:</strong>\n            <div style=\"margin-top:8px;\">Pilih kelemahan profesional yang nyata, namun bukan kualifikasi inti pekerjaan, lalu jelaskan langkah konkret yang sedang Anda ambil untuk mengatasinya:\n<div class=\"hk-template-display-box\">\"Di masa lalu, saya cenderung merasa cemas ketika harus melakukan presentasi spontan di depan forum besar tanpa persiapan panjang. Untuk memperbaiki hal tersebut, dalam 6 bulan terakhir saya aktif bergabung dengan klub public speaking Toastmasters dan secara sukarela mengambil peran sebagai juru bicara kelompok proyek. Langkah ini membantu saya jauh lebih tenang dan percaya diri dalam menyampaikan gagasan secara terstruktur.\"</div></div>\n        </div>\n    </div>\n\n\n    <div class=\"hk-soal-box\" id=\"interview-4\">\n        <div class=\"hk-soal-header\">\n            <span class=\"hk-soal-number-badge\">Pertanyaan 4: 'Mengapa Anda tertarik bekerja di perusahaan kami?'</span>\n            <span class=\"hk-soal-category-tag\">Pertanyaan Riset & Keselarasan Motivasi</span>\n        </div>\n        <div style=\"background:#fff1f2; border:1px solid #fecdd3; border-radius:8px; padding:10px 14px; margin-bottom:12px; font-size:13px; color:#9f1239;\">\n            <strong>⚠️ Jebakan yang Harus Dihindari:</strong> Menjawab karena ingin cari pengalaman, atau karena lokasinya dekat rumah.\n        </div>\n        <div style=\"font-size:14px; line-height:1.65; color:var(--hk-text-main);\">\n            <strong>✅ Panduan Jawaban Terbaik &amp; Contoh Naskah:</strong>\n            <div style=\"margin-top:8px;\">Tunjukkan bahwa Anda telah meriset produk, inovasi, atau prestasi perusahaan:\n<div class=\"hk-template-display-box\">\"Saya telah mengikuti perkembangan perusahaan ini sejak meluncurkan inisiatif digitalisasi logistik tahun lalu. Saya sangat mengagumi komitmen perusahaan terhadap efisiensi rantai pasok dan keberlanjutan lingkungan. Berbekal latar belakang saya di bidang supply chain dan sertifikasi manajemen logistik, saya ingin terlibat langsung dalam mengoptimalkan jalur distribusi regional perusahaan di area Sumatera.\"</div></div>\n        </div>\n    </div>\n\n\n    <div class=\"hk-soal-box\" id=\"interview-5\">\n        <div class=\"hk-soal-header\">\n            <span class=\"hk-soal-number-badge\">Pertanyaan 5: 'Ceritakan situasi saat Anda menghadapi kegagalan atau tekanan kerja berat!'</span>\n            <span class=\"hk-soal-category-tag\">Behavioral Question (Wajib Metode STAR)</span>\n        </div>\n        <div style=\"background:#fff1f2; border:1px solid #fecdd3; border-radius:8px; padding:10px 14px; margin-bottom:12px; font-size:13px; color:#9f1239;\">\n            <strong>⚠️ Jebakan yang Harus Dihindari:</strong> Menyalahkan orang lain atau rekan satu tim atas kegagalan tersebut.\n        </div>\n        <div style=\"font-size:14px; line-height:1.65; color:var(--hk-text-main);\">\n            <strong>✅ Panduan Jawaban Terbaik &amp; Contoh Naskah:</strong>\n            <div style=\"margin-top:8px;\">Gunakan metode STAR (Situation, Task, Action, Result):\n<div class=\"hk-template-display-box\">\"<strong>Situation:</strong> Pada proyek peluncuran aplikasi mobile kampus, kami menghadapi kemunduran jadwal 2 minggu karena dua programmer utama jatuh sakit.\n<strong>Task:</strong> Sebagai koordinator proyek, saya bertanggung jawab memastikan aplikasi tetap meluncur sesuai jadwal pendaftaran mahasiswa baru.\n<strong>Action:</strong> Saya segera mengaudit sisa fitur, membagi beban kerja secara modular, dan memprioritaskan fitur minimum viable product (MVP) yang paling krusial. Saya juga turun tangan langsung melakukan QA testing setiap malam.\n<strong>Result:</strong> Aplikasi berhasil dirilis tepat waktu dengan tingkat kepuasan pengguna 94% dan fitur pelengkap kami luncurkan bertahap di update patch berikutnya.\"</div></div>\n        </div>\n    </div>\n\n\n    <div class=\"hk-soal-box\" id=\"interview-6\">\n        <div class=\"hk-soal-header\">\n            <span class=\"hk-soal-number-badge\">Pertanyaan 6: 'Bagaimana Anda menghadapi rekan kerja yang tidak kooperatif?'</span>\n            <span class=\"hk-soal-category-tag\">Pertanyaan Kerjasama Tim & Manajemen Konflik</span>\n        </div>\n        <div style=\"background:#fff1f2; border:1px solid #fecdd3; border-radius:8px; padding:10px 14px; margin-bottom:12px; font-size:13px; color:#9f1239;\">\n            <strong>⚠️ Jebakan yang Harus Dihindari:</strong> Menghindari rekan tersebut atau langsung mengadu ke atasan.\n        </div>\n        <div style=\"font-size:14px; line-height:1.65; color:var(--hk-text-main);\">\n            <strong>✅ Panduan Jawaban Terbaik &amp; Contoh Naskah:</strong>\n            <div style=\"margin-top:8px;\">Tunjukkan kedewasaan komunikasi dan empati profesional:\n<div class=\"hk-template-display-box\">\"Saya selalu mengutamakan komunikasi personal empatik terlebih dahulu. Saya akan mengajak rekan kerja tersebut berdiskusi empat mata untuk memahami kendala yang sedang dihadapinya, apakah ada hambatan teknis atau beban kerja yang tidak seimbang. Kemudian kami menyepakati batas tanggung jawab masing-masing secara tertulis agar selaras dengan target divisi tanpa menimbulkan gesekan emosional.\"</div></div>\n        </div>\n    </div>\n\n\n    <div class=\"hk-soal-box\" id=\"interview-7\">\n        <div class=\"hk-soal-header\">\n            <span class=\"hk-soal-number-badge\">Pertanyaan 7: 'Mengapa Anda berhenti dari pekerjaan Anda sebelumnya?'</span>\n            <span class=\"hk-soal-category-tag\">Pertanyaan Integritas & Loyalitas</span>\n        </div>\n        <div style=\"background:#fff1f2; border:1px solid #fecdd3; border-radius:8px; padding:10px 14px; margin-bottom:12px; font-size:13px; color:#9f1239;\">\n            <strong>⚠️ Jebakan yang Harus Dihindari:</strong> Membicarakan keburukan mantan atasan, gaji kecil, atau gosip kantor.\n        </div>\n        <div style=\"font-size:14px; line-height:1.65; color:var(--hk-text-main);\">\n            <strong>✅ Panduan Jawaban Terbaik &amp; Contoh Naskah:</strong>\n            <div style=\"margin-top:8px;\">Fokuskan pada dorongan mencari tantangan baru dan pertumbuhan profesional:\n<div class=\"hk-template-display-box\">\"Saya sangat bersyukur atas pengalaman dan ilmu yang saya peroleh selama 2 tahun di perusahaan sebelumnya. Namun saat ini saya merasa siap untuk mengambil tanggung jawab yang lebih luas di skala operasional yang lebih besar, dan profil posisi di perusahaan Bapak/Ibu menawarkan ruang pertumbuhan karir yang sangat selaras dengan tujuan jangka panjang saya.\"</div></div>\n        </div>\n    </div>\n\n\n    <div class=\"hk-soal-box\" id=\"interview-8\">\n        <div class=\"hk-soal-header\">\n            <span class=\"hk-soal-number-badge\">Pertanyaan 8: 'Di mana Anda melihat diri Anda dalam 3 hingga 5 tahun ke depan?'</span>\n            <span class=\"hk-soal-category-tag\">Pertanyaan Visi Karir & Stabilitas</span>\n        </div>\n        <div style=\"background:#fff1f2; border:1px solid #fecdd3; border-radius:8px; padding:10px 14px; margin-bottom:12px; font-size:13px; color:#9f1239;\">\n            <strong>⚠️ Jebakan yang Harus Dihindari:</strong> Menjawab ingin punya bisnis sendiri tahun depan atau 'tidak tahu'.\n        </div>\n        <div style=\"font-size:14px; line-height:1.65; color:var(--hk-text-main);\">\n            <strong>✅ Panduan Jawaban Terbaik &amp; Contoh Naskah:</strong>\n            <div style=\"margin-top:8px;\">Tunjukkan komitmen jangka menengah yang selaras dengan jenjang karir perusahaan:\n<div class=\"hk-template-display-box\">\"Dalam 2 tahun pertama, fokus saya adalah menguasai seluruh alur operasional di posisi ini dan membuktikan performa kerja melampaui target KPI. Dalam 3 hingga 5 tahun ke depan, saya bercita-cita mengembangkan kompetensi kepemimpinan agar dapat memegang tanggung jawab sebagai Senior Specialist atau Team Lead yang mampu membimbing talenta-talenta baru di divisi ini.\"</div></div>\n        </div>\n    </div>\n\n\n    <div class=\"hk-soal-box\" id=\"interview-9\">\n        <div class=\"hk-soal-header\">\n            <span class=\"hk-soal-number-badge\">Pertanyaan 9: 'Berapa ekspektasi gaji Anda?'</span>\n            <span class=\"hk-soal-category-tag\">Pertanyaan Negosiasi Kompensasi</span>\n        </div>\n        <div style=\"background:#fff1f2; border:1px solid #fecdd3; border-radius:8px; padding:10px 14px; margin-bottom:12px; font-size:13px; color:#9f1239;\">\n            <strong>⚠️ Jebakan yang Harus Dihindari:</strong> Menjawab 'Terserah perusahaan' atau meminta angka tanpa dasar riset.\n        </div>\n        <div style=\"font-size:14px; line-height:1.65; color:var(--hk-text-main);\">\n            <strong>✅ Panduan Jawaban Terbaik &amp; Contoh Naskah:</strong>\n            <div style=\"margin-top:8px;\">Berikan rentang realistis berdasarkan riset upah pasar dan tanyakan paket benefit keseluruhan:\n<div class=\"hk-template-display-box\">\"Berdasarkan riset saya terhadap standar gaji posisi ini di wilayah setempat serta mempertimbangkan kualifikasi dan pengalaman yang saya miliki, ekspektasi saya berada di rentang Rp 5.500.000 hingga Rp 7.000.000 per bulan. Namun saya tentu sangat fleksibel dan terbuka untuk mendiskusikan penawaran paket benefit, asuransi, dan peluang jenjang karir yang disediakan perusahaan.\"</div></div>\n        </div>\n    </div>\n\n\n    <div class=\"hk-soal-box\" id=\"interview-10\">\n        <div class=\"hk-soal-header\">\n            <span class=\"hk-soal-number-badge\">Pertanyaan 10: 'Apakah ada pertanyaan yang ingin Anda tanyakan kepada kami?'</span>\n            <span class=\"hk-soal-category-tag\">Pertanyaan Penutup Penentu (Wajib Bertanya)</span>\n        </div>\n        <div style=\"background:#fff1f2; border:1px solid #fecdd3; border-radius:8px; padding:10px 14px; margin-bottom:12px; font-size:13px; color:#9f1239;\">\n            <strong>⚠️ Jebakan yang Harus Dihindari:</strong> Menjawab 'Tidak ada, sudah cukup jelas'.\n        </div>\n        <div style=\"font-size:14px; line-height:1.65; color:var(--hk-text-main);\">\n            <strong>✅ Panduan Jawaban Terbaik &amp; Contoh Naskah:</strong>\n            <div style=\"margin-top:8px;\">Ajukan 2-3 pertanyaan berkualitas tinggi yang menunjukkan Anda serius dan antusias:\n<div class=\"hk-template-display-box\">1. \"Apa tolok ukur keberhasilan utama untuk orang yang mengisi posisi ini dalam 3 bulan pertama masa percobaan?\"\n2. \"Bagaimana budaya kerja tim dalam menghadapi tantangan target yang ketat?\"\n3. \"Apa tahapan selanjutnya dari proses rekrutmen ini dan kapan saya bisa mengantisipasi kabar berikutnya?\"</div></div>\n        </div>\n    </div>\n\n\n            <h2 id=\"pertanyaan-balik\">4. Trik Mengajukan Pertanyaan Balik ke HRD di Sesi Akhir</h2>\n            <p>Ketika pewawancara bertanya: <em>\"Apakah ada yang ingin Anda tanyakan kepada kami?\"</em>, <strong>JANGAN PERNAH MENJAWAB \"TIDAK ADA\"</strong>. Tidak bertanya memberi kesan bahwa Anda tidak antusias atau pasif. Ajukan pertanyaan yang menggali ekspektasi posisi kerja tersebut untuk meninggalkan kesan profesional yang kuat.</p>\n        "},"k3":{"title":"Panduan Lengkap Sertifikasi Ahli K3 Umum Kemenaker untuk Fresh Graduate & Profesional","category":"Sertifikasi Profesi","catClass":"hk-tk-icon-blue","badgeBg":"#0284c7","date":"12 Okt 2026","readTime":"9 Menit Baca","author":"Instruktur K3 Profesional Hakajobs","banner":"https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=1000&auto=format&fit=crop&q=80","toc":[{"id":"dasar-hukum","label":"1. Landasan Hukum Wajib K3 di Indonesia"},{"id":"syarat-pelatihan","label":"2. Syarat & Alur Pembinaan 12 Hari Kerja"},{"id":"materi-modul","label":"3. 12 Modul Pembinaan Ahli K3 Umum"},{"id":"peluang-gaji","label":"4. Peluang Karir & Standar Gaji Pemegang Sertifikat"}],"body":"\n            <div class=\"hk-callout-box\">\n                <strong>📌 Kenapa Sertifikat K3 Sangat Dicari?</strong> Berdasarkan UU No. 1 Tahun 1970 dan Permenaker No. 04/MEN/1987, setiap tempat kerja dengan lebih dari 100 karyawan atau memiliki potensi bahaya tinggi (konstruksi, manufaktur, migas, tambang, rumah sakit) <strong>wajib memiliki minimal satu Ahli K3 Umum bersertifikat resmi Kemenaker</strong>.\n            </div>\n\n            <h2 id=\"dasar-hukum\">1. Landasan Hukum &amp; Pentingnya Ahli K3 Umum</h2>\n            <p>Keselamatan dan Kesehatan Kerja (K3) adalah pilar mutlak operasional industri modern. Ahli K3 Umum ditunjuk oleh Menteri Ketenagakerjaan untuk mengawasi langsung ditaatinya peraturan perundang-undangan K3 di tempat kerja guna mencegah terjadinya kecelakaan kerja (*zero accident*) dan penyakit akibat kerja (PAK).</p>\n\n            <h2 id=\"syarat-pelatihan\">2. Persyaratan &amp; Alur Pembinaan 12 Hari</h2>\n            <ol>\n                <li><strong>Persyaratan Pendidikan</strong>: Minimal lulusan Diploma Tiga (D3) atau Sarjana (S1) dari semua jurusan teknik maupun non-teknik.</li>\n                <li><strong>Alur Pembinaan</strong>: Melalui Perusahaan Jasa K3 (PJK3) resmi yang ditunjuk Kemnaker selama 12 hari kerja intensif (sekitar 120 jam pelajaran).</li>\n                <li><strong>Tahapan Evaluasi</strong>: Ujian Pre-test & Post-test tertulis Kemenaker, observasi Praktik Kerja Lapangan (PKL) di pabrik/proyek nyata, penulisan laporan PKL, serta seminar sidang laporan di hadapan pengawas Kemnaker.</li>\n            </ol>\n\n            <h2 id=\"materi-modul\">3. Materi Pokok Pembinaan Ahli K3 Umum</h2>\n            <ul>\n                <li>Kebijakan Nasional K3 dan Dasar-Dasar Keselamatan Kerja.</li>\n                <li>K3 Mekanik, Pesawat Uap, Bejana Tekan, dan Tangki Timbun.</li>\n                <li>K3 Instalasi Listrik dan Proteksi Kebakaran (APAR & Hydrant).</li>\n                <li>K3 Konstruksi Bangunan dan Lingkungan Kerja (P3K & Higiene Industri).</li>\n                <li>Manajemen Risiko (HIRADC / JSA) dan Investigasi Kecelakaan Kerja.</li>\n                <li>Sistem Manajemen K3 (SMK3) berdasarkan Peraturan Pemerintah No. 50 Tahun 2012.</li>\n            </ul>\n\n            <h2 id=\"peluang-gaji\">4. Peluang Karir &amp; Standar Gaji</h2>\n            <p>Bagi lulusan baru (*fresh graduate*), memiliki lisensi Ahli K3 Umum Kemnaker melipatgandakan peluang panggilan kerja di posisi <em>HSE Officer, Safety Inspector, K3 Specialist, dan Compliance Officer</em> dengan rentang gaji awal Rp 5.000.000 hingga Rp 9.000.000 per bulan, dan mencapai belasan juta rupiah di sektor tambang dan migas.</p>\n        "},"toefl":{"title":"Panduan Skor TOEFL ITP, Prediction, dan IELTS untuk Syarat BUMN & CPNS 2026","category":"Sertifikasi Bahasa","catClass":"hk-tk-icon-emerald","badgeBg":"#10b981","date":"10 Okt 2026","readTime":"8 Menit Baca","author":"Konsultan Edukasi Bahasa Hakajobs","banner":"https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=1000&auto=format&fit=crop&q=80","toc":[{"id":"beda-toefl","label":"1. Perbedaan Mendasar TOEFL ITP, Prediction, dan IELTS"},{"id":"standar-bumn","label":"2. Standar Skor Minimum BUMN & Kementerian CPNS"},{"id":"trik-30-hari","label":"3. Roadmap Belajar 30 Hari Mendongkrak Skor 500+"}],"body":"\n            <div class=\"hk-callout-box\">\n                <strong>📌 Jangan Sampai Salah Ikut Tes:</strong> Banyak pelamar gugur administrasi di Rekrutmen Bersama BUMN (RBB) atau CPNS Kementerian Luar Negeri karena mengunggah sertifikat TOEFL Prediction padahal instansi mewajibkan sertifikat resmi **TOEFL ITP resmi ETS**. Pahami ketentuannya secara tepat.\n            </div>\n\n            <h2 id=\"beda-toefl\">1. Perbedaan Mendasar TOEFL ITP, Prediction, dan IELTS</h2>\n            <ul>\n                <li><strong>TOEFL ITP (Institutional Testing Program)</strong>: Dikeluarkan langsung oleh institusi resmi Educational Testing Service (ETS) Amerika Serikat melalui lembaga bahasa berlisensi di Indonesia. Skor berkisar 310 - 677. Format Paper-Based Test (PBT) terdiri dari Listening Comprehension, Structure & Written Expression, dan Reading Comprehension.</li>\n                <li><strong>TOEFL Prediction</strong>: Ujian simulasi yang diselenggarakan oleh lembaga kursus lokal. Biaya jauh lebih murah (Rp 50.000 - Rp 150.000), namun <em>hanya diterima oleh sebagian perusahaan swasta lokal</em> dan ditolak oleh instansi pemerintah resmi.</li>\n                <li><strong>IELTS (International English Language Testing System)</strong>: Dikelola oleh British Council / IDP dengan rentang band skor 1.0 - 9.0. Menguji 4 kemampuan lengkap termasuk Speaking dan Writing langsung dengan penutur asli.</li>\n            </ul>\n\n            <h2 id=\"standar-bumn\">2. Standar Skor Minimum Rekrutmen Bersama BUMN (RBB) &amp; CPNS</h2>\n            <table style=\"width:100%; border-collapse:collapse; margin:20px 0; font-size:13.5px;\">\n                <thead>\n                    <tr style=\"background:#f1f5f9; border-bottom:2px solid #cbd5e1;\">\n                        <th style=\"padding:10px 14px; text-align:left;\">Instansi / Perusahaan</th>\n                        <th style=\"padding:10px 14px; text-align:left;\">Jenis Sertifikat yang Diterima</th>\n                        <th style=\"padding:10px 14px; text-align:left;\">Skor Minimal</th>\n                    </tr>\n                </thead>\n                <tbody>\n                    <tr style=\"border-bottom:1px solid #e2e8f0;\">\n                        <td style=\"padding:10px 14px; font-weight:700;\">PT Pertamina (Persero)</td>\n                        <td style=\"padding:10px 14px;\">TOEFL ITP / IELTS Resmi</td>\n                        <td style=\"padding:10px 14px;\">500 (ITP) / 6.0 (IELTS)</td>\n                    </tr>\n                    <tr style=\"border-bottom:1px solid #e2e8f0;\">\n                        <td style=\"padding:10px 14px; font-weight:700;\">PT Telkom Indonesia</td>\n                        <td style=\"padding:10px 14px;\">TOEFL ITP / TOEIC</td>\n                        <td style=\"padding:10px 14px;\">500 (ITP) / 650 (TOEIC)</td>\n                    </tr>\n                    <tr style=\"border-bottom:1px solid #e2e8f0;\">\n                        <td style=\"padding:10px 14px; font-weight:700;\">Bank Mandiri & BRI (BUMN)</td>\n                        <td style=\"padding:10px 14px;\">TOEFL ITP / Prediction Terakreditasi</td>\n                        <td style=\"padding:10px 14px;\">450 - 500</td>\n                    </tr>\n                    <tr style=\"border-bottom:1px solid #e2e8f0;\">\n                        <td style=\"padding:10px 14px; font-weight:700;\">Kementerian Luar Negeri (Kemenlu)</td>\n                        <td style=\"padding:10px 14px;\">TOEFL ITP / IELTS Resmi</td>\n                        <td style=\"padding:10px 14px;\">550 (ITP) / 6.5 (IELTS)</td>\n                    </tr>\n                </tbody>\n            </table>\n\n            <h2 id=\"trik-30-hari\">3. Roadmap Belajar 30 Hari Mendongkrak Skor 500+</h2>\n            <ul>\n                <li><strong>Minggu 1 (Fokus Structure & Written Expression)</strong>: Pelajari 15 aturan tata bahasa krusial: Subjek-Predikat Inversi, Penggunaan Klausa Relatif (*Who/Which/That*), Pola Parallel Structure, dan Concord/Agreement. Bagian Structure adalah bagian yang paling cepat ditingkatkan nilainya dalam waktu singkat!</li>\n                <li><strong>Minggu 2 (Listening Comprehension Part A)</strong>: Latih telinga Anda untuk menangkap sinonim kata pada pembicara kedua (*Second Speaker Strategy*). Kunci jawaban di Part A hampir selalu merupakan pengulangan kalimat pembicara kedua dalam kata lain.</li>\n                <li><strong>Minggu 3 (Reading Comprehension Skimming & Scanning)</strong>: Jangan membaca seluruh teks paragraf dari awal. Baca pertanyaan terlebih dahulu, temukan kata kunci utama, lalu lakukan scanning baris teks yang bersangkutan.</li>\n                <li><strong>Minggu 4 (Simulasi Full Test CAT)</strong>: Kerjakan minimal 3 paket simulasi lengkap 140 soal dalam batas waktu 115 menit tanpa jeda untuk membangun ketahanan fokus.</li>\n            </ul>\n        "},"bnsp":{"title":"Cara Memperoleh Sertifikat Profesi BNSP untuk Meningkatkan Nilai Tawar Gaji","category":"Sertifikasi Profesi","catClass":"hk-tk-icon-amber","badgeBg":"#f59e0b","date":"08 Okt 2026","readTime":"7 Menit Baca","author":"Konsultan Standar Kompetensi Hakajobs","banner":"https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=1000&auto=format&fit=crop&q=80","toc":[{"id":"apa-itu-bnsp","label":"1. Apa itu BNSP & Lembaga Sertifikasi Profesi (LSP)?"},{"id":"skema-populer","label":"2. Skema Kompetensi Paling Populer di Dunia Kerja"},{"id":"tahapan-asesmen","label":"3. Alur Pendaftaran & Tahapan Uji Asesmen"},{"id":"nilai-tambah","label":"4. Nilai Tambah pada Negosiasi Gaji"}],"body":"\n            <div class=\"hk-callout-box\">\n                <strong>📌 Mengapa Sertifikat BNSP Diakui Negara?</strong> Badan Nasional Sertifikasi Profesi (BNSP) adalah badan independen yang bertanggung jawab langsung kepada Presiden RI untuk menjamin kompetensi tenaga kerja Indonesia berdasarkan Standar Kompetensi Kerja Nasional Indonesia (SKKNI).\n            </div>\n\n            <h2 id=\"apa-itu-bnsp\">1. Mengenal BNSP &amp; Lembaga Sertifikasi Profesi (LSP)</h2>\n            <p>Sertifikat BNSP memiliki logo Garuda Pancasila emas resmi. Berbeda dengan sertifikat pelatihan (*Certificate of Attendance*) yang hanya menyatakan Anda pernah hadir kursus, Sertifikat Kompetensi BNSP membuktikan secara legal formal bahwa Anda <strong>KOMPETEN</strong> melakukan pekerjaan sesuai standar industri setelah diuji oleh Asesor bersertifikat.</p>\n\n            <h2 id=\"skema-populer\">2. Skema Kompetensi Paling Diminati Rekruter</h2>\n            <ul>\n                <li><strong>Digital Marketing</strong>: Pengelolaan kampanye iklan, SEO, dan media sosial.</li>\n                <li><strong>Human Resource Management (HRD)</strong>: Staf Rekrutmen, Payroll, dan Hubungan Industrial.</li>\n                <li><strong>Akuntansi &amp; Keuangan</strong>: Teknisi Akuntansi Yunior & Pengelola Pajak.</li>\n                <li><strong>Pengadaan Barang dan Jasa</strong>: Procurement Officer dan Logistik.</li>\n            </ul>\n\n            <h2 id=\"tahapan-asesmen\">3. Alur Pendaftaran &amp; Tahapan Uji Asesmen</h2>\n            <ol>\n                <li><strong>Pendaftaran via LSP Terlisensi</strong>: Memilih skema okupasi yang sesuai dengan latar belakang Anda.</li>\n                <li><strong>Pengisian Asesmen Mandiri (FR-APL-01 &amp; FR-APL-02)</strong>: Menandai bukti kompetensi yang telah Anda miliki.</li>\n                <li><strong>Pengumpulan Portofolio Bukti Kerja</strong>: Menyertakan contoh laporan kerja, surat rekomendasi atasan, karya desain, atau sertifikat pendukung.</li>\n                <li><strong>Pelaksanaan Asesmen (Uji Kompetensi)</strong>: Wawancara mendalam bersama Asesor, ujian tertulis/studi kasus, dan demonstrasi simulasi praktik kerja.</li>\n                <li><strong>Keputusan Asesmen</strong>: Dinyatakan K (Kompeten) atau BK (Belum Kompeten).</li>\n            </ol>\n\n            <h2 id=\"nilai-tambah\">4. Nilai Tambah pada Negosiasi Gaji</h2>\n            <p>Kandidat yang mencantumkan nomor registrasi sertifikat BNSP di resume memiliki keunggulan kompetitif di mata rekruter korporasi karena perusahaan tidak perlu mengeluarkan biaya pelatihan dasar lagi. Hal ini memberikan posisi tawar yang jauh lebih kuat saat bernegosiasi gaji pokok dan benefit awal.</p>\n        "}};

        window.openCareerArticle = function(slug) {
        var data = fullCareerArticles[slug];
        if (!data) return;

        var hub = document.getElementById('hk-career-hub-view');
        var view = document.getElementById('hk-career-article-view');
        if (hub && view) {
            hub.style.display = 'none';
            view.style.display = 'block';
        }

        var bcTitle = document.getElementById('hkArticleBreadcrumbTitle');
        if (bcTitle) bcTitle.textContent = data.title;

        var catBadge = document.getElementById('hkArticleCatBadge');
        if (catBadge) {
            catBadge.textContent = data.category;
            catBadge.style.background = data.badgeBg || '#0284c7';
        }

        var titleEl = document.getElementById('hkArticleMainTitle');
        if (titleEl) titleEl.textContent = data.title;

        var dateEl = document.getElementById('hkArticleDate');
        if (dateEl) dateEl.textContent = data.date;

        var timeEl = document.getElementById('hkArticleReadTime');
        if (timeEl) timeEl.textContent = data.readTime;

        var authorEl = document.getElementById('hkArticleAuthor');
        var customAuthor = <?php echo json_encode($tk_author_name); ?>;
        if (authorEl) authorEl.textContent = 'Oleh ' + (customAuthor || data.author || 'Tim Litbang Karir & Edukasi');

        var authorBoxName = document.getElementById('hkArticleAuthorBoxName');
        if (authorBoxName && customAuthor) {
            authorBoxName.textContent = customAuthor;
        }

        var bannerEl = document.getElementById('hkArticleBanner');
        if (bannerEl) {
            bannerEl.src = data.banner;
            bannerEl.alt = data.title;
        }

        var tocListEl = document.getElementById('hkArticleTocList');
        var tocBox = document.getElementById('hkArticleToc');
        if (tocListEl && data.toc && data.toc.length > 0) {
            tocBox.style.display = 'block';
            tocListEl.innerHTML = data.toc.map(function(item) {
                return '<li><a href="#' + item.id + '">' + item.label + '</a></li>';
            }).join('');
        } else if (tocBox) {
            tocBox.style.display = 'none';
        }

        var contentEl = document.getElementById('hkArticleFullContent');
        if (contentEl) {
            contentEl.innerHTML = data.body;
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    window.closeCareerArticle = function() {
        var hub = document.getElementById('hk-career-hub-view');
        var view = document.getElementById('hk-career-article-view');
        if (hub && view) {
            view.style.display = 'none';
            hub.style.display = 'block';
        }
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    window.toggleSoalExplanation = function(id) {
        var exp = document.getElementById(id);
        if (exp) {
            exp.classList.toggle('is-hidden');
        }
    };

    
        // ==========================================
        // Interactive Article Practice Exam Logic
        // ==========================================
        window.articleAnswers = {};

        window.selectArticleAnswer = function(num, letter) {
            if (!window.articleAnswers[num]) {
                window.articleAnswers[num] = {};
            }
            window.articleAnswers[num].selected = letter;

            var group = document.getElementById('options-group-' + num);
            if (group) {
                var buttons = group.querySelectorAll('.hk-soal-opt-btn');
                buttons.forEach(function(btn) {
                    btn.classList.remove('is-selected');
                });
            }

            var activeBtn = document.getElementById('opt-btn-' + num + '-' + letter);
            if (activeBtn) {
                activeBtn.classList.add('is-selected');
            }

            var checkBtn = document.getElementById('btn-check-' + num);
            if (checkBtn) {
                checkBtn.disabled = false;
            }
        };

        window.checkArticleAnswer = function(num) {
            var answerData = window.articleAnswers[num];
            if (!answerData || !answerData.selected) return;

            var box = document.getElementById('soal-box-' + num);
            if (!box) return;

            var correctKey = box.getAttribute('data-key');
            var isCorrect = (answerData.selected === correctKey);
            answerData.correct = correctKey;
            answerData.isCorrect = isCorrect;
            answerData.checked = true;

            var group = document.getElementById('options-group-' + num);
            if (group) {
                var buttons = group.querySelectorAll('.hk-soal-opt-btn');
                buttons.forEach(function(btn) {
                    btn.style.pointerEvents = 'none';
                });
            }

            var selectedBtn = document.getElementById('opt-btn-' + num + '-' + answerData.selected);
            var statusEl = document.getElementById('soal-status-' + num);

            if (isCorrect) {
                if (selectedBtn) selectedBtn.classList.add('is-correct');
                if (statusEl) {
                    statusEl.style.display = 'inline-block';
                    statusEl.innerHTML = '<span style="color:#059669; background:#ecfdf5; padding:3px 8px; border-radius:4px; border:1px solid #a7f3d0;">✅ Jawaban Benar (+5 Poin)</span>';
                }
            } else {
                if (selectedBtn) selectedBtn.classList.add('is-wrong');
                var correctBtn = document.getElementById('opt-btn-' + num + '-' + correctKey);
                if (correctBtn) correctBtn.classList.add('is-correct');
                if (statusEl) {
                    statusEl.style.display = 'inline-block';
                    statusEl.innerHTML = '<span style="color:#dc2626; background:#fef2f2; padding:3px 8px; border-radius:4px; border:1px solid #fecdd3;">❌ Kurang Tepat (Kunci: ' + correctKey + ')</span>';
                }
            }

            // Reveal explanation
            var exp = document.getElementById('exp-' + num);
            if (exp) {
                exp.classList.remove('is-hidden');
            }

            var checkBtn = document.getElementById('btn-check-' + num);
            if (checkBtn) {
                checkBtn.disabled = true;
                checkBtn.textContent = 'Selesai';
            }

            // Update Score Tracker
            updateArticleScoreTracker();
        };

        window.resetArticleAnswer = function(num) {
            delete window.articleAnswers[num];

            var box = document.getElementById('soal-box-' + num);
            if (!box) return;

            var group = document.getElementById('options-group-' + num);
            if (group) {
                var buttons = group.querySelectorAll('.hk-soal-opt-btn');
                buttons.forEach(function(btn) {
                    btn.classList.remove('is-selected', 'is-correct', 'is-wrong');
                    btn.style.pointerEvents = '';
                });
            }

            var statusEl = document.getElementById('soal-status-' + num);
            if (statusEl) statusEl.style.display = 'none';

            var exp = document.getElementById('exp-' + num);
            if (exp) exp.classList.add('is-hidden');

            var checkBtn = document.getElementById('btn-check-' + num);
            if (checkBtn) {
                checkBtn.disabled = true;
                checkBtn.textContent = 'Periksa Jawaban';
            }

            updateArticleScoreTracker();
        };

        window.resetAllArticleAnswers = function() {
            for (var i = 1; i <= 10; i++) {
                window.resetArticleAnswer(i);
            }
            showToast('Seluruh latihan soal telah di-reset!');
        };

        function updateArticleScoreTracker() {
            var display = document.getElementById('hk-exam-score-display');
            var status = document.getElementById('hk-exam-score-status');
            if (!display || !status) return;

            var totalAnswered = 0;
            var totalCorrect = 0;

            for (var num in window.articleAnswers) {
                var item = window.articleAnswers[num];
                if (item.checked) {
                    totalAnswered++;
                    if (item.isCorrect) totalCorrect++;
                }
            }

            var points = totalCorrect * 5;
            display.textContent = totalCorrect + ' / 10 Soal Benar (' + points + ' Poin)';

            if (totalAnswered === 0) {
                status.textContent = 'Pilih jawaban Anda (opsi A, B, C, D, E) pada tiap butir soal di bawah lalu klik "Periksa Jawaban" untuk mengecek ambang batas kelulusan Anda secara instan.';
            } else if (totalAnswered < 10) {
                status.innerHTML = 'Progress: <strong>' + totalAnswered + ' dari 10 soal terjawab</strong>. Selesaikan sisa soal untuk melihat evaluasi total passing grade.';
            } else {
                if (totalCorrect >= 7) {
                    status.innerHTML = '<span style="color:#059669; font-weight:800;">🎉 LUAR BIASA! Skor Anda Melampaui Nilai Ambang Batas (Passing Grade) Resmi BKN dengan Akurasi ' + (totalCorrect * 10) + '%. Pertahankan strategi eliminasi opsi ini!</span>';
                } else {
                    status.innerHTML = '<span style="color:#d97706; font-weight:800;">⚠️ Evaluasi: Skor Anda ' + points + ' poin. Pelajari kembali pembahasan di butir soal yang keliru untuk memperkuat konsep sebelum hari ujian CAT sesungguhnya.</span>';
                }
            }
        }

        // Real E-Book PDF Download trigger
        window.openEbookDownload = function() {
            var link = document.createElement('a');
            link.href = 'assets/downloads/E-Book-Kit-Persiapan-Kerja-2026.pdf';
            link.download = 'E-Book-Kit-Persiapan-Kerja-InfoLoker-Lampung-2026.pdf';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            showToast('E-Book Kit Persiapan Kerja 2026 (PDF Asli) berhasil diunduh ke komputer Anda!');
        };


    // 2. Multi-Soal Interactive Quiz Simulator
    var multiQuizDatabase = {
        twk: [
            {
                category: "CPNS SKD (Tes Wawasan Kebangsaan)",
                title: "Soal 1 dari 5: Pengamalan Sila Ke-3 Pancasila",
                question: "Penerapan nilai-nilai Pancasila dalam kehidupan berbangsa terus mengalami tantangan di era transformasi digital. Salah satu bentuk pengamalan sila ke-3 'Persatuan Indonesia' oleh seorang pencari kerja atau pekerja profesional adalah...",
                options: [
                    { id: "A", text: "Mengutamakan hanya bekerja dengan rekan kantor yang memiliki latar belakang suku dan daerah yang sama." },
                    { id: "B", text: "Menyebarkan informasi lowongan kerja yang belum diverifikasi ke grup WhatsApp demi membantu teman." },
                    { id: "C", text: "Menjaga etika komunikasi digital dengan tidak menyebarkan isu SARA dan narasi provokatif di lingkungan kerja dan media sosial." },
                    { id: "D", text: "Menolak berkompromi dalam proyek tim demi mempertahankan pendapat pribadi." }
                ],
                correct: "C",
                explanation: "Pengamalan Sila ke-3 (Persatuan Indonesia) menuntut sikap inklusif, menghormati keberagaman, dan menjaga keharmonisan dengan tidak menyebarkan ujaran kebencian di era digital."
            },
            {
                category: "CPNS SKD (Tes Wawasan Kebangsaan)",
                title: "Soal 2 dari 5: Integritas & Gratifikasi ASN",
                question: "Sebagai ASN bagian pengadaan, seorang vendor memberikan gawai mewah sebagai ucapan terima kasih setelah proyek selesai. Sikap integritas antikorupsi yang benar adalah...",
                options: [
                    { id: "A", text: "Menerima gawai tersebut karena proses tender sudah selesai secara sah." },
                    { id: "B", text: "Menolak bingkisan dengan santun atau melaporkannya ke Unit Pengendalian Gratifikasi (UPG)/KPK dalam tempo 30 hari." },
                    { id: "C", text: "Menjual gawai dan menyumbangkan uangnya ke panti asuhan." },
                    { id: "D", text: "Membagi-bagikan aksesoris gawai kepada rekan satu tim." }
                ],
                correct: "B",
                explanation: "Berdasarkan Pasal 12B UU No. 20 Tahun 2001, penerimaan barang oleh aparatur negara yang berkaitan dengan jabatannya wajib dilaporkan ke KPK dalam waktu 30 hari kerja."
            },
            {
                category: "CPNS SKD (Tes Wawasan Kebangsaan)",
                title: "Soal 3 dari 5: Bela Negara Era Digital",
                question: "Wujud nyata nilai dasar Bela Negara 'Kemampuan Awal Bela Negara' oleh seorang tenaga profesional di bidang teknologi informasi adalah...",
                options: [
                    { id: "A", text: "Melakukan serangan siber balasan ke situs negara lain secara mandiri." },
                    { id: "B", text: "Mengamankan data rahasia instansi, mematuhi protokol keamanan siber, dan mengedukasi literasi digital anti-hoaks." },
                    { id: "C", text: "Menghapus seluruh akun media sosial pribadi agar tidak diserang hacker." },
                    { id: "D", text: "Mengabaikan sistem keamanan dan menyerahkan sepenuhnya pada pihak ketiga." }
                ],
                correct: "B",
                explanation: "Bela negara nir-militer di era siber diwujudkan melalui penguasaan kompetensi profesional untuk menjaga kedaulatan data dan keamanan informasi nasional."
            },
            {
                category: "CPNS SKD (Tes Wawasan Kebangsaan)",
                title: "Soal 4 dari 5: Keadilan Sosial Sila Ke-5",
                question: "Pengamalan Sila ke-5 'Keadilan Sosial bagi Seluruh Rakyat Indonesia' oleh pimpinan unit kerja tercermin pada tindakan...",
                options: [
                    { id: "A", text: "Memberikan promosi hanya kepada staf yang memiliki ikatan kekeluargaan dekat." },
                    { id: "B", text: "Membagikan beban kerja dan peluang pelatihan secara adil berdasarkan kompetensi dan kinerja objektif." },
                    { id: "C", text: "Menuntut target kerja yang tidak realistis tanpa menyediakan fasilitas yang memadai." },
                    { id: "D", text: "Menyamaratakan semua nilai evaluasi pegawai tanpa melihat kontribusi nyata." }
                ],
                correct: "B",
                explanation: "Sila ke-5 menekankan perlakuan adil, penghargaan atas jerih payah, dan pembagian hak serta tanggung jawab secara proporsional."
            },
            {
                category: "CPNS SKD (Tes Wawasan Kebangsaan)",
                title: "Soal 5 dari 5: Asas Netralitas ASN",
                question: "Menjelang pemilihan umum kepala daerah, tindakan yang melanggar kode etik netralitas ASN adalah...",
                options: [
                    { id: "A", text: "Menggunakan hak pilih di bilik suara sesuai hati nurani pada hari pemungutan suara." },
                    { id: "B", text: "Mengikuti kampanye akbar dengan mengenakan atribut seragam dinas dan berfoto pose simbol nomor urut paslon." },
                    { id: "C", text: "Menghimbau masyarakat di sekitar rumah untuk tidak golput dan menjaga kedamaian pemilu." },
                    { id: "D", text: "Menolak permintaan titipan anggaran kampanye dari tim sukses pasangan calon." }
                ],
                correct: "B",
                explanation: "ASN dilarang keras terlibat kampanye, menggunakan fasilitas dinas, atau menunjukkan keberpihakan simbolik pada kontestan pemilu (UU No. 20/2023)."
            }
        ],
        tiu: [
            {
                category: "Kemampuan Verbal & Analogi Kata (TIU)",
                title: "Soal 1 dari 5: Analogi Kata Fungsi",
                question: "PORTAL LOWONGAN : PELAMAR KERJA = ... : ...",
                options: [
                    { id: "A", text: "APLIKASI : SMARTPHONE" },
                    { id: "B", text: "PERPUSTAKAAN : PEMBACA" },
                    { id: "C", text: "PASAR : PEDAGANG" },
                    { id: "D", text: "INTERVIEW : HRD" }
                ],
                correct: "B",
                explanation: "Hubungan fungsi: Portal Lowongan adalah tempat yang dikunjungi Pelamar Kerja, sebagaimana Perpustakaan dikunjungi Pembaca."
            },
            {
                category: "Kemampuan Verbal & Analogi Kata (TIU)",
                title: "Soal 2 dari 5: Analogi Alat & Profesi",
                question: "STETOSKOP : DOKTER = ... : ...",
                options: [
                    { id: "A", text: "PENA : TINTA" },
                    { id: "B", text: "CANGKUL : PETANI" },
                    { id: "C", text: "PASIEN : RUMAH SAKIT" },
                    { id: "D", text: "TERMOMETER : SUHU" }
                ],
                correct: "B",
                explanation: "Stetoskop adalah alat kerja utama Dokter, sebagaimana Cangkul adalah alat kerja utama Petani."
            },
            {
                category: "Silogisme Logika (TIU)",
                title: "Soal 3 dari 5: Penarikan Kesimpulan",
                question: "Semua pelamar kerja di Hakajobs tidak dipungut biaya. Sebagian pelamar di Hakajobs mendaftar posisi IT. Kesimpulannya:",
                options: [
                    { id: "A", text: "Semua posisi IT di Hakajobs dipungut biaya pendaftaran." },
                    { id: "B", text: "Sebagian pelamar posisi IT di Hakajobs tidak dipungut biaya." },
                    { id: "C", text: "Tidak ada pelamar IT yang lolos seleksi." },
                    { id: "D", text: "Semua pelamar kerja wajib membayar biaya administrasi." }
                ],
                correct: "B",
                explanation: "Aturan silogisme partikular: Semua A adalah B, sebagian A adalah C -> Sebagian C adalah B."
            },
            {
                category: "Hitungan Aritmatika Cepat (TIU)",
                title: "Soal 4 dari 5: Deret Angka",
                question: "Tentukan angka berikutnya dari deret: 3, 6, 12, 24, 48, ...?",
                options: [
                    { id: "A", text: "72" },
                    { id: "B", text: "84" },
                    { id: "C", text: "96" },
                    { id: "D", text: "108" }
                ],
                correct: "C",
                explanation: "Pola perkalian konstan: x 2. Maka: 48 x 2 = 96."
            },
            {
                category: "Soal Cerita Kecepatan (TIU)",
                title: "Soal 5 dari 5: Waktu Berpapasan",
                question: "Dua mobil bergerak saling mendekat dengan kecepatan masing-masing 60 km/jam dan 80 km/jam. Jika jarak mula-mula 280 km, berapa jam mereka akan berpapasan?",
                options: [
                    { id: "A", text: "1.5 jam" },
                    { id: "B", text: "2 jam" },
                    { id: "C", text: "2.5 jam" },
                    { id: "D", text: "3 jam" }
                ],
                correct: "B",
                explanation: "Waktu = Jarak / (V1 + V2) = 280 / (60 + 80) = 280 / 140 = 2 jam."
            }
        ],
        akhlak: [
            {
                category: "Core Values BUMN (AKHLAK)",
                title: "Soal 1 dari 5: Nilai Kolaboratif",
                question: "Karyawan BUMN sedang menyelesaikan tugas penting. Tim divisi lain membutuhkan data analitik penting yang hanya bisa diakses olehnya. Sikap Kolaboratif yang tepat adalah...",
                options: [
                    { id: "A", text: "Menolak mentah-mentah permintaan bantuan karena itu bukan tugas divisi sendiri." },
                    { id: "B", text: "Membagikan data yang diperlukan sambil berkoordinasi mengatur alokasi waktu agar kedua pekerjaan terselesaikan dengan baik." },
                    { id: "C", text: "Menyerahkan seluruh tugas utama ke rekan kerja lain agar bisa membantu divisi lain." },
                    { id: "D", text: "Menyuruh divisi lain mencari data sendiri di server lama." }
                ],
                correct: "B",
                explanation: "Kolaboratif menekankan sinergi aktif dan membangun kerja sama yang memberi nilai tambah bagi perusahaan secara keseluruhan."
            },
            {
                category: "Core Values BUMN (AKHLAK)",
                title: "Soal 2 dari 5: Nilai Amanah",
                question: "Implementasi nilai 'Amanah' (Memegang teguh kepercayaan yang diberikan) oleh seorang staf keuangan BUMN adalah...",
                options: [
                    { id: "A", text: "Menggunakan dana kas kecil kantor untuk keperluan belanja pribadi lalu menggantinya saat gajian." },
                    { id: "B", text: "Menyusun pembukuan keuangan secara transparan, jujur, akurat, dan sesuai standar akuntansi yang berlaku." },
                    { id: "C", text: "Memanipulasi bukti kuitansi pengeluaran demi menyenangkan atasan." },
                    { id: "D", text: "Menunda pelaporan anggaran hingga akhir tahun agar tidak diaudit." }
                ],
                correct: "B",
                explanation: "Amanah berarti memenuhi janji dan komitmen, bertanggung jawab atas tugas dan kewenangan, serta berpegang teguh pada nilai moral."
            },
            {
                category: "Core Values BUMN (AKHLAK)",
                title: "Soal 3 dari 5: Nilai Kompeten",
                question: "Ciri insan BUMN yang menerapkan nilai 'Kompeten' adalah...",
                options: [
                    { id: "A", text: "Merasa sudah cukup pintar sehingga menolak mengikuti pelatihan teknologi baru." },
                    { id: "B", text: "Terus meningkatkan kapabilitas diri, mempelajari keahlian digital baru, dan membantu orang lain belajar." },
                    { id: "C", text: "Hanya bekerja jika diperintah oleh pimpinan tertinggi." },
                    { id: "D", text: "Menyembunyikan informasi penting agar rekan kerja tidak bisa menyaingi performanya." }
                ],
                correct: "B",
                explanation: "Kompeten berarti terus belajar dan mengembangkan kapabilitas serta memberikan kinerja terbaik."
            },
            {
                category: "Core Values BUMN (AKHLAK)",
                title: "Soal 4 dari 5: Nilai Harmonis",
                question: "Penerapan nilai 'Harmonis' di lingkungan kerja BUMN yang heterogen adalah...",
                options: [
                    { id: "A", text: "Membentuk kelompok makan siang eksklusif hanya untuk rekan sedaerah." },
                    { id: "B", text: "Menghargai setiap rekan kerja tanpa memandang latar belakang suku, agama, dan gender serta suka menolong." },
                    { id: "C", text: "Membicarakan kebiasaan pribadi rekan kerja di belakangnya." },
                    { id: "D", text: "Menhindari komunikasi dengan anggota tim yang memiliki pandangan berbeda." }
                ],
                correct: "B",
                explanation: "Harmonis berarti saling peduli dan menghargai perbedaan untuk membangun lingkungan kerja yang kondusif."
            },
            {
                category: "Core Values BUMN (AKHLAK)",
                title: "Soal 5 dari 5: Nilai Loyal & Adaptif",
                question: "Ketika BUMN tempat Anda bekerja melakukan transformasi sistem manajemen berbasis AI, sikap Adaptif yang benar adalah...",
                options: [
                    { id: "A", text: "Menolak menggunakan sistem baru dan tetap memakai pencatatan manual." },
                    { id: "B", text: "Proaktif mempelajari sistem AI baru, antusias mengadaptasi perubahan, dan mencari solusi inovatif untuk unit kerja." },
                    { id: "C", text: "Menunggu hingga sistem lama benar-benar dimatikan paksa oleh manajemen." },
                    { id: "D", text: "Mengkritik kebijakan manajemen di media sosial publik." }
                ],
                correct: "B",
                explanation: "Adaptif berarti cepat menyesuaikan diri menghadapi perubahan, berinovasi, dan bertindak proaktif."
            }
        ],
        psikotes: [
            {
                category: "Psikotes Kerja (Logika Deret)",
                title: "Soal 1 dari 5: Deret Angka Bertingkat",
                question: "Tentukan angka berikutnya dari deret: 3, 5, 9, 17, 33, ...?",
                options: [
                    { id: "A", text: "49" },
                    { id: "B", text: "55" },
                    { id: "C", text: "65" },
                    { id: "D", text: "72" }
                ],
                correct: "C",
                explanation: "Pola selisih: +2, +4, +8, +16, +32. Maka: 33 + 32 = 65."
            },
            {
                category: "Psikotes Kerja (Deret Pecahan)",
                title: "Soal 2 dari 5: Pembagian Konstan",
                question: "Berapakah nilai berikutnya dari deret: 64, 32, 16, 8, 4, ...?",
                options: [
                    { id: "A", text: "3" },
                    { id: "B", text: "2" },
                    { id: "C", text: "1" },
                    { id: "D", text: "0.5" }
                ],
                correct: "B",
                explanation: "Pola pembagian 2 (x / 2). Suku berikutnya: 4 / 2 = 2."
            },
            {
                category: "Psikotes Kerja (Tes Koran)",
                title: "Soal 3 dari 5: Penjumlahan Satuan",
                question: "Pada tes Kraepelin/Pauli, jika Anda menjumlahkan dua angka: 7 dan 8, hasilnya adalah 15. Angka yang wajib ditulis pada lembar jawaban adalah...",
                options: [
                    { id: "A", text: "15" },
                    { id: "B", text: "1" },
                    { id: "C", text: "5" },
                    { id: "D", text: "8" }
                ],
                correct: "C",
                explanation: "Aturan tes koran: jika hasil penjumlahan dua digit (10 ke atas), Anda hanya menuliskan angka satuannya saja, yaitu angka 5."
            },
            {
                category: "Psikotes Logika Figural",
                title: "Soal 4 dari 5: Rotasi Arah",
                question: "Sebuah jarum jam menunjuk angka 12. Diputar searah jarum jam 90°, lalu diputar 180°, lalu diputar berlawanan arah jarum jam 90°. Jarum jam sekarang menunjuk angka...",
                options: [
                    { id: "A", text: "Angka 3" },
                    { id: "B", text: "Angka 6" },
                    { id: "C", text: "Angka 9" },
                    { id: "D", text: "Angka 12" }
                ],
                correct: "B",
                explanation: "Total putaran: +90° + 180° - 90° = +180° dari angka 12. Berada tepat di seberangnya, yaitu angka 6."
            },
            {
                category: "Psikotes Aritmatika Pekerja",
                title: "Soal 5 dari 5: Rasio Waktu Kerja",
                question: "Sebuah gudang dapat diselesaikan oleh 12 tukang dalam 20 hari. Jika ingin selesai dalam 10 hari, berapa jumlah pekerja tambahan yang dibutuhkan?",
                options: [
                    { id: "A", text: "6 orang" },
                    { id: "B", text: "12 orang" },
                    { id: "C", text: "24 orang" },
                    { id: "D", text: "18 orang" }
                ],
                correct: "B",
                explanation: "Perbandingan berbalik nilai: 12 x 20 = X x 10 -> X = 24 total pekerja. Pekerja tambahan yang dibutuhkan: 24 - 12 = 12 orang."
            }
        ]
    };

    var activeCat = 'twk';
    var currentIdx = 0;
    var selectedOpt = null;

    function renderActiveQuiz(cat, idx) {
        activeCat = cat || activeCat;
        currentIdx = (typeof idx === 'number') ? idx : 0;
        var questions = multiQuizDatabase[activeCat] || [];
        var data = questions[currentIdx];
        var container = document.getElementById('hkQuizContainer');
        if (!container || !data) return;

        var stepperHtml = '<div style="display:flex; align-items:center; gap:6px; margin-bottom:14px; flex-wrap:wrap;">' +
            '<span style="font-size:12px; font-weight:700; color:var(--hk-text-muted); margin-right:4px;">Lompat Soal:</span>' +
            questions.map(function(q, i) {
                var isCurrent = (i === currentIdx);
                var btnStyle = isCurrent 
                    ? 'background:var(--hk-primary); color:#ffffff; border-color:var(--hk-primary); font-weight:800;' 
                    : 'background:#ffffff; color:var(--hk-text-main); border-color:var(--hk-border); font-weight:600;';
                return '<button type="button" onclick="window.renderActiveQuiz(\'' + activeCat + '\', ' + i + ')" style="width:30px; height:30px; border-radius:8px; border:1px solid; font-size:12px; cursor:pointer; ' + btnStyle + '">' + (i + 1) + '</button>';
            }).join('') +
            '<span style="font-size:11.5px; color:var(--hk-text-muted); margin-left:auto;">Soal ' + (currentIdx + 1) + ' dari ' + questions.length + '</span>' +
            '</div>';

        var optionsHtml = data.options.map(function(opt) {
            return '<button type="button" class="hk-tk-option-btn" data-opt="' + opt.id + '" onclick="window.selectQuizOption(\'' + opt.id + '\')">' +
                '<span class="hk-tk-opt-letter">' + opt.id + '</span>' +
                '<span class="hk-tk-opt-text">' + opt.text + '</span>' +
                '</button>';
        }).join('');

        var hasNext = (currentIdx < questions.length - 1);
        var nextBtnHtml = hasNext 
            ? '<button type="button" class="hk-btn hk-btn-primary" onclick="window.renderActiveQuiz(\'' + activeCat + '\', ' + (currentIdx + 1) + ')" style="display:inline-flex; align-items:center; gap:6px;"><span>Soal Berikutnya</span> &rarr;</button>'
            : '<button type="button" class="hk-btn hk-btn-primary" onclick="window.renderActiveQuiz(\'' + activeCat + '\', 0)" style="display:inline-flex; align-items:center; gap:6px;"><span>Kembali ke Soal 1</span> &olarr;</button>';

        container.innerHTML = 
            stepperHtml +
            '<div>' +
            '  <span class="hk-tk-quiz-question-tag">' + data.category + '</span>' +
            '  <h3 class="hk-tk-quiz-question-title">' + data.title + '</h3>' +
            '  <p class="hk-tk-quiz-question-text">' + data.question + '</p>' +
            '</div>' +
            '<div class="hk-tk-options-list">' + optionsHtml + '</div>' +
            '<div class="hk-tk-explanation-box" id="hkExplanationBox"></div>' +
            '<div style="display:flex; gap:12px; align-items:center; flex-wrap:wrap; margin-top:16px;">' +
            '  <button type="button" id="hkSubmitQuizBtn" class="hk-tk-submit-quiz-btn" onclick="window.checkQuizAnswer()" disabled>' +
            '    Periksa Jawaban' +
            '  </button>' +
            nextBtnHtml +
            '</div>';

        selectedOpt = null;
    }
    window.renderActiveQuiz = renderActiveQuiz;

    window.selectQuizOption = function(optId) {
        selectedOpt = optId;
        var buttons = document.querySelectorAll('.hk-tk-option-btn');
        buttons.forEach(function(btn) {
            btn.classList.remove('is-selected');
        });
        var targetBtn = document.querySelector('.hk-tk-option-btn[data-opt="' + optId + '"]');
        if (targetBtn) {
            targetBtn.classList.add('is-selected');
        }
        var submitBtn = document.getElementById('hkSubmitQuizBtn');
        if (submitBtn) {
            submitBtn.disabled = false;
        }
    };

    window.checkQuizAnswer = function() {
        if (!selectedOpt) return;
        var questions = multiQuizDatabase[activeCat] || [];
        var data = questions[currentIdx];
        var expBox = document.getElementById('hkExplanationBox');
        var submitBtn = document.getElementById('hkSubmitQuizBtn');
        var buttons = document.querySelectorAll('.hk-tk-option-btn');

        buttons.forEach(function(btn) {
            btn.style.pointerEvents = 'none';
        });

        if (selectedOpt === data.correct) {
            var correctBtn = document.querySelector('.hk-tk-option-btn[data-opt="' + selectedOpt + '"]');
            if (correctBtn) correctBtn.classList.add('is-correct');

            expBox.className = 'hk-tk-explanation-box show-correct';
            expBox.innerHTML = '<strong>✅ Jawaban Anda Benar! (Kunci: ' + data.correct + ')</strong><p style="margin:6px 0 0;">' + data.explanation + '</p>';
        } else {
            var wrongBtn = document.querySelector('.hk-tk-option-btn[data-opt="' + selectedOpt + '"]');
            if (wrongBtn) wrongBtn.classList.add('is-wrong');

            var actualCorrectBtn = document.querySelector('.hk-tk-option-btn[data-opt="' + data.correct + '"]');
            if (actualCorrectBtn) actualCorrectBtn.classList.add('is-correct');

            expBox.className = 'hk-tk-explanation-box show-wrong';
            expBox.innerHTML = '<strong>❌ Jawaban Kurang Tepat. (Kunci Jawaban yang Benar: ' + data.correct + ')</strong><p style="margin:6px 0 0;">' + data.explanation + '</p>';
        }

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Evaluasi Selesai';
        }
    };

    // Tab Switching
    var tabBtns = document.querySelectorAll('#hkQuizTabs .hk-tk-tab-btn');
    tabBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            tabBtns.forEach(function(b) { b.classList.remove('is-active'); });
            btn.classList.add('is-active');
            var cat = btn.getAttribute('data-cat');
            renderActiveQuiz(cat, 0);
        });
    });

    // Tag clicks trigger instant search highlight
    var tagButtons = document.querySelectorAll('.hk-tk-tag-chip');
    tagButtons.forEach(function(tag) {
        tag.addEventListener('click', function() {
            var val = tag.getAttribute('data-query');
            var input = document.getElementById('hkTkSearchInput');
            if (input) {
                input.value = val;
                input.focus();
            }
            if (val.toLowerCase().indexOf('skd') !== -1 || val.toLowerCase().indexOf('twk') !== -1) {
                window.openCareerArticle('skd');
            } else if (val.toLowerCase().indexOf('cv') !== -1) {
                window.openCareerArticle('cv');
            } else if (val.toLowerCase().indexOf('k3') !== -1) {
                window.openCareerArticle('k3');
            } else if (val.toLowerCase().indexOf('kraepelin') !== -1 || val.toLowerCase().indexOf('psikotes') !== -1) {
                window.openCareerArticle('psikotes');
            } else {
                window.openCareerArticle('skd');
            }
        });
    });

    var searchBtn = document.getElementById('hkTkSearchBtn');
    if (searchBtn) {
        searchBtn.addEventListener('click', function() {
            var input = document.getElementById('hkTkSearchInput');
            var val = (input ? input.value : '').trim();
            if (val) {
                window.openCareerArticle('skd');
            } else {
                if (input) input.focus();
            }
        });
    }

    // Initialize Quiz
    renderActiveQuiz('twk', 0);
})();
</script>

<?php
get_footer();
