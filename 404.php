<?php
/**
 * 404 Template for Hakajobs
 *
 * @package Hakajobs
 */

get_header();
?>

<main id="hk-main" class="hk-site-main hk-404-page">
    <div class="hk-container">
        <div class="hk-404-card">
            <span class="hk-404-number">404</span>
            <h1 class="hk-404-title"><?php _e('Halaman Tidak Ditemukan', 'hakajobs'); ?></h1>
            <p class="hk-404-desc">
                <?php _e('Maaf, halaman atau lowongan kerja yang Anda cari mungkin sudah ditutup, kedaluwarsa, atau tautannya telah berubah.', 'hakajobs'); ?>
            </p>

            <div class="hk-404-search">
                <form action="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" method="get" class="hk-search-simple">
                    <input type="text" name="s_keyword" placeholder="<?php esc_attr_e('Cari posisi lowongan lainnya...', 'hakajobs'); ?>">
                    <button type="submit" class="hk-btn hk-btn-primary"><?php _e('Cari', 'hakajobs'); ?></button>
                </form>
            </div>

            <div class="hk-404-actions">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="hk-btn hk-btn-primary">
                    &larr; <?php _e('Kembali ke Beranda', 'hakajobs'); ?>
                </a>
                <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" class="hk-btn hk-btn-subtle">
                    <?php _e('Lihat Semua Lowongan', 'hakajobs'); ?>
                </a>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
