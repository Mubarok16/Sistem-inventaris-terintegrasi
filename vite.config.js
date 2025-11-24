import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    // Konfigurasi server Vite agar dapat diakses dari jaringan lokal
    // server: {
    //     // Ini memastikan Vite mendengarkan semua antarmuka jaringan
    //     host: '192.168.2.179', 
    //     // Ini memungkinkan akses dari jaringan eksternal
    //     headers: {
    //         // Ini akan mengizinkan semua origin untuk mengambil aset dari Vite
    //         'Access-Control-Allow-Origin': '*', 
    //         // Atau, lebih spesifik: 'Access-Control-Allow-Origin': 'http://192.168.2.179:8000',
    //     },
    //     watch: {
    //         usePolling: true,
    //     },
    // },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
