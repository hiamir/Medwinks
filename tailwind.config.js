const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
        "./layouts/**/*.html",
        "./content/**/*.md",
        "./content/**/*.html",
        "./src/**/*.js",
    ],
    tailwindConfig: './styles/tailwind.config.js',
    darkMode: 'class',
    variants: {
        scrollbar: ['dark']
    },
    theme: {
        screens: {
            xs: '320px',
            sm: '480px',
            md: '768px',
            lg: '1024px',
            xl: '1200px',
            xxl: '1400px',
            xxxl: '1600px',
        },
        dropShadow: {
            'md2': '0 4px 3px rgba(0, 0, 0, 0.2)',
            'md2c': '0 0px 2px rgba(0, 0, 0, 0.2)',
            'md5': '0 0px 5px rgba(0, 0, 0, 0.3)'
        },

        // colors: {
        //     'blue': '#1fb6ff',
        //     'purple': '#7e5bef',
        //     'pink': '#ff49db',
        //     'orange': '#ff7849',
        //     'green': '#13ce66',
        //     'yellow': '#ffc82c',
        //     'gray-dark': '#273444',
        //     'gray': '#8492a6',
        //     'gray-light': '#d3dce6',
        // },
        // fontFamily: {
        //     sans: ['Graphik', 'sans-serif'],
        //     serif: ['Merriweather', 'serif'],
        // },
        // extend: {
        //     spacing: {
        //         '128': '32rem',
        //         '144': '36rem',
        //     },
        //     borderRadius: {
        //         '4xl': '2rem',
        //     }
        // }
    },

    plugins: [require('tailwind-scrollbar'), require('flowbite/plugin'), require('@tailwindcss/forms'),require('prettier-plugin-tailwindcss')]
};
