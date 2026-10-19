<?php
/**
 * Custom Template Tags and Helper Functions for Hakajobs
 *
 * @package Hakajobs
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Company Logo or Generated Initials Avatar
 */
function hakajobs_get_company_logo($post_id = null, $size = 54) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $company_name = get_post_meta($post_id, '_hakajobs_company_name', true);
    if (empty($company_name)) {
        $company_name = get_the_title($post_id);
    }

    if (has_post_thumbnail($post_id)) {
        return get_the_post_thumbnail($post_id, array($size, $size), array(
            'class' => 'hk-company-logo-img',
            'alt'   => esc_attr($company_name),
            'loading' => 'lazy',
        ));
    }

    // Generate initials avatar
    $words = explode(' ', trim($company_name));
    $initials = '';
    if (count($words) >= 2) {
        $initials = mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1);
    } else {
        $initials = mb_substr($company_name, 0, 2);
    }
    $initials = strtoupper($initials);

    // Dynamic pleasant pastel color based on string hash
    $colors = array(
        array('bg' => '#eff6ff', 'text' => '#1d4ed8'),
        array('bg' => '#ecfdf5', 'text' => '#047857'),
        array('bg' => '#faf5ff', 'text' => '#7e22ce'),
        array('bg' => '#fff7ed', 'text' => '#c2410c'),
        array('bg' => '#f0fdf4', 'text' => '#15803d'),
        array('bg' => '#fef2f2', 'text' => '#b91c1c'),
        array('bg' => '#f0fdfa', 'text' => '#0f766e'),
    );
    $color_index = abs(crc32($company_name)) % count($colors);
    $selected_color = $colors[$color_index];

    return sprintf(
        '<div class="hk-company-initials" style="background-color:%s; color:%s; width:%dpx; height:%dpx; font-size:%dpx;" title="%s">%s</div>',
        esc_attr($selected_color['bg']),
        esc_attr($selected_color['text']),
        (int)$size,
        (int)$size,
        (int)($size * 0.38),
        esc_attr($company_name),
        esc_html($initials)
    );
}

/**
 * Job Type Badges (Penuh Waktu, Magang, Remote, dll.)
 */
function hakajobs_get_job_type_badges($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $terms = get_the_terms($post_id, 'tipe_pekerjaan');
    if (empty($terms) || is_wp_error($terms)) {
        return '';
    }

    $output = '<div class="hk-badges-group">';
    foreach ($terms as $term) {
        $term_slug = strtolower($term->slug);
        $badge_class = 'hk-badge-default';
        if (strpos($term_slug, 'penuh-waktu') !== false || strpos($term_slug, 'full-time') !== false) {
            $badge_class = 'hk-badge-fulltime';
        } elseif (strpos($term_slug, 'paruh-waktu') !== false || strpos($term_slug, 'part-time') !== false) {
            $badge_class = 'hk-badge-parttime';
        } elseif (strpos($term_slug, 'magang') !== false || strpos($term_slug, 'intern') !== false) {
            $badge_class = 'hk-badge-internship';
        } elseif (strpos($term_slug, 'kontrak') !== false) {
            $badge_class = 'hk-badge-contract';
        } elseif (strpos($term_slug, 'remote') !== false || strpos($term_slug, 'wfh') !== false) {
            $badge_class = 'hk-badge-remote';
        }

        $output .= sprintf(
            '<span class="hk-badge %s">%s</span>',
            esc_attr($badge_class),
            esc_html($term->name)
        );
    }
    $output .= '</div>';
    return $output;
}

/**
 * Human-friendly Indonesian Time Ago
 */
function hakajobs_time_ago($time) {
    if (is_numeric($time)) {
        $time_stamp = $time;
    } else {
        $time_stamp = strtotime($time);
    }
    $diff = current_time('timestamp') - $time_stamp;

    if ($diff < 60) {
        return __('Baru saja', 'hakajobs');
    }
    $minutes = round($diff / 60);
    if ($minutes < 60) {
        return sprintf(_n('%d menit lalu', '%d menit lalu', $minutes, 'hakajobs'), $minutes);
    }
    $hours = round($diff / 3600);
    if ($hours < 24) {
        return sprintf(_n('%d jam lalu', '%d jam lalu', $hours, 'hakajobs'), $hours);
    }
    $days = round($diff / 86400);
    if ($days < 30) {
        return sprintf(_n('%d hari lalu', '%d hari lalu', $days, 'hakajobs'), $days);
    }
    $months = round($diff / 2592000);
    if ($months < 12) {
        return sprintf(_n('%d bulan lalu', '%d bulan lalu', $months, 'hakajobs'), $months);
    }
    $years = round($diff / 31536000);
    return sprintf(_n('%d tahun lalu', '%d tahun lalu', $years, 'hakajobs'), $years);
}

