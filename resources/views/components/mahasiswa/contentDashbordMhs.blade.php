
<div class="max-w-[1200px] mx-auto flex flex-col gap-8">
    {{-- count peminjaman --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
        <div
            class="bg-surface-light px-5 py-3 rounded-xl border border-[#e7ecf3] shadow-sm flex flex-col justify-between group hover:border-primary/50 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-blue-50 p-2.5 rounded-lg text-primary">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
                
            </div>
            <div>
                <p class="text-text-secondary text-sm font-medium mb-1">Peminjaman</p>
                <div class="flex items-baseline gap-2">
                    <h5 class="text-2xl font-bold text-text-main">{{ $dataPeminjamanByMhs }} Peminjaman</h5>
                    {{-- <span class="text-xs text-text-secondary">active now</span> --}}
                </div>
            </div>
        </div>
        <div
            class="bg-surface-light px-5 py-3 rounded-xl border border-[#e7ecf3] shadow-sm flex flex-col justify-between hover:border-primary/50 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-red-50 p-2.5 rounded-lg text-red-600">
                    
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
            </div>
            <div>
                <p class="text-text-secondary text-sm font-medium mb-1">Lewat waktu pinjam</p>
                <div class="flex items-baseline gap-2">
                    <h5 class="text-2xl font-bold text-text-main">{{ $dataPeminjamanLewatByMhs }} Peminjaman</h5>
                    {{-- <span class="text-xs text-text-secondary">Until 16:00</span> --}}
                </div>
            </div>
        </div>
        <div
            class="bg-surface-light px-5 py-3 rounded-xl border border-[#e7ecf3] shadow-sm flex flex-col justify-between hover:border-primary/50 transition-colors">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-orange-50 p-2.5 rounded-lg text-orange-600">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
            </div>
            <div>
                <p class="text-text-secondary text-sm font-medium mb-1">Menunggu persetujuan</p>
                <div class="flex items-baseline gap-2">
                    <h5 class="text-2xl font-bold text-text-main">{{ $dataPeminjamanDiajukanByMhs }} Pengajuan</h5>
                    {{-- <span class="text-xs text-text-secondary">In Review</span> --}}
                </div>
            </div>
        </div>
    </div>
    <div>
        <h3 class="text-lg font-bold text-text-main mb-4">Agenda Penggunaan Ruangan</h3>
        <div id="calendar" data-url="{{ url('/peminjam/events-calender') }}" class="mb-4 border-t-1 pt-4 border-gray-300 fc-tailwind"></div>
        
    </div>
</div>


