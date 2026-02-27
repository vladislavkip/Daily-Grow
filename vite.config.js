import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js'
        }
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true, 
        }),
        vue(),
    ],

    '@images': path.resolve(__dirname, 'resources/images'),

    server: {
        host: '0.0.0.0',          
        port: 5173,
        hmr: {
            host: 'host.docker.internal',  
            port: 5173
        }
    }
});