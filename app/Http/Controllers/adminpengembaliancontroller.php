<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\bukudetail;
use App\Models\peminjamandetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class adminpengembaliancontroller extends Controller
{
    public function index(Request $request)
    {
        // if($this->checkauth('admin')==='404'){
        //     return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        // }

        #WAJIB
        $pages='pengembalian';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('pengembalian')
        ->orderBy('nama','asc')
        ->paginate(Fungsi::paginationjml());

        // $pengembaliankategori = DB::table('kategori')->where('prefix','tipepengembalian')->get();
        // $kondisi = DB::table('kategori')->where('prefix','kondisi')->get();

        return view('admin.pengembalian.index',compact('pages','datas','request'));
        // return view('admin.beranda');
    }

    public function invoicepengembalianperiksa(Request $request)
    {
        // dd($request);
        return redirect(URL::to('/').'/admin/pengembalian/'.$request->kodetrans)->with('status','Data ditemukan!')->with('tipe','success')->with('icon','fas fa-trash');

    }
    public function invoicepengembalian(Request $request)
    {

        #WAJIB
        $pages='pengembalian';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('pengembalian')
        ->orderBy('created_at','desc')
        ->paginate(Fungsi::paginationjml());

        // $pengembaliankategori = DB::table('kategori')->where('prefix','tipepengembalian')->get();
        // $kondisi = DB::table('kategori')->where('prefix','kondisi')->get();

        return view('admin.pengembalian.invoicepengembalian',compact('pages','datas','request'));
        // return view('admin.beranda');
    }
    public function invoice(Request $request,$id)
    {
        $datapinjam=DB::table('pengembalian')
        ->where('kodetrans',$id)
        ->orderBy('created_at','desc')
        ->first();

        $jmlbelumkembali=0;
            //ambil data
        $datapinjamdetail=DB::table('pengembaliandetail')->where('kodetrans',$id)->orderBy('created_at', 'desc')->get();

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
        return view('admin.pengembalian.invoiceshow',compact('pages','datas','datapinjam','request','dataanggota'));
    }

    public function kembalikan(Request $request)
    {

        $kodetrans=base64_encode(date('YmdHis'));
        $decodekodetrans=base64_decode($kodetrans);

        $datapinjam=DB::table('peminjamandetail')->where('nomeridentitas',$request->nomeridentitas)->where('statuspengembalian',null)->orderBy('created_at', 'desc')->get();

        $datas = $datapinjam->unique('buku_kode');
        $dataanggota=DB::table('anggota')->where('nomeridentitas',$request->nomeridentitas)->first();
        // $loop=1;
        $dendakeseluruhan=0;
        foreach($datas as $data){
            $nomeridentitas=$data->nomeridentitas;
            $buku_kode=$data->buku_kode;
            $jml=$request->datas[$data->buku_kode][$dataanggota->nomeridentitas];
            $denda=Fungsi::periksadenda($data->tgl_harus_kembali);
            $dendatotalperbuku=$denda*$jml;


            $databuku=DB::table('buku')->where('kode',$buku_kode)->first();
            // dd($dendatotalperbuku);
                for($i=0;$i<$jml;$i++){
                    // $cek=DB::table('peminjamandetail')->where('status','dipinjam')->where('buku_kode',$databuku->kode)->where('nomeridentitas',$nomeridentitas)->skip(0)->take(1)->count();


            // 3.update data bukudetail ,,status
                    $cek=DB::table('bukudetail')->where('status','dipinjam')->where('buku_kode',$databuku->kode)->skip(0)->take(1)->count();
                    $ambil=DB::table('bukudetail')->where('status','dipinjam')->where('buku_kode',$databuku->kode)->skip(0)->take(1)->first();
                    // dd($cek,$ambil);
                    if($cek>0){
                            bukudetail::where('id',$ambil->id)
                            ->update([
                                'status'     =>  'ada',
                            'updated_at'=>date("Y-m-d H:i:s")
                            ]);
                        }

            // 4.insert data pengembaliandetail
                    $cek=DB::table('peminjamandetail')->where('statuspengembalian',null)->where('buku_kode',$databuku->kode)->where('nomeridentitas',$nomeridentitas)->skip(0)->take(1)->count();
                    $ambil=DB::table('peminjamandetail')->where('statuspengembalian',null)->where('buku_kode',$databuku->kode)->where('nomeridentitas',$nomeridentitas)->skip(0)->take(1)->first();
                    // dd($cek,$ambil);
                    if($cek>0){
                        DB::table('pengembaliandetail')->insert([
                            'kodetrans' => $kodetrans,
                            'buku_isbn' => $ambil->buku_isbn,
                            'nomeridentitas' =>$nomeridentitas,
                            'buku_nama' => $ambil->buku_nama,
                            'buku_kode' => $ambil->buku_kode,
                            'buku_penerbit' => $ambil->buku_penerbit,
                            'buku_tahunterbit' => $ambil->buku_tahunterbit,
                            'buku_pengarang' => $ambil->buku_pengarang,
                            'buku_tempatterbit' => $ambil->buku_tempatterbit,
                            'buku_bahasa' => $ambil->buku_bahasa,
                            // 'bukurak_nama' => $ambil->bukurak_nama,
                            'bukukategori_nama' => $ambil->bukukategori_nama,
                            'bukukategori_ddc' => $ambil->bukukategori_ddc,
                            'jaminan_tipe' => $ambil->jaminan_tipe,
                            'jaminan_nama' => $ambil->jaminan_nama,
                            'tgl_pinjam' => $ambil->tgl_pinjam,
                            'tgl_harus_kembali' =>$ambil->tgl_harus_kembali,
                            'tgl_dikembalikan' =>date('Y-m-d'),
                            'totaldenda' =>$denda,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                        }

            // 2.update data peminjamandetail ,,status
                    $cek=DB::table('peminjamandetail')->where('statuspengembalian',null)->where('buku_kode',$databuku->kode)->where('nomeridentitas',$nomeridentitas)->skip(0)->take(1)->count();
                    $ambil=DB::table('peminjamandetail')->where('statuspengembalian',null)->where('buku_kode',$databuku->kode)->where('nomeridentitas',$nomeridentitas)->skip(0)->take(1)->first();
                    // dd($cek,$ambil);
                    if($cek>0){
                            peminjamandetail::where('id',$ambil->id)
                            ->update([
                                // 'denda'     =>  Fungsi::defaultdenda(),
                                'statuspengembalian'     =>  'sudah',
                                'denda'     =>  $denda,
                            'updated_at'=>date("Y-m-d H:i:s")
                            ]);
                        }


                        $dendakeseluruhan+=$denda;
                        // $loop++;
                  }




        }

            // 5.inset data pengembalian
            DB::table('pengembalian')->insert([
                'kodetrans' => $kodetrans,
                'nama' => $dataanggota->nama,
                'nomeridentitas' =>$request->nomeridentitas,
                'jaminan_tipe' => $ambil->jaminan_tipe,
                'jaminan_nama' => $ambil->jaminan_nama,
                'tgl_pinjam' => $ambil->tgl_pinjam,
                'tgl_harus_kembali' =>$ambil->tgl_harus_kembali,
                'denda' =>Fungsi::defaultdenda(),
                'totaldendaakhir' =>$dendakeseluruhan,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        // dd($dataanggota,$datas,$request->datas,$dendakeseluruhan);

        return  redirect(URL::to('/').'/admin/pengembalian/'.$kodetrans)->with('status','Proses pengembalian berhasil dilakukan!')->with('tipe','success')->with('icon','fas fa-trash');
        // 1. ambil data request
            // ulangi perbuku
            //ambil jmlah yang dikembalikan
            // 2.update data peminjamandetail ,,status
            // 3.update data bukudetail ,,status
            // 4.insert data pengembaliandetail
                    // a. ambil data peminjaman tgl_harus_kembali
                    // b. hitung denda dan denta total
            // 5.inset data pengembalian

    }
    public function periksaanggotashow(Request $request,$id){
        $jmlbelumkembali=0;
            //ambil data
        $datapinjam=DB::table('peminjamandetail')->where('nomeridentitas',$id)->where('statuspengembalian',null)->orderBy('created_at', 'desc')->get();

        $datas = $datapinjam->unique('buku_kode');
        $dataanggota=DB::table('anggota')->where('nomeridentitas',$id)->first();

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

            return view('admin.pengembalian.periksaanggota',compact('pages','datas','request','dataanggota'));

    }
    public function periksaanggota(Request $request)
    {
        // if($this->checkauth('admin')==='404'){
        //     return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        // }
        // dd('asd');
            //periksa apakah pernah pinjam
        $jmlpinjam=DB::table('peminjaman')->where('nomeridentitas',$request->nomeridentitas)->orderBy('created_at', 'desc')->count();
        if($jmlpinjam<1){
            // periksa apakah sudah dikembalikan
            // $ambildatapeminjaman=DB::table('peminjaman')->where('nomeridentitas',$request->nomeridentitas)->orderBy('created_at', 'desc')->first();
            // $jmlkembali=DB::table('pengembalian')->where('nomeridentitas',$request->nomeridentitas)->where('tgl_pinjam',$ambildatapeminjaman->tgl_pinjam)
            //                                     ->where('tgl_harus_kembali',$ambildatapeminjaman
            //                                     ->tgl_harus_kembali)->orderBy('created_at', 'desc')
            //                                     ->count();
            //                                         if($jmlkembali>1){
                                                            // sudah dikembalikan
            return redirect(URL::to('/').'/admin/pengembalian')->with('status','Belum pernah pinjam!')->with('tipe','error');
                                                    // }

        }else{
            $ambildatapeminjaman=DB::table('peminjaman')->where('nomeridentitas',$request->nomeridentitas)->orderBy('created_at', 'desc')->first();
           
            $jmlkembali=DB::table('pengembalian')->where('nomeridentitas',$request->nomeridentitas)
            // ->where('tgl_pinjam',$ambildatapeminjaman->tgl_pinjam)
                                                // ->where('tgl_harus_kembali',$ambildatapeminjaman
                                                // ->tgl_harus_kembali)
                                                ->orderBy('created_at', 'desc')
                                                ->count();
                                                // dd($ambildatapeminjaman,$jmlpinjam,$jmlkembali);
                                                    if($jmlpinjam<=$jmlkembali){
                                                            // sudah dikembalikan
            return redirect(URL::to('/').'/admin/pengembalian')->with('status','Belum pernah pinjam! Atau buku sudah dikembalikan')->with('tipe','error');
                                                    }
                                                    
            return redirect(URL::to('/').'/admin/pengembalian/periksaanggota/'.$request->nomeridentitas)->with('status','Data ditemukan!')->with('tipe','success');

        $jmlbelumkembali=0;
            //ambil data
        $datapinjam=DB::table('peminjamandetail')->where('nomeridentitas',$request->nomeridentitas)->where('statuspengembalian',null)->orderBy('created_at', 'desc')->get();

        $datas = $datapinjam->unique('buku_kode');
        $dataanggota=DB::table('anggota')->where('nomeridentitas',$request->nomeridentitas)->first();

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

            return view('admin.pengembalian.periksaanggota',compact('pages','datas','request','dataanggota'));
            // return redirect(URL::to('/').'/admin/pengembalian/periksa/'.$id)->with('status','Data Ditemukan!')->with('tipe','success');
        }
        // dd($id);
        // if($request->daftarbuku==null){
        // return redirect()->back()->with('status','Gagal! Buku tidak ditemukan!')->with('tipe','error')->with('icon','fas fa-trash');
        // }
    }
    public function store(Request $request)
    {
        dd($request);
        // if($request->daftarbuku==null){
        // return redirect()->back()->with('status','Gagal! Buku tidak ditemukan!')->with('tipe','error')->with('icon','fas fa-trash');
        // }
    }

    public function storelawas(Request $request)
    {
        if($request->daftarkembali==null){
        return redirect()->back()->with('status','Gagal! Buku tidak ditemukan!')->with('tipe','error')->with('icon','fas fa-trash');
        }
        $bukubuku=$request->daftarkembali;
        $jml=Fungsi::periksaarray($bukubuku);
        // if()
        $str=explode(",",$bukubuku);
        for($i=0;$i<$jml;$i++){


        }

        $datas=DB::table('bukudetail')->orderBy('created_at', 'desc')->where('kodepanggil',$str[0])->first();
        $dataanggota=DB::table('peminjaman')->orderBy('created_at', 'desc')->where('nomeridentitas',$request->nomeridentitas)->first();


        //buat kodetransaksi dari date masukkan ke peminjaman dan peminjamandetail
        $kodetrans=base64_encode(date('YmdHis'));
        $decodekodetrans=base64_decode($kodetrans);

        // validator (lakukan di front end, jika tidak sesuai tidak dapat masuk kesini)
        // a. periksa apakah buku dipinjam atau sudah dikembalikan
        // b. buku masih dipinjam / rusak

        $jaminan_nama=$request->nomeridentitas;
        if($request->jaminan_nama!=null){
            $jaminan_nama=$request->jaminan_nama;
        }
        $tgl_pinjam=date('Y-m-d');
        $tgl_harus_kembali=Fungsi::manipulasiTanggal($tgl_pinjam,Fungsi::defaultmaxharipinjam(),'days');
        // dd($jml,count($str),($str[0]),$datas,$request->nomeridentitas,$dataanggota->nama,$kodetrans,$decodekodetrans,$tgl_pinjam,$tgl_harus_kembali);


        //1/insert buku ke pengembalian detail where kodetransaksi
        $totaldendaakhir=0;
        for($i=0;$i<$jml;$i++){
            // a.ambildata dari peminjamandetail last()
            $datas=DB::table('peminjamandetail')->orderBy('created_at', 'desc')->where('buku_kodepanggil',$str[$i])->first();
            // $DeferenceInDays = Carbon::parse(Carbon::now())->diffInDays($datas->tgl_harus_kembali);
            $tgl_harus_kembali=$datas->tgl_harus_kembali;
            $hitungketerlambatan = strtotime($tgl_harus_kembali)-strtotime(Carbon::now());
            $selisih = $hitungketerlambatan / 86400;
            // jika selisih negatif maka terlambat
            if($selisih<0){
                $DeferenceInDays = Carbon::parse(Carbon::now())->diffInDays($tgl_harus_kembali);
                $denda=$DeferenceInDays*Fungsi::defaultdenda();
                $totaldendaakhir+=$denda;
            }else{
                $DeferenceInDays=0;
                $denda=0;
            }
            // dd(Carbon::now(),$tgl_harus_kembali,$DeferenceInDays,$selisih,$denda);
            DB::table('pengembaliandetail')->insert([
                'kodetrans' => $kodetrans,
                'buku_isbn' => $datas->buku_isbn,
                'nomeridentitas' =>$request->nomeridentitas,
                'buku_nama' => $datas->buku_nama,
                'buku_kodepanggil' => $datas->buku_kodepanggil,
                'buku_penerbit' => $datas->buku_penerbit,
                'buku_tahunterbit' => $datas->buku_tahunterbit,
                'buku_pengarang' => $datas->buku_pengarang,
                'buku_tempatterbit' => $datas->buku_tempatterbit,
                'buku_bahasa' => $datas->buku_bahasa,
                // 'bukurak_nama' => $datas->bukurak_nama,
                'bukukategori_nama' => $datas->bukukategori_nama,
                'bukukategori_ddc' => $datas->bukukategori_ddc,
                'jaminan_tipe' => $datas->jaminan_tipe,
                'jaminan_nama' => $datas->jaminan_nama,
                'tgl_pinjam' => $datas->tgl_pinjam,
                'tgl_harus_kembali' =>$datas->tgl_harus_kembali,
                'tgl_dikembalikan' => Carbon::now(),
                'totaldenda' =>$denda,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        peminjamandetail::where('kodetrans',$datas->kodetrans)->where('buku_kodepanggil',$datas->buku_kodepanggil)
        ->update([
            'denda'     =>  $denda,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);
        }

        // dd(Carbon::now(),$tgl_harus_kembali,$DeferenceInDays,$selisih,$denda,$totaldendaakhir);
        //2.insert anggota ke pengembalian
        DB::table('pengembalian')->insert([
            'kodetrans' => $kodetrans,
            'nama' => $dataanggota->nama,
            'nomeridentitas' =>$request->nomeridentitas,
            'jaminan_tipe' => $dataanggota->jaminan_tipe,
            'jaminan_nama' => $dataanggota->jaminan_nama,
            'tgl_pinjam' => $dataanggota->tgl_pinjam,
            'tgl_harus_kembali' =>$dataanggota->tgl_harus_kembali,
            'denda' =>Fungsi::defaultdenda(),
            'totaldendaakhir' =>$totaldendaakhir,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        for($i=0;$i<$jml;$i++){

        //3.ubah status buku per exemplar bahwa dipinjam
            $datas=DB::table('peminjamandetail')->orderBy('created_at', 'desc')->where('buku_kodepanggil',$str[$i])->first();

        peminjamandetail::where('kodetrans',$datas->kodetrans)->where('buku_kodepanggil',$datas->buku_kodepanggil)
        ->update([
            'statuspengembalian'     =>  'sudah',
           'updated_at'=>date("Y-m-d H:i:s")
        ]);

        bukudetail::where('kodepanggil',$str[$i])
        ->update([
            'status'     =>  'ada',
           'updated_at'=>date("Y-m-d H:i:s")
        ]);


        }

        return redirect()->back()->with('status','Proses Peminjaman Berhasil!')->with('tipe','success')->with('clearlocal','yes');


    }
}
