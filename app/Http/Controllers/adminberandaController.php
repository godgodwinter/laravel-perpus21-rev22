<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\settings;
use App\Models\tapel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class adminberandaController extends Controller
{
    public function index()
    {


        // $count=DB::table('peminjamandetail')->whereMonth('tgl_pinjam','08')->whereYear('tgl_pinjam','2021')
        // ->count();
        // dd($count);

        $pages='beranda';

        $labelawal = Carbon::now()->startOfMonth()->subMonth(6);
        $month = date("Y-m",strtotime($labelawal));
        $label=[];
        array_push($label,Fungsi::tanggalindobln($month));
        // $label='"'.Fungsi::tanggalindobln($month).'"';
        $bln = date("m",strtotime($labelawal));
        $year = date("Y",strtotime($labelawal));

        $count=DB::table('peminjamandetail')->whereMonth('tgl_pinjam',$bln)->whereYear('tgl_pinjam',$year)
        ->count();
        $data=$count;

        for($i=0;$i<6;$i++){
            $labelawal = $labelawal->startOfMonth()->addMonth(1);
            $month = date("Y-m",strtotime($labelawal));
            // $label.=',"'.Fungsi::tanggalindobln($month).'"';
        array_push($label,Fungsi::tanggalindobln($month));



            $bln = date("m",strtotime($labelawal));
            $year = date("Y",strtotime($labelawal));
            $count=DB::table('peminjamandetail')->whereMonth('tgl_pinjam',$bln)->whereYear('tgl_pinjam',$year)
                     ->count();
                     $data.=','.$count;
        }

        $datasminus = Carbon::now()->startOfMonth()->subMonth(3);
        $datasadd = Carbon::now()->startOfMonth()->addMonth(3);
        $month = date("m",strtotime($datasminus));
// dd($label);


// data pengunjung
$datatanpauniq=DB::table('pengunjung')->whereMonth('tgl',$bln)->whereYear('tgl',$year)->orderBy('tgl','desc')->get();
$datas=$datatanpauniq->unique('nama');
$jml=$datatanpauniq->unique('nama')->count();


$labelawal = Carbon::now()->startOfMonth()->subMonth(6);
$month = date("Y-m",strtotime($labelawal));
$labelpengunjung=[];
array_push($labelpengunjung,Fungsi::tanggalindobln($month));
// $label='"'.Fungsi::tanggalindobln($month).'"';
$bln = date("m",strtotime($labelawal));
$year = date("Y",strtotime($labelawal));

$datatanpauniq=DB::table('pengunjung')->whereMonth('tgl',$bln)->whereYear('tgl',$year)->orderBy('tgl','desc')->get();
$datas=$datatanpauniq->unique('nama');
// $jml=DB::table('pengunjung')->whereMonth('tgl',$bln)->whereYear('tgl',$year)->orderBy('tgl','desc')->count();
$count=$datatanpauniq->unique('nama')->count();
$datapengunjung=$count;

for($i=0;$i<6;$i++){
    $labelawal = $labelawal->startOfMonth()->addMonth(1);
    $month = date("Y-m",strtotime($labelawal));
    // $label.=',"'.Fungsi::tanggalindobln($month).'"';
array_push($labelpengunjung,Fungsi::tanggalindobln($month));



    $bln = date("m",strtotime($labelawal));
    $year = date("Y",strtotime($labelawal));
    $datatanpauniq=DB::table('pengunjung')->whereMonth('tgl',$bln)->whereYear('tgl',$year)->orderBy('tgl','desc')->get();
    $datas=$datatanpauniq->unique('nama');
    // $jml=DB::table('pengunjung')->whereMonth('tgl',$bln)->whereYear('tgl',$year)->orderBy('tgl','desc')->count();
    $count=$datatanpauniq->unique('nama')->count();
    // $data=$count;
             $datapengunjung.=','.$count;
}

$datasminus = Carbon::now()->startOfMonth()->subMonth(3);
$datasadd = Carbon::now()->startOfMonth()->addMonth(3);
$month = date("m",strtotime($datasminus));
// dd($label,$data,$labelpengunjung,$datapengunjung);
        return view('admin.pages.beranda',compact('pages'
            ,'label','data'
            ,'labelpengunjung','datapengunjung'
        ));
        }

    public function notfound()
    {

        return view('404');
    }
}
