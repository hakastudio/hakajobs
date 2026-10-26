<?php
/**
 * Progressive Web App (PWA) Module for Hakajobs
 * 
 * Features:
 * - Dynamic Web App Manifest (manifest.webmanifest)
 * - Service Worker with Offline Fallback & Stale-While-Revalidate caching
 * - Native Add-to-Home-Screen (A2HS) Floating Install Banner
 * - Full Customization via WordPress Customizer
 * - Standalone offline experience with link to Saved Jobs (LocalStorage)
 *
 * @package Hakajobs
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Register Customizer Options for PWA
 */
function hakajobs_pwa_customize_register($wp_customize) {
    $wp_customize->add_section('hakajobs_pwa_section', array(
        'title'       => __('📲 Aplikasi Web (PWA)', 'hakajobs'),
        'description' => __('Konfigurasi Progressive Web App (PWA) agar situs dapat diinstal di layar utama (home screen) smartphone Android/iOS maupun desktop Chrome/Edge tanpa Play Store.', 'hakajobs'),
        'priority'    => 138,
    ));

    // Enable PWA
    $wp_customize->add_setting('hakajobs_pwa_enable', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
    ));
    $wp_customize->add_control('hakajobs_pwa_enable', array(
        'label'       => __('Aktifkan Fitur PWA & Service Worker', 'hakajobs'),
        'description' => __('Mengaktifkan manifest web app, service worker offline caching, dan kemampuan instalasi mandiri.', 'hakajobs'),
        'section'     => 'hakajobs_pwa_section',
        'type'        => 'checkbox',
    ));

    // Enable Install Prompt Banner
    $wp_customize->add_setting('hakajobs_pwa_install_prompt', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
    ));
    $wp_customize->add_control('hakajobs_pwa_install_prompt', array(
        'label'       => __('Tampilkan Banner Mengajak Instal Aplikasi', 'hakajobs'),
        'description' => __('Menampilkan kartu melayang di sudut layar untuk mengajak pengunjung memasang aplikasi ke ponsel/PC.', 'hakajobs'),
        'section'     => 'hakajobs_pwa_section',
        'type'        => 'checkbox',
    ));

    // App Name
    $wp_customize->add_setting('hakajobs_pwa_app_name', array(
        'default'           => get_bloginfo('name'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_pwa_app_name', array(
        'label'       => __('Nama Lengkap Aplikasi (App Name)', 'hakajobs'),
        'section'     => 'hakajobs_pwa_section',
        'type'        => 'text',
    ));

    // Short Name
    $wp_customize->add_setting('hakajobs_pwa_short_name', array(
        'default'           => wp_trim_words(get_bloginfo('name'), 2, ''),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_pwa_short_name', array(
        'label'       => __('Nama Singkat di Home Screen (Maks 12 Karakter)', 'hakajobs'),
        'section'     => 'hakajobs_pwa_section',
        'type'        => 'text',
    ));

    // Description
    $wp_customize->add_setting('hakajobs_pwa_desc', array(
        'default'           => get_bloginfo('description') ?: __('Portal Info Lowongan Kerja & Latihan Soal Karir Terlengkap', 'hakajobs'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('hakajobs_pwa_desc', array(
        'label'       => __('Deskripsi Singkat Aplikasi', 'hakajobs'),
        'section'     => 'hakajobs_pwa_section',
        'type'        => 'textarea',
    ));

    // Theme Color
    $wp_customize->add_setting('hakajobs_pwa_theme_color', array(
        'default'           => '#0284c7',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_pwa_theme_color', array(
        'label'       => __('Warna Tema Status Bar (Theme Color)', 'hakajobs'),
        'description' => __('Warna bilah status browser dan header aplikasi pada perangkat mobile.', 'hakajobs'),
        'section'     => 'hakajobs_pwa_section',
    )));

    // Background Color
    $wp_customize->add_setting('hakajobs_pwa_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_pwa_bg_color', array(
        'label'       => __('Warna Latar Splash Screen', 'hakajobs'),
        'section'     => 'hakajobs_pwa_section',
    )));

    // Custom Icon 512x512
    $wp_customize->add_setting('hakajobs_pwa_custom_icon', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hakajobs_pwa_custom_icon', array(
        'label'       => __('Ikon Kustom Aplikasi PWA (512x512 PNG)', 'hakajobs'),
        'description' => __('Jika dikosongkan, sistem otomatis menggunakan Ikon Situs (Site Icon) WordPress atau ikon bawaan tema.', 'hakajobs'),
        'section'     => 'hakajobs_pwa_section',
    )));

    // Banner Title
    $wp_customize->add_setting('hakajobs_pwa_banner_title', array(
        'default'           => __('Pasang Aplikasi Lowongan Kerja', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_pwa_banner_title', array(
        'label'       => __('Judul Banner Install', 'hakajobs'),
        'section'     => 'hakajobs_pwa_section',
        'type'        => 'text',
    ));

    // Banner Text
    $wp_customize->add_setting('hakajobs_pwa_banner_desc', array(
        'default'           => __('Akses update loker harian, tips karir, dan latihan soal lebih cepat langsung dari layar utama perangkat Anda.', 'hakajobs'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('hakajobs_pwa_banner_desc', array(
        'label'       => __('Teks Keterangan Banner Install', 'hakajobs'),
        'section'     => 'hakajobs_pwa_section',
        'type'        => 'textarea',
    ));
}
add_action('customize_register', 'hakajobs_pwa_customize_register', 25);

/**
 * 2. Helper: Get PWA Icon URLs
 */
function hakajobs_get_pwa_icons() {
    $custom_icon = get_theme_mod('hakajobs_pwa_custom_icon', '');
    $site_icon   = get_site_icon_url(512);

    $icon_512 = $custom_icon ?: ($site_icon ?: HAKAJOBS_URI . '/assets/pwa/icon-512.png');
    $icon_192 = get_site_icon_url(192) ?: HAKAJOBS_URI . '/assets/pwa/icon-192.png';
    $icon_mask = HAKAJOBS_URI . '/assets/pwa/icon-maskable.png';
    $icon_svg  = HAKAJOBS_URI . '/assets/pwa/icon.svg';

    return array(
        '192'      => $icon_192,
        '512'      => $icon_512,
        'maskable' => $icon_mask,
        'svg'      => $icon_svg,
    );
}

/**
 * 3. Handle Dynamic Manifest & Service Worker Endpoints
 */
function hakajobs_pwa_handle_endpoints() {
    $is_enabled = get_theme_mod('hakajobs_pwa_enable', '1');
    if ($is_enabled !== '1') {
        return;
    }

    // A. Dynamic Web App Manifest
    if (isset($_GET['hakajobs_manifest']) && $_GET['hakajobs_manifest'] === '1') {
        header('Content-Type: application/manifest+json; charset=utf-8');
        header('Cache-Control: public, max-age=3600');

        $name       = get_theme_mod('hakajobs_pwa_app_name', get_bloginfo('name'));
        $short_name = get_theme_mod('hakajobs_pwa_short_name', wp_trim_words($name, 2, ''));
        $desc       = get_theme_mod('hakajobs_pwa_desc', get_bloginfo('description'));
        $theme_col  = get_theme_mod('hakajobs_pwa_theme_color', '#0284c7');
        $bg_col     = get_theme_mod('hakajobs_pwa_bg_color', '#ffffff');
        $icons      = hakajobs_get_pwa_icons();

        $manifest = array(
            'id'               => home_url('/?source=pwa'),
            'name'             => $name,
            'short_name'       => $short_name,
            'description'      => $desc,
            'start_url'        => home_url('/?source=pwa'),
            'scope'            => home_url('/'),
            'display'          => 'standalone',
            'orientation'      => 'any',
            'background_color' => $bg_col,
            'theme_color'      => $theme_col,
            'lang'             => get_locale(),
            'categories'       => array('business', 'jobs', 'productivity', 'education'),
            'icons'            => array(
                array(
                    'src'     => $icons['192'],
                    'sizes'   => '192x192',
                    'type'    => 'image/png',
                    'purpose' => 'any',
                ),
                array(
                    'src'     => $icons['512'],
                    'sizes'   => '512x512',
                    'type'    => 'image/png',
                    'purpose' => 'any',
                ),
                array(
                    'src'     => $icons['maskable'],
                    'sizes'   => '512x512',
                    'type'    => 'image/png',
                    'purpose' => 'maskable',
                ),
                array(
                    'src'     => $icons['svg'],
                    'sizes'   => 'any',
                    'type'    => 'image/svg+xml',
                    'purpose' => 'any',
                ),
            ),
            'shortcuts'        => array(
                array(
                    'name'        => __('Cari Lowongan', 'hakajobs'),
                    'short_name'  => __('Lowongan', 'hakajobs'),
                    'description' => __('Jelajahi info lowongan kerja terbaru', 'hakajobs'),
                    'url'         => get_post_type_archive_link('lowongan') ?: home_url('/?post_type=lowongan'),
                    'icons'       => array(
                        array('src' => $icons['192'], 'sizes' => '192x192', 'type' => 'image/png'),
                    ),
                ),
                array(
                    'name'        => __('Tes & Karir', 'hakajobs'),
                    'short_name'  => __('Latihan Soal', 'hakajobs'),
                    'description' => __('Latihan soal tes SKD CAT & modul karir', 'hakajobs'),
                    'url'         => home_url('/tes-karir/'),
                    'icons'       => array(
                        array('src' => $icons['192'], 'sizes' => '192x192', 'type' => 'image/png'),
                    ),
                ),
                array(
                    'name'        => __('Lowongan Tersimpan', 'hakajobs'),
                    'short_name'  => __('Tersimpan', 'hakajobs'),
                    'description' => __('Daftar lowongan yang disimpan untuk dilamar', 'hakajobs'),
                    'url'         => home_url('/saved-jobs/'),
                    'icons'       => array(
                        array('src' => $icons['192'], 'sizes' => '192x192', 'type' => 'image/png'),
                    ),
                ),
            ),
        );

        echo wp_json_encode($manifest, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        exit;
    }

    // B. Dynamic Service Worker
    if (isset($_GET['hakajobs_sw']) && $_GET['hakajobs_sw'] === '1') {
        header('Content-Type: application/javascript; charset=utf-8');
        header('Service-Worker-Allowed: /');
        header('Cache-Control: no-cache, no-store, must-revalidate');

        $sw_version = defined('HAKAJOBS_VERSION') ? HAKAJOBS_VERSION : '1.0.42';
        $offline_url = home_url('/?hakajobs_offline=1');
        $saved_url   = home_url('/saved-jobs/');
        $site_name   = esc_js(get_bloginfo('name'));

        echo "/* Hakajobs Service Worker v{$sw_version} */\n";
        ?>
const CACHE_NAME = 'hakajobs-pwa-v<?php echo esc_js($sw_version); ?>';
const OFFLINE_URL = '<?php echo esc_js($offline_url); ?>';

// Core assets to pre-cache on install
const PRECACHE_ASSETS = [
    OFFLINE_URL,
    '<?php echo esc_js(home_url('/')); ?>',
    '<?php echo esc_js(HAKAJOBS_URI . '/assets/css/main.min.css?v=' . $sw_version); ?>',
    '<?php echo esc_js(HAKAJOBS_URI . '/assets/css/tes-karir.min.css?v=' . $sw_version); ?>',
    '<?php echo esc_js(HAKAJOBS_URI . '/assets/js/main.min.js?v=' . $sw_version); ?>',
    '<?php echo esc_js(HAKAJOBS_URI . '/assets/pwa/icon-192.png'); ?>',
    '<?php echo esc_js(HAKAJOBS_URI . '/assets/pwa/icon-512.png'); ?>'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(PRECACHE_ASSETS).catch((err) => {
                console.warn('[PWA] Pre-cache partial warning:', err);
            });
        }).then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) => {
            return Promise.all(
                keys.map((key) => {
                    if (key !== CACHE_NAME) {
                        return caches.delete(key);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', (event) => {
    const request = event.request;
    const url = new URL(request.url);

    // Bypass non-GET and WP admin / customizer requests
    if (request.method !== 'GET') return;
    if (url.pathname.includes('/wp-admin') || url.pathname.includes('/wp-login.php') || url.search.includes('preview=true')) {
        return;
    }

    // 1. Navigation requests (HTML pages): Network-first with cache & offline fallback
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request)
                .then((networkResponse) => {
                    if (networkResponse && networkResponse.status === 200) {
                        const responseClone = networkResponse.clone();
                        caches.open(CACHE_NAME).then((cache) => cache.put(request, responseClone));
                    }
                    return networkResponse;
                })
                .catch(() => {
                    return caches.match(request).then((cachedResponse) => {
                        return cachedResponse || caches.match(OFFLINE_URL);
                    });
                })
        );
        return;
    }

    // 2. Static Assets (CSS, JS, Fonts, Images): Stale-While-Revalidate
    if (
        request.destination === 'style' ||
        request.destination === 'script' ||
        request.destination === 'image' ||
        request.destination === 'font' ||
        url.pathname.match(/\.(css|js|png|jpg|jpeg|svg|webp|woff|woff2|ttf)$/i)
    ) {
        event.respondWith(
            caches.match(request).then((cachedResponse) => {
                const fetchPromise = fetch(request).then((networkResponse) => {
                    if (networkResponse && networkResponse.status === 200) {
                        const responseClone = networkResponse.clone();
                        caches.open(CACHE_NAME).then((cache) => cache.put(request, responseClone));
                    }
                    return networkResponse;
                }).catch(() => {});
                return cachedResponse || fetchPromise;
            })
        );
        return;
    }

    // 3. Default: Network with cache fallback
    event.respondWith(
        fetch(request).catch(() => caches.match(request))
    );
});
        <?php
        exit;
    }

    // C. Standalone Offline Fallback Page
    if (isset($_GET['hakajobs_offline']) && $_GET['hakajobs_offline'] === '1') {
        header('Content-Type: text/html; charset=utf-8');
        $site_name = get_bloginfo('name');
        $theme_col = get_theme_mod('hakajobs_pwa_theme_color', '#0284c7');
        $saved_url = home_url('/saved-jobs/');
        $home_url  = home_url('/');
        ?>
<!DOCTYPE html>
<html lang="<?php echo esc_attr(get_locale()); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php _e('Anda Sedang Offline', 'hakajobs'); ?> — <?php echo esc_html($site_name); ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            text-align: center;
        }
        .hk-offline-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 40px 32px;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.08);
        }
        .hk-offline-icon-box {
            width: 80px;
            height: 80px;
            background: #f0f9ff;
            color: <?php echo esc_attr($theme_col); ?>;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
        }
        h1 {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 12px;
            letter-spacing: -0.02em;
        }
        p {
            font-size: 14.5px;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 28px;
        }
        .hk-offline-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .hk-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }
        .hk-btn-primary {
            background: <?php echo esc_attr($theme_col); ?>;
            color: #ffffff;
        }
        .hk-btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
        .hk-btn-subtle {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #cbd5e1;
        }
        .hk-btn-subtle:hover {
            background: #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="hk-offline-card">
        <div class="hk-offline-icon-box">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="1" y1="1" x2="23" y2="23"></line>
                <path d="M16.72 11.06A10.94 10.94 0 0 1 19 12.55"></path>
                <path d="M5 12.55a10.94 10.94 0 0 1 5.17-2.39"></path>
                <path d="M10.71 5.05A16 16 0 0 1 22.58 9"></path>
                <path d="M1.42 9a15.91 15.91 0 0 1 4.7-2.88"></path>
                <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path>
                <line x1="12" y1="20" x2="12.01" y2="20"></line>
            </svg>
        </div>
        <h1><?php _e('Koneksi Internet Terputus', 'hakajobs'); ?></h1>
        <p><?php _e('Anda saat ini berada dalam mode offline. Anda tetap dapat membuka lowongan kerja yang sudah disimpan sebelumnya di perangkat ini.', 'hakajobs'); ?></p>
        <div class="hk-offline-actions">
            <button type="button" class="hk-btn hk-btn-primary" onclick="window.location.reload()">
                🔄 <?php _e('Coba Muat Ulang', 'hakajobs'); ?>
            </button>
            <a href="<?php echo esc_url($saved_url); ?>" class="hk-btn hk-btn-subtle">
                📂 <?php _e('Buka Lowongan Tersimpan', 'hakajobs'); ?>
            </a>
            <a href="<?php echo esc_url($home_url); ?>" style="margin-top:8px; font-size:13px; color:#64748b; text-decoration:none;">
                &larr; <?php _e('Kembali ke Halaman Beranda', 'hakajobs'); ?>
            </a>
        </div>
    </div>
</body>
</html>
        <?php
        exit;
    }
}
add_action('init', 'hakajobs_pwa_handle_endpoints', 1);

