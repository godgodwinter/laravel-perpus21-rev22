<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\anggota;
use App\Models\buku;
use App\Models\bukudetail;
use App\Models\bukurak;
use App\Models\peminjaman;
use App\Models\peminjamandetail;
use App\Models\pengembalian;
use App\Models\pengembaliandetail;
use App\Models\peralatan;
use App\Models\settings;
use App\Models\tapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class settingsController extends Controller
{
    public function index()
    {
        $pages='settings';

        return view('admin.pages.settings',compact('pages'
        // ,'settings'
    ));
    }

    public function proses_update($request,$datas)
    {





        settings::where('id',$datas->id)
        ->update([
            'aplikasijudul'     =>   $request->aplikasijudul,
            'aplikasijudulsingkat'     =>   $request->aplikasijudulsingkat,
            'paginationjml'     =>   $request->paginationjml,
            'passdefaultadmin'     =>   $request->passdefaultadmin,
            'passdefaultpegawai'     =>   $request->passdefaultpegawai,
            'sekolahttd'     =>   $request->sekolahttd,
            'defaultdenda'     =>   $request->defaultdenda,
            'defaultminbayar'     =>   $request->defaultminbayar,
            'defaultmaxbukupinjam'     =>   $request->defaultmaxbukupinjam,
            'defaultmaxharipinjam'     =>   $request->defaultmaxharipinjam,
            'sekolahnama'     =>   $request->sekolahnama,
            'sekolahalamat'     =>   $request->sekolahalamat,
            'sekolahtelp'     =>   $request->sekolahtelp,
            'kop1'     =>   $request->kop1,
            'kop2'     =>   $request->kop2,
            'kop3'     =>   $request->kop3,
            'kop4'     =>   $request->kop4,
           'updated_at'=>date("Y-m-d H:i:s")
        ]);


    }

    public function update(Request $request, settings $id)
    {
        $this->proses_update($request,$id);

            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    public function hard(){

        buku::truncate();
        bukudetail::truncate();
        // bukurak::truncate();
        anggota::truncate();
        peralatan::truncate();
        peminjaman::truncate();
        peminjamandetail::truncate();
        pengembalian::truncate();
        pengembaliandetail::truncate();

        return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    public function bukurak(){
        $jmldata=10;
        $limitdata=200;
        $cekdata=DB::table('bukurak')
        ->count();
        if($cekdata>$limitdata){
            return redirect()->back()->with('status','Gagal! Data  lebih dari '.$limitdata)->with('tipe','error')->with('icon','fas fa-trash');
        }

        bukurak::truncate();

        $faker = Faker::create('id_ID');
        for($i=0;$i<$jmldata;$i++){
            // 3. insert data siswa
                $nama='RAK '.($i+1);
                $kode='R'.($i+1);
                DB::table('bukurak')->insert([
                    'nama' => $nama,
                    'kode' => $kode,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
     }
     return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }
    public function buku(){
        $jmldata=20;
        $limitdata=200;



        $cekdata=DB::table('buku')
        ->count();
        if($cekdata>$limitdata){
            return redirect()->back()->with('status','Gagal! Data  lebih dari '.$limitdata)->with('tipe','error')->with('icon','fas fa-trash');
        }

        $faker = Faker::create('id_ID');
    //     for($i=0;$i<$jmldata;$i++){
    //         $nama=$faker->sentence($nbWords = 6, $variableNbWords = true);
    //         $pengarang=$faker->name;
    //         $penerbit=$faker->company;
    //         $nomerrak=$faker->numberBetween(1,10);
    //         $nomeridentitas=date('YmdHis').$i;
    //         // 3. insert data siswa
    //             $kode='R '.($i+1);
    //             DB::table('buku')->insert([
    //                 'nama' => $nama,
    //                 'kode' => $nomeridentitas,
    //                 'pengarang' => $pengarang,
    //                 'penerbit' => $penerbit,
    //                 'bahasa' => $faker->randomElement(['Indonesia', 'English']),
    //                 'tempatterbit' => $faker->country,
    //                 'tahunterbit' => $faker->numberBetween(1990,2021),
    //                 'bukurak_nama' => 'Rak '.$nomerrak,
    //                 'bukurak_kode' => 'R'.$nomerrak,
    //                 'bukukategori_nama' => 'Campur',
    //                 'bukukategori_ddc' => $faker->unique()->numberBetween(1000,2000),
    //                 'created_at' => Carbon::now(),
    //                 'updated_at' => Carbon::now()
    //             ]);
    //  }

    buku::truncate();

        // $jmlbuku = buku::count();
        $generatekodepanggil=Fungsi::autokodepanggilbuku(1);
        $kodepanggil = ''. str_pad($generatekodepanggil, 6, '0', STR_PAD_LEFT) ;

                    DB::table('buku')->insert([
                        'nama' => 'Sejarah Wali Songo [sumber elektronis]',
                        'id' => $kodepanggil,
                        'kode' => $kodepanggil,
                        'isbn' => '978-623-244-922-0',
                        'pengarang' => 'Zulham Farobi',
                        'penerbit' =>'Anak Hebat Indonesia',
                        'bahasa' => $faker->randomElement(['Indonesia', 'English']),
                        'tempatterbit' => $faker->country,
                        'tahunterbit' => $faker->numberBetween(1990,2021),
                        // 'bukurak_nama' => 'Rak '.$faker->numberBetween(1,10),
                        // 'bukurak_kode' => 'R'.$faker->numberBetween(1,10),
                        'bukukategori_nama' => 'Sejarah',
                        'bukukategori_ddc' => $faker->unique()->numberBetween(1000,2000),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);


        $generatekodepanggil=Fungsi::autokodepanggilbuku(1);
        $kodepanggil = ''. str_pad($generatekodepanggil, 6, '0', STR_PAD_LEFT) ;
                    DB::table('buku')->insert([
                        'nama' => 'Sejarah pemikiran ekonomi Islam',
                        'id' => $kodepanggil,
                        'kode' => $kodepanggil,
                        'isbn' => '978-623-312-462-1',
                        'pengarang' => 'Jajang W Mahri',
                        'penerbit' =>'Penerbit Universitas Terbuka',
                        'bahasa' => $faker->randomElement(['Indonesia', 'English']),
                        'tempatterbit' => $faker->country,
                        'tahunterbit' => $faker->numberBetween(1990,2021),
                        // 'bukurak_nama' => 'Rak '.$faker->numberBetween(1,10),
                        // 'bukurak_kode' => 'R'.$faker->numberBetween(1,10),
                        'bukukategori_nama' => 'Sejarah',
                        'bukukategori_ddc' => $faker->unique()->numberBetween(1000,2000),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);



        $generatekodepanggil=Fungsi::autokodepanggilbuku(1);
        $kodepanggil = ''. str_pad($generatekodepanggil, 6, '0', STR_PAD_LEFT) ;
                    DB::table('buku')->insert([
                        'nama' => 'Tegar dalam doa',
                        'id' => $kodepanggil,
                        'kode' => $kodepanggil,
                        'isbn' => '978-623-383-034-8',
                        'pengarang' => 'Fauzah ',
                        'penerbit' => 'CV Pustaka Mediaguru',
                        'bahasa' => $faker->randomElement(['Indonesia', 'English']),
                        'tempatterbit' => $faker->country,
                        'tahunterbit' => $faker->numberBetween(1990,2021),
                        // 'bukurak_nama' => 'Rak '.$faker->numberBetween(1,10),
                        // 'bukurak_kode' => 'R'.$faker->numberBetween(1,10),
                        'bukukategori_nama' => 'Agama',
                        'bukukategori_ddc' => $faker->unique()->numberBetween(1000,2000),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

        $generatekodepanggil=Fungsi::autokodepanggilbuku(1);
        $kodepanggil = ''. str_pad($generatekodepanggil, 6, '0', STR_PAD_LEFT) ;
                    DB::table('buku')->insert([
                        'nama' => 'Hikmah melangitkan doa',
                        'id' => $kodepanggil,
                        'kode' => $kodepanggil,
                        'isbn' => '978-623-6860-68-7',
                        'pengarang' => 'Neny Andriani ; editor, Diyah KN',
                        'penerbit' => 'CV. Bumi Pena',
                        'bahasa' => $faker->randomElement(['Indonesia', 'English']),
                        'tempatterbit' => $faker->country,
                        'tahunterbit' => $faker->numberBetween(1990,2021),
                        // 'bukurak_nama' => 'Rak '.$faker->numberBetween(1,10),
                        // 'bukurak_kode' => 'R'.$faker->numberBetween(1,10),
                        'bukukategori_nama' => 'Agama',
                        'bukukategori_ddc' => $faker->unique()->numberBetween(1000,2000),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    $generatekodepanggil=Fungsi::autokodepanggilbuku(1);
                    $kodepanggil = ''. str_pad($generatekodepanggil, 6, '0', STR_PAD_LEFT) ;

                    DB::table('buku')->insert([
                        'nama' => 'Pengantar jaringan komputer',
                        'id' => $kodepanggil,
                        'kode' => $kodepanggil,
                        'isbn' => '978-623-95937-6-6',
                        'pengarang' => 'Adi Wibowo',
                        'penerbit' => 'UMKO Publishing',
                        'bahasa' => $faker->randomElement(['Indonesia', 'English']),
                        'tempatterbit' => $faker->country,
                        'tahunterbit' => $faker->numberBetween(1990,2021),
                        // 'bukurak_nama' => 'Rak '.$faker->numberBetween(1,10),
                        // 'bukurak_kode' => 'R'.$faker->numberBetween(1,10),
                        'bukukategori_nama' => 'Teknologi',
                        'bukukategori_ddc' => $faker->unique()->numberBetween(1000,2000),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);


                    $generatekodepanggil=Fungsi::autokodepanggilbuku(1);
                    $kodepanggil = ''. str_pad($generatekodepanggil, 6, '0', STR_PAD_LEFT) ;
                    DB::table('buku')->insert([
                        'nama' => 'Metode penelitian pendidikan ilmu komputer',
                        'id' => $kodepanggil,
                        'kode' => $kodepanggil,
                        'isbn' => '978-623-6478-35-6',
                        'pengarang' => 'Wahyudin',
                        'penerbit' => 'Perkumpulan Rumah Cemerlang Indonesia',
                        'bahasa' => $faker->randomElement(['Indonesia', 'English']),
                        'tempatterbit' => $faker->country,
                        'tahunterbit' => $faker->numberBetween(1990,2021),
                        // 'bukurak_nama' => 'Rak '.$faker->numberBetween(1,10),
                        // 'bukurak_kode' => 'R'.$faker->numberBetween(1,10),
                        'bukukategori_nama' => 'Teknologi',
                        'bukukategori_ddc' => $faker->unique()->numberBetween(1000,2000),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

     return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }


    public function bukudetail(){
        $jmldata=5;
        $limitdata=200;

        $faker = Faker::create('id_ID');
        $databos=DB::table('buku')->get();
        foreach($databos as $db){

        for($i=0;$i<$jmldata;$i++){
            $nomeridentitas=date('YmdHis').$i;

            DB::table('bukudetail')->insert([
                'buku_nama' => $db->nama,
                'buku_kode' => $db->kode,
                'buku_kode' => $db->kode,
                'buku_pengarang' =>$db->pengarang,
                'buku_penerbit' => $db->penerbit,
                'buku_bahasa' => $db->bahasa,
                'buku_tempatterbit' =>$db->tempatterbit,
                'buku_tahunterbit' =>$db->tahunterbit,
                // 'bukurak_nama' =>$db->bukurak_nama,
                // 'bukurak_kode' => $db->bukurak_kode,
                'bukukategori_nama' => $db->bukukategori_nama,
                'bukukategori_ddc' => $db->bukukategori_ddc,
                'kondisi' => $faker->randomElement(['Bagus', 'Layak','Tidak Layak']),
                'status' => 'ada',
                // 'kodepanggil' => $db->kode.'-'.$nomeridentitas,
                'buku_isbn' =>$db->isbn,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        }
        return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }
    public function anggota(){
        $jmldata=20;
        $limitdata=200;

        $cekdata=DB::table('anggota')
        ->count();
        if($cekdata>$limitdata){
            return redirect()->back()->with('status','Gagal! Data  lebih dari '.$limitdata)->with('tipe','error')->with('icon','fas fa-trash');
        }

        $faker = Faker::create('id_ID');
        for($i=0;$i<$jmldata;$i++){
            $nama=$faker->name;
            $nomeridentitas=date('YmdHis').$i;
            // 3. insert data siswa
                $kode='R '.($i+1);
                DB::table('anggota')->insert([
                    'nama' => $nama,
                    'tipe' => $faker->randomElement(['Siswa', 'Umum']),
                    'tempatlahir' => $faker->country,
                    'tgllahir' => $faker->numberBetween(1990,2020).'-0'.$faker->numberBetween(1,9).'-'.$faker->numberBetween(10,29),
                    'alamat' => 'Desa '.$faker->address,
                    'nomeridentitas' => $nomeridentitas,
                    'sekolahasal' => $faker->randomElement(['Sumbersari', 'Jakarta','Surabaya','Blitar']),
                    'jk' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                    'telp' => $faker->e164PhoneNumber,
                    'agama' => $faker->randomElement(['Islam', 'Kristen','Hindu','Budha']),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
     }
     return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }
}
