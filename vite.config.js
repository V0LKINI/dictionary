import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

const env = loadEnv('','./')
const host = env.VITE_APP_URL;

export default defineConfig({
    build: {
        target: 'esnext'
    },
    plugins: [
        vue({
            script: {
                defineModel: true,
                propsDestructure: true
            }
        }),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host,
        hmr: { host },
    },
});
