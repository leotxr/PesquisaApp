const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
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
        },
    },

    plugins: [require('@tailwindcss/forms'),
    require("daisyui"),
    require('flowbite/plugin')
    ],

    daisyui: {
        styled: true,
        themes: [
            {
                ultrimagem: {
        
                  "primary": "#0a33a3",
        
                  "secondary": "#cdccff",
        
                  "accent": "#2849a3",
        
                  "neutral": "#252432",
        
                  "base-100": "#f2f2f2",
        
                  "info": "#1e4cd2",
        
                  "success": "#81dcb8",
        
                  "warning": "#f9b85d",
        
                  "error": "#c10015",
                },
              }],
        base: true,
        utils: true,
        logs: true,
        rtl: false,
        prefix: "",
        darkTheme: "dark",
    },
};
