import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./node_modules/flowbite/**/*.js"
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                display: ['Bangers, system-ui'],
                body: ['Poppins, sans-serif']
            },
            backgroundImage: {
                'vip-pattern': "url('../../public/images/architect.svg')",
                'hero': "url('../../public/images/hero.jpg')",
                'login': "url('../../public/images/login.jpg')",
                'sidebar': "url('../../public/images/sidebar.jpg')",
                'gamebar': "url('../../public/images/game.jpg')",
            },
            colors: {
                purple: {
                  1000: '#1d1128'
                },
                red: {
                    1000: '#DB162F'
                },
                lightpurple: '#E88EED',
                greyish: '#878E76'
            }
        }
    },

    plugins: [
        forms,
        require('flowbite/plugin')
    ],
};
