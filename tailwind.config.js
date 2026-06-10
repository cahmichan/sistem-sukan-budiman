import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import flowbite from 'flowbite/plugin';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                budiman: {
                    primary: '#432818',
                    secondary: '#132a13',
                    accent: '#6b3a25',
                    cream: '#f7f3ea',
                    surface: '#f8f8f7',
                    footer: '#482719',
                },
            },
            fontFamily: {
                sans: ['Poppins', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, flowbite],
};
