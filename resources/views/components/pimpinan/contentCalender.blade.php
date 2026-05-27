<main class="flex-1 py-2 px-2 mb-4">

    {{-- isi konten --}}
    <div class="">
        <!-- agenda berlangsung -->
        <div class="space-y-8">
            <!-- detail agenda today -->
            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                {{-- calender --}}
                <div id="calendar" data-url="{{ url('/pimpinan/events-calender') }}"
                    class="mb-4 pt-4 border-gray-300 fc-tailwind">
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
