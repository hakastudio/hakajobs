<?php
/**
 * Page Template for Hakajobs
 *
 * @package Hakajobs
 */

get_header();

while (have_posts()) : the_post();
?>

<?php hakajobs_breadcrumbs(); ?>

<main id="hk-main" class="hk-site-main hk-page-standard">
    <div class="hk-container">
        <article class="hk-page-card">
            <header class="hk-page-header">
                <h1 class="hk-page-title"><?php the_title(); ?></h1>
            </header>

            <div class="hk-page-content hk-typography">
                <?php the_content(); ?>
            </div>
        </article>
    </div>
</main>

<?php
endwhile;
get_footer();
