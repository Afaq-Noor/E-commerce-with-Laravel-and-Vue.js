import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    // Setting this to false leaves absolute URLs untouched
                    // so they correctly point to the public directory.
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
