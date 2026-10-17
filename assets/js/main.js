/**
 * Hakajobs Main JavaScript
 * 
 * Handles:
 * - LocalStorage Job Bookmarking (No-login saved jobs)
 * - Saved Jobs Modal & Page Rendering
 * - Mobile Menu Drawer
 * - Clipboard Link Sharing
 * - Toast Notifications
 */

document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    var STORAGE_KEY = 'hk_saved_jobs_v1';

    // Helper: Get Saved Jobs from LocalStorage
    function getSavedJobs() {
        try {
            var raw = localStorage.getItem(STORAGE_KEY);
            return raw ? JSON.parse(raw) : [];
        } catch (e) {
            console.error('LocalStorage error:', e);
            return [];
        }
    }

    // Helper: Save Jobs to LocalStorage
    function setSavedJobs(jobs) {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(jobs));
            updateSavedUI();
        } catch (e) {
            console.error('LocalStorage write error:', e);
        }
    }

    // Helper: Check if a job is saved
    function isJobSaved(jobId) {
        var jobs = getSavedJobs();
        return jobs.some(function (item) {
            return String(item.id) === String(jobId);
        });
    }

    // Toast Notification Helper
    function showToast(message) {
        var toast = document.getElementById('hk-toast');
        if (!toast) return;

        toast.textContent = message;
        toast.classList.add('hk-toast-show');

        setTimeout(function () {
            toast.classList.remove('hk-toast-show');
        }, 3000);
    }

    // Update Bookmark Buttons & Badge across the page
    function updateSavedUI() {
        var jobs = getSavedJobs();
        var count = jobs.length;

        // Update badge in header
        var badge = document.getElementById('hk-saved-badge');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'inline-flex' : 'none';
        }

        // Update all bookmark buttons
        var bookmarkBtns = document.querySelectorAll('.hk-btn-bookmark, .hk-btn-single-bookmark');
        bookmarkBtns.forEach(function (btn) {
            var jobId = btn.getAttribute('data-job-id');
            var saved = isJobSaved(jobId);

            if (saved) {
                btn.classList.add('is-saved');
                btn.setAttribute('aria-pressed', 'true');
                var textSpan = btn.querySelector('.hk-bookmark-text');
                if (textSpan) {
                    textSpan.textContent = (window.HakajobsData && HakajobsData.strings.saved) ? HakajobsData.strings.saved : 'Tersimpan';
                }
            } else {
                btn.classList.remove('is-saved');
                btn.setAttribute('aria-pressed', 'false');
                var textSpan = btn.querySelector('.hk-bookmark-text');
                if (textSpan) {
                    textSpan.textContent = (window.HakajobsData && HakajobsData.strings.save) ? HakajobsData.strings.save : 'Simpan Lowongan';
                }
            }
        });

        // Re-render modal list if open
        renderSavedJobsModalList();

        // Re-render full saved page if on that page
        renderSavedJobsPage();
    }

    // Toggle Save Job
    function toggleSaveJob(jobId, jobTitle, jobCompany, jobUrl) {
        var jobs = getSavedJobs();
        var index = jobs.findIndex(function (j) {
            return String(j.id) === String(jobId);
        });

        if (index > -1) {
            // Remove
            jobs.splice(index, 1);
            setSavedJobs(jobs);
            showToast((window.HakajobsData && HakajobsData.strings.removed) ? HakajobsData.strings.removed : 'Lowongan dihapus dari simpanan');
        } else {
            // Add
            jobs.unshift({
                id: jobId,
                title: jobTitle,
                company: jobCompany,
                url: jobUrl,
                date: new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'short' })
            });
            setSavedJobs(jobs);
            showToast((window.HakajobsData && HakajobsData.strings.saved) ? 'Lowongan berhasil disimpan!' : 'Disimpan ke browser!');
        }
    }

    // Delegate Click for Bookmark Buttons
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.hk-btn-bookmark, .hk-btn-single-bookmark');
        if (!btn) return;

        e.preventDefault();
        e.stopPropagation();

        var jobId = btn.getAttribute('data-job-id');
        var card = btn.closest('.hk-job-card');
        var title = '';
        var company = '';
        var url = '';

        if (card) {
            title = card.getAttribute('data-title') || '';
            company = card.getAttribute('data-company') || '';
            url = card.getAttribute('data-url') || '';
        } else {
            title = btn.getAttribute('data-title') || document.title;
            company = btn.getAttribute('data-company') || '';
            url = btn.getAttribute('data-url') || window.location.href;
        }

        toggleSaveJob(jobId, title, company, url);
    });

    // Render Saved Jobs inside Drawer Modal
    function renderSavedJobsModalList() {
        var container = document.getElementById('hk-saved-list-container');
        if (!container) return;

        var jobs = getSavedJobs();
        if (jobs.length === 0) {
            container.innerHTML = '<div class="hk-saved-empty"><div class="hk-empty-icon" style="font-size:32px;margin-bottom:8px;">📌</div><p>' +
                ((window.HakajobsData && HakajobsData.strings.noSavedJobs) ? HakajobsData.strings.noSavedJobs : 'Belum ada lowongan tersimpan.') +
                '</p><p style="font-size:12px;color:#94a3b8;">Klik ikon bookmark pada kartu lowongan untuk menyimpannya di sini.</p></div>';
            return;
        }

        var html = '<ul class="hk-saved-items-list">';
        jobs.forEach(function (job) {
            html += '<li class="hk-saved-item" data-id="' + job.id + '">';
            html += '  <div class="hk-saved-item-info">';
            html += '    <span class="hk-saved-item-company">' + escapeHtml(job.company || 'Perusahaan') + '</span>';
            html += '    <h4 class="hk-saved-item-title"><a href="' + escapeHtml(job.url) + '">' + escapeHtml(job.title) + '</a></h4>';
            html += '  </div>';
            html += '  <div class="hk-saved-item-actions">';
            html += '    <a href="' + escapeHtml(job.url) + '" class="hk-btn hk-btn-subtle hk-btn-sm">Buka</a>';
            html += '    <button type="button" class="hk-btn-delete-saved" data-id="' + job.id + '" title="Hapus">&times;</button>';
            html += '  </div>';
            html += '</li>';
        });
        html += '</ul>';

        container.innerHTML = html;
    }

    // Render Saved Jobs on Full Page (/tersimpan/)
    function renderSavedJobsPage() {
        var container = document.getElementById('hk-saved-full-page-container');
        if (!container) return;

        var jobs = getSavedJobs();
        if (jobs.length === 0) {
            container.innerHTML = '<div class="hk-empty-state"><div class="hk-empty-icon">📌</div><h3>Belum Ada Lowongan Tersimpan</h3><p>Anda belum menyimpan lowongan kerja apapun. Cari lowongan kerja dan klik ikon bookmark untuk menyimpannya.</p></div>';
            var clearBtn = document.getElementById('hk-clear-saved-page-btn');
            if (clearBtn) clearBtn.style.display = 'none';
            return;
        }

        var clearBtn = document.getElementById('hk-clear-saved-page-btn');
        if (clearBtn) clearBtn.style.display = 'inline-block';

        var html = '<div class="hk-saved-page-grid">';
        jobs.forEach(function (job) {
            html += '<div class="hk-job-card" data-id="' + job.id + '">';
            html += '  <div class="hk-job-card-top">';
            html += '    <div class="hk-job-card-main">';
            html += '      <span class="hk-card-company">' + escapeHtml(job.company || 'Perusahaan') + '</span>';
            html += '      <h3 class="hk-job-title"><a href="' + escapeHtml(job.url) + '">' + escapeHtml(job.title) + '</a></h3>';
            html += '    </div>';
            html += '  </div>';
            html += '  <div class="hk-job-card-footer" style="margin-top:16px;">';
            html += '    <span style="font-size:12px;color:#64748b;">Disimpan ' + escapeHtml(job.date || '') + '</span>';
            html += '    <div class="hk-card-actions">';
            html += '      <button type="button" class="hk-btn-delete-saved hk-btn hk-btn-subtle" data-id="' + job.id + '">Hapus</button>';
            html += '      <a href="' + escapeHtml(job.url) + '" class="hk-btn hk-btn-primary">Lihat Detail &rarr;</a>';
            html += '    </div>';
            html += '  </div>';
            html += '</div>';
        });
        html += '</div>';

        container.innerHTML = html;
    }

    // Delete single item from modal or page
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.hk-btn-delete-saved');
        if (!btn) return;

        var id = btn.getAttribute('data-id');
        var jobs = getSavedJobs().filter(function (j) {
            return String(j.id) !== String(id);
        });
        setSavedJobs(jobs);
        showToast('Lowongan dihapus dari daftar tersimpan.');
    });

    // Clear All Saved Jobs
    var clearModalBtn = document.getElementById('hk-clear-saved-btn');
    if (clearModalBtn) {
        clearModalBtn.addEventListener('click', function () {
            if (confirm('Apakah Anda yakin ingin menghapus semua lowongan tersimpan?')) {
                setSavedJobs([]);
                showToast('Semua simpanan berhasil dibersihkan.');
            }
        });
    }

    var clearPageBtn = document.getElementById('hk-clear-saved-page-btn');
    if (clearPageBtn) {
        clearPageBtn.addEventListener('click', function () {
            if (confirm('Apakah Anda yakin ingin menghapus semua lowongan tersimpan?')) {
                setSavedJobs([]);
                showToast('Semua simpanan berhasil dibersihkan.');
            }
        });
    }

    // Saved Jobs Modal Toggle
    var savedModal = document.getElementById('hk-saved-modal');
    var savedToggle = document.getElementById('hk-saved-jobs-toggle');
    var savedClose = document.getElementById('hk-saved-modal-close');
    var savedBackdrop = document.getElementById('hk-saved-modal-backdrop');

    function openSavedModal() {
        if (!savedModal) return;
        renderSavedJobsModalList();
        savedModal.classList.add('is-active');
        savedModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeSavedModal() {
        if (!savedModal) return;
        savedModal.classList.remove('is-active');
        savedModal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    if (savedToggle) savedToggle.addEventListener('click', openSavedModal);
    if (savedClose) savedClose.addEventListener('click', closeSavedModal);
    if (savedBackdrop) savedBackdrop.addEventListener('click', closeSavedModal);

    // Mobile Drawer Toggle
    var mobileDrawer = document.getElementById('hk-mobile-drawer');
    var mobileToggle = document.getElementById('hk-mobile-toggle');
    var drawerClose = document.getElementById('hk-drawer-close');
    var drawerBackdrop = document.getElementById('hk-drawer-backdrop');

    function openMobileDrawer() {
        if (!mobileDrawer) return;
        mobileDrawer.classList.add('is-active');
        if (drawerBackdrop) drawerBackdrop.classList.add('is-active');
        if (mobileToggle) mobileToggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileDrawer() {
        if (!mobileDrawer) return;
        mobileDrawer.classList.remove('is-active');
        if (drawerBackdrop) drawerBackdrop.classList.remove('is-active');
        if (mobileToggle) mobileToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    if (mobileToggle) mobileToggle.addEventListener('click', openMobileDrawer);
    if (drawerClose) drawerClose.addEventListener('click', closeMobileDrawer);
    if (drawerBackdrop) drawerBackdrop.addEventListener('click', closeMobileDrawer);

    // ESC key closes modals
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeSavedModal();
            closeMobileDrawer();
        }
    });

    // Copy Link Button
    var copyBtn = document.getElementById('hk-copy-link-btn');
    if (copyBtn) {
        copyBtn.addEventListener('click', function () {
            var url = copyBtn.getAttribute('data-url') || window.location.href;
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(function () {
                    showToast((window.HakajobsData && HakajobsData.strings.linkCopied) ? HakajobsData.strings.linkCopied : 'Tautan berhasil disalin!');
                }).catch(function () {
                    promptFallback(url);
                });
            } else {
                promptFallback(url);
            }
        });
    }

    // Admin WhatsApp Broadcast Copy Button
    var broadcastCopyBtns = document.querySelectorAll('.hk-copy-broadcast-btn');
    broadcastCopyBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var text = btn.getAttribute('data-broadcast');
            if (!text) return;
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(function () {
                    showToast('Format teks broadcast loker berhasil disalin!');
                }).catch(function () {
                    promptFallback(text);
                });
            } else {
                promptFallback(text);
            }
        });
    });

    function promptFallback(text) {
        window.prompt('Salin tautan ini:', text);
    }

    // Escape HTML helper
    function escapeHtml(string) {
        if (!string) return '';
        return String(string)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // Sticky Header & Back to Top Scroll Logic
    var siteHeader = document.getElementById('hk-masthead') || document.querySelector('.hk-site-header');
    var backToTopBtn = document.getElementById('hk-back-to-top');
    var isScrolling = false;

    window.addEventListener('scroll', function () {
        if (!isScrolling) {
            window.requestAnimationFrame(function () {
                var scrollY = window.pageYOffset || document.documentElement.scrollTop || 0;

                // Header scrolled class
                if (siteHeader) {
                    if (scrollY > 15) {
                        siteHeader.classList.add('is-scrolled');
                    } else {
                        siteHeader.classList.remove('is-scrolled');
                    }
                }

                // Back to Top visibility
                if (backToTopBtn) {
                    if (scrollY > 280) {
                        backToTopBtn.classList.add('is-visible');
                    } else {
                        backToTopBtn.classList.remove('is-visible');
                    }
                }

                isScrolling = false;
            });
            isScrolling = true;
        }
    }, { passive: true });

    if (backToTopBtn) {
        backToTopBtn.addEventListener('click', function (e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Initial UI Sync
    updateSavedUI();
});
