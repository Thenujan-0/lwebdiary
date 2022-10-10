import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
// import react from '@vitejs/plugin-react';
// import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel([
            'resources/assets/sass/app.scss',
            'resources/assets/sass/writeDiary.scss',
            'resources/assets/sass/index.scss',
            'resources/js/app.js',
            'resources/js/index.js',
            'resources/js/writeDiary.js',
            'resources/js/diaryNamesBar.js',
            'resources/js/createDiary.js',
        ]),
        // react(),
        // vue({
        //     template: {
        //         transformAssetUrls: {
        //             base: null,
        //             includeAbsolute: false,
        //         },
        //     },
        // }),
    ],
});