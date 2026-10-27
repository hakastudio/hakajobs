<?php
/**
 * Hakajobs Theme Functions and Definitions
 *
 * @package Hakajobs
 */

if (!defined('ABSPATH')) {
    exit;
}

define('HAKAJOBS_VERSION', '1.0.51');
define('HAKAJOBS_DIR', get_template_directory());
define('HAKAJOBS_URI', get_template_directory_uri());

/**
 * Include Required Modules
 */
require_once HAKAJOBS_DIR . '/inc/post-types.php';
require_once HAKAJOBS_DIR . '/inc/meta-boxes.php';
require_once HAKAJOBS_DIR . '/inc/template-tags.php';
require_once HAKAJOBS_DIR . '/inc/sample-data.php';
require_once HAKAJOBS_DIR . '/inc/starter-articles.php';
require_once HAKAJOBS_DIR . '/inc/seo.php';
require_once HAKAJOBS_DIR . '/inc/ads.php';
require_once HAKAJOBS_DIR . '/inc/customizer.php';
require_once HAKAJOBS_DIR . '/inc/updater.php';
require_once HAKAJOBS_DIR . '/inc/performance.php';
require_once HAKAJOBS_DIR . '/inc/push-notification.php';

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

    // Suffix for minified assets in production
    $min = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

    // Main Theme Stylesheet
    $css_file = file_exists(HAKAJOBS_DIR . '/assets/css/main' . $min . '.css') ? '/assets/css/main' . $min . '.css' : '/assets/css/main.css';
    wp_enqueue_style(
        'hakajobs-main-style',
        HAKAJOBS_URI . $css_file,
        array(),
        HAKAJOBS_VERSION
    );

    // Pasang Loker Stylesheet
    if (is_page_template('page-pasang-loker.php') || is_page('pasang-loker')) {
        $pl_css = file_exists(HAKAJOBS_DIR . '/assets/css/pasang-loker' . $min . '.css') ? '/assets/css/pasang-loker' . $min . '.css' : '/assets/css/pasang-loker.css';
        wp_enqueue_style(
            'hakajobs-pasang-loker',
            HAKAJOBS_URI . $pl_css,
            array('hakajobs-main-style'),
            HAKAJOBS_VERSION
        );
    }

    // Tes & Karir Stylesheet (Loaded on career pages, single posts, and category archives)
    if (
        is_page_template('page-tes-karir.php') || 
        is_page_template('page-test-karir.php') || 
        is_page(array('tes-karir', 'test-karir', 'persiapan-karir', 'latihan-soal')) ||
        is_single() ||
        is_category() ||
        is_archive()
    ) {
        $tk_css = file_exists(HAKAJOBS_DIR . '/assets/css/tes-karir' . $min . '.css') ? '/assets/css/tes-karir' . $min . '.css' : '/assets/css/tes-karir.css';
        wp_enqueue_style(
            'hakajobs-tes-karir',
            HAKAJOBS_URI . $tk_css,
            array('hakajobs-main-style'),
            HAKAJOBS_VERSION
        );
    }

    // Main Theme JavaScript (Deferred via inc/performance.php)
    $js_file = file_exists(HAKAJOBS_DIR . '/assets/js/main' . $min . '.js') ? '/assets/js/main' . $min . '.js' : '/assets/js/main.js';
    wp_enqueue_script(
        'hakajobs-main-script',
        HAKAJOBS_URI . $js_file,
        array(),
        HAKAJOBS_VERSION,
        true
    );

    // Localize Script for LocalStorage and AJAX info
    wp_localize_script('hakajobs-main-script', 'HakajobsData', array(
        'siteName'    => get_bloginfo('name'),
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
            'copiedSource'  => __('Teks disalin beserta sumber artikel!', 'hakajobs'),
        ),
    ));
}
add_action('wp_enqueue_scripts', 'hakajobs_enqueue_assets');

/**
 * Register Sidebars / Widget Areas
 */
