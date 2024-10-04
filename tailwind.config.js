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
        "./vendor/ramonrietdijk/livewire-tables/resources/**/*.blade.php"
    ],

    darkMode: 'media', // Esto habilita el modo oscuro basado en las preferencias del sistema

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Puedes personalizar los colores para el modo oscuro aquí si lo deseas
                dark: {
                    'bg-primary': '#1a202c',
                    'text-primary': '#e2e8f0',
                    // ... más colores personalizados
                }
            }
        },
    },

    plugins: [forms, typography],
};