/**
 * Format WhatsApp Number to International 628...
 */
function hakajobs_format_whatsapp_number($phone) {
    // Remove non-digit characters
    $clean = preg_replace('/[^0-9]/', '', $phone);
    if (empty($clean)) {
        return '';
    }
    // If starts with 08, change to 628
    if (substr($clean, 0, 2) === '08') {
        $clean = '62' . substr($clean, 1);
    } elseif (substr($clean, 0, 1) === '8') {
        $clean = '628' . substr($clean, 1);
    }
    return $clean;
}

/**
 * Helper to replace dynamic placeholders in job application templates
 * Supported tags: {posisi}, {job_title}, {title}, {perusahaan}, {company}, {company_name}, {website}, {site_name}, {nama_website}, {link}, {url}, {permalink}
 *
 * @param string $text
 * @param int $post_id
 * @return string
 */
function hakajobs_replace_template_tags($text, $post_id) {
    if (empty($text)) {
        return '';
    }
    $post_title   = html_entity_decode(get_the_title($post_id), ENT_QUOTES, 'UTF-8');
    $company_name = get_post_meta($post_id, '_hakajobs_company_name', true);
    if (empty($company_name)) {
        $company_name = __('Perusahaan', 'hakajobs');
    }
    $site_name = get_bloginfo('name');
    $permalink = get_permalink($post_id);

    $tags = array(
        '{posisi}'        => $post_title,
        '{job_title}'     => $post_title,
        '{title}'         => $post_title,
        '{perusahaan}'    => $company_name,
        '{company}'       => $company_name,
        '{company_name}'  => $company_name,
        '{website}'       => $site_name,
        '{site_name}'     => $site_name,
        '{nama_website}'  => $site_name,
        '{link}'          => $permalink,
        '{url}'           => $permalink,
        '{permalink}'     => $permalink,
    );

    // Legacy hardcoded strings replacement
    $legacy_search = array(
        'website Hakajobs',
        'website "Hakajobs"',
        'website HakaJob',
        'website "HakaJob"',
        'di Hakajobs',
        'di HakaJob',
    );
    $legacy_replace = array(
        'website "' . $site_name . '"',
        'website "' . $site_name . '"',
        'website "' . $site_name . '"',
        'website "' . $site_name . '"',
        'di website "' . $site_name . '"',
        'di website "' . $site_name . '"',
    );

    $text = str_ireplace($legacy_search, $legacy_replace, $text);
    return str_replace(array_keys($tags), array_values($tags), $text);
}

/**
 * Professional default WhatsApp application message
 *
 * @param int $post_id
 * @return string
 */
function hakajobs_get_default_apply_wa_message($post_id) {
    $post_title   = html_entity_decode(get_the_title($post_id), ENT_QUOTES, 'UTF-8');
    $company_name = get_post_meta($post_id, '_hakajobs_company_name', true);
    if (empty($company_name)) {
        $company_name = __('Perusahaan', 'hakajobs');
    }
    $site_name = get_bloginfo('name');
    $permalink = get_permalink($post_id);

    $msg  = sprintf("Halo Tim Rekrutmen %s,\n\n", $company_name);
    $msg .= sprintf("Saya membaca informasi lowongan pekerjaan di website %s dan bermaksud untuk melamar posisi berikut:\n\n", $site_name);
    $msg .= "📋 *Detail Lamaran:*\n";
    $msg .= sprintf("• Posisi: *%s*\n", $post_title);
    $msg .= sprintf("• Perusahaan: %s\n", $company_name);
    $msg .= sprintf("• Referensi Info Loker: %s\n\n", $permalink);
    $msg .= "👤 *Ringkasan Data Singkat:*\n";
    $msg .= "• Nama Lengkap: [Nama Anda]\n";
    $msg .= "• Domisili: [Kota/Daerah Domisili]\n";
    $msg .= "• Pendidikan / Pengalaman Terakhir: [Pendidikan / Pengalaman Terakhir]\n\n";
    $msg .= "Saya telah menyiapkan berkas lamaran (CV dan dokumen pendukung). Apakah berkas dapat saya kirimkan melalui chat WhatsApp ini atau via email resmi rekrutmen?\n\n";
    $msg .= "Terima kasih atas waktu dan kesempatan yang diberikan.";

    return $msg;
}

