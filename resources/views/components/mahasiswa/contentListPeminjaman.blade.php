@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)" class="alert alert-success">
        <ul style="margin-bottom: 0;">
            {{ session('success') }}
        </ul>
    </div>
@endif

@if (session('gagal'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)" class="alert alert-danger">
        <ul style="margin-bottom: 0;">
            {{ session('gagal') }}
        </ul>
    </div>
@endif

<!-- Content Grid: Items (Left) + Summary (Right) -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Left Column: Cart Items List -->
    <div class="lg:col-span-8 flex flex-col gap-4">
        <!-- Header for List (Desktop only) -->
        <div
            class="hidden md:flex justify-between items-center pb-2 border-b border-gray-300 text-[#617589] text-sm font-medium">
            <span class="pl-4">Cart Barang</span>
        </div>
        <!-- cart barang -->
        @foreach ($listBarangDiajukan as $cartbarang)
            {{-- @dump($cartbarang) --}}
            <div class="flex flex-col md:flex-row gap-4 bg-white rounded-xl p-3 shadow-sm border border-[#f0f2f">
                <div class="flex items-start gap-4 flex-1">
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg size-24 md:size-[100px] shrink-0"
                        data-alt="Nike Air running shoes side profile on grey background"
                        style='background-image: url("/storage/{{ $cartbarang['img_item'] }}");'>
                    </div>
                    <div class="flex flex-1 flex-col justify-between h-full min-h-[100px]">
                        <div>
                            <div class="items-center">
                                <p class="text-[#111418] text-lg font-bold leading-normal m-0!">
                                    {{ $cartbarang['nama_item'] }}
                                </p>
                            </div>
                            <p class="text-[#617589] text-sm font-normal leading-normal">
                                {{ $cartbarang['nama_tipe_item'] }}
                            </p>
                        </div>
                        {{-- <p class="text-primary text-base font-bold leading-normal mt-2 md:mt-auto">Rp
                            1.500.000
                        </p> --}}
                    </div>
                </div>
                <div
                    class="flex md:flex-col items-center md:items-end justify-between gap-4 shrink-0 border-t md:border-t-0 border-[#f0f2f4] pt-4 md:pt-0 mt-2 md:mt-0">
                    <div class="flex items-center gap-2 text-[#111418] bg-[#f0f2f4] rounded-lg p-1"
                        x-data="{ qty: {{ $cartbarang['qty_pinjam'] }} }">
                        <button
                            class="flex h-8 w-8 items-center justify-center rounded-md bg-white shadow-sm cursor-pointer hover:text-primary transition-colors"
                            @click="qty = Math.max(0, qty - 1)" :disabled="qty <= 0">
                            <span class="material-symbols-outlined text-[16px]"></span>
                            &minus;
                        </button>
                        <input x-model="qty" min="0"
                            class="w-8 p-0 text-center bg-transparent focus:outline-0 focus:ring-0 border-none font-semibold text-sm"
                            readonly="" type="text" />
                        <button @click="qty = Math.min(qty + 1)" :disabled="qty >= {{ $cartbarang['qty_item'] }}"
                            class="flex h-8 w-8 items-center justify-center rounded-md bg-white shadow-sm cursor-pointer hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[16px]"></span>
                            &plus;
                        </button>
                    </div>
                    <form method="POST" action="{{ route('hapus-item-cart') }}">
                        @csrf
                        <input type="text" name="id_item" class="hidden"
                            value="{{ $cartbarang['id_item'] }}">
                        <button
                            class=" md:flex items-center gap-1 text-[#617589] hover:text-red-500 text-sm font-medium transition-colors">
                            <i class="fa-solid fa-trash"></i>
                            <span>Hapus</span>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach

        <!-- Header for List (Desktop only) -->
        <div
            class="hidden md:flex justify-between items-center pb-2 border-b border-gray-300 text-[#617589] text-sm font-medium">
            <span class="pl-4">Cart Ruangan</span>
        </div>

         <!-- cart barang -->
        @foreach ($listRuanganDiajukan as $cartruangan)
            {{-- @dump($cartbarang) --}}
            <div class="flex flex-col md:flex-row gap-4 bg-white rounded-xl p-3 shadow-sm border border-[#f0f2f">
                <div class="flex items-start gap-4 flex-1">
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg size-24 md:size-[100px] shrink-0"
                        data-alt="Nike Air running shoes side profile on grey background"
                        style='background-image: url("/storage/{{ $cartruangan['gambar_room'] }}");'>
                    </div>
                    <div class="flex flex-1 flex-col justify-between h-full min-h-[100px]">
                        <div>
                            <div class="items-center">
                                <p class="text-[#111418] text-lg font-bold leading-normal m-0!">
                                    {{ $cartruangan['nama_room'] }}
                                </p>
                            </div>
                            <p class="text-[#617589] text-sm font-normal leading-normal">
                                {{ $cartruangan['nama_tipe_room'] }}
                            </p>
                        </div>
                        {{-- <p class="text-primary text-base font-bold leading-normal mt-2 md:mt-auto">Rp
                            1.500.000
                        </p> --}}
                    </div>
                </div>
                <div
                    class="flex md:flex-col items-center md:items-end justify-between gap-4 shrink-0 border-t md:border-t-0 border-[#f0f2f4] pt-4 md:pt-0 mt-2 md:mt-0">
                    <div class="flex items-center gap-2 text-[#111418] bg-[#f0f2f4] rounded-lg p-1"
                        x-data="{ qty: 1 }">
                        <button readonly=""
                            class="flex h-8 w-8 items-center justify-center rounded-md bg-white shadow-sm cursor-pointer hover:text-primary transition-colors"
                            >
                            <span class="material-symbols-outlined text-[16px]"></span>
                            &minus;
                        </button>
                        <input x-model="qty" min="0"
                            class="w-8 p-0 text-center bg-transparent focus:outline-0 focus:ring-0 border-none font-semibold text-sm"
                            readonly="" type="text" />
                        <button readonly
                            class="flex h-8 w-8 items-center justify-center rounded-md bg-white shadow-sm cursor-pointer hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[16px]"></span>
                            &plus;
                        </button>
                    </div>
                    <form method="POST" action="{{ route('hapus-item-cart') }}">
                        @csrf
                        <input type="text" name="id_item" class="hidden"
                            value="{{ $cartruangan['id_room'] }}">
                        <button
                            class=" md:flex items-center gap-1 text-[#617589] hover:text-red-500 text-sm font-medium transition-colors">
                            <i class="fa-solid fa-trash"></i>
                            <span>Hapus</span>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>


    <!-- Right Column: Order Summary (Sticky) -->
    <div class="lg:col-span-4">
        <div class="sticky top-24 flex flex-col gap-6 bg-whi rounded-xl p-6 shadow-sm border border-[#f0f2f4]">
            <h3 class="text-[#111418] text-xl font-bold leading-tight">Ringkasan
                Pesanan</h3>
            <div class="flex flex-col gap-3 pb-6 border-b border-[#f0f2f4]">
                <div class="flex justify-between items-center">
                    <p class="text-[#617589] text-base font-normal">Subtotal</p>
                    <p class="text-[#111418] text-base font-medium">Rp 2.900.000</p>
                </div>
                <div class="flex justify-between items-center">
                    <p class="text-[#617589] text-base font-normal">Diskon (Promo)</p>
                    <p class="text-green-600 text-base font-medium">- Rp 0</p>
                </div>
                <div class="flex justify-between items-center">
                    <p class="text-[#617589] text-base font-normal">Estimasi Pajak (11%)</p>
                    <p class="text-[#111418] text-base font-medium">Rp 319.000</p>
                </div>
            </div>
            <!-- Promo Code Input -->
            <div class="flex gap-2">
                <input
                    class="form-input flex-1 min-w-0 rounded-lg text-[#111418] border border-[#dce0e5] bg-white px-3 py-2 text-sm focus:border-primary focus:ring-primary"
                    placeholder="Kode Promo" />
                <button
                    class="flex items-center justify-center rounded-lg bg-[#f0f2f4] px-4 py-2 text-sm font-bold text-[#111418] hover:bg-[#e0e2e5] transition-colors">
                    Pakai
                </button>
            </div>
            <div class="flex justify-between items-center pt-2">
                <p class="text-[#111418] text-lg font-bold">Total</p>
                <p class="text-[#111418] text-2xl font-black text-primary">Rp 3.219.000
                </p>
            </div>
            <button
                class="flex w-full cursor-pointer items-center justify-center rounded-lg bg-primary py-3 text-white text-base font-bold leading-normal hover:bg-blue-600 transition-colors shadow-md shadow-blue-500/20">
                Lanjutkan ke Pembayaran
            </button>
            <div class="flex justify-center mt-2">
                <a class="text-sm font-medium text-[#617589] hover:text-primary flex items-center gap-1 transition-colors"
                    href="#">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    Lanjut Belanja
                </a>
            </div>
        </div>
    </div>
</div>
