<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class pustakawancontroller extends Controller
{

    public function buku(Request $request)
    {

        #WAJIB
        $pages = 'buku';
        $jmldata = '0';
        $datas = '0';


        $datas = DB::table('buku')
            ->orderBy('nama', 'asc')
            ->paginate(Fungsi::paginationjml());

        // $bukurak = DB::table('bukurak')->get();
        $bukukategori = DB::table('kategori')->where('prefix', 'ddc')->get();

        return view('pustakawan.buku.index', compact(
            'pages'
            // ,'bukurak'
            ,
            'bukukategori',
            'datas',
            'request'
        ));
        // return view('admin.beranda');
    }


    public function bukucari(Request $request)
    {
        // dd($request);
        $cari = $request->cari;

        #WAJIB
        $pages = 'buku';
        $jmldata = '0';
        $datas = '0';


        $datas = DB::table('buku')
            // ->where('nis','like',"%".$cari."%")
            ->where('nama', 'like', "%" . $cari . "%")
            ->orWhere('kode', 'like', "%" . $cari . "%")
            ->paginate(Fungsi::paginationjml());



        // $bukurak = DB::table('bukurak')->get();
        $bukukategori = DB::table('kategori')->where('prefix', 'ddc')->get();

        return view('pustakawan.buku.index', compact(
            'pages'
            // ,'bukurak'
            ,
            'bukukategori',
            'datas',
            'request'
        ));
    }

    public function bukudetail(Request $request, buku $id)
    {

        #WAJIB
        $pages = 'bukudetail';
        $jmldata = '0';
        $datas = '0';
        $buku = $id;


        $datas = DB::table('bukudetail')->where('buku_kode', $id->kode)
            // ->orderBy('isbn','asc')
            ->paginate(Fungsi::paginationjml());

        // $bukurak = DB::table('bukurak')->get();
        $bukukategori = DB::table('kategori')->where('prefix', 'ddc')->get();

        return view('pustakawan.buku.bukudetail', compact(
            'pages'
            // ,'bukurak'
            ,
            'bukukategori',
            'datas',
            'buku',
            'request'
        ));
        // return view('admin.beranda');
    }

    public function bukudetailcari(Request $request, buku $id)
    {

        $buku = $id;
        // dd($request);
        $cari = $request->cari;

        #WAJIB
        $pages = 'bukudetail';
        $jmldata = '0';
        $datas = '0';


        $datas = DB::table('bukudetail')
            // ->where('nis','like',"%".$cari."%")
            ->where('kondisi', 'like', "%" . $cari . "%")
            ->where('buku_kode', $id->kode)
            ->orWhere('status', 'like', "%" . $cari . "%")
            ->where('buku_kode', $id->kode)
            ->paginate(Fungsi::paginationjml());



        // $bukurak = DB::table('bukurak')->get();= DB::table('bukurak')->get();
        $bukukategori = DB::table('kategori')->where('prefix', 'ddc')->get();

        return view('pustakawan.buku.bukudetail', compact(
            'pages'
            // ,'bukurak'
            ,
            'bukukategori',
            'datas',
            'buku',
            'request'
        ));
    }
}