/**
 * Professional default application email subject
 *
 * @param int $post_id
 * @return string
 */
function hakajobs_get_default_apply_email_subject($post_id) {
    $post_title = html_entity_decode(get_the_title($post_id), ENT_QUOTES, 'UTF-8');
    return sprintf('Lamaran Pekerjaan: %s - [Nama Lengkap Anda]', $post_title);
}

/**
 * Professional default application email body
 *
 * @param int $post_id
 * @return string
 */
function hakajobs_get_default_apply_email_body($post_id) {
    $post_title   = html_entity_decode(get_the_title($post_id), ENT_QUOTES, 'UTF-8');
    $company_name = get_post_meta($post_id, '_hakajobs_company_name', true);
    if (empty($company_name)) {
        $company_name = __('Perusahaan', 'hakajobs');
    }
    $site_name = get_bloginfo('name');
    $permalink = get_permalink($post_id);

    $body  = "Kepada Yth.\n";
    $body .= sprintf("Tim Rekrutmen / HRD %s\n", $company_name);
    $body .= "di Tempat\n\n";
    $body .= "Dengan hormat,\n\n";
    $body .= sprintf("Sehubungan dengan informasi lowongan pekerjaan untuk posisi %s yang saya temukan melalui situs %s (%s), bersama email ini saya bermaksud untuk mengajukan diri guna mengisi posisi tersebut.\n\n", $post_title, $site_name, $permalink);
    $body .= "Berikut adalah ringkasan singkat profil saya:\n";
    $body .= "• Nama Lengkap: [Nama Lengkap Anda]\n";
    $body .= "• Nomor WhatsApp / HP: [Nomor HP/WA Aktif]\n";
    $body .= "• Kota Domisili: [Kota Domisili]\n";
    $body .= "• Pendidikan Terakhir: [Pendidikan Terakhir / Jurusan]\n";
    $body .= "• Keahlian / Pengalaman Relevan: [Sebutkan 1-2 keahlian utama atau pengalaman kerja relevan]\n\n";
    $body .= "Sebagai bahan pertimbangan Bapak/Ibu, bersama surat lamaran ini turut saya lampirkan berkas kelengkapan:\n";
    $body .= "1. Curriculum Vitae (CV) Terbaru\n";
    $body .= "2. Portofolio Pekerjaan\n";
    $body .= "3. Dokumen Pendukung Lainnya\n\n";
    $body .= "Besar harapan saya untuk memperoleh kesempatan wawancara agar dapat menjelaskan kualifikasi, pengalaman kerja, dan motivasi saya secara lebih terperinci.\n\n";
    $body .= "Demikian surat permohonan ini saya sampaikan. Atas perhatian dan kesempatan yang diberikan oleh Bapak/Ibu, saya ucapkan terima kasih.\n\n\n";
    $body .= "Hormat saya,\n\n";
    $body .= "[Nama Lengkap Anda]\n";
    $body .= "[Nomor WhatsApp / HP Aktif]\n";
    $body .= "[Tautan Profil LinkedIn / Portofolio]";

    return $body;
}

/**
 * Build Direct Apply Link (WhatsApp, Email, or Web URL)
 */
