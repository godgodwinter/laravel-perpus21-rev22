@extends('layouts.layout1')
{{-- @extends('admin.pages.beranda') --}}


@section('title','Pengembalian')
@section('linkpages')
data{{ $pages }}
@endsection
@section('halaman','kelas')

@section('csshere')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

@section('jshere')
@endsection


@section('notif')


@php
$tipe=session('tipe');
$message=session('status');
@endphp
@if (session('status'))
<script>
    $(function () {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            icon: '{{$tipe}}',
            title: '{{$message}}'
        });
         
    @if((session('clearlocal')=='yes'))
   
   localStorage.removeItem("daftarkembali");
                                       inputdaftarkembali.value = '';
                                       $("#tbody").empty();
   @endif
   
    });
   

</script>
@endif
@endsection



@section('container')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@yield('title')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Beranda</a></li>
                    <li class="breadcrumb-item active">@yield('title')</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->

    <div class="row">
        <div class="col-12 col-md-12 col-lg-4">

            <div class="card">
                <div class="card-header">

                    {{-- <div class="card-body"> --}}
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">


                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                {{-- <form action="#" method="post">
                                @csrf --}}
                                <div class="card-header">
                                    <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> Pilih
                                        Buku</span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        

                                        <div class="form-group col-md-12 col-12">
                                            <label for="nama">Kode Panggil <code>*) Gunakan Barcode Scanner </code></label>
                                            <input type="text" name="nama" id="nama" class="form-control" placeholder=""
                                                required>
                                        </div>

                                    </div>

                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-danger" id="clear">Reset Data</button>
                                    <button class="btn btn-primary" id="isikan">Simpan</button>
                                </div>

                                <form action="/admin/{{ $pages }}" method="post">
                                    @csrf
                                    <div class="card-body">
                                        
                                        <div class="form-group">
                                            <label>Pilih Anggota :</label>
                                            <select class="form-control form-control-md" id="tags" select2 select2-hidden-accessible  name="nomeridentitas" required>
                                            @php
                                            // $cekdataselect = DB::table('anggota')
                                            //     ->count();
                                            $dataselect=DB::table('anggota')
                                                ->get();
                                                @endphp 
                                               
                                            @foreach ($dataselect as $t)
                                                <option value="{{ $t->nomeridentitas }}" >{{ $t->nomeridentitas }} - {{ $t->nama }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Pilih Jaminan :</label>
                                            <select class="form-control form-control-md" id="tags" select2 select2-hidden-accessible  name="jaminan_tipe" required>
                                          
                                                <option >Kartu Pelajar</option>
                                                <option >KTP</option>
                                                <option >SIM</option>
                                                <option >Lainya</option>
                                           
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-12 col-12">
                                            <label for="jaminan_nama">Identitas <code>*) Jika kosong maka akan menggunakan Nomer Identitas dari Anggota </code></label>
                                            <input type="text" name="jaminan_nama" id="jaminan_nama" class="form-control" placeholder=""
                                                >
                                        </div>
                                        <div class="row" id="forminputan">
                                            {{-- <div class="form-group col-md-12 col-12">
                                            <label for="nama">Kode Panggil</label>
                                            <input type="text" name="nama" id="nama"
                                                class="form-control" placeholder="" required>
                                        </div> --}}

                                        </div>

                                    </div>

                                    <div class="card-footer text-right">
                                        <button class="btn btn-success" id="kirimdata">Selesai</button>
                                    </div>
                                </form>
                                
                            <script type="text/javascript">
                                var values = $('#tags option[selected="true"]').map(function() { return $(this).val(); }).get();
    
                                  // you have no need of .trigger("change") if you dont want to trigger an event
                                  $('#tags').select2({ 
                                placeholder: "Pilih Anggota"
                               });
                              </script>

                                {{-- </form> --}}
                                <script>
                                    $(function () {
                                        let daftarkembali;
                                        if (localStorage.getItem('daftarkembali') === null) {
                                            daftarkembali = [];
                                        } else {
                                            daftarkembali = JSON.parse(localStorage.getItem('daftarkembali'));
                                        }

                                        var Toast = Swal.mixin({
                                            toast: true,
                                            position: 'top-end',
                                            showConfirmButton: false,
                                            timer: 3000
                                        });

                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Data berhasil dimuat!'
                                        });

                                        $("#forminputan").append(
                                            '<input name="daftarkembali" type="hidden" id="inputdaftarkembali" value="' +
                                            daftarkembali + '" />');

                                        var inputdaftarkembali = document.getElementById('inputdaftarkembali');
                                        
                                        var jmlbuku=daftarkembali.length;
                                        
                                        // $hasilperiksa=0;
                                        //                         for (let i = 0; i < daftarkembali2.length; i++) {
                                        //                                   if(daftarkembali2[i]==bukubaru.value){
                                        //                                       $hasilperiksa++;
                                        //                                   }else{
                                                                              
                                        //                                     // alert('belum ada');
                                        //                                   }  
                                        //                             }
                                        // alert(jmlbuku);

                                                                for (let i = 0; i < daftarkembali.length; i++) {
                                                                    
                                            data_i = JSON.parse(localStorage.getItem(daftarkembali[i]));
                                            // data.i = JSON.parse(localStorage.getItem('data-'+1234));
                                                                    
                                        $("#tbody").append(
                                            '<tr id="'+daftarkembali[i]+'"><td class="text-center">'+(i+1)+'</td><td>'+daftarkembali[i]+'</td><td>'+data_i.buku_nama+'</td><td>'+data_i.bukukategori_nama+'</td><td><button class="btn btn-icon btn-danger btn-sm" id="hapusbuku'+daftarkembali[i]+'"><span class="pcoded-micon"> <i class="fas fa-trash"></i></span></button></td> </tr>');


                                            document.querySelector('#hapusbuku'+daftarkembali[i]).addEventListener('click', function (e) {
                                                // alert(daftarkembali[i]);
                                        // localStorage.removeItem("daftarkembali");
                                        localStorage.removeItem(daftarkembali[i]);
                                        
                                        const index = daftarkembali.indexOf(daftarkembali[i]);
                                        // alert(index);

                                        if (index > -1) {
                                            daftarkembali.splice(index, 1);
                                        }
                                        // daftarkembali.splice(i);

                                        // $("#"+daftarkembali[i]).empty();
                                        localStorage.setItem('daftarkembali',JSON.stringify(daftarkembali));

                                        location.reload();
                                        // localStorage.removeItem(daftarkembali[i]);
                                        // inputdaftarkembali.value = '';
                                        // alert(daftarkembali[i]);
                                        // $("#tbody").empty();
                                    });

                                                                    }
                                    });

                                    $(document).ready(function () {

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                                    'content')
                                            }
                                        });


                                        document.querySelector('#isikan').addEventListener('click', function (
                                        e) {
                                            
                                    // if (localStorage)  
                                    // {  
                                    //     var buku_ = {};  
                                    //     buku_.Name = '123';  
                                    //     buku_.Age = 123;  
                                    //     buku_.Salary ='asd';  
                                    //     buku_.City = 'zxc';  
                                    //     var ItemId = "data-" + buku_.Name;  
                                    //     localStorage.setItem(ItemId, JSON.stringify(buku_));  

                                        
                                    //     var buku_ = {};  
                                    //     buku_.Name = '1234';  
                                    //     buku_.Age = 123;  
                                    //     buku_.Salary ='asd';  
                                    //     buku_.City = 'zxc';  
                                    //     var ItemId = "data-" + buku_.Name;  
                                    //     localStorage.setItem(ItemId, JSON.stringify(buku_));  
                                    // }  
                                    // else  
                                    // {  
                                    //     alert("OOPS! Your Browser Not Supporting LocalStorage Please Update It!")  
                                    // }  

                                            e.preventDefault();

                                            var nama = $("input[name=nama]").val();

                                            var link = "/admin/peminjaman/periksa/" + nama;

                                            $.ajax({
                                                url: link,
                                                method: 'GET',
                                                data: {
                                                    "_token": "{{ csrf_token() }}",
                                                    nama: nama,
                                                },
                                                success: function (response) {
                                                    if (response.success) {

                                                        // alert(response
                                                        //         .status
                                                        //         ) //Message come from controller
                                                        if (response
                                                            .status == 'dipinjam') {

                                                            let bukubaru = document
                                                                .querySelector('#nama');

                                                            let daftarkembali2;
                                                            if (localStorage.getItem(
                                                                    'daftarkembali') ===
                                                                null) {
                                                                daftarkembali2 = [];
                                                            } else {
                                                                daftarkembali2 = JSON.parse(
                                                                    localStorage
                                                                    .getItem(
                                                                        'daftarkembali'));
                                                            }

                                                            if (bukubaru.value != '') {
                                                                //periksa jika data sudah ada
                                                                $hasilperiksa=0;
                                                                for (let i = 0; i < daftarkembali2.length; i++) {
                                                                          if(daftarkembali2[i]==bukubaru.value){
                                                                              $hasilperiksa++;
                                                                          }else{
                                                                              
                                                                            // alert('belum ada');
                                                                          }  
                                                                    }

                                                                    if($hasilperiksa>0){
                                                                var Toast = Swal.mixin({
                                                                    toast: true,
                                                                    position: 'top-end',
                                                                    showConfirmButton: false,
                                                                    timer: 3000
                                                                });

                                                                Toast.fire({
                                                                    icon: 'error',
                                                                    title: 
                                                                        'Data sudah ditambahkan! '
                                                                });

                                                                    }else{
                                                                            // alert('belum ada');
                                                                            //buatobjek untuk doom
                                                                            var buku_ = {};  
                                                                            buku_.id = response.data;  
                                                                            buku_.buku_nama = response.buku_nama;   
                                                                            buku_.bukukategori_nama = response.bukukategori_nama;   
                                                                            // var ItemId = "data-" + buku_.id;  
                                                                            var ItemId = buku_.id;  
                                                                            localStorage.setItem(ItemId, JSON.stringify(buku_));  
                                                                            
                                            // data_i = JSON.parse(localStorage.getItem('data-'+123));

                                                                daftarkembali2.push(bukubaru
                                                                    .value);
                                                                localStorage.setItem(
                                                                    'daftarkembali', JSON
                                                                    .stringify(
                                                                        daftarkembali2));




                                                                var Toast = Swal.mixin({
                                                                    toast: true,
                                                                    position: 'top-end',
                                                                    showConfirmButton: false,
                                                                    timer: 3000
                                                                });

                                                                Toast.fire({
                                                                    icon: 'success',
                                                                    title: bukubaru
                                                                        .value +
                                                                        'Data berhasil ditambahkan!'
                                                                });

                                                                inputdaftarkembali.value =
                                                                    daftarkembali2;
                                                                    
                                             location.reload();

                                            // data.i = JSON.parse(localStorage.getItem('data-'+1234));
                                                                    
                                        $("#tbody").append(
                                            '<tr id="'+bukubaru.value+'"><td class="text-center">'+(daftarkembali2.length)+'</td><td>'+bukubaru.value+'</td><td>'+response.buku_nama+'</td><td>'+response.bukukategori_nama+'</td><td><button class="btn btn-icon btn-danger btn-sm" id="hapusbuku'+bukubaru.value+'"><span class="pcoded-micon"> <i class="fas fa-trash"></i></span></button></td> </tr>');
                                             i=(daftarkembali2.length-1);
                                            //  alert(bukubaru.value);
                                            // document.querySelector('#hapusbuku'+bukubaru.value).addEventListener('click', function (e) {
                                            //     // localStorage.removeItem("daftarkembali");
                                            //     localStorage.removeItem(bukubaru.value);
                                            //     $("#"+bukubaru.value).empty();
                                            //     daftarkembali2.splice(i);
                                            //     localStorage.setItem('daftarkembali',JSON.stringify(daftarkembali2));
        
                                            //     // localStorage.removeItem(daftarkembali[i]);
                                            //     // inputdaftarkembali.value = '';
                                            //     // alert(daftarkembali[i]);
                                            //     // $("#tbody").empty();
                                            // });
                                           

                                                                    }
                                                                // console.log(daftarkembali2);
                                                                // $("#forminputan").append('<input name="new_gallery" value="'+ daftarkembali +'" />');
                                                                // $(this).remove();

                                                            } else {
                                                                var Toast = Swal.mixin({
                                                                    toast: true,
                                                                    position: 'top-end',
                                                                    showConfirmButton: false,
                                                                    timer: 3000
                                                                });

                                                                Toast.fire({
                                                                    icon: 'error',
                                                                    title: 
                                                                        'Data gagal ditambahkan! atau Buku tidak sedang dipinjam atau sudah dikembalikan'
                                                                });

                                                            }
                                                        }else{
                                                            var Toast = Swal.mixin({
                                                                    toast: true,
                                                                    position: 'top-end',
                                                                    showConfirmButton: false,
                                                                    timer: 3000
                                                                });

                                                                Toast.fire({
                                                                    icon: 'error',
                                                                    title: 
                                                                        'Data gagal ditambahkan! atau Buku tidak sedang dipinjam atau sudah dikembalikan'
                                                                });
                                                        }

                                                    } else {
                                                        alert("Error")
                                                        // alert(response.message) //Message come from controller
                                                        
                                                        var Toast = Swal.mixin({
                                                                    toast: true,
                                                                    position: 'top-end',
                                                                    showConfirmButton: false,
                                                                    timer: 3000
                                                                });

                                                                Toast.fire({
                                                                    icon: 'error',
                                                                    title: 
                                                                        'Data gagal ditambahkan! atau Buku tidak ditemukan'
                                                                });
                                                    }
                                                },
                                                error: function (error) {

                                                    // alert(
                                                    //         'Gagal! Isi data terlebih dahulu!'
                                                    //         ) //Message come from controller
                                                    console.log(error)
                                                    
                                                    var Toast = Swal.mixin({
                                                                    toast: true,
                                                                    position: 'top-end',
                                                                    showConfirmButton: false,
                                                                    timer: 3000
                                                                });

                                                                Toast.fire({
                                                                    icon: 'error',
                                                                    title: 
                                                                        'Data gagal ditambahkan! atau Buku tidak ditemukan'
                                                                });
                                                }
                                            });


                                            // let pesan = document.querySelector('#pesan');		
                                            //     pesan.innerHTML = bukubaru.value + " berhasil disimpan";
                                        });

                                    });

                                    document.querySelector('#clear').addEventListener('click', function (e) {
                                        localStorage.removeItem("daftarkembali");
                                        inputdaftarkembali.value = '';
                                        $("#tbody").empty();
                                    });

                                

                                </script>


                                {{-- <script type="text/javascript">
                                    $(document).ready(function () {

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                                    'content')
                                            }
                                        });



                                        $("#isikan").click(function (e) {
                                            e.preventDefault();

                                            var nama = $("input[name=nama]").val();

                                            var link = "/admin/peminjaman/periksa/" + nama;

                                            $.ajax({
                                                url: link,
                                                method: 'GET',
                                                data: {
                                                    "_token": "{{ csrf_token() }}",
                                nama: nama,
                                },
                                success: function (response) {
                                if (response.success) {

                                alert(response
                                .message) //Message come from controller
                                } else {
                                alert("Error")
                                // alert(response.message) //Message come from controller
                                }
                                },
                                error: function (error) {

                                alert(
                                'Gagal! Angka harus 1-100!') //Message come from controller
                                console.log(error)
                                }
                                });


                                });

                                });

                                </script> --}}
                            </div>

                        </div>
                        <!-- /.card-body -->

                    </div>
                </div>
                <!-- /.card -->

            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-8">

            <div class="card">
                <div class="card-header">

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">



                    <form action="{{ route('admin.'.$pages.'.cari') }}" method="GET">

                        <div class="row">


                            <div class="form-group col-md-12 col-12 mt-1 text-right">

                                <button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal"
                                    data-target="#importExcel"><i class="fas fa-upload"></i>
                                    Import
                                </button>

                                <a href="/admin/@yield('linkpages')/export" type="submit" value="Import"
                                    class="btn btn-icon btn-primary btn-sm"><span class="pcoded-micon"> <i
                                            class="fas fa-download"></i> Export </span></a>
                            </div>






                        </div>

                    </form>
                    <div class="card-body -mt-5">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <thead>
                                        <tr>
                                            <th width="10%" class="text-center"> No</th>
                                            <th> Kode Panggil </th>
                                            <th> Judul Buku</th>
                                            <th> Kategori Buku</th>
                                            <th width="5%" class="text-center">Aksi</th>
                                        </tr>
                                </thead>
                                <tbody id="tbody">

                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-right">
                                @yield('foottable')
                        </div>
                </div>
                <!-- /.card-body -->

            </div>
        </div>

</section>
<!-- /.content -->
@endsection

@section('container-modals')

<!-- Import Excel -->
<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route($pages.'.import') }}" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                </div>
                <div class="modal-body">

                    {{ csrf_field() }}

                    <label>Pilih file excel(.xlsx)</label>
                    <div class="form-group">
                        <input type="file" name="file" required="required">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection
