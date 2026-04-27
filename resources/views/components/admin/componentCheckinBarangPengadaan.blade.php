<!-- Main Content Area -->
<main class="py-6 min-h-screen bg-surface-container-low">
    <div class="mx-auto space-y-8">
        <!-- Read-only Summary Card -->
        <section class="bg-white border border-slate-200 rounded-xl p-6 flex flex-wrap items-center gap-8 shadow-sm">
            <div class="flex items-center gap-4 border-r border-slate-100 pr-8">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                    {{-- <span class="material-symbols-outlined text-2xl" data-icon="laptop_mac">laptop_mac</span> --}}
                    <i class="fa-solid fa-box text-2xl"></i>

                </div>
                <div>
                    <p class="text-label-xs font-label-xs text-slate-500 font-bold">Nama item</p>
                    <p class="text-heading-card font-heading-card text-slate-900">Laptop Dell</p>
                </div>
            </div>
            <div class="flex flex-col gap-1 border-r border-slate-100 pr-8">
                <p class="text-label-xs font-label-xs text-slate-500 font-bold">Total Qty</p>
                <div class="flex items-baseline gap-1">
                    <p class="text-heading-card font-heading-card text-slate-900">20</p>
                    <span class="text-xs text-slate-500">Units</span>
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <p class="text-label-xs font-label-xs text-slate-500 font-bold">Tahun Pengajuan</p>
                <div class="flex items-center gap-2">
                    <p class="text-body-md font-body-md text-slate-700">Faculty Budget 2024</p>
                </div>
            </div>
            <div class="ml-auto">
                <div
                    class="bg-blue-50 text-blue-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-blue-100 uppercase tracking-wider">
                    Awaiting Distribution
                </div>
            </div>
        </section>
        <!-- Main Allocation Section -->
        <section class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-heading-card font-heading-card text-slate-900">Allocation Distribution</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Assign items to specific rooms and define their
                        condition.</p>
                </div>
                <div class="text-right">
                    <p class="text-label-xs font-label-xs text-slate-500 uppercase mb-1 text-right">Allocation
                        Progress</p>
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-slate-900">15 of 20 remaining</span>
                        <div class="w-32 h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="bg-primary h-full rounded-full" style="width: 25%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-4">
                <!-- Table Header -->
                <div
                    class="grid grid-cols-12 gap-4 px-4 py-2 bg-slate-50 rounded-lg text-table-header font-table-header text-slate-500 uppercase">
                    <div class="col-span-4">Select Room</div>
                    <div class="col-span-3">Quantity to Store</div>
                    <div class="col-span-4">Condition</div>
                    <div class="col-span-1 text-center">Action</div>
                </div>
                <!-- Row 1 -->
                <div class="grid grid-cols-12 gap-4 px-4 py-1 items-center">
                    <div class="col-span-4 relative">
                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-lg"
                            data-icon="door_open">door_open</span>
                        <select
                            class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-primary/20 outline-none">
                            <option>Computer Lab A (Room 402)</option>
                            <option>Main Library (Floor 2)</option>
                            <option>Faculty Office (South)</option>
                        </select>
                    </div>
                    <div class="col-span-3">
                        <input
                            class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-primary/20 outline-none"
                            type="number" value="5" />
                    </div>
                    <div class="col-span-4 relative">
                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-lg"
                            data-icon="verified">verified</span>
                        <select
                            class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-primary/20 outline-none">
                            <option>New</option>
                            <option>Good</option>
                            <option>Damaged</option>
                        </select>
                    </div>
                    <div class="col-span-1 flex justify-center">
                        <button class="p-2 text-slate-300 cursor-not-allowed">
                            <span class="material-symbols-outlined" data-icon="delete">delete</span>
                        </button>
                    </div>
                </div>
                <!-- Row 2 (Validation Example: Error State) -->
                <div class="grid grid-cols-12 gap-4 px-4 py-1 items-center">
                    <div class="col-span-4 relative">
                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-lg"
                            data-icon="door_open">door_open</span>
                        <select
                            class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-primary/20 outline-none">
                            <option>Faculty Office (South)</option>
                            <option>Computer Lab A (Room 402)</option>
                            <option>Main Library (Floor 2)</option>
                        </select>
                    </div>
                    <div class="col-span-3">
                        <div class="relative">
                            <input
                                class="w-full px-4 py-2 bg-error-container border border-error text-on-error-container rounded-lg text-xs focus:ring-2 focus:ring-error/20 outline-none font-bold"
                                type="number" value="25" />
                            <div
                                class="absolute -bottom-5 left-0 text-[9px] text-error font-bold flex items-center gap-1">
                                <span class="material-symbols-outlined text-[12px]" data-icon="error">error</span>
                                Total exceeds 20 available units
                            </div>
                        </div>
                    </div>
                    <div class="col-span-4 relative">
                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-lg"
                            data-icon="verified">verified</span>
                        <select
                            class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-primary/20 outline-none">
                            <option>New</option>
                            <option>Good</option>
                            <option>Damaged</option>
                        </select>
                    </div>
                    <div class="col-span-1 flex justify-center">
                        <button
                            class="p-2 text-slate-400 hover:text-error hover:bg-error-container/20 rounded-lg transition-colors">
                            <span class="material-symbols-outlined" data-icon="delete">delete</span>
                        </button>
                    </div>
                </div>
                <!-- Row 3 -->
                <div class="grid grid-cols-12 gap-4 px-4 py-1 items-center pt-4">
                    <div class="col-span-4 relative">
                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-lg"
                            data-icon="door_open">door_open</span>
                        <select
                            class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-primary/20 outline-none">
                            <option>Select a destination room...</option>
                            <option>Room 101</option>
                            <option>Room 202</option>
                        </select>
                    </div>
                    <div class="col-span-3">
                        <input
                            class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-primary/20 outline-none"
                            placeholder="Qty" type="number" />
                    </div>
                    <div class="col-span-4 relative">
                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-lg"
                            data-icon="verified">verified</span>
                        <select
                            class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-primary/20 outline-none">
                            <option>Select condition...</option>
                            <option>New</option>
                            <option>Good</option>
                            <option>Damaged</option>
                        </select>
                    </div>
                    <div class="col-span-1 flex justify-center">
                        <button
                            class="p-2 text-slate-400 hover:text-error hover:bg-error-container/20 rounded-lg transition-colors">
                            <span class="material-symbols-outlined" data-icon="delete">delete</span>
                        </button>
                    </div>
                </div>
                <div class="pt-6 border-t border-slate-100 flex justify-start">
                    <button
                        class="flex items-center gap-2 text-xs font-bold text-tertiary hover:bg-tertiary-container/10 px-4 py-2 rounded-lg transition-colors">
                        <span class="material-symbols-outlined" data-icon="add_circle">add_circle</span>
                        + Add Another Room
                    </button>
                </div>
            </div>
            <!-- Footer Section -->
            <div class="bg-slate-50 p-6 flex items-center justify-between mt-8">
                <button
                    class="px-6 py-2 border border-slate-300 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-100 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm" data-icon="arrow_back">arrow_back</span>
                    Back
                </button>
                <div class="flex items-center gap-3">
                    <div class="text-right mr-4">
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest leading-none mb-1">
                            Items To Confirm</p>
                        <p class="text-sm font-black text-slate-900">30 Units Allocated</p>
                    </div>
                    <button
                        class="px-8 py-2.5 bg-tertiary text-on-tertiary rounded-lg text-sm font-bold shadow-lg shadow-tertiary/20 hover:opacity-90 active:scale-[0.98] transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg" data-icon="check_circle">check_circle</span>
                        Confirm &amp; Distribute
                    </button>
                </div>
            </div>
        </section>
    </div>
</main>
