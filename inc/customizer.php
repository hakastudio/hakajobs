<?php
/**
 * Theme Customizer Settings for Hakajobs
 *
 * Panel: 🎨 Penyesuaian Tema Hakajobs
 *  ├─ Section 1 : Skema Warna & Branding
 *  ├─ Section 2 : Header & Navigasi Menu
 *  ├─ Section 3 : Bilah Pengumuman (Topbar)
 *  ├─ Section 4 : Tombol Kembali ke Atas
 *  ├─ Section 5 : Halaman Beranda (Hero)
 *  ├─ Section 6 : Peringatan Anti Penipuan
 *  ├─ Section 7 : Footer & Hak Cipta
 *  ├─ Section 8 : SEO & Meta Tags
 *  ├─ Section 9 : Monetisasi & Slot Banner Iklan
 *  ├─ Section 10: Halaman Pasang Loker & Tarif
 *  ├─ Section 11: Saluran WhatsApp & Broadcast Loker
 *  └─ Section 12: Sidebar Kanan (Beranda & Halaman Statis)
 *
 * @package Hakajobs
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Customizer Settings and Controls
 */
function hakajobs_customize_register($wp_customize) {

    // =========================================================================
    // PANEL UTAMA
    // =========================================================================
    $wp_customize->add_panel('hakajobs_theme_options', array(
        'title'       => __('Penyesuaian Tema Hakajobs', 'hakajobs'),
        'description' => __('Atur warna, header, navigasi, hero, dan semua teks tema dari sini.', 'hakajobs'),
        'priority'    => 20,
    ));

    // =========================================================================
    // SECTION 1 — WARNA & BRANDING
    // =========================================================================
    $wp_customize->add_section('hakajobs_color_section', array(
        'title'    => __('Skema Warna & Branding', 'hakajobs'),
        'panel'    => 'hakajobs_theme_options',
        'priority' => 10,
    ));

    $wp_customize->add_setting('hakajobs_primary_color', array(
        'default'           => '#0284c7',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_primary_color', array(
        'label'       => __('Warna Utama (Tombol, Link Aktif)', 'hakajobs'),
        'description' => __('Warna dominan tema — tombol, link, dan elemen sorotan.', 'hakajobs'),
        'section'     => 'hakajobs_color_section',
    )));

    $wp_customize->add_setting('hakajobs_primary_hover_color', array(
        'default'           => '#0369a1',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_primary_hover_color', array(
        'label'   => __('Warna Hover Tombol Utama', 'hakajobs'),
        'section' => 'hakajobs_color_section',
    )));

    $wp_customize->add_setting('hakajobs_dark_color', array(
        'default'           => '#0f172a',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_dark_color', array(
        'label'       => __('Warna Gelap (Topbar & Footer)', 'hakajobs'),
        'description' => __('Latar bilah atas, footer, dan kartu gelap.', 'hakajobs'),
        'section'     => 'hakajobs_color_section',
    )));

    $wp_customize->add_setting('hakajobs_accent_color', array(
        'default'           => '#0f766e',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_accent_color', array(
        'label'       => __('Warna Aksen (Label Gaji & Sorotan)', 'hakajobs'),
        'section'     => 'hakajobs_color_section',
    )));

    $wp_customize->add_setting('hakajobs_wa_color', array(
        'default'           => '#16a34a',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_wa_color', array(
        'label'   => __('Warna Tombol Lamar via WhatsApp', 'hakajobs'),
        'section' => 'hakajobs_color_section',
    )));

    $wp_customize->add_setting('hakajobs_body_bg', array(
        'default'           => '#f8fafc',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_body_bg', array(
        'label'   => __('Warna Latar Belakang Halaman', 'hakajobs'),
        'section' => 'hakajobs_color_section',
    )));

    // =========================================================================
    // SECTION 2 — HEADER & NAVIGASI MENU
    // =========================================================================
    $wp_customize->add_section('hakajobs_header_section', array(
        'title'       => __('Header & Navigasi Menu', 'hakajobs'),
        'description' => __('Atur logo, sticky header, tombol CTA, dan tautan cepat di bilah atas. Untuk mengedit item menu, buka: Tampilan → Menu.', 'hakajobs'),
        'panel'       => 'hakajobs_theme_options',
        'priority'    => 20,
    ));

    // Sticky Header
    $wp_customize->add_setting('hakajobs_sticky_header', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sticky_header', array(
        'type'        => 'checkbox',
        'label'       => __('Header Melekat (Sticky Header)', 'hakajobs'),
        'description' => __('Header tetap terlihat di paling atas saat halaman di-scroll.', 'hakajobs'),
        'section'     => 'hakajobs_header_section',
    ));

    // Tampilkan Tagline
    $wp_customize->add_setting('hakajobs_show_tagline', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_show_tagline', array(
        'type'        => 'checkbox',
        'label'       => __('Tampilkan Tagline di Bawah Nama Situs', 'hakajobs'),
        'description' => __('Menampilkan deskripsi singkat situs di bawah nama logo teks.', 'hakajobs'),
        'section'     => 'hakajobs_header_section',
    ));

    // Ikon Logo (Emoji)
    $wp_customize->add_setting('hakajobs_logo_icon', array(
        'default'           => '💼',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_logo_icon', array(
        'type'        => 'text',
        'label'       => __('Ikon Logo (Emoji)', 'hakajobs'),
        'description' => __('Emoji sebelum nama situs (jika tidak pakai logo gambar). Contoh: 💼 🏢 🌟 🚀', 'hakajobs'),
        'section'     => 'hakajobs_header_section',
    ));

    // Tinggi Maksimal Logo Gambar (px) — Pengaturan Besar Kecil Logo
    $wp_customize->add_setting('hakajobs_logo_max_height', array(
        'default'           => 42,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_logo_max_height', array(
        'type'        => 'range',
        'label'       => __('📏 Ukuran Tinggi Logo Gambar (px)', 'hakajobs'),
        'description' => __('Atur besar / kecil ukuran tinggi logo gambar agar pas dan tidak kebesaran di header. Rekomendasi: 32px - 52px (Default: 42px).', 'hakajobs'),
        'section'     => 'hakajobs_header_section',
        'input_attrs' => array(
            'min'  => 20,
            'max'  => 70,
            'step' => 1,
        ),
    ));

    // Kontrol Logo di Menu Bawaan Identitas Situs (Site Identity)
    $wp_customize->add_control('hakajobs_logo_max_height_site_identity', array(
        'settings'    => 'hakajobs_logo_max_height',
        'type'        => 'range',
        'label'       => __('📏 Tinggi Maksimal Logo Gambar (px)', 'hakajobs'),
        'description' => __('Atur besar / kecil ukuran logo agar tidak kebesaran di header.', 'hakajobs'),
        'section'     => 'title_tagline',
        'priority'    => 9,
        'input_attrs' => array(
            'min'  => 20,
            'max'  => 70,
            'step' => 1,
        ),
    ));

    // Ukuran Font Teks Nama Situs (px)
    $wp_customize->add_setting('hakajobs_logo_text_size', array(
        'default'           => 20,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_logo_text_size', array(
        'type'        => 'range',
        'label'       => __('🔤 Ukuran Font Nama Situs (px)', 'hakajobs'),
        'description' => __('Besar / kecil font nama website jika tidak memakai logo gambar (14px - 32px). Default: 20px.', 'hakajobs'),
        'section'     => 'hakajobs_header_section',
        'input_attrs' => array(
            'min'  => 14,
            'max'  => 32,
            'step' => 1,
        ),
    ));

    // Ukuran Ikon Logo Emoji (px)
    $wp_customize->add_setting('hakajobs_logo_icon_size', array(
        'default'           => 26,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_logo_icon_size', array(
        'type'        => 'range',
        'label'       => __('✨ Ukuran Ikon Logo Emoji (px)', 'hakajobs'),
        'description' => __('Besar / kecil emoji ikon sebelum nama website (16px - 44px). Default: 26px.', 'hakajobs'),
        'section'     => 'hakajobs_header_section',
        'input_attrs' => array(
            'min'  => 16,
            'max'  => 44,
            'step' => 2,
        ),
    ));

    // =========================================================================
    // PENGATURAN MENU UTAMA BAWAAN (DEFAULT NAV MENU)
    // =========================================================================
    // Label Beranda
    $wp_customize->add_setting('hakajobs_nav_home_label', array(
        'default'           => __('Beranda', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_nav_home_label', array(
        'type'        => 'text',
        'label'       => __('Menu: Label [Beranda]', 'hakajobs'),
        'description' => __('Label menu beranda bawaan. Kosongkan jika ingin disembunyikan.', 'hakajobs'),
        'section'     => 'hakajobs_header_section',
    ));

    // Label Semua Lowongan
    $wp_customize->add_setting('hakajobs_nav_all_label', array(
        'default'           => __('Semua', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_nav_all_label', array(
        'type'        => 'text',
        'label'       => __('Menu: Label [Semua]', 'hakajobs'),
        'description' => __('Label menu arsip lowongan. Contoh: "Semua", "Semua Lowongan", atau kosongkan.', 'hakajobs'),
        'section'     => 'hakajobs_header_section',
    ));

    // Label Menu 3 (Magang)
    $wp_customize->add_setting('hakajobs_nav_custom1_label', array(
        'default'           => __('Magang (Internship)', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_nav_custom1_label', array(
        'type'        => 'text',
        'label'       => __('Menu: Label [Magang]', 'hakajobs'),
        'description' => __('Label menu ketiga bawaan. Contoh: Magang (Internship).', 'hakajobs'),
        'section'     => 'hakajobs_header_section',
    ));

    // URL Menu 3 (Magang)
    $wp_customize->add_setting('hakajobs_nav_custom1_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hakajobs_nav_custom1_url', array(
        'type'        => 'url',
        'label'       => __('Menu: URL [Magang]', 'hakajobs'),
        'description' => __('Kosongkan untuk otomatis ke filter tipe Magang.', 'hakajobs'),
        'section'     => 'hakajobs_header_section',
    ));

    // Label Menu 4 (Part-Time)
    $wp_customize->add_setting('hakajobs_nav_custom2_label', array(
        'default'           => __('Part-Time', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_nav_custom2_label', array(
        'type'        => 'text',
        'label'       => __('Menu: Label [Part-Time]', 'hakajobs'),
        'description' => __('Label menu keempat bawaan. Contoh: Part-Time.', 'hakajobs'),
        'section'     => 'hakajobs_header_section',
    ));

    // URL Menu 4 (Part-Time)
    $wp_customize->add_setting('hakajobs_nav_custom2_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hakajobs_nav_custom2_url', array(
        'type'        => 'url',
        'label'       => __('Menu: URL [Part-Time]', 'hakajobs'),
        'description' => __('Kosongkan untuk otomatis ke filter tipe Part-Time.', 'hakajobs'),
        'section'     => 'hakajobs_header_section',
    ));

    // Tampilkan Tombol Pasang Loker di Dalam Menu Navigasi
    $wp_customize->add_setting('hakajobs_nav_show_post_job', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
    ));
    $wp_customize->add_control('hakajobs_nav_show_post_job', array(
        'type'        => 'checkbox',
        'label'       => __('Tampilkan Link [Pasang Loker] di Deretan Menu', 'hakajobs'),
        'section'     => 'hakajobs_header_section',
    ));

    // Tampilkan Tombol CTA di Kanan Header
    $wp_customize->add_setting('hakajobs_show_cta_btn', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
    ));
    $wp_customize->add_control('hakajobs_show_cta_btn', array(
        'type'        => 'checkbox',
        'label'       => __('Tampilkan Tombol CTA [Pasang Loker] di Pojok Kanan Header', 'hakajobs'),
        'section'     => 'hakajobs_header_section',
    ));

    // Teks Tombol CTA Header
    $wp_customize->add_setting('hakajobs_post_job_label', array(
        'default'           => __('Pasang Loker', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_post_job_label', array(
        'type'        => 'text',
        'label'       => __('Teks Tombol CTA Header [Pasang Loker]', 'hakajobs'),
        'description' => __('Label tombol di pojok kanan header. Contoh: "Pasang Loker", "Hubungi Admin".', 'hakajobs'),
        'section'     => 'hakajobs_header_section',
    ));

    // URL Tombol CTA Header
    $wp_customize->add_setting('hakajobs_post_job_url', array(
        'default'           => home_url('/pasang-loker/'),
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hakajobs_post_job_url', array(
        'type'        => 'url',
        'label'       => __('URL Tombol CTA Header', 'hakajobs'),
        'description' => __('Link tujuan tombol CTA. Bisa berupa halaman kontak atau WhatsApp: https://wa.me/628xxx', 'hakajobs'),
        'section'     => 'hakajobs_header_section',
    ));

    // Tampilkan Tombol Bookmark
    $wp_customize->add_setting('hakajobs_show_bookmark_btn', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_show_bookmark_btn', array(
        'type'        => 'checkbox',
        'label'       => __('Tampilkan Tombol Lowongan Tersimpan di Header', 'hakajobs'),
        'description' => __('Ikon bookmark dengan penghitung loker yang disimpan pengunjung.', 'hakajobs'),
        'section'     => 'hakajobs_header_section',
    ));

    // Topbar Quick Link 1
    $wp_customize->add_setting('hakajobs_menu_link1_label', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_menu_link1_label', array(
        'type'        => 'text',
        'label'       => __('Topbar — Teks Link Cepat 1', 'hakajobs'),
        'description' => __('Tautan cepat pertama di bilah pengumuman (opsional).', 'hakajobs'),
        'section'     => 'hakajobs_header_section',
    ));
    $wp_customize->add_setting('hakajobs_menu_link1_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hakajobs_menu_link1_url', array(
        'type'    => 'url',
        'label'   => __('Topbar — URL Link Cepat 1', 'hakajobs'),
        'section' => 'hakajobs_header_section',
    ));

    // Topbar Quick Link 2
    $wp_customize->add_setting('hakajobs_menu_link2_label', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_menu_link2_label', array(
        'type'    => 'text',
        'label'   => __('Topbar — Teks Link Cepat 2', 'hakajobs'),
        'section' => 'hakajobs_header_section',
    ));
    $wp_customize->add_setting('hakajobs_menu_link2_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hakajobs_menu_link2_url', array(
        'type'    => 'url',
        'label'   => __('Topbar — URL Link Cepat 2', 'hakajobs'),
        'section' => 'hakajobs_header_section',
    ));

    // =========================================================================
    // SECTION 3 — BILAH PENGUMUMAN (TOPBAR)
    // =========================================================================
    $wp_customize->add_section('hakajobs_topbar_section', array(
        'title'    => __('Bilah Pengumuman (Topbar)', 'hakajobs'),
        'panel'    => 'hakajobs_theme_options',
        'priority' => 25,
    ));

    $wp_customize->add_setting('hakajobs_show_topbar', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
    ));
    $wp_customize->add_control('hakajobs_show_topbar', array(
        'type'        => 'checkbox',
        'label'       => __('Tampilkan Bilah Pengumuman', 'hakajobs'),
        'description' => __('Bilah tipis di paling atas halaman untuk pengumuman singkat.', 'hakajobs'),
        'section'     => 'hakajobs_topbar_section',
    ));

    $wp_customize->add_setting('hakajobs_topbar_badge', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_topbar_badge', array(
        'type'        => 'text',
        'label'       => __('Teks Badge / Label Kecil', 'hakajobs'),
        'description' => __('Badge di kiri topbar (opsional). Contoh: "Terverifikasi", "Resmi", "#1 di Indonesia".', 'hakajobs'),
        'section'     => 'hakajobs_topbar_section',
    ));

    $wp_customize->add_setting('hakajobs_topbar_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_topbar_text', array(
        'type'        => 'text',
        'label'       => __('Teks Pengumuman Utama', 'hakajobs'),
        'description' => __('Pesan pengumuman di samping badge (opsional).', 'hakajobs'),
        'section'     => 'hakajobs_topbar_section',
    ));

    // =========================================================================
    // SECTION 4 — TOMBOL KEMBALI KE ATAS
    // =========================================================================
    $wp_customize->add_section('hakajobs_backtotop_section', array(
        'title'    => __('Tombol Kembali ke Atas', 'hakajobs'),
        'panel'    => 'hakajobs_theme_options',
        'priority' => 30,
    ));

    $wp_customize->add_setting('hakajobs_enable_back_to_top', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_enable_back_to_top', array(
        'type'        => 'checkbox',
        'label'       => __('Aktifkan Tombol "Kembali ke Atas"', 'hakajobs'),
        'description' => __('Tombol melayang di pojok kanan bawah saat pengguna menggulir ke bawah.', 'hakajobs'),
        'section'     => 'hakajobs_backtotop_section',
    ));

    $wp_customize->add_setting('hakajobs_backtotop_color', array(
        'default'           => '#0284c7',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_backtotop_color', array(
        'label'   => __('Warna Tombol Kembali ke Atas', 'hakajobs'),
        'section' => 'hakajobs_backtotop_section',
    )));

    // =========================================================================
    // SECTION 5 — HALAMAN BERANDA (HERO)
    // =========================================================================
    $wp_customize->add_section('hakajobs_hero_section', array(
        'title'       => __('Halaman Beranda & Cara Melamar', 'hakajobs'),
        'description' => __('Kustomisasi teks hero pencarian dan panduan 3 langkah cara melamar kerja di halaman beranda.', 'hakajobs'),
        'panel'       => 'hakajobs_theme_options',
        'priority'    => 35,
    ));

    // Pilihan Gaya Hero (Pasang Loker vs Light)
    $wp_customize->add_setting('hakajobs_hero_style', array(
        'default'           => 'pasang-loker',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_hero_style', array(
        'type'        => 'select',
        'label'       => __('Gaya Desain Hero Beranda', 'hakajobs'),
        'description' => __('Pilih gaya visual hero beranda. Gaya Pasang Loker menggunakan latar dark navy modern dengan aksen cyan glow.', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
        'choices'     => array(
            'pasang-loker' => __('Gaya Pasang Loker (Dark Navy & Aksen Cyan - Rekomendasi)', 'hakajobs'),
            'light'        => __('Gaya Terang Minimalis (Clean Light)', 'hakajobs'),
        ),
    ));

    // Badge Teks Hero
    $wp_customize->add_setting('hakajobs_hero_badge', array(
        'default'           => __('Portal Loker Terpercaya & Lamar Langsung', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_hero_badge', array(
        'type'        => 'text',
        'label'       => __('Teks Badge / Label Kecil Hero', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
    ));

    // Judul Utama Hero (H1)
    $wp_customize->add_setting('hakajobs_hero_title', array(
        'default'           => __('Temukan Lowongan Kerja Impian & Lamar Langsung ke Rekruter', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_hero_title', array(
        'type'    => 'text',
        'label'   => __('Judul Utama Hero (H1)', 'hakajobs'),
        'section' => 'hakajobs_hero_section',
    ));

    // Teks Sorotan Bergradien (Highlight Text)
    $wp_customize->add_setting('hakajobs_hero_highlight', array(
        'default'           => __('Lamar Langsung ke Rekruter', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_hero_highlight', array(
        'type'        => 'text',
        'label'       => __('Teks Sorotan Gradien (Highlight)', 'hakajobs'),
        'description' => __('Ketikkan potongan kalimat dalam Judul Utama di atas yang ingin diberi efek gradien warna seperti di halaman pasang loker.', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
    ));

    $wp_customize->add_setting('hakajobs_hero_subtitle', array(
        'default'           => __('Ribuan info lowongan kerja dari perusahaan terpercaya. Lamar langsung tanpa daftar akun — gratis selamanya.', 'hakajobs'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_hero_subtitle', array(
        'type'    => 'textarea',
        'label'   => __('Subjudul / Deskripsi Hero', 'hakajobs'),
        'section' => 'hakajobs_hero_section',
    ));

    $wp_customize->add_setting('hakajobs_hero_search_placeholder', array(
        'default'           => __('Cari jabatan, skill, atau perusahaan...', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_hero_search_placeholder', array(
        'type'    => 'text',
        'label'   => __('Placeholder Kotak Pencarian', 'hakajobs'),
        'section' => 'hakajobs_hero_section',
    ));

    $wp_customize->add_setting('hakajobs_hero_search_btn', array(
        'default'           => __('Cari Loker', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_hero_search_btn', array(
        'type'    => 'text',
        'label'   => __('Teks Tombol Cari', 'hakajobs'),
        'section' => 'hakajobs_hero_section',
    ));

    // --- Sub-bagian: Statistik Hero (Stats Bar) ---
    $wp_customize->add_setting('hakajobs_hero_show_stats', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_hero_show_stats', array(
        'type'        => 'checkbox',
        'label'       => __('Tampilkan Bilah Statistik Hero (Stats Bar)', 'hakajobs'),
        'description' => __('Menampilkan 3 kotak statistik di bawah kolom pencarian seperti pada halaman pasang loker.', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
    ));

    $wp_customize->add_setting('hakajobs_hero_stat1_num', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_hero_stat1_num', array(
        'type'        => 'text',
        'label'       => __('Stat 1: Angka (Kosong = Otomatis)', 'hakajobs'),
        'description' => __('Kosongkan jika ingin otomatis menghitung total lowongan aktif yang tayang.', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
    ));

    $wp_customize->add_setting('hakajobs_hero_stat1_label', array(
        'default'           => __('Lowongan Aktif', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_hero_stat1_label', array(
        'type'    => 'text',
        'label'   => __('Stat 1: Label', 'hakajobs'),
        'section' => 'hakajobs_hero_section',
    ));

    $wp_customize->add_setting('hakajobs_hero_stat2_num', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_hero_stat2_num', array(
        'type'        => 'text',
        'label'       => __('Stat 2: Angka (Kosong = Otomatis)', 'hakajobs'),
        'description' => __('Kosongkan jika ingin otomatis menghitung total kategori bidang kerja.', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
    ));

    $wp_customize->add_setting('hakajobs_hero_stat2_label', array(
        'default'           => __('Kategori Bidang', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_hero_stat2_label', array(
        'type'    => 'text',
        'label'   => __('Stat 2: Label', 'hakajobs'),
        'section' => 'hakajobs_hero_section',
    ));

    $wp_customize->add_setting('hakajobs_hero_stat3_num', array(
        'default'           => '1×24 Jam',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_hero_stat3_num', array(
        'type'    => 'text',
        'label'   => __('Stat 3: Angka / Nilai', 'hakajobs'),
        'section' => 'hakajobs_hero_section',
    ));

    $wp_customize->add_setting('hakajobs_hero_stat3_label', array(
        'default'           => __('Respon Rekruter', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_hero_stat3_label', array(
        'type'    => 'text',
        'label'   => __('Stat 3: Label', 'hakajobs'),
        'section' => 'hakajobs_hero_section',
    ));

    // Lengkungan Gelombang Wave
    $wp_customize->add_setting('hakajobs_hero_show_wave', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_hero_show_wave', array(
        'type'        => 'checkbox',
        'label'       => __('Tampilkan Lengkungan Gelombang (Wave) di Bawah Hero', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
    ));

    // Warna Kustom Gradien Hero
    $wp_customize->add_setting('hakajobs_hero_bg_start', array(
        'default'           => '#0f172a',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_hero_bg_start', array(
        'label'       => __('Warna Awal Gradien Hero (Kiri Atas)', 'hakajobs'),
        'description' => __('Default: #0f172a (Dark Slate Navy khas Pasang Loker)', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
    )));

    $wp_customize->add_setting('hakajobs_hero_bg_end', array(
        'default'           => '#0f3460',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hakajobs_hero_bg_end', array(
        'label'       => __('Warna Akhir Gradien Hero (Kanan Bawah)', 'hakajobs'),
        'description' => __('Default: #0f3460 (Deep Navy khas Pasang Loker)', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
    )));

    // --- Sub-bagian: Lowongan Sorotan & Dibutuhkan Segera (Spotlight) ---
    $wp_customize->add_setting('hakajobs_show_featured_section', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_show_featured_section', array(
        'type'        => 'checkbox',
        'label'       => __('Tampilkan Bagian Lowongan Prioritas (Spotlight)', 'hakajobs'),
        'description' => __('Centang untuk mengaktifkan blok kartu lowongan prioritas / sorotan di beranda.', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
    ));

    $wp_customize->add_setting('hakajobs_featured_badge', array(
        'default'           => __('Lowongan Prioritas', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_featured_badge', array(
        'type'        => 'text',
        'label'       => __('Teks Badge / Label Bagian', 'hakajobs'),
        'description' => __('Contoh: 🔥 Lowongan Prioritas, ⭐ Lowongan Pilihan, dsb.', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
    ));

    $wp_customize->add_setting('hakajobs_featured_section_title', array(
        'default'           => __('Lamar Sekarang! Lowongan Prioritas & Dibutuhkan Segera', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_featured_section_title', array(
        'type'        => 'text',
        'label'       => __('Judul Bagian Lowongan Sorotan (CTA)', 'hakajobs'),
        'description' => __('Gunakan kata-kata aksi/CTA yang memikat pelamar untuk segera melamar lowongan prioritas.', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
    ));

    $wp_customize->add_setting('hakajobs_featured_section_subtitle', array(
        'default'           => __('Peluang karir terbaik dengan respon rekrutmen tercepat. Kirim lamaranmu sebelum kuota penuh!', 'hakajobs'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_featured_section_subtitle', array(
        'type'        => 'textarea',
        'label'       => __('Subjudul Bagian Lowongan Sorotan', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
    ));

    $wp_customize->add_setting('hakajobs_featured_section_link_text', array(
        'default'           => __('Lihat Semua', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_featured_section_link_text', array(
        'type'        => 'text',
        'label'       => __('Teks Tautan "Lihat Semua"', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
    ));

    $wp_customize->add_setting('hakajobs_featured_count', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_featured_count', array(
        'type'        => 'number',
        'label'       => __('Jumlah Lowongan Prioritas Ditampilkan', 'hakajobs'),
        'description' => __('Atur berapa banyak kartu lowongan yang ditampilkan. Default: 6 lowongan.', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 24,
            'step' => 1,
        ),
    ));

    $wp_customize->add_setting('hakajobs_featured_columns', array(
        'default'           => '3',
        'sanitize_callback' => 'hakajobs_sanitize_select',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_featured_columns', array(
        'type'        => 'select',
        'label'       => __('Jumlah Kolom Grid Desktop', 'hakajobs'),
        'description' => __('Pilih tata letak kolom kartu pada desktop. Pilihan 3 kolom sangat presisi dan rapi untuk 6 lowongan (2 baris × 3 kolom).', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
        'choices'     => array(
            '3'    => __('3 Kolom (Rekomendasi untuk 6 kartu: 2 baris × 3 kolom)', 'hakajobs'),
            '2'    => __('2 Kolom (Kartu lebih lebar & lega)', 'hakajobs'),
            '4'    => __('4 Kolom (Tampilan lebih rapat)', 'hakajobs'),
            'auto' => __('Otomatis Fleksibel (Auto-fit)', 'hakajobs'),
        ),
    ));

    // --- Sub-bagian: Panduan Cara Melamar Kerja ---
    $wp_customize->add_setting('hakajobs_show_how_it_works', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_show_how_it_works', array(
        'type'        => 'checkbox',
        'label'       => __('Tampilkan Bagian "Cara Melamar"', 'hakajobs'),
        'description' => __('Tampilkan blok panduan 3 langkah melamar kerja di halaman beranda.', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
    ));

    $wp_customize->add_setting('hakajobs_how_it_works_title', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_how_it_works_title', array(
        'type'        => 'text',
        'label'       => __('Judul Bagian "Cara Melamar"', 'hakajobs'),
        'description' => __('Kosongkan untuk otomatis mengikuti nama website: "Cara Melamar Kerja di [Nama Situs]". Anda juga bisa mengetikkan judul kustom di sini.', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
    ));

    $wp_customize->add_setting('hakajobs_how_it_works_subtitle', array(
        'default'           => __('Tanpa perlu daftar akun, verifikasi email yang panjang, atau mengingat password.', 'hakajobs'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_how_it_works_subtitle', array(
        'type'        => 'textarea',
        'label'       => __('Subjudul Bagian "Cara Melamar"', 'hakajobs'),
        'section'     => 'hakajobs_hero_section',
    ));

    // Langkah 1
    $wp_customize->add_setting('hakajobs_step1_title', array(
        'default'           => __('Cari & Pilih Lowongan', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_step1_title', array(
        'type'    => 'text',
        'label'   => __('Langkah 1 — Judul', 'hakajobs'),
        'section' => 'hakajobs_hero_section',
    ));
    $wp_customize->add_setting('hakajobs_step1_desc', array(
        'default'           => __('Gunakan filter lokasi, tipe kerja, atau bidang industri untuk menemukan posisi yang sesuai dengan keahlian Anda.', 'hakajobs'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('hakajobs_step1_desc', array(
        'type'    => 'textarea',
        'label'   => __('Langkah 1 — Deskripsi', 'hakajobs'),
        'section' => 'hakajobs_hero_section',
    ));

    // Langkah 2
    $wp_customize->add_setting('hakajobs_step2_title', array(
        'default'           => __('Siapkan Dokumen', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_step2_title', array(
        'type'    => 'text',
        'label'   => __('Langkah 2 — Judul', 'hakajobs'),
        'section' => 'hakajobs_hero_section',
    ));
    $wp_customize->add_setting('hakajobs_step2_desc', array(
        'default'           => __('Pastikan berkas resume/CV dan tautan portofolio terbaru Anda sudah siap dikirimkan kepada tim rekruter.', 'hakajobs'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('hakajobs_step2_desc', array(
        'type'    => 'textarea',
        'label'   => __('Langkah 2 — Deskripsi', 'hakajobs'),
        'section' => 'hakajobs_hero_section',
    ));

    // Langkah 3
    $wp_customize->add_setting('hakajobs_step3_title', array(
        'default'           => __('Kirim Lamaran Langsung', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_step3_title', array(
        'type'    => 'text',
        'label'   => __('Langkah 3 — Judul', 'hakajobs'),
        'section' => 'hakajobs_hero_section',
    ));
    $wp_customize->add_setting('hakajobs_step3_desc', array(
        'default'           => __('Klik tombol Lamar untuk terhubung langsung ke WhatsApp HRD, kirim email, atau isi formulir karir resmi perusahaan.', 'hakajobs'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('hakajobs_step3_desc', array(
        'type'    => 'textarea',
        'label'   => __('Langkah 3 — Deskripsi', 'hakajobs'),
        'section' => 'hakajobs_hero_section',
    ));

    // =========================================================================
    // SECTION 6 — PERINGATAN ANTI PENIPUAN
    // =========================================================================
    $wp_customize->add_section('hakajobs_fraud_section', array(
        'title'    => __('Peringatan Anti Penipuan', 'hakajobs'),
        'panel'    => 'hakajobs_theme_options',
        'priority' => 40,
    ));

    $wp_customize->add_setting('hakajobs_show_fraud_alert', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
    ));
    $wp_customize->add_control('hakajobs_show_fraud_alert', array(
        'type'        => 'checkbox',
        'label'       => __('Tampilkan Banner Anti Penipuan di Atas Footer', 'hakajobs'),
        'section'     => 'hakajobs_fraud_section',
    ));

    $wp_customize->add_setting('hakajobs_fraud_title', array(
        'default'           => __('Peringatan Anti Penipuan Rekrutmen', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_fraud_title', array(
        'type'    => 'text',
        'label'   => __('Judul Peringatan', 'hakajobs'),
        'section' => 'hakajobs_fraud_section',
    ));

    $wp_customize->add_setting('hakajobs_fraud_text', array(
        'default'           => __('Seluruh proses seleksi dan lamaran kerja di situs ini adalah 100% GRATIS. Jangan pernah mentransfer uang dengan alasan apapun (biaya administrasi, tiket travel, seragam, atau akomodasi hotel).', 'hakajobs'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('hakajobs_fraud_text', array(
        'type'    => 'textarea',
        'label'   => __('Teks Isi Peringatan', 'hakajobs'),
        'section' => 'hakajobs_fraud_section',
    ));

    // =========================================================================
    // SECTION 7 — FOOTER & HAK CIPTA
    // =========================================================================
    $wp_customize->add_section('hakajobs_footer_section', array(
        'title'    => __('Footer & Hak Cipta', 'hakajobs'),
        'panel'    => 'hakajobs_theme_options',
        'priority' => 50,
    ));

    $wp_customize->add_setting('hakajobs_footer_about', array(
        'default'           => __('Platform kurasi info lowongan kerja terpercaya, menghubungkan pencari kerja langsung dengan HRD via WhatsApp, Email, & Web resmi tanpa perlu registrasi akun.', 'hakajobs'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('hakajobs_footer_about', array(
        'type'    => 'textarea',
        'label'   => __('Deskripsi Singkat di Footer', 'hakajobs'),
        'section' => 'hakajobs_footer_section',
    ));

    // Footer Column 2 (Kategori)
    $wp_customize->add_setting('hakajobs_footer_col2_title', array(
        'default'           => __('Kategori Pekerjaan', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_footer_col2_title', array(
        'type'        => 'text',
        'label'       => __('Judul Kolom 2 (Kategori)', 'hakajobs'),
        'description' => __('Default: Kategori Pekerjaan. Bisa diisi custom menu via Tampilan > Menu (Footer Kolom 2) atau Tampilan > Widget.', 'hakajobs'),
        'section'     => 'hakajobs_footer_section',
    ));

    $wp_customize->add_setting('hakajobs_footer_col2_count', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('hakajobs_footer_col2_count', array(
        'type'        => 'number',
        'label'       => __('Jumlah Kategori Populer (Otomatis)', 'hakajobs'),
        'description' => __('Jumlah kategori yang tampil jika belum memilih menu manual di Tampilan > Menu.', 'hakajobs'),
        'section'     => 'hakajobs_footer_section',
        'input_attrs' => array('min' => 1, 'max' => 20, 'step' => 1),
    ));

    // Footer Column 3 (Kota & Wilayah)
    $wp_customize->add_setting('hakajobs_footer_col3_title', array(
        'default'           => __('Kota & Wilayah', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_footer_col3_title', array(
        'type'        => 'text',
        'label'       => __('Judul Kolom 3 (Kota & Wilayah)', 'hakajobs'),
        'description' => __('Default: Kota & Wilayah. Bisa diisi custom menu via Tampilan > Menu (Footer Kolom 3) atau Tampilan > Widget.', 'hakajobs'),
        'section'     => 'hakajobs_footer_section',
    ));

    $wp_customize->add_setting('hakajobs_footer_col3_count', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('hakajobs_footer_col3_count', array(
        'type'        => 'number',
        'label'       => __('Jumlah Lokasi Populer (Otomatis)', 'hakajobs'),
        'description' => __('Jumlah kota yang tampil jika belum memilih menu manual di Tampilan > Menu.', 'hakajobs'),
        'section'     => 'hakajobs_footer_section',
        'input_attrs' => array('min' => 1, 'max' => 20, 'step' => 1),
    ));

    // Footer Column 4 (Navigasi & Info)
    $wp_customize->add_setting('hakajobs_footer_col4_title', array(
        'default'           => __('Navigasi & Info', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_footer_col4_title', array(
        'type'        => 'text',
        'label'       => __('Judul Kolom 4 (Navigasi & Info)', 'hakajobs'),
        'description' => __('Default: Navigasi & Info. Isi tautan dapat disetel manual via Tampilan > Menu (Footer Kolom 4) atau Tampilan > Widget.', 'hakajobs'),
        'section'     => 'hakajobs_footer_section',
    ));

    $wp_customize->add_setting('hakajobs_copyright_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_copyright_text', array(
        'type'        => 'text',
        'label'       => __('Teks Hak Cipta Custom', 'hakajobs'),
        'description' => __('Kosongkan untuk default: © [Tahun] [Nama Situs]. Hak Cipta Dilindungi.', 'hakajobs'),
        'section'     => 'hakajobs_footer_section',
    ));

    // Catatan / Slogan Footer Bawah (Portal Info Lowongan Kerja Tanpa Login)
    $wp_customize->add_setting('hakajobs_show_footer_tagline', array(
        'default'           => '0',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_show_footer_tagline', array(
        'type'        => 'checkbox',
        'label'       => __('Tampilkan Catatan / Slogan Footer Bawah', 'hakajobs'),
        'description' => __('Default tidak aktif (tersembunyi). Centang jika ingin memunculkan teks catatan di samping copyright footer.', 'hakajobs'),
        'section'     => 'hakajobs_footer_section',
    ));

    $wp_customize->add_setting('hakajobs_footer_tagline', array(
        'default'           => __('Portal Info Lowongan Kerja Tanpa Login', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_footer_tagline', array(
        'type'        => 'text',
        'label'       => __('Teks Catatan / Slogan Footer', 'hakajobs'),
        'description' => __('Contoh: Portal Info Lowongan Kerja Tanpa Login. Hanya tampil jika opsi centang di atas diaktifkan.', 'hakajobs'),
        'section'     => 'hakajobs_footer_section',
    ));

    // Media Sosial Pemilik Website di Footer
    $wp_customize->add_setting('hakajobs_show_footer_social', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_show_footer_social', array(
        'type'        => 'checkbox',
        'label'       => __('Tampilkan Media Sosial Pemilik Website', 'hakajobs'),
        'description' => __('Aktifkan (ON) atau nonaktifkan (OFF) deretan ikon media sosial di footer. Ikon hanya akan tampil jika tautan (link) diisi di bawah ini.', 'hakajobs'),
        'section'     => 'hakajobs_footer_section',
    ));

    $wp_customize->add_setting('hakajobs_footer_social_label', array(
        'default'           => __('Sosial Media Kami:', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_footer_social_label', array(
        'type'        => 'text',
        'label'       => __('Label Teks Media Sosial', 'hakajobs'),
        'description' => __('Contoh: "Sosial Media Kami:", "Ikuti Kami:", "Official Social Media:".', 'hakajobs'),
        'section'     => 'hakajobs_footer_section',
    ));

    $wp_customize->add_setting('hakajobs_footer_social_wa', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hakajobs_footer_social_wa', array(
        'type'        => 'url',
        'label'       => __('URL WhatsApp (Admin/Official)', 'hakajobs'),
        'description' => __('Contoh: https://wa.me/6281234567890. Kosongkan jika tidak ingin menampilkan.', 'hakajobs'),
        'section'     => 'hakajobs_footer_section',
    ));

    $wp_customize->add_setting('hakajobs_footer_social_tg', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hakajobs_footer_social_tg', array(
        'type'        => 'url',
        'label'       => __('URL Telegram (Channel/Group/Akun)', 'hakajobs'),
        'description' => __('Contoh: https://t.me/sosialmedia. Kosongkan jika tidak ingin menampilkan.', 'hakajobs'),
        'section'     => 'hakajobs_footer_section',
    ));

    $wp_customize->add_setting('hakajobs_footer_social_in', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hakajobs_footer_social_in', array(
        'type'        => 'url',
        'label'       => __('URL LinkedIn (Halaman/Profil)', 'hakajobs'),
        'description' => __('Contoh: https://linkedin.com/company/sosialmedia. Kosongkan jika tidak ingin menampilkan.', 'hakajobs'),
        'section'     => 'hakajobs_footer_section',
    ));

    $wp_customize->add_setting('hakajobs_footer_social_fb', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hakajobs_footer_social_fb', array(
        'type'        => 'url',
        'label'       => __('URL Facebook (Fanspage/Group/Profil)', 'hakajobs'),
        'description' => __('Contoh: https://facebook.com/sosialmedia. Kosongkan jika tidak ingin menampilkan.', 'hakajobs'),
        'section'     => 'hakajobs_footer_section',
    ));

    $wp_customize->add_setting('hakajobs_footer_social_ig', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hakajobs_footer_social_ig', array(
        'type'        => 'url',
        'label'       => __('URL Instagram (Profil Resmi)', 'hakajobs'),
        'description' => __('Contoh: https://instagram.com/sosialmedia. Kosongkan jika tidak ingin menampilkan.', 'hakajobs'),
        'section'     => 'hakajobs_footer_section',
    ));

    // =========================================================================
    // SECTION 8 — 🔍 SEO & VERIFIKASI MESIN PENCARI
    // =========================================================================
    $wp_customize->add_section('hakajobs_seo_section', array(
        'title'       => __('SEO & Verifikasi Mesin Pencari', 'hakajobs'),
        'description' => __('Optimalisasi agar situs mudah diindeks Google, Bing, serta preview menarik di WhatsApp & Medsos.', 'hakajobs'),
        'panel'       => 'hakajobs_theme_options',
        'priority'    => 55,
    ));

    $wp_customize->add_setting('hakajobs_seo_enable', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
    ));
    $wp_customize->add_control('hakajobs_seo_enable', array(
        'type'        => 'checkbox',
        'label'       => __('Aktifkan Mesin SEO Otomatis', 'hakajobs'),
        'description' => __('Otomatis menyisipkan Meta Description, Canonical URL, Open Graph, Twitter Card, dan Robots.', 'hakajobs'),
        'section'     => 'hakajobs_seo_section',
    ));

    $wp_customize->add_setting('hakajobs_google_verification', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_google_verification', array(
        'type'        => 'text',
        'label'       => __('Kode Verifikasi Google Search Console', 'hakajobs'),
        'description' => __('Masukkan nilai content meta tag Google Anda. Contoh: abc123def456...', 'hakajobs'),
        'section'     => 'hakajobs_seo_section',
    ));

    $wp_customize->add_setting('hakajobs_bing_verification', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_bing_verification', array(
        'type'        => 'text',
        'label'       => __('Kode Verifikasi Bing Webmaster Tools', 'hakajobs'),
        'description' => __('Nilai kode msvalidate.01 dari Bing.', 'hakajobs'),
        'section'     => 'hakajobs_seo_section',
    ));

    $wp_customize->add_setting('hakajobs_default_meta_desc', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('hakajobs_default_meta_desc', array(
        'type'        => 'textarea',
        'label'       => __('Meta Description Beranda', 'hakajobs'),
        'description' => __('Ringkasan deskripsi website yang tampil di hasil pencarian Google (Rekomendasi: 140 - 160 karakter).', 'hakajobs'),
        'section'     => 'hakajobs_seo_section',
    ));

    $wp_customize->add_setting('hakajobs_default_share_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hakajobs_default_share_image', array(
        'label'       => __('Gambar Preview Medsos / WhatsApp (Default)', 'hakajobs'),
        'description' => __('Gambar banner saat link website dibagikan ke WhatsApp/Facebook jika postingan tidak ada foto.', 'hakajobs'),
        'section'     => 'hakajobs_seo_section',
    )));

    // =========================================================================
    // SECTION 9 — 💰 GOOGLE ADSENSE & PENEMPATAN IKLAN
    // =========================================================================
    $wp_customize->add_section('hakajobs_ads_section', array(
        'title'       => __('Google AdSense & Penempatan Iklan', 'hakajobs'),
        'description' => __('Monetisasi website Anda dengan Google AdSense atau banner sponsor kustom di berbagai posisi strategis.', 'hakajobs'),
        'panel'       => 'hakajobs_theme_options',
        'priority'    => 60,
    ));

    $wp_customize->add_setting('hakajobs_ads_enable', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
    ));
    $wp_customize->add_control('hakajobs_ads_enable', array(
        'type'        => 'checkbox',
        'label'       => __('Aktifkan Penayangan Iklan', 'hakajobs'),
        'description' => __('Nyalakan atau matikan seluruh slot iklan di website dengan satu klik.', 'hakajobs'),
        'section'     => 'hakajobs_ads_section',
    ));

    $wp_customize->add_setting('hakajobs_ads_demo_mode', array(
        'default'           => '0',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
    ));
    $wp_customize->add_control('hakajobs_ads_demo_mode', array(
        'type'        => 'checkbox',
        'label'       => __('Mode Preview Kotak Iklan (Placeholder)', 'hakajobs'),
        'description' => __('Centang ini untuk menampilkan kotak abu-abu di semua posisi iklan agar Anda bisa melihat tata letaknya sebelum akun AdSense disetujui.', 'hakajobs'),
        'section'     => 'hakajobs_ads_section',
    ));

    $wp_customize->add_setting('hakajobs_adsense_client', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hakajobs_adsense_client', array(
        'type'        => 'text',
        'label'       => __('ID Klien Google AdSense (Auto Ads)', 'hakajobs'),
        'description' => __('Contoh: ca-pub-1234567890123456. Ini otomatis memuat skrip resmi AdSense di seluruh halaman.', 'hakajobs'),
        'section'     => 'hakajobs_ads_section',
    ));

    $wp_customize->add_setting('hakajobs_ad_head_code', array(
        'default'           => '',
        'sanitize_callback' => 'hakajobs_sanitize_ad_code',
    ));
    $wp_customize->add_control('hakajobs_ad_head_code', array(
        'type'        => 'textarea',
        'label'       => __('Kode Kustom <head> Iklan / Verifikasi AdSense', 'hakajobs'),
        'description' => __('Skrip tambahan dari Google AdSense untuk peninjauan situs (Site Review).', 'hakajobs'),
        'section'     => 'hakajobs_ads_section',
    ));

    $wp_customize->add_setting('hakajobs_ad_slot_header', array(
        'default'           => '',
        'sanitize_callback' => 'hakajobs_sanitize_ad_code',
    ));
    $wp_customize->add_control('hakajobs_ad_slot_header', array(
        'type'        => 'textarea',
        'label'       => __('Slot Iklan Atas Konten (Banner 728x90 / Responsif)', 'hakajobs'),
        'description' => __('Tampil di antara hero dan konten utama pada beranda & arsip.', 'hakajobs'),
        'section'     => 'hakajobs_ads_section',
    ));

    $wp_customize->add_setting('hakajobs_ad_slot_sidebar', array(
        'default'           => '',
        'sanitize_callback' => 'hakajobs_sanitize_ad_code',
    ));
    $wp_customize->add_control('hakajobs_ad_slot_sidebar', array(
        'type'        => 'textarea',
        'label'       => __('Slot Iklan Sidebar (Kotak 300x250 / 300x600)', 'hakajobs'),
        'description' => __('Tampil di sidebar beranda, arsip loker, dan detail lowongan kerja.', 'hakajobs'),
        'section'     => 'hakajobs_ads_section',
    ));

    $wp_customize->add_setting('hakajobs_ad_slot_single_top', array(
        'default'           => '',
        'sanitize_callback' => 'hakajobs_sanitize_ad_code',
    ));
    $wp_customize->add_control('hakajobs_ad_slot_single_top', array(
        'type'        => 'textarea',
        'label'       => __('Slot Iklan Dalam Lowongan (Atas Deskripsi)', 'hakajobs'),
        'description' => __('Tampil di halaman detail lowongan sebelum teks deskripsi pekerjaan (CTR Tinggi).', 'hakajobs'),
        'section'     => 'hakajobs_ads_section',
    ));

    $wp_customize->add_setting('hakajobs_ad_slot_single_bottom', array(
        'default'           => '',
        'sanitize_callback' => 'hakajobs_sanitize_ad_code',
    ));
    $wp_customize->add_control('hakajobs_ad_slot_single_bottom', array(
        'type'        => 'textarea',
        'label'       => __('Slot Iklan Dalam Lowongan (Bawah Deskripsi)', 'hakajobs'),
        'description' => __('Tampil setelah kualifikasi dan benefit sebelum bagian peringatan keamanan.', 'hakajobs'),
        'section'     => 'hakajobs_ads_section',
    ));

    $wp_customize->add_setting('hakajobs_ad_slot_footer', array(
        'default'           => '',
        'sanitize_callback' => 'hakajobs_sanitize_ad_code',
    ));
    $wp_customize->add_control('hakajobs_ad_slot_footer', array(
        'type'        => 'textarea',
        'label'       => __('Slot Iklan Sebelum Footer (Banner Lebar)', 'hakajobs'),
        'description' => __('Tampil di atas banner anti penipuan pada seluruh halaman website.', 'hakajobs'),
        'section'     => 'hakajobs_ads_section',
    ));

    // =========================================================================
    // SECTION 10 — HALAMAN PASANG LOKER & TARIF
    // =========================================================================
    $wp_customize->add_section('hakajobs_postjob_section', array(
        'title'       => __('Halaman Pasang Loker & Tarif', 'hakajobs'),
        'description' => __('Atur nomor WhatsApp admin, email, dan tarif paket di halaman /pasang-loker/.', 'hakajobs'),
        'panel'       => 'hakajobs_theme_options',
        'priority'    => 95,
    ));

    // Nomor WhatsApp Admin
    $wp_customize->add_setting('hakajobs_contact_wa', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_contact_wa', array(
        'type'        => 'text',
        'label'       => __('Nomor WhatsApp Admin', 'hakajobs'),
        'description' => __('Menerima pesan otomatis pendaftaran lowongan dari form pasang loker. Format: 08123456789 atau 628123456789.', 'hakajobs'),
        'section'     => 'hakajobs_postjob_section',
    ));

    // Email Kontak Admin
    $wp_customize->add_setting('hakajobs_contact_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_contact_email', array(
        'type'        => 'email',
        'label'       => __('Email Admin / Perusahaan', 'hakajobs'),
        'description' => __('Email alternatif penerima data lowongan (jika kosong, menggunakan email admin WordPress).', 'hakajobs'),
        'section'     => 'hakajobs_postjob_section',
    ));

    // Tarif Paket Featured
    $wp_customize->add_setting('hakajobs_price_featured', array(
        'default'           => 'Rp 50.000',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_price_featured', array(
        'type'        => 'text',
        'label'       => __('Tarif Paket Featured', 'hakajobs'),
        'description' => __('Label harga paket Featured (Populer). Contoh: "Rp 50.000" atau "Rp 99.000".', 'hakajobs'),
        'section'     => 'hakajobs_postjob_section',
    ));

    // Tarif Paket Urgent
    $wp_customize->add_setting('hakajobs_price_urgent', array(
        'default'           => 'Rp 75.000',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_price_urgent', array(
        'type'        => 'text',
        'label'       => __('Tarif Paket Urgent', 'hakajobs'),
        'description' => __('Label harga paket Urgent (Prioritas). Contoh: "Rp 75.000" atau "Rp 150.000".', 'hakajobs'),
        'section'     => 'hakajobs_postjob_section',
    ));

    // =========================================================================
    // SECTION 11 — SALURAN WHATSAPP & BROADCAST LOKER
    // =========================================================================
    $wp_customize->add_section('hakajobs_wa_channel_section', array(
        'title'       => __('Saluran WhatsApp & Broadcast', 'hakajobs'),
        'description' => __('Atur link Saluran WhatsApp resmi Anda untuk broadcast 1-klik loker dan banner undangan pengunjung.', 'hakajobs'),
        'panel'       => 'hakajobs_theme_options',
        'priority'    => 105,
    ));

    // Link Saluran WhatsApp
    $wp_customize->add_setting('hakajobs_wa_channel_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_wa_channel_url', array(
        'type'        => 'url',
        'label'       => __('Tautan Saluran WhatsApp (Channel URL)', 'hakajobs'),
        'description' => __('Contoh: https://whatsapp.com/channel/0029Va... atau link invite grup WA. Tautan ini akan otomatis disertakan pada teks broadcast dan tombol publik.', 'hakajobs'),
        'section'     => 'hakajobs_wa_channel_section',
    ));

    // Nama Saluran WhatsApp
    $wp_customize->add_setting('hakajobs_wa_channel_name', array(
        'default'           => __('Saluran Resmi Info Loker', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_wa_channel_name', array(
        'type'        => 'text',
        'label'       => __('🏷️ Nama Saluran / Komunitas WA', 'hakajobs'),
        'description' => __('Nama tampilan saluran yang dicantumkan pada teks broadcast.', 'hakajobs'),
        'section'     => 'hakajobs_wa_channel_section',
    ));

    // Judul Header Broadcast
    $wp_customize->add_setting('hakajobs_wa_broadcast_heading', array(
        'default'           => '📢 LOWONGAN KERJA TERBARU',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_wa_broadcast_heading', array(
        'type'        => 'text',
        'label'       => __('📝 Header Teks Pesan Broadcast', 'hakajobs'),
        'description' => __('Judul pesan baris pertama pada saat teks broadcast digenerate.', 'hakajobs'),
        'section'     => 'hakajobs_wa_channel_section',
    ));

    // Tampilkan Banner Publik Gabung Saluran WA di Single Job & Footer
    $wp_customize->add_setting('hakajobs_wa_show_public_widget', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_wa_show_public_widget', array(
        'type'        => 'checkbox',
        'label'       => __('Tampilkan Banner Ajakan Saluran WA ke Pengunjung', 'hakajobs'),
        'description' => __('Membantu meningkatkan follower Saluran WhatsApp Anda secara gratis dari pengunjung setia website.', 'hakajobs'),
        'section'     => 'hakajobs_wa_channel_section',
    ));

    // Judul Banner Publik
    $wp_customize->add_setting('hakajobs_wa_public_cta_title', array(
        'default'           => __('Dapatkan Info Lowongan Kerja Harian di WhatsApp Anda!', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_wa_public_cta_title', array(
        'type'        => 'text',
        'label'       => __('Judul Banner Publik', 'hakajobs'),
        'section'     => 'hakajobs_wa_channel_section',
    ));

    // Deskripsi Banner Publik
    $wp_customize->add_setting('hakajobs_wa_public_cta_desc', array(
        'default'           => __('Ikuti Saluran WhatsApp resmi kami. Gratis, tanpa spam, dan langsung terupdate setiap hari di ponsel Anda.', 'hakajobs'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_wa_public_cta_desc', array(
        'type'        => 'textarea',
        'label'       => __('Deskripsi Banner Publik', 'hakajobs'),
        'section'     => 'hakajobs_wa_channel_section',
    ));

    // Teks Tombol Banner Publik
    $wp_customize->add_setting('hakajobs_wa_public_btn_text', array(
        'default'           => __('Gabung Saluran WhatsApp', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_wa_public_btn_text', array(
        'type'        => 'text',
        'label'       => __('Teks Tombol Banner Publik', 'hakajobs'),
        'section'     => 'hakajobs_wa_channel_section',
    ));

    // =========================================================================
    // SECTION 12 — SIDEBAR KANAN (BERANDA & HALAMAN STATIS)
    // =========================================================================
    $wp_customize->add_section('hakajobs_sidebar_section', array(
        'title'       => __('Sidebar Kanan (Beranda & Halaman)', 'hakajobs'),
        'description' => __('Atur tampilan dan isi widget sidebar kanan: Pasang Loker, Kategori Populer, Lokasi Kerja Teratas, dan Tips Melamar Efektif.', 'hakajobs'),
        'panel'       => 'hakajobs_theme_options',
        'priority'    => 36,
    ));

    // --- Pengaturan Tampilan Halaman Statis ---
    $wp_customize->add_setting('hakajobs_sidebar_show_on_pages', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_show_on_pages', array(
        'type'        => 'checkbox',
        'label'       => __('Tampilkan Sidebar di Halaman Statis Standar (page.php)', 'hakajobs'),
        'description' => __('Jika diaktifkan, halaman statis seperti Tentang Kami atau Kontak akan menggunakan tata letak dua kolom dengan sidebar kanan.', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
    ));

    // --- WIDGET 1: PASANG LOKER (UNTUK PERUSAHAAN / REKRUTER) ---
    $wp_customize->add_setting('hakajobs_sidebar_show_post_job', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_show_post_job', array(
        'type'        => 'checkbox',
        'label'       => __('1. Tampilkan Widget "Pasang Loker"', 'hakajobs'),
        'description' => __('Kartu ajakan pasang lowongan kerja untuk perusahaan/rekruter dengan gaya dark navy.', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
    ));

    $wp_customize->add_setting('hakajobs_sidebar_post_job_badge', array(
        'default'           => 'UNTUK PERUSAHAAN / REKRUTER',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_post_job_badge', array(
        'type'        => 'text',
        'label'       => __('Label Badge Rekruter', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
    ));

    $wp_customize->add_setting('hakajobs_sidebar_post_job_title', array(
        'default'           => __('Punya Lowongan Kerja?', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_post_job_title', array(
        'type'        => 'text',
        'label'       => __('Judul Pasang Loker', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
    ));

    $wp_customize->add_setting('hakajobs_sidebar_post_job_desc', array(
        'default'           => __('Pasang info lowongan kerja Anda di Hakajobs dan dapatkan pelamar berkualitas langsung ke WhatsApp atau Email perusahaan Anda.', 'hakajobs'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_post_job_desc', array(
        'type'        => 'textarea',
        'label'       => __('Deskripsi Pasang Loker', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
    ));

    $wp_customize->add_setting('hakajobs_sidebar_post_job_btn_text', array(
        'default'           => 'Pasang Iklan Loker →',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_post_job_btn_text', array(
        'type'        => 'text',
        'label'       => __('Teks Tombol Pasang Loker', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
    ));

    $wp_customize->add_setting('hakajobs_sidebar_post_job_btn_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_post_job_btn_url', array(
        'type'        => 'url',
        'label'       => __('Tautan Tombol Pasang Loker (URL)', 'hakajobs'),
        'description' => __('Kosongkan untuk otomatis mengarah ke halaman /pasang-loker/ bawaan tema.', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
    ));

    // --- WIDGET 2: KATEGORI POPULER ---
    $wp_customize->add_setting('hakajobs_sidebar_show_cats', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_show_cats', array(
        'type'        => 'checkbox',
        'label'       => __('2. Tampilkan Widget "Kategori Populer"', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
    ));

    $wp_customize->add_setting('hakajobs_sidebar_cats_title', array(
        'default'           => __('Kategori Populer', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_cats_title', array(
        'type'        => 'text',
        'label'       => __('Judul Widget Kategori', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
    ));

    $wp_customize->add_setting('hakajobs_sidebar_cats_count', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_cats_count', array(
        'type'        => 'number',
        'label'       => __('Jumlah Kategori Ditampilkan', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 30,
            'step' => 1,
        ),
    ));

    $wp_customize->add_setting('hakajobs_sidebar_cats_hide_empty', array(
        'default'           => '0',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_cats_hide_empty', array(
        'type'        => 'checkbox',
        'label'       => __('Sembunyikan Kategori yang Tidak Memiliki Lowongan (0 loker)', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
    ));

    $wp_customize->add_setting('hakajobs_sidebar_cats_orderby', array(
        'default'           => 'count',
        'sanitize_callback' => 'hakajobs_sanitize_select',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_cats_orderby', array(
        'type'        => 'select',
        'label'       => __('Urutan Kategori', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
        'choices'     => array(
            'count' => __('Jumlah Lowongan Terbanyak (Populer)', 'hakajobs'),
            'name'  => __('Sesuai Abjad Nama (A-Z)', 'hakajobs'),
        ),
    ));

    // --- WIDGET 3: LOKASI KERJA TERATAS ---
    $wp_customize->add_setting('hakajobs_sidebar_show_locs', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_show_locs', array(
        'type'        => 'checkbox',
        'label'       => __('3. Tampilkan Widget "Lokasi Kerja Teratas"', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
    ));

    $wp_customize->add_setting('hakajobs_sidebar_locs_title', array(
        'default'           => __('Lokasi Kerja Teratas', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_locs_title', array(
        'type'        => 'text',
        'label'       => __('Judul Widget Lokasi', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
    ));

    $wp_customize->add_setting('hakajobs_sidebar_locs_count', array(
        'default'           => 8,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_locs_count', array(
        'type'        => 'number',
        'label'       => __('Jumlah Lokasi Ditampilkan', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 40,
            'step' => 1,
        ),
    ));

    $wp_customize->add_setting('hakajobs_sidebar_locs_hide_empty', array(
        'default'           => '0',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_locs_hide_empty', array(
        'type'        => 'checkbox',
        'label'       => __('Sembunyikan Lokasi yang Tidak Memiliki Lowongan (0 loker)', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
    ));

    $wp_customize->add_setting('hakajobs_sidebar_locs_orderby', array(
        'default'           => 'count',
        'sanitize_callback' => 'hakajobs_sanitize_select',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_locs_orderby', array(
        'type'        => 'select',
        'label'       => __('Urutan Lokasi', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
        'choices'     => array(
            'count' => __('Jumlah Lowongan Terbanyak (Teratas)', 'hakajobs'),
            'name'  => __('Sesuai Abjad Nama Kota/Provinsi (A-Z)', 'hakajobs'),
        ),
    ));

    // --- WIDGET 4: TIPS MELAMAR EFEKTIF ---
    $wp_customize->add_setting('hakajobs_sidebar_show_tips', array(
        'default'           => '1',
        'sanitize_callback' => 'hakajobs_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_show_tips', array(
        'type'        => 'checkbox',
        'label'       => __('4. Tampilkan Widget "💡 Tips Melamar Efektif"', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
    ));

    $wp_customize->add_setting('hakajobs_sidebar_tips_title', array(
        'default'           => __('💡 Tips Melamar Efektif', 'hakajobs'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_tips_title', array(
        'type'        => 'text',
        'label'       => __('Judul Widget Tips', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
    ));

    $default_tips_text = "Sesuaikan CV Anda dengan kata kunci yang diminta pada kualifikasi lowongan.\nGunakan format PDF dengan nama file yang jelas (contoh: CV_NamaLengkap_Posisi.pdf).\nSaat melamar via WhatsApp, gunakan bahasa yang santun dan perkenalkan diri secara ringkas.";
    $wp_customize->add_setting('hakajobs_sidebar_tips_content', array(
        'default'           => $default_tips_text,
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_tips_content', array(
        'type'        => 'textarea',
        'label'       => __('Daftar Butir Poin Tips', 'hakajobs'),
        'description' => __('Ketik satu butir tips per baris (tekan Enter untuk poin baru). Setiap baris akan otomatis ditampilkan sebagai butir daftar berpeluru.', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
    ));

    // --- INTEGRASI WIDGET WORDPRESS ---
    $wp_customize->add_setting('hakajobs_sidebar_wp_widgets_pos', array(
        'default'           => 'after',
        'sanitize_callback' => 'hakajobs_sanitize_select',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('hakajobs_sidebar_wp_widgets_pos', array(
        'type'        => 'select',
        'label'       => __('Posisi Widget WordPress Kustom (Tampilan > Widget)', 'hakajobs'),
        'description' => __('Tentukan di mana widget kustom dari area "Sidebar Kanan (Beranda & Halaman Statis)" akan diletakkan.', 'hakajobs'),
        'section'     => 'hakajobs_sidebar_section',
        'choices'     => array(
            'after'   => __('Tampilkan Setelah Widget Bawaan Tema (Bawah)', 'hakajobs'),
            'before'  => __('Tampilkan Sebelum Widget Bawaan Tema (Atas)', 'hakajobs'),
            'replace' => __('Gantikan Semua Widget Bawaan (Hanya Widget WP)', 'hakajobs'),
        ),
    ));
}
add_action('customize_register', 'hakajobs_customize_register');

/**
 * Sanitize Raw Ad Code Callback (allows script, ins, style, iframe)
 */
function hakajobs_sanitize_ad_code($input) {
    if (current_user_can('unfiltered_html')) {
        return $input;
    }
    return wp_kses_post($input);
}

/**
 * Sanitize Checkbox Callback
 */
function hakajobs_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? '1' : '0');
}

/**
 * Sanitize Select Callback
 */
function hakajobs_sanitize_select($input, $setting) {
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Output Dynamic CSS from Customizer values
 */
function hakajobs_customizer_css() {
    $primary        = get_theme_mod('hakajobs_primary_color', '#0284c7');
    $primary_hover  = get_theme_mod('hakajobs_primary_hover_color', '#0369a1');
    $dark           = get_theme_mod('hakajobs_dark_color', '#0f172a');
    $accent         = get_theme_mod('hakajobs_accent_color', '#0f766e');
    $wa_color       = get_theme_mod('hakajobs_wa_color', '#16a34a');
    $body_bg        = get_theme_mod('hakajobs_body_bg', '#f8fafc');
    $btt_color      = get_theme_mod('hakajobs_backtotop_color', '#0284c7');
    $sticky         = get_theme_mod('hakajobs_sticky_header', '1');
    $logo_height    = get_theme_mod('hakajobs_logo_max_height', 42);
    $logo_text_size = get_theme_mod('hakajobs_logo_text_size', 20);
    $logo_icon_size = get_theme_mod('hakajobs_logo_icon_size', 26);
    $hero_bg_start  = get_theme_mod('hakajobs_hero_bg_start', '#0f172a');
    $hero_bg_end    = get_theme_mod('hakajobs_hero_bg_end', '#0f3460');
    ?>
    <style id="hakajobs-customizer-inline-css">
        :root {
            --hk-primary: <?php echo esc_attr($primary); ?>;
            --hk-primary-hover: <?php echo esc_attr($primary_hover); ?>;
            --hk-dark: <?php echo esc_attr($dark); ?>;
            --hk-accent: <?php echo esc_attr($accent); ?>;
            --hk-wa-green: <?php echo esc_attr($wa_color); ?>;
            --hk-bg-body: <?php echo esc_attr($body_bg); ?>;
            --hk-btt-color: <?php echo esc_attr($btt_color); ?>;
        }
        .hk-topbar,
        .hk-site-footer {
            background-color: var(--hk-dark) !important;
        }
        .hk-hero-pasangloker-theme {
            background: linear-gradient(135deg, <?php echo esc_attr($hero_bg_start); ?> 0%, #0c2340 50%, <?php echo esc_attr($hero_bg_end); ?> 100%) !important;
        }
        .hk-back-to-top {
            background-color: var(--hk-btt-color) !important;
        }
        .hk-btn-wa {
            background-color: var(--hk-wa-green) !important;
        }
        /* Pengaturan Besar Kecil Logo Header */
        .hk-custom-logo img,
        .custom-logo {
            max-height: <?php echo intval($logo_height); ?>px !important;
            width: auto !important;
            height: auto !important;
            object-fit: contain !important;
        }
        .hk-site-title {
            font-size: <?php echo intval($logo_text_size); ?>px !important;
        }
        .hk-logo-icon {
            font-size: <?php echo intval($logo_icon_size); ?>px !important;
        }
        <?php if ($sticky === '1'): ?>
        .hk-site-header {
            position: sticky;
            top: 0;
            z-index: 500;
        }
        .admin-bar .hk-site-header {
            top: 32px;
        }
        @media (max-width: 782px) {
            .admin-bar .hk-site-header {
                top: 46px;
            }
        }
        @media (max-width: 600px) {
            .admin-bar .hk-site-header {
                top: 0;
            }
        }
        <?php else: ?>
        .hk-site-header {
            position: relative;
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action('wp_head', 'hakajobs_customizer_css', 100);