function hakajobs_get_apply_info($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $apply_type        = get_post_meta($post_id, '_hakajobs_apply_type', true);
    $apply_wa          = get_post_meta($post_id, '_hakajobs_apply_wa', true);
    $apply_wa_message  = get_post_meta($post_id, '_hakajobs_apply_wa_message', true);
    $apply_email       = get_post_meta($post_id, '_hakajobs_apply_email', true);
    $apply_email_sub   = get_post_meta($post_id, '_hakajobs_apply_email_sub', true);
    $apply_url         = get_post_meta($post_id, '_hakajobs_apply_url', true);
    $status            = get_post_meta($post_id, '_hakajobs_status', true);
    $deadline          = get_post_meta($post_id, '_hakajobs_deadline', true);

    $is_expired = false;
    if (!empty($deadline)) {
        $deadline_ts = strtotime($deadline . ' 23:59:59');
        if ($deadline_ts && $deadline_ts < current_time('timestamp')) {
            $is_expired = true;
        }
    }

    $is_closed = ($status === 'tutup' || $is_expired);

    $info = array(
        'type'        => $apply_type ? $apply_type : 'whatsapp',
        'is_closed'   => $is_closed,
        'link'        => '#',
        'target'      => '_self',
        'label'       => __('Lamar Sekarang', 'hakajobs'),
        'icon'        => 'send',
        'channel'     => 'Website',
    );

    if ($is_closed) {
        $info['label'] = __('Lowongan Telah Ditutup', 'hakajobs');
        $info['link'] = 'javascript:void(0);';
        return $info;
    }

    $post_title = get_the_title($post_id);
    $company_name = get_post_meta($post_id, '_hakajobs_company_name', true);
    $permalink = get_permalink($post_id);
    $site_name = get_bloginfo('name');

    if ($apply_type === 'whatsapp' && !empty($apply_wa)) {
        $formatted_phone = hakajobs_format_whatsapp_number($apply_wa);

        $legacy_old_default = sprintf('Halo Tim HRD, saya melihat lowongan pekerjaan di website "%s" dan tertarik untuk melamar posisi ini. Mohon informasi berkas yang perlu saya kirimkan. Terima kasih.', $site_name);
        $is_legacy = (trim($apply_wa_message) === trim($legacy_old_default) || trim($apply_wa_message) === 'Halo Tim HRD, saya melihat lowongan pekerjaan di website "Hakajobs" dan tertarik untuk melamar posisi ini. Mohon informasi berkas yang perlu saya kirimkan. Terima kasih.');

        if (empty($apply_wa_message) || $is_legacy) {
            $default_msg = hakajobs_get_default_apply_wa_message($post_id);
        } else {
            $default_msg = hakajobs_replace_template_tags($apply_wa_message, $post_id);
        }

        $encoded_msg = rawurlencode($default_msg);
        $info['link'] = 'https://api.whatsapp.com/send?phone=' . esc_attr($formatted_phone) . '&text=' . $encoded_msg;
        $info['target'] = '_blank';
        $info['label'] = __('Lamar via WhatsApp HRD', 'hakajobs');
        $info['icon'] = 'whatsapp';
        $info['channel'] = 'WhatsApp';
    } elseif ($apply_type === 'email' && !empty($apply_email)) {
        $apply_email_body = get_post_meta($post_id, '_hakajobs_apply_email_body', true);

        if (empty($apply_email_sub)) {
            $subject = hakajobs_get_default_apply_email_subject($post_id);
        } else {
            $subject = hakajobs_replace_template_tags($apply_email_sub, $post_id);
        }

        if (empty($apply_email_body)) {
            $body = hakajobs_get_default_apply_email_body($post_id);
        } else {
            $body = hakajobs_replace_template_tags($apply_email_body, $post_id);
        }

        $info['link'] = 'mailto:' . esc_attr($apply_email) . '?subject=' . rawurlencode($subject) . '&body=' . rawurlencode($body);
        $info['label'] = __('Kirim Email Lamaran', 'hakajobs');
        $info['icon'] = 'mail';
        $info['channel'] = 'Email';
    } elseif (!empty($apply_url)) {
        $info['link'] = esc_url($apply_url);
        $info['target'] = '_blank';
        $info['label'] = __('Lamar di Situs Resmi', 'hakajobs');
        $info['icon'] = 'external-link';
        $info['channel'] = 'Portal Perusahaan';
    }

    return $info;
}

/**
 * Post View Counter Helper
 */
function hakajobs_get_views($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $views = (int)get_post_meta($post_id, '_hakajobs_views_count', true);
    return $views;
}

function hakajobs_set_views($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    if (!is_single($post_id)) {
        return;
    }
    $views = (int)get_post_meta($post_id, '_hakajobs_views_count', true);
    $views++;
    update_post_meta($post_id, '_hakajobs_views_count', $views);
}

/**
 * Calculate job deadline expiry, remaining days, and status badges
 *
 * @param int $post_id
 * @return array
 */
