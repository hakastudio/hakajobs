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
    $exp        = function_exists('hakajobs_get_job_expiry_data') 
                    ? hakajobs_get_job_expiry_data($post_id) 
                    : array('is_expired' => false, 'is_closed' => ($status === 'tutup'), 'is_urgent' => false, 'days_left' => null, 'badge_class' => 'hk-pill-open', 'badge_label' => 'Rekrutmen Aktif', 'deadline_format' => $deadline);
    $is_expired = $exp['is_expired'];
    $is_closed  = $exp['is_closed'];
    $days_left  = $exp['days_left'];

    $apply_info = hakajobs_get_apply_info($post_id);
?>

<?php hakajobs_breadcrumbs(); ?>

<main id="hk-main" class="hk-site-main hk-single-job-page">
    
    <!-- Job Header Card Section -->
    <section class="hk-single-header-section">
        <div class="hk-container">

            <?php if (current_user_can('edit_post', $post_id)): 
                $wa_broadcast_url  = function_exists('hakajobs_get_wa_broadcast_url') ? hakajobs_get_wa_broadcast_url($post_id) : '#';
                $wa_broadcast_text = function_exists('hakajobs_get_wa_broadcast_text') ? hakajobs_get_wa_broadcast_text($post_id) : '';
                $wa_channel_url    = get_theme_mod('hakajobs_wa_channel_url', '');
            ?>
                <!-- Admin WhatsApp Broadcast Quick Bar -->
                <div class="hk-admin-broadcast-banner">
                    <div class="hk-admin-broadcast-info">
                        <span class="hk-admin-broadcast-badge">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            <?php _e('Alat Admin', 'hakajobs'); ?>
                        </span>
                        <div class="hk-admin-broadcast-texts">
                            <strong><?php _e('Siarkan Loker ke Saluran WhatsApp', 'hakajobs'); ?></strong>
                            <span><?php _e('Format teks siap kirim lengkap dengan emoji, ringkasan, dan link channel.', 'hakajobs'); ?></span>
                        </div>
                    </div>
                    <div class="hk-admin-broadcast-actions">
                        <a href="<?php echo esc_url($wa_broadcast_url); ?>" target="_blank" rel="noopener noreferrer" class="hk-admin-btn hk-admin-btn-wa" title="<?php esc_attr_e('Buka WhatsApp dan kirim ke Saluran atau Grup', 'hakajobs'); ?>">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            <span><?php _e('Kirim ke WhatsApp', 'hakajobs'); ?></span>
                        </a>
                        <button type="button" class="hk-admin-btn hk-admin-btn-copy hk-copy-broadcast-btn" data-broadcast="<?php echo esc_attr($wa_broadcast_text); ?>" title="<?php esc_attr_e('Salin teks format broadcast ke clipboard', 'hakajobs'); ?>">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                            <span><?php _e('Salin Teks', 'hakajobs'); ?></span>
                        </button>
                        <?php if (!empty($wa_channel_url)): ?>
                            <a href="<?php echo esc_url($wa_channel_url); ?>" target="_blank" rel="noopener noreferrer" class="hk-admin-btn hk-admin-btn-channel" title="<?php esc_attr_e('Buka Saluran WhatsApp Anda di tab baru', 'hakajobs'); ?>">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                <span><?php _e('Buka Saluran', 'hakajobs'); ?></span>
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo esc_url(get_edit_post_link($post_id)); ?>" class="hk-admin-btn hk-admin-btn-edit" title="<?php esc_attr_e('Edit lowongan ini di WordPress Admin', 'hakajobs'); ?>">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            <span><?php _e('Edit Loker', 'hakajobs'); ?></span>
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <div class="hk-single-header-card <?php echo $is_closed ? 'hk-header-closed' : ''; ?>">
                
                <div class="hk-single-header-top">
                    <div class="hk-single-company-logo">
                        <?php echo hakajobs_get_company_logo($post_id, 80, true); ?>
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
                                <?php if ($exp['is_closed']): ?>
                                    <span class="hk-pill hk-pill-closed"><?php _e('Pendaftaran Ditutup', 'hakajobs'); ?></span>
                                <?php elseif ($exp['is_urgent']): ?>
                                    <span class="hk-pill hk-pill-expiring" title="<?php esc_attr_e('Batas akhir penerimaan lamaran segera berakhir', 'hakajobs'); ?>">
                                        ⏳ <?php echo esc_html($exp['badge_label']); ?>
                                    </span>
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

                    <!-- Expired or Urgent Countdown Alert Banner -->
                    <?php if ($exp['is_closed']): ?>
                        <div class="hk-job-alert-closed">
                            <div class="hk-alert-icon">🚫</div>
                            <div class="hk-alert-text">
                                <strong><?php _e('Pendaftaran untuk Posisi Ini Telah Resmi Ditutup', 'hakajobs'); ?></strong>
                                <p>
                                    <?php if (!empty($deadline)): ?>
                                        <?php printf(__('Batas waktu penerimaan berkas telah berakhir pada %s. Rekruter tidak lagi menerima berkas lamaran baru untuk lowongan ini.', 'hakajobs'), '<strong>' . esc_html($exp['deadline_format']) . '</strong>'); ?>
                                    <?php else: ?>
                                        <?php _e('Proses penerimaan berkas telah ditutup oleh pihak perusahaan/rekruter.', 'hakajobs'); ?>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    <?php elseif ($exp['is_urgent']): ?>
                        <div class="hk-job-alert-expiring">
                            <div class="hk-alert-icon">⏳</div>
                            <div class="hk-alert-text">
                                <strong><?php _e('Peringatan: Batas Waktu Lamaran Segera Berakhir!', 'hakajobs'); ?></strong>
                                <p>
                                    <?php 
                                    $time_text = ($exp['days_left'] === 0) ? __('hari ini (kesempatan terakhir)', 'hakajobs') : sprintf(__('%d hari lagi', 'hakajobs'), (int)$exp['days_left']);
                                    printf(__('Penerimaan berkas untuk posisi ini akan ditutup dalam %s (Batas: %s). Segera kirimkan lamaran Anda sebelum akses pendaftaran ditutup secara otomatis.', 'hakajobs'), '<strong>' . $time_text . '</strong>', '<strong>' . esc_html($exp['deadline_format']) . '</strong>'); 
                                    ?>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>

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
                            <h2 class="hk-box-heading"><?php _e('Benefit & Fasilitas yang Diberikan', 'hakajobs'); ?></h2>
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
                            <h2 class="hk-notes-heading">📌 <?php _e('Petunjuk Khusus Pelamar', 'hakajobs'); ?></h2>
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

                    <!-- Public WhatsApp Channel Follower Widget -->
                    <?php
                    $wa_channel_url  = get_theme_mod('hakajobs_wa_channel_url', '');
                    $show_wa_widget  = get_theme_mod('hakajobs_wa_show_public_widget', '1');
                    $wa_widget_title = get_theme_mod('hakajobs_wa_public_cta_title', __('Dapatkan Info Lowongan Kerja Harian di WhatsApp Anda!', 'hakajobs'));
                    $wa_widget_desc  = get_theme_mod('hakajobs_wa_public_cta_desc', __('Ikuti Saluran WhatsApp resmi kami. Gratis, tanpa spam, dan langsung terupdate setiap hari di ponsel Anda.', 'hakajobs'));
                    $wa_widget_btn   = get_theme_mod('hakajobs_wa_public_btn_text', __('Gabung Saluran WhatsApp', 'hakajobs'));

                    if (!empty($wa_channel_url) && $show_wa_widget === '1'):
                    ?>
                        <div class="hk-public-wa-channel-box">
                            <div class="hk-wa-channel-icon-wrap">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            </div>
                            <div class="hk-wa-channel-content">
                                <span class="hk-wa-channel-tag">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                    <?php _e('Saluran Resmi', 'hakajobs'); ?>
                                </span>
                                <h4 class="hk-wa-channel-title"><?php echo esc_html($wa_widget_title); ?></h4>
                                <p class="hk-wa-channel-desc"><?php echo esc_html($wa_widget_desc); ?></p>
                            </div>
                            <div class="hk-wa-channel-action">
                                <a href="<?php echo esc_url($wa_channel_url); ?>" target="_blank" rel="noopener noreferrer nofollow" class="hk-btn hk-btn-wa-channel">
                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                    <span><?php echo esc_html($wa_widget_btn); ?></span>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Social Share Section -->
                    <div class="hk-job-share-bar">
                        <span class="hk-share-label"><?php _e('Bagikan lowongan ini:', 'hakajobs'); ?></span>
                        <div class="hk-share-buttons">
                            <!-- WhatsApp Share -->
                            <?php 
                            $share_wa_url = function_exists('hakajobs_get_wa_broadcast_url') 
                                ? hakajobs_get_wa_broadcast_url($post_id) 
                                : ('https://api.whatsapp.com/send?text=' . rawurlencode(get_the_title() . ' di ' . $company_name . ' - Info lengkap: ' . get_permalink())); 
                            ?>
                            <a href="<?php echo esc_url($share_wa_url); ?>" target="_blank" rel="noopener noreferrer" class="hk-share-btn hk-share-wa" title="<?php esc_attr_e('Bagikan ke WhatsApp', 'hakajobs'); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
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
                                <div class="hk-closed-badge-large">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>
                                    <span><?php _e('Pendaftaran Ditutup', 'hakajobs'); ?></span>
                                </div>
                                <p><?php _e('Maaf, batas waktu penerimaan lamaran untuk posisi ini telah berakhir atau telah ditutup oleh rekruter.', 'hakajobs'); ?></p>
                                <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" class="hk-btn hk-btn-primary hk-btn-block">
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
                                <span class="hk-overview-value <?php echo $exp['is_urgent'] ? 'hk-urgency-highlight' : ($exp['is_closed'] ? 'hk-deadline-closed-text' : ''); ?>">
                                    <?php if (!empty($deadline)): ?>
                                        <?php if ($exp['is_closed']): ?>
                                            <s><?php echo esc_html($exp['deadline_format']); ?></s>
                                            <small style="color:#b91c1c; font-weight:700;">(<?php _e('Pendaftaran Ditutup', 'hakajobs'); ?>)</small>
                                        <?php elseif ($exp['is_urgent']): ?>
                                            ⏳ <?php echo esc_html($exp['deadline_format']); ?>
                                            <small style="color:#c2410c; font-weight:700;">(<?php echo esc_html($exp['badge_label']); ?>)</small>
                                        <?php else: ?>
                                            <?php echo esc_html($exp['deadline_format']); ?>
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
                                    echo (!empty($types) && !is_wp_error($types)) ? esc_html($types[0]->name) : 'Full-Time';
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
