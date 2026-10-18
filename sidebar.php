<?php
/**
 * Sidebar Template for Hakajobs
 *
 * Menampilkan bilah sisi kanan (sidebar) yang dapat dikustomisasi melalui WP Customizer:
 * 1. Kartu Pasang Loker (Punya Lowongan Kerja?) untuk Rekruter
 * 2. Slot Iklan Banner Sidebar
 * 3. Kategori Populer
 * 4. Lokasi Kerja Teratas
 * 5. 💡 Tips Melamar Efektif
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

// 4. Pengaturan Tips Melamar Efektif
$show_tips         = get_theme_mod('hakajobs_sidebar_show_tips', '1');
$tips_title        = get_theme_mod('hakajobs_sidebar_tips_title', __('💡 Tips Melamar Efektif', 'hakajobs'));
$default_tips      = "Sesuaikan CV Anda dengan kata kunci yang diminta pada kualifikasi lowongan.\nGunakan format PDF dengan nama file yang jelas (contoh: CV_NamaLengkap_Posisi.pdf).\nSaat melamar via WhatsApp, gunakan bahasa yang santun dan perkenalkan diri secara ringkas.";
$tips_content      = get_theme_mod('hakajobs_sidebar_tips_content', $default_tips);

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

        <!-- 4. Widget 💡 Tips Melamar Efektif -->
        <?php if ($show_tips === '1'): ?>
            <div class="hk-widget-card hk-tips-card">
                <?php if (!empty($tips_title)): ?>
                    <h3 class="hk-widget-title"><?php echo esc_html($tips_title); ?></h3>
                <?php endif; ?>

                <?php
                $tips_lines = array_filter(array_map('trim', explode("\n", $tips_content)));
                if (!empty($tips_lines)):
                ?>
                    <ul class="hk-tips-list">
                        <?php foreach ($tips_lines as $tip_line): ?>
                            <li><?php echo esc_html($tip_line); ?></li>
                        <?php endforeach; ?>
                    </ul>
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
