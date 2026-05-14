import $ from 'jquery';
window.$ = window.jQuery = $;
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap; // supaya ruang-admin.js bisa akses global

// import './bootstrap'; // Biarkan jika ada
// import Alpine from 'alpinejs'; // <-- IMPORT ALPINE

// window.Alpine = Alpine; // <-- Membuat Alpine tersedia secara global

// Alpine.start();

// apex chart
import ApexCharts from 'apexcharts';
window.ApexCharts = ApexCharts;

// full calender
import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list'
// optional
import interactionPlugin from '@fullcalendar/interaction'

// unutk calender all
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar')

    if (!calendarEl) return

    const calendar = new Calendar(calendarEl, {
        plugins: [
            dayGridPlugin,
            timeGridPlugin,
            listPlugin,
            interactionPlugin
        ],
        initialView: 'dayGridMonth',
        height: 'auto',
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listDay'
        },

        // --- TAMBAHKAN BARIS INI ---
        eventDisplay: 'block',
        // ---------------------------

        navLinks: true,
        dateClick(info) {
            calendar.changeView('listDay', info.dateStr)
        },

        events: calendarEl.getAttribute('data-url'),
    })

    calendar.render()
})

// unutk kalender kusus pengelolaan agenda detail, pengelolaan peminjaman detail dan riwayat detail
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendarDetail')

    if (!calendarEl) return

    // Jika data-start-date kosong, kita beri fallback ke tanggal hari ini
    const startDate = calendarEl.getAttribute('data-start-date') || new Date();

    const calendar = new Calendar(calendarEl, {
        plugins: [
            dayGridPlugin,
            timeGridPlugin,
            listPlugin,
            interactionPlugin
        ],
        initialDate: startDate,
        initialView: 'dayGridMonth',
        height: 'auto',
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listDay'
        },

        // --- TAMBAHKAN BARIS INI ---
        eventDisplay: 'block',
        // ---------------------------

        navLinks: true,
        dateClick(info) {
            calendar.changeView('listDay', info.dateStr)
        },

        events: calendarEl.getAttribute('data-url'),
    })

    calendar.render()
})


// import 'bootstrap/dist/js/bootstrap.bundle.min.js';
// import 'bootstrap/dist/css/bootstrap.min.css';
// // resources/js/app.js
// import '@fortawesome/fontawesome-free/css/all.min.css';


