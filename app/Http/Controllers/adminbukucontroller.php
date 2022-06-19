<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\buku;
use App\Models\bukudetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use PDF;
use PHPUnit\Framework\MockObject\Rule\Parameters;

class adminbukucontroller extends Controller
{
    public function index(Request $request)
    {
        if ($this->checkauth('admin') === '404') {
            return redirect(URL::to('/') . '/404')->with('status', 'Halaman tidak ditemukan!')->with('tipe', 'danger')->with('icon', 'fas fa-trash');
        }



        // $jmlbuku = buku::count();
        $generatekodepanggil = Fungsi::autokodepanggilbuku(1);
        // dd($generatekodepanggil);
        // $jmlbuku++;
        $kodepanggil = '' . str_pad($generatekodepanggil, 6, '0', STR_PAD_LEFT);

        // dd($kodepanggil);
        #WAJIB
        $pages = 'buku';
        $jmldata = '0';
        $datas = '0';


        $datas = DB::table('buku')
            ->orderBy('kode', 'asc')
            ->paginate(Fungsi::paginationjml());

        // $bukurak = DB::table('bukurak')->get();
        $bukukategori = DB::table('kategori')->where('prefix', 'ddc')->get();

        return view('admin.buku.index', compact(
            'pages'
            // ,'bukurak'
            ,
            'bukukategori',
            'datas',
            'request',
            'kodepanggil'
        ));
        // return view('admin.beranda');
    }
    public function bukuPemesanan(Request $request)
    {
        if ($this->checkauth('admin') === '404') {
            return redirect(URL::to('/') . '/404')->with('status', 'Halaman tidak ditemukan!')->with('tipe', 'danger')->with('icon', 'fas fa-trash');
        }



        // $jmlbuku = buku::count();
        $generatekodepanggil = Fungsi::autokodepanggilbuku(1);
        // dd($generatekodepanggil);
        // $jmlbuku++;
        $kodepanggil = '' . str_pad($generatekodepanggil, 6, '0', STR_PAD_LEFT);

        // dd($kodepanggil);
        #WAJIB
        $pages = 'buku';
        $jmldata = '0';
        $datas = '0';


        $datas = DB::table('buku')
            ->orderBy('kode', 'asc')
            ->paginate(Fungsi::paginationjml());

        // $bukurak = DB::table('bukurak')->get();
        $bukukategori = DB::table('kategori')->where('prefix', 'ddc')->get();

        return view('admin.buku.bukuPemesanan', compact(
            'pages'
            // ,'bukurak'
            ,
            'bukukategori',
            'datas',
            'request',
            'kodepanggil'
        ));
        // return view('admin.beranda');
    }