function hakajobs_get_job_expiry_data($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $deadline = get_post_meta($post_id, '_hakajobs_deadline', true);
    $status   = get_post_meta($post_id, '_hakajobs_status', true);

    $is_expired   = false;
    $is_closed    = false;
    $is_urgent    = false; // 0 to 3 days remaining
    $days_left    = null;
    $deadline_ts  = 0;
    $now_ts       = current_time('timestamp');

    if (!empty($deadline)) {
        // Akhir hari deadline (23:59:59 pada zona waktu lokal WordPress)
        $deadline_ts = strtotime($deadline . ' 23:59:59');
        if ($deadline_ts) {
            if ($deadline_ts < $now_ts) {
                $is_expired = true;
            } else {
                $diff_sec  = $deadline_ts - $now_ts;
                $days_left = max(0, (int)ceil($diff_sec / 86400));
                if ($days_left <= 3) {
                    $is_urgent = true;
                }
            }
        }
    }

    // Ditutup jika status manual = 'tutup' ATAU waktu deadline sudah lewat
    if ($status === 'tutup' || $is_expired) {
        $is_closed = true;
    }

    // Tentukan label dan class badge
    $badge_class = 'hk-pill-open';
    $badge_label = __('Rekrutmen Aktif', 'hakajobs');

    if ($is_closed) {
        $badge_class = 'hk-pill-closed';
        $badge_label = __('Pendaftaran Ditutup', 'hakajobs');
    } elseif ($is_urgent) {
        $badge_class = 'hk-pill-expiring';
        if ($days_left === 0) {
            $badge_label = __('Hari Terakhir!', 'hakajobs');
        } elseif ($days_left === 1) {
            $badge_label = __('Sisa 1 Hari', 'hakajobs');
        } else {
            $badge_label = sprintf(__('Sisa %d Hari', 'hakajobs'), $days_left);
        }
    }

    return array(
        'deadline'        => $deadline,
        'deadline_ts'     => $deadline_ts,
        'deadline_format' => !empty($deadline) ? date_i18n('d F Y', strtotime($deadline)) : '',
        'is_expired'      => $is_expired,
        'is_closed'       => $is_closed,
        'is_urgent'       => $is_urgent,
        'days_left'       => $days_left,
        'badge_class'     => $badge_class,
        'badge_label'     => $badge_label,
    );
}

/**
 * Reusable Job Card HTML
 */
