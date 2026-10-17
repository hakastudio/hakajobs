<?php
/**
 * Template Name: Lowongan Tersimpan (Saved Jobs)
 *
 * @package Hakajobs
 */

get_header();
?>

<?php hakajobs_breadcrumbs(); ?>

<main id="hk-main" class="hk-site-main hk-saved-page">
    <div class="hk-container">
        <div class="hk-archive-header" style="text-align:left; margin: 32px 0 24px;">
            <h1 class="hk-archive-title"><?php _e('Lowongan Tersimpan Saya', 'hakajobs'); ?></h1>
            <p class="hk-archive-subtitle">
                <?php _e('Daftar lowongan yang Anda tandai untuk dilamar nanti. Disimpan di peramban (browser) Anda tanpa akun login.', 'hakajobs'); ?>
            </p>
        </div>

        <div id="hk-saved-full-page-container">
            <div class="hk-loading-spinner" style="text-align:center; padding: 40px; color: #64748b;">
                <p><?php _e('Memuat lowongan tersimpan...', 'hakajobs'); ?></p>
            </div>
        </div>

        <div class="hk-saved-page-actions" style="margin-top: 32px; display: flex; gap: 16px; align-items: center;">
            <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" class="hk-btn hk-btn-primary">
                &larr; <?php _e('Cari Lowongan Lainnya', 'hakajobs'); ?>
            </a>
            <button type="button" class="hk-btn hk-btn-subtle" id="hk-clear-saved-page-btn">
                <?php _e('Hapus Semua Simpanan', 'hakajobs'); ?>
            </button>
        </div>
    </div>
</main>

<?php
get_footer();
