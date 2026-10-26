<?php
/**
 * Push Notification Prompt Module for Hakajobs
 *
 * Implements an Antaranews-style news & job alert prompt card.
 * Configurable via WordPress Theme Customizer.
 *
 * @package Hakajobs
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Theme Customizer Section & Controls for Push Notification
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function hakajobs_push_notification_customize_register($wp_customize) {
    // =========================================================================
    // SECTION: POP-UP NOTIFIKASI BERITA / LOKER (GAYA ANTARANEWS)
    // =========================================================================
    $wp_customize->add_section('hakajobs_push_notice_section', array(
        'title'       => __('Pop-up Notifikasi Berita / Loker', 'hakajobs'),
        'description' => __('Atur tampilan dan perilaku pop-up notifikasi bergaya Antaranews saat pengunjung membuka website.', 'hakajobs'),
        'panel'       => 'hakajobs_theme_options',
        'priority'    => 76,
    ));

    // 1. Aktifkan Fitur
    $wp_customize->add_setting('hakajobs_push_enable', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_enable', array(
        'type'        => 'checkbox',
        'label'       => __('Aktifkan Pop-up Notifikasi', 'hakajobs'),
        'description' => __('Tampilkan kartu notifikasi saat pengunjung membuka situs ini.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 2. Posisi Tampil
    $wp_customize->add_setting('hakajobs_push_pos', array(
        'default'           => 'top-left',
        'sanitize_callback' => 'hakajobs_sanitize_select',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_pos', array(
        'type'        => 'select',
        'label'       => __('Posisi Tampil di Layar', 'hakajobs'),
        'description' => __('Pilih letak kartu notifikasi muncul di layar pengunjung.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
        'choices'     => array(
            'top-left'     => __('Atas Kiri (Bawaan - Seperti Antaranews)', 'hakajobs'),
            'top-center'   => __('Atas Tengah', 'hakajobs'),
            'top-right'    => __('Atas Kanan', 'hakajobs'),
            'bottom-left'  => __('Bawah Kiri', 'hakajobs'),
            'bottom-right' => __('Bawah Kanan', 'hakajobs'),
        ),
    ));

    // 3. Tampilkan Pada Halaman
    $wp_customize->add_setting('hakajobs_push_show_on', array(
        'default'           => 'all',
        'sanitize_callback' => 'hakajobs_sanitize_select',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_show_on', array(
        'type'        => 'select',
        'label'       => __('Tampilkan Pada Halaman', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
        'choices'     => array(
            'all'    => __('Semua Halaman (Rekomendasi)', 'hakajobs'),
            'home'   => __('Hanya Halaman Depan / Beranda', 'hakajobs'),
            'single' => __('Hanya Halaman Lowongan & Artikel', 'hakajobs'),
        ),
    ));

    // 4. Teks Pesan Notifikasi
    $default_text = sprintf(
        /* translators: %s: site name */
        __('Dapatkan Berita Terkini khusus untuk anda dengan mengaktifkan notifikasi %s', 'hakajobs'),
        get_bloginfo('name')
    );
    $wp_customize->add_setting('hakajobs_push_text', array(
        'default'           => $default_text,
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_text', array(
        'type'        => 'textarea',
        'label'       => __('Teks Pesan Notifikasi', 'hakajobs'),
        'description' => __('Gunakan kode [site_name] untuk menyisipkan nama website secara dinamis.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 5. Jenis Ikon
    $wp_customize->add_setting('hakajobs_push_icon_type', array(
        'default'           => 'bell',
        'sanitize_callback' => 'hakajobs_sanitize_select',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_icon_type', array(
        'type'        => 'select',
        'label'       => __('Pilihan Ikon Notifikasi', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
        'choices'     => array(
            'bell'   => __('Ikon Lonceng Bawaan (SVG)', 'hakajobs'),
            'custom' => __('Unggah Ikon / Logo Kustom Sendiri', 'hakajobs'),
        ),
    ));

    // 6. Unggah Ikon Kustom
    $wp_customize->add_setting('hakajobs_push_custom_icon', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hakajobs_push_custom_icon', array(
        'label'       => __('Unggah Ikon / Logo Kustom', 'hakajobs'),
        'description' => __('Berlaku jika opsi ikon dipilih "Unggah Ikon Sendiri". Disarankan rasio 1:1 persegi (contoh: 80x80 px).', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    )));

    // 7. Warna Lingkaran Ikon
    $wp_customize->add_setting('hakajobs_push_icon_bg', array(
        'default'           => '#e53935',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_push_icon_bg', array(
        'label'       => __('Warna Latar Belakang Ikon', 'hakajobs'),
        'description' => __('Warna lingkaran di belakang ikon lonceng (bawaan: merah salmon #e53935).', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    )));

    // 8. Warna Ikon Lonceng
    $wp_customize->add_setting('hakajobs_push_icon_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_push_icon_color', array(
        'label'       => __('Warna Ikon Lonceng', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    )));

    // 9. Aksi Tombol Utama (Oke)
    $wp_customize->add_setting('hakajobs_push_action_type', array(
        'default'           => 'push_and_link',
        'sanitize_callback' => 'hakajobs_sanitize_select',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_action_type', array(
        'type'        => 'select',
        'label'       => __('Aksi Saat Tombol "Oke" Diklik', 'hakajobs'),
        'description' => __('Tentukan respons browser saat pengunjung menyetujui notifikasi.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
        'choices'     => array(
            'push_and_link' => __('Minta Izin Browser & Buka URL Tujuan (Jika Diisi)', 'hakajobs'),
            'push_only'     => __('Minta Izin Notifikasi Browser Saja (Web Push)', 'hakajobs'),
            'link_only'     => __('Hanya Buka Link / URL Tujuan (Saluran WA, Telegram, dll)', 'hakajobs'),
            'dismiss_only'  => __('Tutup Pop-up & Tandai Disetujui', 'hakajobs'),
        ),
    ));

    // 10. Teks Tombol Utama
    $wp_customize->add_setting('hakajobs_push_btn_ok_text', array(
        'default'           => 'Oke',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_btn_ok_text', array(
        'type'        => 'text',
        'label'       => __('Teks Tombol Utama', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 11. URL Tujuan Tombol Utama
    $wp_customize->add_setting('hakajobs_push_btn_ok_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_btn_ok_url', array(
        'type'        => 'url',
        'label'       => __('URL Tujuan / Tautan Broadcast (Opsional)', 'hakajobs'),
        'description' => __('Masukkan link Saluran WhatsApp, Telegram, atau halaman info khusus jika ingin mengarahkan pengunjung.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 12. Target Buka Tautan
    $wp_customize->add_setting('hakajobs_push_btn_ok_target', array(
        'default'           => '_blank',
        'sanitize_callback' => 'hakajobs_sanitize_select',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_btn_ok_target', array(
        'type'        => 'select',
        'label'       => __('Target Buka Tautan', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
        'choices'     => array(
            '_blank' => __('Buka di Tab Baru (_blank)', 'hakajobs'),
            '_self'  => __('Buka di Tab yang Sama (_self)', 'hakajobs'),
        ),
    ));

    // 13. Warna Tombol Utama (Background)
    $wp_customize->add_setting('hakajobs_push_btn_ok_bg', array(
        'default'           => '#c81e1e',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_push_btn_ok_bg', array(
        'label'       => __('Warna Latar Tombol Utama', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    )));

    // 14. Warna Teks Tombol Utama
    $wp_customize->add_setting('hakajobs_push_btn_ok_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_push_btn_ok_color', array(
        'label'       => __('Warna Teks Tombol Utama', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    )));

    // 15. Teks Tombol Tolak / Tutup
    $wp_customize->add_setting('hakajobs_push_btn_cancel_text', array(
        'default'           => 'Terima Kasih',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_btn_cancel_text', array(
        'type'        => 'text',
        'label'       => __('Teks Tombol Tolak / Tutup', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 16. Warna Teks Tombol Tolak
    $wp_customize->add_setting('hakajobs_push_btn_cancel_color', array(
        'default'           => '#c81e1e',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_push_btn_cancel_color', array(
        'label'       => __('Warna Teks Tombol Tolak', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    )));

    // 17. Jeda Waktu Muncul (Detik)
    $wp_customize->add_setting('hakajobs_push_delay', array(
        'default'           => 1,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_delay', array(
        'type'        => 'number',
        'label'       => __('Jeda Tampil Pop-up (Detik)', 'hakajobs'),
        'description' => __('Waktu tunggu setelah halaman termuat sebelum kartu muncul (contoh: 1 atau 2).', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 60,
            'step' => 1,
        ),
    ));

    // 18. Durasi Ingat Jika Ditolak (Hari)
    $wp_customize->add_setting('hakajobs_push_frequency', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_frequency', array(
        'type'        => 'number',
        'label'       => __('Jangka Waktu Tidak Tampil Jika Ditolak (Hari)', 'hakajobs'),
        'description' => __('Berapa hari kartu tidak akan ditampilkan lagi setelah pengunjung menekan tombol Terima Kasih.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 365,
            'step' => 1,
        ),
    ));

    // 19. Durasi Ingat Jika Diterima (Hari)
    $wp_customize->add_setting('hakajobs_push_accepted_frequency', array(
        'default'           => 30,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_accepted_frequency', array(
        'type'        => 'number',
        'label'       => __('Jangka Waktu Tidak Tampil Jika Disetujui (Hari)', 'hakajobs'),
        'description' => __('Berapa hari kartu tidak akan ditampilkan lagi setelah pengunjung menekan tombol Oke.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 365,
            'step' => 1,
        ),
    ));
}
add_action('customize_register', 'hakajobs_push_notification_customize_register', 20);

/**
 * Render Push Notification Prompt HTML, CSS, and JS in wp_footer
 */
function hakajobs_render_push_notification() {
    $enabled = get_theme_mod('hakajobs_push_enable', '1');
    if ($enabled !== '1') {
        return;
    }

    // Filter display based on page setting
    $show_on = get_theme_mod('hakajobs_push_show_on', 'all');
    if ($show_on === 'home' && !is_front_page()) {
        return;
    }
    if ($show_on === 'single' && !is_singular()) {
        return;
    }

    $pos              = get_theme_mod('hakajobs_push_pos', 'top-left');
    $site_name        = get_bloginfo('name');
    $default_text     = sprintf(__('Dapatkan Berita Terkini khusus untuk anda dengan mengaktifkan notifikasi %s', 'hakajobs'), $site_name);
    $text_raw         = get_theme_mod('hakajobs_push_text', $default_text);
    $text             = str_replace('[site_name]', $site_name, $text_raw);

    $icon_type        = get_theme_mod('hakajobs_push_icon_type', 'bell');
    $custom_icon      = get_theme_mod('hakajobs_push_custom_icon', '');
    $icon_bg          = get_theme_mod('hakajobs_push_icon_bg', '#e53935');
    $icon_color       = get_theme_mod('hakajobs_push_icon_color', '#ffffff');

    $action_type      = get_theme_mod('hakajobs_push_action_type', 'push_and_link');
    $btn_ok_text      = get_theme_mod('hakajobs_push_btn_ok_text', __('Oke', 'hakajobs'));
    $btn_ok_url       = get_theme_mod('hakajobs_push_btn_ok_url', '');
    $btn_ok_target    = get_theme_mod('hakajobs_push_btn_ok_target', '_blank');
    $btn_ok_bg        = get_theme_mod('hakajobs_push_btn_ok_bg', '#c81e1e');
    $btn_ok_color     = get_theme_mod('hakajobs_push_btn_ok_color', '#ffffff');

    $btn_cancel_text  = get_theme_mod('hakajobs_push_btn_cancel_text', __('Terima Kasih', 'hakajobs'));
    $btn_cancel_color = get_theme_mod('hakajobs_push_btn_cancel_color', '#c81e1e');

    $delay            = max(0, intval(get_theme_mod('hakajobs_push_delay', 1)));
    $frequency        = max(1, intval(get_theme_mod('hakajobs_push_frequency', 3)));
    $acc_frequency    = max(1, intval(get_theme_mod('hakajobs_push_accepted_frequency', 30)));
    ?>

    <!-- Hakajobs Antaranews-style Push Notification Prompt -->
    <aside class="hk-push-prompt hk-push-pos-<?php echo esc_attr($pos); ?>" 
           id="hk-push-prompt" 
           role="dialog" 
           aria-labelledby="hk-push-prompt-desc" 
           aria-modal="false" 
           aria-hidden="true"
           style="display: none;">
        <div class="hk-push-prompt-card">
            <div class="hk-push-prompt-body">
                <div class="hk-push-prompt-icon-wrap" style="background-color: <?php echo esc_attr($icon_bg); ?>; color: <?php echo esc_attr($icon_color); ?>;">
                    <?php if ($icon_type === 'custom' && !empty($custom_icon)): ?>
                        <img src="<?php echo esc_url($custom_icon); ?>" alt="<?php esc_attr_e('Ikon Notifikasi', 'hakajobs'); ?>" class="hk-push-custom-img" />
                    <?php else: ?>
                        <svg class="hk-push-bell-svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M12 2C10.9 2 10 2.9 10 4C7.24 4.46 5 6.96 5 10V16L3 18V19H21V18L19 16V10C19 6.96 16.76 4.46 14 4C14 2.9 13.1 2 12 2ZM12 22C13.1 22 14 21.1 14 20H10C10 21.1 10.9 22 12 22Z"/>
                        </svg>
                    <?php endif; ?>
                </div>
                <div class="hk-push-prompt-content">
                    <p class="hk-push-prompt-text" id="hk-push-prompt-desc">
                        <?php echo nl2br(esc_html($text)); ?>
                    </p>
                </div>
            </div>
            <div class="hk-push-prompt-actions">
                <button type="button" 
                        class="hk-push-btn hk-push-btn-cancel" 
                        id="hk-push-btn-cancel" 
                        style="color: <?php echo esc_attr($btn_cancel_color); ?>;">
                    <?php echo esc_html($btn_cancel_text); ?>
                </button>
                <button type="button" 
                        class="hk-push-btn hk-push-btn-ok" 
                        id="hk-push-btn-ok" 
                        style="background-color: <?php echo esc_attr($btn_ok_bg); ?>; color: <?php echo esc_attr($btn_ok_color); ?>;">
                    <?php echo esc_html($btn_ok_text); ?>
                </button>
            </div>
        </div>
    </aside>

    <style id="hk-push-prompt-inline-css">
        .hk-push-prompt {
            position: fixed;
            z-index: 99995;
            pointer-events: auto;
            max-width: 440px;
            width: calc(100% - 32px);
            opacity: 0;
            transition: opacity 0.28s cubic-bezier(0.16, 1, 0.3, 1), transform 0.28s cubic-bezier(0.16, 1, 0.3, 1);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            box-sizing: border-box;
        }

        /* Posisi Desktop */
        .hk-push-prompt.hk-push-pos-top-left {
            top: 20px;
            left: 20px;
            transform: translateY(-16px);
        }
        .hk-push-prompt.hk-push-pos-top-center {
            top: 20px;
            left: 50%;
            transform: translate(-50%, -16px);
        }
        .hk-push-prompt.hk-push-pos-top-right {
            top: 20px;
            right: 20px;
            transform: translateY(-16px);
        }
        .hk-push-prompt.hk-push-pos-bottom-left {
            bottom: 20px;
            left: 20px;
            transform: translateY(16px);
        }
        .hk-push-prompt.hk-push-pos-bottom-right {
            bottom: 20px;
            right: 20px;
            transform: translateY(16px);
        }

        /* Offset saat ada WP Admin Bar */
        .admin-bar .hk-push-prompt.hk-push-pos-top-left,
        .admin-bar .hk-push-prompt.hk-push-pos-top-center,
        .admin-bar .hk-push-prompt.hk-push-pos-top-right {
            top: 52px;
        }
        @media (max-width: 782px) {
            .admin-bar .hk-push-prompt.hk-push-pos-top-left,
            .admin-bar .hk-push-prompt.hk-push-pos-top-center,
            .admin-bar .hk-push-prompt.hk-push-pos-top-right {
                top: 66px;
            }
        }
        @media (max-width: 600px) {
            .admin-bar .hk-push-prompt.hk-push-pos-top-left,
            .admin-bar .hk-push-prompt.hk-push-pos-top-center,
            .admin-bar .hk-push-prompt.hk-push-pos-top-right {
                top: 16px;
            }
        }

        /* Status Aktif / Tampil */
        .hk-push-prompt.is-visible {
            opacity: 1;
        }
        .hk-push-prompt.hk-push-pos-top-left.is-visible,
        .hk-push-prompt.hk-push-pos-top-right.is-visible,
        .hk-push-prompt.hk-push-pos-bottom-left.is-visible,
        .hk-push-prompt.hk-push-pos-bottom-right.is-visible {
            transform: translateY(0);
        }
        .hk-push-prompt.hk-push-pos-top-center.is-visible {
            transform: translate(-50%, 0);
        }

        /* Status Menghilang */
        .hk-push-prompt.is-hiding {
            opacity: 0;
            pointer-events: none;
        }
        .hk-push-prompt.hk-push-pos-top-left.is-hiding,
        .hk-push-prompt.hk-push-pos-top-right.is-hiding {
            transform: translateY(-16px);
        }
        .hk-push-prompt.hk-push-pos-top-center.is-hiding {
            transform: translate(-50%, -16px);
        }
        .hk-push-prompt.hk-push-pos-bottom-left.is-hiding,
        .hk-push-prompt.hk-push-pos-bottom-right.is-hiding {
            transform: translateY(16px);
        }

        /* Desain Kartu (Identik dengan Antaranews) */
        .hk-push-prompt-card {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 10px 25px -4px rgba(0, 0, 0, 0.14), 0 4px 10px -2px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.06);
            padding: 16px 20px 14px 20px;
            box-sizing: border-box;
        }

        .hk-push-prompt-body {
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .hk-push-prompt-icon-wrap {
            width: 48px;
            height: 48px;
            min-width: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(229, 57, 53, 0.28);
        }

        .hk-push-bell-svg {
            width: 25px;
            height: 25px;
            display: block;
        }

        .hk-push-custom-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            display: block;
        }

        .hk-push-prompt-content {
            flex: 1;
            min-width: 0;
            padding-top: 2px;
        }

        .hk-push-prompt-text {
            margin: 0;
            font-size: 13.5px;
            line-height: 1.48;
            color: #334155;
            font-weight: 500;
            word-break: break-word;
        }

        .hk-push-prompt-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 12px;
        }

        .hk-push-btn {
            font-family: inherit;
            cursor: pointer;
            border: none;
            outline: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            transition: background 0.15s ease, opacity 0.15s ease, transform 0.15s ease, box-shadow 0.15s ease;
            text-decoration: none;
        }

        /* Tombol Batal / Terima Kasih */
        .hk-push-btn-cancel {
            background: transparent;
            font-size: 13px;
            font-weight: 600;
            padding: 7px 12px;
            border-radius: 5px;
            line-height: 1.4;
        }
        .hk-push-btn-cancel:hover {
            background: rgba(200, 30, 30, 0.08);
            opacity: 0.92;
        }
        .hk-push-btn-cancel:focus-visible {
            outline: 2px solid currentColor;
            outline-offset: 2px;
        }

        /* Tombol Utama (Oke) */
        .hk-push-btn-ok {
            font-size: 13px;
            font-weight: 700;
            padding: 7px 22px;
            border-radius: 5px;
            line-height: 1.4;
            box-shadow: 0 2px 6px rgba(200, 30, 30, 0.28);
        }
        .hk-push-btn-ok:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(200, 30, 30, 0.38);
            filter: brightness(0.94);
        }
        .hk-push-btn-ok:active {
            transform: translateY(0);
        }
        .hk-push-btn-ok:focus-visible {
            outline: 2px solid #0284c7;
            outline-offset: 2px;
        }

        /* Dukungan Mode Gelap HakaJobs */
        body.hk-dark-mode .hk-push-prompt-card,
        [data-theme="dark"] .hk-push-prompt-card {
            background: #1e293b;
            border-color: #334155;
            box-shadow: 0 12px 30px -4px rgba(0, 0, 0, 0.45);
        }
        body.hk-dark-mode .hk-push-prompt-text,
        [data-theme="dark"] .hk-push-prompt-text {
            color: #f1f5f9;
        }

        /* Tampilan Responsif Ponsel */
        @media (max-width: 540px) {
            .hk-push-prompt {
                left: 12px !important;
                right: 12px !important;
                max-width: calc(100% - 24px) !important;
                width: auto !important;
                transform: none !important;
            }
            .hk-push-prompt.hk-push-pos-top-left,
            .hk-push-prompt.hk-push-pos-top-center,
            .hk-push-prompt.hk-push-pos-top-right {
                top: 14px !important;
            }
            .hk-push-prompt.hk-push-pos-bottom-left,
            .hk-push-prompt.hk-push-pos-bottom-right {
                bottom: 14px !important;
            }
            .hk-push-prompt-card {
                padding: 14px 16px 12px 16px;
            }
            .hk-push-prompt-icon-wrap {
                width: 44px;
                height: 44px;
                min-width: 44px;
            }
            .hk-push-bell-svg {
                width: 22px;
                height: 22px;
            }
            .hk-push-prompt-text {
                font-size: 13px;
            }
            /* Target sentuhan standar minimum 44px di mobile */
            .hk-push-btn {
                min-height: 44px;
                padding-left: 16px;
                padding-right: 16px;
            }
        }
    </style>

    <script id="hk-push-prompt-inline-js">
        (function() {
            var STORAGE_KEY = 'hk_push_prompt_state';
            var DELAY_MS = <?php echo intval($delay * 1000); ?>;
            var DISMISS_DAYS = <?php echo intval($frequency); ?>;
            var ACCEPT_DAYS = <?php echo intval($acc_frequency); ?>;
            var ACTION_TYPE = '<?php echo esc_js($action_type); ?>';
            var TARGET_URL = '<?php echo esc_url($btn_ok_url); ?>';
            var URL_TARGET = '<?php echo esc_js($btn_ok_target); ?>';

            function getSavedState() {
                try {
                    var data = localStorage.getItem(STORAGE_KEY);
                    if (!data) return null;
                    return JSON.parse(data);
                } catch (e) {
                    return null;
                }
            }

            function saveState(status, days) {
                try {
                    var expireTime = Date.now() + (days * 24 * 60 * 60 * 1000);
                    var payload = {
                        status: status,
                        expires: expireTime
                    };
                    localStorage.setItem(STORAGE_KEY, JSON.stringify(payload));
                    // Cookie fallback
                    var date = new Date(expireTime);
                    document.cookie = STORAGE_KEY + '=' + status + '; expires=' + date.toUTCString() + '; path=/; SameSite=Lax';
                } catch (e) {}
            }

            function shouldShow() {
                var state = getSavedState();
                if (!state) return true;
                if (!state.expires || Date.now() > state.expires) {
                    try {
                        localStorage.removeItem(STORAGE_KEY);
                    } catch (e) {}
                    return true;
                }
                return false;
            }

            function showPrompt() {
                var el = document.getElementById('hk-push-prompt');
                if (!el) return;
                el.style.display = 'block';
                el.setAttribute('aria-hidden', 'false');
                // Trigger reflow for smooth CSS animation
                void el.offsetWidth;
                el.classList.add('is-visible');
            }

            function hidePrompt() {
                var el = document.getElementById('hk-push-prompt');
                if (!el) return;
                el.classList.remove('is-visible');
                el.classList.add('is-hiding');
                el.setAttribute('aria-hidden', 'true');
                setTimeout(function() {
                    el.style.display = 'none';
                    el.classList.remove('is-hiding');
                }, 320);
            }

            function requestBrowserPermission() {
                if ('Notification' in window) {
                    if (Notification.permission === 'default') {
                        Notification.requestPermission().then(function(perm) {
                            if (perm === 'granted') {
                                try {
                                    new Notification('<?php echo esc_js($site_name); ?>', {
                                        body: '<?php echo esc_js(__('Notifikasi berhasil diaktifkan. Terima kasih!', 'hakajobs')); ?>',
                                        icon: '<?php echo esc_url($custom_icon ? $custom_icon : get_site_icon_url(96)); ?>'
                                    });
                                } catch (err) {}
                            }
                        });
                    }
                }
            }

            function initPushPrompt() {
                if (!shouldShow()) {
                    return;
                }

                // Tampilkan setelah jeda waktu yang dikonfigurasi
                setTimeout(showPrompt, DELAY_MS);

                var btnCancel = document.getElementById('hk-push-btn-cancel');
                var btnOk = document.getElementById('hk-push-btn-ok');

                if (btnCancel) {
                    btnCancel.addEventListener('click', function(e) {
                        e.preventDefault();
                        saveState('dismissed', DISMISS_DAYS);
                        hidePrompt();
                    });
                }

                if (btnOk) {
                    btnOk.addEventListener('click', function(e) {
                        e.preventDefault();
                        saveState('accepted', ACCEPT_DAYS);

                        // Eksekusi aksi sesuai pengaturan WP
                        if (ACTION_TYPE === 'push_only') {
                            requestBrowserPermission();
                        } else if (ACTION_TYPE === 'link_only') {
                            if (TARGET_URL) {
                                window.open(TARGET_URL, URL_TARGET);
                            }
                        } else if (ACTION_TYPE === 'push_and_link') {
                            requestBrowserPermission();
                            if (TARGET_URL) {
                                setTimeout(function() {
                                    window.open(TARGET_URL, URL_TARGET);
                                }, 300);
                            }
                        }

                        hidePrompt();
                    });
                }

                // Tutup saat pengguna menekan tombol Escape di keyboard
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' || e.keyCode === 27) {
                        var el = document.getElementById('hk-push-prompt');
                        if (el && el.classList.contains('is-visible')) {
                            saveState('dismissed', DISMISS_DAYS);
                            hidePrompt();
                        }
                    }
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initPushPrompt);
            } else {
                initPushPrompt();
            }
        })();
    </script>
    <?php
}
add_action('wp_footer', 'hakajobs_render_push_notification', 99);
