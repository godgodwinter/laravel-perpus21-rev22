<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\buku;
use App\Models\bukudetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class adminbukudetailcontroller extends Controller
{
    public function index(Request $request, buku $id)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }
        // dd($id);

        #WAJIB
        $pages='bukudetail';
        $jmldata='0';
        $datas='0';
        $buku=$id;


        $datas=DB::table('bukudetail')->where('buku_kode',$id->kode)
        // ->orderBy('isbn','asc')
        ->paginate(Fungsi::paginationjml());

        // $bukurak = DB::table('bukurak')->get();
        $bukukategori = DB::table('kategori')->where('prefix','ddc')->get();

        return view('admin.buku.bukudetail',compact('pages'
        // ,'bukurak'
        ,'bukukategori','datas','buku','request'));
        // return view('admin.beranda');
    }

    public function cari(Request $request,buku $id)
    {

        $buku=$id;
        // dd($request);
        $cari=$request->cari;

        #WAJIB
        $pages='bukudetail';
        $jmldata='0';
        $datas='0';


    $datas=DB::table('bukudetail')
    // ->where('nis','like',"%".$cari."%")
    ->where('kondisi','like',"%".$cari."%")
    ->where('buku_kode',$id->kode)
    ->orWhere('status','like',"%".$cari."%")
    ->where('buku_kode',$id->kode)
    ->paginate(Fungsi::paginationjml());



    // $bukurak = DB::table('bukurak')->get();= DB::table('bukurak')->get();
        $bukukategori = DB::table('kategori')->where('prefix','ddc')->get();

        return view('admin.buku.bukudetail',compact('pages'
        // ,'bukurak'
        ,'bukukategori','datas','buku','request'));
    }
    public function store(Request $request,buku $id)
    {
        // dd($request);
        // dd($request);
        $request->validate([
            'jumlah'=>'required|numeric|min:1',
            // 'bukurak_nama'=>'required',
            // 'bukukategori_nama'=>'required',


        ],
        [
            // 'nama.required'=>'Nama Harus diisi',

        ]);
        for($i=0;$i<$request->jumlah;$i++){
             // dd($kodebuku);
        DB::table('bukudetail')->insert(
            array(
                   'kondisi'     =>   $request->kondisi,
                   'status'     =>   'ada', //ada ,  dipinjam , hilang
                //    'kodepanggil'     =>   $id->kode.'-'.date('YmdHis'),
                   'buku_nama'     =>   $id->nama,
                   'buku_kode'     =>   $id->kode,
                //    'bukurak_nama'     =>   $id->bukurak_nama,
                //    'bukurak_kode'     =>   $id->bukurak_kode,
                   'bukukategori_nama'     =>   $id->bukukategori_nama,
                   'bukukategori_ddc'     =>   $id->bukukategori_ddc,
                   'created_at'=>date("Y-m-d H:i:s"),
                   'updated_at'=>date("Y-m-d H:i:s")
            ));


        }


            // $notification = array(
            //     'message' => 'Post created successfully!',
            //     'alert-type' => 'success'
            // );
            return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success');

     }

    public function show(Request $request,buku $buku,bukudetail $id)
    {
        // dd($id);
        #WAJIB
        $pages='bukudetail';
        $buku=$buku;
        $datas=$id;

        // $bukurak = DB::table('bukurak')->get();
        $bukukategori = DB::table('kategori')->where('prefix','ddc')->get();

        return view('admin.buku.bukudetail_edit',compact('pages','datas'
        // ,'bukurak'
        ,'buku','bukukategori','request'));
    }
    public function proses_update($request,$buku,$datas)
    {



        // dd($request->bukukategori_nama,$datas->bukukategori_nama,$kodebuku);

        bukudetail::where('id',$datas->id)
        ->update([
            'kondisi'     =>   $request->kondisi,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);


    }

    public function update(Request $request, buku $buku,bukudetail $id)
    {
        $this->proses_update($request,$buku,$id);

            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }
    public function destroy($buku,$id)
    {
        bukudetail::destroy($id);
        return redirect()->back()->with('status','Data berhasil dihapus!')->with('tipe','info')->with('icon','fas fa-trash');

    }

    public function multidel(Request $request,buku $id)
    {

        $ids=$request->ids;

        // $datasiswa = DB::table('siswa')->where('id',$ids)->get();
        // foreach($datasiswa as $ds){
        //     $nis=$ds->nis;
        // }

        // dd($request);

        // DB::table('tagihansiswa')->where('siswa_nis', $ids)->where('tapel_nama',$this->tapelaktif())->delete();
        bukudetail::whereIn('id',$ids)->delete();


        // load ulang


        #WAJIB
        $pages='bukudetail';
        $jmldata='0';
        $datas='0';
        $buku=$id;


        $datas=DB::table('bukudetail')->where('buku_kode',$id->kode)
        // ->orderBy('isbn','asc')
        ->paginate(Fungsi::paginationjml());

        // $bukurak = DB::table('bukurak')->get();
        $bukukategori = DB::table('kategori')->where('prefix','ddc')->get();

        return view('admin.buku.bukudetail',compact('pages'
        // ,'bukurak'
        ,'bukukategori','datas','buku','request'));

    }
}
