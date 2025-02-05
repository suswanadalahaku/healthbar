import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/views/livewire/**/*.blade.php", // Untuk Livewire
        "./resources/js/**/*.js",                   // Untuk file JS
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            typography: {
                DEFAULT: {
                    css: {
                        p: {
                            marginTop: "0.5rem",
                            marginBottom: "0.5rem",
                        },
                        h1: {
                            marginTop: "1rem",
                            marginBottom: "0.5rem",
                            color: '#1a202c',
                        },
                        h2: {
                            marginTop: "1rem",
                            marginBottom: "0.5rem",
                            color: '#1a202c',
                        },
                        h3: {
                            marginTop: "1rem",
                            marginBottom: "0.5rem",
                            color: '#1a202c',
                        },
                        "ul > li": {
                            marginTop: "0.25rem",
                            marginBottom: "0.25rem",
                        },
                        "ol > li": {
                            marginTop: "0.25rem",
                            marginBottom: "0.25rem",
                        },
                        blockquote: {
                            marginTop: "1rem",
                            marginBottom: "1rem",
                        },
                    },
                },
            },
        },
    },

    plugins: [forms, require("daisyui"), require("@tailwindcss/typography")],

    // daisyui: {
    //     themes: ["light", "dark", "cupcake"], // Opsional, jika ingin tema khusus
    // },
};
