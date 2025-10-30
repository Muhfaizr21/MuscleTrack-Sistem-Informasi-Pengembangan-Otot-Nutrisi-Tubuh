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
                // Ganti 'Figtree' (bawaan Breeze) dengan 'Inter'
                'sans': ['Inter', ...defaultTheme.fontFamily.sans],
                // Tambahkan font 'Playfair Display' untuk judul
                'serif': ['"Playfair Display"', 'serif'],
            },
            // Kita akan menggunakan warna 'amber' bawaan Tailwind,
            // jadi tidak perlu menambahkannya di sini.
        },
    },

    plugins: [forms],
};
