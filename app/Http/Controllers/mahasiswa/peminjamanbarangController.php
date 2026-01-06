<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\DataBarang;
use App\Models\UsageItems;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\Traits\ToStringFormat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Scalar\Int_;

use function Symfony\Component\Clock\now;

class peminjamanbarangController extends Controller
{
    // ke halaman detail pengajuan peminjaman
    public function DetailPeminjamanBarang($id)
    {   
        // mengambil tgl chosed dari session 
        $tgl_chosed = session()->get('tgl_chosed');
        // membuat var tgl table jadwal penggunaan barang
        $tglForTblUsageBrng = null;

        // jika tgl chosed null maka tgl = tgl sekarang
        if ($tgl_chosed === null) {
            $tglForTblUsageBrng = now()->format('Y-m-d');
        }else{
            $tglForTblUsageBrng = $tgl_chosed;
        }

        // mengambil detail barang berdasarkan id_item
        $detailBarang = DataBarang::where('id_item', $id)
            ->join('tipe_item' , 'items.id_tipe_item', '=', 'tipe_item.id_tipe_item')
            ->select('items.*', 'tipe_item.nama_tipe_item')
            ->get();

        // mengambil data penggunaan barang berdasarkan id_item dan tgl input sekarang
        $dataUsageItems = UsageItems::where('id_item', $id)
            ->leftjoin('agenda_fakultas', 'agenda_fakultas.kode_agenda', '=', 'usage_items.kode_agenda')
            ->leftjoin('peminjaman', 'peminjaman.kode_peminjaman', '=', 'usage_items.kode_peminjaman')
            ->select(
                'usage_items.tgl_pinjam_usage_item',
                'usage_items.tgl_kembali_usage_item',
                'usage_items.status_usage_item',
                'usage_items.qty_usage_item',
                'agenda_fakultas.nama_agenda',
                'peminjaman.ket_peminjaman',
            )
            ->wheredate('tgl_pinjam_usage_item', '=', $tglForTblUsageBrng)
            ->where('status_usage_item', '!=', 'selesai')
            ->where('status_usage_item', '!=', 'ditolak')
            ->where('status_usage_item', '!=', 'diajukan')
            ->orderBy('tgl_pinjam_usage_item', 'asc')
            ->get();
        
        $id_item = $id;
        // dd($dataUsageItems);
        $user = Auth::guard('peminjam')->user()->nama_peminjam;
        $halaman = 'contentDetailPeminjamanBarang';
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user', 'detailBarang', 'dataUsageItems', 'id_item', 'tglForTblUsageBrng'));
    }

    // menyimpan data barang ke cart
    public function BarangAddCart(Request $request)
    {
        // mengambil id_item dan tgl chosed
        $request->validate([
            'id_item' => 'required',
            'qty_pinjam' => 'required',
        ]);

        // mengambil nama barang berdasarkan id yg diinput
        $dataBarangDb = DataBarang::where('id_item', $request->id_item)
            ->join('tipe_item', 'items.id_tipe_item', '=', 'tipe_item.id_tipe_item')
            ->select('items.nama_item', 'items.qty_item', 'items.img_item', 'tipe_item.nama_tipe_item')
            ->get();

        // cek apakah session cart_barang sudah ada isinya atau tidak
        if (session()->get('cart') === null) {
            // cek apakah qty pinjam > qty item 
            foreach ($dataBarangDb as $value) {
                if ($request->qty_pinjam > $value->qty_item) {
                    return back()->with('gagal', 'barang yang anda input melebihi stok tersedia!');
                }
            }

            // menyimpan data input peminjaman barang ke list peminjaman 
            session()->put('cart', [
                [
                    'id_item' => $request->id_item,
                    'nama_item' => $dataBarangDb[0]->nama_item,
                    'nama_tipe_item' => $dataBarangDb[0]->nama_tipe_item,
                    'qty_pinjam' => $request->qty_pinjam,
                    'qty_item' => $dataBarangDb[0]->qty_item,
                    'img_item' => $dataBarangDb[0]->img_item,
                ]
            ]);
        } else {
            // menyimpan data input peminjaman barang ke list peminjaman
            // jika di session cart_barang sudah ada data, data baru akan ditambahkan setelahnya
            $cartBarang = session()->get('cart', []);

            // jika data dengan id yg diinput sudah ada maka gagal
            foreach ($cartBarang as $value) {
                if ($value['id_item'] === $request->id_item) {
                    return back()->with('gagal', 'barang sudah ada di cart peminjaman!');
                }
            }

            // cek apakah qty pinjam > qty item 
            foreach ($dataBarangDb as $value) {
                if ($request->qty_pinjam > $value->qty_item) {
                    return back()->with('gagal', 'barang yang anda input melebihi stok tersedia!');
                }
            }

            $cartBarangbaru =
                [
                    'id_item' => $request->id_item,
                    'nama_item' => $dataBarangDb[0]->nama_item,
                    'nama_tipe_item' => $dataBarangDb[0]->nama_tipe_item,
                    'qty_pinjam' => $request->qty_pinjam,
                    'qty_item' => $dataBarangDb[0]->qty_item,
                    'img_item' => $dataBarangDb[0]->img_item,
                ];

            session()->push('cart', $cartBarangbaru);
        }

        // kembali ke halaman detail peminjaman barang
        return back()->with('success', 'barang berhasil ditambahkan ke cart peminjaman!');
    }

