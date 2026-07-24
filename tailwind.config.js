import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                /* E-Turismo brand greens — usable as bg-brand-*, text-brand-*, etc. */
                brand: {
                    950: '#052e16',
                    900: '#0B3D2E',
                    800: '#166534',
                    700: '#15803d',
                    600: '#16a34a',
                    500: '#22c55e',
                    400: '#4ADE80',
                    300: '#86efac',
                    200: '#bbf7d0',
                    100: '#dcfce7',
                    50:  '#f0fdf4',
                    lime: '#a3e635',
                },
            },
            backgroundImage: {
                'et-gradient':       'linear-gradient(135deg, #0B3D2E 0%, #166534 40%, #16a34a 70%, #4ADE80 100%)',
                'et-gradient-hover': 'linear-gradient(135deg, #052e16 0%, #0B3D2E 40%, #15803d 70%, #22c55e 100%)',
                'et-gradient-light': 'linear-gradient(135deg, #22c55e 0%, #4ADE80 60%, #a3e635 100%)',
            },
        },
    },

    plugins: [forms],
    safelist: [
        // Dynamic classes used in PHP loops — ensure they are not purged
        { pattern: /^border-(indigo|emerald|amber|green|blue|rose|yellow|red|gray|brand)-(100|200|300|400|500|600|700|800)$/ },
        { pattern: /^(bg|text)-(indigo|emerald|amber|green|blue|rose|yellow|red|gray|brand)-(50|100|200|300|400|500|600|700|800|900)$/ },
    ],
};