/**
 * 4. Output PWA Meta Tags in <head>
 */
function hakajobs_pwa_head_tags() {
    $is_enabled = get_theme_mod('hakajobs_pwa_enable', '1');
    if ($is_enabled !== '1') {
        return;
    }

    $theme_col    = get_theme_mod('hakajobs_pwa_theme_color', '#0284c7');
    $app_name     = get_theme_mod('hakajobs_pwa_app_name', get_bloginfo('name'));
    $icons        = hakajobs_get_pwa_icons();
    $manifest_url = home_url('/?hakajobs_manifest=1');

    echo "\n<!-- Hakajobs Progressive Web App (PWA) Tags -->\n";
    echo '<link rel="manifest" href="' . esc_url($manifest_url) . '">' . "\n";
    echo '<meta name="theme-color" content="' . esc_attr($theme_col) . '">' . "\n";
    echo '<meta name="mobile-web-app-capable" content="yes">' . "\n";
    echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
    echo '<meta name="apple-mobile-web-app-status-bar-style" content="default">' . "\n";
    echo '<meta name="apple-mobile-web-app-title" content="' . esc_attr($app_name) . '">' . "\n";
    echo '<link rel="apple-touch-icon" href="' . esc_url($icons['192']) . '">' . "\n";
    echo '<link rel="apple-touch-icon" sizes="192x192" href="' . esc_url($icons['192']) . '">' . "\n";
    echo '<link rel="apple-touch-icon" sizes="512x512" href="' . esc_url($icons['512']) . '">' . "\n";
}
add_action('wp_head', 'hakajobs_pwa_head_tags', 2);

