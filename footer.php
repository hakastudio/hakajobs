<?php
/**
 * Footer Template for Hakajobs
 *
 * @package Hakajobs
 */

$show_fraud   = get_theme_mod('hakajobs_show_fraud_alert', '1');
$fraud_title  = get_theme_mod('hakajobs_fraud_title', __('Peringatan Anti Penipuan Rekrutmen', 'hakajobs'));
$fraud_text   = get_theme_mod('hakajobs_fraud_text', __('Seluruh proses seleksi dan lamaran kerja di situs ini adalah 100% GRATIS. Jangan pernah mentransfer uang dengan alasan apapun (biaya administrasi, seragam, tiket travel, atau akomodasi hotel). Jika menemukan indikasi mencurigakan, segera laporkan ke pihak berwajib.', 'hakajobs'));
$footer_about = get_theme_mod('hakajobs_footer_about', __('Platform kurasi info lowongan kerja terpercaya, menghubungkan pencari kerja langsung dengan HRD via WhatsApp, Email, & Web resmi tanpa perlu registrasi akun.', 'hakajobs'));
$custom_copy  = get_theme_mod('hakajobs_copyright_text', '');
$enable_btt   = get_theme_mod('hakajobs_enable_back_to_top', '1');
$logo_icon    = get_theme_mod('hakajobs_logo_icon', '💼');
$col2_title   = get_theme_mod('hakajobs_footer_col2_title', __('Kategori Pekerjaan', 'hakajobs'));
$col3_title   = get_theme_mod('hakajobs_footer_col3_title', __('Kota & Wilayah', 'hakajobs'));
$col4_title   = get_theme_mod('hakajobs_footer_col4_title', __('Navigasi & Info', 'hakajobs'));
$col2_count   = (int) get_theme_mod('hakajobs_footer_col2_count', 6);
$col3_count   = (int) get_theme_mod('hakajobs_footer_col3_count', 6);
?>

    <!-- Footer Ad Slot -->
    <?php if (function_exists('hakajobs_render_ad_slot')) { hakajobs_render_ad_slot('footer'); } ?>

    <!-- Anti-Fraud Warning Callout -->
    <?php if ($show_fraud === '1'): ?>
    <section class="hk-fraud-alert-section">
        <div class="hk-container">
            <div class="hk-fraud-alert-card">
                <div class="hk-fraud-alert-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                </div>
                <div class="hk-fraud-alert-content">
                    <h4 class="hk-fraud-alert-title"><?php echo esc_html($fraud_title); ?></h4>
                    <p class="hk-fraud-alert-desc">
                        <?php echo esc_html($fraud_text); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Main Footer -->
    <footer class="hk-site-footer" id="hk-colophon">
        <div class="hk-container hk-footer-container">
            <div class="hk-footer-grid">

                <!-- Column 1: Brand & About / Widget -->
                <div class="hk-footer-col">
                    <?php if (is_active_sidebar('footer-1')): ?>
                        <?php dynamic_sidebar('footer-1'); ?>
                    <?php else: ?>
                        <div class="hk-footer-brand">
                            <?php if (has_custom_logo()): ?>
                                <div class="hk-custom-logo hk-footer-custom-logo"><?php the_custom_logo(); ?></div>
                            <?php else: ?>
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="hk-footer-logo-link" rel="home">
                                    <span class="hk-logo-icon"><?php echo esc_html($logo_icon); ?></span>
                                    <span class="hk-footer-brand-title"><?php bloginfo('name'); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                        <p class="hk-footer-about">
                            <?php bloginfo('description'); ?>
                        </p>
                        <p class="hk-footer-subtext">
                            <?php echo esc_html($footer_about); ?>
                        </p>
                        <?php
                        $show_share        = get_theme_mod('hakajobs_show_footer_share', '1');
                        $share_label       = get_theme_mod('hakajobs_footer_share_label', __('Bagikan Info Loker:', 'hakajobs'));
                        $share_wa          = get_theme_mod('hakajobs_footer_share_wa', '1');
                        $share_tg          = get_theme_mod('hakajobs_footer_share_tg', '1');
                        $share_in          = get_theme_mod('hakajobs_footer_share_in', '1');
                        $share_fb          = get_theme_mod('hakajobs_footer_share_fb', '0');
                        $share_text_custom = get_theme_mod('hakajobs_footer_share_text', '');
                        $site_url          = home_url('/');
                        $share_text        = !empty($share_text_custom) ? $share_text_custom : (get_bloginfo('name') . ' - Portal Info Lowongan Kerja Terupdate: ' . $site_url);
                        ?>
                        <?php if ($show_share === '1'): ?>
                            <div class="hk-social-pills">
                                <?php if (!empty($share_label)): ?>
                                    <span class="hk-social-label"><?php echo esc_html($share_label); ?></span>
                                <?php endif; ?>
                                <?php if ($share_wa === '1'): ?>
                                    <a href="https://api.whatsapp.com/send?text=<?php echo rawurlencode($share_text); ?>" target="_blank" rel="noopener noreferrer" class="hk-social-pill" title="WhatsApp">WA</a>
                                <?php endif; ?>
                                <?php if ($share_tg === '1'): ?>
                                    <a href="https://t.me/share/url?url=<?php echo rawurlencode($site_url); ?>&text=<?php echo rawurlencode(!empty($share_text_custom) ? $share_text_custom : (get_bloginfo('name') . ' Info Loker')); ?>" target="_blank" rel="noopener noreferrer" class="hk-social-pill" title="Telegram">TG</a>
                                <?php endif; ?>
                                <?php if ($share_in === '1'): ?>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo rawurlencode($site_url); ?>" target="_blank" rel="noopener noreferrer" class="hk-social-pill" title="LinkedIn">IN</a>
                                <?php endif; ?>
                                <?php if ($share_fb === '1'): ?>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode($site_url); ?>" target="_blank" rel="noopener noreferrer" class="hk-social-pill" title="Facebook">FB</a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Column 2: Kategori Pekerjaan (Widget / Menu / Auto) -->
                <div class="hk-footer-col">
                    <?php if (is_active_sidebar('footer-2')): ?>
                        <?php dynamic_sidebar('footer-2'); ?>
                    <?php else: ?>
                        <h4 class="hk-footer-heading"><?php echo esc_html($col2_title); ?></h4>
                        <?php if (has_nav_menu('footer-col2-menu')): ?>
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer-col2-menu',
                                'container'      => false,
                                'menu_class'     => 'hk-footer-links',
                                'depth'          => 1,
                            ));
                            ?>
                        <?php else: ?>
                            <ul class="hk-footer-links">
                                <?php
                                $categories = get_terms(array(
                                    'taxonomy'   => 'kategori_lowongan',
                                    'number'     => $col2_count > 0 ? $col2_count : 6,
                                    'hide_empty' => false,
                                ));
                                if (!empty($categories) && !is_wp_error($categories)) {
                                    foreach ($categories as $cat) {
                                        echo '<li><a href="' . esc_url(get_term_link($cat)) . '">' . esc_html($cat->name) . ' <span class="hk-footer-count">(' . $cat->count . ')</span></a></li>';
                                    }
                                } else {
                                    echo '<li><a href="' . esc_url(get_post_type_archive_link('lowongan')) . '">' . __('Semua Kategori', 'hakajobs') . '</a></li>';
                                }
                                ?>
                            </ul>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Column 3: Kota & Wilayah (Widget / Menu / Auto) -->
                <div class="hk-footer-col">
                    <?php if (is_active_sidebar('footer-3')): ?>
                        <?php dynamic_sidebar('footer-3'); ?>
                    <?php else: ?>
                        <h4 class="hk-footer-heading"><?php echo esc_html($col3_title); ?></h4>
                        <?php if (has_nav_menu('footer-col3-menu')): ?>
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer-col3-menu',
                                'container'      => false,
                                'menu_class'     => 'hk-footer-links',
                                'depth'          => 1,
                            ));
                            ?>
                        <?php else: ?>
                            <ul class="hk-footer-links">
                                <?php
                                $locations = get_terms(array(
                                    'taxonomy'   => 'lokasi_lowongan',
                                    'number'     => $col3_count > 0 ? $col3_count : 6,
                                    'hide_empty' => false,
                                ));
                                if (!empty($locations) && !is_wp_error($locations)) {
                                    foreach ($locations as $loc) {
                                        echo '<li><a href="' . esc_url(get_term_link($loc)) . '">' . esc_html($loc->name) . ' <span class="hk-footer-count">(' . $loc->count . ')</span></a></li>';
                                    }
                                } else {
                                    echo '<li><a href="' . esc_url(get_post_type_archive_link('lowongan')) . '">' . __('Semua Lokasi', 'hakajobs') . '</a></li>';
                                }
                                ?>
                            </ul>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Column 4: Navigasi & Info (Widget / Menu / Default) -->
                <div class="hk-footer-col">
                    <?php if (is_active_sidebar('footer-4')): ?>
                        <?php dynamic_sidebar('footer-4'); ?>
                    <?php else: ?>
                        <h4 class="hk-footer-heading"><?php echo esc_html($col4_title); ?></h4>
                        <?php if (has_nav_menu('footer-col4-menu') || has_nav_menu('footer-menu')): ?>
                            <?php
                            $menu_location = has_nav_menu('footer-col4-menu') ? 'footer-col4-menu' : 'footer-menu';
                            wp_nav_menu(array(
                                'theme_location' => $menu_location,
                                'container'      => false,
                                'menu_class'     => 'hk-footer-links',
                                'depth'          => 1,
                            ));
                            ?>
                        <?php else: ?>
                            <ul class="hk-footer-links">
                                <li><a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>"><?php _e('Cari Lowongan Kerja', 'hakajobs'); ?></a></li>
                                <li><a href="<?php echo esc_url(get_theme_mod('hakajobs_post_job_url', home_url('/pasang-loker/'))); ?>"><?php _e('Pasang Info Lowongan (Admin)', 'hakajobs'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/tentang-kami/')); ?>"><?php _e('Tentang Kami', 'hakajobs'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/kontak/')); ?>"><?php _e('Hubungi Pengelola', 'hakajobs'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/kebijakan-privasi/')); ?>"><?php _e('Kebijakan Privasi', 'hakajobs'); ?></a></li>
                            </ul>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

            </div>

            <!-- Footer Bottom -->
            <div class="hk-footer-bottom">
                <div class="hk-copyright">
                    <?php if (!empty($custom_copy)): ?>
                        <?php echo esc_html($custom_copy); ?>
                    <?php else: ?>
                        &copy; <?php echo date('Y'); ?> <strong><?php bloginfo('name'); ?></strong>. <?php _e('Hak Cipta Dilindungi.', 'hakajobs'); ?>
                    <?php endif; ?>
                </div>
                <div class="hk-footer-notes">
                    <span><?php _e('Portal Info Lowongan Kerja Tanpa Login', 'hakajobs'); ?></span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Saved Jobs Drawer Modal (LocalStorage based) -->
    <div class="hk-saved-modal" id="hk-saved-modal" aria-hidden="true" role="dialog" aria-labelledby="hk-saved-title">
        <div class="hk-saved-modal-backdrop" id="hk-saved-modal-backdrop"></div>
        <div class="hk-saved-modal-content">
            <div class="hk-saved-modal-header">
                <div>
                    <h3 class="hk-saved-modal-title" id="hk-saved-title"><?php _e('Lowongan Tersimpan', 'hakajobs'); ?></h3>
                    <p class="hk-saved-modal-subtitle"><?php _e('Disimpan langsung di peramban Anda tanpa perlu mendaftar akun.', 'hakajobs'); ?></p>
                </div>
                <button type="button" class="hk-saved-modal-close" id="hk-saved-modal-close" aria-label="<?php esc_attr_e('Tutup', 'hakajobs'); ?>">&times;</button>
            </div>
            <div class="hk-saved-modal-body" id="hk-saved-list-container">
                <!-- Injected via JavaScript from localStorage -->
            </div>
            <div class="hk-saved-modal-footer">
                <button type="button" class="hk-btn hk-btn-subtle" id="hk-clear-saved-btn"><?php _e('Hapus Semua', 'hakajobs'); ?></button>
                <a href="<?php echo esc_url(get_post_type_archive_link('lowongan')); ?>" class="hk-btn hk-btn-primary"><?php _e('Jelajahi Lowongan Lain', 'hakajobs'); ?></a>
            </div>
        </div>
    </div>

    <!-- Toast Notification for Links & Bookmarks -->
    <div class="hk-toast" id="hk-toast" role="status" aria-live="polite"></div>

    <!-- Floating Back to Top Button -->
    <?php if ($enable_btt === '1'): ?>
    <button type="button" class="hk-back-to-top" id="hk-back-to-top" aria-label="<?php esc_attr_e('Kembali ke Atas', 'hakajobs'); ?>" title="<?php esc_attr_e('Kembali ke Atas', 'hakajobs'); ?>">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"></polyline></svg>
    </button>
    <?php endif; ?>

</div><!-- #hk-page -->

<?php wp_footer(); ?>
</body>
</html>
