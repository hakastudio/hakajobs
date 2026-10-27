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

    $update_checker = PucFactory::buildUpdateChecker(
        $repo_url,
        HAKAJOBS_DIR . '/style.css',
        get_template()
    );

    // Cabang utama (default: main)
    $branch = defined('HAKAJOBS_GITHUB_BRANCH') ? HAKAJOBS_GITHUB_BRANCH : 'main';
    $update_checker->setBranch(apply_filters('hakajobs_github_branch', $branch));

    // Jika repository GitHub bersifat Private, gunakan Personal Access Token
    if (defined('HAKAJOBS_GITHUB_TOKEN') && !empty(HAKAJOBS_GITHUB_TOKEN)) {
        $update_checker->setAuthentication(HAKAJOBS_GITHUB_TOKEN);
    }

    // Aktifkan dukungan file aset ZIP pada GitHub Releases
    if (method_exists($update_checker, 'getVcsApi') && $update_checker->getVcsApi()) {
        $update_checker->getVcsApi()->enableReleaseAssets('/\.zip($|[?&#])/i');
    }

    // Simpan di variabel global agar dapat diakses oleh action dan filter lain
    $hakajobs_update_checker = $update_checker;
}
add_action('after_setup_theme', 'hakajobs_init_theme_updater');

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

        // Bersihkan transient update_themes bawaan WordPress
        delete_site_transient('update_themes');

        $status = $update ? 'found' : 'latest';
        $ver    = ($update && isset($update->version)) ? $update->version : '';

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
 * Rename folder hasil ekstrak ZIP GitHub agar sesuai slug tema.
 * GitHub auto-zip menghasilkan folder seperti "hakajobs-1.0.20/" atau "hakajobs-main/",
 * sedangkan WordPress membutuhkan folder bernama persis "hakajobs/" agar style.css terbaca.
 */
add_filter('upgrader_source_selection', function ($source, $remote_source, $upgrader) {
    global $wp_filesystem;
    if (!$wp_filesystem || is_wp_error($source)) {
        return $source;
    }

    $template    = get_template();
    $source_name = basename(untrailingslashit($source));

    // Jika style.css sudah ada di folder sumber, langsung gunakan tanpa modifikasi
    if ($wp_filesystem->exists(trailingslashit($source) . 'style.css')) {
        return $source;
    }

    // Jika folder sumber sudah bernama persis sama dengan template (case-insensitive), langsung gunakan
    if (strcasecmp($source_name, $template) === 0) {
        return $source;
    }

    $target = trailingslashit($remote_source) . $template . '/';

    // Cek apakah ini adalah paket pembaruan untuk tema Hakajobs
    if (stripos($source_name, 'hakajobs') === false && stripos($source_name, strtolower($template)) === false) {
        return $source;
    }

    // Hapus target lama jika ada dan pastikan bukan folder sumber yang sama
    if ($wp_filesystem->exists($target) && strcasecmp(untrailingslashit($source), untrailingslashit($target)) !== 0) {
        $wp_filesystem->delete($target, true);
    }

    // Rename folder ke slug tema yang tepat
    if (!$wp_filesystem->move($source, $target, true)) {
        return new WP_Error(
            'hakajobs_rename_failed',
            sprintf(
                __('Gagal rename folder tema dari "%s" ke "%s". Pastikan direktori wp-content/themes dapat ditulisi.', 'hakajobs'),
                $source_name,
                $template
            )
        );
    }

    return $target;
}, 5, 3);

/**
 * Mengaktifkan otomatisasi background auto-update untuk tema hakajobs
 */
add_filter('auto_update_theme', function ($update, $item) {
    if (isset($item->theme) && (strtolower($item->theme) === 'hakajobs')) {
        return true;
    }
    return $update;
}, 10, 2);
