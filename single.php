<?php
/**
 * Single Post Template for Hakajobs
 * Tampilan artikel standar blog dan materi edukasi karir lengkap dengan dukungan soal interaktif
 *
 * @package Hakajobs
 */

get_header();

while (have_posts()) : the_post();
    $categories  = get_the_category();
    $primary_cat = !empty($categories) ? $categories[0] : null;

    // Deteksi apakah artikel karir
    $is_career = false;
    if (!empty($categories)) {
        foreach ($categories as $cat) {
            $slug = $cat->slug;
            if (in_array($slug, array('tes-karir', 'test-karir', 'persiapan-karir', 'latihan-soal', 'cpns-bumn', 'psikotes-kerja', 'tips-karir', 'resume-cv-ats', 'interview-kerja', 'sertifikasi-profesi', 'gaji-negosiasi', 'cv-berkas', 'pengembangan-karir', 'wawancara-kerja'))) {
                $is_career = true;
                break;
            }
        }
    }

    // Profil Penulis / Kurator dari Customizer
    $tk_author_name   = get_theme_mod('hakajobs_tk_author_name', __('Tim Redaksi Karir & Edukasi', 'hakajobs'));
    $tk_author_bio    = get_theme_mod('hakajobs_tk_author_bio', __('Materi pembelajaran resmi dan kisi-kisi soal yang dikurasi oleh praktisi rekrutmen profesional untuk mempermudah persiapan tes karir pencari kerja di Indonesia.', 'hakajobs'));
    $tk_author_avatar = get_theme_mod('hakajobs_tk_author_avatar', '');
    if (empty($tk_author_avatar)) {
        $tk_author_avatar = 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&auto=format&fit=crop&q=80';
    }

    // Estimasi waktu baca & jumlah dibaca
    $word_count = str_word_count(strip_tags(get_the_content()));
    $read_time  = max(1, ceil($word_count / 200));

    if (function_exists('hakajobs_set_views')) {
        hakajobs_set_views(get_the_ID());
    }
    $views = function_exists('hakajobs_get_views') ? hakajobs_get_views(get_the_ID()) : 0;
    if ($views > 0) {
        $views_formatted = ($views >= 1000) ? round($views / 1000, 1) . 'k' : $views;
    } else {
        $dummy_views = (get_the_ID() * 137) % 3500 + 1200;
        $views_formatted = round($dummy_views / 1000, 1) . 'k';
    }

    // Career Page URL
    $career_url = function_exists('hakajobs_get_career_url') ? hakajobs_get_career_url() : home_url('/tes-karir/');
?>

<?php hakajobs_breadcrumbs(); ?>

<main id="hk-main" class="hk-site-main hk-single-standard-page">
    <div class="hk-container">
        <article class="hk-article-card">
            
            <div class="hk-article-top-nav">
                <a href="<?php echo esc_url($career_url); ?>" class="hk-btn-back-career">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    <span><?php _e('Kembali ke Pusat Tes &amp; Karir', 'hakajobs'); ?></span>
                </a>
                <?php if ($primary_cat): ?>
                    <a href="<?php echo esc_url(get_category_link($primary_cat->term_id)); ?>" class="hk-article-category-badge">
                        <?php echo esc_html($primary_cat->name); ?>
                    </a>
                <?php endif; ?>
            </div>

            <header class="hk-article-header">
                <h1 class="hk-article-title"><?php the_title(); ?></h1>
                <div class="hk-article-meta">
                    <span class="hk-meta-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <span><?php echo esc_html($read_time); ?> <?php _e('menit baca', 'hakajobs'); ?></span>
                    </span>
                    <span>•</span>
                    <span class="hk-meta-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <span><?php echo esc_html($views_formatted); ?> <?php _e('dibaca', 'hakajobs'); ?></span>
                    </span>
                    <span>•</span>
                    <span class="hk-meta-item">
                        <span><?php echo get_the_date('d M Y'); ?></span>
                    </span>
                    <span>•</span>
                    <span class="hk-meta-item">
                        <span><?php echo esc_html($is_career ? $tk_author_name : get_the_author()); ?></span>
                    </span>
                </div>
            </header>

            <?php if (has_post_thumbnail()): ?>
                <div class="hk-article-thumb">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <div class="hk-article-content hk-typography">
                <?php the_content(); ?>
            </div>

            <!-- Share Bar -->
            <div class="hk-article-share-bar">
                <span class="hk-share-title"><?php _e('Bagikan Panduan Ini:', 'hakajobs'); ?></span>
                <div class="hk-share-buttons">
                    <a href="https://api.whatsapp.com/send?text=<?php echo rawurlencode(get_the_title() . ' - ' . get_permalink()); ?>" target="_blank" rel="noopener noreferrer" class="hk-share-btn hk-share-wa">
                        WhatsApp
                    </a>
                    <a href="https://t.me/share/url?url=<?php echo rawurlencode(get_permalink()); ?>&text=<?php echo rawurlencode(get_the_title()); ?>" target="_blank" rel="noopener noreferrer" class="hk-share-btn hk-share-tg">
                        Telegram
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo rawurlencode(get_permalink()); ?>" target="_blank" rel="noopener noreferrer" class="hk-share-btn hk-share-li">
                        LinkedIn
                    </a>
                    <button type="button" class="hk-share-btn hk-share-copy" onclick="if(navigator.clipboard){navigator.clipboard.writeText(window.location.href); if(typeof showToast === 'function'){showToast('Tautan artikel berhasil disalin!');}else{alert('Tautan panduan berhasil disalin!');}}">
                        Salin Tautan
                    </button>
                </div>
            </div>

            <!-- Author Box -->
            <div class="hk-article-author-box">
                <img src="<?php echo esc_url($tk_author_avatar); ?>" alt="<?php echo esc_attr($tk_author_name); ?>" class="hk-author-avatar">
                <div class="hk-author-info">
                    <h4><?php echo esc_html($is_career ? $tk_author_name : get_the_author()); ?></h4>
                    <p><?php echo esc_html($is_career ? $tk_author_bio : (get_the_author_meta('description') ?: __('Penulis dan kontributor konten profesional di portal karir Hakajobs.', 'hakajobs'))); ?></p>
                </div>
            </div>

            <?php
            // CTA Siap Melamar Pekerjaan (Disetting di WP Dashboard > Customizer)
            $show_single_cta = get_theme_mod('hakajobs_single_show_cta_loker', '1');
            if ($show_single_cta === '1' && function_exists('hakajobs_render_jobseeker_cta')) {
                hakajobs_render_jobseeker_cta(array(
                    'class' => 'hk-single-cta-loker',
                ));
            }
            ?>

            <footer class="hk-article-footer">
                <?php the_tags('<div class="hk-tags-list"><span>' . __('Tags:', 'hakajobs') . '</span> ', ' ', '</div>'); ?>

                <div class="hk-article-bottom-nav">
                    <a href="<?php echo esc_url($career_url); ?>" class="hk-btn hk-btn-subtle">
                        &larr; <?php _e('Lihat Semua Modul Tes &amp; Karir', 'hakajobs'); ?>
                    </a>
                    <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" class="hk-btn hk-btn-primary">
                        <?php _e('Jelajahi Lowongan Kerja Terbaru', 'hakajobs'); ?> &rarr;
                    </a>
                </div>
            </footer>
        </article>
    </div>
</main>

<?php
endwhile;
get_footer();
