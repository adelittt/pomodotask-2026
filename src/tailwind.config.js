/** @type {import('tailwindcss').Config} */
const colors = require("tailwindcss/colors");
const defaultTheme = require("tailwindcss/defaultTheme");

function withOpacityValue(variable) {
    return ({ opacityValue }) => {
        if (opacityValue === undefined) {
            return `rgb(var(${variable}))`;
        }
        return `rgb(var(${variable}) / ${opacityValue})`;
    };
}

export default {
    content: [
        "./resources/**/*.blade.php",
        "./app/Filament/**/*.php",
        "./resources/views/filament/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
    ],
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                // Warna pastel kustom untuk PomoTasky
                pastel: {
                    pink: '#FFD1DC',
                    mint: '#C1E1C1',
                    peach: '#FFDDC1',
                    lavender: '#E6E6FA',
                    cream: '#FFFDD0',
                    blue: '#B5E3F7',
                    yellow: '#FFF5BA',
                },
                // Override warna primary Filament jika ingin selaras
                primary: {
                    50: '#FFF5F0',
                    100: '#FFE6DC',
                    200: '#FFCDB8',
                    300: '#FFB495',
                    400: '#FF9B71',
                    500: '#FF824E',  // oranye pastel
                    600: '#E5673A',
                    700: '#CC4E26',
                    800: '#B23513',
                    900: '#991C00',
                },
            },
        },
    },
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
}