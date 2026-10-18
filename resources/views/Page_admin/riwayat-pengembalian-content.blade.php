            <div class="container-fluid px-3 py-4">
                <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <a href="{{ route('dashboard-admin') }}" class="text-blue-600 hover:underline">Dashboard</a>
                        <h1 class="mt-3 text-2xl font-bold text-slate-800">Riwayat Pemeriksaan Pengembalian</h1>
                        <p class="mt-1 text-sm text-slate-500">Catatan kondisi barang dan ruangan saat dikembalikan.</p>
                    </div>
                    <a href="{{ route('dashboard-admin') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold">Kembali ke Dashboard</a>
                </div>

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                                <tr>
                                    <th class="px-4 py-3">Tanggal</th><th class="px-4 py-3">Kode Peminjaman</th><th class="px-4 py-3">Aset</th><th class="px-4 py-3">Kondisi</th><th class="px-4 py-3">Jumlah Rusak</th><th class="px-4 py-3">Deskripsi</th><th class="px-4 py-3">Foto</th><th class="px-4 py-3">Petugas</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($riwayat as $row)
                                    <tr class="align-top">
                                        <td class="whitespace-nowrap px-4 py-3">{{ \Carbon\Carbon::parse($row->tanggal_pemeriksaan)->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-3 font-medium">{{ $row->kode_peminjaman }}</td>
                                        <td class="px-4 py-3">{{ $row->jenis_aset === 'barang' ? ($row->nama_item ?? $row->id_item) : ($row->nama_room ?? $row->id_room) }}<div class="text-xs text-slate-500">{{ ucfirst($row->jenis_aset) }}</div></td>
                                        <td class="px-4 py-3"><span class="rounded-full px-2 py-1 text-xs font-bold {{ $row->kondisi_pengembalian === 'rusak' ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">{{ ucfirst($row->kondisi_pengembalian) }}</span></td>
                                        <td class="px-4 py-3">{{ $row->qty_rusak }} / {{ $row->qty_dikembalikan }}</td>
                                        <td class="max-w-xs px-4 py-3 whitespace-normal">{{ $row->deskripsi_kerusakan ?: '—' }}</td>
                                        <td class="px-4 py-3">@if ($row->foto_kerusakan)<a class="text-blue-600 underline" href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($row->foto_kerusakan) }}" target="_blank" rel="noopener">Lihat foto</a>@else — @endif</td>
                                        <td class="px-4 py-3">{{ $row->username ?? $row->dicatat_oleh }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="px-4 py-10 text-center text-slate-500">Belum ada catatan pemeriksaan pengembalian.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="border-t border-slate-100 p-4">{{ $riwayat->links() }}</div>
                </div>
