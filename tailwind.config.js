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
        "./src/**/*.js"
    ],
    darkMode: 'class',

    theme: {
        screens: {
            xs: '320px',
            sm: '480px',
            md: '768px',
            lg: '1024px',
            xl: '1200px',
            xxl: '1400px',
        },
        dropShadow: {
            'md2': '0 4px 3px rgba(0, 0, 0, 0.2)'
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

    plugins: [
        require('flowbite/plugin')
    ],

    plugins: [require('@tailwindcss/forms')],
};
