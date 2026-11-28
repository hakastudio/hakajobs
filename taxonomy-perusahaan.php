<?php
/**
 * Taxonomy Archive Template for Perusahaan (Company Profile & Job Listings)
 * Menampilkan rangkuman seluruh lowongan kerja yang pernah diterbitkan oleh perusahaan (aktif maupun ditutup).
 *
 * @package Hakajobs
 */

get_header();

$term = get_queried_object();
$term_id = $term ? $term->term_id : 0;
$profile = function_exists('hakajobs_get_company_profile_data') ? hakajobs_get_company_profile_data($term_id) : false;
$company_name = $term ? $term->name : __('Perusahaan', 'hakajobs');
?>

<?php hakajobs_breadcrumbs(); ?>

<main id="hk-main" class="hk-site-main hk-company-archive-page">
    <div class="hk-container">

        <!-- Company Profile Hero Card -->
        <div class="hk-company-profile-card">
            <div class="hk-company-profile-main">
                <div class="hk-company-profile-logo">
                    <?php 
                    if ($profile && !empty($profile['logo_post_id'])) {
                        echo hakajobs_get_company_logo($profile['logo_post_id'], 76, true);
                    } else {
                        $initial = strtoupper(substr($company_name, 0, 2));
                        echo '<div class="hk-company-initial-avatar">' . esc_html($initial) . '</div>';
                    }
                    ?>
                </div>

                <div class="hk-company-profile-info">
                    <div class="hk-company-tagline">
                        <span class="hk-company-verified-badge">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <?php _e('Profil Rekruter / Pemberi Kerja', 'hakajobs'); ?>
                        </span>
                    </div>

                    <h1 class="hk-company-profile-name"><?php single_term_title(); ?></h1>

                    <div class="hk-company-profile-meta">
                        <?php if ($profile && !empty($profile['location'])): ?>
                            <span class="hk-company-meta-item">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <?php echo esc_html($profile['location']); ?>
                            </span>
                        <?php endif; ?>

                        <?php if ($profile && !empty($profile['website'])): ?>
                            <a href="<?php echo esc_url($profile['website']); ?>" target="_blank" rel="noopener noreferrer nofollow" class="hk-company-meta-item hk-company-web-link">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                <span><?php _e('Website Perusahaan', 'hakajobs'); ?></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Stats Bar -->
            <?php if ($profile): ?>
            <div class="hk-company-stats-strip">
                <div class="hk-stat-box hk-stat-total">
                    <span class="hk-stat-num"><?php echo (int) $profile['total']; ?></span>
                    <span class="hk-stat-label"><?php _e('Total Lowongan Pernah Tayang', 'hakajobs'); ?></span>
                </div>
                <div class="hk-stat-box hk-stat-active">
                    <span class="hk-stat-num"><?php echo (int) $profile['active']; ?></span>
                    <span class="hk-stat-label"><?php _e('Rekrutmen Aktif', 'hakajobs'); ?></span>
                </div>
                <div class="hk-stat-box hk-stat-closed">
                    <span class="hk-stat-num"><?php echo (int) $profile['closed']; ?></span>
                    <span class="hk-stat-label"><?php _e('Pendaftaran Ditutup', 'hakajobs'); ?></span>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Company About Section (Deskripsi Perusahaan) -->
        <?php
        $company_desc = (!empty($term->description)) ? $term->description : '';
        if (empty($company_desc) && $term_id) {
            $sample_jobs = get_posts(array(
                'post_type'      => 'lowongan',
                'posts_per_page' => 1,
                'post_status'    => array('publish', 'draft'),
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'perusahaan',
                        'field'    => 'term_id',
                        'terms'    => $term_id,
                    ),
                ),
                'meta_query'     => array(
                    array(
                        'key'     => '_hakajobs_company_description',
                        'value'   => '',
                        'compare' => '!=',
                    ),
                ),
                'fields'         => 'ids',
            ));
            if (!empty($sample_jobs)) {
                $company_desc = get_post_meta($sample_jobs[0], '_hakajobs_company_description', true);
                if (!empty($company_desc)) {
                    wp_update_term($term_id, 'perusahaan', array('description' => $company_desc));
                }
            }
        }
        ?>

        <?php if (!empty($company_desc)): ?>
            <section class="hk-company-about-card" aria-label="<?php echo esc_attr(sprintf(__('Tentang %s', 'hakajobs'), $company_name)); ?>">
                <div class="hk-company-about-header">
                    <div class="hk-company-about-title-wrap">
                        <span class="hk-company-about-icon-badge">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                            </svg>
                        </span>
                        <h2 class="hk-company-about-title"><?php printf(__('Tentang %s', 'hakajobs'), esc_html($company_name)); ?></h2>
                    </div>
                    <?php if (current_user_can('manage_categories') || current_user_can('edit_theme_options')): ?>
                        <a href="<?php echo esc_url(get_edit_term_link($term_id, 'perusahaan')); ?>" class="hk-company-about-edit-btn" title="<?php esc_attr_e('Edit deskripsi perusahaan ini di WordPress Admin', 'hakajobs'); ?>">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            <span><?php _e('Edit Deskripsi', 'hakajobs'); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="hk-company-about-content">
                    <?php echo wpautop(wp_kses_post($company_desc)); ?>
                </div>
            </section>
        <?php elseif (current_user_can('manage_categories') || current_user_can('edit_theme_options')): ?>
            <div class="hk-company-about-card hk-company-about-placeholder">
                <div class="hk-company-placeholder-inner">
                    <div class="hk-placeholder-main">
                        <div class="hk-placeholder-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                        </div>
                        <div class="hk-placeholder-text">
                            <strong><?php printf(__('Deskripsi untuk %s belum diisi', 'hakajobs'), esc_html($company_name)); ?></strong>
                            <p><?php _e('Tambahkan profil, bidang bisnis, atau visi & misi perusahaan agar halaman profil ini terlihat lebih lengkap dan terpercaya bagi calon pelamar.', 'hakajobs'); ?></p>
                        </div>
                    </div>
                    <a href="<?php echo esc_url(get_edit_term_link($term_id, 'perusahaan')); ?>" class="hk-btn hk-btn-primary hk-btn-sm" style="white-space: nowrap;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        <span><?php _e('Tulis Deskripsi', 'hakajobs'); ?></span>
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Ad Slot -->
        <?php if (function_exists('hakajobs_render_ad_slot')) { hakajobs_render_ad_slot('header'); } ?>

        <!-- Job Listings Section -->
        <div class="hk-company-jobs-section">
            <div class="hk-section-heading" style="margin-bottom: 20px;">
                <h2 class="hk-section-title" style="font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">
                    <?php printf(__('Daftar Lowongan dari %s', 'hakajobs'), esc_html($company_name)); ?>
                </h2>
                <span class="hk-section-subtitle" style="font-size: 13.5px; color: #64748b;">
                    <?php _e('Menampilkan riwayat seluruh lowongan kerja yang pernah diterbitkan (aktif maupun ditutup).', 'hakajobs'); ?>
                </span>
            </div>

            <?php if (have_posts()) : ?>
                <div class="hk-jobs-list">
                    <?php
                    while (have_posts()) : the_post();
                        hakajobs_render_job_card(get_the_ID());
                    endwhile;
                    ?>
                </div>

                <div class="hk-pagination-wrap" style="margin-top: 30px;">
                    <?php
                    the_posts_pagination(array(
                        'mid_size'           => 2,
                        'prev_text'          => '&larr; ' . __('Sebelumnya', 'hakajobs'),
                        'next_text'          => __('Selanjutnya', 'hakajobs') . ' &rarr;',
                        'screen_reader_text' => __('Navigasi Halaman Lowongan Perusahaan', 'hakajobs'),
                    ));
                    ?>
                </div>
            <?php else : ?>
                <div class="hk-empty-state" style="text-align: center; padding: 40px 20px; background: #fff; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <div class="hk-empty-icon" style="font-size: 40px; margin-bottom: 12px;">📂</div>
                    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 8px;"><?php _e('Belum Ada Lowongan', 'hakajobs'); ?></h3>
                    <p style="color: #64748b; margin-bottom: 16px;"><?php _e('Saat ini belum ada lowongan kerja yang terhubung ke profil perusahaan ini.', 'hakajobs'); ?></p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" class="hk-btn hk-btn-primary">
                        <?php _e('Jelajahi Lowongan Lainnya', 'hakajobs'); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>

<?php
get_footer();

