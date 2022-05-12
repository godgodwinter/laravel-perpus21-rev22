<?php

namespace App\Http\Controllers;

use App\Exports\exportanggota;
use App\Exports\Exportbuku;
use App\Exports\exportbukudetail;
use App\Exports\Exportbukudigital;
use App\Exports\Exportbukurak;
use App\Exports\exportpemasukan;
use App\Exports\exportpengeluaran;
use App\Exports\exportperalatan;
use App\Exports\exportusers;
use App\Imports\importanggota;
use App\Imports\Importbukurak;
use App\Imports\Importbuku;
use App\Imports\importbukudetail;
use App\Imports\Importbukudigital;
use App\Imports\Importpemasukan;
use App\Imports\Importpengeluaran;
use App\Imports\Importperalatan;
use App\Imports\importusers;
use App\Models\anggota;
use App\Models\buku;
use App\Models\settings;
use App\Models\siswa;
use App\Models\tagihanatur;
use App\Models\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class prosesController extends Controller
{

    public function exportbukurak()
    {
        $tgl = date("YmdHis");
        return Excel::download(new Exportbukurak, 'perpus-bukurak-' . $tgl . '.xlsx');
    }
    public function exportusers()
    {
        $tgl = date("YmdHis");
        return Excel::download(new exportusers, 'perpus-users-' . $tgl . '.xlsx');
    }

    public function exportbuku()
    {
        $tgl = date("YmdHis");
        return Excel::download(new Exportbuku, 'perpus-buku-' . $tgl . '.xlsx');
    }
    public function exportbukudigital()
    {
        $tgl = date("YmdHis");
        return Excel::download(new Exportbukudigital, 'perpus-bukudigital-' . $tgl . '.xlsx');
    }

    public function exportanggota()
    {
        $tgl = date("YmdHis");
        return Excel::download(new exportanggota, 'perpus-anggota-' . $tgl . '.xlsx');
    }
    public function exportperalatan()
    {
        $tgl = date("YmdHis");
        return Excel::download(new exportperalatan, 'perpus-peralatan-' . $tgl . '.xlsx');
    }
    public function exportbukudetail()
    {
        $tgl = date("YmdHis");
        return Excel::download(new exportbukudetail, 'perpus-bukudetail-' . $tgl . '.xlsx');
    }
    public function exportpemasukan()
    {
        $tgl = date("YmdHis");
        return Excel::download(new exportpemasukan, 'perpus-pemasukan-' . $tgl . '.xlsx');
    }
    public function exportpengeluaran()
    {
        $tgl = date("YmdHis");
        return Excel::download(new exportpengeluaran, 'perpus-pengeluaran-' . $tgl . '.xlsx');
    }

    public function importbukurak(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_temp', $nama_file);

        // import data
        Excel::import(new Importbukurak, public_path('/file_temp/' . $nama_file));

        // notifikasi dengan session
        // Session::flash('sukses','Data Siswa Berhasil Diimport!');

        // alihkan halaman kembali
        // return redirect('/siswa');
        return redirect()->back()->with('status', 'Data berhasil Diimport!')->with('tipe', 'success')->with('icon', 'fas fa-edit');
    }
    public function importbukudigital(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_temp', $nama_file);

        // import data
        Excel::import(new Importbukudigital, public_path('/file_temp/' . $nama_file));

        // notifikasi dengan session
        // Session::flash('sukses','Data Siswa Berhasil Diimport!');

        // alihkan halaman kembali
        // return redirect('/siswa');
        return redirect()->back()->with('status', 'Data berhasil Diimport!')->with('tipe', 'success')->with('icon', 'fas fa-edit');
    }

    public function importbuku(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_temp', $nama_file);

        // import data
        Excel::import(new Importbuku, public_path('/file_temp/' . $nama_file));

        // notifikasi dengan session
        // Session::flash('sukses','Data Siswa Berhasil Diimport!');

        // alihkan halaman kembali
        // return redirect('/siswa');
        return redirect()->back()->with('status', 'Data berhasil Diimport!')->with('tipe', 'success')->with('icon', 'fas fa-edit');
    }
    public function importusers(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_temp', $nama_file);

        // import data
        Excel::import(new importusers, public_path('/file_temp/' . $nama_file));

        // notifikasi dengan session
        // Session::flash('sukses','Data Siswa Berhasil Diimport!');

        // alihkan halaman kembali
        // return redirect('/siswa');
        return redirect()->back()->with('status', 'Data berhasil Diimport!')->with('tipe', 'success')->with('icon', 'fas fa-edit');
    }

    public function importanggota(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_temp', $nama_file);

        // import data
        Excel::import(new importanggota, public_path('/file_temp/' . $nama_file));

        // notifikasi dengan session
        // Session::flash('sukses','Data Siswa Berhasil Diimport!');

        // alihkan halaman kembali
        // return redirect('/siswa');
        return redirect()->back()->with('status', 'Data berhasil Diimport!')->with('tipe', 'success')->with('icon', 'fas fa-edit');
    }


    public function importbukudetail(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_temp', $nama_file);

        // import data
        Excel::import(new importbukudetail, public_path('/file_temp/' . $nama_file));

        // notifikasi dengan session
        // Session::flash('sukses','Data Siswa Berhasil Diimport!');

        // alihkan halaman kembali
        // return redirect('/siswa');
        return redirect()->back()->with('status', 'Data berhasil Diimport!')->with('tipe', 'success')->with('icon', 'fas fa-edit');
    }


    public function importpemasukan(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_temp', $nama_file);

        // import data
        Excel::import(new Importpemasukan, public_path('/file_temp/' . $nama_file));

        // notifikasi dengan session
        // Session::flash('sukses','Data Siswa Berhasil Diimport!');

        // alihkan halaman kembali
        // return redirect('/siswa');
        return redirect()->back()->with('status', 'Data berhasil Diimport!')->with('tipe', 'success')->with('icon', 'fas fa-edit');
    }

    public function importpengeluaran(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_temp', $nama_file);

        // import data
        Excel::import(new Importpengeluaran, public_path('/file_temp/' . $nama_file));

        // notifikasi dengan session
        // Session::flash('sukses','Data Siswa Berhasil Diimport!');

        // alihkan halaman kembali
        // return redirect('/siswa');
        return redirect()->back()->with('status', 'Data berhasil Diimport!')->with('tipe', 'success')->with('icon', 'fas fa-edit');
    }


    public function importperalatan(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_temp', $nama_file);

        // import data
        Excel::import(new Importperalatan, public_path('/file_temp/' . $nama_file));

        // notifikasi dengan session
        // Session::flash('sukses','Data Siswa Berhasil Diimport!');

        // alihkan halaman kembali
        // return redirect('/siswa');
        return redirect()->back()->with('status', 'Data berhasil Diimport!')->with('tipe', 'success')->with('icon', 'fas fa-edit');
    }

    public function cleartemp()
    {
        $file = new Filesystem;
        $file->cleanDirectory(public_path('file_temp'));

        // unlink(public_path('file_temp'));
        return redirect()->back()->with('status', 'Data berhasil di Hapus!')->with('tipe', 'success')->with('icon', 'fas fa-trash');
    }

    public function uploadbuku(Request $request, buku $buku)
    {
        // dd($request);
        $this->validate($request, [
            'file' => 'required',
        ]);

        $namafilebaru = $buku->kode;

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


        buku::where('kode', $buku->kode)
            ->update([
                'gambar' => "gambar/" . $namafilebaru . ".jpg",
                'updated_at' => date("Y-m-d H:i:s")
            ]);

        return redirect()->back()->with('status', 'Photo berhasil Diupload!')->with('tipe', 'success')->with('icon', 'fas fa-edit');
    }

    public function uploadbukudelete(Request $request, buku $buku)
    {

        // dd($request);
        // Storage::disk('public')->delete($request->namaphoto);
        // Storage::delete($request->namaphoto);
        $image_path = 'storage/' . $request->namaphoto;
        // $image_path = public_path().'/'.$request->namaphoto;
        unlink($image_path);
        buku::where('id', $buku->id)
            ->update([
                'gambar' => "",
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        return redirect()->back()->with('status', 'Photo berhasil Dihapus!')->with('tipe', 'danger')->with('icon', 'fas fa-trash');
    }


    public function uploadanggota(Request $request, anggota $anggota)
    {
        // dd($request);
        $this->validate($request, [
            'file' => 'required',
        ]);
        $namafilebaru = $anggota->nomeridentitas;

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


        anggota::where('nomeridentitas', $anggota->nomeridentitas)
            ->update([
                'gambar' => "gambar/" . $namafilebaru . ".jpg",
                'updated_at' => date("Y-m-d H:i:s")
            ]);

        return redirect()->back()->with('status', 'Photo berhasil Diupload!')->with('tipe', 'success')->with('icon', 'fas fa-edit');
    }

    public function uploadanggotadelete(Request $request, anggota $anggota)
    {

        // dd($request);
        // Storage::disk('public')->delete($request->namaphoto);
        $image_path = 'storage/' . $request->namaphoto;
        // $image_path = public_path().'/'.$request->namaphoto;
        unlink($image_path);
        anggota::where('id', $anggota->id)
            ->update([
                'gambar' => "",
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        return redirect()->back()->with('status', 'Photo berhasil Dihapus!')->with('tipe', 'danger')->with('icon', 'fas fa-trash');
    }
    public function uploadusers(Request $request, User $users)
    {
        // dd($request);
        $this->validate($request, [
            'file' => 'required',
        ]);
        $namafilebaru = $users->username;

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


        User::where('username', $users->username)
            ->update([
                'profile_photo_path' => "gambar/" . $namafilebaru . ".jpg",
                'updated_at' => date("Y-m-d H:i:s")
            ]);

        return redirect()->back()->with('status', 'Photo berhasil Diupload!')->with('tipe', 'success')->with('icon', 'fas fa-edit');
    }

    public function uploadusersdelete(Request $request, User $users)
    {

        // dd($request);
        Storage::disk('public')->delete($request->profile_photo_path);
        User::where('id', $users->id)
            ->update([
                'profile_photo_path' => "",
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        return redirect()->back()->with('status', 'Photo berhasil Dihapus!')->with('tipe', 'danger')->with('icon', 'fas fa-trash');
    }

    public function uploadlogo(Request $request, settings $settings)
    {
        // dd($request);
        $this->validate($request, [
            'file' => 'required',
        ]);
        $namafilebaru = 'sekolahlogo';

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
        $tujuan_upload = 'storage/gambar/logo';

        // upload file
        $file->move($tujuan_upload, "gambar/logo/" . $namafilebaru . ".jpg");


        settings::where('id', '1')
            ->update([
                'sekolahlogo' => "gambar/logo/" . $namafilebaru . ".jpg",
                'updated_at' => date("Y-m-d H:i:s")
            ]);

        return redirect()->back()->with('status', 'Photo berhasil Diupload!')->with('tipe', 'success')->with('icon', 'fas fa-edit');
    }


    public function uploadlogodelete(Request $request, settings $settings)
    {

        // dd($request);
        Storage::disk('public')->delete($request->namaphoto);
        settings::where('id', '1')
            ->update([
                'sekolahlogo' => "",
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        return redirect()->back()->with('status', 'Photo berhasil Dihapus!')->with('tipe', 'danger')->with('icon', 'fas fa-trash');
    }
}
