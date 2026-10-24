<?php
/**
 * Category Archive Template for Hakajobs (Kategori Artikel & Tips Karir)
 *
 * @package Hakajobs
 */

get_header();

$cat_title = single_cat_title('', false);
$cat_desc  = category_description();
?>

<?php hakajobs_breadcrumbs(); ?>

<main id="hk-main" class="hk-site-main hk-category-page">
    <div class="hk-container">
        <div class="hk-archive-header" style="text-align:left; margin: 28px 0 36px;">
            <div class="hk-section-badge" style="margin-bottom:8px;">
                📂 <?php _e('Kategori Artikel', 'hakajobs'); ?>
            </div>
            <h1 class="hk-archive-title" style="margin-bottom:8px;"><?php echo esc_html($cat_title); ?></h1>
            <?php if (!empty($cat_desc)): ?>
                <div class="hk-archive-subtitle" style="max-width:720px; line-height:1.6; color:var(--hk-text-muted);">
                    <?php echo wp_kses_post($cat_desc); ?>
                </div>
            <?php else: ?>
                <p class="hk-archive-subtitle">
                    <?php printf(__('Kumpulan artikel, tips, dan panduan seputar %s.', 'hakajobs'), esc_html($cat_title)); ?>
                </p>
            <?php endif; ?>
        </div>

        <?php if (have_posts()): ?>
            <div class="hk-articles-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="hk-blog-card">
                        <?php if (has_post_thumbnail()): ?>
                            <a href="<?php the_permalink(); ?>" class="hk-blog-card-thumb">
                                <?php the_post_thumbnail('medium_large'); ?>
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
                <div class="hk-empty-icon" style="font-size:36px; margin-bottom:12px;">📝</div>
                <h3><?php _e('Belum Ada Artikel di Kategori Ini', 'hakajobs'); ?></h3>
                <p><?php _e('Artikel untuk topik ini sedang disiapkan. Silakan cek kembali nanti atau telusuri lowongan kerja yang tersedia.', 'hakajobs'); ?></p>
                <div style="margin-top:20px;">
                    <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" class="hk-btn hk-btn-primary">
                        <?php _e('Jelajahi Lowongan Kerja', 'hakajobs'); ?> &rarr;
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
