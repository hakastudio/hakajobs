<?php
/**
 * GitHub Releases Auto-Update Engine for Hakajobs Theme
 * Powered by YahnisElsts/plugin-update-checker v5
 *
 * @package Hakajobs
 */

if (!defined('ABSPATH')) {
    exit;
}

// Pastikan berkas library PUC ada dan dapat dibaca
$hakajobs_puc_file = HAKAJOBS_DIR . '/inc/plugin-update-checker/plugin-update-checker.php';
if (!file_exists($hakajobs_puc_file) || !is_readable($hakajobs_puc_file)) {
    return;
}

try {
    require_once $hakajobs_puc_file;
} catch (\Throwable $e) {
    error_log('[Hakajobs Updater Error] ' . $e->getMessage());
    return;
}

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

/**
 * Inisialisasi Pengecek Pembaruan Otomatis dari GitHub Releases
 */
function hakajobs_init_theme_updater() {
    // URL Repository GitHub (dapat diubah lewat wp-config.php atau filter)
    $repo_url = defined('HAKAJOBS_GITHUB_REPO') 
        ? HAKAJOBS_GITHUB_REPO 
        : 'https://github.com/hakastudio/hakajobs';

    $repo_url = apply_filters('hakajobs_github_repo_url', $repo_url);

    if (empty($repo_url)) {
        return;
    }

    global $hakajobs_update_checker;

    $theme_slug = get_template();

    $update_checker = PucFactory::buildUpdateChecker(
        $repo_url,
        HAKAJOBS_DIR . '/style.css',
        $theme_slug
    );

    // Cabang utama (default: main)
    $branch = defined('HAKAJOBS_GITHUB_BRANCH') ? HAKAJOBS_GITHUB_BRANCH : 'main';
    $update_checker->setBranch(apply_filters('hakajobs_github_branch', $branch));

    // Jika repository GitHub bersifat Private, gunakan Personal Access Token
    if (defined('HAKAJOBS_GITHUB_TOKEN') && !empty(HAKAJOBS_GITHUB_TOKEN)) {
        $update_checker->setAuthentication(HAKAJOBS_GITHUB_TOKEN);
    }

    // Aktifkan dukungan file aset ZIP pada GitHub Releases (misal hakajobs.zip)
    if (method_exists($update_checker, 'getVcsApi') && $update_checker->getVcsApi()) {
        $update_checker->getVcsApi()->enableReleaseAssets('/\.zip($|[?&#])/i');
    }

    // Hapus filter bawaan PUC yang kaku agar tidak memicu 'Unable to rename the update to match the existing directory'
    // Seluruh proses normalisasi folder dan instalasi tema ditangani oleh filter arsitektur ganda di bawah.
    remove_filter('upgrader_source_selection', array($update_checker, 'fixDirectoryName'), 10);

    // Pastikan PUC mengizinkan flag autoupdate di WordPress 5.5+
    add_filter('puc_autoupdate_field_allowed-' . $theme_slug, '__return_true');
    add_filter('puc_autoupdate_field_allowed-hakajobs', '__return_true');

    // Simpan di variabel global agar dapat diakses oleh action dan filter lain
    $hakajobs_update_checker = $update_checker;
}
add_action('after_setup_theme', 'hakajobs_init_theme_updater');

/**
 * Pemeriksaan akurat apakah paket update yang sedang diproses adalah tema Hakajobs.
 *
 * @param array|null        $hook_extra
 * @param \WP_Upgrader|null $upgrader
 * @param string            $source
 * @param string            $remote_source
 * @return bool
 */
