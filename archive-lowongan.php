<?php
/**
 * Archive Template for Lowongan Kerja
 *
 * @package Hakajobs
 */

get_header();

// Extract query parameters
$current_keyword  = isset($_GET['s_keyword']) ? sanitize_text_field($_GET['s_keyword']) : '';
$current_kategori = isset($_GET['kategori']) ? sanitize_text_field($_GET['kategori']) : '';
$current_lokasi   = isset($_GET['lokasi']) ? sanitize_text_field($_GET['lokasi']) : '';
$current_tipe     = isset($_GET['tipe']) ? sanitize_text_field($_GET['tipe']) : '';
$current_exp      = isset($_GET['pengalaman']) ? sanitize_text_field($_GET['pengalaman']) : '';
$current_sort     = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'terbaru';

// If in taxonomy archive, override respective filter
if (is_tax('kategori_lowongan')) {
    $current_kategori = get_queried_object()->slug;
} elseif (is_tax('lokasi_lowongan')) {
    $current_lokasi = get_queried_object()->slug;
} elseif (is_tax('tipe_pekerjaan')) {
    $current_tipe = get_queried_object()->slug;
} elseif (is_tax('pengalaman_kerja')) {
    $current_exp = get_queried_object()->slug;
}

$has_active_filters = (!empty($current_keyword) || !empty($current_kategori) || !empty($current_lokasi) || !empty($current_tipe) || !empty($current_exp));
?>

<?php hakajobs_breadcrumbs(); ?>

