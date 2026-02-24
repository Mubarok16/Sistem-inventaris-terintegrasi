<main class="flex-1 py-2 px-2 mb-4">

    {{-- isi konten --}}
    <div class="">
        <!-- agenda berlangsung -->
        <div class="space-y-8">
            <!-- detail agenda today -->
            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h5 class="font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-minus text-primary"></i>
                        Agenda Berlangsung
                    </h5>
                </div>
                {{-- live data agenda yg berlangsung --}}
                <livewire:agenda-berlangsung />
                {{-- calender --}}
                <div id="calendar" data-url="{{ url('/admin/events-calender') }}"
                    class="mb-4 border-t-1 pt-4 border-gray-300 fc-tailwind">
                </div>
            </div>
            
        </div>
    </div>
</main>

<script>
    function updateClock() {
        const now = new Date();

        // Ambil jam dan menit, tambahkan angka 0 di depan jika di bawah 10
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');

        // Format waktu (HH:mm)
        const timeString = `${hours} : ${minutes} WIB`;

        // Update isi dari elemen dengan ID 'realtime-clock'
        document.getElementById('realtime-clock').textContent = timeString;
    }

    // Jalankan fungsi setiap 1 detik (1000 milidetik)
    setInterval(updateClock, 1000);

    // Jalankan sekali di awal agar tidak menunggu 1 detik pertama
    updateClock();
</script>
