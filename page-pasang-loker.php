<?php
/**
 * Template Name: Pasang Loker
 * Template Post Type: page
 *
 * Halaman landing untuk perusahaan yang ingin memasang lowongan kerja.
 * Menampilkan paket tarif, keunggulan, dan form pengiriman info loker.
 *
 * @package Hakajobs
 */

get_header();

// Ambil pengaturan kontak dari Customizer
$wa_number  = get_theme_mod('hakajobs_contact_wa', '');
$wa_clean   = preg_replace('/[^0-9]/', '', $wa_number);
if (str_starts_with($wa_clean, '0')) {
    $wa_clean = '62' . substr($wa_clean, 1);
}
$contact_email = get_theme_mod('hakajobs_contact_email', get_bloginfo('admin_email'));
$site_name     = get_bloginfo('name');

// Pesan template WhatsApp untuk paket
$wa_msg_basic = rawurlencode(
    "Halo Tim Admin {$site_name},\n\n" .
    "Saya ingin mengajukan pemasangan lowongan kerja untuk *Paket BASIC (Gratis)*. Berikut rincian informasinya:\n\n" .
    "📋 *DATA LOWONGAN KERJA:*\n" .
    "━━━━━━━━━━━━━━━━━━━━\n" .
    "• Nama Perusahaan : \n" .
    "• Posisi Lowongan : \n" .
    "• Lokasi Kerja    : \n" .
    "• Tipe Pekerjaan  : (Full-Time / Part-Time / Freelance / Magang)\n" .
    "• Kisaran Gaji    : \n" .
    "• Batas Lamaran   : \n" .
    "• Kontak HRD      : (No. WhatsApp / Email Lamaran)\n\n" .
    "📝 *Deskripsi Singkat & Kualifikasi:*\n" .
    "(Tuliskan kualifikasi singkat dan persyaratan)\n\n" .
    "━━━━━━━━━━━━━━━━━━━━\n" .
    "Mohon bantuan untuk verifikasi dan proses penayangannya. Terima kasih!"
);

$wa_msg_featured = rawurlencode(
    "Halo Tim Admin {$site_name},\n\n" .
    "Saya ingin mengajukan pemasangan lowongan kerja untuk *Paket FEATURED (Sorotan Berbayar)*. Berikut rincian informasinya:\n\n" .
    "📋 *DATA LOWONGAN KERJA:*\n" .
    "━━━━━━━━━━━━━━━━━━━━\n" .
    "• Nama Perusahaan : \n" .
    "• Posisi Lowongan : \n" .
    "• Lokasi Kerja    : \n" .
    "• Tipe Pekerjaan  : \n" .
    "• Kisaran Gaji    : \n" .
    "• Batas Lamaran   : \n" .
    "• Kontak HRD      : (No. WhatsApp / Email Lamaran)\n\n" .
    "📝 *Deskripsi Singkat & Kualifikasi:*\n" .
    "(Tuliskan kualifikasi singkat dan persyaratan)\n\n" .
    "━━━━━━━━━━━━━━━━━━━━\n" .
    "Mohon informasi rekening pembayaran dan konfirmasi penayangannya. Terima kasih!"
);

$wa_msg_urgent = rawurlencode(
    "Halo Tim Admin {$site_name},\n\n" .
    "Saya ingin mengajukan pemasangan lowongan kerja untuk *Paket URGENT (Prioritas Utama)*. Berikut rincian informasinya:\n\n" .
    "📋 *DATA LOWONGAN KERJA:*\n" .
    "━━━━━━━━━━━━━━━━━━━━\n" .
    "• Nama Perusahaan : \n" .
    "• Posisi Lowongan : \n" .
    "• Lokasi Kerja    : \n" .
    "• Tipe Pekerjaan  : \n" .
    "• Kisaran Gaji    : \n" .
    "• Batas Lamaran   : \n" .
    "• Kontak HRD      : (No. WhatsApp / Email Lamaran)\n\n" .
    "📝 *Deskripsi Singkat & Kualifikasi:*\n" .
    "(Tuliskan kualifikasi singkat dan persyaratan)\n\n" .
    "━━━━━━━━━━━━━━━━━━━━\n" .
    "Mohon informasi rekening pembayaran dan konfirmasi penayangan prioritas 1x24 jam. Terima kasih!"
);