<main id="hk-main" class="hk-site-main hk-archive-page">
    <div class="hk-container">
        
        <!-- Archive Page Banner -->
        <div class="hk-archive-header">
            <h1 class="hk-archive-title">
                <?php
                if (is_tax()) {
                    single_term_title();
                } else {
                    _e('Direktori Lowongan Kerja', 'hakajobs');
                }
                ?>
            </h1>
            <p class="hk-archive-subtitle">
                <?php
                if (is_tax()) {
                    the_archive_description();
                } else {
                    _e('Temukan posisi yang sesuai dengan keahlian Anda dari berbagai industri dan perusahaan terpercaya.', 'hakajobs');
                }
                ?>
            </p>
        </div>

        <!-- Filter & Jobs Directory Grid -->
        <div class="hk-directory-layout">
            
            <!-- Left Filter Sidebar -->
            <aside class="hk-filter-sidebar" id="hk-filter-sidebar">
                <div class="hk-filter-card">
                    <div class="hk-filter-card-header">
                        <div class="hk-filter-header-title">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                            <span><?php _e('Filter Pencarian', 'hakajobs'); ?></span>
                        </div>
                        <?php if ($has_active_filters): ?>
                            <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" class="hk-filter-reset-link">
                                <?php _e('Reset', 'hakajobs'); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <form action="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" method="get" class="hk-filter-form">
                        <input type="hidden" name="post_type" value="lowongan">

                        <!-- Keyword Filter -->
                        <div class="hk-filter-group">
                            <label for="hk-f-keyword" class="hk-filter-label"><?php _e('Kata Kunci', 'hakajobs'); ?></label>
                            <input type="text" id="hk-f-keyword" name="s_keyword" value="<?php echo esc_attr($current_keyword); ?>" placeholder="<?php esc_attr_e('Contoh: Programmer, Desain...', 'hakajobs'); ?>" class="hk-filter-input" />
                        </div>

                        <!-- Kategori Filter -->
                        <div class="hk-filter-group">
                            <label for="hk-f-category" class="hk-filter-label"><?php _e('Kategori Bidang', 'hakajobs'); ?></label>
                            <select id="hk-f-category" name="kategori" class="hk-filter-select">
                                <option value=""><?php _e('Semua Kategori', 'hakajobs'); ?></option>
                                <?php
                                $all_cats = get_terms(array('taxonomy' => 'kategori_lowongan', 'hide_empty' => false));
                                if (!empty($all_cats) && !is_wp_error($all_cats)) {
                                    foreach ($all_cats as $cat) {
                                        echo '<option value="' . esc_attr($cat->slug) . '" ' . selected($current_kategori, $cat->slug, false) . '>' . esc_html($cat->name) . ' (' . $cat->count . ')</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Lokasi Filter -->
                        <div class="hk-filter-group">
                            <label for="hk-f-location" class="hk-filter-label"><?php _e('Kota / Wilayah', 'hakajobs'); ?></label>
                            <select id="hk-f-location" name="lokasi" class="hk-filter-select">
                                <option value=""><?php _e('Semua Lokasi', 'hakajobs'); ?></option>
                                <?php
                                $all_locs = get_terms(array('taxonomy' => 'lokasi_lowongan', 'hide_empty' => false));
                                if (!empty($all_locs) && !is_wp_error($all_locs)) {
                                    foreach ($all_locs as $loc) {
                                        echo '<option value="' . esc_attr($loc->slug) . '" ' . selected($current_lokasi, $loc->slug, false) . '>' . esc_html($loc->name) . ' (' . $loc->count . ')</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Tipe Pekerjaan Filter -->
                        <div class="hk-filter-group">
                            <label class="hk-filter-label"><?php _e('Tipe Pekerjaan', 'hakajobs'); ?></label>
                            <div class="hk-filter-radios">
                                <label class="hk-radio-item">
                                    <input type="radio" name="tipe" value="" <?php checked(empty($current_tipe)); ?>>
                                    <span><?php _e('Semua Tipe', 'hakajobs'); ?></span>
                                </label>
                                <?php
                                $all_types = get_terms(array('taxonomy' => 'tipe_pekerjaan', 'hide_empty' => false));
                                if (!empty($all_types) && !is_wp_error($all_types)) {
                                    foreach ($all_types as $type) {
                                        echo '<label class="hk-radio-item">';
                                        echo '<input type="radio" name="tipe" value="' . esc_attr($type->slug) . '" ' . checked($current_tipe, $type->slug, false) . '>';
                                        echo '<span>' . esc_html($type->name) . '</span>';
                                        echo '</label>';
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Tingkat Pengalaman Filter -->
                        <div class="hk-filter-group">
                            <label for="hk-f-exp" class="hk-filter-label"><?php _e('Pengalaman Kerja', 'hakajobs'); ?></label>
                            <select id="hk-f-exp" name="pengalaman" class="hk-filter-select">
                                <option value=""><?php _e('Semua Pengalaman', 'hakajobs'); ?></option>
                                <?php
                                $all_exps = get_terms(array('taxonomy' => 'pengalaman_kerja', 'hide_empty' => false));
                                if (!empty($all_exps) && !is_wp_error($all_exps)) {
                                    foreach ($all_exps as $exp) {
                                        echo '<option value="' . esc_attr($exp->slug) . '" ' . selected($current_exp, $exp->slug, false) . '>' . esc_html($exp->name) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Submit Filter Button -->
                        <div class="hk-filter-submit">
                            <button type="submit" class="hk-btn hk-btn-primary hk-btn-block">
                                <?php _e('Terapkan Filter', 'hakajobs'); ?>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Sidebar Ad Slot -->
                <?php if (function_exists('hakajobs_render_ad_slot')) { hakajobs_render_ad_slot('sidebar'); } ?>
            </aside>

            <!-- Right Results Column -->
            <div class="hk-directory-content">

                <!-- Header / Top Ad Slot -->
                <?php if (function_exists('hakajobs_render_ad_slot')) { hakajobs_render_ad_slot('header'); } ?>
                
                <!-- Results Bar (Count & Sorting) -->
                <div class="hk-results-toolbar">
                    <div class="hk-results-count">
                        <?php
                        global $wp_query;
                        $total_jobs = $wp_query->found_posts;
                        printf(
                            _n('Menampilkan <strong>%d</strong> lowongan kerja aktif', 'Menampilkan <strong>%d</strong> lowongan kerja aktif', $total_jobs, 'hakajobs'),
                            $total_jobs
                        );
                        ?>
                    </div>

                    <div class="hk-results-sorting">
                        <label for="hk-sort-select"><?php _e('Urutkan:', 'hakajobs'); ?></label>
                        <select id="hk-sort-select" onchange="location = this.value;">
                            <?php
                            $base_url = add_query_arg(array(
                                's_keyword'  => $current_keyword,
                                'kategori'   => $current_kategori,
                                'lokasi'     => $current_lokasi,
                                'tipe'       => $current_tipe,
                                'pengalaman' => $current_exp,
                            ));
                            ?>
                            <option value="<?php echo esc_url(add_query_arg('sort', 'terbaru', $base_url)); ?>" <?php selected($current_sort, 'terbaru'); ?>><?php _e('Terbaru Dipublikasikan', 'hakajobs'); ?></option>
                            <option value="<?php echo esc_url(add_query_arg('sort', 'populer', $base_url)); ?>" <?php selected($current_sort, 'populer'); ?>><?php _e('Paling Banyak Dilihat', 'hakajobs'); ?></option>
                            <option value="<?php echo esc_url(add_query_arg('sort', 'deadline', $base_url)); ?>" <?php selected($current_sort, 'deadline'); ?>><?php _e('Batas Lamaran Terdekat', 'hakajobs'); ?></option>
                        </select>
                    </div>
                </div>

                <!-- Active Filters Chips Bar -->
                <?php if ($has_active_filters): ?>
                    <div class="hk-active-chips-bar">
                        <span class="hk-chips-label"><?php _e('Filter aktif:', 'hakajobs'); ?></span>
                        
                        <?php if (!empty($current_keyword)): ?>
                            <span class="hk-active-chip">"<?php echo esc_html($current_keyword); ?>"</span>
                        <?php endif; ?>

                        <?php if (!empty($current_kategori)): ?>
                            <span class="hk-active-chip">Kategori: <?php echo esc_html($current_kategori); ?></span>
                        <?php endif; ?>

                        <?php if (!empty($current_lokasi)): ?>
                            <span class="hk-active-chip">Lokasi: <?php echo esc_html($current_lokasi); ?></span>
                        <?php endif; ?>

                        <?php if (!empty($current_tipe)): ?>
                            <span class="hk-active-chip">Tipe: <?php echo esc_html($current_tipe); ?></span>
                        <?php endif; ?>

                        <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" class="hk-clear-all-chips">
                            <?php _e('Hapus Semua', 'hakajobs'); ?> &times;
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Jobs Listing -->
                <?php if (have_posts()): ?>
                    <div class="hk-jobs-list">
                        <?php
                        while (have_posts()) {
                            the_post();
                            hakajobs_render_job_card(get_the_ID());
                        }
                        ?>
                    </div>

                    <!-- Pagination -->
                    <div class="hk-pagination-wrap">
                        <?php
                        the_posts_pagination(array(
                            'mid_size'  => 2,
                            'prev_text' => '&larr; ' . __('Sebelumnya', 'hakajobs'),
                            'next_text' => __('Selanjutnya', 'hakajobs') . ' &rarr;',
                        ));
                        ?>
                    </div>

                <?php else: ?>
                    
                    <!-- Empty Search / Filter Results -->
                    <div class="hk-empty-state">
                        <div class="hk-empty-icon">🔍</div>
                        <h3><?php _e('Tidak Ada Lowongan yang Cocok', 'hakajobs'); ?></h3>
                        <p><?php _e('Coba sesuaikan kata kunci atau bersihkan beberapa filter di sebelah kiri untuk melihat lebih banyak lowongan.', 'hakajobs'); ?></p>
                        <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" class="hk-btn hk-btn-primary">
                            <?php _e('Tampilkan Semua Lowongan', 'hakajobs'); ?>
                        </a>
                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>
</main>

<?php
get_footer();
