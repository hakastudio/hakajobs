<?php
/**
 * Register Custom Post Types & Taxonomies for Hakajobs
 *
 * @package Hakajobs
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register 'lowongan' custom post type
 */
function hakajobs_register_post_types() {
    $labels = array(
        'name'                  => _x('Lowongan Kerja', 'Post Type General Name', 'hakajobs'),
        'singular_name'         => _x('Lowongan', 'Post Type Singular Name', 'hakajobs'),
        'menu_name'             => __('Lowongan Kerja', 'hakajobs'),
        'name_admin_bar'        => __('Lowongan Kerja', 'hakajobs'),
        'archives'              => __('Arsip Lowongan', 'hakajobs'),
        'attributes'            => __('Atribut Lowongan', 'hakajobs'),
        'parent_item_colon'     => __('Induk Lowongan:', 'hakajobs'),
        'all_items'             => __('Semua Lowongan', 'hakajobs'),
        'add_new_item'          => __('Tambah Lowongan Baru', 'hakajobs'),
        'add_new'               => __('Tambah Baru', 'hakajobs'),
        'new_item'              => __('Lowongan Baru', 'hakajobs'),
        'edit_item'             => __('Edit Lowongan', 'hakajobs'),
        'update_item'           => __('Perbarui Lowongan', 'hakajobs'),
        'view_item'             => __('Lihat Lowongan', 'hakajobs'),
        'view_items'            => __('Lihat Semua Lowongan', 'hakajobs'),
        'search_items'          => __('Cari Lowongan', 'hakajobs'),
        'not_found'             => __('Tidak ada lowongan ditemukan', 'hakajobs'),
        'not_found_in_trash'    => __('Tidak ada lowongan di tempat sampah', 'hakajobs'),
        'featured_image'        => __('Logo Perusahaan / Banner', 'hakajobs'),
        'set_featured_image'    => __('Pilih Logo Perusahaan', 'hakajobs'),
        'remove_featured_image' => __('Hapus Logo', 'hakajobs'),
        'use_featured_image'    => __('Gunakan sebagai logo', 'hakajobs'),
        'insert_into_item'      => __('Sisipkan ke lowongan', 'hakajobs'),
        'uploaded_to_this_item' => __('Diunggah untuk lowongan ini', 'hakajobs'),
        'items_list'            => __('Daftar Lowongan', 'hakajobs'),
        'items_list_navigation' => __('Navigasi daftar lowongan', 'hakajobs'),
        'filter_items_list'     => __('Filter daftar lowongan', 'hakajobs'),
    );

    $args = array(
        'label'                 => __('Lowongan', 'hakajobs'),
        'description'           => __('Posting lowongan kerja', 'hakajobs'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'taxonomies'            => array('kategori_lowongan', 'lokasi_lowongan', 'tipe_pekerjaan', 'pengalaman_kerja', 'pendidikan_terakhir'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-businessman',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'rewrite'               => array('slug' => 'lowongan', 'with_front' => false),
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type('lowongan', $args);
}
add_action('init', 'hakajobs_register_post_types', 0);

/**
 * Register Taxonomies
 */
function hakajobs_register_taxonomies() {
    // 1. Kategori Lowongan (Bidang Pekerjaan)
    $cat_labels = array(
        'name'              => _x('Kategori Pekerjaan', 'taxonomy general name', 'hakajobs'),
        'singular_name'     => _x('Kategori Pekerjaan', 'taxonomy singular name', 'hakajobs'),
        'search_items'      => __('Cari Kategori', 'hakajobs'),
        'all_items'         => __('Semua Kategori', 'hakajobs'),
        'parent_item'       => __('Induk Kategori', 'hakajobs'),
        'parent_item_colon' => __('Induk Kategori:', 'hakajobs'),
        'edit_item'         => __('Edit Kategori', 'hakajobs'),
        'update_item'       => __('Perbarui Kategori', 'hakajobs'),
        'add_new_item'      => __('Tambah Kategori Baru', 'hakajobs'),
        'new_item_name'     => __('Nama Kategori Baru', 'hakajobs'),
        'menu_name'         => __('Kategori', 'hakajobs'),
    );
    register_taxonomy('kategori_lowongan', array('lowongan'), array(
        'hierarchical'      => true,
        'labels'            => $cat_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'kategori-loker'),
        'show_in_rest'      => true,
    ));

    // 2. Lokasi Pekerjaan (Kota / Wilayah)
    $loc_labels = array(
        'name'              => _x('Lokasi / Kota', 'taxonomy general name', 'hakajobs'),
        'singular_name'     => _x('Lokasi', 'taxonomy singular name', 'hakajobs'),
        'search_items'      => __('Cari Lokasi', 'hakajobs'),
        'all_items'         => __('Semua Lokasi', 'hakajobs'),
        'edit_item'         => __('Edit Lokasi', 'hakajobs'),
        'update_item'       => __('Perbarui Lokasi', 'hakajobs'),
        'add_new_item'      => __('Tambah Lokasi Baru', 'hakajobs'),
        'new_item_name'     => __('Nama Lokasi Baru', 'hakajobs'),
        'menu_name'         => __('Lokasi Kota', 'hakajobs'),
    );
    register_taxonomy('lokasi_lowongan', array('lowongan'), array(
        'hierarchical'      => true,
        'labels'            => $loc_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'lokasi-loker'),
        'show_in_rest'      => true,
    ));

    // 3. Tipe Pekerjaan (Penuh Waktu, Paruh Waktu, Kontrak, Magang, Freelance, Remote)
    $type_labels = array(
        'name'              => _x('Tipe Pekerjaan', 'taxonomy general name', 'hakajobs'),
        'singular_name'     => _x('Tipe Pekerjaan', 'taxonomy singular name', 'hakajobs'),
        'search_items'      => __('Cari Tipe', 'hakajobs'),
        'all_items'         => __('Semua Tipe', 'hakajobs'),
        'edit_item'         => __('Edit Tipe', 'hakajobs'),
        'update_item'       => __('Perbarui Tipe', 'hakajobs'),
        'add_new_item'      => __('Tambah Tipe Baru', 'hakajobs'),
        'menu_name'         => __('Tipe Pekerjaan', 'hakajobs'),
    );
    register_taxonomy('tipe_pekerjaan', array('lowongan'), array(
        'hierarchical'      => false,
        'labels'            => $type_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'tipe-loker'),
        'show_in_rest'      => true,
    ));

    // 4. Pengalaman Kerja
    $exp_labels = array(
        'name'              => _x('Tingkat Pengalaman', 'taxonomy general name', 'hakajobs'),
        'singular_name'     => _x('Pengalaman', 'taxonomy singular name', 'hakajobs'),
        'all_items'         => __('Semua Pengalaman', 'hakajobs'),
        'edit_item'         => __('Edit Pengalaman', 'hakajobs'),
        'add_new_item'      => __('Tambah Pengalaman', 'hakajobs'),
        'menu_name'         => __('Pengalaman', 'hakajobs'),
    );
    register_taxonomy('pengalaman_kerja', array('lowongan'), array(
        'hierarchical'      => false,
        'labels'            => $exp_labels,
        'show_ui'           => true,
        'show_admin_column' => false,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'pengalaman'),
        'show_in_rest'      => true,
    ));

    // 5. Pendidikan Terakhir
    $edu_labels = array(
        'name'              => _x('Pendidikan', 'taxonomy general name', 'hakajobs'),
        'singular_name'     => _x('Pendidikan', 'taxonomy singular name', 'hakajobs'),
        'all_items'         => __('Semua Pendidikan', 'hakajobs'),
        'edit_item'         => __('Edit Pendidikan', 'hakajobs'),
        'add_new_item'      => __('Tambah Pendidikan', 'hakajobs'),
        'menu_name'         => __('Pendidikan', 'hakajobs'),
    );
    register_taxonomy('pendidikan_terakhir', array('lowongan'), array(
        'hierarchical'      => false,
        'labels'            => $edu_labels,
        'show_ui'           => true,
        'show_admin_column' => false,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'pendidikan'),
        'show_in_rest'      => true,
    ));
}
add_action('init', 'hakajobs_register_taxonomies', 0);

