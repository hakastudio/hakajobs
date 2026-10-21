<?php
/**
 * Header Template for Hakajobs
 *
 * @package Hakajobs
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <script>
        (function() {
            try {
                var defaultSetting = <?php echo json_encode(get_theme_mod('hakajobs_default_theme_mode', 'system')); ?>;
                var saved = localStorage.getItem('hk_theme');
                var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                var activeTheme = 'light';
                if (saved === 'dark' || saved === 'light') {
                    activeTheme = saved;
                } else if (defaultSetting === 'dark') {
                    activeTheme = 'dark';
                } else if (defaultSetting === 'light') {
                    activeTheme = 'light';
                } else if (prefersDark) {
                    activeTheme = 'dark';
                }
                document.documentElement.setAttribute('data-theme', activeTheme);
            } catch(e) {}
        })();
    </script>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="hk-page" class="hk-site-wrapper">
    <!-- Top Announcement Bar -->
    <?php
    $show_topbar      = get_theme_mod('hakajobs_show_topbar', '1');
    $topbar_badge     = get_theme_mod('hakajobs_topbar_badge', '');
    $topbar_text      = get_theme_mod('hakajobs_topbar_text', '');
    $post_job_url     = get_theme_mod('hakajobs_post_job_url', home_url('/pasang-loker/'));
    $post_job_label   = get_theme_mod('hakajobs_post_job_label', __('Pasang Loker', 'hakajobs'));
    $logo_icon        = get_theme_mod('hakajobs_logo_icon', '💼');
    $show_tagline     = get_theme_mod('hakajobs_show_tagline', '1');
    $show_bookmark    = get_theme_mod('hakajobs_show_bookmark_btn', '1');
    $link1_label      = get_theme_mod('hakajobs_menu_link1_label', '');
    $link1_url        = get_theme_mod('hakajobs_menu_link1_url', '');
    $link2_label      = get_theme_mod('hakajobs_menu_link2_label', '');
    $link2_url        = get_theme_mod('hakajobs_menu_link2_url', '');
    $has_topbar_content = (!empty($topbar_badge) || !empty($topbar_text) || !empty($link1_url) || !empty($link2_url));
    ?>
    <?php if ($show_topbar === '1' && $has_topbar_content): ?>
    <div class="hk-topbar">
        <div class="hk-container hk-topbar-inner">
            <?php if (!empty($topbar_badge) || !empty($topbar_text)): ?>
            <div class="hk-topbar-left">
                <?php if (!empty($topbar_badge)): ?>
                <span class="hk-topbar-badge"><?php echo esc_html($topbar_badge); ?></span>
                <?php endif; ?>
                <?php if (!empty($topbar_text)): ?>
                <span class="hk-topbar-text"><?php echo esc_html($topbar_text); ?></span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if (!empty($link1_url) || !empty($link2_url)): ?>
            <div class="hk-topbar-right">
                <?php if (!empty($link1_url)): ?>
                <a href="<?php echo esc_url($link1_url); ?>" class="hk-topbar-link">
                    <?php echo esc_html($link1_label); ?>
                </a>
                <?php endif; ?>
                <?php if (!empty($link1_url) && !empty($link2_url)): ?>
                <span class="hk-topbar-sep">•</span>
                <?php endif; ?>
                <?php if (!empty($link2_url)): ?>
                <a href="<?php echo esc_url($link2_url); ?>" class="hk-topbar-link">
                    <?php echo esc_html($link2_label); ?>
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Navigation Header -->
    <header class="hk-site-header" id="hk-masthead">
        <div class="hk-container hk-header-inner">
            
            <!-- Site Brand / Logo -->
            <div class="hk-site-branding">
                <?php if (has_custom_logo()): ?>
                    <div class="hk-custom-logo"><?php the_custom_logo(); ?></div>
                <?php else: ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="hk-site-logo-link" rel="home">
                        <span class="hk-logo-icon"><?php echo esc_html($logo_icon); ?></span>
                        <div class="hk-logo-text-wrap">
                            <span class="hk-site-title"><?php bloginfo('name'); ?></span>
                            <?php if ($show_tagline === '1'): ?>
                            <span class="hk-site-tagline"><?php bloginfo('description'); ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Desktop Nav Menu -->
            <nav class="hk-main-navigation" id="hk-site-navigation" aria-label="<?php esc_attr_e('Menu Utama', 'hakajobs'); ?>">
                <?php
                if (has_nav_menu('primary-menu')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary-menu',
                        'menu_class'     => 'hk-nav-list',
                        'container'      => false,
                        'depth'          => 2,
                    ));
                } else {
                    hakajobs_fallback_menu(false);
                }
                ?>
            </nav>

            <!-- Header Action Controls -->
            <div class="hk-header-actions">
                <!-- Dark Mode Toggle Button -->
                <?php 
                $show_theme_toggle = get_theme_mod('hakajobs_show_theme_toggle', '1');
                if ($show_theme_toggle === '1'): 
                ?>
                <button type="button" class="hk-theme-toggle" id="hk-theme-toggle" aria-label="<?php esc_attr_e('Ganti Mode Gelap/Terang', 'hakajobs'); ?>" title="<?php esc_attr_e('Mode Gelap / Terang', 'hakajobs'); ?>">
                    <span class="hk-theme-icon-sun" aria-hidden="true">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                    </span>
                    <span class="hk-theme-icon-moon" aria-hidden="true">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                    </span>
                </button>
                <?php endif; ?>

                <!-- Saved Jobs Counter Button -->
                <?php if ($show_bookmark === '1'): ?>
                <button type="button" class="hk-btn-saved-trigger" id="hk-saved-jobs-toggle" aria-label="<?php esc_attr_e('Buka Lowongan Tersimpan', 'hakajobs'); ?>" title="<?php esc_attr_e('Lowongan Tersimpan', 'hakajobs'); ?>">
                    <svg class="hk-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
                    <span class="hk-saved-count-badge" id="hk-saved-badge">0</span>
                </button>
                <?php endif; ?>

                <!-- Post Job CTA for Employers -->
                <?php 
                $show_cta = get_theme_mod('hakajobs_show_cta_btn', '1');
                if ($show_cta === '1' && !empty($post_job_label)): 
                ?>
                <a href="<?php echo esc_url($post_job_url); ?>" class="hk-btn hk-btn-header-cta">
                    <svg class="hk-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span><?php echo esc_html($post_job_label); ?></span>
                </a>
                <?php endif; ?>

                <!-- Mobile Hamburger Button -->
                <button type="button" class="hk-mobile-menu-toggle" id="hk-mobile-toggle" aria-label="<?php esc_attr_e('Buka Menu', 'hakajobs'); ?>" aria-expanded="false" aria-controls="hk-mobile-drawer">
                    <span class="hk-hamburger-line"></span>
                    <span class="hk-hamburger-line"></span>
                    <span class="hk-hamburger-line"></span>
                </button>
            </div>

        </div>
    </header>

    <!-- Mobile Drawer Navigation -->
    <div class="hk-mobile-drawer" id="hk-mobile-drawer" aria-hidden="true">
        <div class="hk-mobile-drawer-header">
            <span class="hk-mobile-drawer-title"><?php bloginfo('name'); ?></span>
            <button type="button" class="hk-drawer-close" id="hk-drawer-close" aria-label="<?php esc_attr_e('Tutup Menu', 'hakajobs'); ?>">&times;</button>
        </div>
        <div class="hk-mobile-drawer-body">
            <?php
            if (has_nav_menu('primary-menu')) {
                wp_nav_menu(array(
                    'theme_location' => 'primary-menu',
                    'menu_class'     => 'hk-mobile-nav-list',
                    'container'      => false,
                    'depth'          => 2,
                ));
            } else {
                hakajobs_fallback_menu(true);
            }
            ?>
            <?php if ($show_theme_toggle === '1'): ?>
            <div class="hk-mobile-drawer-theme">
                <span class="hk-drawer-theme-label"><?php _e('🌓 Mode Tampilan', 'hakajobs'); ?></span>
                <div class="hk-drawer-theme-switch">
                    <button type="button" class="hk-drawer-theme-btn" data-theme="light"><?php _e('☀️ Terang', 'hakajobs'); ?></button>
                    <button type="button" class="hk-drawer-theme-btn" data-theme="dark"><?php _e('🌙 Gelap', 'hakajobs'); ?></button>
                </div>
            </div>
            <?php endif; ?>
            <?php 
            $show_cta = get_theme_mod('hakajobs_show_cta_btn', '1');
            if ($show_cta === '1' && !empty($post_job_label)): 
            ?>
            <div class="hk-mobile-drawer-cta">
                <a href="<?php echo esc_url($post_job_url); ?>" class="hk-btn hk-btn-primary hk-btn-block">
                    + <?php echo esc_html($post_job_label); ?>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="hk-drawer-backdrop" id="hk-drawer-backdrop"></div>