function hakajobs_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar Kanan (Beranda & Halaman Statis)', 'hakajobs'),
        'id'            => 'sidebar-right',
        'description'   => __('Widget yang tampil di bilah kanan beranda dan halaman statis. Anda dapat menambahkan widget WordPress kustom di sini.', 'hakajobs'),
        'before_widget' => '<div id="%1$s" class="hk-widget-card %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="hk-widget-title">',
        'after_title'   => '</h3>',
    ));

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
    if ($query->is_post_type_archive('lowongan') || $query->is_tax(array('kategori_lowongan', 'lokasi_lowongan', 'tipe_pekerjaan', 'pengalaman_kerja')) || (is_search() && (!isset($_GET['post_type']) || $_GET['post_type'] === 'lowongan'))) {
        
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
            $tipe_val   = sanitize_text_field($_GET['tipe']);
            $tipe_terms = array($tipe_val);
            if ($tipe_val === 'part-time') {
                $tipe_terms[] = 'paruh-waktu';
            } elseif ($tipe_val === 'paruh-waktu') {
                $tipe_terms[] = 'part-time';
            } elseif ($tipe_val === 'full-time') {
                $tipe_terms[] = 'penuh-waktu';
            } elseif ($tipe_val === 'penuh-waktu') {
                $tipe_terms[] = 'full-time';
            }
            $tax_query[] = array(
                'taxonomy' => 'tipe_pekerjaan',
                'field'    => 'slug',
                'terms'    => $tipe_terms,
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
        } elseif (!empty($_GET['s'])) {
            $query->set('s', sanitize_text_field($_GET['s']));
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
 * Dapatkan URL halaman Pusat Tes & Karir
 */
function hakajobs_get_career_url() {
    $career_url = get_theme_mod('hakajobs_nav_career_url', '');
    if (empty($career_url)) {
        $career_page = get_page_by_path('tes-karir');
        if (!$career_page) {
            $career_page = get_page_by_path('test-karir');
        }
        $career_url = $career_page ? get_permalink($career_page->ID) : home_url('/tes-karir/');
    }
    return $career_url;
}

/**
 * Fallback Menu (dapat diatur via Customizer jika belum menggunakan Tampilan > Menu)
 *
 * @param bool $is_mobile
 */
function hakajobs_fallback_menu($is_mobile = false) {
    $class      = $is_mobile ? 'hk-mobile-nav-list' : 'hk-nav-list';
    $home_label = get_theme_mod('hakajobs_nav_home_label', __('Beranda', 'hakajobs'));
    $all_label  = get_theme_mod('hakajobs_nav_all_label', __('Semua Lowongan', 'hakajobs'));
    
    // Dropdown 1: Kategori Loker
    $show_cat_menu = get_theme_mod('hakajobs_nav_show_cat_menu', '1');
    $cat_label     = get_theme_mod('hakajobs_nav_cat_label', __('Kategori Loker', 'hakajobs'));
    
    // Dropdown 2: Tes & Karir
    $show_career_menu = get_theme_mod('hakajobs_nav_show_career_menu', '1');
    $career_label     = get_theme_mod('hakajobs_nav_career_label', __('Tes & Karir', 'hakajobs'));

    $post_label = get_theme_mod('hakajobs_post_job_label', __('Pasang Loker', 'hakajobs'));
    $post_url   = get_theme_mod('hakajobs_post_job_url', home_url('/pasang-loker/'));
    $show_post  = get_theme_mod('hakajobs_nav_show_post_job', '0');

    $archive_url = get_post_type_archive_link('lowongan');

    echo '<ul class="' . esc_attr($class) . '">';
    if (!empty($home_label)) {
        echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html($home_label) . '</a></li>';
    }
    if (!empty($all_label)) {
        echo '<li><a href="' . esc_url($archive_url) . '">' . esc_html($all_label) . '</a></li>';
    }

    // Dropdown: Kategori Loker
    if ($show_cat_menu === '1') {
        echo '<li class="menu-item-has-children">';
        echo '<a href="' . esc_url($archive_url) . '">' . esc_html($cat_label) . '</a>';
        echo '<ul class="sub-menu">';
        echo '<li><a href="' . esc_url($archive_url . '?tipe=full-time') . '">' . __('Full-Time', 'hakajobs') . '</a></li>';
        echo '<li><a href="' . esc_url($archive_url . '?tipe=part-time') . '">' . __('Part-Time', 'hakajobs') . '</a></li>';
        echo '<li><a href="' . esc_url($archive_url . '?tipe=magang') . '">' . __('Magang (Internship)', 'hakajobs') . '</a></li>';
        echo '<li><a href="' . esc_url($archive_url . '?tipe=remote') . '">' . __('Remote / WFH', 'hakajobs') . '</a></li>';
        echo '</ul>';
        echo '</li>';
    }

    // Link Halaman: Tes & Karir (Pusat Persiapan Karir & Latihan Tes Kerja)
    if ($show_career_menu === '1') {
        $career_url = hakajobs_get_career_url();
        echo '<li><a href="' . esc_url($career_url) . '">' . esc_html($career_label) . '</a></li>';
    }

    if ($show_post === '1' && !empty($post_label) && !empty($post_url)) {
        echo '<li><a href="' . esc_url($post_url) . '" class="hk-menu-highlight">' . esc_html($post_label) . '</a></li>';
    }
    echo '</ul>';
}

/**
 * Otomatis sinkronisasi istilah taksonomi tipe pekerjaan dari Penuh Waktu -> Full-Time dan Paruh Waktu -> Part-Time
 */
function hakajobs_sync_job_types() {
    if (get_option('hakajobs_job_types_synced_v2') === '1') {
        return;
    }

    if (!taxonomy_exists('tipe_pekerjaan')) {
        return;
    }

    $term_penuh = get_term_by('name', 'Penuh Waktu', 'tipe_pekerjaan');
    if ($term_penuh && !is_wp_error($term_penuh)) {
        wp_update_term($term_penuh->term_id, 'tipe_pekerjaan', array(
            'name' => 'Full-Time',
            'slug' => 'full-time',
        ));
    }

    $term_paruh = get_term_by('name', 'Paruh Waktu', 'tipe_pekerjaan');
    if ($term_paruh && !is_wp_error($term_paruh)) {
        wp_update_term($term_paruh->term_id, 'tipe_pekerjaan', array(
            'name' => 'Part-Time',
            'slug' => 'part-time',
        ));
    }

    update_option('hakajobs_job_types_synced_v2', '1');
}
add_action('init', 'hakajobs_sync_job_types', 20);

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
 * Otomatis pastikan halaman default (Pasang Loker & Pusat Tes Karir) terbuat dan terbit di WordPress
 */
function hakajobs_ensure_default_pages() {
    // 1. Halaman Pasang Loker
    if (!get_page_by_path('pasang-loker')) {
        $pl_id = wp_insert_post(array(
            'post_title'     => __('Pasang Lowongan Kerja', 'hakajobs'),
            'post_name'      => 'pasang-loker',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'comment_status' => 'closed',
        ));
        if ($pl_id && !is_wp_error($pl_id)) {
            update_post_meta($pl_id, '_wp_page_template', 'page-pasang-loker.php');
        }
    }

    // 2. Halaman Pusat Tes & Karir
    if (!get_page_by_path('tes-karir') && !get_page_by_path('test-karir')) {
        $tk_id = wp_insert_post(array(
            'post_title'     => __('Pusat Tes & Karir', 'hakajobs'),
            'post_name'      => 'tes-karir',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'comment_status' => 'closed',
        ));
        if ($tk_id && !is_wp_error($tk_id)) {
            update_post_meta($tk_id, '_wp_page_template', 'page-tes-karir.php');
        }
    }
}
add_action('init', 'hakajobs_ensure_default_pages');
add_action('after_switch_theme', 'hakajobs_ensure_default_pages');

/**
 * Interceptor Template: Memastikan URL /tes-karir/ atau /test-karir/ selalu memuat template page-tes-karir.php
 * Mencegah 404 atau redirect ke beranda bila permalink belum di-flush atau laman belum terdaftar.
 */
function hakajobs_career_template_loader($template) {
    global $wp_query;

    if (is_page('tes-karir') || is_page('test-karir') || is_page_template('page-tes-karir.php') || is_page_template('page-test-karir.php')) {
        $career_tpl = locate_template(array('page-tes-karir.php', 'page-test-karir.php'));
        if ($career_tpl) {
            return $career_tpl;
        }
    }

    $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    $path = trim(parse_url($request_uri, PHP_URL_PATH), '/');
    $segments = explode('/', $path);
    $last_slug = end($segments);

    if (in_array($last_slug, array('tes-karir', 'test-karir', 'persiapan-karir'), true)) {
        $career_tpl = locate_template(array('page-tes-karir.php', 'page-test-karir.php'));
        if ($career_tpl) {
            $wp_query->is_404 = false;
            $wp_query->is_page = true;
            status_header(200);
            return $career_tpl;
        }
    }

    return $template;
}
add_filter('template_include', 'hakajobs_career_template_loader', 99);

/**
 * Hilangkan tag judul screen-reader "Paginasi pos" dari output the_posts_pagination()
 * Memastikan tampilan paginasi bersih tanpa teks heading yang bocor ke visual pengguna.
 */
function hakajobs_navigation_markup_template($template, $class) {
    return '
    <nav class="navigation %1$s" aria-label="%4$s">
        <div class="nav-links">%3$s</div>
    </nav>';
}
add_filter('navigation_markup_template', 'hakajobs_navigation_markup_template', 10, 2);

/**
 * Standarisasi dan percantik markup tombol aksi latihan soal interaktif di konten artikel
 * Memastikan tombol pada artikel yang sudah terbit di basis data tetap rapi dengan ikon SVG dan perataan presisi.
 */
function hakajobs_filter_soal_buttons_markup($content) {
    if (empty($content) || stristr($content, 'hk-soal-') === false) {
        return $content;
    }

    // 1. Standardisasi tombol Kunci & Pembahasan jika belum memiliki SVG
    $content = preg_replace_callback(
        '/<button([^>]*class=["\'][^"\']*hk-soal-toggle-btn[^"\']*["\'][^>]*)>(.*?)<\/button>/is',
        function ($m) {
            $attrs = $m[1];
            $inner = $m[2];
            if (strpos($inner, '<svg') !== false) {
                return $m[0];
            }
            $clean_text = trim(strip_tags($inner));
            if (empty($clean_text)) {
                $clean_text = 'Kunci &amp; Pembahasan';
            }
            if (strpos($attrs, 'hk-btn') === false) {
                $attrs = preg_replace('/class=["\'](.*?)["\']/', 'class="$1 hk-btn"', $attrs);
            }
            $svg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 12 12 12 8"></polyline></svg>';
            return '<button ' . trim($attrs) . '>' . $svg . '<span>' . $clean_text . '</span></button>';
        },
        $content
    );

    // 2. Standardisasi tombol Ulangi Soal
    $content = preg_replace_callback(
        '/<button([^>]*resetArticleAnswer[^>]*)>(.*?)<\/button>/is',
        function ($m) {
            $attrs = $m[1];
            $inner = $m[2];
            if (strpos($inner, '<svg') !== false) {
                return $m[0];
            }
            $clean_text = trim(str_replace('🔄', '', strip_tags($inner)));
            if (empty($clean_text)) {
                $clean_text = 'Ulangi Soal';
            }
            if (strpos($attrs, 'hk-btn') === false) {
                $attrs = preg_replace('/class=["\'](.*?)["\']/', 'class="$1 hk-btn hk-btn-subtle hk-btn-sm"', $attrs);
            }
            if (strpos($attrs, 'margin-left') === false) {
                $attrs = rtrim($attrs) . ' style="margin-left:auto;"';
            }
            $svg = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"></path></svg>';
            return '<button ' . trim($attrs) . '>' . $svg . '<span>' . $clean_text . '</span></button>';
        },
        $content
    );

    return $content;
}
add_filter('the_content', 'hakajobs_filter_soal_buttons_markup', 15);


