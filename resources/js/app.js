import './bootstrap';
import Alpine from 'alpinejs';
import {
    initTheme,
    toggleTheme,
    initAOS,
    initTilt,
    initCounters,
    initCharts,
    initPageTransition,
    initRipple,
    showToast,
    refreshChartsOnTheme,
} from './animations';

window.Alpine = Alpine;

Alpine.data('themeToggle', () => ({
    dark: document.documentElement.classList.contains('dark'),
    toggle() {
        this.dark = toggleTheme();
    },
}));

Alpine.data('mobileNav', () => ({
    open: false,
    toggle() { this.open = !this.open; },
    close() { this.open = false; },
}));

Alpine.data('notificationsDropdown', () => ({
    open: false,
    count: parseInt(document.querySelector('[data-notification-count]')?.textContent || '0', 10),
    init() {
        const el = document.querySelector('[data-notification-count]');
        if (el) this.count = parseInt(el.textContent, 10) || 0;
        setInterval(() => {
            fetch('/notifications/poll', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then((r) => r.json())
                .then((d) => { this.count = d.count; })
                .catch(() => {});
        }, 30000);
    },
}));

Alpine.data('uploadZone', () => ({
    dragging: false,
    previews: [],
    onDrop(e) {
        this.dragging = false;
        this.handleFiles(e.dataTransfer.files);
    },
    onSelect(e) {
        this.handleFiles(e.target.files);
    },
    handleFiles(files) {
        [...files].forEach((file) => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = (ev) => {
                this.previews.push({ name: file.name, url: ev.target.result });
            };
            reader.readAsDataURL(file);
        });
    },
}));

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    initTheme();
    initAOS();
    initTilt();
    initCounters();
    initCharts();
    initPageTransition();
    initRipple();
    refreshChartsOnTheme();

    document.querySelectorAll('[data-theme-toggle]').forEach((btn) => {
        btn.addEventListener('click', () => toggleTheme());
    });

    if (document.querySelector('[data-flash-success]')) {
        showToast(document.querySelector('[data-flash-success]').textContent, 'success');
    }
    if (document.querySelector('[data-flash-error]')) {
        showToast(document.querySelector('[data-flash-error]').textContent, 'error');
    }
});

// Image preview (sync with file input)
document.querySelectorAll('[data-image-preview-input]').forEach((input) => {
    input.addEventListener('change', (event) => {
        const container = document.querySelector('[data-image-preview-container]');
        if (!container) return;
        container.innerHTML = '';
        [...event.target.files].forEach((file, i) => {
            const wrap = document.createElement('div');
            wrap.className = 'group relative overflow-hidden rounded-xl border border-white/40 shadow-glass';
            wrap.dataset.aos = 'zoom-in';
            wrap.dataset.aosDelay = String(i * 50);
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.className = 'h-24 w-24 object-cover transition-transform duration-500 group-hover:scale-110';
            wrap.appendChild(img);
            container.appendChild(wrap);
        });
        if (window.AOS) window.AOS.refresh();
    });
});

// Map picker
document.querySelectorAll('[data-map-picker]').forEach((map) => {
    map.addEventListener('click', (e) => {
        const rect = map.getBoundingClientRect();
        const x = (e.clientX - rect.left) / rect.width;
        const y = (e.clientY - rect.top) / rect.height;
        const lat = (90 - y * 180).toFixed(7);
        const lng = (x * 360 - 180).toFixed(7);
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        if (latInput) latInput.value = lat;
        if (lngInput) lngInput.value = lng;
        map.innerHTML = `<span class="text-brand-600 font-medium">📍 ${lat}, ${lng}</span>`;
        map.classList.add('ring-2', 'ring-brand-500/50');
    });
});

// Live search
document.querySelectorAll('[data-live-search-input]').forEach((input) => {
    let timeout;
    const form = input.closest('[data-live-search-form]');
    const results = document.querySelector('[data-live-search-results]');
    const indicator = form?.querySelector('[data-loading-indicator]');
    if (!form || !results) return;

    const runSearch = () => {
        indicator?.classList.remove('hidden');
        results.classList.add('opacity-50', 'pointer-events-none');
        const url = form.action + '?' + new URLSearchParams(new FormData(form)).toString();
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then((r) => r.text())
            .then((html) => {
                results.innerHTML = html;
                initTilt();
                if (window.AOS) window.AOS.refresh();
            })
            .finally(() => {
                indicator?.classList.add('hidden');
                results.classList.remove('opacity-50', 'pointer-events-none');
            });
    };

    input.addEventListener('input', () => {
        clearTimeout(timeout);
        timeout = setTimeout(runSearch, 350);
    });
});

window.showToast = showToast;
