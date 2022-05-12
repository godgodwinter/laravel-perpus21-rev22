<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\peralatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use PDF;

class adminperalatancontroller extends Controller
{
    public function index(Request $request)
    {
        if ($this->checkauth('admin') === '404') {
            return redirect(URL::to('/') . '/404')->with('status', 'Halaman tidak ditemukan!')->with('tipe', 'danger')->with('icon', 'fas fa-trash');
        }

        #WAJIB
        $pages = 'peralatan';
        $jmldata = '0';
        $datas = '0';


        $datas = DB::table('peralatan')
            ->orderBy('nama', 'asc')
            ->paginate(Fungsi::paginationjml());

        $peralatankategori = DB::table('kategori')->where('prefix', 'tipeperalatan')->get();
        $kondisi = DB::table('kategori')->where('prefix', 'kondisi')->get();

        return view('admin.peralatan.index', compact('pages', 'datas', 'peralatankategori', 'kondisi', 'request'));
        // return view('admin.beranda');
    }
    public function cari(Request $request)
    {
        // dd($request);
        $cari = $request->cari;

        #WAJIB
        $pages = 'peralatan';
        $jmldata = '0';
        $datas = '0';


        $datas = DB::table('peralatan')
            // ->where('nis','like',"%".$cari."%")
            ->where('nama', 'like', "%" . $cari . "%")
            ->orWhere('kondisi', 'like', "%" . $cari . "%")
            // ->orWhere('kategori_nama','like',"%".$cari."%")
            ->paginate(Fungsi::paginationjml());



        $peralatankategori = DB::table('kategori')->where('prefix', 'tipeperalatan')->get();
        $kondisi = DB::table('kategori')->where('prefix', 'kondisi')->get();

        return view('admin.peralatan.index', compact('pages', 'datas', 'peralatankategori', 'kondisi', 'request'));
    }
    public function store(Request $request)
    {
        // dd($request);
        // dd($request);
        $request->validate(
            [
                'nama' => 'required|unique:peralatan,nama',
                // 'kategori_nama' => 'required',
                'tgl_masuk' => 'required',
                'kondisi' => 'required',


            ],
            [
                'nama.required' => 'Nama Harus diisi',

            ]
        );

        DB::table('peralatan')->insert(
            array(
                'nama'     =>   $request->nama,
                // 'kategori_nama'     =>   $request->kategori_nama,
                'tgl_masuk'     =>   $request->tgl_masuk,
                'kondisi'     =>   $request->kondisi,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            )
        );

        return redirect()->back()->with('status', 'Data berhasil di tambahkan!')->with('tipe', 'success');
    }
    public function show(Request $request, peralatan $id)
    {
        // dd($id);
        #WAJIB
        $pages = 'peralatan';
        $datas = $id;


        $peralatankategori = DB::table('kategori')->where('prefix', 'tipeperalatan')->get();
        $kondisi = DB::table('kategori')->where('prefix', 'kondisi')->get();
        return view('admin.peralatan.edit', compact('pages', 'datas', 'peralatankategori', 'kondisi', 'request'));
    }
    public function proses_update($request, $datas)
    {
        if ($request->nama !== $datas->nama) {
            $request->validate(
                [
                    'nama' => 'unique:peralatan,nama'
                ],
                [
                    'nama.unique' => 'Nama sudah digunakan'


                ]
            );
        }



        peralatan::where('id', $datas->id)
            ->update([
                'nama'     =>   $request->nama,
                // 'kategori_nama'     =>   $request->kategori_nama,
                'tgl_masuk'     =>   $request->tgl_masuk,
                'kondisi'     =>   $request->kondisi,
                'updated_at' => date("Y-m-d H:i:s")
            ]);
    }

    public function update(Request $request, peralatan $id)
    {
        $this->proses_update($request, $id);

        return redirect()->back()->with('status', 'Data berhasil diupdate!')->with('tipe', 'success')->with('icon', 'fas fa-edit');
    }

    public function destroy($id)
    {
        peralatan::destroy($id);
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
        peralatan::whereIn('id', $ids)->delete();


        // load ulang

        #WAJIB
        $pages = 'peralatan';
        $jmldata = '0';
        $datas = '0';


        $datas = DB::table('peralatan')
            ->orderBy('nama', 'asc')
            ->paginate(Fungsi::paginationjml());

        $peralatankategori = DB::table('kategori')->where('prefix', 'tipeperalatan')->get();
        $kondisi = DB::table('kategori')->where('prefix', 'kondisi')->get();

        return view('admin.peralatan.index', compact('pages', 'datas', 'peralatankategori', 'kondisi', 'request'));
    }


    public function cetak(Request $request)
    {

        // dd($request->bln);
        $tgl = date("YmdHis");
        // dd($tgl);
        $bln = date("m", strtotime($request->bln));
        $year = date("Y", strtotime($request->bln));
        $blnthn = $request->bln;

        $datas = DB::table('peralatan')->orderBy('created_at', 'desc')->get();
        // dd($datas,$jml);

        $pdf = PDF::loadview('admin.peralatan.cetak', compact('datas'))->setPaper('a4', 'potrait');

        // \QrCode::size(500)
        //     ->format('png')
        //     ->generate('www.google.com', public_path('assets/img/qrcode.png'));

        return $pdf->stream('laporanperalatan' . $tgl . '-pdf');
    }
}
