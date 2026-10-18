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



/* Kalender agenda publik pada halaman login. Seluruh interaksi hanya baca. */
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('public-calendar');
    if (!calendarEl) return;

    const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, (char) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
    })[char]);

    const formatDate = (value) => {
        if (!value) return 'Tanggal belum ditentukan';
        const date = new Date(value + 'T00:00:00');
        return Number.isNaN(date.getTime()) ? value : new Intl.DateTimeFormat('id-ID', {
            day: 'numeric', month: 'long', year: 'numeric'
        }).format(date);
    };

    const formatTime = (start, end) => {
        if (!start && !end) return 'Sehari penuh / waktu belum ditentukan';
        return (start || '--:--') + '–' + (end || '--:--') + ' WIB';
    };

    const resourceMarkup = (items, kind) => {
        if (!items || !items.length) {
            return '<div class="empty">Tidak ada informasi ' + kind + ' untuk tanggal ini.</div>';
        }
        return items.map((item) => {
            const time = formatTime(item.jam_mulai, item.jam_selesai);
            const quantity = item.jumlah ? ' · Jumlah ' + escapeHtml(item.jumlah) : '';
            return '<div class="resource"><strong>' + escapeHtml(item.nama) + '</strong>' +
                '<small>' + escapeHtml(time) + quantity + '</small></div>';
        }).join('');
    };

    const modalElement = document.getElementById('publicAgendaModal');
    const modalTitle = document.getElementById('publicAgendaModalTitle');
    const modalBody = document.getElementById('publicAgendaModalBody');
    const modal = modalElement && window.bootstrap ? new window.bootstrap.Modal(modalElement) : null;

    const showError = (message) => {
        modalTitle.textContent = 'Detail agenda tidak tersedia';
        modalBody.innerHTML = '<div class="empty">' + escapeHtml(message) + '</div>';
        if (modal) modal.show();
    };

    const openAgenda = async (event) => {
        const props = event.extendedProps || {};
        if (!props.detail_url) {
            showError('Tautan detail agenda tidak tersedia.');
            return;
        }
        modalTitle.textContent = event.title || 'Detail agenda';
        modalBody.innerHTML = '<div class="text-center py-5 text-secondary"><span class="spinner-border spinner-border-sm me-2" role="status"></span>Memuat informasi agenda...</div>';
        if (modal) modal.show();

        try {
            const response = await fetch(props.detail_url, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Informasi agenda gagal dimuat.');

            modalTitle.textContent = data.nama_agenda || 'Detail agenda';
            modalBody.innerHTML =
                '<div class="chips">' +
                    '<span class="chip">▦ ' + escapeHtml(formatDate(data.tanggal)) + '</span>' +
                    '<span class="chip">◈ ' + escapeHtml(data.tipe_agenda || 'Agenda Fakultas') + '</span>' +
                    '<span class="chip">Kode: ' + escapeHtml(data.kode_agenda || '-') + '</span>' +
                '</div>' +
                '<div class="section-label">Ruangan yang digunakan</div>' +
                resourceMarkup(data.ruangan, 'ruangan') +
                '<div class="section-label">Barang / sarana yang digunakan</div>' +
                resourceMarkup(data.barang, 'barang');
        } catch (error) {
            showError(error.message || 'Terjadi kesalahan saat memuat agenda.');
        }
    };

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        height: 'auto',
        locale: 'id',
        firstDay: 1,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listDay'
        },
        buttonText: { today: 'Hari ini', month: 'Bulan', week: 'Minggu', day: 'Hari', list: 'Agenda' },
        noEventsText: 'Tidak ada agenda pada periode ini',
        navLinks: true,
        dayMaxEvents: 3,
        moreLinkText: (count) => '+' + count + ' agenda',
        eventDisplay: 'block',
        events: {
            url: calendarEl.getAttribute('data-events-url'),
            failure: () => {
                calendarEl.insertAdjacentHTML('beforeend', '<p class="text-danger small mt-3">Kalender gagal dimuat. Silakan muat ulang halaman.</p>');
            }
        },
        dateClick(info) {
            calendar.changeView('listDay', info.dateStr);
        },
        eventClick(info) {
            info.jsEvent.preventDefault();
            openAgenda(info.event);
        }
    });
    calendar.render();
});