/**
 * Custom Admin Columns for Lowongan
 */
function hakajobs_set_lowongan_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['logo'] = __('Logo', 'hakajobs');
    $new_columns['title'] = __('Posisi & Perusahaan', 'hakajobs');
    $new_columns['lokasi'] = __('Lokasi', 'hakajobs');
    $new_columns['kategori'] = __('Kategori', 'hakajobs');
    $new_columns['tipe'] = __('Tipe', 'hakajobs');
    $new_columns['gaji'] = __('Gaji', 'hakajobs');
    $new_columns['deadline'] = __('Batas Lamaran', 'hakajobs');
    $new_columns['status'] = __('Status', 'hakajobs');
    $new_columns['views'] = __('Dilihat', 'hakajobs');
    $new_columns['date'] = __('Tanggal', 'hakajobs');
    return $new_columns;
}
add_filter('manage_lowongan_posts_columns', 'hakajobs_set_lowongan_columns');

/**
 * Populate Custom Admin Columns
 */
function hakajobs_custom_lowongan_column_data($column, $post_id) {
    switch ($column) {
        case 'logo':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, array(44, 44), array('style' => 'width:44px;height:44px;object-fit:cover;border-radius:6px;border:1px solid #e2e8f0;'));
            } else {
                $comp = get_post_meta($post_id, '_hakajobs_company_name', true);
                $initial = !empty($comp) ? strtoupper(substr($comp, 0, 2)) : 'LK';
                echo '<div style="width:44px;height:44px;border-radius:6px;background:#0284c7;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;">' . esc_html($initial) . '</div>';
            }
            break;

        case 'lokasi':
            $terms = get_the_terms($post_id, 'lokasi_lowongan');
            if (!empty($terms) && !is_wp_error($terms)) {
                $names = wp_list_pluck($terms, 'name');
                echo esc_html(implode(', ', $names));
            } else {
                echo '<span style="color:#94a3b8;">—</span>';
            }
            break;

        case 'kategori':
            $terms = get_the_terms($post_id, 'kategori_lowongan');
            if (!empty($terms) && !is_wp_error($terms)) {
                $names = wp_list_pluck($terms, 'name');
                echo esc_html(implode(', ', $names));
            } else {
                echo '<span style="color:#94a3b8;">—</span>';
            }
            break;

        case 'tipe':
            $terms = get_the_terms($post_id, 'tipe_pekerjaan');
            if (!empty($terms) && !is_wp_error($terms)) {
                foreach ($terms as $t) {
                    echo '<span style="display:inline-block;padding:2px 8px;font-size:11px;font-weight:600;border-radius:4px;background:#e0f2fe;color:#0369a1;margin-right:4px;">' . esc_html($t->name) . '</span>';
                }
            } else {
                echo '<span style="color:#94a3b8;">—</span>';
            }
            break;

        case 'gaji':
            $salary = get_post_meta($post_id, '_hakajobs_salary', true);
            echo !empty($salary) ? esc_html($salary) : '<span style="color:#94a3b8;">Dirahasiakan</span>';
            break;

        case 'deadline':
            $deadline = get_post_meta($post_id, '_hakajobs_deadline', true);
            if (!empty($deadline)) {
                $time = strtotime($deadline);
                $is_expired = ($time && $time < strtotime('today'));
                $color = $is_expired ? '#dc2626' : '#1e293b';
                echo '<span style="color:' . esc_attr($color) . ';font-weight:600;">' . esc_html(date_i18n('d M Y', $time)) . '</span>';
                if ($is_expired) {
                    echo '<br><small style="color:#dc2626;font-size:10px;">(Kedaluwarsa)</small>';
                }
            } else {
                echo '<span style="color:#94a3b8;">Seterusnya</span>';
            }
            break;

        case 'status':
            $status = get_post_meta($post_id, '_hakajobs_status', true);
            if ($status === 'tutup') {
                echo '<span style="padding:3px 8px;font-size:11px;font-weight:700;border-radius:4px;background:#fee2e2;color:#b91c1c;">TUTUP</span>';
            } else {
                echo '<span style="padding:3px 8px;font-size:11px;font-weight:700;border-radius:4px;background:#dcfce7;color:#15803d;">AKTIF</span>';
            }
            break;

        case 'views':
            $views = get_post_meta($post_id, '_hakajobs_views_count', true);
            echo number_format_i18n((int)$views) . 'x';
            break;
    }
}
add_action('manage_lowongan_posts_custom_column', 'hakajobs_custom_lowongan_column_data', 10, 2);

/**
 * Add Quick WhatsApp Broadcast Row Action in Admin Post Table
 */
function hakajobs_add_lowongan_row_actions($actions, $post) {
    if ($post->post_type === 'lowongan' && $post->post_status === 'publish') {
        if (function_exists('hakajobs_get_wa_broadcast_url')) {
            $wa_url = hakajobs_get_wa_broadcast_url($post->ID);
            $actions['wa_broadcast'] = sprintf(
                '<a href="%s" target="_blank" style="color:#15803d; font-weight:700;" title="%s">📢 %s</a>',
                esc_url($wa_url),
                esc_attr__('Siarkan lowongan ini ke Saluran WhatsApp atau Grup', 'hakajobs'),
                __('Broadcast WA', 'hakajobs')
            );
        }
    }
    return $actions;
}
add_filter('post_row_actions', 'hakajobs_add_lowongan_row_actions', 10, 2);

