<?php
/**
 * SEO & Schema.org Optimization Engine for Hakajobs
 *
 * @package Hakajobs
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Output Comprehensive SEO Meta Tags in <head>
 * (Auto-disables if popular SEO plugins like Yoast or RankMath are installed to avoid duplicate tags)
 */
function hakajobs_seo_meta_tags() {
    $seo_enabled = get_theme_mod('hakajobs_seo_enable', '1');
    if ($seo_enabled !== '1') {
        return;
    }

    // Skip if Yoast, Rank Math, or All in One SEO is active
    if (defined('WPSEO_VERSION') || class_exists('RankMath') || defined('AIOSEO_VERSION')) {
        return;
    }

    global $post, $wp_query;

    $site_name        = get_bloginfo('name');
    $site_description = get_bloginfo('description');
    $default_desc     = get_theme_mod('hakajobs_default_meta_desc', $site_description);
    $default_image    = get_theme_mod('hakajobs_default_share_image', '');

    $title       = '';
    $description = '';
    $canonical   = '';
    $og_type     = 'website';
    $og_image    = $default_image;

    if (is_front_page() || is_home()) {
        $title       = $site_name . (!empty($site_description) ? ' — ' . $site_description : '');
        $description = !empty($default_desc) ? $default_desc : 'Portal informasi lowongan kerja terpercaya di Indonesia. Lamar kerja langsung ke HRD via WhatsApp & Email tanpa perlu registrasi akun.';
        $canonical   = home_url('/');
        $og_type     = 'website';
    } elseif (is_singular('lowongan')) {
        $post_id          = get_the_ID();
        $company_name     = get_post_meta($post_id, '_hakajobs_company_name', true);
        $location         = get_post_meta($post_id, '_hakajobs_company_location', true);
        $salary           = get_post_meta($post_id, '_hakajobs_salary', true);
        
        $terms_location   = get_the_terms($post_id, 'lokasi_lowongan');
        $city             = (!empty($terms_location) && !is_wp_error($terms_location)) ? $terms_location[0]->name : $location;

        $title = get_the_title() . ($company_name ? ' — ' . $company_name : '') . ' | ' . $site_name;

        // Custom rich meta description for high Google search CTR
        $desc_parts = array();
        $desc_parts[] = sprintf(__('Info lowongan kerja %s', 'hakajobs'), get_the_title());
        if (!empty($company_name)) {
            $desc_parts[] = sprintf(__('di %s', 'hakajobs'), $company_name);
        }
        if (!empty($city)) {
            $desc_parts[] = sprintf(__('(Lokasi: %s)', 'hakajobs'), $city);
        }
        if (!empty($salary)) {
            $desc_parts[] = sprintf(__('Gaji: %s.', 'hakajobs'), $salary);
        }
        $desc_parts[] = __('Lamar langsung ke HRD via WhatsApp/Email tanpa registrasi akun.', 'hakajobs');
        
        $description = implode(' ', $desc_parts);
        $canonical   = get_permalink($post_id);
        $og_type     = 'article';

        if (has_post_thumbnail($post_id)) {
            $og_image = get_the_post_thumbnail_url($post_id, 'large');
        }
    } elseif (is_singular()) {
        $title       = get_the_title() . ' | ' . $site_name;
        $description = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_post_field('post_content', get_the_ID()), 28, '...');
        $canonical   = get_permalink();
        $og_type     = 'article';
        if (has_post_thumbnail()) {
            $og_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
        }
    } elseif (is_post_type_archive('lowongan')) {
        $title       = __('Direktori Lowongan Kerja Terbaru', 'hakajobs') . ' | ' . $site_name;
        $description = __('Temukan ribuan lowongan kerja terupdate hari ini. Filter berdasarkan posisi, kota, tipe kerja remote, dan kirim lamaran langsung.', 'hakajobs');
        $canonical   = get_post_type_archive_link('lowongan');
        $og_type     = 'website';
    } elseif (is_tax()) {
        $term        = get_queried_object();
        $title       = sprintf(__('Lowongan Kerja %s', 'hakajobs'), $term->name) . ' | ' . $site_name;
        $description = !empty($term->description) ? wp_strip_all_tags($term->description) : sprintf(__('Daftar lowongan kerja bidang / lokasi %s terbaru. Lamar langsung tanpa ribet registrasi.', 'hakajobs'), $term->name);
        $canonical   = get_term_link($term);
        $og_type     = 'website';
    } elseif (is_search()) {
        $query_str   = get_search_query();
        $title       = sprintf(__('Pencarian Lowongan: %s', 'hakajobs'), esc_html($query_str)) . ' | ' . $site_name;
        $description = sprintf(__('Hasil pencarian lowongan kerja untuk kata kunci "%s".', 'hakajobs'), esc_html($query_str));
        $canonical   = home_url('/?s=' . urlencode($query_str));
    }

    $description = esc_attr(trim(preg_replace('/\s+/', ' ', strip_tags($description))));

    echo "\n<!-- Hakajobs SEO & Fast-Indexing Engine -->\n";
    if (!empty($description)) {
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    }

    // Google Search Robots
    echo '<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">' . "\n";

    if (!empty($canonical)) {
        echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";
    }

    // Search Engine Verifications
    $google_ver = get_theme_mod('hakajobs_google_verification', '');
    if (!empty($google_ver)) {
        echo '<meta name="google-site-verification" content="' . esc_attr($google_ver) . '">' . "\n";
    }
    $bing_ver = get_theme_mod('hakajobs_bing_verification', '');
    if (!empty($bing_ver)) {
        echo '<meta name="msvalidate.01" content="' . esc_attr($bing_ver) . '">' . "\n";
    }

    // Open Graph (Facebook, WhatsApp, LinkedIn, Telegram)
    echo '<meta property="og:locale" content="' . esc_attr(get_locale()) . '">' . "\n";
    echo '<meta property="og:type" content="' . esc_attr($og_type) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    if (!empty($description)) {
        echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    }
    if (!empty($canonical)) {
        echo '<meta property="og:url" content="' . esc_url($canonical) . '">' . "\n";
    }
    echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '">' . "\n";
    if (!empty($og_image)) {
        echo '<meta property="og:image" content="' . esc_url($og_image) . '">' . "\n";
    }

    // Twitter / X Cards
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
    if (!empty($description)) {
        echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";
    }
    if (!empty($og_image)) {
        echo '<meta name="twitter:image" content="' . esc_url($og_image) . '">' . "\n";
    }
}
add_action('wp_head', 'hakajobs_seo_meta_tags', 1);

