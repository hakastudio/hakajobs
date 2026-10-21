<?php
/**
 * Main Index Template for Hakajobs
 *
 * @package Hakajobs
 */

get_header();
?>

<main id="hk-main" class="hk-site-main">
    <div class="hk-container">
        <div class="hk-archive-header" style="text-align:left; margin: 32px 0;">
            <h1 class="hk-archive-title"><?php _e('Berita & Artikel Karir', 'hakajobs'); ?></h1>
            <p class="hk-archive-subtitle"><?php _e('Tips seputar dunia kerja, wawancara, dan pengembangan karir.', 'hakajobs'); ?></p>
        </div>

        <?php if (have_posts()): ?>
            <div class="hk-articles-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="hk-blog-card">
                        <?php if (has_post_thumbnail()): ?>
                            <a href="<?php the_permalink(); ?>" class="hk-blog-card-thumb">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        <?php endif; ?>
                        <div class="hk-blog-card-body">
                            <span class="hk-blog-date"><?php echo get_the_date(); ?></span>
                            <h2 class="hk-blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p class="hk-blog-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                            <a href="<?php the_permalink(); ?>" class="hk-link-arrow"><?php _e('Baca Selengkapnya', 'hakajobs'); ?> &rarr;</a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="hk-pagination-wrap">
                <?php
                the_posts_pagination(array(
                    'mid_size'           => 2,
                    'prev_text'          => '&larr; ' . __('Sebelumnya', 'hakajobs'),
                    'next_text'          => __('Selanjutnya', 'hakajobs') . ' &rarr;',
                    'screen_reader_text' => __('Paginasi Artikel', 'hakajobs'),
                    'aria_label'         => __('Paginasi Artikel', 'hakajobs'),
                ));
                ?>
            </div>
        <?php else: ?>
            <div class="hk-empty-state">
                <h3><?php _e('Belum Ada Artikel', 'hakajobs'); ?></h3>
                <p><?php _e('Silakan cek kembali di lain waktu.', 'hakajobs'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
