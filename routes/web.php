<?php

use App\Helpers\Fungsi;
use App\Http\Controllers\pagesController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('landing');
// });


//halaman admin fixed
Route::group(['middleware' => ['auth:web', 'verified']], function () {

    //DASHBOARD-MENU
    Route::get('/dashboard', 'App\Http\Controllers\adminberandaController@index')->name('dashboard');



    Route::get('/admin/bukupemesanan', 'App\Http\Controllers\adminbukucontroller@bukuPemesanan')->name('admin.bukuPemesanan');
    Route::get('/admin/bukupemesanan/cari', 'App\Http\Controllers\adminbukucontroller@bukuPemesanancari')->name('admin.bukuPemesanan.cari');
    //buku-MENU
    Route::get('/admin/buku', 'App\Http\Controllers\adminbukucontroller@index')->name('admin.buku');
    Route::get('/admin/buku/cari', 'App\Http\Controllers\adminbukucontroller@cari')->name('admin.buku.cari');
    Route::post('/admin/buku', 'App\Http\Controllers\adminbukucontroller@store')->name('admin.buku.store');
    Route::get('/admin/buku/{id}', 'App\Http\Controllers\adminbukucontroller@show')->name('admin.buku.show');
    Route::put('/admin/buku/{id}', 'App\Http\Controllers\adminbukucontroller@update')->name('admin.buku.update');
    Route::delete('/admin/buku/{id}', 'App\Http\Controllers\adminbukucontroller@destroy')->name('admin.buku.destroy');
    Route::delete('/admin/databuku/multidel', 'App\Http\Controllers\adminbukucontroller@multidel')->name('admin.buku.multidel');


    //bukudetail-MENU
    Route::get('/admin/buku/{id}/bukudetail', 'App\Http\Controllers\adminbukudetailcontroller@index')->name('admin.buku.bukudetail');
    Route::get('/admin/buku/{id}/databukudetail/cari', 'App\Http\Controllers\adminbukudetailcontroller@cari')->name('admin.bukudetail.cari');
    Route::post('/admin/buku/{id}/bukudetail', 'App\Http\Controllers\adminbukudetailcontroller@store')->name('admin.bukudetail.store');
    Route::get('/admin/buku/{buku}/bukudetail/{id}', 'App\Http\Controllers\adminbukudetailcontroller@show')->name('admin.bukudetail.show');
    Route::put('/admin/buku/{buku}/bukudetail/{id}', 'App\Http\Controllers\adminbukudetailcontroller@update')->name('admin.bukudetail.update');
    Route::delete('/admin/buku/{buku}/bukudetail/{id}', 'App\Http\Controllers\adminbukudetailcontroller@destroy')->name('admin.bukudetail.destroy');
    Route::delete('/admin/bukudetail/multidel', 'App\Http\Controllers\adminbukudetailcontroller@multidel')->name('admin.bukudetail.multidel');


    //anggota-MENU
    Route::get('/admin/anggota', 'App\Http\Controllers\adminanggotacontroller@index')->name('admin.anggota');
    Route::get('/admin/anggota/cari', 'App\Http\Controllers\adminanggotacontroller@cari')->name('admin.anggota.cari');
    Route::post('/admin/anggota', 'App\Http\Controllers\adminanggotacontroller@store')->name('admin.anggota.store');
    Route::get('/admin/anggota/{id}', 'App\Http\Controllers\adminanggotacontroller@show')->name('admin.anggota.show');
    Route::put('/admin/anggota/{id}', 'App\Http\Controllers\adminanggotacontroller@update')->name('admin.anggota.update');
    Route::delete('/admin/anggota/{id}', 'App\Http\Controllers\adminanggotacontroller@destroy')->name('admin.anggota.destroy');
    Route::delete('/admin/dataanggota/multidel', 'App\Http\Controllers\adminanggotacontroller@multidel')->name('admin.anggota.multidel');

    //pengunjung-MENU
    Route::get('/admin/pengunjung', 'App\Http\Controllers\laporanController@pengunjung')->name('admin.laporan.pengunjung');
    Route::get('/admin/pengunjungapi', 'App\Http\Controllers\laporanController@pengunjungapi')->name('admin.laporan.pengunjungapi');

    //laporan-MENU
    Route::get('/admin/laporan/peminjaman', 'App\Http\Controllers\laporanController@laporanpeminjaman')->name('admin.laporan.peminjaman');
    Route::get('/admin/laporan/api/peminjaman', 'App\Http\Controllers\laporanController@apipeminjaman')->name('admin.laporan.api.peminjaman');
    Route::get('/admin/laporan/keuangan', 'App\Http\Controllers\laporanController@laporankeuangan')->name('admin.laporan.keuangan');
    Route::get('/admin/laporan/api/keuangan', 'App\Http\Controllers\laporanController@apikeuangan')->name('admin.laporan.api.keuangan');

    //chart-MENU
    Route::get('/admin/api/chart1', 'App\Http\Controllers\laporanController@apichart1')->name('admin.api.chart1');

    //users-MENU
    Route::get('/admin/users', 'App\Http\Controllers\adminuserscontroller@index')->name('admin.users');
    Route::get('/admin/users/cari', 'App\Http\Controllers\adminuserscontroller@cari')->name('admin.users.cari');
    Route::post('/admin/users', 'App\Http\Controllers\adminuserscontroller@store')->name('admin.users.store');
    Route::get('/admin/users/{id}', 'App\Http\Controllers\adminuserscontroller@show')->name('admin.users.show');
    Route::put('/admin/users/{id}', 'App\Http\Controllers\adminuserscontroller@update')->name('admin.users.update');
    Route::delete('/admin/users/{id}', 'App\Http\Controllers\adminuserscontroller@destroy')->name('admin.users.destroy');
    Route::delete('/admin/datausers/multidel', 'App\Http\Controllers\adminuserscontroller@multidel')->name('admin.users.multidel');
    Route::get('/admin/myprofile', 'App\Http\Controllers\adminuserscontroller@myprofile')->name('admin.users.myprofile');


    //peralatan-MENU
    Route::get('/admin/peralatan', 'App\Http\Controllers\adminperalatancontroller@index')->name('admin.peralatan');
    Route::get('/admin/peralatan/cari', 'App\Http\Controllers\adminperalatancontroller@cari')->name('admin.peralatan.cari');
    Route::post('/admin/peralatan', 'App\Http\Controllers\adminperalatancontroller@store')->name('admin.peralatan.store');
    Route::get('/admin/peralatan/{id}', 'App\Http\Controllers\adminperalatancontroller@show')->name('admin.peralatan.show');
    Route::put('/admin/peralatan/{id}', 'App\Http\Controllers\adminperalatancontroller@update')->name('admin.peralatan.update');
    Route::delete('/admin/peralatan/{id}', 'App\Http\Controllers\adminperalatancontroller@destroy')->name('admin.peralatan.destroy');
    Route::delete('/admin/dataperalatan/multidel', 'App\Http\Controllers\adminperalatancontroller@multidel')->name('admin.peralatan.multidel');


    //peminjaman-MENU
    Route::get('/admin/peminjaman', 'App\Http\Controllers\adminpeminjamancontroller@index')->name('admin.peminjaman');
    Route::get('/admin/pinjambuku', 'App\Http\Controllers\adminpeminjamancontroller@buku')->name('admin.peminjaman.buku');
    // Route::get('/admin/peminjaman/{id}', 'App\Http\Controllers\adminpeminjamancontroller@invoice')->name('admin.peminjaman.invoice');
    Route::get('/admin/peminjaman/cari', 'App\Http\Controllers\adminpeminjamancontroller@cari')->name('admin.peminjaman.cari');
    Route::post('/admin/peminjaman', 'App\Http\Controllers\adminpeminjamancontroller@store')->name('admin.peminjaman.store');
    Route::get('/admin/peminjaman/periksa/{id}', 'App\Http\Controllers\adminpeminjamancontroller@periksa')->name('admin.peminjaman.periksa');
    Route::get('/admin/peminjaman/periksabuku/{id}', 'App\Http\Controllers\adminpeminjamancontroller@periksabuku')->name('admin.peminjaman.periksabuku');
    Route::get('/admin/bukupinjam', 'App\Http\Controllers\adminpeminjamancontroller@indexbukupinjam')->name('admin.bukupinjam');
    Route::get('/admin/bukupinjam/cari', 'App\Http\Controllers\adminpeminjamancontroller@caribukupinjam')->name('admin.bukupinjam.cari');
    Route::get('/admin/bukupinjam/{id}/bukudetail', 'App\Http\Controllers\adminpeminjamancontroller@indexbukupinjamdetail')->name('admin.bukupinjam.bukudetail');
    Route::post('/admin/bukupinjam/{id}/bukudetail/cari', 'App\Http\Controllers\adminpeminjamancontroller@caribukupinjamdetail')->name('admin.bukupinjam.bukudetail.cari');


    //peminjaman-MENU
    Route::get('/admin/pengembalian', 'App\Http\Controllers\adminpengembaliancontroller@index')->name('admin.pengembalian');
    Route::post('/admin/pengembalian/kembelikan', 'App\Http\Controllers\adminpengembaliancontroller@kembalikan')->name('admin.pengembalian.kembalikan');
    Route::post('/admin/pengembalian/periksaanggota/', 'App\Http\Controllers\adminpengembaliancontroller@periksaanggota')->name('admin.pengembalian.periksaanggota');
    Route::get('/admin/pengembalian/periksaanggota/{id}', 'App\Http\Controllers\adminpengembaliancontroller@periksaanggotashow')->name('admin.pengembalian.periksaanggota.show');
    Route::get('/admin/kembalikanbuku', 'App\Http\Controllers\adminpeminjamancontroller@buku')->name('admin.kembalikan.buku');
    Route::get('/admin/pengembalian/cari', 'App\Http\Controllers\adminpengembaliancontroller@cari')->name('admin.pengembalian.cari');
    Route::post('/admin/pengembalian', 'App\Http\Controllers\adminpengembaliancontroller@store')->name('admin.pengembalian.store');
    Route::get('/admin/pengembalian/periksa/{id}', 'App\Http\Controllers\adminpengembaliancontroller@periksa')->name('admin.pengembalian.periksa');
    Route::get('/admin/bukukembali', 'App\Http\Controllers\adminpeminjamancontroller@indexbukukembali')->name('admin.bukukembali');
    Route::get('/admin/bukukembali/cari', 'App\Http\Controllers\adminpeminjamancontroller@caribukukembali')->name('admin.bukukembali.cari');
    Route::get('/admin/bukukembali/{id}/bukudetail', 'App\Http\Controllers\adminpeminjamancontroller@indexbukukembalidetail')->name('admin.bukukembali.bukudetail');
    Route::post('/admin/bukukembali/{id}/bukudetail/cari', 'App\Http\Controllers\adminpeminjamancontroller@caribukukembalidetail')->name('admin.bukukembali.bukudetail.cari');



    //pemasukan-MENU
    Route::get('/admin/pemasukan', 'App\Http\Controllers\adminpemasukancontroller@index')->name('admin.pemasukan');
    Route::get('/admin/pemasukan/cari', 'App\Http\Controllers\adminpemasukancontroller@cari')->name('admin.pemasukan.cari');
    Route::post('/admin/pemasukan', 'App\Http\Controllers\adminpemasukancontroller@store')->name('admin.pemasukan.store');
    Route::get('/admin/pemasukan/{id}', 'App\Http\Controllers\adminpemasukancontroller@show')->name('admin.pemasukan.show');
    Route::put('/admin/pemasukan/{id}', 'App\Http\Controllers\adminpemasukancontroller@update')->name('admin.pemasukan.update');
    Route::delete('/admin/pemasukan/{id}', 'App\Http\Controllers\adminpemasukancontroller@destroy')->name('admin.pemasukan.destroy');
    Route::delete('/admin/datapemasukan/multidel', 'App\Http\Controllers\adminpemasukancontroller@multidel')->name('admin.pemasukan.multidel');

    //bukudigital-MENU
    Route::get('/admin/bukudigital', 'App\Http\Controllers\adminbukudigitalcontroller@index')->name('admin.bukudigital');
    Route::get('/admin/bukudigital/cari', 'App\Http\Controllers\adminbukudigitalcontroller@cari')->name('admin.bukudigital.cari');
    Route::post('/admin/bukudigital', 'App\Http\Controllers\adminbukudigitalcontroller@store')->name('admin.bukudigital.store');
    Route::get('/admin/bukudigital/{id}', 'App\Http\Controllers\adminbukudigitalcontroller@show')->name('admin.bukudigital.show');
    Route::put('/admin/bukudigital/{id}', 'App\Http\Controllers\adminbukudigitalcontroller@update')->name('admin.bukudigital.update');
    Route::delete('/admin/bukudigital/{id}', 'App\Http\Controllers\adminbukudigitalcontroller@destroy')->name('admin.bukudigital.destroy');
    Route::delete('/admin/databukudigital/multidel', 'App\Http\Controllers\adminbukudigitalcontroller@multidel')->name('admin.bukudigital.multidel');


    //pengeluaran-MENU
    Route::get('/admin/pengeluaran', 'App\Http\Controllers\adminpengeluarancontroller@index')->name('admin.pengeluaran');
    Route::get('/admin/pengeluaran/cari', 'App\Http\Controllers\adminpengeluarancontroller@cari')->name('admin.pengeluaran.cari');
    Route::post('/admin/pengeluaran', 'App\Http\Controllers\adminpengeluarancontroller@store')->name('admin.pengeluaran.store');
    Route::get('/admin/pengeluaran/{id}', 'App\Http\Controllers\adminpengeluarancontroller@show')->name('admin.pengeluaran.show');
    Route::put('/admin/pengeluaran/{id}', 'App\Http\Controllers\adminpengeluarancontroller@update')->name('admin.pengeluaran.update');
    Route::delete('/admin/pengeluaran/{id}', 'App\Http\Controllers\adminpengeluarancontroller@destroy')->name('admin.pengeluaran.destroy');
    Route::delete('/admin/datapengeluaran/multidel', 'App\Http\Controllers\adminpengeluarancontroller@multidel')->name('admin.pengeluaran.multidel');

    //invoice
    Route::get('/admin/invoice/peminjaman', 'App\Http\Controllers\adminpeminjamancontroller@invoicepeminjaman')->name('admin.peminjaman.invoicepeminjaman');
    Route::post('/admin/invoice/peminjaman', 'App\Http\Controllers\adminpeminjamancontroller@invoicepeminjamanperiksa')->name('admin.peminjaman.invoicepeminjamanperiksa');
    Route::get('/admin/invoice/pengembalian', 'App\Http\Controllers\adminpengembaliancontroller@invoicepengembalian')->name('admin.pengembalian.invoicepengembalian');
    Route::post('/admin/invoice/pengembalian', 'App\Http\Controllers\adminpengembaliancontroller@invoicepengembalianperiksa')->name('admin.pengembalian.invoicepengembalianperiksa');
    Route::get('/admin/peminjaman/{id}', 'App\Http\Controllers\adminpeminjamancontroller@invoice')->name('admin.peminjaman.invoice');
    Route::get('/admin/pengembalian/{id}', 'App\Http\Controllers\adminpengembaliancontroller@invoice')->name('admin.pengembalian.invoice');
    Route::delete('/admin/peminjaman/{id}/destroy', 'App\Http\Controllers\adminpeminjamancontroller@destroy')->name('admin.peminjaman.invoice.destroy');
    Route::delete('/admin/pengembalian/{id}/destroy', 'App\Http\Controllers\adminpengembaliancontroller@destroy')->name('admin.pengembalian.invoice.destroy');


    //SETTINGS-MENU
    Route::get('/admin/settings', 'App\Http\Controllers\settingsController@index')->name('admin.settings');
    Route::put('/admin/settings/{id}', 'App\Http\Controllers\settingsController@update')->name('admin.settings.update');
    Route::post('admin/reset/hard', 'App\Http\Controllers\settingsController@hard')->name('reset.hard');
    Route::post('admin/reset/default', 'App\Http\Controllers\settingsController@default')->name('reset.default');
    Route::post('admin/seeder/anggota', 'App\Http\Controllers\settingsController@anggota')->name('seeder.anggota');
    // Route::post('admin/seeder/bukurak', 'App\Http\Controllers\settingsController@bukurak')->name('seeder.bukurak');
    Route::post('admin/seeder/buku', 'App\Http\Controllers\settingsController@buku')->name('seeder.buku');
    Route::post('admin/seeder/bukudetail', 'App\Http\Controllers\settingsController@bukudetail')->name('seeder.bukudetail');

    // ExportdanImport
    Route::get('admin/databukudigital/export', 'App\Http\Controllers\prosesController@exportbukudigital')->name('bukudigital.export');
    Route::post('admin/databukudigital/import', 'App\Http\Controllers\prosesController@importbukudigital')->name('bukudigital.import');
    Route::get('admin/databukurak/export', 'App\Http\Controllers\prosesController@exportbukurak')->name('bukurak.export');
    Route::post('admin/databukurak/import', 'App\Http\Controllers\prosesController@importbukurak')->name('bukurak.import');
    Route::get('admin/databuku/export', 'App\Http\Controllers\prosesController@exportbuku')->name('buku.export');
    Route::post('admin/databuku/import', 'App\Http\Controllers\prosesController@importbuku')->name('buku.import');
    Route::get('admin/databukudetail/export', 'App\Http\Controllers\prosesController@exportbukudetail')->name('bukudetail.export');
    Route::post('admin/databukudetail/import', 'App\Http\Controllers\prosesController@importbukudetail')->name('bukudetail.import');
    Route::get('admin/dataanggota/export', 'App\Http\Controllers\prosesController@exportanggota')->name('anggota.export');
    Route::post('admin/dataanggota/import', 'App\Http\Controllers\prosesController@importanggota')->name('anggota.import');
    Route::get('admin/dataperalatan/export', 'App\Http\Controllers\prosesController@exportperalatan')->name('peralatan.export');
    Route::post('admin/dataperalatan/import', 'App\Http\Controllers\prosesController@importperalatan')->name('peralatan.import');
    Route::get('admin/datapeminjaman/export', 'App\Http\Controllers\prosesController@exportpeminjaman')->name('peminjaman.export');
    Route::post('admin/datapeminjaman/import', 'App\Http\Controllers\prosesController@importpeminjaman')->name('peminjaman.import');
    Route::get('admin/datapengembalian/export', 'App\Http\Controllers\prosesController@exportpengembalian')->name('pengembalian.export');
    Route::post('admin/datapengembalian/import', 'App\Http\Controllers\prosesController@importpengembalian')->name('pengembalian.import');
    Route::get('admin/datapemasukan/export', 'App\Http\Controllers\prosesController@exportpemasukan')->name('pemasukan.export');
    Route::post('admin/datapemasukan/import', 'App\Http\Controllers\prosesController@importpemasukan')->name('pemasukan.import');
    Route::get('admin/datapengeluaran/export', 'App\Http\Controllers\prosesController@exportpengeluaran')->name('pengeluaran.export');
    Route::post('admin/datapengeluaran/import', 'App\Http\Controllers\prosesController@importpengeluaran')->name('pengeluaran.import');
    Route::get('admin/datausers/export', 'App\Http\Controllers\prosesController@exportusers')->name('users.export');
    Route::post('admin/datausers/import', 'App\Http\Controllers\prosesController@importusers')->name('users.import');

    Route::get('admin/testing/qr', 'App\Http\Controllers\laporanController@qr')->name('testing.qr');

    Route::get('/barcode', [pagesController::class, 'barcode'])->name('barcode.index');

    Route::post('/admin/settings/cleartemp', 'App\Http\Controllers\prosesController@cleartemp')->name('cleartemp');
    //upload
    Route::post('admin/databuku/upload/{buku}', 'App\Http\Controllers\prosesController@uploadbuku')->name('admin.buku.upload');
    Route::delete('admin/databuku/upload/{buku}', 'App\Http\Controllers\prosesController@uploadbukudelete')->name('admin.buku.upload.delete');
    Route::post('admin/dataanggota/upload/{anggota}', 'App\Http\Controllers\prosesController@uploadanggota')->name('admin.anggota.upload');
    Route::delete('admin/dataanggota/upload/{anggota}', 'App\Http\Controllers\prosesController@uploadanggotadelete')->name('admin.anggota.upload.delete');
    Route::post('admin/datausers/upload/{users}', 'App\Http\Controllers\prosesController@uploadusers')->name('admin.users.upload');
    Route::delete('admin/datausers/upload/{users}', 'App\Http\Controllers\prosesController@uploadusersdelete')->name('admin.users.upload.delete');


    Route::get('pengunjung/cetak', 'App\Http\Controllers\laporanController@pengunjungcetak')->name('pengunjung.cetak');
    Route::get('admin/dataperalatan/cetak', 'App\Http\Controllers\adminperalatancontroller@cetak')->name('peralatan.cetak');
    Route::get('admin/datakeuangan/cetak/{bln}', 'App\Http\Controllers\laporanController@cetakkeuangan')->name('keuangan.cetak');
    Route::get('admin/datapeminjaman/cetak/{bln}/{status}/{cari}', 'App\Http\Controllers\laporanController@cetakpeminjaman')->name('peminjaman.cetak');
    Route::get('admin/databuku/cetak/checked', 'App\Http\Controllers\adminbukucontroller@cetakchecked')->name('buku.checked.cetak');

    Route::get('/pustakawan/buku', 'App\Http\Controllers\pustakawancontroller@buku')->name('pustakawan.buku');

    //pustakawan
    Route::get('/pustakawan/buku', 'App\Http\Controllers\pustakawancontroller@buku')->name('pustakawan.buku');
    Route::get('/pustakawan/buku/cari', 'App\Http\Controllers\pustakawancontroller@bukucari')->name('pustakawan.buku.cari');
    Route::get('/pustakawan/buku/{id}/bukudetail', 'App\Http\Controllers\pustakawancontroller@bukudetail')->name('pustakawan.buku.bukudetail');
    Route::get('/pustakawan/buku/{id}/databukudetail/cari', 'App\Http\Controllers\pustakawancontroller@bukudetailcari')->name('pustakawan.bukudetail.cari');
    Route::get('/pustakawan/peminjaman', 'App\Http\Controllers\pustakawancontroller@peminjaman')->name('pustakawan.peminjaman');
    Route::get('/pustakawan/pengembalian', 'App\Http\Controllers\pustakawancontroller@pengembalian')->name('pustakawan.pengembalian');
});