    public function bukuPemesanancari(Request $request)
    {
        // dd($request);
        $cari = $request->cari;

        #WAJIB
        $pages = 'buku';
        $jmldata = '0';
        $datas = '0';

        $generatekodepanggil = Fungsi::autokodepanggilbuku(1);
        // dd($generatekodepanggil);
        // $jmlbuku++;
        $kodepanggil = '' . str_pad($generatekodepanggil, 6, '0', STR_PAD_LEFT);

        $datas = DB::table('buku')
            // ->where('nis','like',"%".$cari."%")
            ->where('nama', 'like', "%" . $cari . "%")
            ->orWhere('kode', 'like', "%" . $cari . "%")
            ->paginate(Fungsi::paginationjml());



        // $bukurak = DB::table('bukurak')->get();
        $bukukategori = DB::table('kategori')->where('prefix', 'ddc')->get();

        return view('admin.buku.bukuPemesanan', compact(
            'pages'
            // ,'bukurak'
            ,
            'bukukategori',
            'datas',
            'request',
            'kodepanggil'
        ));
    }
    public function cari(Request $request)
    {
        // dd($request);
        $cari = $request->cari;

        #WAJIB
        $pages = 'buku';
        $jmldata = '0';
        $datas = '0';

        $generatekodepanggil = Fungsi::autokodepanggilbuku(1);
        // dd($generatekodepanggil);
        // $jmlbuku++;
        $kodepanggil = '' . str_pad($generatekodepanggil, 6, '0', STR_PAD_LEFT);

        $datas = DB::table('buku')
            // ->where('nis','like',"%".$cari."%")
            ->where('nama', 'like', "%" . $cari . "%")
            ->orWhere('kode', 'like', "%" . $cari . "%")
            ->paginate(Fungsi::paginationjml());



        // $bukurak = DB::table('bukurak')->get();
        $bukukategori = DB::table('kategori')->where('prefix', 'ddc')->get();

        return view('admin.buku.index', compact(
            'pages'
            // ,'bukurak'
            ,
            'bukukategori',
            'datas',
            'request',
            'kodepanggil'
        ));
    }
    public function store(Request $request)
    {


        // dd($request);
        // dd($request);
        $request->validate(
            [
                'nama' => 'required|unique:buku,nama',
                // 'bukurak_nama'=>'required',
                'bukukategori_ddc' => 'required',


            ],
            [
                'nama.required' => 'Nama Harus diisi',

            ]
        );
        // dd($files);

        // dd($kodebuku);
        DB::table('buku')->insert(
            array(
                'id'     =>   $request->kode,
                'nama'     =>   $request->nama,
                'isbn'     =>   $request->isbn,
                'pengarang'     =>   $request->pengarang,
                'kode'     =>   $request->kode,
                //    'bukurak_nama'     =>   $request->bukurak_nama,
                //    'bukurak_kode'     =>   $ambilbukurak_kode->kode,
                'bukukategori_ddc'     =>   $request->bukukategori_ddc,
                'tempatterbit'     =>   $request->tempatterbit,
                'penerbit'     =>   $request->penerbit,
                'tahunterbit'     =>   $request->tahunterbit,
                'bahasa'     =>   $request->bahasa,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            )
        );


        $files = $request->file('file');

        // dd($request);
        if ($files != null) {
            // dd(!Input::hasFile('files'));
            // dd($files,'aaa');
            $namafilebaru = $request->kode;

            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('file');

            // nama file
            echo 'File Name: ' . $file->getClientOriginalName();
            echo '<br>';

            // ekstensi file
            echo 'File Extension: ' . $file->getClientOriginalExtension();
            // dd()
            echo '<br>';

            // real path
            echo 'File Real Path: ' . $file->getRealPath();
            echo '<br>';

            // ukuran file
            echo 'File Size: ' . $file->getSize();
            echo '<br>';

            // tipe mime
            echo 'File Mime Type: ' . $file->getMimeType();

            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'storage/gambar';

            // upload file
            $file->move($tujuan_upload, "gambar/" . $namafilebaru . ".jpg");


            buku::where('kode', $request->kode)
                ->update([
                    'gambar' => "gambar/" . $namafilebaru . ".jpg",
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
        }

        return redirect()->back()->with('status', 'Data berhasil di tambahkan!')->with('tipe', 'success');
    }
    public function show(Request $request, buku $id)
    {
        // dd($id);
        #WAJIB
        $pages = 'buku';
        $datas = $id;

        // $bukurak = DB::table('bukurak')->get();
        $bukukategori = DB::table('kategori')->where('prefix', 'ddc')->get();

        return view('admin.buku.edit', compact(
            'pages',
            'datas'
            // ,'bukurak'
            ,
            'bukukategori',
            'request'
        ));
    }
    public function proses_update($request, $datas)
    {
        if ($request->nama !== $datas->nama) {
            $request->validate(
                [
                    'nama' => 'unique:buku,nama'
                ],
                [
                    // 'nama.unique'=>'Nama harus diisi'


                ]
            );
        }

        if ($request->kode !== $datas->kode) {
            $request->validate(
                [
                    'kode' => 'unique:buku,kode'
                ],
                [
                    // 'nama.unique'=>'Nama harus diisi'


                ]
            );
        }



        // $ambilbukurak_kode = DB::table('bukurak')->where('nama',$request->bukurak_nama)->first();
        // $ambilbukukategori_ddc = DB::table('kategori')->where('nama',$request->bukukategori_nama)->first();


        // if($request->bukukategori_nama==$datas->bukukategori_nama){
        //     $kodebuku=$datas->kode;
        // }else{
        //     $kodebuku=Fungsi::autokodebuku($ambilbukukategori_ddc->kode);
        //             if($kodebuku==='penuh'){
        //                 return redirect()->back()->with('status','Data Gagal di tambahkan karena kode buku penuh!')->with('tipe','error')->with('icon','fas fa-feather');

        //             }
        // }
        // dd($request->bukukategori_nama,$datas->bukukategori_nama,$kodebuku);

        bukudetail::where('buku_kode', $datas->kode)
            ->update([
                'buku_nama'     =>   $request->nama,
                'buku_kode'     =>   $request->kode,
                'buku_pengarang'     =>   $request->pengarang,
                'buku_isbn'     =>   $request->isbn,
                // 'bukukategori_ddc'     =>   $ambilbukukategori_ddc->kode,
                'bukukategori_ddc'     =>   $request->bukukategori_ddc,
                // 'bukukategori_nama'     =>   $request->bukukategori_nama,
                // 'bukurak_kode'     =>   $ambilbukurak_kode->kode,
                // 'bukurak_nama'     =>   $request->bukurak_nama,
                'buku_penerbit'     =>   $request->penerbit,
                'buku_tahunterbit'     =>   $request->tahunterbit,
                'buku_bahasa'     =>   $request->bahasa,
                'updated_at' => date("Y-m-d H:i:s")
            ]);

        buku::where('id', $datas->id)
            ->update([
                'nama'     =>   $request->nama,
                'kode'     =>   $request->kode,
                'pengarang'     =>   $request->pengarang,
                'isbn'     =>   $request->isbn,
                'bukukategori_ddc'     =>   $request->bukukategori_ddc,
                // 'bukurak_kode'     =>   $ambilbukurak_kode->kode,
                // 'bukurak_nama'     =>   $request->bukurak_nama,
                'penerbit'     =>   $request->penerbit,
                'tempatterbit'     =>   $request->tempatterbit,
                'tahunterbit'     =>   $request->tahunterbit,
                'bahasa'     =>   $request->bahasa,
                'updated_at' => date("Y-m-d H:i:s")
            ]);
    }

    public function update(Request $request, buku $id)
    {
        $this->proses_update($request, $id);

        return redirect()->back()->with('status', 'Data berhasil diupdate!')->with('tipe', 'success')->with('icon', 'fas fa-edit');
    }

    public function destroy($id)
    {
        buku::destroy($id);
        return redirect()->back()->with('status', 'Data berhasil dihapus!')->with('tipe', 'info')->with('icon', 'fas fa-trash');
    }

    public function multidel(Request $request)
    {

        $ids = $request->ids;

        // $datasiswa = DB::table('siswa')->where('id',$ids)->get();
        // foreach($datasiswa as $ds){
        //     $nis=$ds->nis;
        // }

        // dd($request);

        // DB::table('tagihansiswa')->where('siswa_nis', $ids)->where('tapel_nama',$this->tapelaktif())->delete();
        buku::whereIn('id', $ids)->delete();


        // load ulang


        // $jmlbuku = buku::count();
        $generatekodepanggil = Fungsi::autokodepanggilbuku(1);
        // dd($generatekodepanggil);
        // $jmlbuku++;
        $kodepanggil = '' . str_pad($generatekodepanggil, 6, '0', STR_PAD_LEFT);

        // dd($kodepanggil);
        #WAJIB
        $pages = 'buku';
        $jmldata = '0';
        $datas = '0';


        $datas = DB::table('buku')
            ->orderBy('kode', 'asc')
            ->paginate(Fungsi::paginationjml());

        // $bukurak = DB::table('bukurak')->get();
        $bukukategori = DB::table('kategori')->where('prefix', 'ddc')->get();

        return view('admin.buku.index', compact(
            'pages'
            // ,'bukurak'
            ,
            'bukukategori',
            'datas',
            'request',
            'kodepanggil'
        ));
    }
    public function cetakchecked(Request $request)
    {
        // dd($request->databukuchecked);

        $tgl = date("YmdHis");
        $str = explode(",", $request->databukuchecked);
        $jmldata = count($str);

        // dd($str,$jmldata);

        $pdf = PDF::loadview('admin.buku.cetakchecked', compact('jmldata', 'str'))->setPaper('a4', 'potrait');

        return $pdf->stream('buku' . $tgl . '.pdf');
    }
}
