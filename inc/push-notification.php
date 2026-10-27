<?php
/**
 * Push Notification Module for Hakajobs
 *
 * Provides Antaranews-style prompt card on the frontend and full Web Push (OneSignal)
 * automation to deliver instant push notifications to user smartphones (Android & iOS)
 * whenever a new Job Vacancy (Lowongan) or Article (Post) is published or updated.
 *
 * @package Hakajobs
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Register Theme Customizer Section & Controls for Push Notification
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function hakajobs_push_notification_customize_register($wp_customize) {
    // =========================================================================
    // SECTION: NOTIFIKASI WEB PUSH & POP-UP (HP & DESKTOP)
    // =========================================================================
    $wp_customize->add_section('hakajobs_push_notice_section', array(
        'title'       => __('🔔 Notifikasi Web Push & Pop-up (HP)', 'hakajobs'),
        'description' => __('Atur tampilan pop-up notifikasi (gaya Antaranews) dan integrasi Web Push OneSignal agar setiap artikel atau lowongan kerja baru langsung terkirim otomatis ke layar handphone pengunjung (Android & iOS).', 'hakajobs'),
        'panel'       => 'hakajobs_theme_options',
        'priority'    => 76,
    ));

    // -------------------------------------------------------------------------
    // BAGIAN 1: STATUS & POP-UP PROMPT
    // -------------------------------------------------------------------------

    // 1. Aktifkan Fitur Pop-up
    $wp_customize->add_setting('hakajobs_push_enable', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_enable', array(
        'type'        => 'checkbox',
        'label'       => __('Aktifkan Pop-up & Fitur Notifikasi', 'hakajobs'),
        'description' => __('Tampilkan kartu ajakan notifikasi saat pengunjung membuka website.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 2. Mode / Aksi Tombol Utama (Oke)
    $wp_customize->add_setting('hakajobs_push_action_type', array(
        'default'           => 'onesignal',
        'sanitize_callback' => 'hakajobs_sanitize_select',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_action_type', array(
        'type'        => 'select',
        'label'       => __('Metode Pengiriman Notifikasi', 'hakajobs'),
        'description' => __('Pilih bagaimana notifikasi disalurkan ke pengguna saat mereka menekan tombol "Oke".', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
        'choices'     => array(
            'onesignal'     => __('Web Push ke Smartphone via OneSignal (Rekomendasi Utama)', 'hakajobs'),
            'push_and_link' => __('Web Push OneSignal + Buka Saluran (WhatsApp / Telegram)', 'hakajobs'),
            'link_only'     => __('Hanya Buka Saluran Broadcast (WhatsApp / Telegram)', 'hakajobs'),
            'dismiss_only'  => __('Hanya Tutup Pop-up & Tandai Disetujui', 'hakajobs'),
        ),
    ));

    // -------------------------------------------------------------------------
    // BAGIAN 2: KONFIGURASI ONESIGNAL (PUSH KE SMARTPHONE USER)
    // -------------------------------------------------------------------------

    // 3. OneSignal App ID
    $wp_customize->add_setting('hakajobs_onesignal_app_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_onesignal_app_id', array(
        'type'        => 'text',
        'label'       => __('OneSignal App ID', 'hakajobs'),
        'description' => __('Dapatkan gratis di https://onesignal.com (Free tier s/d 10.000 subscriber). Contoh: 12345678-abcd-1234-abcd-1234567890ab', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 4. OneSignal REST API Key
    $wp_customize->add_setting('hakajobs_onesignal_api_key', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_onesignal_api_key', array(
        'type'        => 'text',
        'label'       => __('OneSignal REST API Key', 'hakajobs'),
        'description' => __('Kunci API dari OneSignal Dashboard > Settings > Keys & IDs. Diperlukan agar WordPress dapat mengirim notifikasi otomatis saat loker/artikel baru terbit.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 5. OneSignal Safari Web ID (Opsional)
    $wp_customize->add_setting('hakajobs_onesignal_safari_web_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_onesignal_safari_web_id', array(
        'type'        => 'text',
        'label'       => __('OneSignal Safari Web ID (Opsional)', 'hakajobs'),
        'description' => __('Diperlukan khusus pengguna Safari Desktop versi lama (contoh: web.onesignal.auto.xxxxxx). iOS 16.4+ sudah mendukung web push otomatis.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // -------------------------------------------------------------------------
    // BAGIAN 3: PENGIRIMAN OTOMATIS SAAT UPDATE LOKER & ARTIKEL
    // -------------------------------------------------------------------------

    // 6. Otomatis Kirim saat Lowongan Baru Diterbitkan
    $wp_customize->add_setting('hakajobs_push_notify_lowongan', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_notify_lowongan', array(
        'type'        => 'checkbox',
        'label'       => __('Kirim Notifikasi Otomatis: Lowongan Baru', 'hakajobs'),
        'description' => __('Kirim pemberitahuan otomatis ke smartphone pengguna setiap kali lowongan kerja baru dipublikasikan.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 7. Otomatis Kirim saat Artikel / Berita Baru Diterbitkan
    $wp_customize->add_setting('hakajobs_push_notify_articles', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_notify_articles', array(
        'type'        => 'checkbox',
        'label'       => __('Kirim Notifikasi Otomatis: Artikel / Tips Karir Baru', 'hakajobs'),
        'description' => __('Kirim pemberitahuan otomatis ke smartphone pengguna setiap kali ada artikel atau berita baru dipublikasikan.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 8. Kirim Saat Loker / Artikel Diperbarui (Update)
    $wp_customize->add_setting('hakajobs_push_notify_on_update', array(
        'default'           => '0',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_notify_on_update', array(
        'type'        => 'checkbox',
        'label'       => __('Kirim Notifikasi Saat Artikel/Loker Diupdate', 'hakajobs'),
        'description' => __('Jika diaktifkan, setiap kali artikel/loker yang sudah terbit diperbarui, notifikasi juga akan dikirim ulang. Anda juga bisa mengatur ini secara spesifik per-artikel di layar edit.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 9. Format Judul Notifikasi Lowongan
    $wp_customize->add_setting('hakajobs_push_title_lowongan', array(
        'default'           => __('[Loker Baru] {title}', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_title_lowongan', array(
        'type'        => 'text',
        'label'       => __('Format Judul Notifikasi Lowongan', 'hakajobs'),
        'description' => __('Gunakan tag {title} untuk judul pekerjaan, {company} untuk perusahaan, {site_name} untuk nama situs.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 10. Format Judul Notifikasi Artikel
    $wp_customize->add_setting('hakajobs_push_title_post', array(
        'default'           => __('{title}', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_title_post', array(
        'type'        => 'text',
        'label'       => __('Format Judul Notifikasi Artikel', 'hakajobs'),
        'description' => __('Gunakan tag {title} untuk judul artikel, {site_name} untuk nama website.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 11. Sertakan Gambar Unggulan (Featured Image) di Handphone
    $wp_customize->add_setting('hakajobs_push_rich_image', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_rich_image', array(
        'type'        => 'checkbox',
        'label'       => __('Tampilkan Banner Gambar Unggulan di Smartphone', 'hakajobs'),
        'description' => __('Menampilkan gambar artikel/loker ukuran besar di tray notifikasi Android dan lockscreen.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // -------------------------------------------------------------------------
    // BAGIAN 4: DESAIN & TAMPILAN POP-UP (ANTARANEWS STYLE)
    // -------------------------------------------------------------------------

    // 12. Posisi Tampil di Layar
    $wp_customize->add_setting('hakajobs_push_pos', array(
        'default'           => 'top-left',
        'sanitize_callback' => 'hakajobs_sanitize_select',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_pos', array(
        'type'        => 'select',
        'label'       => __('Posisi Tampil di Layar', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
        'choices'     => array(
            'top-left'     => __('Atas Kiri (Bawaan - Seperti Antaranews)', 'hakajobs'),
            'top-center'   => __('Atas Tengah', 'hakajobs'),
            'top-right'    => __('Atas Kanan', 'hakajobs'),
            'bottom-left'  => __('Bawah Kiri', 'hakajobs'),
            'bottom-right' => __('Bawah Kanan', 'hakajobs'),
        ),
    ));

    // 13. Tampilkan Pada Halaman
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

    // 14. Teks Pesan Notifikasi Pop-up
    $default_text = sprintf(
        /* translators: %s: site name */
        __('Dapatkan Berita & Info Lowongan Kerja Terkini khusus untuk anda dengan mengaktifkan notifikasi %s', 'hakajobs'),
        get_bloginfo('name')
    );
    $wp_customize->add_setting('hakajobs_push_text', array(
        'default'           => $default_text,
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_text', array(
        'type'        => 'textarea',
        'label'       => __('Teks Pesan Pop-up', 'hakajobs'),
        'description' => __('Gunakan kode [site_name] untuk menyisipkan nama website secara dinamis.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 15. Jenis Ikon
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

    // 16. Unggah Ikon Kustom
    $wp_customize->add_setting('hakajobs_push_custom_icon', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hakajobs_push_custom_icon', array(
        'label'       => __('Unggah Ikon / Logo Kustom', 'hakajobs'),
        'description' => __('Disarankan gambar persegi rasio 1:1 (contoh: 192x192 px PNG).', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    )));

    // 17. Warna Lingkaran Ikon
    $wp_customize->add_setting('hakajobs_push_icon_bg', array(
        'default'           => '#e53935',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_push_icon_bg', array(
        'label'       => __('Warna Latar Belakang Ikon', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    )));

    // 18. Warna Ikon Lonceng
    $wp_customize->add_setting('hakajobs_push_icon_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_push_icon_color', array(
        'label'       => __('Warna Ikon Lonceng', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    )));

    // 19. Teks Tombol Utama
    $wp_customize->add_setting('hakajobs_push_btn_ok_text', array(
        'default'           => 'Oke',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_btn_ok_text', array(
        'type'        => 'text',
        'label'       => __('Teks Tombol Utama (Setuju)', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 20. URL Saluran Broadcast Tambahan (WhatsApp / Telegram)
    $wp_customize->add_setting('hakajobs_push_btn_ok_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_btn_ok_url', array(
        'type'        => 'url',
        'label'       => __('URL Saluran WhatsApp / Telegram (Opsional)', 'hakajobs'),
        'description' => __('Masukkan link Saluran WhatsApp atau Telegram jika memilih metode push + link saluran.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 21. Target Buka Tautan
    $wp_customize->add_setting('hakajobs_push_btn_ok_target', array(
        'default'           => '_blank',
        'sanitize_callback' => 'hakajobs_sanitize_select',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_btn_ok_target', array(
        'type'        => 'select',
        'label'       => __('Target Buka Tautan Saluran', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
        'choices'     => array(
            '_blank' => __('Buka di Tab Baru (_blank)', 'hakajobs'),
            '_self'  => __('Buka di Tab yang Sama (_self)', 'hakajobs'),
        ),
    ));

    // 22. Warna Tombol Utama (Background)
    $wp_customize->add_setting('hakajobs_push_btn_ok_bg', array(
        'default'           => '#c81e1e',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_push_btn_ok_bg', array(
        'label'       => __('Warna Latar Tombol Utama', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    )));

    // 23. Warna Teks Tombol Utama
    $wp_customize->add_setting('hakajobs_push_btn_ok_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_push_btn_ok_color', array(
        'label'       => __('Warna Teks Tombol Utama', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    )));

    // 24. Teks Tombol Tolak / Tutup
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

    // 25. Warna Teks Tombol Tolak
    $wp_customize->add_setting('hakajobs_push_btn_cancel_color', array(
        'default'           => '#c81e1e',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_push_btn_cancel_color', array(
        'label'       => __('Warna Teks Tombol Tolak', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    )));

    // 26. Jeda Waktu Muncul (Detik)
    $wp_customize->add_setting('hakajobs_push_delay', array(
        'default'           => 1,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_delay', array(
        'type'        => 'number',
        'label'       => __('Jeda Tampil Pop-up (Detik)', 'hakajobs'),
        'description' => __('Waktu tunggu setelah halaman termuat sebelum kartu muncul.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 60,
            'step' => 1,
        ),
    ));

    // 27. Durasi Ingat Jika Ditolak (Hari)
    $wp_customize->add_setting('hakajobs_push_frequency', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_frequency', array(
        'type'        => 'number',
        'label'       => __('Jangka Waktu Tidak Tampil Jika Ditolak (Hari)', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 365,
            'step' => 1,
        ),
    ));

    // 28. Durasi Ingat Jika Diterima (Hari)
    $wp_customize->add_setting('hakajobs_push_accepted_frequency', array(
        'default'           => 30,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_accepted_frequency', array(
        'type'        => 'number',
        'label'       => __('Jangka Waktu Tidak Tampil Jika Disetujui (Hari)', 'hakajobs'),
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
 * 2. Serve Dynamic OneSignal Service Worker Endpoint
 */
function hakajobs_push_sw_endpoint() {
    if (isset($_GET['hakajobs_onesignal_sw']) || (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'OneSignalSDKWorker.js') !== false)) {
        header('Content-Type: application/javascript; charset=utf-8');
        header('Service-Worker-Allowed: /');
        header('Cache-Control: public, max-age=3600');
        echo "/* OneSignal Service Worker via Hakajobs */\n";
        echo 'importScripts("https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.sw.js");';
        exit;
    }
}
add_action('init', 'hakajobs_push_sw_endpoint', 1);

/**
 * 3. Core Sender: Send Web Push Notification via OneSignal REST API
 *
 * @param array $args Notification payload arguments.
 * @return array Result containing success bool, recipient count, id, or error.
 */
function hakajobs_send_push_notification($args = array()) {
    $app_id  = trim(get_theme_mod('hakajobs_onesignal_app_id', ''));
    $api_key = trim(get_theme_mod('hakajobs_onesignal_api_key', ''));

    if (empty($app_id) || empty($api_key)) {
        return array(
            'success' => false,
            'error'   => __('OneSignal App ID atau REST API Key belum diatur di Pengaturan Notifikasi.', 'hakajobs'),
        );
    }

    $title   = !empty($args['title']) ? sanitize_text_field($args['title']) : get_bloginfo('name');
    $message = !empty($args['message']) ? sanitize_text_field($args['message']) : __('Info lowongan dan artikel terbaru dari ', 'hakajobs') . get_bloginfo('name');
    $url     = !empty($args['url']) ? esc_url_raw($args['url']) : home_url('/');
    $icon    = !empty($args['icon']) ? esc_url_raw($args['icon']) : get_site_icon_url(192);
    $image   = !empty($args['image']) ? esc_url_raw($args['image']) : '';

    if (empty($icon)) {
        $custom_icon = get_theme_mod('hakajobs_push_custom_icon', '');
        $icon = !empty($custom_icon) ? esc_url_raw($custom_icon) : HAKAJOBS_URI . '/screenshot.png';
    }

    $payload = array(
        'app_id'            => $app_id,
        'included_segments' => array('Subscribed Users', 'Total Subscriptions'),
        'headings'          => array('en' => $title, 'id' => $title),
        'contents'          => array('en' => $message, 'id' => $message),
        'url'               => $url,
        'chrome_web_icon'   => $icon,
        'firefox_icon'      => $icon,
    );

    if (!empty($image)) {
        $payload['big_picture']      = $image;
        $payload['chrome_web_image'] = $image;
    }

    $response = wp_remote_post('https://onesignal.com/api/v1/notifications', array(
        'method'      => 'POST',
        'timeout'     => 12,
        'redirection' => 5,
        'httpversion' => '1.1',
        'blocking'    => true,
        'headers'     => array(
            'Content-Type'  => 'application/json; charset=utf-8',
            'Authorization' => 'Basic ' . $api_key,
        ),
        'body'        => wp_json_encode($payload),
    ));

    if (is_wp_error($response)) {
        $err = $response->get_error_message();
        update_option('hakajobs_last_push_log', array(
            'time'    => current_time('mysql'),
            'status'  => 'error',
            'message' => $err,
            'title'   => $title,
        ));
        return array('success' => false, 'error' => $err);
    }

    $code = wp_remote_retrieve_response_code($response);
    $body = json_decode(wp_remote_retrieve_body($response), true);

    if ($code === 200 && !empty($body['id'])) {
        $recipients = isset($body['recipients']) ? intval($body['recipients']) : 0;
        update_option('hakajobs_last_push_log', array(
            'time'       => current_time('mysql'),
            'status'     => 'success',
            'id'         => $body['id'],
            'recipients' => $recipients,
            'title'      => $title,
        ));
        return array(
            'success'    => true,
            'id'         => $body['id'],
            'recipients' => $recipients,
        );
    }

    $error_msg = __('Gagal mengirim notifikasi.', 'hakajobs');
    if (!empty($body['errors'])) {
        if (is_array($body['errors'])) {
            $error_msg = implode(', ', $body['errors']);
        } else {
            $error_msg = strval($body['errors']);
        }
    }

    update_option('hakajobs_last_push_log', array(
        'time'    => current_time('mysql'),
        'status'  => 'error',
        'code'    => $code,
        'message' => $error_msg,
        'title'   => $title,
    ));

    return array('success' => false, 'error' => $error_msg);
}

/**
 * 4. Automatic Trigger When a Lowongan or Article is Published / Updated
 *
 * @param string  $new_status New post status.
 * @param string  $old_status Old post status.
 * @param WP_Post $post       Post object.
 */
function hakajobs_handle_push_on_publish($new_status, $old_status, $post) {
    if (!is_object($post) || !isset($post->ID)) {
        return;
    }

    // Hindari autosave dan revisi
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (wp_is_post_revision($post->ID) || wp_is_post_autosave($post->ID)) {
        return;
    }

    // Hanya kirim saat status akhir adalah 'publish'
    if ($new_status !== 'publish') {
        return;
    }

    $post_type = $post->post_type;
    if ($post_type !== 'lowongan' && $post_type !== 'post') {
        return;
    }

    // Cek apakah OneSignal diaktifkan
    $app_id = trim(get_theme_mod('hakajobs_onesignal_app_id', ''));
    if (empty($app_id)) {
        return;
    }

    // Cegah duplikasi pengiriman dalam satu siklus request PHP
    static $sent_posts = array();
    if (isset($sent_posts[$post->ID])) {
        return;
    }

    $is_new_publish = ($old_status !== 'publish');
    $is_update      = ($old_status === 'publish');

    // Cek override per-post dari Meta Box (jika admin secara manual mengubah centang)
    $manual_override = isset($_POST['hakajobs_send_push_notification']) ? sanitize_text_field($_POST['hakajobs_send_push_notification']) : '';

    if ($manual_override === '0') {
        // Admin sengaja membatalkan pengiriman untuk post ini
        return;
    }

    if ($is_new_publish) {
        // Cek setting tema untuk terbitan baru
        if ($post_type === 'lowongan') {
            $enabled = get_theme_mod('hakajobs_push_notify_lowongan', '1');
        } else {
            $enabled = get_theme_mod('hakajobs_push_notify_articles', '1');
        }
        if ($enabled !== '1' && $manual_override !== '1') {
            return;
        }
    } elseif ($is_update) {
        // Cek setting tema untuk update artikel/loker lama
        $update_enabled = get_theme_mod('hakajobs_push_notify_on_update', '0');
        if ($update_enabled !== '1' && $manual_override !== '1') {
            return;
        }
    }

    $site_name = get_bloginfo('name');

    // Buat Judul Notifikasi
    if ($post_type === 'lowongan') {
        $title_template = get_theme_mod('hakajobs_push_title_lowongan', __('[Loker Baru] {title}', 'hakajobs'));
        $company_name   = get_post_meta($post->ID, '_hakajobs_company_name', true);
        $location       = get_post_meta($post->ID, '_hakajobs_company_location', true);
        $salary         = get_post_meta($post->ID, '_hakajobs_salary', true);
        $salary_period  = get_post_meta($post->ID, '_hakajobs_salary_period', true);

        $notification_title = str_replace(
            array('{title}', '{company}', '{site_name}'),
            array($post->post_title, $company_name ?: $site_name, $site_name),
            $title_template
        );

        // Buat Pesan Notifikasi Loker
        $msg_parts = array();
        if (!empty($company_name)) {
            $msg_parts[] = $company_name;
        }
        if (!empty($location)) {
            $msg_parts[] = '(' . wp_trim_words($location, 4, '') . ')';
        }
        if (!empty($salary)) {
            $msg_parts[] = '• Gaji: ' . $salary . (!empty($salary_period) ? '/' . $salary_period : '');
        }

        if (!empty($msg_parts)) {
            $notification_body = implode(' ', $msg_parts) . '. Klik untuk cek kualifikasi & melamar!';
        } else {
            $notification_body = wp_strip_all_tags($post->post_excerpt ?: wp_trim_words($post->post_content, 18, '...'));
            if (empty($notification_body)) {
                $notification_body = sprintf(__('Lowongan kerja baru telah dibuka di %s. Buka sekarang untuk melamar!', 'hakajobs'), $site_name);
            }
        }
    } else {
        $title_template = get_theme_mod('hakajobs_push_title_post', __('{title}', 'hakajobs'));
        $notification_title = str_replace(
            array('{title}', '{site_name}'),
            array($post->post_title, $site_name),
            $title_template
        );

        $notification_body = wp_strip_all_tags($post->post_excerpt ?: wp_trim_words($post->post_content, 20, '...'));
        if (empty($notification_body)) {
            $notification_body = sprintf(__('Artikel & tips karir baru telah terbit di %s. Baca selengkapnya!', 'hakajobs'), $site_name);
        }
    }

    // Override custom title / message jika diisi di meta box
    if (!empty($_POST['hakajobs_push_custom_title'])) {
        $notification_title = sanitize_text_field($_POST['hakajobs_push_custom_title']);
    }
    if (!empty($_POST['hakajobs_push_custom_message'])) {
        $notification_body = sanitize_text_field($_POST['hakajobs_push_custom_message']);
    }

    // Gambar Unggulan (Featured Image) untuk Rich Notification di Handphone
    $image_url = '';
    $rich_image_enabled = get_theme_mod('hakajobs_push_rich_image', '1');
    if ($rich_image_enabled === '1' && has_post_thumbnail($post->ID)) {
        $image_url = get_the_post_thumbnail_url($post->ID, 'large');
    }

    $custom_icon = get_theme_mod('hakajobs_push_custom_icon', '');
    $icon_url    = !empty($custom_icon) ? $custom_icon : get_site_icon_url(192);

    // Tandai sudah diproses agar tidak kirim dobel
    $sent_posts[$post->ID] = true;

    // Kirim notifikasi
    $result = hakajobs_send_push_notification(array(
        'title'   => $notification_title,
        'message' => $notification_body,
        'url'     => get_permalink($post->ID),
        'image'   => $image_url,
        'icon'    => $icon_url,
    ));

    // Simpan status pengiriman di post meta
    if (!empty($result['success'])) {
        update_post_meta($post->ID, '_hakajobs_push_last_sent', current_time('mysql'));
        update_post_meta($post->ID, '_hakajobs_push_notification_id', $result['id']);
        update_post_meta($post->ID, '_hakajobs_push_recipients', $result['recipients']);
        update_post_meta($post->ID, '_hakajobs_push_status', 'success');
    } else {
        update_post_meta($post->ID, '_hakajobs_push_last_error', isset($result['error']) ? $result['error'] : 'Unknown error');
        update_post_meta($post->ID, '_hakajobs_push_status', 'failed');
    }
}
add_action('transition_post_status', 'hakajobs_handle_push_on_publish', 10, 3);

/**
 * 5. Meta Box for Post & Lowongan Edit Screen
 */
function hakajobs_register_push_meta_box() {
    $screens = array('lowongan', 'post');
    foreach ($screens as $screen) {
        add_meta_box(
            'hakajobs_push_notification_mb',
            __('🔔 Notifikasi Handphone Pengunjung', 'hakajobs'),
            'hakajobs_render_push_meta_box',
            $screen,
            'side',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'hakajobs_register_push_meta_box');

/**
 * Render Meta Box Content in Post & Lowongan Editor
 */
function hakajobs_render_push_meta_box($post) {
    wp_nonce_field('hakajobs_push_meta_nonce_action', 'hakajobs_push_meta_nonce');

    $app_id       = trim(get_theme_mod('hakajobs_onesignal_app_id', ''));
    $last_sent    = get_post_meta($post->ID, '_hakajobs_push_last_sent', true);
    $recipients   = get_post_meta($post->ID, '_hakajobs_push_recipients', true);
    $last_error   = get_post_meta($post->ID, '_hakajobs_push_last_error', true);
    $is_published = ($post->post_status === 'publish');

    // Default centang: Aktif untuk draf/loker baru, tidak aktif jika hanya edit teks artikel lama
    $default_checked = $is_published ? false : true;
    ?>
    <div class="hk-push-mb-wrap" style="font-size: 13px; color: #334155;">
        <?php if (empty($app_id)): ?>
            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 10px; border-radius: 6px; margin-bottom: 12px; font-size: 12px; line-height: 1.4;">
                ⚠️ <strong>OneSignal Belum Terhubung</strong><br>
                Masukkan App ID & REST API Key di <strong>Tampilan > Sesuaikan > 🔔 Notifikasi Web Push</strong> agar pemberitahuan otomatis masuk ke smartphone pengunjung.
            </div>
        <?php else: ?>
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 8px 10px; border-radius: 6px; margin-bottom: 12px; font-size: 12px; display: flex; align-items: center; gap: 6px;">
                <span>🟢</span>
                <span><strong>OneSignal Siap:</strong> Notifikasi aktif ke smartphone.</span>
            </div>
        <?php endif; ?>

        <p style="margin: 0 0 10px 0;">
            <label style="display: flex; align-items: flex-start; gap: 8px; font-weight: 600; cursor: pointer;">
                <input type="checkbox" 
                       name="hakajobs_send_push_notification" 
                       value="1" 
                       <?php checked($default_checked, true); ?> 
                       style="margin-top: 2px;" />
                <span><?php _e('Kirim Notifikasi Push ke Handphone Pengunjung saat diterbitkan/disimpan', 'hakajobs'); ?></span>
            </label>
        </p>

        <?php if (!empty($last_sent)): ?>
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 8px 10px; border-radius: 6px; margin-top: 10px; font-size: 11.5px; color: #64748b;">
                <strong style="color: #0f172a;">Terakhir Terkirim:</strong><br>
                📅 <?php echo esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($last_sent))); ?>
                <?php if ($recipients !== ''): ?>
                    <br>👥 Diterima oleh: <strong><?php echo intval($recipients); ?></strong> perangkat
                <?php endif; ?>
            </div>
        <?php elseif (!empty($last_error)): ?>
            <div style="background: #fff1f2; border: 1px solid #fecdd3; padding: 8px 10px; border-radius: 6px; margin-top: 10px; font-size: 11.5px; color: #e11d48;">
                <strong>Gagal Mengirim:</strong><br>
                <?php echo esc_html($last_error); ?>
            </div>
        <?php endif; ?>

        <details style="margin-top: 12px; font-size: 12px;">
            <summary style="cursor: pointer; color: #0284c7; font-weight: 600;"><?php _e('Kustomisasi Teks Notifikasi (Opsional)', 'hakajobs'); ?></summary>
            <div style="margin-top: 8px;">
                <label style="display:block; margin-bottom:4px; font-weight:600;"><?php _e('Judul Khusus:', 'hakajobs'); ?></label>
                <input type="text" name="hakajobs_push_custom_title" value="" placeholder="<?php _e('Kosongkan untuk otomatis', 'hakajobs'); ?>" style="width:100%; margin-bottom:8px; font-size:12px;" />
                
                <label style="display:block; margin-bottom:4px; font-weight:600;"><?php _e('Pesan Khusus:', 'hakajobs'); ?></label>
                <textarea name="hakajobs_push_custom_message" rows="2" placeholder="<?php _e('Kosongkan untuk ringkasan otomatis', 'hakajobs'); ?>" style="width:100%; font-size:12px;"></textarea>
            </div>
        </details>
    </div>
    <?php
}

/**
 * 6. Admin Notice: Prompt to fill OneSignal Keys if enabled but missing
 */
function hakajobs_push_admin_notice() {
    $push_enabled = get_theme_mod('hakajobs_push_enable', '1');
    $app_id       = trim(get_theme_mod('hakajobs_onesignal_app_id', ''));

    if ($push_enabled === '1' && empty($app_id) && current_user_can('manage_options')) {
        $customizer_url = admin_url('customize.php?autofocus[section]=hakajobs_push_notice_section');
        ?>
        <div class="notice notice-warning is-dismissible" style="border-left-color: #0284c7;">
            <p>
                <strong>🔔 Fitur Notifikasi HakaJobs Aktif:</strong>
                Agar pemberitahuan artikel & lowongan baru dapat terkirim otomatis ke layar handphone pengunjung, silakan masukkan <strong>OneSignal App ID & REST API Key</strong> Anda.
                <a href="<?php echo esc_url($customizer_url); ?>" class="button button-small button-primary" style="margin-left: 8px;">
                    <?php _e('Buka Pengaturan Notifikasi', 'hakajobs'); ?>
                </a>
            </p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'hakajobs_push_admin_notice');

/**
 * 7. AJAX Test Push Notification Endpoint for Admin
 */
function hakajobs_ajax_test_push() {
    check_ajax_referer('hakajobs_test_push_nonce', 'nonce');

    if (!current_user_can('manage_options')) {
        wp_send_json_error(array('message' => __('Akses ditolak.', 'hakajobs')));
    }

    $site_name = get_bloginfo('name');
    $result = hakajobs_send_push_notification(array(
        'title'   => sprintf(__('🔔 [Uji Coba] Notifikasi %s Berhasil!', 'hakajobs'), $site_name),
        'message' => __('Selamat! Fitur notifikasi handphone Anda telah aktif dan terhubung. Update artikel & lowongan kerja baru akan otomatis terkirim.', 'hakajobs'),
        'url'     => home_url('/'),
    ));

    if (!empty($result['success'])) {
        wp_send_json_success(array(
            'message'    => sprintf(__('Notifikasi uji coba berhasil dikirim! Diterima oleh %d perangkat.', 'hakajobs'), $result['recipients']),
            'recipients' => $result['recipients'],
        ));
    } else {
        wp_send_json_error(array(
            'message' => isset($result['error']) ? $result['error'] : __('Gagal mengirim notifikasi.', 'hakajobs'),
        ));
    }
}
add_action('wp_ajax_hakajobs_test_push', 'hakajobs_ajax_test_push');

/**
 * 8. Render Push Notification Prompt HTML, CSS, and JS in wp_footer
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
    $default_text     = sprintf(__('Dapatkan Berita & Info Lowongan Kerja Terkini khusus untuk anda dengan mengaktifkan notifikasi %s', 'hakajobs'), $site_name);
    $text_raw         = get_theme_mod('hakajobs_push_text', $default_text);
    $text             = str_replace('[site_name]', $site_name, $text_raw);

    $icon_type        = get_theme_mod('hakajobs_push_icon_type', 'bell');
    $custom_icon      = get_theme_mod('hakajobs_push_custom_icon', '');
    $icon_bg          = get_theme_mod('hakajobs_push_icon_bg', '#e53935');
    $icon_color       = get_theme_mod('hakajobs_push_icon_color', '#ffffff');

    $action_type      = get_theme_mod('hakajobs_push_action_type', 'onesignal');
    $onesignal_app_id = trim(get_theme_mod('hakajobs_onesignal_app_id', ''));
    $safari_web_id    = trim(get_theme_mod('hakajobs_onesignal_safari_web_id', ''));

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

        .hk-push-prompt.is-hiding {
            opacity: 0;
            pointer-events: none;
        }

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
            .hk-push-btn {
                min-height: 44px;
                padding-left: 16px;
                padding-right: 16px;
            }
        }
    </style>

    <?php if (!empty($onesignal_app_id) && ($action_type === 'onesignal' || $action_type === 'push_and_link')): ?>
        <!-- OneSignal Web SDK v16 for Mobile & Desktop Web Push -->
        <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
        <script>
            window.OneSignalDeferred = window.OneSignalDeferred || [];
            OneSignalDeferred.push(async function(OneSignal) {
                await OneSignal.init({
                    appId: "<?php echo esc_js($onesignal_app_id); ?>",
                    <?php if (!empty($safari_web_id)): ?>
                    safari_web_id: "<?php echo esc_js($safari_web_id); ?>",
                    <?php endif; ?>
                    notifyButton: {
                        enable: false // Use custom Antaranews prompt card
                    },
                    serviceWorkerParam: { scope: '/' },
                    serviceWorkerPath: 'OneSignalSDKWorker.js',
                    allowLocalhostAsSecureOrigin: true
                });
            });
        </script>
    <?php endif; ?>

    <script id="hk-push-prompt-inline-js">
        (function() {
            var STORAGE_KEY = 'hk_push_prompt_state';
            var DELAY_MS = <?php echo intval($delay * 1000); ?>;
            var DISMISS_DAYS = <?php echo intval($frequency); ?>;
            var ACCEPT_DAYS = <?php echo intval($acc_frequency); ?>;
            var ACTION_TYPE = '<?php echo esc_js($action_type); ?>';
            var TARGET_URL = '<?php echo esc_url($btn_ok_url); ?>';
            var URL_TARGET = '<?php echo esc_js($btn_ok_target); ?>';
            var ONESIGNAL_ACTIVE = <?php echo (!empty($onesignal_app_id)) ? 'true' : 'false'; ?>;

            // Bersihkan legacy service worker PWA jika pernah tersimpan di handphone pengunjung
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.getRegistrations().then(function(regs) {
                    regs.forEach(function(reg) {
                        if (reg.active && reg.active.scriptURL && reg.active.scriptURL.indexOf('hakajobs_sw') !== -1) {
                            reg.unregister();
                        }
                    });
                }).catch(function() {});
            }
            if ('caches' in window) {
                caches.keys().then(function(names) {
                    names.forEach(function(name) {
                        if (name.indexOf('hakajobs-pwa') !== -1) {
                            caches.delete(name);
                        }
                    });
                }).catch(function() {});
            }

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

            function requestOneSignalPermission() {
                if (ONESIGNAL_ACTIVE && window.OneSignalDeferred) {
                    window.OneSignalDeferred.push(async function(OneSignal) {
                        try {
                            await OneSignal.Notifications.requestPermission();
                        } catch (err) {
                            console.warn('[Push Notification] OneSignal request error:', err);
                        }
                    });
                } else if ('Notification' in window) {
                    if (Notification.permission === 'default') {
                        Notification.requestPermission();
                    }
                }
            }

            function initPushPrompt() {
                if (!shouldShow()) {
                    return;
                }

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

                        if (ACTION_TYPE === 'onesignal') {
                            requestOneSignalPermission();
                        } else if (ACTION_TYPE === 'link_only') {
                            if (TARGET_URL) {
                                window.open(TARGET_URL, URL_TARGET);
                            }
                        } else if (ACTION_TYPE === 'push_and_link') {
                            requestOneSignalPermission();
                            if (TARGET_URL) {
                                setTimeout(function() {
                                    window.open(TARGET_URL, URL_TARGET);
                                }, 350);
                            }
                        }

                        hidePrompt();
                    });
                }

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
