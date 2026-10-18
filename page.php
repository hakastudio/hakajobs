<?php
/**
 * Page Template for Hakajobs (Halaman Statis Standar)
 *
 * Menampilkan konten halaman statis dengan opsi bilah sisi kanan (sidebar).
 * Pengaturan tampilan sidebar dapat diatur secara global melalui:
 * WP Admin > Tampilan > Sesuaikan > Sidebar Kanan (Beranda & Halaman Statis).
 *
 * @package Hakajobs
 */

get_header();

$show_sidebar = get_theme_mod('hakajobs_sidebar_show_on_pages', '1');

while (have_posts()) : the_post();
?>

<?php hakajobs_breadcrumbs(); ?>

<main id="hk-main" class="hk-site-main hk-page-standard">
    <div class="hk-container">
        <?php if ($show_sidebar === '1'): ?>
            <div class="hk-layout-with-sidebar">
                <div class="hk-page-main-col">
                    <article class="hk-page-card">
                        <header class="hk-page-header">
                            <h1 class="hk-page-title"><?php the_title(); ?></h1>
                        </header>

                        <div class="hk-page-content hk-typography">
                            <?php the_content(); ?>
                        </div>
                    </article>
                </div>

                <!-- Right Column: Sidebar -->
                <?php get_sidebar(); ?>
            </div>
        <?php else: ?>
            <article class="hk-page-card">
                <header class="hk-page-header">
                    <h1 class="hk-page-title"><?php the_title(); ?></h1>
                </header>

                <div class="hk-page-content hk-typography">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endif; ?>
    </div>
</main>

<?php
endwhile;
get_footer();
