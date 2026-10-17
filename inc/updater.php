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

// Pastikan berkas library PUC ada
$hakajobs_puc_file = HAKAJOBS_DIR . '/inc/plugin-update-checker/plugin-update-checker.php';
if (!file_exists($hakajobs_puc_file)) {
    return;
}

require_once $hakajobs_puc_file;

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
}
add_action('after_setup_theme', 'hakajobs_init_theme_updater');

/**
 * Bersihkan direktori sementara jika ada sisa upgrade sebelumnya
 * agar tidak terjadi error "Unable to rename the update to match the existing directory"
 */
add_filter('upgrader_source_selection', function ($source, $remote_source, $upgrader) {
    global $wp_filesystem;
    if (!$wp_filesystem || is_wp_error($source)) {
        return $source;
    }

    $template = get_template();
    $target   = trailingslashit($remote_source) . $template . '/';

    // Jika source sudah sesuai target direktori tema, langsung kembalikan
    if (untrailingslashit($source) === untrailingslashit($target)) {
        return $source;
    }

    // Jika ada sisa direktori dari proses sebelumnya, bersihkan agar rename sukses
    if (strtolower(basename($source)) === strtolower($template)) {
        if ($wp_filesystem->exists($target)) {
            $wp_filesystem->delete($target, true);
        }
    }

    return $source;
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
