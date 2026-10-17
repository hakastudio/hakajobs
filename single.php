<?php
/**
 * Single Post Template for Hakajobs
 *
 * @package Hakajobs
 */

get_header();

while (have_posts()) : the_post();
?>

<?php hakajobs_breadcrumbs(); ?>

<main id="hk-main" class="hk-site-main hk-single-standard-page">
    <div class="hk-container">
        <article class="hk-article-card">
            <header class="hk-article-header">
                <h1 class="hk-article-title"><?php the_title(); ?></h1>
                <div class="hk-article-meta">
                    <span><?php echo get_the_date(); ?></span>
                    <span>•</span>
                    <span><?php the_author(); ?></span>
                    <?php if (has_category()): ?>
                        <span>•</span>
                        <span><?php the_category(', '); ?></span>
                    <?php endif; ?>
                </div>
            </header>

            <?php if (has_post_thumbnail()): ?>
                <div class="hk-article-thumb">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <div class="hk-article-content hk-typography">
                <?php the_content(); ?>
            </div>

            <footer class="hk-article-footer">
                <?php the_tags('<div class="hk-tags-list"><span>' . __('Tags:', 'hakajobs') . '</span> ', ' ', '</div>'); ?>
            </footer>
        </article>
    </div>
</main>

<?php
endwhile;
get_footer();
