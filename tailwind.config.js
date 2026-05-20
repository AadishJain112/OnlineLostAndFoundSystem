import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                display: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#eef4ff',
                    100: '#d9e6ff',
                    200: '#bcd4ff',
                    300: '#8eb6ff',
                    400: '#5a8fff',
                    500: '#3b6ff5',
                    600: '#2550ea',
                    700: '#1d3fd7',
                    800: '#1e35af',
                    900: '#1e318a',
                    950: '#172154',
                },
                surface: {
                    light: 'rgba(255,255,255,0.72)',
                    dark: 'rgba(15,23,42,0.65)',
                },
            },
            boxShadow: {
                glass: '0 8px 32px rgba(31, 38, 135, 0.12)',
                'glass-lg': '0 16px 48px rgba(31, 38, 135, 0.18)',
                glow: '0 0 40px rgba(59, 111, 245, 0.35)',
                'glow-sm': '0 0 20px rgba(59, 111, 245, 0.25)',
                lift: '0 20px 40px -12px rgba(0, 0, 0, 0.15)',
            },
            backgroundImage: {
                'mesh-light': 'radial-gradient(at 0% 0%, rgba(59,111,245,0.18) 0, transparent 50%), radial-gradient(at 100% 0%, rgba(139,92,246,0.15) 0, transparent 50%), radial-gradient(at 100% 100%, rgba(16,185,129,0.12) 0, transparent 50%), radial-gradient(at 0% 100%, rgba(244,114,182,0.1) 0, transparent 50%)',
                'mesh-dark': 'radial-gradient(at 0% 0%, rgba(59,111,245,0.25) 0, transparent 50%), radial-gradient(at 100% 0%, rgba(139,92,246,0.2) 0, transparent 50%), radial-gradient(at 100% 100%, rgba(16,185,129,0.15) 0, transparent 50%), radial-gradient(at 0% 100%, rgba(244,114,182,0.12) 0, transparent 50%)',
            },
            animation: {
                'float': 'float 8s ease-in-out infinite',
                'float-delayed': 'float 8s ease-in-out 2s infinite',
                'pulse-soft': 'pulse-soft 3s ease-in-out infinite',
                'shimmer': 'shimmer 2s linear infinite',
                'fade-up': 'fade-up 0.6s ease-out forwards',
                'scale-in': 'scale-in 0.4s ease-out forwards',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-16px)' },
                },
                'pulse-soft': {
                    '0%, 100%': { opacity: '0.6' },
                    '50%': { opacity: '1' },
                },
                shimmer: {
                    '0%': { backgroundPosition: '-200% 0' },
                    '100%': { backgroundPosition: '200% 0' },
                },
                'fade-up': {
                    '0%': { opacity: '0', transform: 'translateY(16px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'scale-in': {
                    '0%': { opacity: '0', transform: 'scale(0.95)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
            },
            backdropBlur: {
                xs: '2px',
            },
        },
    },
    plugins: [forms],
};