/**
 * 5. PWA Floating Install Prompt Card & Service Worker Registration Script in Footer
 */
function hakajobs_pwa_footer_markup() {
    $is_enabled = get_theme_mod('hakajobs_pwa_enable', '1');
    if ($is_enabled !== '1') {
        return;
    }

    $show_prompt   = get_theme_mod('hakajobs_pwa_install_prompt', '1');
    $app_name      = get_theme_mod('hakajobs_pwa_app_name', get_bloginfo('name'));
    $banner_title  = get_theme_mod('hakajobs_pwa_banner_title', __('Pasang Aplikasi Lowongan Kerja', 'hakajobs'));
    $banner_desc   = get_theme_mod('hakajobs_pwa_banner_desc', __('Akses update loker harian, tips karir, dan latihan soal lebih cepat langsung dari layar utama perangkat Anda.', 'hakajobs'));
    $icons         = hakajobs_get_pwa_icons();
    $sw_url        = home_url('/?hakajobs_sw=1');
    ?>

    <?php if ($show_prompt === '1'): ?>
    <!-- PWA Install Floating Card -->
    <div id="hk-pwa-install-banner" class="hk-pwa-banner" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="hk-pwa-title">
        <div class="hk-pwa-card">
            <button type="button" class="hk-pwa-close-btn" id="hkPwaDismissBtn" aria-label="<?php esc_attr_e('Tutup', 'hakajobs'); ?>">&times;</button>
            <div class="hk-pwa-body">
                <img src="<?php echo esc_url($icons['192']); ?>" alt="<?php echo esc_attr($app_name); ?>" class="hk-pwa-icon">
                <div class="hk-pwa-info">
                    <span class="hk-pwa-badge"><?php _e('Aplikasi Web Ringan', 'hakajobs'); ?></span>
                    <h4 class="hk-pwa-title" id="hk-pwa-title"><?php echo esc_html($banner_title); ?></h4>
                    <p class="hk-pwa-text"><?php echo esc_html($banner_desc); ?></p>
                </div>
            </div>
            <div class="hk-pwa-actions">
                <button type="button" class="hk-btn hk-pwa-btn-install" id="hkPwaInstallBtn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span><?php _e('Install Sekarang', 'hakajobs'); ?></span>
                </button>
                <button type="button" class="hk-btn hk-pwa-btn-later" id="hkPwaLaterBtn">
                    <?php _e('Nanti Saja', 'hakajobs'); ?>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <style>
    /* PWA Floating Install Banner Styles */
    .hk-pwa-banner {
        position: fixed;
        bottom: 24px;
        left: 24px;
        z-index: 9998;
        max-width: 380px;
        width: calc(100% - 48px);
        animation: hkPwaSlideIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes hkPwaSlideIn {
        from { opacity: 0; transform: translateY(30px) scale(0.96); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .hk-pwa-card {
        background: #ffffff;
        border: 1px solid var(--hk-border, #e2e8f0);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 16px 36px -4px rgba(15, 23, 42, 0.16), 0 4px 12px rgba(15, 23, 42, 0.08);
        position: relative;
    }
    .hk-pwa-close-btn {
        position: absolute;
        top: 10px;
        right: 14px;
        background: transparent;
        border: none;
        font-size: 20px;
        color: #94a3b8;
        cursor: pointer;
        padding: 4px;
        line-height: 1;
        transition: color 0.15s ease;
    }
    .hk-pwa-close-btn:hover { color: #334155; }
    .hk-pwa-body {
        display: flex;
        gap: 14px;
        align-items: flex-start;
        margin-bottom: 16px;
    }
    .hk-pwa-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        object-fit: cover;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        flex-shrink: 0;
        background: #0284c7;
    }
    .hk-pwa-badge {
        display: inline-block;
        background: #f0f9ff;
        color: var(--hk-primary, #0284c7);
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 4px;
        margin-bottom: 4px;
        border: 1px solid #bae6fd;
    }
    .hk-pwa-title {
        font-size: 14.5px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 4px;
        line-height: 1.35;
    }
    .hk-pwa-text {
        font-size: 12.5px;
        color: #64748b;
        line-height: 1.5;
        margin: 0;
    }
    .hk-pwa-actions {
        display: flex;
        gap: 8px;
    }
    .hk-pwa-btn-install {
        flex: 1;
        height: 38px;
        background: var(--hk-primary, #0284c7) !important;
        color: #ffffff !important;
        border: 1.5px solid var(--hk-primary, #0284c7) !important;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(2, 132, 199, 0.25);
    }
    .hk-pwa-btn-install:hover {
        background: var(--hk-primary-hover, #0369a1) !important;
        transform: translateY(-1px);
    }
    .hk-pwa-btn-later {
        height: 38px;
        background: #f8fafc !important;
        color: #64748b !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        padding: 0 14px;
        cursor: pointer;
    }
    .hk-pwa-btn-later:hover {
        background: #f1f5f9 !important;
        color: #334155 !important;
    }

    @media (max-width: 640px) {
        .hk-pwa-banner {
            bottom: 16px;
            left: 16px;
            right: 16px;
            width: auto;
            max-width: none;
        }
    }
    </style>

    <script>
    (function () {
        'use strict';

        // 1. Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('<?php echo esc_js($sw_url); ?>', { scope: '/' })
                    .then(function (reg) {
                        // Registration success
                    })
                    .catch(function (err) {
                        console.warn('[PWA] ServiceWorker registration warning:', err);
                    });
            });
        }

        // 2. Add-to-Home-Screen (A2HS) Prompt Logic
        var deferredPrompt = null;
        var banner = document.getElementById('hk-pwa-install-banner');
        var installBtn = document.getElementById('hkPwaInstallBtn');
        var dismissBtn = document.getElementById('hkPwaDismissBtn');
        var laterBtn = document.getElementById('hkPwaLaterBtn');

        var PWA_DISMISSED_KEY = 'hk_pwa_install_dismissed_v1';
        var isDismissed = false;
        try {
            var dismissedTime = localStorage.getItem(PWA_DISMISSED_KEY);
            if (dismissedTime && (Date.now() - parseInt(dismissedTime, 10)) < (14 * 86400 * 1000)) {
                isDismissed = true; // Dismissed within 14 days
            }
        } catch (e) {}

        window.addEventListener('beforeinstallprompt', function (e) {
            e.preventDefault();
            deferredPrompt = e;

            if (banner && !isDismissed) {
                // Show after 3 seconds delay for polite UX
                setTimeout(function () {
                    banner.style.display = 'block';
                }, 3000);
            }
        });

        function hidePwaBanner(permanently) {
            if (banner) {
                banner.style.display = 'none';
            }
            if (permanently) {
                try {
                    localStorage.setItem(PWA_DISMISSED_KEY, Date.now().toString());
                } catch (e) {}
            }
        }

        if (installBtn) {
            installBtn.addEventListener('click', function () {
                if (!deferredPrompt) {
                    hidePwaBanner(true);
                    return;
                }
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then(function (choice) {
                    if (choice.outcome === 'accepted') {
                        hidePwaBanner(true);
                    }
                    deferredPrompt = null;
                });
            });
        }

        if (dismissBtn) {
            dismissBtn.addEventListener('click', function () {
                hidePwaBanner(true);
            });
        }
        if (laterBtn) {
            laterBtn.addEventListener('click', function () {
                hidePwaBanner(true);
            });
        }

        window.addEventListener('appinstalled', function () {
            hidePwaBanner(true);
            if (typeof showToast === 'function') {
                showToast('Aplikasi berhasil dipasang di perangkat Anda!');
            }
        });

        // 3. Online/Offline Network Status Toast
        window.addEventListener('online', function () {
            if (typeof showToast === 'function') {
                showToast('Koneksi internet Anda pulih kembali!');
            }
        });
        window.addEventListener('offline', function () {
            if (typeof showToast === 'function') {
                showToast('Anda sedang dalam mode offline.');
            }
        });
    })();
    </script>
    <?php
}
add_action('wp_footer', 'hakajobs_pwa_footer_markup', 90);
