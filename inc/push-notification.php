<?php
/**
 * Push Notification Module for Hakajobs
 *
 * Integrasi resmi OneSignal Web Push v16.
 * Menggunakan pop-up izin asli (native slidedown / browser prompt) dari OneSignal.com
 * dan otomatisasi pengiriman Web Push ke layar smartphone pengunjung (Android & iOS)
 * saat Lowongan Kerja atau Artikel baru dipublikasikan atau diperbarui.
 *
 * @package Hakajobs
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Smart sanitizer for OneSignal App ID:
 * Extracts clean UUID even if user pastes entire <script> tag or surrounded by quotes
 */
function hakajobs_sanitize_onesignal_app_id($input) {
    if (empty($input)) {
        return '';
    }
    $clean = trim((string) $input);
    if (preg_match('/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/i', $clean, $matches)) {
        return strtolower($matches[0]);
    }
    return sanitize_text_field($clean);
}

/**
 * Smart sanitizer for OneSignal Safari Web ID:
 * Extracts web.onesignal.auto.xxxx even if user pastes entire <script> tag
 */
function hakajobs_sanitize_onesignal_safari_id($input) {
    if (empty($input)) {
        return '';
    }
    $clean = trim((string) $input);
    if (preg_match('/web\.onesignal\.auto\.[0-9a-z.-]+/i', $clean, $matches)) {
        return strtolower($matches[0]);
    }
    return sanitize_text_field($clean);
}

/**
 * Smart sanitizer for OneSignal REST API Key:
 * Strips whitespace, surrounding quotes, or accidental tags
 */
function hakajobs_sanitize_onesignal_api_key($input) {
    if (empty($input)) {
        return '';
    }
    $clean = trim((string) $input);
    $clean = trim($clean, " \t\n\r\0\x0B\"'");
    return sanitize_text_field($clean);
}

