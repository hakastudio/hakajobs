<?php
/**
 * Single Job Template for Hakajobs
 *
 * @package Hakajobs
 */

get_header();

while (have_posts()) : the_post();
    $post_id          = get_the_ID();
    $company_name     = get_post_meta($post_id, '_hakajobs_company_name', true);
    $company_website  = get_post_meta($post_id, '_hakajobs_company_website', true);
    $company_location = get_post_meta($post_id, '_hakajobs_company_location', true);
    $salary           = get_post_meta($post_id, '_hakajobs_salary', true);
    $salary_period    = get_post_meta($post_id, '_hakajobs_salary_period', true);
    $deadline         = get_post_meta($post_id, '_hakajobs_deadline', true);
    $status           = get_post_meta($post_id, '_hakajobs_status', true);
    $benefits         = get_post_meta($post_id, '_hakajobs_benefits', true);
    $apply_notes      = get_post_meta($post_id, '_hakajobs_apply_notes', true);
    $views            = hakajobs_get_views($post_id);

    // Terms
    $terms_location   = get_the_terms($post_id, 'lokasi_lowongan');
    $location_label   = (!empty($terms_location) && !is_wp_error($terms_location)) ? $terms_location[0]->name : $company_location;
    if (empty($location_label)) {
        $location_label = __('Indonesia', 'hakajobs');
    }

    $terms_category   = get_the_terms($post_id, 'kategori_lowongan');
    $category_obj     = (!empty($terms_category) && !is_wp_error($terms_category)) ? $terms_category[0] : null;

    $terms_exp        = get_the_terms($post_id, 'pengalaman_kerja');
    $exp_label        = (!empty($terms_exp) && !is_wp_error($terms_exp)) ? $terms_exp[0]->name : __('Semua Pengalaman', 'hakajobs');

    $terms_edu        = get_the_terms($post_id, 'pendidikan_terakhir');
    $edu_label        = (!empty($terms_edu) && !is_wp_error($terms_edu)) ? $terms_edu[0]->name : __('Semua Jurusan', 'hakajobs');

    // Deadline & Expiry calculation
    $is_expired = false;
    $days_left  = null;
    if (!empty($deadline)) {
        $deadline_ts = strtotime($deadline . ' 23:59:59');
        $now_ts      = current_time('timestamp');
        if ($deadline_ts && $deadline_ts < $now_ts) {
            $is_expired = true;
        } else {
            $diff_sec  = $deadline_ts - $now_ts;
            $days_left = max(0, ceil($diff_sec / 86400));
        }
    }
    $is_closed = ($status === 'tutup' || $is_expired);

    $apply_info = hakajobs_get_apply_info($post_id);
?>

<?php hakajobs_breadcrumbs(); ?>