function hakajobs_render_job_card($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $company_name     = get_post_meta($post_id, '_hakajobs_company_name', true);
    $company_location = get_post_meta($post_id, '_hakajobs_company_location', true);
    $salary           = get_post_meta($post_id, '_hakajobs_salary', true);
    $salary_period    = get_post_meta($post_id, '_hakajobs_salary_period', true);
    $deadline         = get_post_meta($post_id, '_hakajobs_deadline', true);
    $status           = get_post_meta($post_id, '_hakajobs_status', true);
    $is_featured      = get_post_meta($post_id, '_hakajobs_is_featured', true);
    $is_urgent        = get_post_meta($post_id, '_hakajobs_is_urgent', true);

    $terms_location   = get_the_terms($post_id, 'lokasi_lowongan');
    $location_label   = (!empty($terms_location) && !is_wp_error($terms_location)) ? $terms_location[0]->name : $company_location;
    if (empty($location_label)) {
        $location_label = __('Indonesia', 'hakajobs');
    }

    $terms_category   = get_the_terms($post_id, 'kategori_lowongan');
    $category_label   = (!empty($terms_category) && !is_wp_error($terms_category)) ? $terms_category[0]->name : '';

    $exp       = hakajobs_get_job_expiry_data($post_id);
    $is_closed = $exp['is_closed'];

    $apply_info = hakajobs_get_apply_info($post_id);
    ?>
    <article class="hk-job-card <?php echo ($is_featured === '1') ? 'hk-job-featured' : ''; ?> <?php echo $is_closed ? 'hk-job-closed' : ''; ?>" data-id="<?php echo esc_attr($post_id); ?>" data-title="<?php echo esc_attr(get_the_title($post_id)); ?>" data-company="<?php echo esc_attr($company_name); ?>" data-url="<?php echo esc_url(get_permalink($post_id)); ?>">
        
        <div class="hk-job-card-top">
            <div class="hk-company-logo-wrap">
                <a href="<?php the_permalink($post_id); ?>" tabindex="-1" aria-hidden="true">
                    <?php echo hakajobs_get_company_logo($post_id, 52); ?>
                </a>
            </div>

            <div class="hk-job-card-main">
                <div class="hk-job-card-header">
                    <span class="hk-card-company"><?php echo esc_html($company_name ? $company_name : get_bloginfo('name')); ?></span>
                    
                    <div class="hk-card-status-badges">
                        <?php if ($exp['is_closed']): ?>
                            <span class="hk-pill hk-pill-closed"><?php _e('Pendaftaran Ditutup', 'hakajobs'); ?></span>
                        <?php else: ?>
                            <?php if ($exp['is_urgent']): ?>
                                <span class="hk-pill hk-pill-expiring" title="<?php esc_attr_e('Batas akhir penerimaan lamaran segera berakhir', 'hakajobs'); ?>">
                                    ⏳ <?php echo esc_html($exp['badge_label']); ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($is_urgent === '1'): ?>
                                <span class="hk-pill hk-pill-urgent">🔥 <?php _e('Urgent', 'hakajobs'); ?></span>
                            <?php endif; ?>
                            <?php if ($is_featured === '1'): ?>
                                <span class="hk-pill hk-pill-featured">⭐ <?php _e('Sorotan', 'hakajobs'); ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <h3 class="hk-job-title">
                    <a href="<?php the_permalink($post_id); ?>"><?php echo esc_html(get_the_title($post_id)); ?></a>
                </h3>

                <div class="hk-job-meta-row">
                    <span class="hk-meta-item">
                        <svg class="hk-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <?php echo esc_html($location_label); ?>
                    </span>

                    <?php if (!empty($salary)): ?>
                        <span class="hk-meta-item hk-salary-highlight">
                            <svg class="hk-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="6" width="20" height="12" rx="2"></rect><circle cx="12" cy="12" r="2"></circle><path d="M6 12h.01M18 12h.01"></path></svg>
                            <?php echo esc_html($salary); ?>
                        </span>
                    <?php endif; ?>

                    <?php if (!empty($category_label)): ?>
                        <span class="hk-meta-item hk-category-tag">
                            <?php echo esc_html($category_label); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="hk-job-tags-row">
                    <?php echo hakajobs_get_job_type_badges($post_id); ?>
                </div>
            </div>
        </div>

        <div class="hk-job-card-footer">
            <div class="hk-card-footer-info">
                <span class="hk-post-time">
                    <svg class="hk-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <?php echo hakajobs_time_ago(get_post_time('U', false, $post_id)); ?>
                </span>

                <?php if ($exp['is_closed']): ?>
                    <span class="hk-deadline-tag hk-deadline-closed">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>
                        <?php _e('Pendaftaran Ditutup', 'hakajobs'); ?>
                    </span>
                <?php elseif (!empty($deadline)): ?>
                    <span class="hk-deadline-tag <?php echo $exp['is_urgent'] ? 'hk-deadline-urgent' : ''; ?>">
                        <?php if ($exp['is_urgent']): ?>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            <?php echo sprintf(__('Segera Berakhir: Sisa %d Hari (%s)', 'hakajobs'), (int)$exp['days_left'], esc_html(date_i18n('d M', strtotime($deadline)))); ?>
                        <?php else: ?>
                            Batas: <?php echo esc_html(date_i18n('d M Y', strtotime($deadline))); ?>
                        <?php endif; ?>
                    </span>
                <?php endif; ?>
            </div>

            <div class="hk-card-actions">
                <button type="button" class="hk-btn-bookmark" data-job-id="<?php echo esc_attr($post_id); ?>" title="<?php esc_attr_e('Simpan Lowongan ke Browser', 'hakajobs'); ?>" aria-label="<?php esc_attr_e('Simpan Lowongan', 'hakajobs'); ?>">
                    <svg class="hk-bookmark-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
                </button>

                <a href="<?php the_permalink($post_id); ?>" class="hk-btn hk-btn-detail">
                    <?php _e('Lihat Detail', 'hakajobs'); ?>
                </a>

                <?php if (!$exp['is_closed']): ?>
                    <a href="<?php echo esc_url($apply_info['link']); ?>" target="<?php echo esc_attr($apply_info['target']); ?>" class="hk-btn hk-btn-quick-apply <?php echo ($apply_info['channel'] === 'WhatsApp') ? 'hk-btn-wa' : ''; ?>" rel="nofollow">
                        <?php echo esc_html($apply_info['label']); ?>
                    </a>
                <?php else: ?>
                    <span class="hk-btn-closed-pill" title="<?php esc_attr_e('Pendaftaran untuk lowongan ini telah ditutup', 'hakajobs'); ?>">
                        <?php _e('Ditutup', 'hakajobs'); ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>

    </article>
    <?php
}

/**
 * Breadcrumb Navigation
 */
