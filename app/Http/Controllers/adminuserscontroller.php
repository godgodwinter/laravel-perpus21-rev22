<?php

namespace App\Http\Controllers;

use App\Helpers\Fungsi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class adminuserscontroller extends Controller
{
    public function index(Request $request)
    {
        if($this->checkauth('admin')==='404'){
            return redirect(URL::to('/').'/404')->with('status','Halaman tidak ditemukan!')->with('tipe','danger')->with('icon','fas fa-trash');
        }

        #WAJIB
        $pages='users';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('users')
        ->orderBy('name','asc')
        ->paginate(Fungsi::paginationjml());

        // $userskategori = DB::table('kategori')->where('prefix','ddc')->get();

        return view('admin.users.index',compact('pages','datas','request'));
        // return view('admin.beranda');
    }

    public function cari(Request $request)
    {
        // dd($request);
        $cari=$request->cari;

        #WAJIB
        $pages='users';
        $jmldata='0';
        $datas='0';


    $datas=DB::table('users')
    // ->where('nis','like',"%".$cari."%")
    ->where('name','like',"%".$cari."%")
    ->orWhere('username','like',"%".$cari."%")
    ->orWhere('email','like',"%".$cari."%")
    ->orWhere('tipeuser','like',"%".$cari."%")
    ->paginate(Fungsi::paginationjml());



    // $bukurak = DB::table('bukurak')->get();
    // $bukukategori = DB::table('kategori')->where('prefix','ddc')->get();

    return view('admin.users.index',compact('pages','datas','request'));
    }
    public function store(Request $request)
    {
        // dd($request);
        // dd($request);
        $request->validate([
            'name'=>'required|unique:users,name',
            'username' => ['required', 'string', 'max:255', 'unique:users', 'regex:/^\S*$/u'],
            'email' => 'required|email|unique:users',
            'tipeuser'=>'required',
            'password' => 'min:3|required_with:password2|same:password2',
            'password2' => 'min:3',


        ],
        [
            'name.required'=>'Nama Harus diisi2',

        ]);

       DB::table('users')->insert(
        array(
               'name'     =>   $request->name,
               'tipeuser'     =>   $request->tipeuser,
               'username'     =>   $request->username,
               'email'     =>   $request->email,
               'password' => Hash::make($request->password),
               'nomerinduk'     =>   date('YmdHis'),
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s")
        ));

        return redirect()->back()->with('status','Data berhasil di tambahkan!')->with('tipe','success');

    }
    public function myprofile(Request $request)
    {
        $id=Auth::user()->username;
        $datas=DB::table('users')->where('username',$id)->first();
        // dd($datas);
        #WAJIB
        $pages='users';
        // $datas=$id;


        return view('admin.users.edit',compact('pages','datas','request'));
    }
    public function show(Request $request,User $id)
    {
        // dd($id);
        #WAJIB
        $pages='users';
        $datas=$id;


        return view('admin.users.edit',compact('pages','datas','request'));
    }
    public function proses_update($request,$datas)
    {
        if($request->email!==$datas->email){
            $request->validate([
                'email'=>'unique:users,email'
            ],
            [
                'email.unique'=>'Email sudah digunakan'


            ]);
        }

            if($request->username!==$datas->username){
                $request->validate([
                    'username'=>'unique:users,username'
                ],
                [
                    'username.unique'=>'Username sudah digunakan'


                ]);
        }


        if ($request->password==null){

            User::where('email',$datas->email)
            ->update([
                'name'     =>   $request->name,
                'tipeuser'     =>   $request->tipeuser,
                'username'     =>   $request->username,
                'email'     =>   $request->email,
                'nomerinduk'     =>   date('YmdHis'),
               'updated_at'=>date("Y-m-d H:i:s")
            ]);
        }else{
            User::where('email',$datas->email)
            ->update([
                'name'     =>   $request->name,
                'tipeuser'     =>   $request->tipeuser,
                'username'     =>   $request->username,
                'email'     =>   $request->email,
                'password' => Hash::make($request->password),
                'nomerinduk'     =>   date('YmdHis'),
               'updated_at'=>date("Y-m-d H:i:s")
            ]);

        }


    }

    public function update(Request $request, User $id)
    {
        $this->proses_update($request,$id);

            return redirect()->back()->with('status','Data berhasil diupdate!')->with('tipe','success')->with('icon','fas fa-edit');
    }

    public function destroy($id)
    {
        User::destroy($id);
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
        User::whereIn('id',$ids)->delete();


        // load ulang

        #WAJIB
        $pages='users';
        $jmldata='0';
        $datas='0';


        $datas=DB::table('anggota')
        ->orderBy('nama','asc')
        ->paginate(Fungsi::paginationjml());

        // $anggotakategori = DB::table('kategori')->where('prefix','ddc')->get();

        return view('admin.anggota.index',compact('pages','datas','request'));

    }
}