/**
 * 1. Register Theme Customizer Section & Controls for OneSignal Web Push
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function hakajobs_push_notification_customize_register($wp_customize) {
    $wp_customize->add_section('hakajobs_push_notice_section', array(
        'title'       => __('🔔 Notifikasi Web Push OneSignal', 'hakajobs'),
        'description' => __('Integrasi resmi Web Push OneSignal. Pop-up izin notifikasi tampil secara asli (native) dari OneSignal.com ke pengunjung website, dan pemberitahuan otomatis dikirim langsung ke layar handphone pengunjung (Android & iOS) saat Anda mempublikasikan lowongan kerja atau artikel baru.', 'hakajobs'),
        'panel'       => 'hakajobs_theme_options',
        'priority'    => 76,
    ));

    // 1. Aktifkan Fitur Web Push OneSignal
    $wp_customize->add_setting('hakajobs_push_enable', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_enable', array(
        'type'        => 'checkbox',
        'label'       => __('Aktifkan Notifikasi Web Push OneSignal', 'hakajobs'),
        'description' => __('Muat skrip resmi OneSignal di website dan aktifkan pengiriman notifikasi otomatis.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 2. OneSignal App ID
    $wp_customize->add_setting('hakajobs_onesignal_app_id', array(
        'default'           => '',
        'sanitize_callback' => 'hakajobs_sanitize_onesignal_app_id',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_onesignal_app_id', array(
        'type'        => 'text',
        'label'       => __('OneSignal App ID', 'hakajobs'),
        'description' => __('Dapatkan di https://onesignal.com > Settings > Keys & IDs. Masukkan ID saja (contoh: fa8d0207-13ae-4f12-9058-d910ade5f80a).', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 3. OneSignal REST API Key
    $wp_customize->add_setting('hakajobs_onesignal_api_key', array(
        'default'           => '',
        'sanitize_callback' => 'hakajobs_sanitize_onesignal_api_key',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_onesignal_api_key', array(
        'type'        => 'text',
        'label'       => __('OneSignal REST API Key', 'hakajobs'),
        'description' => __('Kunci API dari OneSignal Dashboard > Settings > Keys & IDs (contoh: os_v2_app_... atau kunci REST API v1). Diperlukan agar WordPress dapat mengirim notifikasi otomatis.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 4. OneSignal Safari Web ID (Opsional)
    $wp_customize->add_setting('hakajobs_onesignal_safari_web_id', array(
        'default'           => '',
        'sanitize_callback' => 'hakajobs_sanitize_onesignal_safari_id',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_onesignal_safari_web_id', array(
        'type'        => 'text',
        'label'       => __('OneSignal Safari Web ID (Opsional)', 'hakajobs'),
        'description' => __('Khusus browser Apple Safari. Contoh: web.onesignal.auto.xxxxxx (Cukup kodenya saja).', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 5. Pop-up Izin Notifikasi Otomatis (Auto-Prompt)
    $wp_customize->add_setting('hakajobs_push_auto_prompt', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_auto_prompt', array(
        'type'        => 'checkbox',
        'label'       => __('Tampilkan Pop-up Izin Notifikasi Otomatis (Slidedown Prompt)', 'hakajobs'),
        'description' => __('Otomatis menampilkan prompt ajakan berlangganan notifikasi ke pengunjung saat membuka website.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 6. Teks Ajakan Notifikasi
    $wp_customize->add_setting('hakajobs_push_prompt_text', array(
        'default'           => __('Dapatkan info lowongan kerja dan update karir terbaru langsung di perangkat Anda.', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_prompt_text', array(
        'type'        => 'text',
        'label'       => __('Teks Ajakan Notifikasi (Prompt)', 'hakajobs'),
        'description' => __('Pesan ajakan yang tampil di jendela pop-up izin OneSignal.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 7. Waktu Tunggu Kemunculan Pop-up (Detik)
    $wp_customize->add_setting('hakajobs_push_prompt_delay', array(
        'default'           => '3',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_prompt_delay', array(
        'type'        => 'number',
        'label'       => __('Waktu Tunda Pop-up (Detik)', 'hakajobs'),
        'description' => __('Berapa detik setelah halaman dimuat sebelum pop-up izin muncul (rekomendasi: 2 - 5 detik).', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 30,
            'step' => 1,
        ),
    ));

    // 9. Otomatis Kirim saat Lowongan Baru Diterbitkan
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

    // 10. Otomatis Kirim saat Artikel / Berita Baru Diterbitkan
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

    // 11. Kirim Saat Loker / Artikel Diperbarui (Update)
    $wp_customize->add_setting('hakajobs_push_notify_on_update', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_push_notify_on_update', array(
        'type'        => 'checkbox',
        'label'       => __('Kirim Notifikasi Saat Artikel/Loker Diupdate', 'hakajobs'),
        'description' => __('Jika diaktifkan, artikel/loker yang diperbarui juga akan mengirimkan notifikasi.', 'hakajobs'),
        'section'     => 'hakajobs_push_notice_section',
    ));

    // 12. Format Judul Notifikasi Lowongan
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

    // 13. Format Judul Notifikasi Artikel
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

    // 14. Sertakan Gambar Unggulan (Featured Image) di Handphone
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
}
add_action('customize_register', 'hakajobs_push_notification_customize_register', 20);

/**
 * 2. Serve Dynamic OneSignal Service Worker Endpoint & Sync Root File
 */
