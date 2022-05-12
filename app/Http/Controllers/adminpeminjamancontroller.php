<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\bukudetail;
use App\Models\peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class adminpeminjamancontroller extends Controller
{
    public function index(Request $request)
    {
        // if($this->checkauth('admin')==='404'){
        //     return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        // }

        #WAJIB
        $pages='peminjaman';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('peminjaman')
        ->orderBy('nama','asc')
        ->paginate(Fungsi::paginationjml());

        // $peminjamankategori = DB::table('kategori')->where('prefix','tipepeminjaman')->get();
        // $kondisi = DB::table('kategori')->where('prefix','kondisi')->get();

        return view('admin.peminjaman.index',compact('pages','datas','request'));
        // return view('admin.beranda');
    }

    public function invoicepeminjamanperiksa(Request $request)
    {
        // dd($request);
        return redirect(URL::to('/').'/admin/peminjaman/'.$request->kodetrans)->with('status','Data ditemukan!')->with('tipe','success')->with('icon','fas fa-trash');

    }
    public function invoicepeminjaman(Request $request)
    {

        #WAJIB
        $pages='peminjaman';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('peminjaman')
        ->orderBy('created_at','desc')
        ->paginate(Fungsi::paginationjml());

        // $peminjamankategori = DB::table('kategori')->where('prefix','tipepeminjaman')->get();
        // $kondisi = DB::table('kategori')->where('prefix','kondisi')->get();

        return view('admin.peminjaman.invoicepeminjaman',compact('pages','datas','request'));
        // return view('admin.beranda');
    }

    public function invoice(Request $request,$id)
    {
        $datapinjam=DB::table('peminjaman')
        ->where('kodetrans',$id)
        ->orderBy('created_at','desc')
        ->first();

        $jmlbelumkembali=0;
            //ambil data
        $datapinjamdetail=DB::table('peminjamandetail')->where('kodetrans',$id)->orderBy('created_at', 'desc')->get();

        $datas = $datapinjamdetail->unique('buku_kode');
        $dataanggota=DB::table('anggota')->where('nomeridentitas',$datapinjam->nomeridentitas)->first();

            // dd($datas);
            #WAJIB
            $pages='pengembalian';
            // $jmldata='0';
            // $datas='0';


            // $datas=DB::table('pengembalian')
            // ->orderBy('nama','asc')
            // ->paginate(Fungsi::paginationjml());

            // $pengembaliankategori = DB::table('kategori')->where('prefix','tipepengembalian')->get();
            // $kondisi = DB::table('kategori')->where('prefix','kondisi')->get();

        // dd($dataanggota);
        return view('admin.peminjaman.invoiceshow',compact('pages','datas','datapinjam','request','dataanggota'));
    }
    public function store(Request $request)
    {
        // dd($request);
        $kodetrans=base64_encode(date('YmdHis'));
        $decodekodetrans=base64_decode($kodetrans);

        $dataanggota=DB::table('anggota')->where('nomeridentitas',$request->nomeridentitas)->first();


        $jaminan_nama=$request->nomeridentitas;
        if($request->jaminan_nama!=null){
            $jaminan_nama=$request->jaminan_nama;
        }
        $tgl_pinjam=$request->tgl_pinjam;
        $tgl_harus_kembali=Fungsi::manipulasiTanggal($tgl_pinjam,Fungsi::defaultmaxharipinjam(),'days');

        // dd($request->daftarbuku);
        if($request->daftarbuku==null){
        return redirect()->back()->with('status','Gagal! Buku tidak ditemukan!')->with('tipe','error')->with('icon','fas fa-trash');
        }

            // 2. insert peminjaman berdasarkan dataanggota
            DB::table('peminjaman')->insert([
                'kodetrans' => $kodetrans,
                'nama' => $dataanggota->nama,
                'nomeridentitas' =>$request->nomeridentitas,
                'jaminan_tipe' => $request->jaminan_tipe,
                'jaminan_nama' => $jaminan_nama,
                'tgl_pinjam' => $tgl_pinjam,
                'tgl_harus_kembali' =>$tgl_harus_kembali,
                'denda' =>Fungsi::defaultdenda(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        // dd($request->daftarbuku);
        foreach($request->daftarbuku as $db){
            $kode=$db['kode'];
            $jml=$db['jml'];

            // 1.ambil data buku
                $databuku=DB::table('buku')->where('kode',$kode)->first();

            // 3. ulangi sesuai jml buku
            // 4. insert peminjamandetail
            for($i=0;$i<$jml;$i++){
                $cek=DB::table('bukudetail')->where('status','ada')->where('buku_kode',$databuku->kode)->skip(0)->take(1)->count();
                // dd($cek,($jml-$i));
                $datas=DB::table('bukudetail')->where('status','ada')->where('buku_kode',$databuku->kode)->skip(0)->take(1)->first();
                // dd($kodetrans,$databukudetail,$request->daftarbuku,$db,$db['kode'],$kode,$jml,$databuku);
                // foreach($databukudetail as $datas){
             if($cek>0){
            DB::table('peminjamandetail')->insert([
                'kodetrans' => $kodetrans,
                'buku_isbn' => $datas->buku_isbn,
                'nomeridentitas' =>$request->nomeridentitas,
                'buku_nama' => $datas->buku_nama,
                'buku_kode' => $datas->buku_kode,
                'buku_penerbit' => $datas->buku_penerbit,
                'buku_tahunterbit' => $datas->buku_tahunterbit,
                'buku_pengarang' => $datas->buku_pengarang,
                'buku_tempatterbit' => $datas->buku_tempatterbit,
                'buku_bahasa' => $datas->buku_bahasa,
                // 'bukurak_nama' => $datas->bukurak_nama,
                'bukukategori_nama' => $datas->bukukategori_nama,
                'bukukategori_ddc' => $datas->bukukategori_ddc,
                'jaminan_tipe' => $request->jaminan_tipe,
                'jaminan_nama' => $jaminan_nama,
                'tgl_pinjam' => $tgl_pinjam,
                'tgl_harus_kembali' =>$tgl_harus_kembali,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

                    bukudetail::where('id',$datas->id)
                    ->update([
                        'status'     =>  'dipinjam',
                       'updated_at'=>date("Y-m-d H:i:s")
                    ]);
        }
    }
                // dd($kodetrans,$databukudetail,$request->daftarbuku,$db,$db['kode'],$kode,$jml,$databuku);
            // }

        }

        // dd($request->daftarbuku,$db);
        return  redirect(URL::to('/').'/admin/peminjaman/'.$kodetrans)->with('status','Proses Peminjaman Berhasil!')->with('tipe','success')->with('clearlocal','yes');

    }
    public function storelawas(Request $request)
    {
        if($request->daftarbuku==null){
        return redirect()->back()->with('status','Gagal! Buku tidak ditemukan!')->with('tipe','error')->with('icon','fas fa-trash');
        }
        $bukubuku=$request->daftarbuku;
        $jml=Fungsi::periksaarray($bukubuku);
        // if()
        $str=explode(",",$bukubuku);
        for($i=0;$i<$jml;$i++){


        }

        $datas=DB::table('bukudetail')->where('kodepanggil',$str[0])->first();
        $dataanggota=DB::table('anggota')->where('nomeridentitas',$request->nomeridentitas)->first();


        //buat kodetransaksi dari date masukkan ke peminjaman dan peminjamandetail
        $kodetrans=base64_encode(date('YmdHis'));
        $decodekodetrans=base64_decode($kodetrans);

        // validator (lakukan di front end, jika tidak sesuai tidak dapat masuk kesini)
        // a.periksa jumlah tanggungan buku belum dikembalikan
        // b. buku masih dipinjam / rusak

        //1.insert anggota ke peminjaman
        $jaminan_nama=$request->nomeridentitas;
        if($request->jaminan_nama!=null){
            $jaminan_nama=$request->jaminan_nama;
        }
        $tgl_pinjam=date('Y-m-d');
        $tgl_harus_kembali=Fungsi::manipulasiTanggal($tgl_pinjam,Fungsi::defaultmaxharipinjam(),'days');
        // dd($jml,count($str),($str[0]),$datas,$request->nomeridentitas,$dataanggota->nama,$kodetrans,$decodekodetrans,$tgl_pinjam,$tgl_harus_kembali);

        DB::table('peminjaman')->insert([
            'kodetrans' => $kodetrans,
            'nama' => $dataanggota->nama,
            'nomeridentitas' =>$request->nomeridentitas,
            'jaminan_tipe' => $request->jaminan_tipe,
            'jaminan_nama' => $jaminan_nama,
            'tgl_pinjam' => $tgl_pinjam,
            'tgl_harus_kembali' =>$tgl_harus_kembali,
            'denda' =>Fungsi::defaultdenda(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        //2/insert buku ke peminjaman detail where kodetransaksi

        for($i=0;$i<$jml;$i++){

            $datas=DB::table('bukudetail')->where('kodepanggil',$str[$i])->first();
            // dd($datas);
            DB::table('peminjamandetail')->insert([
                'kodetrans' => $kodetrans,
                'buku_isbn' => $datas->buku_isbn,
                'nomeridentitas' =>$request->nomeridentitas,
                'buku_nama' => $datas->buku_nama,
                'buku_kodepanggil' => $datas->kodepanggil,
                'buku_penerbit' => $datas->buku_penerbit,
                'buku_tahunterbit' => $datas->buku_tahunterbit,
                'buku_pengarang' => $datas->buku_pengarang,
                'buku_tempatterbit' => $datas->buku_tempatterbit,
                'buku_bahasa' => $datas->buku_bahasa,
                // 'bukurak_nama' => $datas->bukurak_nama,
                'bukukategori_nama' => $datas->bukukategori_nama,
                'bukukategori_ddc' => $datas->bukukategori_ddc,
                'jaminan_tipe' => $request->jaminan_tipe,
                'jaminan_nama' => $jaminan_nama,
                'tgl_pinjam' => $tgl_pinjam,
                'tgl_harus_kembali' =>$tgl_harus_kembali,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        //3.ubah status buku per exemplar bahwa dipinjam

        bukudetail::where('kodepanggil',$str[$i])
        ->update([
            'status'     =>  'dipinjam',
           'updated_at'=>date("Y-m-d H:i:s")
        ]);


        }

        return redirect()->back()->with('status','Proses Peminjaman Berhasil!')->with('tipe','success')->with('clearlocal','yes');


    }

    public function periksabuku($id)
    {
        $jmltersedia=DB::table('bukudetail')->where('buku_kode',$id)->where('status','ada')->count();
        $data=DB::table('buku')->where('kode',$id)->first();
        // $datsa=DB::table('buku')->get();
        // return $datsa;
        return response()->json([
            'success' => true,
            'message' => $jmltersedia,
            // 'status' => $data->status,
            'nama' => $data->nama,
            'pengarang' => $data->pengarang,
            'penerbit' => $data->penerbit,
            'isbn' => $data->isbn,
            'bukukategori_nama' => $data->bukukategori_nama,
            'data'    => $id
        ], 200);

    }
    public function periksa($id)
    {

        $datas=DB::table('bukudetail')->where('kodepanggil',$id)->count();
        $data=DB::table('bukudetail')->where('kodepanggil',$id)->first();
        // //make response JSON
        if($datas>0){
            $ada=1;
            if($data->status!='ada'){
                $ada=0;
            }

            return response()->json([
                'success' => true,
                'message' => $ada,
                'status' => $data->status,
                'buku_nama' => $data->buku_nama,
                'bukukategori_nama' => $data->bukukategori_nama,
                'data'    => $id
            ], 200);

        }else{
            $ada=1;
            if($data->status!='ada'){
                $ada=0;
            }
            return response()->json([
                'success' => true,
                'message' => $ada,
                'status' => $data->status,
                'buku_nama' => $data->buku_nama,
                'bukukategori_nama' => $data->bukukategori_nama,
                'data'    => $id
            ], 200);

        }
    }

    public function destroy($id){

        DB::table('pengembalian')->where('kodetrans', $id)->delete();
        DB::table('pengembaliandetail')->where('kodetrans', $id)->delete();
        DB::table('peminjaman')->where('kodetrans', $id)->delete();
        DB::table('peminjamandetail')->where('kodetrans', $id)->delete();
        // peminjaman::destroy($id);
        return redirect()->route('admin.peminjaman.invoicepeminjaman')->with('status','Data berhasil dihapus!')->with('tipe','info')->with('icon','fas fa-trash');

    }

}