/**
 * Output WebSite & Sitelinks Searchbox JSON-LD Schema
 */
function hakajobs_schema_website() {
    if (!is_front_page()) {
        return;
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type'    => 'WebSite',
        'name'     => get_bloginfo('name'),
        'url'      => home_url('/'),
        'description' => get_bloginfo('description'),
        'potentialAction' => array(
            '@type'       => 'SearchAction',
            'target'      => home_url('/?post_type=lowongan&s_keyword={search_term_string}'),
            'query-input' => 'required name=search_term_string',
        ),
    );

    echo "\n<!-- Schema.org WebSite & Sitelinks Searchbox by Hakajobs -->\n";
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'hakajobs_schema_website', 2);

/**
 * Output BreadcrumbList JSON-LD Schema on Single Jobs and Taxonomies
 */
function hakajobs_schema_breadcrumbs() {
    $breadcrumbs = array();
    $breadcrumbs[] = array(
        '@type'    => 'ListItem',
        'position' => 1,
        'name'     => __('Beranda', 'hakajobs'),
        'item'     => home_url('/'),
    );

    if (is_singular('lowongan')) {
        $breadcrumbs[] = array(
            '@type'    => 'ListItem',
            'position' => 2,
            'name'     => __('Lowongan Kerja', 'hakajobs'),
            'item'     => get_post_type_archive_link('lowongan'),
        );
        $breadcrumbs[] = array(
            '@type'    => 'ListItem',
            'position' => 3,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );
    } elseif (is_tax()) {
        $term = get_queried_object();
        $breadcrumbs[] = array(
            '@type'    => 'ListItem',
            'position' => 2,
            'name'     => __('Lowongan Kerja', 'hakajobs'),
            'item'     => get_post_type_archive_link('lowongan'),
        );
        $breadcrumbs[] = array(
            '@type'    => 'ListItem',
            'position' => 3,
            'name'     => $term->name,
            'item'     => get_term_link($term),
        );
    } else {
        return;
    }

    $schema = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $breadcrumbs,
    );

    echo "\n<!-- Schema.org Breadcrumbs by Hakajobs -->\n";
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'hakajobs_schema_breadcrumbs', 3);

/**
 * Automatically prevent duplicate JobPosting schema from Rank Math on single lowongan.
 * Hakajobs already outputs fully structured Google-compliant JobPosting JSON-LD.
 */
add_filter('rank_math/json_ld', function ($data, $jsonld) {
    if (is_singular('lowongan')) {
        if (isset($data['JobPosting'])) {
            unset($data['JobPosting']);
        }
        if (isset($data['richSnippet'])) {
            unset($data['richSnippet']);
        }
    }
    return $data;
}, 99, 2);

add_filter('rank_math/snippet/rich_snippet', function ($snippet) {
    if (is_singular('lowongan')) {
        return false;
    }
    return $snippet;
}, 99);

