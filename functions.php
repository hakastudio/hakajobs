<?php
/**
 * Hakajobs Theme Functions and Definitions
 *
 * @package Hakajobs
 */

if (!defined('ABSPATH')) {
    exit;
}

define('HAKAJOBS_VERSION', '1.0.6');
define('HAKAJOBS_DIR', get_template_directory());
define('HAKAJOBS_URI', get_template_directory_uri());

/**
 * Include Required Modules
 */
require_once HAKAJOBS_DIR . '/inc/post-types.php';
require_once HAKAJOBS_DIR . '/inc/meta-boxes.php';
require_once HAKAJOBS_DIR . '/inc/template-tags.php';
require_once HAKAJOBS_DIR . '/inc/sample-data.php';
require_once HAKAJOBS_DIR . '/inc/seo.php';
require_once HAKAJOBS_DIR . '/inc/ads.php';
require_once HAKAJOBS_DIR . '/inc/customizer.php';
require_once HAKAJOBS_DIR . '/inc/updater.php';

/**
 * Theme Setup
 */
function hakajobs_setup() {
    // Translation support
    load_theme_textdomain('hakajobs', HAKAJOBS_DIR . '/languages');

    // Title tag
    add_theme_support('title-tag');

    // Featured images
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(120, 120, true);
    add_image_size('hakajobs-company-logo', 96, 96, true);
    add_image_size('hakajobs-card-thumb', 360, 200, true);

    // Custom Logo
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 220,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // HTML5 markup
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Register Navigation Menus
    register_nav_menus(array(
        'primary-menu'     => __('Menu Utama (Header)', 'hakajobs'),
        'footer-col2-menu' => __('Footer Kolom 2 (Kategori Pekerjaan)', 'hakajobs'),
        'footer-col3-menu' => __('Footer Kolom 3 (Kota & Wilayah)', 'hakajobs'),
        'footer-col4-menu' => __('Footer Kolom 4 (Navigasi & Info)', 'hakajobs'),
        'footer-menu'      => __('Menu Footer Cadangan', 'hakajobs'),
    ));
}
add_action('after_setup_theme', 'hakajobs_setup');

/**
 * Enqueue Scripts and Styles
 */
function hakajobs_enqueue_assets() {
    // Google Fonts (Plus Jakarta Sans)
    wp_enqueue_style(
        'hakajobs-fonts',
        'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap',
        array(),
        null
    );

    // Main Theme Stylesheet
    wp_enqueue_style(
        'hakajobs-main-style',
        HAKAJOBS_URI . '/assets/css/main.css',
        array(),
        HAKAJOBS_VERSION
    );

    // Pasang Loker Stylesheet
    if (is_page_template('page-pasang-loker.php') || is_page('pasang-loker')) {
        wp_enqueue_style(
            'hakajobs-pasang-loker',
            HAKAJOBS_URI . '/assets/css/pasang-loker.css',
            array('hakajobs-main-style'),
            HAKAJOBS_VERSION
        );
    }

    // Main Theme JavaScript
    wp_enqueue_script(
        'hakajobs-main-script',
        HAKAJOBS_URI . '/assets/js/main.js',
        array(),
        HAKAJOBS_VERSION,
        true
    );

    // Localize Script for LocalStorage and AJAX info
    wp_localize_script('hakajobs-main-script', 'HakajobsData', array(
        'ajaxUrl'     => admin_url('admin-ajax.php'),
        'homeUrl'     => home_url('/'),
        'archiveUrl'  => get_post_type_archive_link('lowongan'),
        'savedJobsUrl'=> home_url('/tersimpan/'),
        'strings'     => array(
            'saved'         => __('Tersimpan', 'hakajobs'),
            'save'          => __('Simpan Lowongan', 'hakajobs'),
            'removed'       => __('Dihapus dari simpanan', 'hakajobs'),
            'linkCopied'    => __('Tautan berhasil disalin!', 'hakajobs'),
            'noSavedJobs'   => __('Belum ada lowongan yang disimpan.', 'hakajobs'),
        ),
    ));
}
add_action('wp_enqueue_scripts', 'hakajobs_enqueue_assets');

/**
 * Register Sidebars / Widget Areas
 */
function hakajobs_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar Lowongan', 'hakajobs'),
        'id'            => 'sidebar-job',
        'description'   => __('Widget yang tampil di sidebar halaman arsip/pencarian lowongan.', 'hakajobs'),
        'before_widget' => '<div id="%1$s" class="hk-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="hk-widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Kolom 1 (Tentang & Brand)', 'hakajobs'),
        'id'            => 'footer-1',
        'description'   => __('Widget kolom 1 footer (opsional, menggantikan info brand bawaan jika diisi).', 'hakajobs'),
        'before_widget' => '<div id="%1$s" class="hk-footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="hk-footer-heading">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Kolom 2 (Kategori)', 'hakajobs'),
        'id'            => 'footer-2',
        'description'   => __('Widget kolom 2 footer (opsional, menggantikan daftar kategori bawaan jika diisi).', 'hakajobs'),
        'before_widget' => '<div id="%1$s" class="hk-footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="hk-footer-heading">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Kolom 3 (Kota & Wilayah)', 'hakajobs'),
        'id'            => 'footer-3',
        'description'   => __('Widget kolom 3 footer (opsional, menggantikan daftar kota bawaan jika diisi).', 'hakajobs'),
        'before_widget' => '<div id="%1$s" class="hk-footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="hk-footer-heading">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Kolom 4 (Navigasi & Info)', 'hakajobs'),
        'id'            => 'footer-4',
        'description'   => __('Widget kolom 4 footer (opsional, menggantikan daftar tautan bawaan jika diisi).', 'hakajobs'),
        'before_widget' => '<div id="%1$s" class="hk-footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="hk-footer-heading">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'hakajobs_widgets_init');

