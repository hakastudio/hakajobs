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
$custom_copy    = get_theme_mod('hakajobs_copyright_text', '');
$show_tagline   = get_theme_mod('hakajobs_show_footer_tagline', '0');
$footer_tagline = get_theme_mod('hakajobs_footer_tagline', __('Portal Info Lowongan Kerja Tanpa Login', 'hakajobs'));
$enable_btt     = get_theme_mod('hakajobs_enable_back_to_top', '1');
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
                        $show_social   = get_theme_mod('hakajobs_show_footer_social', '1');
                        $social_label  = get_theme_mod('hakajobs_footer_social_label', __('Sosial Media Kami:', 'hakajobs'));
                        $social_wa     = trim(get_theme_mod('hakajobs_footer_social_wa', ''));
                        if (!empty($social_wa) && !preg_match('#^https?://#i', $social_wa)) {
                            $clean_wa  = preg_replace('/[^0-9]/', '', $social_wa);
                            if (substr($clean_wa, 0, 1) === '0') {
                                $clean_wa = '62' . substr($clean_wa, 1);
                            }
                            $social_wa = 'https://wa.me/' . $clean_wa;
                        }

                        $social_tg     = trim(get_theme_mod('hakajobs_footer_social_tg', ''));
                        $social_in     = trim(get_theme_mod('hakajobs_footer_social_in', ''));
                        $social_fb     = trim(get_theme_mod('hakajobs_footer_social_fb', ''));
                        $social_ig     = trim(get_theme_mod('hakajobs_footer_social_ig', ''));

                        $is_social_on     = ($show_social === '1' || $show_social === 1 || $show_social === true);
                        $has_social_links = (!empty($social_wa) || !empty($social_tg) || !empty($social_in) || !empty($social_fb) || !empty($social_ig));
                        ?>
                        <?php if ($is_social_on && $has_social_links): ?>
                            <div class="hk-footer-social-wrap">
                                <?php if (!empty($social_label)): ?>
                                    <span class="hk-footer-social-label"><?php echo esc_html($social_label); ?></span>
                                <?php endif; ?>
                                <div class="hk-footer-social-icons">
                                    <?php if (!empty($social_wa)): ?>
                                        <a href="<?php echo esc_url($social_wa); ?>" target="_blank" rel="noopener noreferrer nofollow" class="hk-social-icon-btn hk-btn-wa" title="WhatsApp" aria-label="WhatsApp">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($social_tg)): ?>
                                        <a href="<?php echo esc_url($social_tg); ?>" target="_blank" rel="noopener noreferrer nofollow" class="hk-social-icon-btn hk-btn-tg" title="Telegram" aria-label="Telegram">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0Zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.121l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.458c.538-.196 1.006.128.832.94Z"/></svg>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($social_in)): ?>
                                        <a href="<?php echo esc_url($social_in); ?>" target="_blank" rel="noopener noreferrer nofollow" class="hk-social-icon-btn hk-btn-in" title="LinkedIn" aria-label="LinkedIn">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($social_fb)): ?>
                                        <a href="<?php echo esc_url($social_fb); ?>" target="_blank" rel="noopener noreferrer nofollow" class="hk-social-icon-btn hk-btn-fb" title="Facebook" aria-label="Facebook">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($social_ig)): ?>
                                        <a href="<?php echo esc_url($social_ig); ?>" target="_blank" rel="noopener noreferrer nofollow" class="hk-social-icon-btn hk-btn-ig" title="Instagram" aria-label="Instagram">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                        </a>
                                    <?php endif; ?>
                                </div>
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
                <?php if ($show_tagline === '1' && !empty($footer_tagline)): ?>
                <div class="hk-footer-notes">
                    <span><?php echo esc_html($footer_tagline); ?></span>
                </div>
                <?php endif; ?>
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
