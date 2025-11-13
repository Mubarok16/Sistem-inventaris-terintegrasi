import $ from 'jquery';
window.$ = window.jQuery = $;
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap; // supaya ruang-admin.js bisa akses global

// import './bootstrap'; // Biarkan jika ada
import Alpine from 'alpinejs'; // <-- IMPORT ALPINE

window.Alpine = Alpine; // <-- Membuat Alpine tersedia secara global

Alpine.start();



// import 'bootstrap/dist/js/bootstrap.bundle.min.js';
// import 'bootstrap/dist/css/bootstrap.min.css';
// // resources/js/app.js
// import '@fortawesome/fontawesome-free/css/all.min.css';


