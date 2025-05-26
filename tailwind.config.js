/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/wire-elements/modal/resources/views/*.blade.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    safelist: [
        "bg-green-500",
        "bg-teal-500",
        "bg-yellow-500",
        "bg-sky-500",
        "bg-rose-500",
        "text-green-500",
        "text-teal-500",
        "text-yellow-500",
        "text-sky-500",
        "text-rose-500",
        {
            pattern: /max-w-(sm|md|lg|xl|2xl|3xl|4xl|5xl|6xl|7xl)/,
            variants: ['sm', 'md', 'lg', 'xl', '2xl']
        }
    ],
    daisyui: {
        themes: [{
                nord: {
                    ...require("daisyui/src/theming/themes")["nord"],
                    ".menu li > *:not(ul):not(.menu-title):not(details).active": {
                        "background-color": "#fca311",
                        "--primary-muted": "78.6% 0.167 70.04",
                        color: "#000000",
                    },
                    "--base-400": "25.2% 0.056 264.00",
                    "--primary-muted": "78.6% 0.167 70.04",
                },
            },
            // light theme
            {
                light: {
                    ...require("daisyui/src/theming/themes")["light"],
                    "--primary-muted": "78.6% 0.167 70.04",
                    "--base-400": "25.2% 0.056 264.00",
                    "--primary-muted": "78.6% 0.167 70.04",
                },
            },
            // dark theme
            {
                dark: {
                    ...require("daisyui/src/theming/themes")["dark"],
                    "--primary-muted": "78.6% 0.167 70.04",
                    "--base-400": "25.2% 0.056 264.00",
                    "--primary-muted": "78.6% 0.167 70.04",
                },
            },
            "light",
            "dark",
            "cupcake",
            "bumblebee",
            "emerald",
            "corporate",
            "synthwave",
            "retro",
            "cyberpunk",
            "valentine",
            "halloween",
            "garden",
            "forest",
            "aqua",
            "lofi",
            "pastel",
            "fantasy",
            "wireframe",
            "black",
            "luxury",
            "dracula",
            "cmyk",
            "autumn",
            "business",
            "acid",
            "lemonade",
            "night",
            "coffee",
            "winter",
            "dim",
            "nord",
            "sunset",
        ],
    },
    theme: {
        extend: {
            screens: {
                'sm': '640px',
                // => @media (min-width: 640px) { ... }

                'md': '768px',
                // => @media (min-width: 768px) { ... }

                'lg': '1024px',
                // => @media (min-width: 1024px) { ... }

                'xl': '1280px',
                // => @media (min-width: 1280px) { ... }

                '2xl': '1536px',
                // => @media (min-width: 1536px) { ... }
            },
            colors: {
                "primary-muted": "oklch(var(--primary-muted) / <alpha-value>)",
                "base-400": "oklch(var(--base-400) / <alpha-value>)",
            },
            fontFamily: {
                spicy_rice: ['Spicy Rice', 'sans-serif'],
                signika: ['Signika', 'sans-serif'],
            },
        },
    },
    plugins: [require("daisyui")],
};
