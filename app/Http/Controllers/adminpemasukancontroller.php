<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class adminpemasukancontroller extends Controller
{
    public function index(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }

        #WAJIB
        $pages='pemasukan';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('pemasukan')
        ->orderBy('created_at','desc')
        ->paginate(Fungsi::paginationjml());

        // $anggotakategori = DB::table('kategori')->where('prefix','ddc')->get();

        return view('admin.pemasukan.index',compact('pages','datas','request'));
        // return view('admin.beranda');
    }
    
    public function cari(Request $request)
    {
        // dd($request);
        $cari=$request->cari;

        #WAJIB
        $pages='pemasukan';
        $jmldata='0';
        $datas='0';


    $datas=DB::table('pemasukan')
    // ->where('nis','like',"%".$cari."%")
    ->where('nama','like',"%".$cari."%")
    ->orWhere('kategori_nama','like',"%".$cari."%")
    // ->orWhere('tglbayar','like',"%".$cari."%")
    // ->orWhere('tipe','like',"%".$cari."%")
    ->paginate(Fungsi::paginationjml());



    // $bukurak = DB::table('bukurak')->get();
    // $bukukategori = DB::table('kategori')->where('prefix','ddc')->get();

    return view('admin.pemasukan.index',compact('pages','datas','request'));
    }
    public function store(Request $request)
    {
        // dd($request);
        // dd($request);
        $request->validate([
            'nama'=>'required|unique:pemasukan,nama',
            'kategori_nama'=>'required',
            'tglbayar'=>'required',
            'nominal'=>'required',


        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);
        
       DB::table('pemasukan')->insert(
        array(
               'nama'     =>   $request->nama,
               'kategori_nama'     =>   $request->kategori_nama,
               'tglbayar'     =>   $request->tglbayar,
               'catatan'     =>   $request->catatan,
               'nominal'     =>   $request->nominal,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));

        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success');
    
    }
    public function show(Request $request,pemasukan $id)
    {
        // dd($id);
        #WAJIB
        $pages='pemasukan';
        $datas=$id;
        

        return view('admin.pemasukan.edit',compact('pages','datas','request'));
    }
    public function proses_update($request,$datas)
    {
        $request->validate([
            'nama'=>'required',
            'kategori_nama'=>'required',
            'tglbayar'=>'required',
            'nominal'=>'required',


        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);
    

       
        pemasukan::where('id',$datas->id)
        ->update([
            'nama'     =>   $request->nama,
            'kategori_nama'     =>   $request->kategori_nama,
            'tglbayar'     =>   $request->tglbayar,
            'catatan'     =>   $request->catatan,
            'nominal'     =>   $request->nominal,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);

        
    }

    public function update(Request $request, pemasukan $id)
    {
        $this->proses_update($request,$id);

            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }
    
    public function destroy($id)
    {
        pemasukan::destroy($id);
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
        pemasukan::whereIn('id',$ids)->delete();

        
        // load ulang
     
        #WAJIB
        $pages='pemasukan';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('pemasukan')
        ->orderBy('created_at','desc')
        ->paginate(Fungsi::paginationjml());

        // $anggotakategori = DB::table('kategori')->where('prefix','ddc')->get();

        return view('admin.pemasukan.index',compact('pages','datas','request'));

    }
}
