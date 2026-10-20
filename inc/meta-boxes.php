<?php
/**
 * Custom Meta Boxes for Lowongan Kerja
 *
 * @package Hakajobs
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register meta boxes
 */
function hakajobs_add_job_meta_boxes() {
    add_meta_box(
        'hakajobs_job_details',
        __('Detail Pekerjaan & Perusahaan', 'hakajobs'),
        'hakajobs_render_job_details_box',
        'lowongan',
        'normal',
        'high'
    );

    add_meta_box(
        'hakajobs_job_apply',
        __('Metode Lamaran Kerja (WhatsApp / Email / Link Website)', 'hakajobs'),
        'hakajobs_render_job_apply_box',
        'lowongan',
        'normal',
        'high'
    );

    add_meta_box(
        'hakajobs_job_benefits',
        __('Benefit & Fasilitas Pekerjaan', 'hakajobs'),
        'hakajobs_render_job_benefits_box',
        'lowongan',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'hakajobs_add_job_meta_boxes');

/**
 * Render Job Details Meta Box
 */
function hakajobs_render_job_details_box($post) {
    wp_nonce_field('hakajobs_job_meta_nonce_action', 'hakajobs_job_meta_nonce');

    $company_name     = get_post_meta($post->ID, '_hakajobs_company_name', true);
    $company_website  = get_post_meta($post->ID, '_hakajobs_company_website', true);
    $company_location = get_post_meta($post->ID, '_hakajobs_company_location', true);
    $postal_code      = get_post_meta($post->ID, '_hakajobs_postal_code', true);
    $salary           = get_post_meta($post->ID, '_hakajobs_salary', true);
    $salary_period    = get_post_meta($post->ID, '_hakajobs_salary_period', true);
    $deadline         = get_post_meta($post->ID, '_hakajobs_deadline', true);
    $status           = get_post_meta($post->ID, '_hakajobs_status', true);
    $is_featured      = get_post_meta($post->ID, '_hakajobs_is_featured', true);
    $is_urgent        = get_post_meta($post->ID, '_hakajobs_is_urgent', true);

    if (empty($status)) {
        $status = 'aktif';
    }
    if (empty($salary_period)) {
        $salary_period = 'bulan';
    }
    ?>
    <style>
        .hk-meta-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; margin-bottom: 16px; }
        .hk-field { margin-bottom: 12px; }
        .hk-field label { display: block; font-weight: 600; margin-bottom: 5px; color: #1e293b; font-size: 13px; }
        .hk-field input[type="text"], .hk-field input[type="url"], .hk-field input[type="date"], .hk-field select {
            width: 100%; padding: 8px 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-size: 13px;
        }
        .hk-field small { color: #64748b; font-size: 11px; display: block; margin-top: 3px; }
        .hk-checkboxes { display: flex; gap: 20px; align-items: center; background: #f8fafc; padding: 12px; border-radius: 6px; border: 1px solid #e2e8f0; }
        .hk-checkboxes label { font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; }
    </style>

    <div class="hk-meta-grid">
        <div class="hk-field">
            <label for="hakajobs_company_name"><?php _e('Nama Perusahaan / Organisasi *', 'hakajobs'); ?></label>
            <input type="text" id="hakajobs_company_name" name="hakajobs_company_name" value="<?php echo esc_attr($company_name); ?>" placeholder="Contoh: PT Teknologi Bangsa Indonesia" required />
            <small><?php _e('Nama pemberi kerja atau rekruter.', 'hakajobs'); ?></small>
        </div>

        <div class="hk-field">
            <label for="hakajobs_company_website"><?php _e('Website Perusahaan (Opsional)', 'hakajobs'); ?></label>
            <input type="url" id="hakajobs_company_website" name="hakajobs_company_website" value="<?php echo esc_attr($company_website); ?>" placeholder="https://perusahaan.com" />
            <small><?php _e('Link situs resmi perusahaan untuk kredibilitas.', 'hakajobs'); ?></small>
        </div>
    </div>

    <div class="hk-meta-grid">
        <div class="hk-field">
            <label for="hakajobs_company_location"><?php _e('Alamat Lengkap Kantor / Jalan (streetAddress)', 'hakajobs'); ?></label>
            <input type="text" id="hakajobs_company_location" name="hakajobs_company_location" value="<?php echo esc_attr($company_location); ?>" placeholder="Contoh: Menara Sudirman Lt. 12, Jl. Jend. Sudirman" />
            <small><?php _e('Alamat spesifik kantor tempat bekerja (jalan, gedung, lantai). Terhubung ke streetAddress Google Jobs.', 'hakajobs'); ?></small>
        </div>

        <div class="hk-field">
            <label for="hakajobs_postal_code"><?php _e('Kode Pos Kantor (postalCode)', 'hakajobs'); ?></label>
            <input type="text" id="hakajobs_postal_code" name="hakajobs_postal_code" value="<?php echo esc_attr($postal_code); ?>" placeholder="Contoh: 12190" maxlength="10" />
            <small><?php _e('Kode pos 5 digit kantor. Jika kosong, sistem otomatis mengisinya berdasarkan kota.', 'hakajobs'); ?></small>
        </div>
    </div>

    <div class="hk-meta-grid">
        <div class="hk-field">
            <label for="hakajobs_salary"><?php _e('Kisaran Gaji / Penghasilan', 'hakajobs'); ?></label>
            <input type="text" id="hakajobs_salary" name="hakajobs_salary" value="<?php echo esc_attr($salary); ?>" placeholder="Contoh: Rp 6.000.000 - Rp 9.000.000" />
            <small><?php _e('Format angka (misal Rp 6.000.000 - Rp 9.000.000) otomatis terbaca oleh Google baseSalary.', 'hakajobs'); ?></small>
        </div>

        <div class="hk-field">
            <label for="hakajobs_salary_period"><?php _e('Periode Gaji', 'hakajobs'); ?></label>
            <select id="hakajobs_salary_period" name="hakajobs_salary_period">
                <option value="bulan" <?php selected($salary_period, 'bulan'); ?>><?php _e('Per Bulan', 'hakajobs'); ?></option>
                <option value="tahun" <?php selected($salary_period, 'tahun'); ?>><?php _e('Per Tahun', 'hakajobs'); ?></option>
                <option value="hari" <?php selected($salary_period, 'hari'); ?>><?php _e('Per Hari', 'hakajobs'); ?></option>
                <option value="jam" <?php selected($salary_period, 'jam'); ?>><?php _e('Per Jam', 'hakajobs'); ?></option>
                <option value="proyek" <?php selected($salary_period, 'proyek'); ?>><?php _e('Per Proyek / Freelance', 'hakajobs'); ?></option>
            </select>
            <small><?php _e('Frekuensi pembayaran upah.', 'hakajobs'); ?></small>
        </div>
    </div>

    <div class="hk-meta-grid">
        <div class="hk-field">
            <label for="hakajobs_deadline"><?php _e('Batas Akhir Pendaftaran (Deadline)', 'hakajobs'); ?></label>
            <input type="date" id="hakajobs_deadline" name="hakajobs_deadline" value="<?php echo esc_attr($deadline); ?>" />
            <small><?php _e('Biarkan kosong jika tidak ada batas waktu tertentu.', 'hakajobs'); ?></small>
        </div>
    </div>

    <div class="hk-checkboxes">
        <label>
            <input type="radio" name="hakajobs_status" value="aktif" <?php checked($status, 'aktif'); ?> />
            <span style="color:#15803d;font-weight:700;">🟢 <?php _e('Status: Lowongan Aktif', 'hakajobs'); ?></span>
        </label>
        <label>
            <input type="radio" name="hakajobs_status" value="tutup" <?php checked($status, 'tutup'); ?> />
            <span style="color:#b91c1c;font-weight:700;">🔴 <?php _e('Status: Sudah Ditutup', 'hakajobs'); ?></span>
        </label>
        <span style="border-left: 1px solid #cbd5e1; height: 20px; margin: 0 8px;"></span>
        <label>
            <input type="checkbox" name="hakajobs_is_featured" value="1" <?php checked($is_featured, '1'); ?> />
            ⭐ <?php _e('Tandai Lowongan Sorotan (Featured)', 'hakajobs'); ?>
        </label>
        <label>
            <input type="checkbox" name="hakajobs_is_urgent" value="1" <?php checked($is_urgent, '1'); ?> />
            🔥 <?php _e('Dibutuhkan Segera (Urgent)', 'hakajobs'); ?>
        </label>
    </div>
    <?php
}

/**
 * Render Job Apply Method Meta Box
 */
function hakajobs_render_job_apply_box($post) {
    $apply_type        = get_post_meta($post->ID, '_hakajobs_apply_type', true);
    $apply_wa          = get_post_meta($post->ID, '_hakajobs_apply_wa', true);
    $apply_wa_message  = get_post_meta($post->ID, '_hakajobs_apply_wa_message', true);
    $apply_email       = get_post_meta($post->ID, '_hakajobs_apply_email', true);
    $apply_email_sub   = get_post_meta($post->ID, '_hakajobs_apply_email_sub', true);
    $apply_email_body  = get_post_meta($post->ID, '_hakajobs_apply_email_body', true);
    $apply_url         = get_post_meta($post->ID, '_hakajobs_apply_url', true);
    $apply_notes       = get_post_meta($post->ID, '_hakajobs_apply_notes', true);

    if (empty($apply_type)) {
        $apply_type = 'whatsapp';
    }
    $site_name = get_bloginfo('name');
    
    // Check if using old generic placeholder
    $legacy_old_default = sprintf('Halo Tim HRD, saya melihat lowongan pekerjaan di website "%s" dan tertarik untuk melamar posisi ini. Mohon informasi berkas yang perlu saya kirimkan. Terima kasih.', $site_name);
    if (trim($apply_wa_message) === trim($legacy_old_default) || trim($apply_wa_message) === 'Halo Tim HRD, saya melihat lowongan pekerjaan di website "Hakajobs" dan tertarik untuk melamar posisi ini. Mohon informasi berkas yang perlu saya kirimkan. Terima kasih.') {
        $apply_wa_message = '';
    }

    $wa_placeholder = "Halo Tim Rekrutmen {company},\n\nSaya melihat informasi lowongan pekerjaan di website {website} dan bermaksud untuk melamar posisi berikut:\n\n📋 *Detail Lamaran:*\n• Posisi: *{posisi}*\n• Perusahaan: {company}\n• Referensi Info Loker: {link}\n\n👤 *Ringkasan Data Singkat:*\n• Nama Lengkap: [Nama Anda]\n• Domisili: [Kota/Daerah Domisili]\n• Pendidikan / Pengalaman Terakhir: [Pendidikan / Pengalaman Singkat]\n\nSaya telah menyiapkan berkas lamaran (CV dan dokumen pendukung). Apakah berkas dapat saya kirimkan melalui chat WhatsApp ini atau via email resmi rekrutmen?\n\nTerima kasih atas waktu dan kesempatan yang diberikan.";
    $email_body_placeholder = "Kepada Yth.\nTim Rekrutmen / HRD {company}\ndi Tempat\n\nDengan hormat,\n\nSehubungan dengan informasi lowongan pekerjaan untuk posisi {posisi} yang saya peroleh melalui situs {website} ({link}), bersama email ini saya bermaksud untuk mengajukan diri guna mengisi posisi tersebut.\n\nBerikut adalah ringkasan singkat profil saya:\n• Nama Lengkap: [Nama Lengkap Anda]\n• Nomor WhatsApp / HP: [Nomor HP/WA Aktif]\n• Kota Domisili: [Kota Domisili]\n• Pendidikan Terakhir: [Pendidikan Terakhir / Jurusan]\n• Keahlian / Pengalaman Relevan: [Sebutkan 1-2 keahlian utama]\n\nSebagai bahan pertimbangan Bapak/Ibu, bersama email ini turut saya lampirkan berkas kelengkapan:\n1. Curriculum Vitae (CV) Terbaru\n2. Portofolio Pekerjaan\n3. Dokumen Pendukung Lainnya\n\nBesar harapan saya untuk memperoleh kesempatan wawancara...\n\n(Biarkan kosong untuk menggunakan template surat lamaran profesional otomatis lengkap)";
    ?>
    <p style="margin-top:0; color:#475569; font-size:13px;">
        <?php _e('Pilih cara bagaimana pelamar mengirim lamaran kepada perusahaan/rekruter. Pelamar TIDAK PERLU login untuk mengirim lamaran!', 'hakajobs'); ?>
    </p>

    <div class="hk-field">
        <label for="hakajobs_apply_type"><?php _e('Metode Utama Pengiriman Lamaran:', 'hakajobs'); ?></label>
        <select id="hakajobs_apply_type" name="hakajobs_apply_type" style="max-width:320px; font-weight:600;">
            <option value="whatsapp" <?php selected($apply_type, 'whatsapp'); ?>>📱 Chat WhatsApp Langsung ke HRD</option>
            <option value="email" <?php selected($apply_type, 'email'); ?>>✉️ Kirim Email Lamaran (Mailto)</option>
            <option value="url" <?php selected($apply_type, 'url'); ?>>🔗 Tautan Web Resmi / Google Form</option>
        </select>
    </div>

    <!-- WhatsApp Box -->
    <div id="hk_apply_wa_wrapper" style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:14px; margin-top:12px;">
        <h4 style="margin:0 0 10px 0; color:#166534;">📱 Konfigurasi Lamaran WhatsApp</h4>
        <div class="hk-meta-grid">
            <div class="hk-field">
                <label for="hakajobs_apply_wa"><?php _e('Nomor WhatsApp Rekruter / HRD', 'hakajobs'); ?></label>
                <input type="text" id="hakajobs_apply_wa" name="hakajobs_apply_wa" value="<?php echo esc_attr($apply_wa); ?>" placeholder="Contoh: 08123456789 atau 628123456789" />
                <small><?php _e('Akan otomatis diformat ke format internasional WhatsApp (628...).', 'hakajobs'); ?></small>
            </div>
            <div class="hk-field">
                <label for="hakajobs_apply_wa_message"><?php _e('Template Teks Pesan WhatsApp (Opsional)', 'hakajobs'); ?></label>
                <textarea id="hakajobs_apply_wa_message" name="hakajobs_apply_wa_message" rows="5" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:8px; font-size:12px; font-family:monospace;" placeholder="<?php echo esc_attr($wa_placeholder); ?>"><?php echo esc_textarea($apply_wa_message); ?></textarea>
                <small style="display:block; margin-top:4px; color:#475569;">
                    <?php _e('Tersedia tag dinamis: <code>{posisi}</code>, <code>{perusahaan}</code>, <code>{website}</code>, <code>{link}</code>.<br><strong>Biarkan kosong</strong> untuk menggunakan template pesan HRD profesional otomatis.', 'hakajobs'); ?>
                </small>
            </div>
        </div>
    </div>

    <!-- Email Box -->
    <div id="hk_apply_email_wrapper" style="background:#f0f9ff; border:1px solid #bae6fd; border-radius:8px; padding:14px; margin-top:12px;">
        <h4 style="margin:0 0 10px 0; color:#075985;">✉️ Konfigurasi Lamaran Email</h4>
        <div class="hk-meta-grid">
            <div class="hk-field">
                <label for="hakajobs_apply_email"><?php _e('Alamat Email Penerima Lamaran', 'hakajobs'); ?></label>
                <input type="text" id="hakajobs_apply_email" name="hakajobs_apply_email" value="<?php echo esc_attr($apply_email); ?>" placeholder="recruitment@perusahaan.com" />
                <small><?php _e('Email HRD / bagian rekrutmen perusahaan.', 'hakajobs'); ?></small>
            </div>
            <div class="hk-field">
                <label for="hakajobs_apply_email_sub"><?php _e('Subjek Default Email', 'hakajobs'); ?></label>
                <input type="text" id="hakajobs_apply_email_sub" name="hakajobs_apply_email_sub" value="<?php echo esc_attr($apply_email_sub); ?>" placeholder="Lamaran Pekerjaan: {posisi} - [Nama Lengkap Anda]" />
                <small><?php _e('Tersedia tag: <code>{posisi}</code>, <code>{perusahaan}</code>, <code>{website}</code>. Biarkan kosong untuk subjek profesional otomatis.', 'hakajobs'); ?></small>
            </div>
            <div class="hk-field" style="margin-top:10px;">
                <label for="hakajobs_apply_email_body"><?php _e('Template Isi Surat Lamaran Email (Opsional)', 'hakajobs'); ?></label>
                <textarea id="hakajobs_apply_email_body" name="hakajobs_apply_email_body" rows="6" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:8px; font-size:12px; font-family:monospace;" placeholder="<?php echo esc_attr($email_body_placeholder); ?>"><?php echo esc_textarea($apply_email_body); ?></textarea>
                <small style="display:block; margin-top:4px; color:#475569;">
                    <?php _e('Tersedia tag: <code>{posisi}</code>, <code>{perusahaan}</code>, <code>{website}</code>, <code>{link}</code>.<br><strong>Biarkan kosong</strong> untuk format surat lamaran kerja resmi standar HRD secara otomatis.', 'hakajobs'); ?>
                </small>
            </div>
        </div>
    </div>

    <!-- External Link Box -->
    <div id="hk_apply_url_wrapper" style="background:#faf5ff; border:1px solid #e9d5ff; border-radius:8px; padding:14px; margin-top:12px;">
        <h4 style="margin:0 0 10px 0; color:#6b21a8;">🔗 Konfigurasi Tautan Lamaran Eksternal</h4>
        <div class="hk-field">
            <label for="hakajobs_apply_url"><?php _e('Tautan Website Karir Perusahaan / Google Form', 'hakajobs'); ?></label>
            <input type="url" id="hakajobs_apply_url" name="hakajobs_apply_url" value="<?php echo esc_attr($apply_url); ?>" placeholder="https://karir.perusahaan.com/apply/123 atau link forms.gle/..." />
            <small><?php _e('Link langsung ke form pendaftaran atau portal karir resmi perusahaan.', 'hakajobs'); ?></small>
        </div>
    </div>

    <div class="hk-field" style="margin-top:14px;">
        <label for="hakajobs_apply_notes"><?php _e('Catatan / Petunjuk Khusus Pelamar (Opsional)', 'hakajobs'); ?></label>
        <textarea id="hakajobs_apply_notes" name="hakajobs_apply_notes" rows="2" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:8px; font-size:13px;" placeholder="Contoh: Lampirkan CV terbaru & portofolio dalam format PDF maksimal 5MB."><?php echo esc_textarea($apply_notes); ?></textarea>
    </div>
    <?php
}

/**
 * Render Job Benefits Meta Box
 */
function hakajobs_render_job_benefits_box($post) {
    $benefits = get_post_meta($post->ID, '_hakajobs_benefits', true);
    ?>
    <p style="font-size:12px; color:#64748b; margin-top:0;">
        <?php _e('Tuliskan benefit/fasilitas per baris. Contoh:', 'hakajobs'); ?>
    </p>
    <textarea name="hakajobs_benefits" rows="6" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:8px; font-size:12px; font-family:sans-serif;" placeholder="BPJS Ketenagakerjaan&#10;BPJS Kesehatan&#10;Tunjangan Transport & Makan&#10;Bonus Kinerja Tahunan&#10;Laptop Kerja Disediakan&#10;Jam Kerja Fleksibel / Hybrid"><?php echo esc_textarea($benefits); ?></textarea>
    <small style="color:#64748b; font-size:11px; display:block; margin-top:4px;">
        <?php _e('Setiap baris baru akan ditampilkan sebagai badge benefit yang rapi.', 'hakajobs'); ?>
    </small>
    <?php
}

/**
 * Save Meta Box Data
 */
function hakajobs_save_job_meta($post_id) {
    // Check nonce
    if (!isset($_POST['hakajobs_job_meta_nonce']) || !wp_verify_nonce($_POST['hakajobs_job_meta_nonce'], 'hakajobs_job_meta_nonce_action')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save fields
    $fields = array(
        '_hakajobs_company_name'     => isset($_POST['hakajobs_company_name']) ? sanitize_text_field($_POST['hakajobs_company_name']) : '',
        '_hakajobs_company_website'  => isset($_POST['hakajobs_company_website']) ? esc_url_raw($_POST['hakajobs_company_website']) : '',
        '_hakajobs_company_location' => isset($_POST['hakajobs_company_location']) ? sanitize_text_field($_POST['hakajobs_company_location']) : '',
        '_hakajobs_postal_code'      => isset($_POST['hakajobs_postal_code']) ? sanitize_text_field($_POST['hakajobs_postal_code']) : '',
        '_hakajobs_salary'           => isset($_POST['hakajobs_salary']) ? sanitize_text_field($_POST['hakajobs_salary']) : '',
        '_hakajobs_salary_period'    => isset($_POST['hakajobs_salary_period']) ? sanitize_text_field($_POST['hakajobs_salary_period']) : 'bulan',
        '_hakajobs_deadline'         => isset($_POST['hakajobs_deadline']) ? sanitize_text_field($_POST['hakajobs_deadline']) : '',
        '_hakajobs_status'           => isset($_POST['hakajobs_status']) ? sanitize_text_field($_POST['hakajobs_status']) : 'aktif',
        '_hakajobs_is_featured'      => isset($_POST['hakajobs_is_featured']) ? '1' : '0',
        '_hakajobs_is_urgent'        => isset($_POST['hakajobs_is_urgent']) ? '1' : '0',
        '_hakajobs_apply_type'       => isset($_POST['hakajobs_apply_type']) ? sanitize_text_field($_POST['hakajobs_apply_type']) : 'whatsapp',
        '_hakajobs_apply_wa'         => isset($_POST['hakajobs_apply_wa']) ? sanitize_text_field($_POST['hakajobs_apply_wa']) : '',
        '_hakajobs_apply_wa_message' => isset($_POST['hakajobs_apply_wa_message']) ? sanitize_textarea_field($_POST['hakajobs_apply_wa_message']) : '',
        '_hakajobs_apply_email'      => isset($_POST['hakajobs_apply_email']) ? sanitize_email($_POST['hakajobs_apply_email']) : '',
        '_hakajobs_apply_email_sub'  => isset($_POST['hakajobs_apply_email_sub']) ? sanitize_text_field($_POST['hakajobs_apply_email_sub']) : '',
        '_hakajobs_apply_email_body' => isset($_POST['hakajobs_apply_email_body']) ? sanitize_textarea_field($_POST['hakajobs_apply_email_body']) : '',
        '_hakajobs_apply_url'        => isset($_POST['hakajobs_apply_url']) ? esc_url_raw($_POST['hakajobs_apply_url']) : '',
        '_hakajobs_apply_notes'      => isset($_POST['hakajobs_apply_notes']) ? sanitize_textarea_field($_POST['hakajobs_apply_notes']) : '',
        '_hakajobs_benefits'         => isset($_POST['hakajobs_benefits']) ? sanitize_textarea_field($_POST['hakajobs_benefits']) : '',
    );

    foreach ($fields as $key => $value) {
        update_post_meta($post_id, $key, $value);
    }
}
add_action('save_post_lowongan', 'hakajobs_save_job_meta');

/**
 * Auto-trim auto-generated slug to max 48-50 characters so that the entire URL
 * (home_url + /lowongan/ + slug) always strictly adheres to Rank Math's <= 75 character limit.
 */
function hakajobs_rankmath_slug_auto_truncate($slug, $post_ID, $post_status, $post_type) {
    if (!in_array($post_type, array('lowongan', 'post'))) {
        return $slug;
    }

    $max_slug_len = 48;
    if (mb_strlen($slug) > $max_slug_len) {
        $truncated = mb_substr($slug, 0, $max_slug_len);
        $last_dash  = mb_strrpos($truncated, '-');
        if ($last_dash !== false && $last_dash > 15) {
            $slug = mb_substr($truncated, 0, $last_dash);
        } else {
            $slug = $truncated;
        }
    }

    return $slug;
}
add_filter('wp_unique_post_slug', 'hakajobs_rankmath_slug_auto_truncate', 10, 4);
