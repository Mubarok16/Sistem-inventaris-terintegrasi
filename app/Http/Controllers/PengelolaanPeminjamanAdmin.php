<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\UsageItems;
use App\Models\UsageRooms;
use App\services\Admin\PengelolaanPeminjamanService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengelolaanPeminjamanAdmin extends Controller
{
    // menampilkan halaman detail peminjaman admin
    function DetailPeminjamanAdmin(Request $request, $id)
    {
        if (Auth::user()->hak_akses  !== "admin") {
            $request->session()->put('halaman-yang-dikunjungi', '/admin/pengajuan-peminjaman/detail/' . $id);

            // abort(403, 'Unauthorized');
            return redirect()->route('login')->with('gagal', 'Anda harus login sebagai admin untuk mengakses halaman ini.');
        }

        $dataDetailPengajuanPeminjaman = DB::table('peminjaman')
            ->join('peminjam', 'peminjaman.no_identitas', '=', 'peminjam.no_identitas')
            ->select('peminjaman.*', 'peminjam.nama_peminjam', 'peminjam.no_identitas', 'peminjam.fakultas', 'peminjam.prodi') // Pilih kolom yang diperlukan
            ->where('peminjaman.kode_peminjaman', $id)
            ->get();

        $detailBarang = DB::table('usage_items')
            ->join('items', 'usage_items.id_item', '=', 'items.id_item')
            ->select('usage_items.*', 'items.nama_item', 'items.id_item', 'items.kondisi_item', 'items.img_item') // Pilih kolom yang diperlukan
            ->where('usage_items.kode_peminjaman', $id)
            ->first();

        $detailRuangan = DB::table('usage_rooms')
            ->join('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
            ->join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
            ->select('usage_rooms.*', 'rooms.nama_room', 'rooms.id_room', 'rooms.kondisi_room', 'rooms.gambar_room', 'tipe_rooms.nama_tipe_room') // Pilih kolom yang diperlukan
            ->where('usage_rooms.kode_peminjaman', $id)
            ->first();

        // mengambil tgl pinjam dan tgl kembali dari usage_items dan usage_rooms
        $tglPinjamItem = DB::table('usage_items')
            ->select('tgl_pinjam_usage_item', 'tgl_kembali_usage_item')
            ->where('kode_peminjaman', $id)
            ->get();

        $tglPinjamRoom = DB::table('usage_rooms')
            ->select('tgl_pinjam_usage_room', 'tgl_kembali_usage_room')
            ->where('kode_peminjaman', $id)
            ->get();

        $tglPinjam = null;
        $tglKembali = null;

        if (!$tglPinjamItem->isEmpty()) {
            foreach ($tglPinjamItem as $value) {
                $tglPinjam = $value->tgl_pinjam_usage_item;
                $tglKembali = $value->tgl_kembali_usage_item;
            }
        } else {
            foreach ($tglPinjamRoom as $value) {
                $tglPinjam = $value->tgl_pinjam_usage_room;
                $tglKembali = $value->tgl_kembali_usage_room;
            }
        }

        // dd($detailBarang);
        $tglStartKalender = $dataDetailPengajuanPeminjaman[0]->tgl_pinjam;

        // cek jadwal agenda
        $PengelolaanPeminjamanService = new PengelolaanPeminjamanService;
        $dataBentrokJadwal = $PengelolaanPeminjamanService->cekPeminjamanAgenda($id, $tglPinjam, $tglKembali);

        // mengambil data barang yg bentrok return dari service cek jadwal
        $itemBentrok = $dataBentrokJadwal['barang']->filter(function ($item) {
            return $item['status'] === 'BENTROK';
        });

        // mengambil data ruangan yg bentrok return dari service cek jadwal
        $roomBentrok = $dataBentrokJadwal['ruangan']->filter(function ($room) {
            return $room['status'] === 'BENTROK';
        });

        // dd($roomBentrok);
        // simpan id di session
        session()->put('id_peminjaman_agenda', $id);

        $user = DB::table('detail_staff')->where('id_user', Auth::user()->id_user)->value('nama');
        $halaman = 'contentDetailPenminjaman';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'dataDetailPengajuanPeminjaman', 'detailBarang', 'detailRuangan', 'tglPinjam', 'tglKembali', 'itemBentrok', 'roomBentrok', 'tglStartKalender'));
    }

    // persetujuan
    function persetujuan(Request $request)
    {
        $request->validate([
            'kode_peminjaman' => 'string',
        ]);

        // id admin yg approve
        $id_admin = Auth::user()->id_user;
        // dd($request->all());

        if ($request->aksi === 'approve') {
            // update status jika disetujui
            DB::table('peminjaman')->where('kode_peminjaman', $request->kode_peminjaman)
                ->update([
                    'status_peminjaman' => 'terjadwal',
                    'updated_at' => now(),
                    'id_user' => $id_admin,
                    'catatan_pengelola' => $request->catatan
                ]);

            UsageItems::where('kode_peminjaman', $request->kode_peminjaman)
                ->update([
                    'status_usage_item' => 'terjadwal',
                    'updated_at' => now(),
                ]);

            UsageRooms::where('kode_peminjaman', $request->kode_peminjaman)
                ->update([
                    'status_usage_room' => 'terjadwal',
                    'updated_at' => now(),
                ]);

            return redirect()->route('admin.pengajuan.peminjaman')->with('success', 'Status persetujuan berhasil diperbarui.');
        } else {
            // update status jika di reject
            DB::table('peminjaman')->where('kode_peminjaman', $request->kode_peminjaman)
                ->update([
                    'status_peminjaman' => 'ditolak',
                    'updated_at' => now(),
                    'id_user' => $id_admin,
                    'catatan_pengelola' => $request->catatan
                ]);

            UsageItems::where('kode_peminjaman', $request->kode_peminjaman)
                ->update([
                    'status_usage_item' => 'ditolak',
                    'updated_at' => now(),
                ]);

            UsageRooms::where('kode_peminjaman', $request->kode_peminjaman)
                ->update([
                    'status_usage_room' => 'ditolak',
                    'updated_at' => now(),
                ]);

            return redirect()->route('admin.pengajuan.peminjaman')->with('gagal', 'Status persetujuan berhasil diperbarui.');
        }
    }

    // konfirmasi pengambilan barang atau kunci ruangan
    function konfirmasiAmbilKembali(Request $request)
    {

        $roomTerdajwal = DB::table('usage_rooms')
            ->select(
                'kode_peminjaman',
                'tgl_pinjam_usage_room',
                'status_usage_room',
                'jam_mulai_usage_room'
            )
            ->where('kode_peminjaman', $request->kode_peminjaman)
            ->whereDate('tgl_pinjam_usage_room', now()->toDateString())
            ->where('status_usage_room', 'terjadwal');
        // ->get();

        // dd($roomTerdajwal->first()->jam_mulai_usage_room);

        $itemTerjdawal = DB::table('usage_items')
            ->select(
                'kode_peminjaman',
                'tgl_pinjam_usage_item',
                'status_usage_item',
                'jam_mulai_usage_item'
            )
            ->where('kode_peminjaman', $request->kode_peminjaman)
            ->whereDate('tgl_pinjam_usage_item', now()->toDateString())
            ->where('status_usage_item', 'terjadwal');
        // ->get();

        // dd(isset($itemTerjdawal->first()->jam_mulai_usage_item));


        $roomDigunakan = DB::table('usage_rooms')
            ->select(
                'kode_peminjaman',
                'tgl_pinjam_usage_room',
                'status_usage_room',
                'jam_mulai_usage_room'
            )
            ->where('kode_peminjaman', $request->kode_peminjaman)
            ->whereDate('tgl_pinjam_usage_room', now()->toDateString())
            ->where('status_usage_room', 'digunakan');
        // ->get();

        $itemDigunakan = DB::table('usage_items')
            ->select(
                'kode_peminjaman',
                'tgl_pinjam_usage_item',
                'status_usage_item',
                'jam_mulai_usage_item'
            )
            ->where('kode_peminjaman', $request->kode_peminjaman)
            ->whereDate('tgl_pinjam_usage_item', now()->toDateString())
            ->where('status_usage_item', 'digunakan');
        // ->get();

        #logika unutk persetujuan pengambilan dan pengembalian barang ruangan sesuai dengan id yg di scan atau di inputkan
        if ($roomTerdajwal->count() > 0 or $itemTerjdawal->count() > 0) {

            #logika if jika peminjamannya full day maka akan update semua item dan room yg ada di table usage item dan room menjadi digunakan berdasarkan idnya

            // Kita cek apakah data pertama ada DAN nilainya adalah string 'null'
            $isRoomFullDay = $roomTerdajwal->first()?->jam_mulai_usage_room === null;
            $isItemFullDay = $itemTerjdawal->first()?->jam_mulai_usage_item === null;

            DB::table('peminjaman')->where('kode_peminjaman', $request->kode_peminjaman)
                ->where('status_peminjaman', 'terjadwal')
                ->update([
                    'status_peminjaman' => 'digunakan',
                    'updated_at' => now(),
                ]);

            if ($isRoomFullDay || $isItemFullDay) {
                // dd($isRoomFullDay, $isItemFullDay);
                # jika room dan item ada yang terjadwal hari ini, maka update status keduanya menjadi digunakan
                # hanya untuk mengupdate semua usage room yg ada karna full day 
                DB::table('usage_rooms')
                    ->select(
                        'kode_peminjaman',
                        'tgl_pinjam_usage_room',
                        'status_usage_room'
                    )
                    ->where('kode_peminjaman', $request->kode_peminjaman)
                    // ->whereDate('tgl_pinjam_usage_room', now()->toDateString())
                    ->where('status_usage_room', 'terjadwal')
                    ->update([
                        'status_usage_room' => 'digunakan',
                        'updated_at' => now(),
                    ]);

                DB::table('usage_items')
                    ->select(
                        'kode_peminjaman',
                        'tgl_pinjam_usage_item',
                        'status_usage_item'
                    )
                    ->where('kode_peminjaman', $request->kode_peminjaman)
                    // ->whereDate('tgl_pinjam_usage_item', now()->toDateString())
                    ->where('status_usage_item', 'terjadwal')
                    ->update([
                        'status_usage_item' => 'digunakan',
                        'updated_at' => now(),
                    ]);
            } else {
                # jika room dan item ada yang terjadwal hari ini, maka update status keduanya menjadi digunakan
                # hanya untuk mengupdate hanya satu hari saja karna spesifik
                DB::table('usage_rooms')
                    ->select(
                        'kode_peminjaman',
                        'tgl_pinjam_usage_room',
                        'status_usage_room'
                    )
                    ->where('kode_peminjaman', $request->kode_peminjaman)
                    ->whereDate('tgl_pinjam_usage_room', now()->toDateString())
                    ->where('status_usage_room', 'terjadwal')
                    ->update([
                        'status_usage_room' => 'digunakan',
                        'updated_at' => now(),
                    ]);

                DB::table('usage_items')
                    ->select(
                        'kode_peminjaman',
                        'tgl_pinjam_usage_item',
                        'status_usage_item'
                    )
                    ->where('kode_peminjaman', $request->kode_peminjaman)
                    ->whereDate('tgl_pinjam_usage_item', now()->toDateString())
                    ->where('status_usage_item', 'terjadwal')
                    ->update([
                        'status_usage_item' => 'digunakan',
                        'updated_at' => now(),
                    ]);
            }
        } elseif ($roomDigunakan->count() > 0 or $itemDigunakan->count() > 0) {
            // Pengembalian harus melalui formulir pemeriksaan agar kerusakan dapat dicatat.
            return redirect()->route('admin.pengembalian.form', [
                'kode_peminjaman' => $request->kode_peminjaman,
            ]);
        } else {
            // jika tidak ada peminjaman hari ini berdasarkan kode peminjamannnya
            return redirect()->route('admin.pengajuan.peminjaman')->with('success', 'peminjaman mungkin tidak dijadwalkan hari ini.');
        }

        return redirect()->route('admin.pengajuan.peminjaman')->with('success', 'Status pengambilan berhasil diperbarui.');
    }

    /** Riwayat pemeriksaan pengembalian dan kerusakan yang pernah dicatat. */
    public function riwayatPengembalian()
    {
        abort_unless(Auth::check() && Auth::user()->hak_akses === 'admin', 403);

        $riwayat = DB::table('pemeriksaan_pengembalian as pp')
            ->leftJoin('items', 'pp.id_item', '=', 'items.id_item')
            ->leftJoin('rooms', 'pp.id_room', '=', 'rooms.id_room')
            ->leftJoin('users', 'pp.dicatat_oleh', '=', 'users.id_user')
            ->select('pp.*', 'items.nama_item', 'rooms.nama_room', 'users.username')
            ->orderByDesc('pp.tanggal_pemeriksaan')
            ->paginate(20);

        $user = DB::table('detail_staff')
            ->where('id_user', Auth::user()->id_user)
            ->value('nama');

        $halaman = 'contentRiwayatPemeriksaanPengembalian';

        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'riwayat'));
    }

    /** Form pemeriksaan kondisi aset saat pengembalian. */
    public function formPengembalian(string $kode_peminjaman)
    {
        abort_unless(Auth::check() && Auth::user()->hak_akses === 'admin', 403);
        $peminjaman = DB::table('peminjaman')
            ->join('peminjam', 'peminjaman.no_identitas', '=', 'peminjam.no_identitas')
            ->where('peminjaman.kode_peminjaman', $kode_peminjaman)
            ->select('peminjaman.*', 'peminjam.nama_peminjam')
            ->first();

        abort_unless($peminjaman, 404, 'Data peminjaman tidak ditemukan.');

        $barang = DB::table('usage_items')
            ->join('items', 'usage_items.id_item', '=', 'items.id_item')
            ->where('usage_items.kode_peminjaman', $kode_peminjaman)
            ->where('usage_items.status_usage_item', 'digunakan')
            ->whereDate('usage_items.tgl_pinjam_usage_item', now()->toDateString())
            ->select('usage_items.id_item', 'usage_items.qty_usage_item', 'items.nama_item', 'items.merek_model')
            ->get()
            ->groupBy('id_item')
            ->map(fn ($rows) => (object) [
                'id_item' => $rows->first()->id_item,
                'nama_item' => $rows->first()->nama_item,
                'merek_model' => $rows->first()->merek_model,
                'qty' => (int) $rows->sum('qty_usage_item'),
            ])->values();

        $ruangan = DB::table('usage_rooms')
            ->join('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
            ->where('usage_rooms.kode_peminjaman', $kode_peminjaman)
            ->where('usage_rooms.status_usage_room', 'digunakan')
            ->whereDate('usage_rooms.tgl_pinjam_usage_room', now()->toDateString())
            ->select('usage_rooms.id_room', 'rooms.nama_room')
            ->distinct()
            ->get();

        if ($barang->isEmpty() && $ruangan->isEmpty()) {
            return redirect()->route('admin.pengajuan.peminjaman')
                ->with('gagal', 'Tidak ada barang atau ruangan yang sedang digunakan hari ini untuk kode peminjaman tersebut.');
        }

        $user = DB::table('detail_staff')->where('id_user', Auth::user()->id_user)->value('nama');
        return view('Page_admin.pemeriksaan-pengembalian', compact('peminjaman', 'barang', 'ruangan', 'user'));
    }

    /** Simpan hasil pemeriksaan, tandai penggunaan selesai, dan tandai aset rusak bila diperlukan. */
    public function simpanPengembalian(Request $request, string $kode_peminjaman)
    {
        abort_unless(Auth::check() && Auth::user()->hak_akses === 'admin', 403);
        $request->validate([
            'barang' => ['nullable', 'array'],
            'barang.*.qty_dikembalikan' => ['required', 'integer', 'min:1'],
            'barang.*.qty_rusak' => ['required', 'integer', 'min:0'],
            'barang.*.deskripsi_kerusakan' => ['nullable', 'string', 'max:5000'],
            'barang.*.foto_kerusakan' => ['nullable', 'image', 'max:4096'],
            'ruangan' => ['nullable', 'array'],
            'ruangan.*.rusak' => ['nullable', 'in:0,1'],
            'ruangan.*.deskripsi_kerusakan' => ['nullable', 'string', 'max:5000'],
            'ruangan.*.foto_kerusakan' => ['nullable', 'image', 'max:4096'],
        ]);

        $userId = Auth::user()->id_user;
        $alreadyProcessed = DB::table('pemeriksaan_pengembalian')
            ->where('kode_peminjaman', $kode_peminjaman)
            ->whereDate('tanggal_pemeriksaan', now()->toDateString())
            ->exists();
        if ($alreadyProcessed) {
            return redirect()->route('admin.pengajuan.peminjaman')
                ->with('gagal', 'Pemeriksaan pengembalian untuk peminjaman ini sudah tercatat.');
        }

        DB::transaction(function () use ($request, $kode_peminjaman, $userId) {
            $now = now();

            foreach (($request->input('barang', [])) as $idItem => $data) {
                $usage = DB::table('usage_items')
                    ->where('kode_peminjaman', $kode_peminjaman)
                    ->where('id_item', $idItem)
                    ->where('status_usage_item', 'digunakan')
                    ->whereDate('tgl_pinjam_usage_item', $now->toDateString())
                    ->lockForUpdate()
                    ->get();
                if ($usage->isEmpty()) continue;

                $qtyDipinjam = (int) $usage->sum('qty_usage_item');
                $qtyKembali = (int) $data['qty_dikembalikan'];
                $qtyRusak = (int) $data['qty_rusak'];
                if ($qtyKembali !== $qtyDipinjam || $qtyRusak > $qtyKembali) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        "barang.$idItem.qty_dikembalikan" => "Jumlah pengembalian harus sama dengan jumlah yang dipinjam ($qtyDipinjam) dan jumlah rusak tidak boleh melebihinya.",
                    ]);
                }
                $deskripsi = trim((string) ($data['deskripsi_kerusakan'] ?? ''));
                if ($qtyRusak > 0 && $deskripsi === '') {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        "barang.$idItem.deskripsi_kerusakan" => 'Deskripsi kerusakan wajib diisi jika ada barang rusak.',
                    ]);
                }

                $foto = $request->file("barang.$idItem.foto_kerusakan");
                $fotoPath = $qtyRusak > 0 && $foto ? $foto->store('kerusakan-pengembalian', 'public') : null;

                $idPemeriksaan = DB::table('pemeriksaan_pengembalian')->insertGetId([
                    'kode_peminjaman' => $kode_peminjaman,
                    'jenis_aset' => 'barang',
                    'id_item' => $idItem,
                    'qty_dikembalikan' => $qtyKembali,
                    'qty_rusak' => $qtyRusak,
                    'kondisi_pengembalian' => $qtyRusak > 0 ? 'rusak' : 'baik',
                    'deskripsi_kerusakan' => $qtyRusak > 0 ? $deskripsi : null,
                    'foto_kerusakan' => $qtyRusak > 0 ? $fotoPath : null,
                    'dicatat_oleh' => $userId,
                    'tanggal_pemeriksaan' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ], 'id_pemeriksaan');

                if ($qtyRusak > 0) {
                    $itemMaster = DB::table('items')->where('id_item', $idItem)->lockForUpdate()->first();
                    if ($itemMaster) {
                        $sisaQty = max(0, (int) $itemMaster->qty_item - $qtyRusak);
                        DB::table('items')->where('id_item', $idItem)->update([
                            'qty_item' => $sisaQty,
                            'kondisi_item' => $sisaQty === 0 ? 'Rusak' : $itemMaster->kondisi_item,
                            'visibility_item' => $sisaQty === 0 ? '0' : $itemMaster->visibility_item,
                            'updated_at' => $now,
                        ]);
                    }
                    // Pengajuan perawatan dibuat nanti dari halaman riwayat oleh admin.
                }

                DB::table('usage_items')->where('kode_peminjaman', $kode_peminjaman)
                    ->where('id_item', $idItem)->where('status_usage_item', 'digunakan')
                    ->whereDate('tgl_pinjam_usage_item', $now->toDateString())
                    ->update(['status_usage_item' => 'selesai', 'updated_at' => $now]);
            }

            foreach (($request->input('ruangan', [])) as $idRoom => $data) {
                $usageExists = DB::table('usage_rooms')
                    ->where('kode_peminjaman', $kode_peminjaman)
                    ->where('id_room', $idRoom)
                    ->where('status_usage_room', 'digunakan')
                    ->whereDate('tgl_pinjam_usage_room', $now->toDateString())
                    ->lockForUpdate()->exists();
                if (!$usageExists) continue;

                $rusak = (string) ($data['rusak'] ?? '0') === '1';
                $deskripsi = trim((string) ($data['deskripsi_kerusakan'] ?? ''));
                if ($rusak && $deskripsi === '') {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        "ruangan.$idRoom.deskripsi_kerusakan" => 'Deskripsi kerusakan wajib diisi jika ruangan rusak.',
                    ]);
                }

                $foto = $request->file("ruangan.$idRoom.foto_kerusakan");
                $fotoPath = $rusak && $foto ? $foto->store('kerusakan-pengembalian', 'public') : null;

                $idPemeriksaan = DB::table('pemeriksaan_pengembalian')->insertGetId([
                    'kode_peminjaman' => $kode_peminjaman,
                    'jenis_aset' => 'ruangan',
                    'id_room' => $idRoom,
                    'qty_dikembalikan' => 1,
                    'qty_rusak' => $rusak ? 1 : 0,
                    'kondisi_pengembalian' => $rusak ? 'rusak' : 'baik',
                    'deskripsi_kerusakan' => $rusak ? $deskripsi : null,
                    'foto_kerusakan' => $rusak ? $fotoPath : null,
                    'dicatat_oleh' => $userId,
                    'tanggal_pemeriksaan' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ], 'id_pemeriksaan');

                if ($rusak) {
                    DB::table('rooms')->where('id_room', $idRoom)->update([
                        'kondisi_room' => 'Rusak', 'visibility_room' => '0', 'updated_at' => $now,
                    ]);
                    // Pengajuan perawatan dibuat nanti dari halaman riwayat oleh admin.
                }

                DB::table('usage_rooms')->where('kode_peminjaman', $kode_peminjaman)
                    ->where('id_room', $idRoom)->where('status_usage_room', 'digunakan')
                    ->whereDate('tgl_pinjam_usage_room', $now->toDateString())
                    ->update(['status_usage_room' => 'selesai', 'updated_at' => $now]);
            }

            $masihDigunakan = DB::table('usage_items')->where('kode_peminjaman', $kode_peminjaman)->whereIn('status_usage_item', ['terjadwal', 'digunakan'])->exists()
                || DB::table('usage_rooms')->where('kode_peminjaman', $kode_peminjaman)->whereIn('status_usage_room', ['terjadwal', 'digunakan'])->exists();
            if (!$masihDigunakan) {
                DB::table('peminjaman')->where('kode_peminjaman', $kode_peminjaman)
                    ->update(['status_peminjaman' => 'selesai', 'updated_at' => $now]);
            }
        });

        return redirect()->route('admin.pengajuan.peminjaman')
            ->with('success', 'Pengembalian berhasil dicatat. Kondisi barang dan ruangan telah diperbarui jika ditemukan kerusakan.');
    }

    /** Buat surat/pengajuan perawatan dari catatan kerusakan yang dipilih admin di riwayat. */
    public function ajukanPerawatanDariPengembalian(Request $request, int $id_pemeriksaan)
    {
        abort_unless(Auth::check() && Auth::user()->hak_akses === 'admin', 403);

        $pemeriksaan = DB::table('pemeriksaan_pengembalian')
            ->where('id_pemeriksaan', $id_pemeriksaan)
            ->first();

        abort_unless($pemeriksaan, 404, 'Catatan pengembalian tidak ditemukan.');

        if ((int) $pemeriksaan->qty_rusak < 1 || $pemeriksaan->kondisi_pengembalian !== 'rusak') {
            return back()->with('gagal', 'Hanya catatan aset yang rusak yang dapat diajukan perawatannya.');
        }

        $existing = DB::table('perawatan_barang')
            ->where('id_pemeriksaan', $id_pemeriksaan)
            ->first();

        if ($existing) {
            return back()->with('success', 'Pengajuan perawatan untuk catatan ini sudah dibuat.');
        }

        $now = now();
        $tahunAkademik = $now->year . '/' . ($now->year + 1);
        $aset = $pemeriksaan->jenis_aset === 'barang'
            ? DB::table('items')->where('id_item', $pemeriksaan->id_item)->first()
            : DB::table('rooms')->where('id_room', $pemeriksaan->id_room)->first();

        if (!$aset) {
            return back()->with('gagal', 'Data barang atau ruangan tidak ditemukan.');
        }

        DB::table('perawatan_barang')->insert([
            'id_perawatan' => 'RET-' . strtoupper(\\Illuminate\\Support\\Str::random(20)),
            'id_pemohon' => Auth::user()->id_user,
            'id_penyetuju' => null,
            'id_item' => $pemeriksaan->jenis_aset === 'barang' ? $pemeriksaan->id_item : null,
            'id_room' => $pemeriksaan->jenis_aset === 'ruangan' ? $pemeriksaan->id_room : null,
            'qty_perawatan' => (int) $pemeriksaan->qty_rusak,
            'sumber_perawatan' => 'pengembalian',
            'id_pemeriksaan' => $id_pemeriksaan,
            'status_perawatan' => 'pendding',
            'tahun_akademik' => $tahunAkademik,
            'keperluan_prodi' => 'Kerusakan dicatat saat pengembalian peminjaman ' . $pemeriksaan->kode_peminjaman . ': ' . ($pemeriksaan->deskripsi_kerusakan ?: 'Tidak ada deskripsi tambahan.'),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return back()->with('success', 'Pengajuan perawatan berhasil dibuat. Surat mengikuti format perawatan yang sudah digunakan.');
    }

    // penolakan pengajuan peminjaman
    // function penolakan(Request $request)
    // {
    //     $request->validate([
    //         'kode_peminjaman' => 'string',
    //     ]);

    //     // id admin yg approve
    //     $id_admin = Auth::user()->id_user;

    //     DB::table('peminjaman')->where('kode_peminjaman', $request->kode_peminjaman)
    //         ->update([
    //             'status_peminjaman' => 'terjadwal',
    //             'updated_at' => now(),
    //             'id_user' => $id_admin,
    //             'catatan_pengelola' => $request->catatan
    //         ]);

    //     UsageItems::where('kode_peminjaman', $request->kode_peminjaman)
    //         ->update([
    //             'status_usage_item' => 'terjadwal',
    //             'updated_at' => now(),
    //         ]);

    //     UsageRooms::where('kode_peminjaman', $request->kode_peminjaman)
    //         ->update([
    //             'status_usage_room' => 'terjadwal',
    //             'updated_at' => now(),
    //         ]);

    //     return redirect()->route('admin.pengajuan.peminjaman')->with('success', 'Status persetujuan berhasil diperbarui.');
    // }

    function pilihDataPengajuanPeminjamanAdmin(Request $request)
    {
        // dd($request->all());
        // Mengambil nilai dari tombol yang diklik
        $status = $request->input('status');
        $cari_pengajuan_peminjaman = $request->input('cari_pengajuan_peminjaman');

        // Menyimpan data ke session
        $request->session()->put('status-peminjaman', $status);
        $request->session()->put('cari_pengajuan_peminjaman', $cari_pengajuan_peminjaman);

        return back();
    }

    // view file pengajuan peminjaman
    function viewFilePengajuanPeminjaman(Request $request)
    {
        $kodePeminjaman = $request->input('kode_peminjaman');

        $peminjaman = DB::table('peminjaman')
            ->where('kode_peminjaman', $kodePeminjaman)
            ->first();

        // dd($peminjaman->lampiran_file);

        $path = $peminjaman->lampiran_file;

        // Cek apakah filenya beneran ada atau tidak
        if (!Storage::exists($path)) {
            return redirect()->back()->with('gagal', 'berkas tidak ditemukan!');
        }

        // Jalankan perintah download otomatis
        return Storage::download($path);
    }
}
