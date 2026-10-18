<?php
/**
 * Template Name: Halaman dengan Sidebar Kanan
 * Template Post Type: page
 *
 * Template halaman statis yang selalu menampilkan bilah sisi (sidebar kanan).
 *
 * @package Hakajobs
 */

get_header();

while (have_posts()) : the_post();
?>

<?php hakajobs_breadcrumbs(); ?>

<main id="hk-main" class="hk-site-main hk-page-standard">
    <div class="hk-container">
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
    </div>
</main>

<?php
endwhile;
get_footer();
