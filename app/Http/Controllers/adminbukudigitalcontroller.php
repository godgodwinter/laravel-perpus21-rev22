<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\bukudigital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminbukudigitalcontroller extends Controller
{
    public function index(Request $request)
    {
        // if($this->checkauth('admin')==='404'){
        //     return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        // }

        #WAJIB
        $pages='bukudigital';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('bukudigital')
        ->orderBy('nama','asc')
        ->paginate(Fungsi::paginationjml());

        // $bukudigitalkategori = DB::table('kategori')->where('prefix','tipebukudigital')->get();
        // $kondisi = DB::table('kategori')->where('prefix','kondisi')->get();

        return view('admin.bukudigital.index',compact('pages','datas','request'));
        // return view('admin.beranda');
    }
    public function cari(Request $request)
    {
        // dd($request);
        $cari=$request->cari;

        #WAJIB
        $pages='bukudigital';
        $jmldata='0';
        $datas='0';


    $datas=DB::table('bukudigital')
    // ->where('nis','like',"%".$cari."%")
    ->where('nama','like',"%".$cari."%")
    ->orWhere('tipe','like',"%".$cari."%")
    ->paginate(Fungsi::paginationjml());




    return view('admin.bukudigital.index',compact('pages','datas','request'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required',
            'tipe'=>'required',
            'file' => 'max:2000|mimes:pdf,png,jpeg,xml', //1MB
        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);

        // $validator = Validator::make($request->all(), [
        //     'file' => 'max:5120', //5MB
        // ]);

        $files = $request->file('file');

        // dd($request);
        $namafileku=null;
        if($files!=null){
            // dd(!Input::hasFile('files'));
            // dd($files,'aaa');
            $namafilebaru=date('YmdHis');

            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('file');
                      // nama file
            echo 'File Name: '.$file->getClientOriginalName();
            echo '<br>';

                      // ekstensi file
            echo 'File Extension: '.$file->getClientOriginalExtension();
            // dd()
            echo '<br>';

                      // real path
            echo 'File Real Path: '.$file->getRealPath();
            echo '<br>';

                      // ukuran file
            echo 'File Size: '.$file->getSize();
            echo '<br>';

                      // tipe mime
            echo 'File Mime Type: '.$file->getMimeType();

                      // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'bukudigital/';

                    // upload file
            $file->move($tujuan_upload,"bukudigital/".$namafilebaru.'.'.$file->getClientOriginalExtension());
                $namafileku="bukudigital/".$namafilebaru.'.'.$file->getClientOriginalExtension();
            }

        DB::table('bukudigital')->insert(
            array(
                   'nama'     =>   $request->nama,
                   'tipe'     =>   $request->tipe,
                   'ket'     =>   $request->ket,
                   'link'     =>   $request->link,
                //    'gambar'     =>   $request->gambar,
                    'file' => $namafileku,
                   'created_at'=>date("Y-m-d H:i:s"),
                   'updated_at'=>date("Y-m-d H:i:s")
            ));
            return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success');

     }

    public function show(Request $request,bukudigital $id)
    {
        // dd($id);
        #WAJIB
        $pages='bukudigital';
        $datas=$id;


        return view('admin.bukudigital.edit',compact('pages','datas','request'));
    }
    public function proses_update($request,$datas)
    {
        $request->validate([
            'nama'=>'required',
        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);

// dd($request);
        $namafileku=null;
        $files = $request->file('file');
        if($files!=null){

        $request->validate([
            'file' => 'max:2000|mimes:pdf,png,jpeg,xml', //1MB
        ],
        [
            // 'nama.required'=>'Nama Harus diisi',

        ]);
            // dd(!Input::hasFile('files'));
            // dd($files,'aaa');
            $namafilebaru=date('YmdHis');

            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('file');
                      // nama file
            echo 'File Name: '.$file->getClientOriginalName();
            echo '<br>';

                      // ekstensi file
            echo 'File Extension: '.$file->getClientOriginalExtension();
            // dd()
            echo '<br>';

                      // real path
            echo 'File Real Path: '.$file->getRealPath();
            echo '<br>';

                      // ukuran file
            echo 'File Size: '.$file->getSize();
            echo '<br>';

                      // tipe mime
            echo 'File Mime Type: '.$file->getMimeType();

                      // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'bukudigital/';

                    // upload file
            $file->move($tujuan_upload,"bukudigital/".$namafilebaru.'.'.$file->getClientOriginalExtension());
                $namafileku="bukudigital/".$namafilebaru.'.'.$file->getClientOriginalExtension();

        bukudigital::where('id',$datas->id)
        ->update([
            'nama'     =>   $request->nama,
            'tipe'     =>   $request->tipe,
            'ket'     =>   $request->ket,
            // 'link'     =>   $request->link,
         //    'gambar'     =>   $request->gambar,
             'file' => $namafileku,
            'updated_at'=>date("Y-m-d H:i:s")
        ]);

        // dd($namafileku);
            }else{

        bukudigital::where('id',$datas->id)
        ->update([
            'nama'     =>   $request->nama,
            'tipe'     =>   $request->tipe,
            'ket'     =>   $request->ket,
            'link'     =>   $request->link,
         //    'gambar'     =>   $request->gambar,
            //  'file' => $namafileku,
            'updated_at'=>date("Y-m-d H:i:s")
        ]);
            }



    }

    public function update(Request $request, bukudigital $id)
    {
        $this->proses_update($request,$id);

            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    public function destroy($id)
    {
        bukudigital::destroy($id);
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
        bukudigital::whereIn('id',$ids)->delete();


        // load ulang

        #WAJIB
        $pages='bukudigital';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('bukudigital')
        ->orderBy('nama','asc')
        ->paginate(Fungsi::paginationjml());

        return view('admin.bukudigital.index',compact('pages','datas','request'));

    }
}