function hakajobs_breadcrumbs() {
    if (is_front_page()) {
        return;
    }

    echo '<nav class="hk-breadcrumbs" aria-label="' . esc_attr__('Navigasi remah roti', 'hakajobs') . '">';
    echo '<div class="hk-container">';
    echo '<ol class="hk-breadcrumbs-list" itemscope itemtype="https://schema.org/BreadcrumbList">';

    echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
    echo '<a itemprop="item" href="' . esc_url(home_url('/')) . '"><span itemprop="name">' . __('Beranda', 'hakajobs') . '</span></a>';
    echo '<meta itemprop="position" content="1" />';
    echo '</li>';

    $position = 2;

    if (is_singular('lowongan')) {
        echo '<li class="hk-breadcrumbs-sep">/</li>';
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<a itemprop="item" href="' . esc_url(get_post_type_archive_link('lowongan')) . '"><span itemprop="name">' . __('Lowongan Kerja', 'hakajobs') . '</span></a>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
        $position++;

        $terms = get_the_terms(get_the_ID(), 'kategori_lowongan');
        if (!empty($terms) && !is_wp_error($terms)) {
            $cat = $terms[0];
            echo '<li class="hk-breadcrumbs-sep">/</li>';
            echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<a itemprop="item" href="' . esc_url(get_term_link($cat)) . '"><span itemprop="name">' . esc_html($cat->name) . '</span></a>';
            echo '<meta itemprop="position" content="' . $position . '" />';
            echo '</li>';
            $position++;
        }

        echo '<li class="hk-breadcrumbs-sep">/</li>';
        echo '<li class="hk-current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . esc_html(wp_trim_words(get_the_title(), 5, '...')) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } elseif (is_post_type_archive('lowongan')) {
        echo '<li class="hk-breadcrumbs-sep">/</li>';
        echo '<li class="hk-current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . __('Semua Lowongan Kerja', 'hakajobs') . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } elseif (is_tax()) {
        $term = get_queried_object();
        echo '<li class="hk-breadcrumbs-sep">/</li>';
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<a itemprop="item" href="' . esc_url(get_post_type_archive_link('lowongan')) . '"><span itemprop="name">' . __('Lowongan', 'hakajobs') . '</span></a>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
        $position++;

        echo '<li class="hk-breadcrumbs-sep">/</li>';
        echo '<li class="hk-current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . esc_html($term->name) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } elseif (is_search()) {
        echo '<li class="hk-breadcrumbs-sep">/</li>';
        echo '<li class="hk-current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . sprintf(__('Hasil Pencarian: "%s"', 'hakajobs'), esc_html(get_search_query())) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } elseif (is_page()) {
        echo '<li class="hk-breadcrumbs-sep">/</li>';
        echo '<li class="hk-current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . esc_html(get_the_title()) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    }

    echo '</ol>';
    echo '</div>';
    echo '</nav>';
}

/**
 * Output Google JobPosting JSON-LD Schema for SEO
 */
function hakajobs_schema_job_posting() {
    if (!is_singular('lowongan')) {
        return;
    }

    $post_id          = get_the_ID();
    $company_name     = get_post_meta($post_id, '_hakajobs_company_name', true);
    $company_website  = get_post_meta($post_id, '_hakajobs_company_website', true);
    $company_location = get_post_meta($post_id, '_hakajobs_company_location', true);
    $salary           = get_post_meta($post_id, '_hakajobs_salary', true);
    $deadline         = get_post_meta($post_id, '_hakajobs_deadline', true);
    $status           = get_post_meta($post_id, '_hakajobs_status', true);

    $terms_location   = get_the_terms($post_id, 'lokasi_lowongan');
    $city             = (!empty($terms_location) && !is_wp_error($terms_location)) ? $terms_location[0]->name : 'Indonesia';

    $terms_type       = get_the_terms($post_id, 'tipe_pekerjaan');
    $employment_type  = 'FULL_TIME';
    if (!empty($terms_type) && !is_wp_error($terms_type)) {
        $slug = $terms_type[0]->slug;
        if (strpos($slug, 'part') !== false || strpos($slug, 'paruh') !== false) {
            $employment_type = 'PART_TIME';
        } elseif (strpos($slug, 'kontrak') !== false) {
            $employment_type = 'CONTRACTOR';
        } elseif (strpos($slug, 'magang') !== false || strpos($slug, 'intern') !== false) {
            $employment_type = 'INTERN';
        } elseif (strpos($slug, 'free') !== false) {
            $employment_type = 'FREELANCE';
        }
    }

    $clean_content = wp_strip_all_tags(get_post_field('post_content', $post_id));
    if (empty($clean_content)) {
        $clean_content = get_the_title($post_id) . ' di ' . ($company_name ? $company_name : get_bloginfo('name'));
    }

    $schema = array(
        '@context'        => 'https://schema.org/',
        '@type'           => 'JobPosting',
        'title'           => get_the_title($post_id),
        'description'     => esc_html($clean_content),
        'datePosted'      => get_the_date('c', $post_id),
        'employmentType'  => $employment_type,
        'hiringOrganization' => array(
            '@type' => 'Organization',
            'name'  => $company_name ? $company_name : get_bloginfo('name'),
            'sameAs' => $company_website ? esc_url($company_website) : home_url(),
        ),
        'jobLocation'     => array(
            '@type'   => 'Place',
            'address' => array(
                '@type'           => 'PostalAddress',
                'addressLocality' => $city,
                'addressRegion'   => $city,
                'addressCountry'  => 'ID',
            ),
        ),
    );

    if (has_post_thumbnail($post_id)) {
        $schema['hiringOrganization']['logo'] = get_the_post_thumbnail_url($post_id, 'full');
    }

    if (!empty($deadline)) {
        $schema['validThrough'] = date('c', strtotime($deadline . ' 23:59:59'));
    }

    echo "\n<!-- Schema.org JobPosting by Hakajobs -->\n";
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
}
add_action('wp_head', 'hakajobs_schema_job_posting');

/**
 * Generate formatted broadcast text for WhatsApp Channel / Groups
 *
 * @param int $post_id
 * @return string
 */
function hakajobs_get_wa_broadcast_text($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $title       = html_entity_decode(get_the_title($post_id), ENT_QUOTES, 'UTF-8');
    $company     = get_post_meta($post_id, '_hakajobs_company_name', true);
    if (empty($company)) {
        $company = get_bloginfo('name');
    }

    $salary      = get_post_meta($post_id, '_hakajobs_salary', true);
    $deadline    = get_post_meta($post_id, '_hakajobs_deadline', true);
    $location    = get_post_meta($post_id, '_hakajobs_company_location', true);

    $terms_loc   = get_the_terms($post_id, 'lokasi_lowongan');
    if (!empty($terms_loc) && !is_wp_error($terms_loc)) {
        $location = $terms_loc[0]->name;
    }
    if (empty($location)) {
        $location = 'Indonesia';
    }

    $terms_type  = get_the_terms($post_id, 'tipe_pekerjaan');
    $type_name   = (!empty($terms_type) && !is_wp_error($terms_type)) ? $terms_type[0]->name : '';

    $terms_edu   = get_the_terms($post_id, 'pendidikan_terakhir');
    $edu_name    = (!empty($terms_edu) && !is_wp_error($terms_edu)) ? $terms_edu[0]->name : '';

    $permalink   = get_permalink($post_id);
    $channel_url = get_theme_mod('hakajobs_wa_channel_url', '');
    $channel_name= get_theme_mod('hakajobs_wa_channel_name', __('Saluran WhatsApp Kami', 'hakajobs'));
    $heading     = get_theme_mod('hakajobs_wa_broadcast_heading', '📢 LOWONGAN KERJA TERBARU');

    $msg = '*' . trim($heading) . "*\n";
    $msg .= "━━━━━━━━━━━━━━━━━━━━\n\n";
    $msg .= "🏢 *Perusahaan* : " . $company . "\n";
    $msg .= "💼 *Posisi*     : " . $title . "\n";
    $msg .= "📍 *Lokasi*     : " . $location . "\n";

    if (!empty($type_name)) {
        $msg .= "🕒 *Tipe Kerja* : " . $type_name . "\n";
    }

    if (!empty($edu_name)) {
        $msg .= "🎓 *Pendidikan* : " . $edu_name . "\n";
    }

    if (!empty($salary)) {
        $msg .= "💰 *Kisaran Gaji*: " . $salary . "\n";
    }

    if (!empty($deadline)) {
        $deadline_ts = strtotime($deadline);
        if ($deadline_ts) {
            $msg .= "⏳ *Batas Akhir*: " . date_i18n('d F Y', $deadline_ts) . "\n";
        }
    }

    $msg .= "\n📝 *Detail Lengkap & Cara Melamar:*\n";
    $msg .= "👉 " . $permalink . "\n\n";
    $msg .= "⚠️ *Catatan:* Proses rekrutmen ini TIDAK dipungut biaya apapun (GRATIS). Waspada terhadap segala bentuk penipuan.\n";

    if (!empty($channel_url)) {
        $msg .= "━━━━━━━━━━━━━━━━━━━━\n";
        $msg .= "📲 *Gabung " . $channel_name . " untuk update loker harian:*\n";
        $msg .= "👉 " . esc_url($channel_url) . "\n";
    }

    return $msg;
}

/**
 * Generate WhatsApp Share URL with pre-filled broadcast text
 *
 * @param int $post_id
 * @return string
 */
function hakajobs_get_wa_broadcast_url($post_id = null) {
    $text = hakajobs_get_wa_broadcast_text($post_id);
    return 'https://api.whatsapp.com/send?text=' . rawurlencode($text);
}

