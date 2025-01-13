import {defineConfig, loadEnv} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import vueI18n from '@intlify/vite-plugin-vue-i18n'
import {resolve} from 'node:path';

const env = loadEnv('', './');
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
      input: ['resources/css/app.sass', 'resources/js/app.js'],
      refresh: true,
    }),
    vueI18n({
      include: [resolve(__dirname, 'resources/js/locales/**')],
    })
  ],
  server: {
    host,
    hmr: {host},
  },
});