// Katering Marketplace — script aplikasi (sidebar + dark mode + toast)

(function () {
    'use strict';

    var THEME_KEY = 'km-theme';

    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        document.documentElement.setAttribute('data-bs-theme', theme);

        document.querySelectorAll('[data-theme-icon]').forEach(function (icon) {
            icon.classList.toggle('fa-moon', theme === 'light');
            icon.classList.toggle('fa-sun', theme === 'dark');
        });
    }

    function currentTheme() {
        try {
            return localStorage.getItem(THEME_KEY) || 'light';
        } catch (e) {
            return 'light';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Sidebar off-canvas (mobile / tablet)
        var toggle = document.getElementById('sidebar-toggle');
        var sidebar = document.getElementById('app-sidebar');
        var backdrop = document.getElementById('sidebar-backdrop');

        function openSidebar() {
            sidebar && sidebar.classList.add('show');
            backdrop && backdrop.classList.remove('d-none');
        }

        function closeSidebar() {
            sidebar && sidebar.classList.remove('show');
            backdrop && backdrop.classList.add('d-none');
        }

        if (toggle && sidebar) {
            toggle.addEventListener('click', function () {
                if (sidebar.classList.contains('show')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });
        }

        if (backdrop) {
            backdrop.addEventListener('click', closeSidebar);
        }

        // Tutup sidebar saat link nav diklik (mode mobile/tablet)
        sidebar && sidebar.querySelectorAll('.nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth < 992) {
                    closeSidebar();
                }
            });
        });

        // Tutup sidebar dengan tombol Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });

        // Dark mode toggle (persisten)
        applyTheme(currentTheme());

        document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var next = currentTheme() === 'dark' ? 'light' : 'dark';
                try {
                    localStorage.setItem(THEME_KEY, next);
                } catch (e) {}
                applyTheme(next);
            });
        });

        // Cetak / simpan invoice sebagai PDF (via dialog print browser)
        document.querySelectorAll('[data-print-invoice]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                window.print();
            });
        });

        // Preview nama file pada area upload (.file-drop)
        document.querySelectorAll('.file-drop input[type="file"]').forEach(function (input) {
            input.addEventListener('change', function () {
                var drop = input.closest('.file-drop');
                if (! drop) {
                    return;
                }
                var textEl = drop.querySelector('.file-drop-text');
                if (textEl && input.files.length > 0) {
                    textEl.innerHTML = input.files[0].name +
                        ' <small>' + (input.files[0].size / 1024).toFixed(0) + ' KB — klik untuk ganti</small>';
                }
            });
        });
    });

    window.showToast = function (message, type) {
        if (typeof Toastify === 'undefined') {
            return;
        }

        var config = {
            success: { icon: 'fa-circle-check', color: '#16a34a', bg: '#eaf8f1' },
            error: { icon: 'fa-circle-xmark', color: '#dc2626', bg: '#fdeeee' },
            warning: { icon: 'fa-triangle-exclamation', color: '#b45309', bg: '#fdf5e6' },
            info: { icon: 'fa-circle-info', color: '#2563eb', bg: '#eaf1fe' },
        };

        var c = config[type] || config.success;

        // Bangun isi toast sebagai DOM (aman & ikon ter-render, bukan teks mentah).
        var wrap = document.createElement('span');
        wrap.className = 'km-toast';

        var iconBox = document.createElement('span');
        iconBox.className = 'km-toast-icon';
        iconBox.style.background = c.bg;
        iconBox.style.color = c.color;
        iconBox.innerHTML = '<i class="fa-solid ' + c.icon + '"></i>';

        var body = document.createElement('span');
        body.className = 'km-toast-body';
        body.textContent = message; // aman dari XSS

        wrap.appendChild(iconBox);
        wrap.appendChild(body);

        Toastify({
            node: wrap,
            duration: 4000,
            gravity: 'top',
            position: 'right',
            stopOnFocus: true,
            close: true,
            offset: { x: 20, y: 20 },
            style: {
                background: '#ffffff',
                color: '#0f172a',
                borderRadius: '12px',
                padding: '10px 12px',
                boxShadow: '0 12px 32px -12px rgba(15, 23, 42, 0.28)',
                border: '1px solid #e2e8f0',
            },
            className: 'km-toastify km-toastify-' + (type || 'success'),
        }).showToast();
    };
})();