function hakajobs_is_updating_theme($hook_extra = null, $upgrader = null, $source = '', $remote_source = '') {
    global $wp_filesystem;
    $template = get_template();

    // 1. Cek hook_extra['theme'] atau hook_extra['themes']
    if (is_array($hook_extra)) {
        if (!empty($hook_extra['theme']) && (strcasecmp($hook_extra['theme'], $template) === 0 || stripos($hook_extra['theme'], 'hakajobs') !== false)) {
            return true;
        }
        if (!empty($hook_extra['themes']) && is_array($hook_extra['themes'])) {
            foreach ($hook_extra['themes'] as $t) {
                if (strcasecmp($t, $template) === 0 || stripos($t, 'hakajobs') !== false) {
                    return true;
                }
            }
        }
    }

    // 2. Cek upgrader skin
    if ($upgrader && isset($upgrader->skin)) {
        if (isset($upgrader->skin->theme_info) && method_exists($upgrader->skin->theme_info, 'get_stylesheet')) {
            $skin_theme = $upgrader->skin->theme_info->get_stylesheet();
            if (strcasecmp($skin_theme, $template) === 0 || stripos($skin_theme, 'hakajobs') !== false) {
                return true;
            }
        }
        if (isset($upgrader->skin->theme)) {
            if (strcasecmp($upgrader->skin->theme, $template) === 0 || stripos($upgrader->skin->theme, 'hakajobs') !== false) {
                return true;
            }
        }
    }

    // 3. Cek nama folder sumber
    $source_name = basename(untrailingslashit($source));
    if (stripos($source_name, 'hakajobs') !== false || strcasecmp($source_name, $template) === 0) {
        return true;
    }

    // 4. Verifikasi isi style.css dalam source
    if (!empty($source) && $wp_filesystem && $wp_filesystem->exists(trailingslashit($source) . 'style.css')) {
        $content = $wp_filesystem->get_contents(trailingslashit($source) . 'style.css');
        if ($content && (stripos($content, 'Theme Name: Hakajobs') !== false || stripos($content, 'Text Domain: hakajobs') !== false || stripos($content, 'hakajobs') !== false)) {
            return true;
        }
    }

    return false;
}

/**
 * Filter 1: upgrader_source_selection
 *
 * Menemukan dan menormalisasi folder tema hasil ekstrak ZIP dari GitHub:
 * 1. Menemukan lokasi berkas style.css di dalam paket (baik di root, subfolder hakajobs, maupun auto-zip GitHub).
 * 2. Selalu menjamin trailing slash pada $source agar WordPress core tidak pernah gagal membaca style.css.
 * 3. Jika nama folder berbeda dari slug tema, lakukan penamaan ulang yang aman (aman Windows/macOS/Linux).
 * 4. Tidak pernah melempar fatal WP_Error jika penamaan ulang dicegah sistem, karena filter kedua (upgrader_package_destination)
 *    menjamin tema tetap terpasang tepat ke folder target.
 */