<main id="hk-main" class="hk-site-main hk-single-job-page">
    
    <!-- Job Header Card Section -->
    <section class="hk-single-header-section">
        <div class="hk-container">
            <div class="hk-single-header-card <?php echo $is_closed ? 'hk-header-closed' : ''; ?>">
                
                <div class="hk-single-header-top">
                    <div class="hk-single-company-logo">
                        <?php echo hakajobs_get_company_logo($post_id, 80); ?>
                    </div>

                    <div class="hk-single-header-details">
                        <div class="hk-single-company-line">
                            <span class="hk-company-name"><?php echo esc_html($company_name ? $company_name : get_bloginfo('name')); ?></span>
                            <?php if (!empty($company_website)): ?>
                                <a href="<?php echo esc_url($company_website); ?>" target="_blank" rel="noopener noreferrer nofollow" class="hk-company-web-link">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                    <?php _e('Website Perusahaan', 'hakajobs'); ?>
                                </a>
                            <?php endif; ?>

                            <div class="hk-header-status-badge">
                                <?php if ($is_closed): ?>
                                    <span class="hk-pill hk-pill-closed"><?php _e('Lowongan Ditutup', 'hakajobs'); ?></span>
                                <?php else: ?>
                                    <span class="hk-pill hk-pill-open"><?php _e('Rekrutmen Aktif', 'hakajobs'); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <h1 class="hk-single-job-title"><?php the_title(); ?></h1>

                        <div class="hk-single-meta-strip">
                            <span class="hk-meta-pill">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <?php echo esc_html($location_label); ?>
                            </span>

                            <?php if (!empty($salary)): ?>
                                <span class="hk-meta-pill hk-pill-salary">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="6" width="20" height="12" rx="2"></rect><circle cx="12" cy="12" r="2"></circle><path d="M6 12h.01M18 12h.01"></path></svg>
                                    <?php echo esc_html($salary); ?>
                                </span>
                            <?php endif; ?>

                            <span class="hk-meta-pill">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                <?php echo sprintf(__('Diterbitkan %s', 'hakajobs'), hakajobs_time_ago(get_the_time('U'))); ?>
                            </span>

                            <span class="hk-meta-pill">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <?php echo number_format_i18n($views); ?> <?php _e('kali dilihat', 'hakajobs'); ?>
                            </span>
                        </div>

                        <div class="hk-single-type-badges">
                            <?php echo hakajobs_get_job_type_badges($post_id); ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Main Content & Sticky Sidebar Grid -->
    <section class="hk-single-body-section">
        <div class="hk-container">
            <div class="hk-single-layout">

                <!-- Left Column: Job Description & Details -->
                <div class="hk-single-content">

                    <!-- Excerpt / Quick Highlights if present -->
                    <?php if (has_excerpt()): ?>
                        <div class="hk-single-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Ad Slot: Single Job Top -->
                    <?php if (function_exists('hakajobs_render_ad_slot')) { hakajobs_render_ad_slot('single_top'); } ?>

                    <!-- Main Job Description -->
                    <div class="hk-job-description-box hk-typography">
                        <h2 class="hk-box-heading"><?php _e('Deskripsi & Kualifikasi Pekerjaan', 'hakajobs'); ?></h2>
                        <?php the_content(); ?>
                    </div>

                    <!-- Benefits & Facilities -->
                    <?php if (!empty($benefits)): 
                        $benefit_lines = array_filter(array_map('trim', explode("\n", $benefits)));
                        if (!empty($benefit_lines)):
                    ?>
                        <div class="hk-job-benefits-box">
                            <h3 class="hk-box-heading">✨ <?php _e('Benefit & Fasilitas yang Diberikan', 'hakajobs'); ?></h3>
                            <ul class="hk-benefits-grid">
                                <?php foreach ($benefit_lines as $b): ?>
                                    <li class="hk-benefit-item">
                                        <svg class="hk-benefit-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                        <span><?php echo esc_html($b); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; endif; ?>

                    <!-- Special Application Notes -->
                    <?php if (!empty($apply_notes)): ?>
                        <div class="hk-job-notes-box">
                            <h4 class="hk-notes-heading">📌 <?php _e('Petunjuk Khusus Pelamar', 'hakajobs'); ?></h4>
                            <p class="hk-notes-text"><?php echo nl2br(esc_html($apply_notes)); ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- Ad Slot: Single Job Bottom -->
                    <?php if (function_exists('hakajobs_render_ad_slot')) { hakajobs_render_ad_slot('single_bottom'); } ?>

                    <!-- Recruitment Safety Warning -->
                    <div class="hk-job-alert-warning">
                        <div class="hk-alert-icon">⚠️</div>
                        <div class="hk-alert-text">
                            <strong><?php _e('Perhatian untuk Calon Pelamar:', 'hakajobs'); ?></strong>
                            <p><?php _e('Jangan pernah mentransfer biaya administrasi, tiket pesawat, atau akomodasi hotel. Proses rekrutmen kerja resmi dari perusahaan yang benar TIDAK PERNAH memungut biaya apapun dari pelamar kerja.', 'hakajobs'); ?></p>
                        </div>
                    </div>

                    <!-- Social Share Section -->
                    <div class="hk-job-share-bar">
                        <span class="hk-share-label"><?php _e('Bagikan lowongan ini:', 'hakajobs'); ?></span>
                        <div class="hk-share-buttons">
                            <!-- WhatsApp Share -->
                            <a href="https://api.whatsapp.com/send?text=<?php echo rawurlencode(get_the_title() . ' di ' . $company_name . ' - Info lengkap: ' . get_permalink()); ?>" target="_blank" rel="noopener noreferrer" class="hk-share-btn hk-share-wa" title="<?php esc_attr_e('Bagikan ke WhatsApp', 'hakajobs'); ?>">
                                <span>WhatsApp</span>
                            </a>
                            <!-- Telegram Share -->
                            <a href="https://t.me/share/url?url=<?php echo rawurlencode(get_permalink()); ?>&text=<?php echo rawurlencode(get_the_title() . ' - ' . $company_name); ?>" target="_blank" rel="noopener noreferrer" class="hk-share-btn hk-share-tg" title="<?php esc_attr_e('Bagikan ke Telegram', 'hakajobs'); ?>">
                                <span>Telegram</span>
                            </a>
                            <!-- LinkedIn Share -->
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo rawurlencode(get_permalink()); ?>" target="_blank" rel="noopener noreferrer" class="hk-share-btn hk-share-li" title="<?php esc_attr_e('Bagikan ke LinkedIn', 'hakajobs'); ?>">
                                <span>LinkedIn</span>
                            </a>
                            <!-- Copy Link -->
                            <button type="button" class="hk-share-btn hk-share-copy" id="hk-copy-link-btn" data-url="<?php the_permalink(); ?>">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                                <span><?php _e('Salin Tautan', 'hakajobs'); ?></span>
                            </button>
                        </div>
                    </div>

                    <!-- Related Jobs ("Lowongan Serupa") -->
                    <?php
                    $related_args = array(
                        'post_type'      => 'lowongan',
                        'posts_per_page' => 3,
                        'post__not_in'   => array($post_id),
                        'orderby'        => 'rand',
                    );
                    if ($category_obj) {
                        $related_args['tax_query'] = array(
                            array(
                                'taxonomy' => 'kategori_lowongan',
                                'field'    => 'term_id',
                                'terms'    => $category_obj->term_id,
                            ),
                        );
                    }
                    $related_query = new WP_Query($related_args);

                    if ($related_query->have_posts()):
                    ?>
                    <div class="hk-related-jobs-wrap">
                        <h3 class="hk-related-title"><?php _e('Lowongan Kerja Terkait Lainnya', 'hakajobs'); ?></h3>
                        <div class="hk-jobs-list">
                            <?php
                            while ($related_query->have_posts()) {
                                $related_query->the_post();
                                hakajobs_render_job_card(get_the_ID());
                            }
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>

                <!-- Right Column: Sticky Apply & Job Overview Sidebar -->
                <aside class="hk-single-sidebar" aria-label="<?php esc_attr_e('Aksi Lamaran', 'hakajobs'); ?>">
                    
                    <!-- Primary Apply Card (Sticky) -->
                    <div class="hk-sticky-apply-card">
                        <div class="hk-apply-card-top">
                            <span class="hk-apply-subtext"><?php _e('Kirim Lamaran Langsung', 'hakajobs'); ?></span>
                            <h3 class="hk-apply-title"><?php _e('Tertarik dengan posisi ini?', 'hakajobs'); ?></h3>
                        </div>

                        <?php if ($is_closed): ?>
                            <div class="hk-apply-closed-notice">
                                <p><?php _e('Maaf, batas waktu penerimaan lamaran untuk posisi ini telah berakhir atau telah ditutup oleh rekruter.', 'hakajobs'); ?></p>
                                <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" class="hk-btn hk-btn-subtle hk-btn-block">
                                    <?php _e('Lihat Lowongan Kerja Lainnya', 'hakajobs'); ?>
                                </a>
                            </div>
                        <?php else: ?>
                            
                            <!-- Main Action Button -->
                            <div class="hk-apply-actions">
                                <a href="<?php echo esc_url($apply_info['link']); ?>" target="<?php echo esc_attr($apply_info['target']); ?>" class="hk-btn hk-btn-primary hk-btn-block hk-btn-apply-main <?php echo ($apply_info['channel'] === 'WhatsApp') ? 'hk-btn-wa' : ''; ?>" rel="nofollow">
                                    <?php if ($apply_info['channel'] === 'WhatsApp'): ?>
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                    <?php elseif ($apply_info['channel'] === 'Email'): ?>
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                    <?php else: ?>
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                    <?php endif; ?>
                                    <span><?php echo esc_html($apply_info['label']); ?></span>
                                </a>

                                <button type="button" class="hk-btn hk-btn-subtle hk-btn-block hk-btn-single-bookmark" data-job-id="<?php echo esc_attr($post_id); ?>" data-title="<?php echo esc_attr(get_the_title($post_id)); ?>" data-company="<?php echo esc_attr($company_name); ?>" data-url="<?php echo esc_url(get_permalink($post_id)); ?>">
                                    <svg class="hk-bookmark-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
                                    <span class="hk-bookmark-text"><?php _e('Simpan Lowongan', 'hakajobs'); ?></span>
                                </button>
                            </div>

                            <p class="hk-apply-channel-note">
                                <?php if ($apply_info['channel'] === 'WhatsApp'): ?>
                                    📱 <?php _e('Lamaran akan terhubung langsung ke pesan chat WhatsApp rekruter.', 'hakajobs'); ?>
                                <?php elseif ($apply_info['channel'] === 'Email'): ?>
                                    ✉️ <?php _e('Lamaran akan membuka aplikasi email dengan format subjek siap kirim.', 'hakajobs'); ?>
                                <?php else: ?>
                                    🔗 <?php _e('Lamaran akan dialihkan ke halaman formulir/portal resmi perusahaan.', 'hakajobs'); ?>
                                <?php endif; ?>
                            </p>

                        <?php endif; ?>

                        <!-- Job Summary Specifications -->
                        <div class="hk-overview-list">
                            <h4 class="hk-overview-heading"><?php _e('Ringkasan Lowongan', 'hakajobs'); ?></h4>

                            <div class="hk-overview-item">
                                <span class="hk-overview-label"><?php _e('Batas Pendaftaran', 'hakajobs'); ?></span>
                                <span class="hk-overview-value <?php echo ($days_left !== null && $days_left <= 3) ? 'hk-urgency-highlight' : ''; ?>">
                                    <?php if (!empty($deadline)): ?>
                                        <?php echo esc_html(date_i18n('d F Y', strtotime($deadline))); ?>
                                        <?php if ($days_left !== null && !$is_closed): ?>
                                            <small>(Sisa <?php echo (int)$days_left; ?> hari)</small>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php _e('Selama Dibuka', 'hakajobs'); ?>
                                    <?php endif; ?>
                                </span>
                            </div>

                            <div class="hk-overview-item">
                                <span class="hk-overview-label"><?php _e('Tipe Pekerjaan', 'hakajobs'); ?></span>
                                <span class="hk-overview-value">
                                    <?php
                                    $types = get_the_terms($post_id, 'tipe_pekerjaan');
                                    echo (!empty($types) && !is_wp_error($types)) ? esc_html($types[0]->name) : 'Penuh Waktu';
                                    ?>
                                </span>
                            </div>

                            <div class="hk-overview-item">
                                <span class="hk-overview-label"><?php _e('Gaji yang Ditawarkan', 'hakajobs'); ?></span>
                                <span class="hk-overview-value hk-salary-text">
                                    <?php echo !empty($salary) ? esc_html($salary) : __('Dirahasiakan / Kompetitif', 'hakajobs'); ?>
                                </span>
                            </div>

                            <div class="hk-overview-item">
                                <span class="hk-overview-label"><?php _e('Pengalaman Kerja', 'hakajobs'); ?></span>
                                <span class="hk-overview-value"><?php echo esc_html($exp_label); ?></span>
                            </div>

                            <div class="hk-overview-item">
                                <span class="hk-overview-label"><?php _e('Pendidikan Terakhir', 'hakajobs'); ?></span>
                                <span class="hk-overview-value"><?php echo esc_html($edu_label); ?></span>
                            </div>

                            <div class="hk-overview-item">
                                <span class="hk-overview-label"><?php _e('Lokasi Penempatan', 'hakajobs'); ?></span>
                                <span class="hk-overview-value"><?php echo esc_html($location_label); ?></span>
                            </div>
                        </div>

                    </div>

                    <!-- Sidebar Ad Slot -->
                    <?php if (function_exists('hakajobs_render_ad_slot')) { hakajobs_render_ad_slot('sidebar'); } ?>

                </aside>

            </div>
        </div>
    </section>

    <!-- Mobile Sticky Bottom Action Bar -->
    <?php if (!$is_closed): ?>
    <div class="hk-mobile-sticky-bar" id="hk-mobile-sticky-bar">
        <div class="hk-sticky-bar-info">
            <span class="hk-bar-company"><?php echo esc_html($company_name ? $company_name : get_bloginfo('name')); ?></span>
            <span class="hk-bar-title"><?php echo esc_html(wp_trim_words(get_the_title(), 4)); ?></span>
        </div>
        <div class="hk-sticky-bar-actions">
            <button type="button" class="hk-btn-bookmark hk-btn-mobile-bookmark" data-job-id="<?php echo esc_attr($post_id); ?>" title="<?php esc_attr_e('Simpan Lowongan', 'hakajobs'); ?>">
                <svg class="hk-bookmark-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
            </button>
            <a href="<?php echo esc_url($apply_info['link']); ?>" target="<?php echo esc_attr($apply_info['target']); ?>" class="hk-btn hk-btn-primary <?php echo ($apply_info['channel'] === 'WhatsApp') ? 'hk-btn-wa' : ''; ?>" rel="nofollow">
                <?php echo esc_html($apply_info['label']); ?>
            </a>
        </div>
    </div>
    <?php endif; ?>

</main>

<?php
endwhile;
get_footer();
