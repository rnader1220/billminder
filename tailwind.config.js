import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    safelist: [
        'grid',
        'grid-cols-2',
        'col-span-2',
        'gap-4',
        'text-center',
        'p-4',
        'fa',
        {pattern: /^fa-/,},
        {pattern: /^form-/,},
        {pattern: /^entry-/,},

    // other safelisted dynamic classes

    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, typography],
};
