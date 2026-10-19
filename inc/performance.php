<?php
/**
 * Hakajobs Speed & Google PageSpeed Core Web Vitals Optimizer
 *
 * Optimizes FCP, LCP, CLS, and TBT for 90+ score on Google PageSpeed Insights.
 *
 * @package Hakajobs
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Preconnect & DNS-Prefetch Resource Hints for Google Fonts & External Assets
 */
function hakajobs_speed_resource_hints($urls, $relation_type) {
    if ('preconnect' === $relation_type) {
        $urls[] = array(
            'href'        => 'https://fonts.googleapis.com',
            'crossorigin' => 'anonymous',
        );
        $urls[] = array(
            'href'        => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
    } elseif ('dns-prefetch' === $relation_type) {
        $urls[] = 'https://fonts.googleapis.com';
        $urls[] = 'https://fonts.gstatic.com';
    }
    return $urls;
}
add_filter('wp_resource_hints', 'hakajobs_speed_resource_hints', 10, 2);

/**
 * 2. Add 'defer' to Theme JavaScript to Eliminate Render-Blocking Resources
 */
function hakajobs_defer_scripts($tag, $handle, $src) {
    // Jangan defer di wp-admin
    if (is_admin()) {
        return $tag;
    }

    // List handles to defer
    $defer_handles = array(
        'hakajobs-main-script',
    );

    if (in_array($handle, $defer_handles, true)) {
        if (strpos($tag, ' defer') === false) {
            $tag = str_replace(' src', ' defer src', $tag);
        }
    }
    return $tag;
}
add_filter('script_loader_tag', 'hakajobs_defer_scripts', 10, 3);

/**
 * 3. Clean WordPress Core Head Bloat & Unused Scripts
 * Menghemat 30-50KB dan menghilangkan render-blocking HTTP requests yang tidak perlu
 */
function hakajobs_clean_wp_head() {
    // Nonaktifkan WordPress Emojis (CSS & JS)
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    // Hapus generator meta tag & XML-RPC link bawaan WP
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);

    // Hapus WP Embed script
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');

    // Hapus inline SVG Duotone filter yang diinject WP 5.9+ di body
    remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
}
add_action('init', 'hakajobs_clean_wp_head');

/**
 * 4. Hapus TinyMCE Emoji Plugin
 */
add_filter('tiny_mce_plugins', function ($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    }
    return array();
});

/**
 * 5. Optimasi Custom Logo untuk Mencegah Cumulative Layout Shift (CLS)
 */
function hakajobs_optimize_custom_logo($html) {
    if (empty($html)) {
        return $html;
    }
    // Tambahkan decoding async & fetchpriority high untuk logo header
    if (strpos($html, 'decoding=') === false) {
        $html = str_replace('<img ', '<img decoding="async" fetchpriority="high" ', $html);
    }
    return $html;
}
add_filter('get_custom_logo', 'hakajobs_optimize_custom_logo');

/**
 * 6. Conditional Enqueue untuk Gutenberg Block Library
 * Menghilangkan ~80KB Gutenberg CSS pada halaman arsip dan single loker
 */
function hakajobs_optimize_block_styles() {
    if (!is_admin() && (is_front_page() || is_singular('lowongan') || is_post_type_archive('lowongan') || is_tax(array('kategori_lowongan', 'lokasi_lowongan', 'tipe_pekerjaan', 'pengalaman_kerja')))) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-blocks-style');
        wp_dequeue_style('classic-theme-styles');
    }
}
add_action('wp_enqueue_scripts', 'hakajobs_optimize_block_styles', 100);
