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
    // Seluruh proses struktur direktori dan normalisasi nama folder ditangani secara cerdas oleh filter di bawah.
    remove_filter('upgrader_source_selection', array($update_checker, 'fixDirectoryName'), 10);

    // Simpan di variabel global agar dapat diakses oleh action dan filter lain
    $hakajobs_update_checker = $update_checker;
}
add_action('after_setup_theme', 'hakajobs_init_theme_updater');

/**
 * Filter cerdas untuk memastikan proses instalasi & update tema selalu sukses:
 * 1. Menjaga slug folder tema tetap persis sesuai direktori tema aktif (get_template()).
 * 2. Menghindari eror "Tema ini tidak memiliki style.css stylesheet" dengan selalu menyertakan trailing slash.
 * 3. Mencegah eror "Unable to rename the update to match the existing directory" baik di server Linux maupun Windows/macOS.
 * 4. Mendukung ZIP release aset (hakajobs.zip) maupun auto-zip GitHub (hakastudio-hakajobs-xxxx / hakajobs-x.x.x).
 */
add_filter('upgrader_source_selection', function ($source, $remote_source, $upgrader = null, $hook_extra = null) {
    global $wp_filesystem;
    if (!$wp_filesystem || is_wp_error($source)) {
        return $source;
    }

    $template    = get_template();
    $source_dir  = untrailingslashit($source);
    $source_name = basename($source_dir);

    // Periksa apakah ini proses instalasi/pembaruan untuk tema Hakajobs
    $is_hakajobs = false;
    if (is_array($hook_extra) && isset($hook_extra['theme']) && stripos($hook_extra['theme'], 'hakajobs') !== false) {
        $is_hakajobs = true;
    } elseif ($upgrader && isset($upgrader->skin) && isset($upgrader->skin->theme_info)) {
        $skin_theme = $upgrader->skin->theme_info->get_stylesheet();
        if (stripos($skin_theme, 'hakajobs') !== false) {
            $is_hakajobs = true;
        }
    } elseif ($upgrader && isset($upgrader->skin) && isset($upgrader->skin->theme)) {
        if (stripos($upgrader->skin->theme, 'hakajobs') !== false) {
            $is_hakajobs = true;
        }
    } elseif (stripos($source_name, 'hakajobs') !== false) {
        $is_hakajobs = true;
    } elseif ($wp_filesystem->exists(trailingslashit($source) . 'style.css')) {
        $style_content = $wp_filesystem->get_contents(trailingslashit($source) . 'style.css');
        if ($style_content && stripos($style_content, 'hakajobs') !== false) {
            $is_hakajobs = true;
        }
    }

    if (!$is_hakajobs) {
        return $source;
    }

    $target_dir = untrailingslashit($remote_source) . '/' . $template;

    // 1. Jika folder source sudah persis sama dengan target_dir
    if ($source_dir === $target_dir) {
        return trailingslashit($target_dir);
    }

    // 2. Jika hanya berbeda kapitalisasi (misal hakajobs vs HakaJobs)
    if (strcasecmp($source_dir, $target_dir) === 0) {
        // Coba rename 2-langkah via folder sementara untuk filesystem case-insensitive (Windows/macOS)
        $temp_dir = $source_dir . '_tmp_' . (function_exists('wp_generate_password') ? wp_generate_password(6, false, false) : uniqid());
        if ($wp_filesystem->move($source_dir, $temp_dir, true)) {
            if ($wp_filesystem->move($temp_dir, $target_dir, true)) {
                return trailingslashit($target_dir);
            }
            // Rollback jika rename ke target_dir gagal
            $wp_filesystem->move($temp_dir, $source_dir, true);
        }
        return trailingslashit($source_dir);
    }

    // 3. Jika folder source bernama berbeda (misal hakajobs-1.0.52 atau hakastudio-hakajobs-xxxx dari auto-zip GitHub)
    if ($wp_filesystem->exists($target_dir)) {
        $wp_filesystem->delete($target_dir, true);
    }

    if ($wp_filesystem->move($source_dir, $target_dir, true)) {
        return trailingslashit($target_dir);
    }

    // Fallback aman: kembalikan source asli dengan trailing slash agar tidak pernah menggagalkan update
    return trailingslashit($source);
}, 5, 4);

/**
 * Paksa reset cache & periksa update langsung dari GitHub saat tombol 'Periksa Lagi' ditekan
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

/**
 * Mengaktifkan otomatisasi background auto-update untuk tema hakajobs
 */
add_filter('auto_update_theme', function ($update, $item) {
    $theme_slug = get_template();
    if (isset($item->theme) && (strcasecmp($item->theme, $theme_slug) === 0 || strcasecmp($item->theme, 'hakajobs') === 0)) {
        return true;
    }
    return $update;
}, 10, 2);