// SIAKAD-MENU-raport
Route::get('raport', 'App\Http\Controllers\raportcontroller@index')->name('raport');
Route::get('raport/{nis}', 'App\Http\Controllers\raportcontroller@show')->name('raport.show');
Route::get('raport/{nis}/cetak', 'App\Http\Controllers\raportcontroller@cetak')->name('raport.cetak');

Route::get('/404', 'App\Http\Controllers\adminberandaController@notfound');
Route::get('/tail', 'App\Http\Controllers\pagesController@tail');
Route::get('/landing', 'App\Http\Controllers\pagesController@landing');
// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');


// HALAMANLUAR-raport
Route::get('/', 'App\Http\Controllers\pagesController@katalog')->name('homeluar');
Route::get('cari', 'App\Http\Controllers\pagesController@cari')->name('cari');
Route::get('cari/proses', 'App\Http\Controllers\pagesController@cariproses')->name('cari.proses');
Route::get('katalog', 'App\Http\Controllers\pagesController@katalog')->name('katalog');
Route::get('katalog/proses', 'App\Http\Controllers\pagesController@katalogproses')->name('katalog.proses');
Route::get('buku/{id}', 'App\Http\Controllers\pagesController@buku')->name('buku');
Route::get('anggota', 'App\Http\Controllers\pagesController@anggota')->name('anggota');
Route::get('anggota/proses', 'App\Http\Controllers\pagesController@anggotaproses')->name('anggota.proses');
Route::get('anggota/anggotacektanggungan', 'App\Http\Controllers\pagesController@anggotacektanggungan')->name('anggota.anggotacektanggungan');
Route::get('anggotashow/{id}', 'App\Http\Controllers\pagesController@anggotashow')->name('anggotashow');
Route::get('invoice/{id}', 'App\Http\Controllers\pagesController@invoice')->name('invoice');

Route::get('pengunjung', 'App\Http\Controllers\pagesController@pengunjung')->name('pengunjung');
Route::get('pengunjung/proses', 'App\Http\Controllers\pagesController@pengunjungproses')->name('pengunjung.proses');

Route::get('cetak/peminjamanshow/{id}', 'App\Http\Controllers\cetakController@peminjamanshow')->name('cetak.peminjaman.show');
Route::get('cetak/pengembalianshow/{id}', 'App\Http\Controllers\cetakController@pengembalianshow')->name('cetak.pengembalian.show');
