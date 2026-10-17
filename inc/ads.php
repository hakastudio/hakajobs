<?php
/**
 * Google AdSense & Advertisement Engine for Hakajobs
 *
 * @package Hakajobs
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Inject Google AdSense Script & Verification into <head>
 */
function hakajobs_adsense_head_code() {
    $ads_enabled = get_theme_mod('hakajobs_ads_enable', '1');
    if ($ads_enabled !== '1') {
        return;
    }

    $client_id = trim(get_theme_mod('hakajobs_adsense_client', ''));
    $head_code = trim(get_theme_mod('hakajobs_ad_head_code', ''));

    echo "\n<!-- Google AdSense Engine by Hakajobs -->\n";

    // Auto Ads Script via Client ID
    if (!empty($client_id)) {
        // Sanitize client id format: ca-pub-XXXXXXXXXXXXXXXX
        if (strpos($client_id, 'ca-pub-') === false && is_numeric($client_id)) {
            $client_id = 'ca-pub-' . $client_id;
        }
        echo '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=' . esc_attr($client_id) . '" crossorigin="anonymous"></script>' . "\n";
    }

    // Custom Head Script / Ad Code
    if (!empty($head_code)) {
        echo $head_code . "\n";
    }
}
add_action('wp_head', 'hakajobs_adsense_head_code', 20);

/**
 * Render Ad Unit Slot with Google AdSense Policy Compliance
 *
 * @param string $slot_id (e.g. 'header', 'sidebar', 'single_top', 'single_bottom', 'footer')
 * @param string $css_class Additional CSS classes
 */
function hakajobs_render_ad_slot($slot_id, $css_class = '') {
    $ads_enabled = get_theme_mod('hakajobs_ads_enable', '1');
    if ($ads_enabled !== '1') {
        return;
    }

    $ad_code   = get_theme_mod('hakajobs_ad_slot_' . $slot_id, '');
    $demo_mode = get_theme_mod('hakajobs_ads_demo_mode', '0');

    if (empty($ad_code) && $demo_mode !== '1') {
        return;
    }

    $slot_labels = array(
        'header'        => __('Banner Atas (Leaderboard 728x90 / Responsif)', 'hakajobs'),
        'sidebar'       => __('Sidebar (Kotak 300x250 / 300x600)', 'hakajobs'),
        'single_top'    => __('Dalam Lowongan — Atas Deskripsi (Responsif)', 'hakajobs'),
        'single_bottom' => __('Dalam Lowongan — Bawah Deskripsi (Responsif)', 'hakajobs'),
        'footer'        => __('Banner Bawah — Sebelum Footer (Lebar)', 'hakajobs'),
    );

    $slot_name = isset($slot_labels[$slot_id]) ? $slot_labels[$slot_id] : ucfirst($slot_id);
    ?>
    <div class="hk-ad-slot hk-ad-slot-<?php echo esc_attr($slot_id); ?> <?php echo esc_attr($css_class); ?>">
        <div class="hk-ad-header-label">
            <span class="hk-ad-badge"><?php _e('IKLAN', 'hakajobs'); ?></span>
        </div>
        <div class="hk-ad-inner">
            <?php if (!empty($ad_code)): ?>
                <?php echo $ad_code; ?>
            <?php elseif ($demo_mode === '1'): ?>
                <div class="hk-ad-placeholder">
                    <div class="hk-ad-ph-icon">📢</div>
                    <div class="hk-ad-ph-info">
                        <strong><?php echo sprintf(__('Slot Iklan Google AdSense: %s', 'hakajobs'), esc_html($slot_name)); ?></strong>
                        <span><?php _e('Masukkan kode iklan AdSense di: Tampilan > Sesuaikan > 💰 Google AdSense & Penempatan Iklan', 'hakajobs'); ?></span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}
