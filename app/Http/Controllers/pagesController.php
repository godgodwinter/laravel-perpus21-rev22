<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\arsip_siswa;
use App\Models\arsip_tagihanatur;
use App\Models\arsip_tagihansiswa;
use App\Models\arsip_tagihansiswadetail;
use App\Models\arsip_users;
use App\Models\kelas;
use App\Models\settings;
use App\Models\siswa;
use App\Models\tagihanatur;
use App\Models\tagihansiswa;
use App\Models\tagihansiswadetail;
use App\Models\tapel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class pagesController extends Controller
{

    public function invoice(Request $request,$id)
    {
        // 1. periksa jika di pengembalian ada maka tampilkan
        // 2. jika tidak a maka peminjaman
        // 3. jika tidak ada maka tampilkan pesan error
        $cekpemgembalian=DB::table('pengembalian')
        ->where('kodetrans',$id)
        ->orderBy('created_at','desc')
        ->count();
        if($cekpemgembalian>0){
            $datas=DB::table('pengembalian')
            ->where('kodetrans',$id)
            ->orderBy('created_at','desc')
            ->first();

            $datapinjamdetail=DB::table('pengembaliandetail')->where('kodetrans',$id)->orderBy('created_at', 'desc')->get();

            $detaildatas = $datapinjamdetail->unique('buku_kode');

                        $pages='pengembalian';
                        return view('testing.invoicepengembalian',compact('pages','datas','detaildatas'
                     ));
        }else{

            $cekpeminjaman=DB::table('peminjaman')
            ->where('kodetrans',$id)
            ->orderBy('created_at','desc')
            ->count();
                if($cekpeminjaman>0){
                    $datas=DB::table('peminjaman')
                    ->where('kodetrans',$id)
                    ->orderBy('created_at','desc')
                    ->first();


        $datapinjamdetail=DB::table('peminjamandetail')->where('kodetrans',$id)->orderBy('created_at', 'desc')->get();

        $detaildatas = $datapinjamdetail->unique('buku_kode');

                    $pages='peminjaman';
                    return view('testing.invoicepeminjaman',compact('pages','datas','detaildatas'
                ));

                }else{
                    //data tidak ditemukan
                     return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');


                }
        }

    }
    public function buku(Request $request,$id)
    {
        $datas=DB::table('buku')
        ->where('kode',$id)
        ->orderBy('created_at','desc')
        ->first();
        // dd($datas);
        $pages='beranda';
        return view('testing.buku',compact('pages','datas'
    ));
    }
    public function anggotashow(Request $request,$id)
    {
        $datas=DB::table('anggota')
        ->where('nomeridentitas',$id)
        ->orderBy('created_at','desc')
        ->first();
        // dd($datas);
        $pages='beranda';
        return view('testing.anggotashow',compact('pages','datas'
    ));
    }
    public function formatimport()
    {
        $pages='beranda';
        return view('admin.pages.formatimport',compact('pages'
    ));
    }

    public function guide()
    {
        $pages='beranda';
        return view('admin.pages.guide',compact('pages'
    ));
    }

    public function barcode()
    {
        $pages='beranda';
        return view('admin.testing.barcode',compact('pages'
    ));
    }

    public function tail()
    {
        $pages='beranda';
        return view('testing.tail',compact('pages'
    ));
    }
    public function landing()
    {
        $pages='beranda';
        return view('testing.landing',compact('pages'
    ));
    }

    public function anggota()
    {
        $pages='beranda';
        $datas=[];
        return view('testing.anggota',compact('pages','datas'
    ));
    }
    public function pengunjung()
    {
        $pages='beranda';
        $datas=[];
        return view('testing.pengunjung',compact('pages','datas'
    ));
    }

    public function katalogproses(Request $request)
    {

        $output = '';
        $cari=$request->cari;

        $jml=DB::table('buku')
        ->where('nama','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('kode','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('isbn','like',"%".$cari."%")->skip(0)->take(10)
        ->count();


        $datas=DB::table('buku')
        // ->where('nis','like',"%".$cari."%")
        ->where('nama','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('kode','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('isbn','like',"%".$cari."%")->skip(0)->take(10)
        ->get();
        if($jml>0){

                foreach($datas as $row){

        $jmltersedia=DB::table('bukudetail')
        ->where('status','ada')
        ->where('buku_kode',$row->kode)
        ->count();
        if($jmltersedia>0){
            $tersedia=$jmltersedia." Buku";
        }else{
            $tersedia="Buku kosong";
        }

                    if($row->gambar==null){
                        $gambar='https://ui-avatars.com/api/?name='.$row->nama.'&color=7F9CF5&background=EBF4FF';
                    }else{
                        $gambar=asset("storage/").'/'.$row->gambar;
                    }

                $output .= '
                
                <div class="max-w-lg rounded overflow-hidden shadow-lg">
                    <img class="w-full object-cover h-48" src="'.$gambar.'" alt="Sunset in the mountains">
                    <div class="px-3 py-4">
                      <div class="font-bold text-xl mb-2"> '.$row->nama.'.</div>
                      <table>
                      <tr>
                      <td style="padding-right:10px;">
                                           <p class="text-gray-700 dark:text-white text-base">Pengarang </td><td style="padding-right:10px;"> :</td><td>
                       '.$row->pengarang.' </td>
                      </p>
                      </tr>
                      <tr>
                      <td>
                                           <p class="text-gray-700 dark:text-white text-base">Penerbit </td><td style="padding-right:10px;"> :</td><td>
                       '.$row->penerbit.' </td>
                      </p>
                      </tr>
                      <tr>
                      <td>
                                           <p class="text-gray-700 dark:text-white text-base">Tersedia </td><td style="padding-right:10px;"> :</td><td>
                       '.$tersedia.' </td>
                      </p>
                      </tr>
                      </table>

                    </div>
                    <div class="px-6 pt-4 pb-2">
                      <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700  dark:bg-gray-700  mr-2 mb-2 dark:text-white">ISBN : '.$row->isbn.'</span>
                      <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 dark:bg-gray-700 mr-2 mb-2 dark:text-white">Kode Panggil : '.$row->kode.'</span>
                    </div>

                    <div class="px-6 pt-4 pb-2 flex float-right">
                    <a href="'.url('/buku/').'/'.$row->kode.'"
                    class="px-4 py-2 font-bold text-white bg-gray-500 rounded hover:bg-gray-600 active:bg-gray-700 focus:outline-none focus:shadow-outline transform hover:rotate-2 transition duration-500 ease-in-out "
                    href="#"> Lihat Selengkapnya
                </a>
                </div>
                  </div>

                ';
                }
         }else{
            $output = '
            <tr>
             <td align="center" colspan="5">No Data Found</td>
            </tr>
            ';

         }
        // echo json_encode($datas);

        return response()->json([
            'success' => true,
            'message' => $jml,
            'show' => $output,
            // 'status' => $data->status,
            'datas' => $datas
        ], 200);

        dd($datas);



        #WAJIB





    // $bukurak = DB::table('bukurak')->get();
    $bukukategori = DB::table('kategori')->where('prefix','ddc')->get();

    return view('admin.buku.index',compact('pages'
    // ,'bukurak'
    ,'bukukategori','datas','request'));
    }



    public function katalog()
    {
        $pages='beranda';
        $datas=[];
        return view('testing.katalog',compact('pages','datas'
    ));
    }


    public function anggotacektanggungan(Request $request)
    {

        $jmlpinjam=DB::table('peminjaman')
        ->where('nomeridentitas',$request->cari)
        ->count();
        $jmlkembali=DB::table('pengembalian')
        ->where('nomeridentitas',$request->cari)
        ->count();

        if($jmlpinjam>0){
            $tersedia=$jmlpinjam." Kali";
        }else{
            $tersedia="Belum pernah pinjam";
        }

        if($jmlpinjam>$jmlkembali){
            $belumkembali=$jmlpinjam-$jmlkembali;
        }else{
            $belumkembali=0;
        }
        return response()->json([
            'success' => true,
            'message' => $belumkembali,
            'datas' => $belumkembali
        ], 200);

        // dd($datas);
    }
    
    public function pengunjungproses(Request $request)
    {
        $request->validate([
            'nama'=>'required',
            'nomeridentitas'=>'required',
            'tgl'=>'required',
        ],
        [
            'nama.required'=>'Nama Harus diisi',

        ]);
            $tipe='Belum Daftar';
        $d=DB::table('anggota')->where('nomeridentitas',$request->nomeridentitas)->count();
        if($d>0){
            $dd=DB::table('anggota')->where('nomeridentitas',$request->nomeridentitas)->first();
            $tipe=$dd->tipe;
        }

        DB::table('pengunjung')->insert([
            'nama' => $request->nama,
            'nomeridentitas' =>$request->nomeridentitas,
            'tipe' => $tipe,
            'tgl' =>$request->tgl,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success');
    }
    public function anggotaproses(Request $request)
    {

        $output = '';
        $cari=$request->cari;

        $jml=DB::table('anggota')
        ->where('nama','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('nomeridentitas','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('agama','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('alamat','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('jk','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('sekolahasal','like',"%".$cari."%")->skip(0)->take(10)
        ->count();


        $datas=DB::table('anggota')
        ->where('nama','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('nomeridentitas','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('agama','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('alamat','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('jk','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('sekolahasal','like',"%".$cari."%")->skip(0)->take(10)
        ->get();

        $first=DB::table('anggota')
        ->where('nama','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('nomeridentitas','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('agama','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('alamat','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('jk','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('sekolahasal','like',"%".$cari."%")->skip(0)->take(10)
        ->first();

        if($jml>0){


                foreach($datas as $row){

                    $jmlpinjam=DB::table('peminjaman')
                    ->where('nomeridentitas',$row->nomeridentitas)
                    ->count();
                    $jmlkembali=DB::table('pengembalian')
                    ->where('nomeridentitas',$row->nomeridentitas)
                    ->count();

                    if($jmlpinjam>0){
                        $tersedia=$jmlpinjam." Kali";
                    }else{
                        $tersedia="Belum pernah pinjam";
                    }

                    if($jmlpinjam>$jmlkembali){
                        $belumkembali=$jmlpinjam-$jmlkembali;
                    }else{
                        $belumkembali=0;
                    }


                    if($row->gambar==null){
                        $gambar='https://ui-avatars.com/api/?name='.$row->nama.'&color=7F9CF5&background=EBF4FF';
                    }else{
                        $gambar=asset("storage/").'/'.$row->gambar;
                    }

            //     $output .= '<div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 mb-4 bg-white dark:bg-gray-800">
            //     <div class="max-w-lg rounded overflow-hidden shadow-lg">
            //         <img class="w-full object-cover h-96" src="'.$gambar.'" alt="Sunset in the mountains">
            //         <div class="px-6 py-4">
            //           <div class="font-bold text-xl mb-2 text-gray-700 dark:text-white"> '.$row->nama.'.</div>
            //           <table>
            //           <tr>
            //           <td style="padding-right:10px;">
            //                                <p class="text-gray-700 dark:text-white text-base">Pinjam </td><td style="padding-right:10px;"> : </td><td>
            //            '.$tersedia.' </td>
            //           </p>
            //           </tr>
            //           <tr>
            //           <td style="padding-right:10px;">
            //                                <p class="text-gray-700 dark:text-white text-base">Belum dikembalikan </td><td style="padding-right:10px;"> : </td><td>
            //                                <p class="text-red-400 text-base">'.$belumkembali.' Buku</p></td>
            //           </p>
            //           </tr>
            //           </table>

            //         </div>
            //         <div class="px-6 pt-4 pb-2">
            //           <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 dark:bg-gray-700  dark:text-white" >Nomer Identitas : '.$row->nomeridentitas.'</span>
            //         </div>


            //         <div class="px-6 pt-4 pb-2 flex float-right">
            //         <a href="'.url('/anggotashow/').'/'.$row->nomeridentitas.'"
            //         class="px-4 py-2 font-bold text-white bg-gray-500 rounded hover:bg-gray-600 active:bg-gray-700 focus:outline-none focus:shadow-outline transform hover:rotate-2 transition duration-500 ease-in-out "
            //         href="#"> Lihat Selengkapnya
            //     </a>
            //     </div>


            //       </div>
            // </div>

            //     ';
                }
         }else{
            // $output = '
            // <tr>
            //  <td align="center" colspan="5">No Data Found</td>
            // </tr>
            // ';

         }
        // echo json_encode($datas);

        return response()->json([
            'success' => true,
            'message' => $jml,
            'show' => $output,
            // 'status' => $data->status,
            'datas' => $datas,
            'first' => $first
        ], 200);

        dd($datas);

    }


    public function cari()
    {
        $pages='beranda';
        $datas=[];
        return view('testing.cari',compact('pages','datas'
    ));
    }
    public function cariproses(Request $request)
    {

        $output = '';
        $cari=$request->cari;

        $jml=DB::table('buku')
        ->where('nama','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('kode','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('isbn','like',"%".$cari."%")->skip(0)->take(10)
        ->count();


        $datas=DB::table('buku')
        // ->where('nis','like',"%".$cari."%")
        ->where('nama','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('kode','like',"%".$cari."%")->skip(0)->take(10)
        ->orWhere('isbn','like',"%".$cari."%")->skip(0)->take(10)
        ->get();
        if($jml>0){

                foreach($datas as $row){

        $jmltersedia=DB::table('bukudetail')
        ->where('status','ada')
        ->where('buku_kode',$row->kode)
        ->count();
        if($jmltersedia>0){
            $tersedia=$jmltersedia." Buku";
        }else{
            $tersedia="Buku kosong";
        }

                    if($row->gambar==null){
                        $gambar='https://ui-avatars.com/api/?name='.$row->nama.'&color=7F9CF5&background=EBF4FF';
                    }else{
                        $gambar=asset("storage/").'/'.$row->gambar;
                    }

                $output .= '<div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 mb-4 bg-white">
                <div class="max-w-lg rounded overflow-hidden shadow-lg">
                    <img class="w-full object-cover h-96" src="'.$gambar.'" alt="Sunset in the mountains">
                    <div class="px-6 py-4">
                      <div class="font-bold text-xl mb-2"> '.$row->nama.'.</div>
                      <table>
                      <tr>
                      <td style="padding-right:10px;">
                                           <p class="text-gray-700 text-base">Pengarang </td><td style="padding-right:10px;"> :</td><td>
                       '.$row->pengarang.' </td>
                      </p>
                      </tr>
                      <tr>
                      <td>
                                           <p class="text-gray-700 text-base">Penerbit </td><td style="padding-right:10px;"> :</td><td>
                       '.$row->penerbit.' </td>
                      </p>
                      </tr>
                      <tr>
                      <td>
                                           <p class="text-gray-700 text-base">Tersedia </td><td style="padding-right:10px;"> :</td><td>
                       '.$tersedia.' </td>
                      </p>
                      </tr>
                      </table>

                    </div>
                    <div class="px-6 pt-4 pb-2">
                      <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">ISBN : '.$row->isbn.'</span>
                    </div>
                  </div>
            </div>

                ';
                }
         }else{
            $output = '
            <tr>
             <td align="center" colspan="5">No Data Found</td>
            </tr>
            ';

         }
        // echo json_encode($datas);

        return response()->json([
            'success' => true,
            'message' => $jml,
            'show' => $output,
            // 'status' => $data->status,
            'datas' => $datas
        ], 200);

        dd($datas);



        #WAJIB





    // $bukurak = DB::table('bukurak')->get();
    $bukukategori = DB::table('kategori')->where('prefix','ddc')->get();

    return view('admin.buku.index',compact('pages'
    // ,'bukurak'
    ,'bukukategori','datas','request'));
    }



}
