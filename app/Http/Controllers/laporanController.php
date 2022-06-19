<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\kelas;
use App\Models\pengunjung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class laporanController extends Controller
{
    public function index()
    {
        #WAJIB
        $pages = 'laporan';
        $jmldata = '0';
        $datas = '0';


        $datas = DB::table('kelas')
            ->paginate($this->paginationjml());

        $jmldata = DB::table('kelas')->count();

        return view('admin.laporan.index', compact('pages', 'jmldata', 'datas'));
    }

    public function pengunjung(Request $request)
    {
        if ($this->checkauth('admin') === '404' && $this->checkauth('pustakawan') === '404') {
            return redirect(URL::to('/') . '/404')->with('status', 'Halaman tidak ditemukan!')->with('tipe', 'danger')->with('icon', 'fas fa-trash');
        }
        // dd($id);

        #WAJIB
        $pages = 'pengunjung';
        $jmldata = '0';
        $datas = '0';
        $bln = date('m');
        $year = date('Y');

        $datatanpauniq = DB::table('pengunjung')->whereMonth('tgl', $bln)->whereYear('tgl', $year)->orderBy('tgl', 'desc')->get();
        $datas = $datatanpauniq->unique('nama');
        // $jml=DB::table('pengunjung')->whereMonth('tgl',$bln)->whereYear('tgl',$year)->orderBy('tgl','desc')->count();
        $jml = $datatanpauniq->unique('nama')->count();
        // $datas=DB::table('pengunjung')->whereMonth('tgl',$bln)->whereYear('tgl',$year)->orderBy('tgl','desc')->get();
        // $jml=DB::table('pengunjung')->whereMonth('tgl',$bln)->whereYear('tgl',$year)->orderBy('tgl','desc')->count();
        // ->orderBy('isbn','asc')
        // ->paginate(Fungsi::paginationjml());

        // $bukurak = DB::table('bukurak')->get();
        // $bukukategori = DB::table('kategori')->where('prefix','ddc')->get();


        $labelawal = Carbon::now()->startOfMonth()->subMonth(6);
        $month = date("Y-m", strtotime($labelawal));
        $label = [];
        array_push($label, Fungsi::tanggalindobln($month));
        // $label='"'.Fungsi::tanggalindobln($month).'"';
        $bln = date("m", strtotime($labelawal));
        $year = date("Y", strtotime($labelawal));

        $datatanpauniq = DB::table('pengunjung')->whereMonth('tgl', $bln)->whereYear('tgl', $year)->orderBy('tgl', 'desc')->get();
        $datas = $datatanpauniq->unique('nama');
        // $jml=DB::table('pengunjung')->whereMonth('tgl',$bln)->whereYear('tgl',$year)->orderBy('tgl','desc')->count();
        $count = $datatanpauniq->unique('nama')->count();
        $data = $count;

        for ($i = 0; $i < 6; $i++) {
            $labelawal = $labelawal->startOfMonth()->addMonth(1);
            $month = date("Y-m", strtotime($labelawal));
            // $label.=',"'.Fungsi::tanggalindobln($month).'"';
            array_push($label, Fungsi::tanggalindobln($month));



            $bln = date("m", strtotime($labelawal));
            $year = date("Y", strtotime($labelawal));
            $datatanpauniq = DB::table('pengunjung')->whereMonth('tgl', $bln)->whereYear('tgl', $year)->orderBy('tgl', 'desc')->get();
            $datas = $datatanpauniq->unique('nama');
            // $jml=DB::table('pengunjung')->whereMonth('tgl',$bln)->whereYear('tgl',$year)->orderBy('tgl','desc')->count();
            $count = $datatanpauniq->unique('nama')->count();
            // $data=$count;
            $data .= ',' . $count;
        }

        $datasminus = Carbon::now()->startOfMonth()->subMonth(3);
        $datasadd = Carbon::now()->startOfMonth()->addMonth(3);
        $month = date("m", strtotime($datasminus));

        return view('admin.laporan.pengunjung', compact('pages', 'datas', 'request', 'jml', 'label', 'data'));
        // return view('admin.beranda');
    }

    public function laporanpeminjaman(Request $request)
    {
        if ($this->checkauth('admin') === '404') {
            return redirect(URL::to('/') . '/404')->with('status', 'Halaman tidak ditemukan!')->with('tipe', 'danger')->with('icon', 'fas fa-trash');
        }
        // dd($id);

        #WAJIB
        $pages = 'pengunjung';
        $jmldata = '0';
        $datas = '0';

        $datas = DB::table('peminjamandetail')->orderBy('tgl_pinjam', 'desc')->get();
        $jml = DB::table('peminjamandetail')->orderBy('tgl_pinjam', 'desc')->count();
        // ->orderBy('isbn','asc')
        // ->paginate(Fungsi::paginationjml());

        // $bukurak = DB::table('bukurak')->get();
        // $bukukategori = DB::table('kategori')->where('prefix','ddc')->get();

        return view('admin.laporan.peminjaman', compact('pages', 'datas', 'request', 'jml'));
        // return view('admin.beranda');
    }



    public function cetakpeminjaman($bln, $status, $cari)
    {
        // dd($bln,$status,$cari);
        // dd($bln);
        $tgl = date("YmdHis");
        // dd($tgl);
        $bulan = date("m", strtotime($bln));
        $year = date("Y", strtotime($bln));
        $blnthn = $bln;


        $pdf = PDF::loadview('admin.laporan.cetakpeminjaman', compact('bulan', 'year', 'blnthn', 'status', 'cari'))->setPaper('a4', 'potrait');

        // \QrCode::size(500)
        //     ->format('png')
        //     ->generate('www.google.com', public_path('assets/img/qrcode.png'));

        return $pdf->stream('laporanpeminjamandanpengembalian' . $tgl . '-pdf');
    }

    public function laporankeuangan(Request $request)
    {
        if ($this->checkauth('admin') === '404') {
            return redirect(URL::to('/') . '/404')->with('status', 'Halaman tidak ditemukan!')->with('tipe', 'danger')->with('icon', 'fas fa-trash');
        }
        // dd($id);

        #WAJIB
        $pages = 'keuangan';
        $jmldata = '0';
        $datas = '0';
        $bln = date('Y-m');
        $month = date("m", strtotime($bln));
        $year = date("Y", strtotime($bln));

        $datas = DB::table('pengeluaran')->whereMonth('tglbayar', $month)->whereYear('tglbayar', $year)->orderBy('tglbayar', 'desc')->get();
        $jml = DB::table('pengeluaran')->whereMonth('tglbayar', $month)->whereYear('tglbayar', $year)->orderBy('tglbayar', 'desc')->count();
        $totalnominal = DB::table('pengeluaran')->whereMonth('tglbayar', $month)->whereYear('tglbayar', $year)->orderBy('tglbayar', 'desc')->sum('nominal');

        $datas2 = DB::table('pemasukan')->whereMonth('tglbayar', $month)->whereYear('tglbayar', $year)->orderBy('tglbayar', 'desc')->get();
        $jml2 = DB::table('pemasukan')->whereMonth('tglbayar', $month)->whereYear('tglbayar', $year)->orderBy('tglbayar', 'desc')->count();
        $totalnominal2 = DB::table('pemasukan')->whereMonth('tglbayar', $month)->whereYear('tglbayar', $year)->orderBy('tglbayar', 'desc')->sum('nominal');

        $datasdenda = DB::table('pengembaliandetail')->whereMonth('tgl_dikembalikan', $month)->whereYear('tgl_dikembalikan', $year)->orderBy('tgl_dikembalikan', 'desc')->get();
        $jmldenda = DB::table('pengembaliandetail')->whereMonth('tgl_dikembalikan', $month)->whereYear('tgl_dikembalikan', $year)->orderBy('tgl_dikembalikan', 'desc')->count();
        $totalnominaldenda = DB::table('pengembaliandetail')->whereMonth('tgl_dikembalikan', $month)->whereYear('tgl_dikembalikan', $year)->orderBy('tgl_dikembalikan', 'desc')->sum('totaldenda');
        // ->orderBy('isbn','asc')
        // ->paginate(Fungsi::paginationjml());

        // $bukurak = DB::table('bukurak')->get();
        // $bukukategori = DB::table('kategori')->where('prefix','ddc')->get();

        return view('admin.laporan.keuangan', compact('pages', 'datas', 'datas2', 'request', 'jml', 'jml2', 'totalnominal', 'totalnominal2', 'datasdenda', 'jmldenda', 'totalnominaldenda'));
        // return view('admin.beranda');
    }


    public function laporankeuangan_baru(Request $request)
    {
        if ($this->checkauth('admin') === '404') {
            return redirect(URL::to('/') . '/404')->with('status', 'Halaman tidak ditemukan!')->with('tipe', 'danger')->with('icon', 'fas fa-trash');
        }
        // dd($id);

        #WAJIB
        $pages = 'keuangan';
        $jmldata = '0';
        $datas = '0';
        $blnawal = $request->blnawal ? $request->blnawal : date('Y') . "-01";
        $monthAwal = date("m", strtotime($blnawal));
        $yearAwall = date("Y", strtotime($blnawal));
        $bln = $request->bln ? $request->bln : date('Y-m');
        $month = date("m", strtotime($bln));
        $year = date("Y", strtotime($bln));

        $datas = DB::table('pengeluaran')
            ->whereMonth('tglbayar', ">=", $monthAwal)
            ->whereYear('tglbayar', ">=", $yearAwall)
            ->whereMonth('tglbayar', "<=", $month)
            ->whereYear('tglbayar', "<=", $year)
            ->orderBy('tglbayar', 'desc')->get();

        $jml = DB::table('pengeluaran')
            ->whereMonth('tglbayar', ">=", $monthAwal)
            ->whereYear('tglbayar', ">=", $yearAwall)
            ->whereMonth('tglbayar', "<=", $month)
            ->whereYear('tglbayar', "<=", $year)
            ->orderBy('tglbayar', 'desc')->count();

        $totalnominal = DB::table('pengeluaran')
            ->whereMonth('tglbayar', ">=", $monthAwal)
            ->whereYear('tglbayar', ">=", $yearAwall)
            ->whereMonth('tglbayar', "<=", $month)
            ->whereYear('tglbayar', "<=", $year)
            ->orderBy('tglbayar', 'desc')
            ->sum('nominal');

        $datas2 = DB::table('pemasukan')
            ->whereMonth('tglbayar', ">=", $monthAwal)
            ->whereYear('tglbayar', ">=", $yearAwall)
            ->whereMonth('tglbayar', "<=", $month)
            ->whereYear('tglbayar', "<=", $year)
            ->orderBy('tglbayar', 'desc')->get();

        $jml2 = DB::table('pemasukan')
            ->whereMonth('tglbayar', ">=", $monthAwal)
            ->whereYear('tglbayar', ">=", $yearAwall)
            ->whereMonth('tglbayar', "<=", $month)
            ->whereYear('tglbayar', "<=", $year)
            ->orderBy('tglbayar', 'desc')->count();

        $totalnominal2 = DB::table('pemasukan')
            ->whereMonth('tglbayar', ">=", $monthAwal)
            ->whereYear('tglbayar', ">=", $yearAwall)
            ->whereMonth('tglbayar', "<=", $month)
            ->whereYear('tglbayar', "<=", $year)
            ->orderBy('tglbayar', 'desc')->sum('nominal');

        $datasdenda = DB::table('pengembaliandetail')
            ->whereMonth('tgl_dikembalikan', ">=", $monthAwal)
            ->whereYear('tgl_dikembalikan', ">=", $yearAwall)
            ->whereMonth('tgl_dikembalikan', "<=", $month)
            ->whereYear('tgl_dikembalikan', "<=", $year)
            ->orderBy('tgl_dikembalikan', 'desc')->get();

        $jmldenda = DB::table('pengembaliandetail')
            ->whereMonth('tgl_dikembalikan', ">=", $monthAwal)
            ->whereYear('tgl_dikembalikan', ">=", $yearAwall)
            ->whereMonth('tgl_dikembalikan', "<=", $month)
            ->whereYear('tgl_dikembalikan', "<=", $year)
            ->orderBy('tgl_dikembalikan', 'desc')->count();

        $totalnominaldenda = DB::table('pengembaliandetail')
            ->whereMonth('tgl_dikembalikan', ">=", $monthAwal)
            ->whereYear('tgl_dikembalikan', ">=", $yearAwall)
            ->whereMonth('tgl_dikembalikan', "<=", $month)
            ->whereYear('tgl_dikembalikan', "<=", $year)
            ->orderBy('tgl_dikembalikan', 'desc')->sum('totaldenda');
        // ->orderBy('isbn','asc')
        // ->paginate(Fungsi::paginationjml());

        // $bukurak = DB::table('bukurak')->get();
        // $bukukategori = DB::table('kategori')->where('prefix','ddc')->get();

        return view('admin.laporan.keuangan_baru', compact('pages', 'datas', 'datas2', 'request', 'jml', 'jml2', 'totalnominal', 'totalnominal2', 'datasdenda', 'jmldenda', 'totalnominaldenda', 'blnawal', 'bln'));
        // return view('admin.beranda');
    }
    public function laporankeuangan_baruall(Request $request)
    {
        if ($this->checkauth('admin') === '404') {
            return redirect(URL::to('/') . '/404')->with('status', 'Halaman tidak ditemukan!')->with('tipe', 'danger')->with('icon', 'fas fa-trash');
        }
        // dd($id);

        #WAJIB
        $pages = 'keuangan';
        $jmldata = '0';
        $datas = '0';
        $blnawal = $request->blnawal ? $request->blnawal : date('Y') . "-01";
        $monthAwal = date("m", strtotime($blnawal));
        $yearAwall = date("Y", strtotime($blnawal));
        $bln = $request->bln ? $request->bln : date('Y-m');
        $month = date("m", strtotime($bln));
        $year = date("Y", strtotime($bln));

        $datas = DB::table('pengeluaran')
            // ->whereMonth('tglbayar', ">=", $monthAwal)
            // ->whereYear('tglbayar', ">=", $yearAwall)
            // ->whereMonth('tglbayar', "<=", $month)
            // ->whereYear('tglbayar', "<=", $year)
            ->orderBy('tglbayar', 'desc')->get();

        $jml = DB::table('pengeluaran')
            // ->whereMonth('tglbayar', ">=", $monthAwal)
            // ->whereYear('tglbayar', ">=", $yearAwall)
            // ->whereMonth('tglbayar', "<=", $month)
            // ->whereYear('tglbayar', "<=", $year)
            ->orderBy('tglbayar', 'desc')->count();

        $totalnominal = DB::table('pengeluaran')
            // ->whereMonth('tglbayar', ">=", $monthAwal)
            // ->whereYear('tglbayar', ">=", $yearAwall)
            // ->whereMonth('tglbayar', "<=", $month)
            // ->whereYear('tglbayar', "<=", $year)
            ->orderBy('tglbayar', 'desc')
            ->sum('nominal');

        $datas2 = DB::table('pemasukan')
            // ->whereMonth('tglbayar', ">=", $monthAwal)
            // ->whereYear('tglbayar', ">=", $yearAwall)
            // ->whereMonth('tglbayar', "<=", $month)
            // ->whereYear('tglbayar', "<=", $year)
            ->orderBy('tglbayar', 'desc')->get();

        $jml2 = DB::table('pemasukan')
            // ->whereMonth('tglbayar', ">=", $monthAwal)
            // ->whereYear('tglbayar', ">=", $yearAwall)
            // ->whereMonth('tglbayar', "<=", $month)
            // ->whereYear('tglbayar', "<=", $year)
            ->orderBy('tglbayar', 'desc')->count();

        $totalnominal2 = DB::table('pemasukan')
            // ->whereMonth('tglbayar', ">=", $monthAwal)
            // ->whereYear('tglbayar', ">=", $yearAwall)
            // ->whereMonth('tglbayar', "<=", $month)
            // ->whereYear('tglbayar', "<=", $year)
            ->orderBy('tglbayar', 'desc')->sum('nominal');

        $datasdenda = DB::table('pengembaliandetail')
            // ->whereMonth('tgl_dikembalikan', ">=", $monthAwal)
            // ->whereYear('tgl_dikembalikan', ">=", $yearAwall)
            // ->whereMonth('tgl_dikembalikan', "<=", $month)
            // ->whereYear('tgl_dikembalikan', "<=", $year)
            ->orderBy('tgl_dikembalikan', 'desc')->get();

        $jmldenda = DB::table('pengembaliandetail')
            // ->whereMonth('tgl_dikembalikan', ">=", $monthAwal)
            // ->whereYear('tgl_dikembalikan', ">=", $yearAwall)
            // ->whereMonth('tgl_dikembalikan', "<=", $month)
            // ->whereYear('tgl_dikembalikan', "<=", $year)
            ->orderBy('tgl_dikembalikan', 'desc')->count();

        $totalnominaldenda = DB::table('pengembaliandetail')
            // ->whereMonth('tgl_dikembalikan', ">=", $monthAwal)
            // ->whereYear('tgl_dikembalikan', ">=", $yearAwall)
            // ->whereMonth('tgl_dikembalikan', "<=", $month)
            // ->whereYear('tgl_dikembalikan', "<=", $year)
            ->orderBy('tgl_dikembalikan', 'desc')->sum('totaldenda');
        // ->orderBy('isbn','asc')
        // ->paginate(Fungsi::paginationjml());

        // $bukurak = DB::table('bukurak')->get();
        // $bukukategori = DB::table('kategori')->where('prefix','ddc')->get();

        return view('admin.laporan.keuangan_baruall', compact('pages', 'datas', 'datas2', 'request', 'jml', 'jml2', 'totalnominal', 'totalnominal2', 'datasdenda', 'jmldenda', 'totalnominaldenda', 'blnawal', 'bln'));
        // return view('admin.beranda');
    }
    public function cetakkeuangan($bln)
    {

        // dd($bln);
        $tgl = date("YmdHis");
        // dd($tgl);
        $bulan = date("m", strtotime($bln));
        $year = date("Y", strtotime($bln));
        $blnthn = $bln;

        // $datas=DB::table('peralatan')->orderBy('created_at','desc')->get();
        // dd($datas,$jml);

        $pdf = PDF::loadview('admin.laporan.cetakkeuangan', compact('bulan', 'year', 'blnthn'))->setPaper('a4', 'potrait');

        // \QrCode::size(500)
        //     ->format('png')
        //     ->generate('www.google.com', public_path('assets/img/qrcode.png'));

        return $pdf->stream('laporankeuangan' . $tgl . '-pdf');
    }

    public function apichart1(Request $request)
    {
        // labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        // data: [12, 19, 3, 5, 2, 3],


        $labelawal = Carbon::now()->startOfMonth()->subMonth(6);
        $bln = date("m", strtotime($labelawal));
        $year = date("Y", strtotime($labelawal));
        $month = date("Y-m", strtotime($labelawal));
        $label = '"' . Fungsi::tanggalindobln($month) . '"';

        $count = DB::table('peminjamandetail')->whereMonth('tgl_pinjam', $bln)->whereYear('tgl_pinjam', $year)
            ->count();
        $data = $count;

        for ($i = 0; $i < 6; $i++) {
            $labelawal = $labelawal->startOfMonth()->addMonth($i + 1);
            $month = date("Y-m", strtotime($labelawal));
            $label .= ',"' . Fungsi::tanggalindobln($month) . '"';



            $bln = date("m", strtotime($labelawal));
            $year = date("Y", strtotime($labelawal));
            $count = DB::table('peminjamandetail')->whereMonth('tgl_pinjam', $bln)->whereYear('tgl_pinjam', $year)
                ->count();
            $data .= ',' . $count;
        }

        $datasminus = Carbon::now()->startOfMonth()->subMonth(3);
        $datasadd = Carbon::now()->startOfMonth()->addMonth(3);
        $month = date("m", strtotime($datasminus));
        return response()->json([
            'success' => true,
            'datasminus' => $datasminus,
            'datasadd' => $datasadd,
            'aa' => $month,
            'label' => $label,
            'data' => $data,
        ], 200);
    }

    public function apipeminjaman(Request $request)
    {

        $output = '';
        $cari = $request->cari;
        $month = date("m", strtotime($request->bln));
        $year = date("Y", strtotime($request->bln));
        // $month = $request->bln;
        // dd($month);
        if ($request->status == 'sudah') {
            $jml = DB::table('peminjamandetail')
                ->where('buku_nama', 'like', "%" . $cari . "%")->where('statuspengembalian', $request->status)->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orWhere('buku_pengarang', 'like', "%" . $cari . "%")->where('statuspengembalian', $request->status)->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orWhere('buku_penerbit', 'like', "%" . $cari . "%")->where('statuspengembalian', $request->status)->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->count();


            $datas = DB::table('peminjamandetail')
                ->where('buku_nama', 'like', "%" . $cari . "%")->where('statuspengembalian', $request->status)->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orWhere('buku_pengarang', 'like', "%" . $cari . "%")->where('statuspengembalian', $request->status)->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orWhere('buku_penerbit', 'like', "%" . $cari . "%")->where('statuspengembalian', $request->status)->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)->orderBy('tgl_pinjam', 'desc')
                ->get();

            $first = DB::table('peminjamandetail')
                ->where('buku_nama', 'like', "%" . $cari . "%")->where('statuspengembalian', $request->status)->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orWhere('buku_pengarang', 'like', "%" . $cari . "%")->where('statuspengembalian', $request->status)->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orWhere('buku_penerbit', 'like', "%" . $cari . "%")->where('statuspengembalian', $request->status)->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->first();
        } elseif ($request->status == 'belum') {
            $jml = DB::table('peminjamandetail')
                ->where('buku_nama', 'like', "%" . $cari . "%")->where('statuspengembalian', null)->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orWhere('buku_pengarang', 'like', "%" . $cari . "%")->where('statuspengembalian', null)->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orWhere('buku_penerbit', 'like', "%" . $cari . "%")->where('statuspengembalian', null)->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->count();


            $datas = DB::table('peminjamandetail')
                ->where('buku_nama', 'like', "%" . $cari . "%")->where('statuspengembalian', null)->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orWhere('buku_pengarang', 'like', "%" . $cari . "%")->where('statuspengembalian', null)->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orWhere('buku_penerbit', 'like', "%" . $cari . "%")->where('statuspengembalian', null)->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orderBy('tgl_pinjam', 'desc')->get();

            $first = DB::table('peminjamandetail')
                ->where('buku_nama', 'like', "%" . $cari . "%")->where('statuspengembalian', null)->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orWhere('buku_pengarang', 'like', "%" . $cari . "%")->where('statuspengembalian', null)->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orWhere('buku_penerbit', 'like', "%" . $cari . "%")->where('statuspengembalian', null)->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->first();
        } else {
            $jml = DB::table('peminjamandetail')
                ->where('buku_nama', 'like', "%" . $cari . "%")->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orWhere('buku_pengarang', 'like', "%" . $cari . "%")->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orWhere('buku_penerbit', 'like', "%" . $cari . "%")->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->count();


            $datas = DB::table('peminjamandetail')
                ->where('buku_nama', 'like', "%" . $cari . "%")->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orWhere('buku_pengarang', 'like', "%" . $cari . "%")->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orWhere('buku_penerbit', 'like', "%" . $cari . "%")->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)->orderBy('tgl_pinjam', 'desc')
                ->get();

            $first = DB::table('peminjamandetail')
                ->where('buku_nama', 'like', "%" . $cari . "%")->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orWhere('buku_pengarang', 'like', "%" . $cari . "%")->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->orWhere('buku_penerbit', 'like', "%" . $cari . "%")->whereMonth('tgl_pinjam', $month)->whereYear('tgl_pinjam', $year)->skip(0)->take(10)
                ->first();
        }

        if ($jml > 0) {

            $no = 0;
            foreach ($datas as $data) {

                if ($data->statuspengembalian == 'sudah') {
                    $warna = 'success';
                    $status = 'Sudah dikembalikan';
                } else {
                    $warna = 'warning';
                    $status = 'Belum dikembalikan';
                }
                $ambilpeminjam = DB::table('peminjaman')->where('kodetrans', $data->kodetrans)->first();

                $no++;
                $output .= '
                <tr>
                      <td>
                         ' . ($no) . '
                      </td>
                      <td>
                          <a>
                             ' . $data->buku_nama . '
                          </a>

                      </td>
                      <td>
                      Pengarang : ' . $data->buku_pengarang . '
                      <small>
                      Penerbit : ' . $data->buku_penerbit . '
                      </small>
                      </td>
                      <td class="project_progress">

                        ' . Fungsi::tanggalindo($data->tgl_pinjam) . '</td>
                        <td class="project_progress">

                          ' . $data->nomeridentitas . ' - ' . $ambilpeminjam->nama . '</td>
                      <td class="project-state">

                          <span class="badge badge-' . $warna . '">' . $status . '</span>
                      </td>

                  </tr>

                ';
            }
        } else {
            $output = '
            <tr>
             <td align="center" colspan="5">No Data Found</td>
            </tr>
            ';
        }
        // echo json_encode($datas);

        return response()->json([
            'success' => true,
            'message' => $jml,
            'show' => $output,
            // 'status' => $data->status,
            'datas' => $datas,
            'first' => $first
        ], 200);

        dd($datas);
    }
    public function apikeuangan(Request $request)
    {


        $output = '';
        $outputpemasukan = '';
        $outputpengeluaran = '';
        $outputdenda = '';
        $cari = $request->cari;
        $month = date("m", strtotime($request->bln));
        $year = date("Y", strtotime($request->bln));

        $jmlpemasukan = DB::table('pemasukan')->whereMonth('tglbayar', $month)->whereYear('tglbayar', $year)->skip(0)->take(10)
            ->count();


        $dataspemasukan = DB::table('pemasukan')->whereMonth('tglbayar', $month)->whereYear('tglbayar', $year)->skip(0)->take(10)
            ->get();

        $sumpemasukan = DB::table('pemasukan')->whereMonth('tglbayar', $month)->whereYear('tglbayar', $year)->skip(0)->take(10)
            ->sum('nominal');

        $firstpemasukan = DB::table('pemasukan')->whereMonth('tglbayar', $month)->whereYear('tglbayar', $year)->skip(0)->take(10)
            ->first();

        $jmlpengeluaran = DB::table('pengeluaran')->whereMonth('tglbayar', $month)->whereYear('tglbayar', $year)->skip(0)->take(10)
            ->count();


        $dataspengeluaran = DB::table('pengeluaran')->whereMonth('tglbayar', $month)->whereYear('tglbayar', $year)->skip(0)->take(10)
            ->get();
        $sumpengeluaran = DB::table('pengeluaran')->whereMonth('tglbayar', $month)->whereYear('tglbayar', $year)->skip(0)->take(10)
            ->sum('nominal');

        $firstpengeluaran = DB::table('pengeluaran')->whereMonth('tglbayar', $month)->whereYear('tglbayar', $year)->skip(0)->take(10)
            ->first();


        $jmldenda = DB::table('pengembaliandetail')->whereMonth('tgl_dikembalikan', $month)->whereYear('tgl_dikembalikan', $year)->skip(0)->take(10)
            ->count();
        $totalnominaldenda = DB::table('pengembaliandetail')->whereMonth('tgl_dikembalikan', $month)->whereYear('tgl_dikembalikan', $year)->orderBy('tgl_dikembalikan', 'desc')->sum('totaldenda');

        // totalnominaldenda


        $datasdenda = DB::table('pengembaliandetail')->whereMonth('tgl_dikembalikan', $month)->whereYear('tgl_dikembalikan', $year)->skip(0)->take(10)
            ->get();

        $sumdenda = DB::table('pengembaliandetail')->whereMonth('tgl_dikembalikan', $month)->whereYear('tgl_dikembalikan', $year)->skip(0)->take(10)
            ->sum('totaldenda');

        $firstdenda = DB::table('pengembaliandetail')->whereMonth('tgl_dikembalikan', $month)->whereYear('tgl_dikembalikan', $year)->skip(0)->take(10)
            ->first();

        $sumsaldo = ($sumpemasukan + $sumdenda) - $sumpengeluaran;
        $sumsaldo = ($sumpemasukan - $sumpengeluaran);
        $outputsaldo = '';
        if ($jmlpemasukan > 0) {

            $no = 0;
            $outputpemasukan .= '
                    <tr  class="thead-dark">
                        <th colspan="2">
                        Data  Pemasukan
                        </th>

                        <th style="width: 18%" class="text-center">
                            ' . $jmlpemasukan . ' Transaksi
                        </th>
                        <th style="width: 18%" class="text-center">
                        <small>   Total Nominal :</small><br>
                            <strong>' . Fungsi::rupiah($sumpemasukan) . '</strong>
                        </th>

                    </tr>
                    ';
            foreach ($dataspemasukan as $data) {

                $no++;
                $outputpemasukan .= '

                <tr>
                <td>
                    ' . $no . '
                </td>
                <td >
                       ' . $data->nama . '

                </td>
                <td class="text-center">
                ' . Fungsi::tanggalindo($data->tglbayar) . '
                </td>

                <td class="project-state">
                    ' . Fungsi::rupiah($data->nominal) . '
                </td>

            </tr>

                ';
            }
        } else {
            $outputpemasukan = '
            <tr>
             <td align="center" colspan="5">No Data Found</td>
            </tr>
            ';
        }



        if ($jmlpengeluaran > 0) {

            $no = 0;
            $outputpengeluaran .= '
                    <tr  class="thead-dark">
                        <th colspan="2">
                        Data  Pengeluaran
                        </th>

                        <th style="width: 18%" class="text-center">
                            ' . $jmlpengeluaran . ' Transaksi
                        </th>
                        <th style="width: 18%" class="text-center">
                        <small>   Total Nominal :</small><br>
                            <strong>' . Fungsi::rupiah($sumpengeluaran) . '</strong>
                        </th>

                    </tr>
                    ';
            foreach ($dataspengeluaran as $data) {

                $no++;
                $outputpengeluaran .= '

                <tr>
                <td>
                    ' . $no . '
                </td>
                <td >
                       ' . $data->nama . '

                </td>
                <td class="text-center">
                ' . Fungsi::tanggalindo($data->tglbayar) . '
                </td>

                <td class="project-state">
                    ' . Fungsi::rupiah($data->nominal) . '
                </td>

            </tr>

                ';
            }
        } else {
            $outputpengeluaran = '
            <tr>
             <td align="center" colspan="5">No Data Found</td>
            </tr>
            ';
        }


        // dd($jmldenda);
        if ($totalnominaldenda > 0) {

            $no = 0;
            $outputdenda .= '
                    <tr  class="thead-dark">
                        <th colspan="2">
                        Data  Denda
                        </th>

                        <th style="width: 18%" class="text-center">
                            ' . $jmldenda . ' Transaksi
                        </th>
                        <th style="width: 18%" class="text-center">
                        <small>   Total Nominal :</small><br>
                            <strong>' . Fungsi::rupiah($totalnominaldenda) . '</strong>
                        </th>

                    </tr>
                    ';
            foreach ($datasdenda as $data) {

                $no++;
                $outputdenda .= '

                <tr>
                <td>
                    ' . $no . '
                </td>
                <td >
                       ' . $data->buku_nama . '

                </td>
                <td class="text-center">
                ' . Fungsi::tanggalindo($data->tgl_dikembalikan) . '
                </td>

                <td class="project-state">
                    ' . Fungsi::rupiah($data->totaldenda) . '
                </td>

            </tr>

                ';
            }
        } else {
            $outputdenda = '
            <tr>
             <td align="center" colspan="5">No Data Found</td>
            </tr>
            ';
        }

        $outputsaldo .= '

         <tr>
         <td colspan="4"> </td>
       </tr>
       <tr>
           <th colspan="2">
             Data  Pemasukan
           </th>

           <th style="width: 18%" class="text-center">
               ' . $jmlpemasukan . ' Transaksi
           </th>
           <th style="width: 18%" class="text-center">
            <small>   Total Nominal :</small><br>
               <strong>' . Fungsi::rupiah($sumpemasukan) . '</strong>
           </th>

       </tr>

       <tr>
           <th colspan="2">
             Data  Pengeluaran
           </th>

           <th style="width: 18%" class="text-center">
           ' . $jmlpengeluaran . ' Transaksi
           </th>
           <th style="width: 18%" class="text-center">
            <small>   Total Nominal :</small><br>
               <strong>' . Fungsi::rupiah($sumpengeluaran) . '</strong>
           </th>

       </tr>
       <tr>
           <th colspan="3">
            Total Saldo = Total Pemasukan - Total Pengeluaran
           </th>

           <th style="width: 18%" class="text-center">
            <small>   Total Saldo :</small><br>
               <strong>' . Fungsi::rupiah($sumsaldo) . '</strong>
           </th>

       </tr>
       ';

        return response()->json([
            'success' => true,
            'jmlpemasukan' => $jmlpemasukan,
            'dataspemasukan' => $dataspemasukan,
            'firstpemasukan' => $firstpemasukan,
            'outputpemasukan' => $outputpemasukan,

            'jmlpengeluaran' => $jmlpengeluaran,
            'dataspengeluaran' => $dataspengeluaran,
            'firstpengeluaran' => $firstpengeluaran,
            'outputpengeluaran' => $outputpengeluaran,

            'jmldenda' => $jmldenda,
            // 'datasdenda' => $datasdenda,
            'firstdenda' => $firstdenda,
            'outputdenda' => $outputdenda,
            'outputsaldo' => $outputsaldo,
        ], 200);

        // dd($datas);

    }
    public function pengunjungapi(Request $request)
    {

        $output = '';
        $cari = $request->cari;
        $month = date("m", strtotime($request->bln));
        $year = date("Y", strtotime($request->bln));
        // $month = $request->bln;
        // dd($month);


        // $datatanpauniq=DB::table('pengunjung')->whereMonth('tgl',$bln)->whereYear('tgl',$year)->orderBy('tgl','desc')->get();
        // $datas=$datatanpauniq->unique('nama');
        // $jml=DB::table('pengunjung')->whereMonth('tgl',$bln)->whereYear('tgl',$year)->orderBy('tgl','desc')->count();

        // $jml=DB::table('pengunjung')
        // ->where('nama','like',"%".$cari."%")->whereMonth('tgl',$month)->whereYear('tgl',$year)->skip(0)->take(10)
        // ->orWhere('nomeridentitas','like',"%".$cari."%")->whereMonth('tgl',$month)->whereYear('tgl',$year)->skip(0)->take(10)
        // ->orWhere('tipe','like',"%".$cari."%")->whereMonth('tgl',$month)->whereYear('tgl',$year)->skip(0)->take(10)
        // ->count();


        $datatanpauniq = DB::table('pengunjung')
            ->where('nama', 'like', "%" . $cari . "%")->whereMonth('tgl', $month)->whereYear('tgl', $year)->skip(0)->take(10)
            ->orWhere('nomeridentitas', 'like', "%" . $cari . "%")->whereMonth('tgl', $month)->whereYear('tgl', $year)->skip(0)->take(10)
            ->orWhere('tipe', 'like', "%" . $cari . "%")->whereMonth('tgl', $month)->whereYear('tgl', $year)->skip(0)->take(10)
            ->get();
        $datas = $datatanpauniq->unique('nama');

        $jml = $datatanpauniq->unique('nama')->count();
        // $first=DB::table('pengunjung')
        // ->where('nama','like',"%".$cari."%")->whereMonth('tgl',$month)->whereYear('tgl',$year)->skip(0)->take(10)
        // ->orWhere('nomeridentitas','like',"%".$cari."%")->whereMonth('tgl',$month)->whereYear('tgl',$year)->skip(0)->take(10)
        // ->orWhere('tipe','like',"%".$cari."%")->whereMonth('tgl',$month)->whereYear('tgl',$year)->skip(0)->take(10)
        // ->first();

        if ($jml > 0) {

            $no = 0;
            foreach ($datas as $data) {
                $no++;
                $output .= '
                <tr>
                      <td>
                         ' . ($no) . '
                      </td>
                      <td>
                          <a>
                             ' . $data->nama . '
                          </a>

                      </td>
                      <td>
                      ' . $data->nomeridentitas . '
                      </td>
                      <td class="project_progress">

                        ' . Fungsi::tanggalindo($data->tgl) . '</td>
                      <td class="project-state">

                          <span class="badge badge-success">' . $data->tipe . '</span>
                      </td>

                  </tr>

                ';
            }
        } else {
            $output = '
            <tr>
             <td align="center" colspan="5">No Data Found</td>
            </tr>
            ';
        }
        // echo json_encode($datas);

        return response()->json([
            'success' => true,
            'message' => $jml,
            'show' => $output,
            // 'status' => $data->status,
            'datas' => $datas,
            // 'first' => $first
        ], 200);

        dd($datas);
    }

    public function cetak()
    {
        $tgl = date("YmdHis");
        // dd($tgl);
        $databos = DB::table('pemasukan')->where('kategori_nama', 'Dana Bos')->get();
        $datapemasukan = DB::table('pemasukan')->whereNotIn('kategori_nama', ['Dana Bos'])->get();
        $datapengeluaran = DB::table('pengeluaran')->get();
        // dd($datapengeluaran);

        $pdf = PDF::loadview('admin.laporan.cetak', compact('databos', 'datapemasukan', 'datapengeluaran'))->setPaper('a4', 'potrait');

        // \QrCode::size(500)
        //     ->format('png')
        //     ->generate('www.google.com', public_path('assets/img/qrcode.png'));

        return $pdf->stream('laporansekolah_' . $tgl . '-pdf');
    }


    public function pengunjungcetak(Request $request)
    {

        // dd($request->bln);
        $tgl = date("YmdHis");
        // dd($tgl);
        $bln = date("m", strtotime($request->bln));
        $year = date("Y", strtotime($request->bln));
        $blnthn = $request->bln;

        $datatanpauniq = DB::table('pengunjung')->whereMonth('tgl', $bln)->whereYear('tgl', $year)->orderBy('tgl', 'desc')->get();
        $datas = $datatanpauniq->unique('nama');
        // $jml=DB::table('pengunjung')->whereMonth('tgl',$bln)->whereYear('tgl',$year)->orderBy('tgl','desc')->count();
        $jml = $datatanpauniq->unique('nama')->count();
        // dd($datas,$jml);

        $pdf = PDF::loadview('admin.laporan.pengunjungcetak', compact('datas', 'jml', 'blnthn'))->setPaper('a4', 'potrait');

        // \QrCode::size(500)
        //     ->format('png')
        //     ->generate('www.google.com', public_path('assets/img/qrcode.png'));

        return $pdf->stream('laporanpengunjung' . $tgl . '-pdf');
    }
    public function qr()
    {

        // \QrCode::size(500)
        //     ->format('png')
        //     ->generate('www.google.com', public_path('assets/img/qrcode.png'));

        return view('admin.testing.qr');
    }
}
