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

(function () {
    'use strict';

    function initHakajobs() {
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

    // Setup Mobile Submenu Toggles in Drawer
    function initMobileSubmenus() {
        var mobileNavItems = document.querySelectorAll('.hk-mobile-nav-list .menu-item-has-children');
        mobileNavItems.forEach(function (item) {
            var parentLink = item.querySelector(':scope > a');
            var subMenu = item.querySelector(':scope > .sub-menu');
            if (!subMenu) return;

            // Avoid double initialization
            if (item.querySelector('.hk-mobile-submenu-toggle')) return;

            var row = document.createElement('div');
            row.className = 'hk-mobile-nav-link-row';

            var toggleBtn = document.createElement('button');
            toggleBtn.type = 'button';
            toggleBtn.className = 'hk-mobile-submenu-toggle';
            toggleBtn.setAttribute('aria-expanded', 'false');
            toggleBtn.setAttribute('aria-label', 'Buka Sub-Menu');
            toggleBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>';

            function toggleSubmenu(e) {
                if (e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                var isOpen = item.classList.toggle('is-open');
                toggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            }

            toggleBtn.addEventListener('click', toggleSubmenu);

            // If parent link has '#' or empty href, clicking link also toggles submenu
            if (parentLink) {
                var href = parentLink.getAttribute('href');
                if (!href || href === '#' || href === 'javascript:void(0)' || href === 'javascript:;') {
                    parentLink.addEventListener('click', toggleSubmenu);
                }
                item.insertBefore(row, parentLink);
                row.appendChild(parentLink);
                row.appendChild(toggleBtn);
            } else {
                item.insertBefore(toggleBtn, subMenu);
            }
        });
    }
    initMobileSubmenus();

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
                if (!backToTopBtn) {
                    backToTopBtn = document.getElementById('hk-back-to-top');
                }
                if (backToTopBtn) {
                    if (scrollY > 200) {
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

    // Click handler for Back to Top Button (event delegation)
    document.addEventListener('click', function (e) {
        var btt = e.target.closest('#hk-back-to-top, .hk-back-to-top');
        if (btt) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    });

    // Smart Anti Copy-Paste & Source Link Attribution
    document.addEventListener('copy', function (e) {
        var selection = window.getSelection();
        if (!selection || selection.rangeCount === 0) return;

        var selectedText = selection.toString();
        if (!selectedText || !selectedText.trim()) return;

        // Skip if user is copying from form inputs/textareas or contenteditable elements
        var activeEl = document.activeElement;
        if (activeEl && (activeEl.tagName === 'INPUT' || activeEl.tagName === 'TEXTAREA' || activeEl.isContentEditable)) {
            return;
        }

        // Also check if selection node is inside an input or textarea
        var anchor = selection.anchorNode;
        var parentEl = anchor ? (anchor.nodeType === 1 ? anchor : anchor.parentElement) : null;
        if (parentEl && parentEl.closest('input, textarea, [contenteditable="true"]')) {
            return;
        }

        // 1. Get Site Name (Sesuaikan Nama Website)
        var siteName = '';
        if (window.HakajobsData && HakajobsData.siteName) {
            siteName = HakajobsData.siteName;
        } else {
            var siteTitleEl = document.querySelector('.hk-site-title, .site-title');
            if (siteTitleEl && siteTitleEl.textContent.trim()) {
                siteName = siteTitleEl.textContent.trim();
            } else if (document.title) {
                siteName = document.title.split(' - ')[0].split(' | ')[0].trim();
            } else {
                siteName = 'Hakajobs';
            }
        }

        // 2. Get Article / Job Title & Link (judul Artikel yang dicopy & link artikel)
        var articleTitle = '';
        var articleUrl = '';

        // If copying inside a specific job card (.hk-job-card)
        var jobCard = parentEl ? parentEl.closest('.hk-job-card') : null;
        if (jobCard) {
            var cardTitle = jobCard.querySelector('.hk-job-title a, .hk-job-title, h3 a, h3');
            if (cardTitle && cardTitle.textContent.trim()) {
                articleTitle = cardTitle.textContent.trim();
            }
            var cardLink = jobCard.querySelector('a.hk-job-title, .hk-job-title a, a.hk-btn-primary, h3 a');
            if (cardLink && cardLink.href) {
                articleUrl = cardLink.href.split('#')[0];
            }
        }

        // If not found from a card, get from single page heading or document
        if (!articleTitle) {
            var heading = document.querySelector('.hk-single-job-title, .hk-entry-title, .entry-title, .hk-page-title, h1');
            if (heading && heading.textContent.trim()) {
                articleTitle = heading.textContent.trim();
            } else if (document.title) {
                articleTitle = document.title.split(' - ')[0].split(' | ')[0].trim();
            } else {
                articleTitle = siteName;
            }
        }

        if (!articleUrl) {
            articleUrl = window.location.href.split('#')[0];
        }

        articleTitle = articleTitle.replace(/\s+/g, ' ').trim();

        // 3. User format:
        // Baca lowongan di " [Nama Website] ", " [judul Artikel yang dicopy] " selengkapnya " [link artikel yang dicopy] " .
        var attributionText = '\n\nBaca lowongan di "' + siteName + '", "' + articleTitle + '" selengkapnya "' + articleUrl + '" .';
        var fullText = selectedText + attributionText;

        if (e.clipboardData) {
            e.clipboardData.setData('text/plain', fullText);

            try {
                var htmlContainer = document.createElement('div');
                for (var i = 0; i < selection.rangeCount; ++i) {
                    htmlContainer.appendChild(selection.getRangeAt(i).cloneContents());
                }
                var htmlAttribution = '<br><br><p>Baca lowongan di &ldquo;<strong>' + escapeHtml(siteName) + '</strong>&rdquo;, &ldquo;<em>' + escapeHtml(articleTitle) + '</em>&rdquo; selengkapnya &ldquo;<a href="' + escapeHtml(articleUrl) + '">' + escapeHtml(articleUrl) + '</a>&rdquo; .</p>';
                e.clipboardData.setData('text/html', htmlContainer.innerHTML + htmlAttribution);
            } catch (err) {
                // Fallback to plain text already set
            }

            e.preventDefault();
        } else if (window.clipboardData) {
            window.clipboardData.setData('Text', fullText);
            e.preventDefault();
        }

        // Show toast notification
        if (typeof showToast === 'function') {
            showToast('📋 Teks disalin beserta sumber: ' + siteName);
        }
    });

    // Clean up any residual dark mode localStorage key and attribute
    try {
        localStorage.removeItem('hk_theme');
    } catch (e) {}
    if (document.documentElement.hasAttribute('data-theme')) {
        document.documentElement.removeAttribute('data-theme');
    }

    // Initial UI Sync
    updateSavedUI();

    // =========================================================================
    // Cookie & Notification Consent Controller
    // =========================================================================
    var COOKIE_KEY = 'hk_cookie_consent';

    function getCookieValue(name) {
        var prefix = name + '=';
        var decoded = decodeURIComponent(document.cookie);
        var ca = decoded.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i].trim();
            if (c.indexOf(prefix) === 0) {
                return c.substring(prefix.length, c.length);
            }
        }
        return null;
    }

    function setCookieValue(name, value, days) {
        var expires = '';
        if (days) {
            var d = new Date();
            d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = '; expires=' + d.toUTCString();
        }
        document.cookie = name + '=' + encodeURIComponent(value) + expires + '; path=/; SameSite=Lax';
    }

    function hideCookiePopup() {
        var popup = document.getElementById('hk-cookie-popup');
        if (!popup) return;
        popup.classList.remove('is-visible');
        popup.classList.add('is-hiding');
        popup.setAttribute('aria-hidden', 'true');
        setTimeout(function () {
            popup.classList.remove('is-hiding');
        }, 350);
    }

    function showCookiePopup() {
        var popup = document.getElementById('hk-cookie-popup');
        if (!popup) return;
        popup.classList.remove('is-hiding');
        popup.classList.add('is-visible');
        popup.setAttribute('aria-hidden', 'false');
    }

    function initCookieNotice() {
        var popup = document.getElementById('hk-cookie-popup');
        if (!popup) return;

        var stored = null;
        try {
            stored = localStorage.getItem(COOKIE_KEY);
        } catch (e) {}

        var cookieConsent = getCookieValue(COOKIE_KEY) || stored;
        if (!cookieConsent) {
            // Smooth entrance delay
            setTimeout(showCookiePopup, 600);
        }

        // Accept Button ("Aktifkan Cookie")
        var acceptBtn = document.getElementById('hk-cookie-accept-btn');
        if (acceptBtn) {
            acceptBtn.addEventListener('click', function (e) {
                e.preventDefault();
                setCookieValue(COOKIE_KEY, 'accepted', 30);
                try {
                    localStorage.setItem(COOKIE_KEY, 'accepted');
                    localStorage.setItem('hk_cookie_consent_time', new Date().toISOString());
                } catch (err) {}
                hideCookiePopup();
                showToast('🍪 Cookie & preferensi berhasil diaktifkan!');
            });
        }

        // Decline Button ("Hanya Esensial")
        var declineBtn = document.getElementById('hk-cookie-decline-btn');
        if (declineBtn) {
            declineBtn.addEventListener('click', function (e) {
                e.preventDefault();
                setCookieValue(COOKIE_KEY, 'essential', 14);
                try {
                    localStorage.setItem(COOKIE_KEY, 'essential');
                } catch (err) {}
                hideCookiePopup();
                showToast('Preferensi cookie esensial disimpan.');
            });
        }

        // Close 'X' Button
        var closeBtn = document.getElementById('hk-cookie-close-btn');
        if (closeBtn) {
            closeBtn.addEventListener('click', function (e) {
                e.preventDefault();
                setCookieValue(COOKIE_KEY, 'dismissed', 7);
                try {
                    localStorage.setItem(COOKIE_KEY, 'dismissed');
                } catch (err) {}
                hideCookiePopup();
            });
        }
    }

    // Expose reset method for testing / interactive demos
    window.resetHakajobsCookieConsent = function () {
        document.cookie = COOKIE_KEY + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        try {
            localStorage.removeItem(COOKIE_KEY);
        } catch (e) {}
        showCookiePopup();
        showToast('Pop-up cookie di-reset. Menampilkan kembali...');
    };

        initCookieNotice();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHakajobs);
    } else {
        initHakajobs();
    }
})();