/**
 * Custom Search & Filter Query Modifier for Lowongan
 */
function hakajobs_filter_job_query($query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    // Apply to lowongan archive, search, or taxonomy
    if ($query->is_post_type_archive('lowongan') || $query->is_tax(array('kategori_lowongan', 'lokasi_lowongan', 'tipe_pekerjaan', 'pengalaman_kerja')) || (is_search() && isset($_GET['post_type']) && $_GET['post_type'] === 'lowongan')) {
        
        $query->set('post_type', 'lowongan');
        $query->set('posts_per_page', 12);

        $tax_query = array('relation' => 'AND');

        // Filter: Kategori
        if (!empty($_GET['kategori'])) {
            $tax_query[] = array(
                'taxonomy' => 'kategori_lowongan',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_GET['kategori']),
            );
        }

        // Filter: Lokasi
        if (!empty($_GET['lokasi'])) {
            $tax_query[] = array(
                'taxonomy' => 'lokasi_lowongan',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_GET['lokasi']),
            );
        }

        // Filter: Tipe Pekerjaan
        if (!empty($_GET['tipe'])) {
            $tax_query[] = array(
                'taxonomy' => 'tipe_pekerjaan',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_GET['tipe']),
            );
        }

        // Filter: Tingkat Pengalaman
        if (!empty($_GET['pengalaman'])) {
            $tax_query[] = array(
                'taxonomy' => 'pengalaman_kerja',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_GET['pengalaman']),
            );
        }

        if (count($tax_query) > 1) {
            $query->set('tax_query', $tax_query);
        }

        // Keyword Search (by title or company name)
        if (!empty($_GET['s_keyword'])) {
            $query->set('s', sanitize_text_field($_GET['s_keyword']));
        }

        // Sorting
        $sort = !empty($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'terbaru';
        if ($sort === 'populer') {
            $query->set('meta_key', '_hakajobs_views_count');
            $query->set('orderby', 'meta_value_num');
            $query->set('order', 'DESC');
        } elseif ($sort === 'deadline') {
            $query->set('meta_key', '_hakajobs_deadline');
            $query->set('orderby', 'meta_value');
            $query->set('order', 'ASC');
        } else {
            $query->set('orderby', 'date');
            $query->set('order', 'DESC');
        }
    }
}
add_action('pre_get_posts', 'hakajobs_filter_job_query');

/**
 * Fallback Menu (dapat diatur via Customizer jika belum menggunakan Tampilan > Menu)
 *
 * @param bool $is_mobile
 */
function hakajobs_fallback_menu($is_mobile = false) {
    $class      = $is_mobile ? 'hk-mobile-nav-list' : 'hk-nav-list';
    $home_label = get_theme_mod('hakajobs_nav_home_label', __('Beranda', 'hakajobs'));
    $all_label  = get_theme_mod('hakajobs_nav_all_label', __('Semua', 'hakajobs'));
    $c1_label   = get_theme_mod('hakajobs_nav_custom1_label', __('Magang (Internship)', 'hakajobs'));
    $c1_url     = get_theme_mod('hakajobs_nav_custom1_url', get_post_type_archive_link('lowongan') . '?tipe=magang');
    $c2_label   = get_theme_mod('hakajobs_nav_custom2_label', __('Paruh Waktu', 'hakajobs'));
    $c2_url     = get_theme_mod('hakajobs_nav_custom2_url', get_post_type_archive_link('lowongan') . '?tipe=paruh-waktu');
    $post_label = get_theme_mod('hakajobs_post_job_label', __('Pasang Loker', 'hakajobs'));
    $post_url   = get_theme_mod('hakajobs_post_job_url', home_url('/pasang-loker/'));
    $show_post  = get_theme_mod('hakajobs_nav_show_post_job', '1');

    echo '<ul class="' . esc_attr($class) . '">';
    if (!empty($home_label)) {
        echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html($home_label) . '</a></li>';
    }
    if (!empty($all_label)) {
        echo '<li><a href="' . esc_url(get_post_type_archive_link('lowongan')) . '">' . esc_html($all_label) . '</a></li>';
    }
    if (!empty($c1_label) && !empty($c1_url)) {
        echo '<li><a href="' . esc_url($c1_url) . '">' . esc_html($c1_label) . '</a></li>';
    }
    if (!empty($c2_label) && !empty($c2_url)) {
        echo '<li><a href="' . esc_url($c2_url) . '">' . esc_html($c2_label) . '</a></li>';
    }
    if ($show_post === '1' && !empty($post_label) && !empty($post_url)) {
        echo '<li><a href="' . esc_url($post_url) . '" class="hk-menu-highlight">' . esc_html($post_label) . '</a></li>';
    }
    echo '</ul>';
}

/**
 * Increment view count on single lowongan
 */
function hakajobs_track_single_views() {
    if (is_singular('lowongan')) {
        hakajobs_set_views(get_the_ID());
    }
}
add_action('wp_head', 'hakajobs_track_single_views');

/**
 * Auto-create default pages (such as Pasang Loker) on theme activation
 */
function hakajobs_create_default_pages() {
    if (!get_page_by_path('pasang-loker')) {
        $page_id = wp_insert_post(array(
            'post_title'     => __('Pasang Lowongan Kerja', 'hakajobs'),
            'post_name'      => 'pasang-loker',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'comment_status' => 'closed',
        ));
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'page-pasang-loker.php');
        }
    }
}
add_action('after_switch_theme', 'hakajobs_create_default_pages');

