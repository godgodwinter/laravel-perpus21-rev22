<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class cetakController extends Controller
{
    public function peminjamanshow($id)
    {
        $tgl = date("YmdHis");
        // dd($tgl);
        $datas = DB::table('peminjaman')->where('kodetrans', $id)->first();
        // dd($datas);
        $datapinjamdetail = DB::table('peminjamandetail')->where('kodetrans', $id)->orderBy('created_at', 'desc')->get();

        $detaildatas = $datapinjamdetail->unique('buku_kode');
        // dd($detaildatas);
        $pdf = PDF::loadview('admin.cetak.peminjamanshow', compact('datas', 'detaildatas'))->setPaper('a4', 'potrait');
        return $pdf->stream('laporansekolah_' . $tgl . '-pdf');
    }

    public function pengembalianshow($id)
    {
        $tgl = date("YmdHis");
        // dd($tgl);
        $datas = DB::table('pengembalian')->where('kodetrans', $id)->first();
        // dd($datas);
        $datapinjamdetail = DB::table('pengembaliandetail')->where('kodetrans', $id)->orderBy('created_at', 'desc')->get();

        $detaildatas = $datapinjamdetail->unique('buku_kode');
        // dd($detaildatas);
        $pdf = PDF::loadview('admin.cetak.pengembalianshow', compact('datas', 'detaildatas'))->setPaper('a4', 'potrait');
        return $pdf->stream('laporansekolah_' . $tgl . '-pdf');
    }
}
