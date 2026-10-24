<?php
/**
 * Sidebar Template for Hakajobs
 *
 * Menampilkan bilah sisi kanan (sidebar) yang dapat dikustomisasi melalui WP Customizer:
 * 1. Kartu Pasang Loker (Punya Lowongan Kerja?) untuk Rekruter
 * 2. Slot Iklan Banner Sidebar
 * 3. Kategori Populer
 * 4. Lokasi Kerja Teratas
 * 5. Lowongan Terpopuler (Berdasarkan 7 Hari / Custom)
 * Serta mendukung Widget Area WordPress kustom (Tampilan > Widget).
 *
 * @package Hakajobs
 */

if (!defined('ABSPATH')) {
    exit;
}

// 1. Pengaturan Pasang Loker
$show_post_job     = get_theme_mod('hakajobs_sidebar_show_post_job', '1');
$post_job_badge    = get_theme_mod('hakajobs_sidebar_post_job_badge', __('UNTUK PERUSAHAAN / REKRUTER', 'hakajobs'));
$post_job_title    = get_theme_mod('hakajobs_sidebar_post_job_title', __('Punya Lowongan Kerja?', 'hakajobs'));
$post_job_desc     = get_theme_mod('hakajobs_sidebar_post_job_desc', __('Pasang info lowongan kerja Anda di Hakajobs dan dapatkan pelamar berkualitas langsung ke WhatsApp atau Email perusahaan Anda.', 'hakajobs'));
$post_job_btn_text = get_theme_mod('hakajobs_sidebar_post_job_btn_text', __('Pasang Iklan Loker', 'hakajobs') . ' &rarr;');
$post_job_btn_url  = get_theme_mod('hakajobs_sidebar_post_job_btn_url', '');
if (empty($post_job_btn_url)) {
    $post_job_btn_url = home_url('/pasang-loker/');
}

// 2. Pengaturan Kategori Populer
$show_cats         = get_theme_mod('hakajobs_sidebar_show_cats', '1');
$cats_title        = get_theme_mod('hakajobs_sidebar_cats_title', __('Kategori Populer', 'hakajobs'));
$cats_count        = intval(get_theme_mod('hakajobs_sidebar_cats_count', 6));
$cats_hide_empty   = get_theme_mod('hakajobs_sidebar_cats_hide_empty', '0') === '1';
$cats_orderby      = get_theme_mod('hakajobs_sidebar_cats_orderby', 'count');

// 3. Pengaturan Lokasi Kerja Teratas
$show_locs         = get_theme_mod('hakajobs_sidebar_show_locs', '1');
$locs_title        = get_theme_mod('hakajobs_sidebar_locs_title', __('Lokasi Kerja Teratas', 'hakajobs'));
$locs_count        = intval(get_theme_mod('hakajobs_sidebar_locs_count', 8));
$locs_hide_empty   = get_theme_mod('hakajobs_sidebar_locs_hide_empty', '0') === '1';
$locs_orderby      = get_theme_mod('hakajobs_sidebar_locs_orderby', 'count');

// 4. Pengaturan Lowongan Terpopuler
$show_popular       = get_theme_mod('hakajobs_sidebar_show_popular', '1');
$popular_title      = get_theme_mod('hakajobs_sidebar_popular_title', __('Lowongan Terpopuler', 'hakajobs'));
$popular_days       = get_theme_mod('hakajobs_sidebar_popular_days', '7');
$popular_count      = intval(get_theme_mod('hakajobs_sidebar_popular_count', 5));
$show_pop_views     = get_theme_mod('hakajobs_sidebar_popular_show_views', '1');

// 5. Posisi Widget WordPress Kustom
$wp_widgets_pos    = get_theme_mod('hakajobs_sidebar_wp_widgets_pos', 'after');
$has_dynamic_wp    = is_active_sidebar('sidebar-right');
?>