    // hapus barang dari cart
    public function hapusitemcart(Request $request)
    {
        $idItemHapus = $request->input('id_item');
        // 1. Ambil array dari sesi dan konversi ke Collection
        $cartBarang = new Collection(session()->get('cart', []));

        // 2. Tentukan ID item yang ingin dihapus
        // $idItemHapus = 'PRO01IL';

        // 3. Hapus elemen di mana nilai itemnya sama dengan $idItemHapus
        $cartBarang = $cartBarang->reject(function ($item) use ($idItemHapus) {
            // PERBAIKAN: Akses kunci 'id_item' di dalam array $item
            return $item['id_item'] === $idItemHapus;
        })->values(); // Penting: ->values() mereset kunci (keys) menjadi 0, 1, 2...

        // 4. Simpan kembali Collection yang telah diperbarui ke sesi
        session()->put('cart', $cartBarang->toArray());

        return back()->with('gagal', 'barang berhasil dihapus dari cart peminjaman!');
    }

    // fungsi untuk jika user ingin mencari tgl yg dia inginkan 
    public function gantiTgl(Request $request)
    {
        // menyimpan tgl chosed di session
        session()->put('tgl_chosed', $request->input('ganti_tgl'));
        
        $id = $request->input('id');
        // dd($ketersediaan);

        return redirect()->route('mhs-detail-peminjaman-barang', $id);
    }

    // fungsi untuk cek ketersediaan barang /// tidak terpakai
    public function cekKetersediaanItem($idItem, $startDate, $endDate, $qtyRequest)
    {
        // 1. Ambil stok asli barang
        $item = DataBarang::where('id_item', $idItem)->first();

        if (!$item) {
            return [
                'status' => false,
                'msg' => 'Item tidak ditemukan'
            ];
        }

        // 2. Cari semua pinjaman yang overlap dengan request user
        $totalDipakaiDiWaktuItu = UsageItems::where('id_item', $idItem)
            ->where('status_usage_item', '!=', 'diajukan')
            ->where('status_usage_item', '!=', 'selesai')
            ->where(function ($q) use ($startDate, $endDate) {
                $q->where('tgl_pinjam_usage_item', '<', $endDate)
                    ->where('tgl_kembali_usage_item', '>', $startDate);
            })
            ->sum('qty_usage_item');

        // 3. Hitung stok tersisa pada waktu tersebut
        $stokTersisa = $item->qty_item - $totalDipakaiDiWaktuItu;

        // 4. cek apakah data tgl yg di imput < tgl sekarang + 1jam 
        $now = Carbon::now();
        if ($startDate < $now->copy()->addHour(1)) {
            return [
                'status' => 'kadaluarsa',
                'stok_tersisa' => $stokTersisa,
                'msg' => 'masa waktu peminjaman telah kadaluarsa!'
            ];
        }

        // 5. Apakah jumlah yang diminta tersedia?
        if ($stokTersisa >= $qtyRequest) {
            return [
                'status' => true,
                'stok_tersisa' => $stokTersisa,
                'msg' => 'Item tersedia pada waktu tersebut'
            ];
        } else {
            return [
                'status' => false,
                'stok_tersisa' => $stokTersisa,
                'msg' => 'Item pada jam pengajuan anda sedang digunakan agenda lain!'
            ];
        }
    }
}
