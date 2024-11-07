import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/Script.js', 'resources/css/app.css'],
            refresh: true,
        }),
    ],
});