<aside class="hk-sidebar" aria-label="<?php esc_attr_e('Sidebar Kanan', 'hakajobs'); ?>">

    <?php 
    // Tampilkan widget WP dinamis sebelum widget bawaan jika disetel 'before'
    if ($has_dynamic_wp && $wp_widgets_pos === 'before') {
        dynamic_sidebar('sidebar-right');
    }
    ?>

    <?php if (!$has_dynamic_wp || $wp_widgets_pos !== 'replace'): ?>

        <!-- 1. Widget Pasang Loker untuk Perusahaan / Rekruter -->
        <?php if ($show_post_job === '1'): ?>
            <div class="hk-widget-card hk-card-post-job">
                <?php if (!empty($post_job_badge)): ?>
                    <div class="hk-post-job-badge"><?php echo esc_html($post_job_badge); ?></div>
                <?php endif; ?>

                <?php if (!empty($post_job_title)): ?>
                    <h3 class="hk-widget-title"><?php echo esc_html($post_job_title); ?></h3>
                <?php endif; ?>

                <?php if (!empty($post_job_desc)): ?>
                    <p class="hk-widget-text">
                        <?php echo nl2br(esc_html($post_job_desc)); ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($post_job_btn_text)): ?>
                    <a href="<?php echo esc_url($post_job_btn_url); ?>" class="hk-btn hk-btn-accent hk-btn-block">
                        <?php echo wp_kses_post($post_job_btn_text); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Slot Iklan Sidebar -->
        <?php if (function_exists('hakajobs_render_ad_slot')) { hakajobs_render_ad_slot('sidebar'); } ?>

        <!-- 2. Widget Kategori Populer -->
        <?php if ($show_cats === '1'): ?>
            <div class="hk-widget-card">
                <?php if (!empty($cats_title)): ?>
                    <h3 class="hk-widget-title"><?php echo esc_html($cats_title); ?></h3>
                <?php endif; ?>

                <ul class="hk-widget-list">
                    <?php
                    $cats_args = array(
                        'taxonomy'   => 'kategori_lowongan',
                        'number'     => ($cats_count > 0 ? $cats_count : 6),
                        'hide_empty' => $cats_hide_empty,
                    );
                    if ($cats_orderby === 'name') {
                        $cats_args['orderby'] = 'name';
                        $cats_args['order']   = 'ASC';
                    } else {
                        $cats_args['orderby'] = 'count';
                        $cats_args['order']   = 'DESC';
                    }

                    $side_cats = get_terms($cats_args);
                    if (!empty($side_cats) && !is_wp_error($side_cats)) {
                        foreach ($side_cats as $sc) {
                            echo '<li>';
                            echo '<a href="' . esc_url(get_term_link($sc)) . '" class="hk-widget-link">';
                            echo '<span>' . esc_html($sc->name) . '</span>';
                            echo '<span class="hk-badge-count">' . intval($sc->count) . '</span>';
                            echo '</a>';
                            echo '</li>';
                        }
                    } else {
                        echo '<li class="hk-widget-empty"><span style="font-size:13px; color:var(--hk-text-muted);">' . __('Belum ada kategori tersedia.', 'hakajobs') . '</span></li>';
                    }
                    ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- 3. Widget Lokasi Kerja Teratas -->
        <?php if ($show_locs === '1'): ?>
            <div class="hk-widget-card">
                <?php if (!empty($locs_title)): ?>
                    <h3 class="hk-widget-title"><?php echo esc_html($locs_title); ?></h3>
                <?php endif; ?>

                <div class="hk-pills-cloud">
                    <?php
                    $locs_args = array(
                        'taxonomy'   => 'lokasi_lowongan',
                        'number'     => ($locs_count > 0 ? $locs_count : 8),
                        'hide_empty' => $locs_hide_empty,
                    );
                    if ($locs_orderby === 'name') {
                        $locs_args['orderby'] = 'name';
                        $locs_args['order']   = 'ASC';
                    } else {
                        $locs_args['orderby'] = 'count';
                        $locs_args['order']   = 'DESC';
                    }

                    $side_locs = get_terms($locs_args);
                    if (!empty($side_locs) && !is_wp_error($side_locs)) {
                        foreach ($side_locs as $sl) {
                            echo '<a href="' . esc_url(get_term_link($sl)) . '" class="hk-cloud-pill">';
                            echo esc_html($sl->name);
                            if ($sl->count > 0) {
                                echo ' <small style="opacity:0.75;">(' . intval($sl->count) . ')</small>';
                            }
                            echo '</a>';
                        }
                    } else {
                        echo '<span style="font-size:13px; color:var(--hk-text-muted);">' . __('Belum ada lokasi tersedia.', 'hakajobs') . '</span>';
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- 4. Widget 🔥 Lowongan Terpopuler -->
        <?php if ($show_popular === '1'): ?>
            <div class="hk-widget-card hk-popular-jobs-widget">
                <?php if (!empty($popular_title)): ?>
                    <h3 class="hk-widget-title"><?php echo esc_html($popular_title); ?></h3>
                <?php endif; ?>

                <?php
                $pop_args = array(
                    'post_type'      => 'lowongan',
                    'post_status'    => 'publish',
                    'posts_per_page' => $popular_count,
                    'meta_key'       => '_hakajobs_views_count',
                    'orderby'        => 'meta_value_num',
                    'order'          => 'DESC',
                    'no_found_rows'  => true,
                );

                if ($popular_days !== 'all' && intval($popular_days) > 0) {
                    $pop_args['date_query'] = array(
                        array(
                            'after'     => intval($popular_days) . ' days ago',
                            'inclusive' => true,
                        ),
                    );
                }

                $popular_query = new WP_Query($pop_args);

                // Fallback: Jika dalam rentang X hari belum ada lowongan, tampilkan lowongan terpopuler sepanjang waktu
                if (!$popular_query->have_posts() && $popular_days !== 'all') {
                    unset($pop_args['date_query']);
                    $popular_query = new WP_Query($pop_args);
                }

                if ($popular_query->have_posts()):
                ?>
                    <div class="hk-popular-jobs-list">
                        <?php 
                        $pop_rank = 1;
                        while ($popular_query->have_posts()): 
                            $popular_query->the_post();
                            $job_id   = get_the_ID();
                            $company  = get_post_meta($job_id, '_hakajobs_company_name', true);
                            $location = get_post_meta($job_id, '_hakajobs_job_location', true);
                            $views    = hakajobs_get_views($job_id);
                        ?>
                            <a href="<?php the_permalink(); ?>" class="hk-popular-job-item">
                                <span class="hk-popular-rank rank-<?php echo esc_attr($pop_rank); ?>"><?php echo esc_html($pop_rank); ?></span>
                                <div class="hk-popular-job-info">
                                    <h4 class="hk-popular-job-title"><?php the_title(); ?></h4>
                                    <div class="hk-popular-job-meta">
                                        <?php if (!empty($company)): ?>
                                            <span class="hk-popular-company"><?php echo esc_html($company); ?></span>
                                        <?php endif; ?>
                                        <?php if (!empty($company) && !empty($location)): ?>
                                            <span class="hk-popular-sep">•</span>
                                        <?php endif; ?>
                                        <?php if (!empty($location)): ?>
                                            <span class="hk-popular-loc"><?php echo esc_html($location); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($show_pop_views === '1' && $views > 0): ?>
                                        <span class="hk-popular-views">👁️ <?php echo number_format_i18n($views); ?> <?php _e('dilihat', 'hakajobs'); ?></span>
                                    <?php endif; ?>
                                </div>
                            </a>
                        <?php 
                            $pop_rank++;
                        endwhile; 
                        wp_reset_postdata();
                        ?>
                    </div>
                <?php else: ?>
                    <p style="font-size:13px; color:var(--hk-text-muted); margin:0;">
                        <?php _e('Belum ada lowongan terpopuler saat ini.', 'hakajobs'); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <?php 
    // Tampilkan widget WP dinamis setelah widget bawaan atau jika disetel 'replace'
    if ($has_dynamic_wp && ($wp_widgets_pos === 'after' || $wp_widgets_pos === 'replace')) {
        dynamic_sidebar('sidebar-right');
    }
    ?>

</aside>