function hakajobs_push_sync_root_worker() {
    if (!defined('ABSPATH')) {
        return;
    }
    $root_file  = trailingslashit(ABSPATH) . 'OneSignalSDKWorker.js';
    $theme_file = get_template_directory() . '/OneSignalSDKWorker.js';

    // Salin otomatis ke root website (ABSPATH) agar Nginx / LiteSpeed / Apache menyajikannya tanpa kendala rewrite 404
    if (file_exists($theme_file)) {
        if (!file_exists($root_file) || (file_exists($root_file) && filesize($root_file) < 50)) {
            if (is_writable(ABSPATH) || (file_exists($root_file) && is_writable($root_file))) {
                @copy($theme_file, $root_file);
            }
        }
    }
}
add_action('admin_init', 'hakajobs_push_sync_root_worker');
add_action('after_switch_theme', 'hakajobs_push_sync_root_worker');

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

    // Strip surrounding quotes or formatting remnants
    $app_id  = trim($app_id, " \t\n\r\0\x0B\"'");
    $api_key = trim($api_key, " \t\n\r\0\x0B\"'");

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
        $icon = HAKAJOBS_URI . '/screenshot.png';
    }

    // Target seluruh segmen pelanggan OneSignal: mendukung format modern ('Total Subscriptions') maupun format standar ('Subscribed Users', 'Active Subscriptions')
    $payload = array(
        'app_id'            => $app_id,
        'included_segments' => array('Total Subscriptions', 'Subscribed Users', 'Active Subscriptions', 'Active Users'),
        'headings'          => array('en' => $title, 'id' => $title),
        'contents'          => array('en' => $message, 'id' => $message),
        'url'               => $url,
        'chrome_web_icon'   => $icon,
        'firefox_icon'      => $icon,
        'priority'          => 10,
        'ttl'               => 259200,
    );

    if (!empty($image)) {
        $payload['big_picture']      = $image;
        $payload['chrome_web_image'] = $image;
    }

    // Bersihkan prefix jika pengguna menyalin "Key ..." atau "Basic ..."
    $clean_key = preg_replace('/^(Basic|Key)\s+/i', '', $api_key);
    // Kunci modern OneSignal (awalan os_v2_app_) memerlukan "Key ...", kunci lama juga didukung
    $auth_header = (strpos($clean_key, 'os_v2_') === 0 || strpos($api_key, 'Key ') === 0) ? 'Key ' . $clean_key : 'Basic ' . $clean_key;

    // Endpoint modern OneSignal REST API
    $api_url = 'https://api.onesignal.com/notifications';

    $response = wp_remote_post($api_url, array(
        'method'      => 'POST',
        'timeout'     => 15,
        'redirection' => 5,
        'httpversion' => '1.1',
        'blocking'    => true,
        'headers'     => array(
            'Content-Type'  => 'application/json; charset=utf-8',
            'Authorization' => $auth_header,
        ),
        'body'        => wp_json_encode($payload),
    ));

    // Fallback: Jika api.onesignal.com mengalami gangguan koneksi, coba fallback ke onesignal.com legacy route
    if (is_wp_error($response)) {
        $fallback_auth = 'Key ' . $clean_key;
        $response = wp_remote_post('https://onesignal.com/api/v1/notifications', array(
            'method'      => 'POST',
            'timeout'     => 15,
            'redirection' => 5,
            'httpversion' => '1.1',
            'blocking'    => true,
            'headers'     => array(
                'Content-Type'  => 'application/json; charset=utf-8',
                'Authorization' => $fallback_auth,
            ),
            'body'        => wp_json_encode($payload),
        ));
    }

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

    // Terjemahkan & jelaskan error teknis OneSignal agar mudah dipahami admin
    if (stripos($error_msg, 'All included players are not subscribed') !== false) {
        $error_msg = __('Belum ada perangkat/handphone yang berlangganan notifikasi di OneSignal (0 subscriber aktif). Buka website di browser HP Anda via HTTPS dan klik "Izinkan" / "Aktifkan" notifikasi terlebih dahulu agar HP Anda terdaftar.', 'hakajobs');
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
    $enabled = get_theme_mod('hakajobs_push_enable', '1');
    $app_id  = trim(get_theme_mod('hakajobs_onesignal_app_id', ''));
    if ($enabled !== '1' || empty($app_id)) {
        return;
    }

    // Cegah duplikasi pengiriman dalam satu siklus request PHP
    static $sent_posts = array();
    if (isset($sent_posts[$post->ID])) {
        return;
    }

    $is_new_publish = ($old_status !== 'publish');
    $is_update      = ($old_status === 'publish');

    // Cek apakah form dikirim dari halaman editor post WordPress yang memiliki meta box kami
    $mb_present = isset($_POST['hakajobs_push_meta_nonce']) && wp_verify_nonce($_POST['hakajobs_push_meta_nonce'], 'hakajobs_push_meta_nonce_action');

    if ($mb_present) {
        // Form dikirim manual oleh admin di editor WordPress:
        // Cek secara presisi apakah checkbox "Kirim Notifikasi Push" dicentang
        if (empty($_POST['hakajobs_send_push_notification'])) {
            return; // Admin sengaja mengosongkan / uncheck centang
        }
    } else {
        // Diterbitkan secara otomatis (REST API, cron, atau XML-RPC)
        if ($is_new_publish) {
            if ($post_type === 'lowongan') {
                $notify_enabled = get_theme_mod('hakajobs_push_notify_lowongan', '1');
            } else {
                $notify_enabled = get_theme_mod('hakajobs_push_notify_articles', '1');
            }
            if ($notify_enabled !== '1') {
                return;
            }
        } elseif ($is_update) {
            $update_enabled = get_theme_mod('hakajobs_push_notify_on_update', '1');
            if ($update_enabled !== '1') {
                return;
            }
        }
    }

    $site_name = get_bloginfo('name');

    // Buat Judul Notifikasi
    if ($post_type === 'lowongan') {
        $title_template = get_theme_mod('hakajobs_push_title_lowongan', __('[Loker Baru] {title}', 'hakajobs'));
        $company_name   = !empty($_POST['hakajobs_company_name']) ? sanitize_text_field(wp_unslash($_POST['hakajobs_company_name'])) : get_post_meta($post->ID, '_hakajobs_company_name', true);
        $location       = !empty($_POST['hakajobs_company_location']) ? sanitize_text_field(wp_unslash($_POST['hakajobs_company_location'])) : get_post_meta($post->ID, '_hakajobs_company_location', true);
        $salary         = !empty($_POST['hakajobs_salary']) ? sanitize_text_field(wp_unslash($_POST['hakajobs_salary'])) : get_post_meta($post->ID, '_hakajobs_salary', true);
        $salary_period  = !empty($_POST['hakajobs_salary_period']) ? sanitize_text_field(wp_unslash($_POST['hakajobs_salary_period'])) : get_post_meta($post->ID, '_hakajobs_salary_period', true);

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

    $icon_url = get_site_icon_url(192);
    if (empty($icon_url)) {
        $icon_url = HAKAJOBS_URI . '/screenshot.png';
    }

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
    $api_key      = trim(get_theme_mod('hakajobs_onesignal_api_key', ''));
    $last_sent    = get_post_meta($post->ID, '_hakajobs_push_last_sent', true);
    $recipients   = get_post_meta($post->ID, '_hakajobs_push_recipients', true);
    $last_error   = get_post_meta($post->ID, '_hakajobs_push_last_error', true);
    $is_published = ($post->post_status === 'publish');

    // Default centang: Aktif untuk draf/loker baru, atau jika opsi kirim saat update aktif di Pengaturan Notifikasi
    $update_setting  = (get_theme_mod('hakajobs_push_notify_on_update', '1') === '1');
    $default_checked = $is_published ? $update_setting : true;
    ?>
    <div class="hk-push-mb-wrap" style="font-size: 13px; color: #334155;">
        <?php if (empty($app_id) || empty($api_key)): ?>
            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 10px; border-radius: 6px; margin-bottom: 12px; font-size: 12px; line-height: 1.4;">
                ⚠️ <strong>OneSignal Belum Terhubung</strong><br>
                Masukkan App ID & REST API Key di <strong>Tampilan > Sesuaikan > 🔔 Notifikasi Web Push OneSignal</strong> agar pemberitahuan otomatis masuk ke smartphone pengunjung.
            </div>
        <?php else: ?>
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 8px 10px; border-radius: 6px; margin-bottom: 12px; font-size: 12px; display: flex; align-items: center; gap: 6px;">
                <span>🟢</span>
                <span><strong>OneSignal Siap:</strong> Terhubung ke aplikasi OneSignal.</span>
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
            <div style="background: #fff1f2; border: 1px solid #fecdd3; padding: 10px; border-radius: 6px; margin-top: 10px; font-size: 11.5px; color: #9f1239; line-height: 1.45;">
                <strong style="display:flex; align-items:center; gap:4px; margin-bottom:4px;">
                    <span>⚠️</span> <?php _e('Gagal Mengirim Sebelumnya:', 'hakajobs'); ?>
                </strong>
                <div><?php echo esc_html($last_error); ?></div>
                <?php if (stripos($last_error, 'subscriber') !== false || stripos($last_error, 'not subscribed') !== false): ?>
                    <div style="margin-top: 8px; padding-top: 8px; border-top: 1px dashed #fecdd3; font-size: 11px; color: #475569;">
                        <strong>💡 Cara Mendaftarkan HP Anda:</strong>
                        <ol style="margin: 4px 0 0 16px; padding: 0;">
                            <li>Buka situs ini di browser HP Anda via <strong>HTTPS</strong>.</li>
                            <li>Klik tombol <strong>"Aktifkan" / "Izinkan" (Allow)</strong> pada pop-up izin notifikasi.</li>
                            <li>Setelah HP Anda terdaftar, klik tombol <em>Tes Kirim Notifikasi Sekarang</em> di bawah atau update artikel.</li>
                        </ol>
                    </div>
                <?php endif; ?>
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

        <!-- Test Push Notification Button -->
        <div style="margin-top: 14px; padding-top: 10px; border-top: 1px dashed #e2e8f0;">
            <button type="button" id="hk-test-push-btn" class="button button-secondary button-small" style="display:inline-flex; align-items:center; gap:5px; font-weight: 600;">
                <span>🔔</span> <?php _e('Tes Kirim Notifikasi Sekarang', 'hakajobs'); ?>
            </button>
            <div id="hk-test-push-feedback" style="margin-top: 8px; font-size: 11.5px; line-height: 1.4; display: none;"></div>
        </div>
        <script>
        (function($){
            $('#hk-test-push-btn').on('click', function(e){
                e.preventDefault();
                var $btn = $(this);
                var $fb  = $('#hk-test-push-feedback');
                $btn.prop('disabled', true).text('Mengirim...');
                $fb.hide().removeClass('notice notice-error notice-success');

                $.post(ajaxurl, {
                    action: 'hakajobs_test_push',
                    nonce: '<?php echo wp_create_nonce('hakajobs_test_push_nonce'); ?>'
                }, function(res){
                    $btn.prop('disabled', false).html('<span>🔔</span> <?php echo esc_js(__('Tes Kirim Notifikasi Sekarang', 'hakajobs')); ?>');
                    $fb.show();
                    if(res && res.success){
                        $fb.attr('style', 'margin-top:8px; padding:6px 8px; border-radius:4px; background:#f0fdf4; border:1px solid #bbf7d0; color:#166534;')
                           .html('✅ ' + (res.data && res.data.message ? res.data.message : 'Berhasil dikirim!'));
                    } else {
                        var errMsg = res && res.data && res.data.message ? res.data.message : 'Gagal mengirim notifikasi.';
                        $fb.attr('style', 'margin-top:8px; padding:6px 8px; border-radius:4px; background:#fff1f2; border:1px solid #fecdd3; color:#e11d48;')
                           .html('❌ ' + errMsg);
                    }
                }).fail(function(){
                    $btn.prop('disabled', false).html('<span>🔔</span> <?php echo esc_js(__('Tes Kirim Notifikasi Sekarang', 'hakajobs')); ?>');
                    $fb.show().attr('style', 'margin-top:8px; padding:6px 8px; border-radius:4px; background:#fff1f2; border:1px solid #fecdd3; color:#e11d48;')
                       .html('❌ Terjadi kesalahan jaringan saat menghubungi server.');
                });
            });
        })(jQuery);
        </script>
    </div>
    <?php
}

/**
 * 6. Admin Notice: Prompt to fill OneSignal Keys if enabled but missing
 */
function hakajobs_push_admin_notice() {
    // Check if dismissed permanently by this user
    if (get_user_meta(get_current_user_id(), 'hakajobs_dismiss_push_notice', true)) {
        return;
    }

    $push_enabled = get_theme_mod('hakajobs_push_enable', '1');
    $app_id       = trim(get_theme_mod('hakajobs_onesignal_app_id', ''));

    if ($push_enabled === '1' && empty($app_id) && current_user_can('manage_options')) {
        $customizer_url = admin_url('customize.php?autofocus[section]=hakajobs_push_notice_section');
        $dismiss_url    = wp_nonce_url(add_query_arg('hakajobs_dismiss_push_notice', '1'), 'hakajobs_dismiss_push_notice_action');
        ?>
        <div class="notice notice-warning is-dismissible hakajobs-push-admin-notice" style="border-left-color: #0284c7;">
            <p>
                <strong>🔔 Fitur Notifikasi HakaJobs Aktif:</strong>
                Agar pemberitahuan artikel & lowongan baru dapat terkirim otomatis ke layar handphone pengunjung, silakan masukkan <strong>OneSignal App ID & REST API Key</strong> Anda.
                <a href="<?php echo esc_url($customizer_url); ?>" class="button button-small button-primary" style="margin-left: 8px;">
                    <?php _e('Buka Pengaturan Notifikasi', 'hakajobs'); ?>
                </a>
                <a href="<?php echo esc_url($dismiss_url); ?>" class="button button-small" style="margin-left: 6px; color: #64748b;">
                    <?php _e('Jangan Tampilkan Lagi', 'hakajobs'); ?>
                </a>
            </p>
        </div>
        <script>
        jQuery(document).on('click', '.hakajobs-push-admin-notice .notice-dismiss', function() {
            jQuery.post(ajaxurl, {
                action: 'hakajobs_dismiss_push_notice_ajax',
                nonce: '<?php echo wp_create_nonce('hakajobs_dismiss_push_ajax_nonce'); ?>'
            });
        });
        </script>
        <?php
    }
}
add_action('admin_notices', 'hakajobs_push_admin_notice');

/**
 * Handle persistent dismissal of push admin notice
 */
function hakajobs_handle_dismiss_push_notice() {
    if (isset($_GET['hakajobs_dismiss_push_notice']) && current_user_can('manage_options')) {
        check_admin_referer('hakajobs_dismiss_push_notice_action');
        update_user_meta(get_current_user_id(), 'hakajobs_dismiss_push_notice', 1);
        wp_safe_redirect(remove_query_arg(array('hakajobs_dismiss_push_notice', '_wpnonce')));
        exit;
    }
}
add_action('admin_init', 'hakajobs_handle_dismiss_push_notice');

function hakajobs_ajax_dismiss_push_notice() {
    check_ajax_referer('hakajobs_dismiss_push_ajax_nonce', 'nonce');
    if (current_user_can('manage_options')) {
        update_user_meta(get_current_user_id(), 'hakajobs_dismiss_push_notice', 1);
        wp_send_json_success();
    }
    wp_send_json_error();
}
add_action('wp_ajax_hakajobs_dismiss_push_notice_ajax', 'hakajobs_ajax_dismiss_push_notice');

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
        'message' => __('Selamat! Fitur notifikasi handphone Anda telah aktif dan terhubung. Update lowongan kerja & artikel baru akan otomatis terkirim.', 'hakajobs'),
        'url'     => home_url('/'),
    ));

    if (!empty($result['success'])) {
        wp_send_json_success(array(
            'message'    => sprintf(__('Notifikasi uji coba berhasil terkirim ke OneSignal! Diterima oleh %d subscriber aktif.', 'hakajobs'), $result['recipients']),
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
 * 8. Render Pure OneSignal Web SDK v16 on Frontend (wp_footer)
 *
 * Menggunakan popup izin bawaan resmi OneSignal.com (Native Slidedown & Permission Prompt).
 * Mendukung auto-prompt, konfigurasi delay, dan floating bell button interaktif.
 */
function hakajobs_render_push_notification() {
    $enabled = get_theme_mod('hakajobs_push_enable', '1');
    $app_id  = trim(get_theme_mod('hakajobs_onesignal_app_id', ''));

    // Bersihkan app_id dari tanda kutip atau spasi liar
    $app_id  = trim($app_id, " \t\n\r\0\x0B\"'");

    if ($enabled !== '1' || empty($app_id)) {
        return;
    }

    $safari_web_id = trim(get_theme_mod('hakajobs_onesignal_safari_web_id', ''));
    $auto_prompt   = get_theme_mod('hakajobs_push_auto_prompt', '1');
    $prompt_delay  = (int) get_theme_mod('hakajobs_push_prompt_delay', 3);
    if ($prompt_delay < 1) {
        $prompt_delay = 1;
    }
    $prompt_msg    = get_theme_mod('hakajobs_push_prompt_text', __('Dapatkan info lowongan kerja dan update karir terbaru langsung di perangkat Anda.', 'hakajobs'));
    $prompt_accept = __('Aktifkan', 'hakajobs');
    $prompt_cancel = __('Nanti Saja', 'hakajobs');
    ?>
    <!-- OneSignal Web SDK v16: Pop-up & Web Push Asli OneSignal.com -->
    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
        // Bersihkan residu legacy Service Worker / PWA non-OneSignal jika pernah tersimpan di browser
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.getRegistrations().then(function(regs) {
                regs.forEach(function(reg) {
                    if (reg.active && reg.active.scriptURL) {
                        var swUrl = reg.active.scriptURL.toLowerCase();
                        // PENTING: JANGAN unregister OneSignal! Hanya unregister legacy sw lama jika bukan onesignal
                        if (swUrl.indexOf('onesignal') === -1 && (swUrl.indexOf('hakajobs_sw') !== -1 || swUrl.indexOf('/sw.js') !== -1)) {
                            reg.unregister();
                        }
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

        window.OneSignalDeferred = window.OneSignalDeferred || [];
        OneSignalDeferred.push(async function(OneSignal) {
            await OneSignal.init({
                appId: "<?php echo esc_js($app_id); ?>",
                <?php if (!empty($safari_web_id)): ?>
                safari_web_id: "<?php echo esc_js($safari_web_id); ?>",
                <?php endif; ?>
                allowLocalhostAsSecureOrigin: true<?php if ($auto_prompt === '1'): ?>,
                promptOptions: {
                    slidedown: {
                        prompts: [
                            {
                                type: "push",
                                autoPrompt: true,
                                text: {
                                    actionMessage: <?php echo wp_json_encode($prompt_msg); ?>,
                                    acceptButton: <?php echo wp_json_encode($prompt_accept); ?>,
                                    cancelButton: <?php echo wp_json_encode($prompt_cancel); ?>
                                },
                                delay: {
                                    pageViews: 1,
                                    timeDelay: <?php echo intval($prompt_delay); ?>
                                }
                            }
                        ]
                    }
                }
                <?php endif; ?>
            });

            <?php if ($auto_prompt === '1'): ?>
            // Fallback trigger: Jika browser belum pernah diminta izin, panggil Slidedown prompt OneSignal
            setTimeout(async function() {
                try {
                    var isOptedIn = OneSignal.User && OneSignal.User.PushSubscription && OneSignal.User.PushSubscription.optedIn;
                    var perm = (window.Notification && Notification.permission) ? Notification.permission : 'default';
                    if (!isOptedIn && perm !== 'denied') {
                        if (OneSignal.Slidedown && typeof OneSignal.Slidedown.promptPush === 'function') {
                            await OneSignal.Slidedown.promptPush();
                        }
                    }
                } catch (e) {
                    // Abaikan jika sudah diprompt
                }
            }, <?php echo intval($prompt_delay + 1) * 1000; ?>);
            <?php endif; ?>
        });

        // Trigger manual lewat tombol / tautan dengan onclick="window.hakajobsTriggerPushPrompt()"
        window.hakajobsTriggerPushPrompt = function() {
            window.OneSignalDeferred = window.OneSignalDeferred || [];
            OneSignalDeferred.push(async function(OneSignal) {
                try {
                    var isOptedIn = OneSignal.User && OneSignal.User.PushSubscription && OneSignal.User.PushSubscription.optedIn;
                    if (isOptedIn || (window.Notification && Notification.permission === 'granted')) {
                        if (typeof showToast === 'function') {
                            showToast('🔔 ' + <?php echo wp_json_encode(__('Anda sudah berlangganan notifikasi!', 'hakajobs')); ?>);
                        } else {
                            alert(<?php echo wp_json_encode(__('Anda sudah berlangganan notifikasi!', 'hakajobs')); ?>);
                        }
                        return;
                    }
                    if (OneSignal.Slidedown && typeof OneSignal.Slidedown.promptPush === 'function') {
                        await OneSignal.Slidedown.promptPush({ force: true });
                    } else if (OneSignal.User && OneSignal.User.PushSubscription && typeof OneSignal.User.PushSubscription.optIn === 'function') {
                        await OneSignal.User.PushSubscription.optIn();
                    } else if (OneSignal.Notifications && typeof OneSignal.Notifications.requestPermission === 'function') {
                        await OneSignal.Notifications.requestPermission();
                    }
                } catch (err) {
                    console.log('OneSignal trigger error:', err);
                }
            });
        };
    </script>
    <?php
}
add_action('wp_footer', 'hakajobs_render_push_notification', 99);
