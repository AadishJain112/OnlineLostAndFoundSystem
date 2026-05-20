import { gsap } from 'gsap';
import AOS from 'aos';
import VanillaTilt from 'vanilla-tilt';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);
window.Chart = Chart;
window.gsap = gsap;

export function initTheme() {
    const key = 'lf-theme';
    const stored = localStorage.getItem(key);
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const theme = stored || (prefersDark ? 'dark' : 'light');
    document.documentElement.classList.toggle('dark', theme === 'dark');
    return theme;
}

export function toggleTheme() {
    const isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('lf-theme', isDark ? 'dark' : 'light');
    window.dispatchEvent(new CustomEvent('theme-changed', { detail: { dark: isDark } }));
    return isDark;
}

export function initAOS() {
    AOS.init({
        duration: 700,
        easing: 'ease-out-cubic',
        once: true,
        offset: 40,
        disable: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
    });
}

export function initTilt() {
    document.querySelectorAll('[data-tilt]:not(.js-tilted)').forEach((el) => {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        VanillaTilt.init(el, {
            max: 12,
            speed: 400,
            glare: true,
            'max-glare': 0.15,
            scale: 1.02,
        });
        el.classList.add('js-tilted');
    });
}

export function initCounters() {
    document.querySelectorAll('[data-counter]').forEach((el) => {
        const target = parseInt(el.dataset.counter, 10) || 0;
        const obj = { val: 0 };
        gsap.to(obj, {
            val: target,
            duration: 1.8,
            ease: 'power2.out',
            onUpdate: () => {
                el.textContent = Math.round(obj.val).toLocaleString();
            },
        });
    });
}

export function initCharts() {
    document.querySelectorAll('[data-chart]').forEach((canvas) => {
        const type = canvas.dataset.chart || 'bar';
        const labels = JSON.parse(canvas.dataset.labels || '[]');
        const values = JSON.parse(canvas.dataset.values || '[]');
        const colors = JSON.parse(canvas.dataset.colors || '["#3b6ff5","#8b5cf6","#10b981","#f59e0b","#ec4899","#6366f1","#14b8a6"]');
        const isDark = document.documentElement.classList.contains('dark');

        new Chart(canvas, {
            type,
            data: {
                labels,
                datasets: [{
                    label: canvas.dataset.label || 'Data',
                    data: values,
                    backgroundColor: colors.map((c) => c + '99'),
                    borderColor: colors,
                    borderWidth: 2,
                    borderRadius: 8,
                    tension: 0.4,
                    fill: type === 'line',
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: { color: isDark ? '#94a3b8' : '#64748b' },
                    },
                },
                scales: type !== 'doughnut' && type !== 'pie' ? {
                    x: {
                        ticks: { color: isDark ? '#94a3b8' : '#64748b' },
                        grid: { color: isDark ? 'rgba(148,163,184,0.1)' : 'rgba(100,116,139,0.1)' },
                    },
                    y: {
                        ticks: { color: isDark ? '#94a3b8' : '#64748b' },
                        grid: { color: isDark ? 'rgba(148,163,184,0.1)' : 'rgba(100,116,139,0.1)' },
                    },
                } : {},
            },
        });
    });
}

export function showToast(message, type = 'success') {
    const stack = document.getElementById('toast-stack');
    if (!stack) return;

    const colors = {
        success: 'from-emerald-500/20 to-emerald-600/10 border-emerald-500/30 text-emerald-800 dark:text-emerald-200',
        error: 'from-red-500/20 to-red-600/10 border-red-500/30 text-red-800 dark:text-red-200',
        info: 'from-brand-500/20 to-brand-600/10 border-brand-500/30 text-brand-800 dark:text-brand-200',
    };

    const toast = document.createElement('div');
    toast.className = `glass pointer-events-auto flex items-center gap-3 rounded-xl border bg-gradient-to-r px-4 py-3 text-sm shadow-glass-lg ${colors[type] || colors.info}`;
    toast.innerHTML = `<span>${message}</span>`;
    stack.appendChild(toast);

    gsap.from(toast, { x: 80, opacity: 0, duration: 0.4, ease: 'power2.out' });
    gsap.to(toast, {
        x: 80,
        opacity: 0,
        duration: 0.4,
        delay: 4,
        ease: 'power2.in',
        onComplete: () => toast.remove(),
    });
}

export function initPageTransition() {
    const main = document.querySelector('[data-page-content]');
    if (main) {
        gsap.from(main, { opacity: 0, y: 20, duration: 0.5, ease: 'power2.out' });
    }
}

export function initRipple() {
    document.querySelectorAll('[data-ripple]').forEach((btn) => {
        btn.addEventListener('click', function (e) {
            const rect = this.getBoundingClientRect();
            const ripple = document.createElement('span');
            ripple.className = 'pointer-events-none absolute rounded-full bg-white/40';
            const size = Math.max(rect.width, rect.height);
            ripple.style.width = ripple.style.height = `${size}px`;
            ripple.style.left = `${e.clientX - rect.left - size / 2}px`;
            ripple.style.top = `${e.clientY - rect.top - size / 2}px`;
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            gsap.fromTo(ripple, { scale: 0, opacity: 0.6 }, { scale: 2, opacity: 0, duration: 0.6, onComplete: () => ripple.remove() });
        });
    });
}

export function refreshChartsOnTheme() {
    window.addEventListener('theme-changed', () => {
        document.querySelectorAll('[data-chart]').forEach((c) => {
            const chart = Chart.getChart(c);
            if (chart) chart.destroy();
        });
        initCharts();
    });
}