$wa_url_basic    = !empty($wa_clean) ? "https://wa.me/{$wa_clean}?text={$wa_msg_basic}" : "mailto:{$contact_email}";
$wa_url_featured = !empty($wa_clean) ? "https://wa.me/{$wa_clean}?text={$wa_msg_featured}" : "mailto:{$contact_email}";
$wa_url_urgent   = !empty($wa_clean) ? "https://wa.me/{$wa_clean}?text={$wa_msg_urgent}" : "mailto:{$contact_email}";
?>

<?php 
if (!wp_style_is('hakajobs-pasang-loker', 'enqueued')) {
    wp_enqueue_style('hakajobs-pasang-loker', get_template_directory_uri() . '/assets/css/pasang-loker.css', array('hakajobs-main-style'), HAKAJOBS_VERSION);
}
?>

<main id="hk-main" class="hk-pasang-loker-page">

    <!-- ===================== HERO SECTION ===================== -->
    <section class="hkpl-hero">
        <div class="hk-container">
            <div class="hkpl-hero-badge">
                <span>💼</span> Platform Loker Terpercaya
            </div>
            <h1 class="hkpl-hero-title">
                Pasang Lowongan Kerja,<br>
                <span class="hkpl-hero-highlight">Temukan Kandidat Terbaik</span>
            </h1>
            <p class="hkpl-hero-sub">
                Jangkau ribuan pencari kerja aktif di wilayah Anda. Proses cepat, tayang dalam 1×24 jam, langsung ke target yang tepat.
            </p>
            <div class="hkpl-hero-stats">
                <div class="hkpl-stat">
                    <span class="hkpl-stat-num">10rb+</span>
                    <span class="hkpl-stat-label">Pencari Kerja Aktif</span>
                </div>
                <div class="hkpl-stat-sep"></div>
                <div class="hkpl-stat">
                    <span class="hkpl-stat-num">500+</span>
                    <span class="hkpl-stat-label">Lowongan Tayang</span>
                </div>
                <div class="hkpl-stat-sep"></div>
                <div class="hkpl-stat">
                    <span class="hkpl-stat-num">1×24 Jam</span>
                    <span class="hkpl-stat-label">Waktu Tayang</span>
                </div>
            </div>
        </div>
        <div class="hkpl-hero-wave">
            <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0 60L60 50C120 40 240 20 360 16.7C480 13.3 600 26.7 720 33.3C840 40 960 40 1080 33.3C1200 26.7 1320 13.3 1380 6.7L1440 0V60H1380C1320 60 1200 60 1080 60C960 60 840 60 720 60C600 60 480 60 360 60C240 60 120 60 60 60H0Z" fill="#f8fafc"/></svg>
        </div>
    </section>

    <!-- ===================== KEUNGGULAN ===================== -->
    <section class="hkpl-features">
        <div class="hk-container">
            <div class="hkpl-features-grid">
                <div class="hkpl-feature-card">
                    <div class="hkpl-feature-icon">🎯</div>
                    <h3>Tepat Sasaran</h3>
                    <p>Lowongan Anda tampil ke pencari kerja yang aktif mencari di daerah & bidang yang relevan.</p>
                </div>
                <div class="hkpl-feature-card">
                    <div class="hkpl-feature-icon">⚡</div>
                    <h3>Tayang Cepat</h3>
                    <p>Verifikasi & publikasi dalam 1×24 jam. Hubungi admin sekarang dan loker langsung naik.</p>
                </div>
                <div class="hkpl-feature-card">
                    <div class="hkpl-feature-icon">🛡️</div>
                    <h3>Bebas Spam</h3>
                    <p>Setiap lowongan diverifikasi admin. Tidak ada loker palsu atau penipuan yang merugikan brand Anda.</p>
                </div>
                <div class="hkpl-feature-card">
                    <div class="hkpl-feature-icon">🔍</div>
                    <h3>SEO Google Jobs</h3>
                    <p>Loker Anda otomatis muncul di Google Jobs berkat schema JobPosting terstruktur.</p>
                </div>
                <div class="hkpl-feature-card">
                    <div class="hkpl-feature-icon">📲</div>
                    <h3>Lamaran via WA</h3>
                    <p>Kandidat melamar langsung ke WhatsApp / email HRD Anda. Tidak perlu sistem login rumit.</p>
                </div>
                <div class="hkpl-feature-card">
                    <div class="hkpl-feature-icon">📊</div>
                    <h3>Branding Perusahaan</h3>
                    <p>Logo perusahaan tampil menonjol di setiap kartu lowongan. Tingkatkan brand awareness Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== PAKET TARIF ===================== -->
    <section class="hkpl-pricing" id="paket-loker">
        <div class="hk-container">
            <div class="hkpl-section-header">
                <span class="hkpl-section-badge">Pilih Paket</span>
                <h2>Tarif Pasang Loker</h2>
                <p>Pilih paket yang sesuai kebutuhan rekrutmen Anda</p>
            </div>

            <div class="hkpl-pricing-grid">

                <!-- Paket Basic -->
                <div class="hkpl-pricing-card">
                    <div class="hkpl-pricing-header">
                        <div class="hkpl-pricing-icon">📋</div>
                        <h3 class="hkpl-pricing-name">Basic</h3>
                        <div class="hkpl-pricing-price">
                            <span class="hkpl-price-amount">Gratis</span>
                        </div>
                        <p class="hkpl-pricing-desc">Cocok untuk UKM dan startup yang baru mulai rekrut</p>
                    </div>
                    <ul class="hkpl-pricing-features">
                        <li><span class="hkpl-check">✓</span> Tayang 30 hari</li>
                        <li><span class="hkpl-check">✓</span> Tampil di halaman arsip loker</span></li>
                        <li><span class="hkpl-check">✓</span> Logo perusahaan (avatar inisial)</li>
                        <li><span class="hkpl-check">✓</span> Muncul di Google Jobs (SEO)</li>
                        <li><span class="hkpl-check">✓</span> Lamaran via WA / Email / Web</li>
                        <li><span class="hkpl-muted">✗</span> Badge Featured / Urgent</li>
                        <li><span class="hkpl-muted">✗</span> Prioritas tampil di atas</li>
                        <li><span class="hkpl-muted">✗</span> Logo perusahaan (upload sendiri)</li>
                    </ul>
                    <a href="<?php echo esc_url($wa_url_basic); ?>" class="hkpl-btn hkpl-btn-outline" target="_blank" rel="noopener" id="hkpl-btn-basic">
                        <?php echo !empty($wa_clean) ? '💬 Chat Admin' : '📧 Email Admin'; ?>
                    </a>
                </div>

                <!-- Paket Featured (POPULER) -->
                <div class="hkpl-pricing-card hkpl-pricing-popular">
                    <div class="hkpl-popular-badge">⭐ Paling Populer</div>
                    <div class="hkpl-pricing-header">
                        <div class="hkpl-pricing-icon">🌟</div>
                        <h3 class="hkpl-pricing-name">Featured</h3>
                        <div class="hkpl-pricing-price">
                            <span class="hkpl-price-amount"><?php echo esc_html(get_theme_mod('hakajobs_price_featured', 'Rp 50.000')); ?></span>
                            <span class="hkpl-price-period">/ 30 hari</span>
                        </div>
                        <p class="hkpl-pricing-desc">Untuk perusahaan yang ingin mendapat lebih banyak pelamar berkualitas</p>
                    </div>
                    <ul class="hkpl-pricing-features">
                        <li><span class="hkpl-check">✓</span> Tayang 30 hari</li>
                        <li><span class="hkpl-check">✓</span> Badge <strong>"Featured"</strong> di kartu loker</li>
                        <li><span class="hkpl-check">✓</span> Prioritas tampil di urutan atas</li>
                        <li><span class="hkpl-check">✓</span> Upload logo perusahaan sendiri</li>
                        <li><span class="hkpl-check">✓</span> Muncul di Google Jobs (SEO)</li>
                        <li><span class="hkpl-check">✓</span> Lamaran via WA / Email / Web</li>
                        <li><span class="hkpl-check">✓</span> Preview kartu loker sebelum tayang</li>
                        <li><span class="hkpl-check">✓</span> Notifikasi WhatsApp ke Admin</li>
                    </ul>
                    <a href="<?php echo esc_url($wa_url_featured); ?>" class="hkpl-btn hkpl-btn-primary" target="_blank" rel="noopener" id="hkpl-btn-featured">
                        <?php echo !empty($wa_clean) ? '💬 Pasang Sekarang' : '📧 Hubungi Admin'; ?>
                    </a>
                </div>

                <!-- Paket Urgent -->
                <div class="hkpl-pricing-card">
                    <div class="hkpl-pricing-header">
                        <div class="hkpl-pricing-icon">🔥</div>
                        <h3 class="hkpl-pricing-name">Urgent</h3>
                        <div class="hkpl-pricing-price">
                            <span class="hkpl-price-amount"><?php echo esc_html(get_theme_mod('hakajobs_price_urgent', 'Rp 75.000')); ?></span>
                            <span class="hkpl-price-period">/ 14 hari</span>
                        </div>
                        <p class="hkpl-pricing-desc">Rekrut cepat! Untuk posisi yang harus diisi dalam waktu singkat</p>
                    </div>
                    <ul class="hkpl-pricing-features">
                        <li><span class="hkpl-check">✓</span> Tayang 14 hari (rekrut cepat)</li>
                        <li><span class="hkpl-check">✓</span> Badge <strong>"🔥 Urgent"</strong> mencolok</li>
                        <li><span class="hkpl-check">✓</span> <strong>Posisi teratas</strong> di atas Featured</li>
                        <li><span class="hkpl-check">✓</span> Upload logo perusahaan sendiri</li>
                        <li><span class="hkpl-check">✓</span> Muncul di Google Jobs (SEO)</li>
                        <li><span class="hkpl-check">✓</span> Lamaran via WA / Email / Web</li>
                        <li><span class="hkpl-check">✓</span> Preview kartu loker sebelum tayang</li>
                        <li><span class="hkpl-check">✓</span> Prioritas respons admin hari ini</li>
                    </ul>
                    <a href="<?php echo esc_url($wa_url_urgent); ?>" class="hkpl-btn hkpl-btn-urgent" target="_blank" rel="noopener" id="hkpl-btn-urgent">
                        <?php echo !empty($wa_clean) ? '🔥 Pasang Urgent' : '📧 Hubungi Admin'; ?>
                    </a>
                </div>

            </div>

            <p class="hkpl-pricing-note">
                💡 <strong>Catatan:</strong> Harga dapat disesuaikan. Hubungi admin untuk paket bundling atau diskon khusus pengguna pertama.
            </p>
        </div>
    </section>

    <!-- ===================== CARA PASANG ===================== -->
    <section class="hkpl-how">
        <div class="hk-container">
            <div class="hkpl-section-header">
                <span class="hkpl-section-badge">Mudah & Cepat</span>
                <h2>Cara Pasang Loker</h2>
                <p>Hanya 3 langkah, loker Anda langsung tayang</p>
            </div>
            <div class="hkpl-steps">
                <div class="hkpl-step">
                    <div class="hkpl-step-num">1</div>
                    <div class="hkpl-step-body">
                        <h3>Kirim Detail Lowongan</h3>
                        <p>Hubungi admin via WhatsApp atau email dengan info lengkap: nama perusahaan, posisi, lokasi, gaji, dan kontak HRD.</p>
                    </div>
                </div>
                <div class="hkpl-step-arrow">→</div>
                <div class="hkpl-step">
                    <div class="hkpl-step-num">2</div>
                    <div class="hkpl-step-body">
                        <h3>Verifikasi & Pembayaran</h3>
                        <p>Admin memverifikasi data dan mengkonfirmasi paket pilihan Anda. Pembayaran untuk paket berbayar bisa via transfer bank atau dompet digital.</p>
                    </div>
                </div>
                <div class="hkpl-step-arrow">→</div>
                <div class="hkpl-step">
                    <div class="hkpl-step-num">3</div>
                    <div class="hkpl-step-body">
                        <h3>Loker Tayang!</h3>
                        <p>Lowongan Anda langsung tayang dan dapat ditemukan oleh ribuan pencari kerja aktif, termasuk melalui Google Jobs.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== FORM KIRIM LOKER ===================== -->
    <section class="hkpl-form-section" id="form-loker">
        <div class="hk-container">
            <div class="hkpl-form-wrap">
                <div class="hkpl-form-info">
                    <h2>Kirim Data Lowongan</h2>
                    <p>Isi form di bawah ini dan admin akan segera menghubungi Anda dalam waktu 1×24 jam.</p>
                    <?php if (!empty($wa_clean)): ?>
                    <a href="https://wa.me/<?php echo esc_attr($wa_clean); ?>" class="hkpl-contact-wa" target="_blank" rel="noopener" id="hkpl-contact-wa-link">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp Admin Sekarang
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($contact_email)): ?>
                    <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="hkpl-contact-email" id="hkpl-contact-email-link">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
                        <?php echo esc_html($contact_email); ?>
                    </a>
                    <?php endif; ?>
                </div>

                <form class="hkpl-form" id="hkpl-submission-form" novalidate>
                    <div class="hkpl-form-row hkpl-form-row-2">
                        <div class="hkpl-form-group">
                            <label for="hkpl-company">Nama Perusahaan <span class="hkpl-required">*</span></label>
                            <input type="text" id="hkpl-company" name="company" placeholder="PT Maju Bersama" required>
                        </div>
                        <div class="hkpl-form-group">
                            <label for="hkpl-position">Posisi / Jabatan <span class="hkpl-required">*</span></label>
                            <input type="text" id="hkpl-position" name="position" placeholder="Staff Administrasi" required>
                        </div>
                    </div>
                    <div class="hkpl-form-row hkpl-form-row-2">
                        <div class="hkpl-form-group">
                            <label for="hkpl-location">Lokasi Kerja <span class="hkpl-required">*</span></label>
                            <input type="text" id="hkpl-location" name="location" placeholder="Jakarta Selatan">
                        </div>
                        <div class="hkpl-form-group">
                            <label for="hkpl-jobtype">Tipe Pekerjaan</label>
                            <select id="hkpl-jobtype" name="jobtype">
                                <option value="">-- Pilih Tipe --</option>
                                <option>Full-Time</option>
                                <option>Part-Time</option>
                                <option>Magang (Internship)</option>
                                <option>Freelance / Kontrak</option>
                                <option>Remote / WFH</option>
                            </select>
                        </div>
                    </div>
                    <div class="hkpl-form-row hkpl-form-row-2">
                        <div class="hkpl-form-group">
                            <label for="hkpl-salary">Kisaran Gaji</label>
                            <input type="text" id="hkpl-salary" name="salary" placeholder="Rp 5.000.000 – Rp 7.000.000">
                        </div>
                        <div class="hkpl-form-group">
                            <label for="hkpl-deadline">Deadline Lamaran</label>
                            <input type="date" id="hkpl-deadline" name="deadline">
                        </div>
                    </div>
                    <div class="hkpl-form-group">
                        <label for="hkpl-desc">Deskripsi Singkat Pekerjaan <span class="hkpl-required">*</span></label>
                        <textarea id="hkpl-desc" name="description" rows="4" placeholder="Tugas utama, syarat & kualifikasi yang dibutuhkan..." required></textarea>
                    </div>
                    <div class="hkpl-form-row hkpl-form-row-2">
                        <div class="hkpl-form-group">
                            <label for="hkpl-contact">Kontak HRD (WA/Email) <span class="hkpl-required">*</span></label>
                            <input type="text" id="hkpl-contact" name="contact" placeholder="08xxxxxxxxxx / email@perusahaan.com" required>
                        </div>
                        <div class="hkpl-form-group">
                            <label for="hkpl-package">Paket yang Dipilih</label>
                            <select id="hkpl-package" name="package">
                                <option value="Basic">Basic (Gratis)</option>
                                <option value="Featured">Featured (Berbayar)</option>
                                <option value="Urgent">Urgent (Berbayar)</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="hkpl-btn hkpl-btn-primary hkpl-btn-submit" id="hkpl-submit-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2L15 22 11 13 2 9l20-7z"/></svg>
                        Kirim via WhatsApp
                    </button>
                    <p class="hkpl-form-note">Form ini akan membuka WhatsApp dengan data yang sudah terisi otomatis.</p>
                </form>
            </div>
        </div>
    </section>

    <!-- ===================== FAQ ===================== -->
    <section class="hkpl-faq">
        <div class="hk-container">
            <div class="hkpl-section-header">
                <h2>Pertanyaan Umum</h2>
            </div>
            <div class="hkpl-faq-list" id="hkpl-faq-list">
                <?php
                $faqs = array(
                    array(
                        'q' => 'Berapa lama loker saya akan tayang?',
                        'a' => 'Admin akan memproses dan mempublikasikan lowongan Anda dalam 1×24 jam setelah data diterima dan (untuk paket berbayar) pembayaran dikonfirmasi.'
                    ),
                    array(
                        'q' => 'Format apa yang harus saya kirimkan?',
                        'a' => 'Anda bisa mengisi form di halaman ini dan otomatis terformat, atau kirim langsung via WhatsApp dengan format: Nama Perusahaan, Posisi, Lokasi, Gaji, Deadline, Deskripsi, dan Kontak HRD.'
                    ),
                    array(
                        'q' => 'Apakah lowongan saya muncul di Google?',
                        'a' => 'Ya! Setiap lowongan yang tayang otomatis dilengkapi schema JobPosting yang diakui Google. Loker Anda berpotensi muncul di Google Jobs dan hasil pencarian organik.'
                    ),
                    array(
                        'q' => 'Metode pembayaran apa yang diterima?',
                        'a' => 'Transfer bank (BCA, BRI, BNI, Mandiri), GoPay, OVO, DANA, dan ShopeePay. Hubungi admin untuk rekening terbaru.'
                    ),
                    array(
                        'q' => 'Bisakah loker diperpanjang setelah habis?',
                        'a' => 'Tentu! Hubungi admin sebelum masa tayang berakhir untuk memperpanjang dengan harga yang sama atau memperbarui isi lowongan.'
                    ),
                    array(
                        'q' => 'Apakah ada diskon untuk beberapa posisi sekaligus?',
                        'a' => 'Ada! Hubungi admin untuk mendapatkan penawaran paket bundling jika Anda ingin memasang 3 lowongan atau lebih sekaligus.'
                    ),
                );
                foreach ($faqs as $i => $faq): ?>
                <div class="hkpl-faq-item" id="hkpl-faq-<?php echo $i; ?>">
                    <button class="hkpl-faq-q" aria-expanded="false" aria-controls="hkpl-faq-ans-<?php echo $i; ?>">
                        <span><?php echo esc_html($faq['q']); ?></span>
                        <svg class="hkpl-faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div class="hkpl-faq-a" id="hkpl-faq-ans-<?php echo $i; ?>" hidden>
                        <p><?php echo esc_html($faq['a']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ===================== CTA BOTTOM ===================== -->
    <section class="hkpl-cta-bottom">
        <div class="hk-container">
            <h2>Siap Menemukan Karyawan Terbaik?</h2>
            <p>Bergabung bersama ratusan perusahaan yang sudah mempercayakan rekrutmen mereka di <?php echo esc_html($site_name); ?></p>
            <div class="hkpl-cta-actions">
                <?php if (!empty($wa_clean)): ?>
                <a href="https://wa.me/<?php echo esc_attr($wa_clean); ?>" class="hkpl-btn hkpl-btn-wa" target="_blank" rel="noopener" id="hkpl-cta-wa-bottom">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Chat WhatsApp Admin
                </a>
                <?php endif; ?>
                <a href="#paket-loker" class="hkpl-btn hkpl-btn-outline-white" id="hkpl-cta-lihat-paket">Lihat Paket →</a>
            </div>
        </div>
    </section>

</main>

<script>
(function() {
    // FAQ Accordion
    document.querySelectorAll('.hkpl-faq-q').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var expanded = this.getAttribute('aria-expanded') === 'true';
            document.querySelectorAll('.hkpl-faq-q').forEach(function(b) {
                b.setAttribute('aria-expanded', 'false');
                var ans = document.getElementById(b.getAttribute('aria-controls'));
                if (ans) ans.hidden = true;
                b.closest('.hkpl-faq-item').classList.remove('hkpl-faq-open');
            });
            if (!expanded) {
                this.setAttribute('aria-expanded', 'true');
                var ans = document.getElementById(this.getAttribute('aria-controls'));
                if (ans) ans.hidden = false;
                this.closest('.hkpl-faq-item').classList.add('hkpl-faq-open');
            }
        });
    });

    // Form → WhatsApp
    var form = document.getElementById('hkpl-submission-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            var company  = document.getElementById('hkpl-company').value.trim();
            var position = document.getElementById('hkpl-position').value.trim();
            var location = document.getElementById('hkpl-location').value.trim();
            var jobtype  = document.getElementById('hkpl-jobtype').value;
            var salary   = document.getElementById('hkpl-salary').value.trim();
            var deadline = document.getElementById('hkpl-deadline').value;
            var desc     = document.getElementById('hkpl-desc').value.trim();
            var contact  = document.getElementById('hkpl-contact').value.trim();
            var pkg      = document.getElementById('hkpl-package').value;

            if (!company || !position || !contact || !desc) {
                alert('Mohon isi field yang wajib diisi (Nama Perusahaan, Posisi, Deskripsi, Kontak HRD).');
                return;
            }

            var siteName = '<?php echo esc_js($site_name); ?>';
            var msg = "Halo Tim Admin " + siteName + ",\n\n"
                + "Saya ingin mengajukan pemasangan lowongan kerja melalui form website. Berikut rincian informasinya:\n\n"
                + "📋 *DATA PENGAJUAN LOKER:*\n"
                + "━━━━━━━━━━━━━━━━━━━━\n"
                + "• Pilihan Paket : " + pkg + "\n"
                + "• Perusahaan    : " + company + "\n"
                + "• Posisi / Role : " + position + "\n"
                + "• Lokasi Kerja  : " + (location || '-') + "\n"
                + "• Tipe Kerja    : " + (jobtype || '-') + "\n"
                + "• Kisaran Gaji  : " + (salary || '-') + "\n"
                + "• Batas Lamaran : " + (deadline || '-') + "\n"
                + "• Kontak HRD    : " + contact + "\n\n"
                + "📝 *Deskripsi & Kualifikasi:*\n"
                + desc + "\n\n"
                + "━━━━━━━━━━━━━━━━━━━━\n"
                + "Mohon konfirmasi verifikasi data dan penayangan lowongan ini. Terima kasih!";

            var waNumber = '<?php echo esc_js($wa_clean); ?>';
            var adminEmail = '<?php echo esc_js($contact_email); ?>';

            if (waNumber) {
                window.open('https://wa.me/' + waNumber + '?text=' + encodeURIComponent(msg), '_blank');
            } else {
                var emailSubject = 'Pengajuan Pasang Loker [' + pkg + '] - ' + company + ' (' + position + ')';
                window.location.href = 'mailto:' + adminEmail + '?subject=' + encodeURIComponent(emailSubject) + '&body=' + encodeURIComponent(msg);
            }
        });
    }
})();
</script>

<?php get_footer(); ?>