add_filter('upgrader_source_selection', function ($source, $remote_source, $upgrader = null, $hook_extra = null) {
    global $wp_filesystem;
    if (!$wp_filesystem || is_wp_error($source)) {
        return $source;
    }

    if (!hakajobs_is_updating_theme($hook_extra, $upgrader, $source, $remote_source)) {
        return $source;
    }

    $template = get_template();
    $style_dir = null;

    // 1. Cek apakah style.css langsung ada di $source
    if ($wp_filesystem->exists(trailingslashit($source) . 'style.css')) {
        $style_dir = trailingslashit($source);
    }
    // 2. Cek apakah style.css ada di subfolder $source/$template/
    elseif ($wp_filesystem->exists(trailingslashit($source) . $template . '/style.css')) {
        $style_dir = trailingslashit($source) . $template . '/';
    }
    // 3. Cek apakah style.css ada di $remote_source/$template/
    elseif ($wp_filesystem->exists(trailingslashit($remote_source) . $template . '/style.css')) {
        $style_dir = trailingslashit($remote_source) . $template . '/';
    }
    // 4. Cari di subfolder dalam $source
    else {
        $dirlist = $wp_filesystem->dirlist($source);
        if (is_array($dirlist)) {
            foreach ($dirlist as $item) {
                $sub = trailingslashit($source) . $item['name'];
                if ($wp_filesystem->is_dir($sub) && $wp_filesystem->exists($sub . '/style.css')) {
                    $style_dir = trailingslashit($sub);
                    break;
                }
            }
        }
    }

    // 5. Cari di subfolder dalam $remote_source jika belum ketemu
    if (!$style_dir) {
        $remote_dirlist = $wp_filesystem->dirlist($remote_source);
        if (is_array($remote_dirlist)) {
            foreach ($remote_dirlist as $item) {
                $sub = trailingslashit($remote_source) . $item['name'];
                if ($wp_filesystem->is_dir($sub) && $wp_filesystem->exists($sub . '/style.css')) {
                    $style_dir = trailingslashit($sub);
                    break;
                }
            }
        }
    }

    // 6. Jika style.css ada langsung di root $remote_source (flat ZIP tanpa subfolder)
    if (!$style_dir && $wp_filesystem->exists(trailingslashit($remote_source) . 'style.css')) {
        $style_dir = trailingslashit($remote_source);
    }

    if (!$style_dir) {
        return trailingslashit($source);
    }

    // Coba normalisasi nama folder di direktori sementara ke slug tema aktif jika memungkinkan
    $target_dir  = untrailingslashit($remote_source) . '/' . $template;
    $current_dir = untrailingslashit($style_dir);

    if ($current_dir !== $target_dir && $current_dir !== untrailingslashit($remote_source)) {
        if (strcasecmp($current_dir, $target_dir) === 0) {
            // Perbedaan kapitalisasi nama (misal hakajobs vs HakaJobs)
            // Gunakan 2-langkah rename untuk mencegah bug penghapusan folder pada Windows/macOS
            $temp_rename = $current_dir . '_case_tmp_' . uniqid();
            if ($wp_filesystem->move($current_dir, $temp_rename, false)) {
                if ($wp_filesystem->move($temp_rename, $target_dir, false)) {
                    $style_dir = trailingslashit($target_dir);
                } else {
                    $wp_filesystem->move($temp_rename, $current_dir, false);
                }
            }
        } elseif (!$wp_filesystem->exists($target_dir)) {
            // Folder bernama berbeda (misal auto-zip GitHub: hakastudio-hakajobs-xxxx atau hakajobs-1.0.54)
            if ($wp_filesystem->move($current_dir, $target_dir, true)) {
                $style_dir = trailingslashit($target_dir);
            }
        }
    }

    return trailingslashit($style_dir);
}, 5, 4);

/**
 * Filter 2: upgrader_package_destination
 *
 * Menjamin 100% WordPress SELALU memasang pembaruan ke direktori tema aktif (misal /wp-content/themes/hakajobs/)
 * terlepas dari apapun nama folder asal ZIP GitHub.
 * Ini mencegah tema terpasang ke folder terpisah (misal hakastudio-hakajobs-xxxx) yang menyebabkan
 * tema aktif tidak pernah terbarui.
 */
add_filter('upgrader_package_destination', function ($destination, $source, $upgrader = null, $hook_extra = null) {
    if (!hakajobs_is_updating_theme($hook_extra, $upgrader, $source)) {
        return $destination;
    }

    $template = get_template();
    $themes_root = dirname(untrailingslashit($destination));
    if (!empty($themes_root)) {
        return trailingslashit($themes_root) . $template;
    }

    return $destination;
}, 10, 4);

/**
 * Filter 3: auto_update_theme
 *
 * Mengaktifkan background auto-update otomatis via WP-Cron untuk tema Hakajobs.
 * Mendukung objek maupun array pada argumen $item.
 */
add_filter('auto_update_theme', function ($update, $item) {
    $template = get_template();
    $item_theme = '';

    if (is_object($item) && isset($item->theme)) {
        $item_theme = $item->theme;
    } elseif (is_array($item) && isset($item['theme'])) {
        $item_theme = $item['theme'];
    } elseif (is_string($item)) {
        $item_theme = $item;
    }

    if (!empty($item_theme)) {
        if (
            strcasecmp($item_theme, $template) === 0 
            || strcasecmp($item_theme, 'hakajobs') === 0 
            || stripos($item_theme, 'hakajobs') !== false
        ) {
            return true;
        }
    }

    return $update;
}, 10, 2);

/**
 * Aksi pasca pembaruan: Segera bersihkan cache tema & transient update setelah update selesai
 */
