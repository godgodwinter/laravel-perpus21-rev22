<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\Fungsi;
use App\Models\bukurak;
use Illuminate\Support\Facades\URL;

class adminbukurakcontroller extends Controller
{
    public function index(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }

        #WAJIB
        $pages='bukurak';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('bukurak')
        ->paginate(Fungsi::paginationjml());

        $jmldata = DB::table('bukurak')->count();

        return view('admin.bukurak.index',compact('pages','jmldata','datas','request'));
        // return view('admin.beranda');
    }

    
    public function cari(Request $request)
    {
        // dd($request);
        $cari=$request->cari;
        $kategori_nama=$request->kategori_nama;

        #WAJIB
        $pages='bukurak';
        $jmldata='0';
        $datas='0';


    $datas=DB::table('bukurak')
    // ->where('nis','like',"%".$cari."%")
    ->where('nama','like',"%".$cari."%")
    ->orWhere('kode','like',"%".$cari."%")
    ->paginate(Fungsi::paginationjml());



        return view('admin.bukurak.index',compact('pages','jmldata','datas','request'));
    }
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'nama'=>'required|unique:bukurak,nama',
            'kode'=>'required|unique:bukurak,kode'

        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);

       DB::table('bukurak')->insert(
        array(
               'nama'     =>   $request->nama,
               'kode'     =>   $request->kode,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));

        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success')->with('icon','fas fa-feather');
    
    }
    public function show(Request $request,bukurak $id)
    {
        // dd($id);
        #WAJIB
        $pages='bukurak';
        $datas=$id;

        return view('admin.bukurak.edit',compact('pages','datas','request'));
    }
    
    public function proses_update($request,$datas)
    {
        if($request->nama!==$datas->nama){
            $request->validate([
                'nama'=>'unique:bukurak,nama'
            ],
            [
                // 'nama.unique'=>'Nama harus diisi'


            ]);
        }
        
        if($request->kode!==$datas->kode){
            $request->validate([
                'kode'=>'unique:bukurak,kode'
            ],
            [
                // 'nama.unique'=>'Nama harus diisi'


            ]);
        }

       
       
        

        bukurak::where('id',$datas->id)
        ->update([
            'nama'     =>   $request->nama,
            'kode'     =>   $request->kode,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);

        
    }

    public function update(Request $request, bukurak $id)
    {
        $this->proses_update($request,$id);

            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }
    
    public function destroy($id)
    {
        bukurak::destroy($id);
        return redirect()->back()->with('status','Data berhasil dihapus!')->with('tipe','info')->with('icon','fas fa-trash');
    
    }

    public function multidel(Request $request)
    {
        
        $ids=$request->ids;

        // $datasiswa = DB::table('siswa')->where('id',$ids)->get();
        // foreach($datasiswa as $ds){
        //     $nis=$ds->nis;
        // }

        // dd($request);

        // DB::table('tagihansiswa')->where('siswa_nis', $ids)->where('tapel_nama',$this->tapelaktif())->delete();
        bukurak::whereIn('id',$ids)->delete();

        
        // load ulang
     
        #WAJIB
        $pages='bukurak';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('bukurak')
        ->paginate(Fungsi::paginationjml());

        $jmldata = DB::table('bukurak')->count();

        return view('admin.bukurak.index',compact('pages','jmldata','datas','request'));

    }
}