add_action('upgrader_process_complete', function ($upgrader, $hook_extra) {
    if (
        is_array($hook_extra) 
        && isset($hook_extra['action'], $hook_extra['type']) 
        && $hook_extra['action'] === 'update' 
        && $hook_extra['type'] === 'theme'
    ) {
        $themes = isset($hook_extra['themes']) 
            ? (array)$hook_extra['themes'] 
            : (isset($hook_extra['theme']) ? array($hook_extra['theme']) : array());
        $template = get_template();
        $is_hakajobs = false;
        foreach ($themes as $t) {
            if (strcasecmp($t, $template) === 0 || strcasecmp($t, 'hakajobs') === 0 || stripos($t, 'hakajobs') !== false) {
                $is_hakajobs = true;
                break;
            }
        }
        if ($is_hakajobs) {
            global $hakajobs_update_checker;
            if (!empty($hakajobs_update_checker)) {
                $hakajobs_update_checker->resetUpdateState();
            }
            if (function_exists('wp_clean_themes_cache')) {
                wp_clean_themes_cache();
            }
            delete_site_transient('update_themes');
        }
    }
}, 10, 2);

/**
 * Paksa reset cache & periksa update langsung dari GitHub saat tombol 'Periksa Lagi' ditekan di Dasbor
 */
add_action('load-update-core.php', function () {
    if (isset($_GET['force-check'])) {
        global $hakajobs_update_checker;
        if (!empty($hakajobs_update_checker)) {
            $hakajobs_update_checker->resetUpdateState();
            $hakajobs_update_checker->checkForUpdates();
        }
    }
});

/**
 * Endpoint manual satu klik untuk memeriksa pembaruan dari GitHub
 */
add_action('admin_init', function () {
    if (!isset($_GET['hakajobs_check_update']) || !current_user_can('update_themes')) {
        return;
    }

    check_admin_referer('hakajobs_check_update_action');

    global $hakajobs_update_checker;
    if (!empty($hakajobs_update_checker)) {
        $hakajobs_update_checker->resetUpdateState();
        $update = $hakajobs_update_checker->checkForUpdates();

        // Bersihkan cache tema WordPress
        if (function_exists('wp_clean_themes_cache')) {
            wp_clean_themes_cache();
        }
        delete_site_transient('update_themes');

        $status = $update ? 'found' : 'latest';
        $ver    = ($update && isset($update->version)) ? trim(ltrim($update->version, 'v')) : '';

        wp_safe_redirect(admin_url('themes.php?hakajobs_update_checked=' . $status . '&ver=' . urlencode($ver)));
        exit;
    }
});

/**
 * Tampilkan tombol Cek Pembaruan & notifikasi status di halaman Tampilan > Tema
 */
add_action('admin_notices', function () {
    $screen = get_current_screen();
    if (!$screen || !in_array($screen->id, array('themes', 'update-core'), true)) {
        return;
    }

    if (!current_user_can('update_themes')) {
        return;
    }

    $check_url = wp_nonce_url(admin_url('themes.php?hakajobs_check_update=1'), 'hakajobs_check_update_action');

    if (isset($_GET['hakajobs_update_checked'])) {
        $status = sanitize_text_field($_GET['hakajobs_update_checked']);
        $ver    = isset($_GET['ver']) ? sanitize_text_field($_GET['ver']) : '';

        if ($status === 'found') {
            echo '<div class="notice notice-warning is-dismissible"><p><strong>🚀 Pembaruan Tema Hakajobs Tersedia!</strong> Versi baru <code>v' . esc_html($ver) . '</code> siap dipasang. Silakan buka menu <a href="' . esc_url(admin_url('update-core.php')) . '"><strong>Dasbor &rarr; Pembaruan</strong></a> untuk memperbarui sekarang.</p></div>';
        } else {
            echo '<div class="notice notice-success is-dismissible"><p><strong>✅ Tema Hakajobs Sudah Menggunakan Versi Terbaru (v' . esc_html(HAKAJOBS_VERSION) . ').</strong> Pengecekan ke GitHub berhasil.</p></div>';
        }
    } elseif ($screen->id === 'themes') {
        echo '<div class="notice notice-info"><p><strong>Tema Hakajobs v' . esc_html(HAKAJOBS_VERSION) . ':</strong> <a href="' . esc_url($check_url) . '" class="button button-secondary" style="margin-left: 8px;">🔄 Cek Pembaruan Thema Sekarang</a></p></div>';
    }
});
