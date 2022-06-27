@extends('layouts.layout1')
{{-- @extends('admin.pages.beranda') --}}


@section('title','Peminjaman')
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

   localStorage.removeItem("daftarbuku");
                                       inputdaftarbuku.value = '';
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
                                    <a href="{{route('admin.buku')}}"><span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> Pilih
                                        Buku</span></a>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group">
                                           <label>Pilih Buku :</label>
                                            <select class="form-control form-control-md" id="tagsbuku" select2 select2-hidden-accessible  name="nomeridentitas" required>
                                            @php
                                            // $cekdataselect = DB::table('anggota')
                                            //     ->count();
                                            $dataselect=DB::table('buku')
                                                ->get();
                                                @endphp

                                            @foreach ($dataselect as $t)
                                                <option value="{{ $t->kode }}" >{{ $t->kode }} - {{ $t->nama }}</option>
                                            @endforeach
                                            </select>
                                        </div>
{{--
                                        <div class="form-group col-md-12 col-12">
                                            <label for="nama">Kode Panggil <code>*) Gunakan Barcode Scanner </code></label>
                                            <input type="text" name="nama" id="nama" class="form-control" placeholder=""
                                                required>
                                        </div> --}}

                                        <div class="form-group col-md-12 col-12">
                                            <label for="jml">Jumlah dipinjam<code>*)</code></label>
                                            <input type="number" name="jml" id="jml" class="form-control" placeholder="" value="" disabled
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

                               var values = $('#tagsbuku option[selected="true"]').map(function() { return $(this).val(); }).get();

                                    // you have no need of .trigger("change") if you dont want to trigger an event
                                    $('#tagsbuku').select2({
                                placeholder: "Pilih Buku"
                                });

                                // $(document).ready(function () {

                                    let maxdata = 0;
                                    let isbn = 0;
                                    let pengarang = 0;
                                    let penerbit = 0;
                                    let bukukategori_nama = 0;
                                    let kodebuku = 0;
                                    let nama = 0;
                                    let jml = 0;
                                    let tersedia = 0;


                                //jika dipilih maka akan mengubah inputan jumlah
                                $("select#tagsbuku").change(function(e){
                                    // var selectedText = $(this).find("option:selected").text();
                                    var selectedText = $(this).find("option:selected").val();
                                     kodebuku = $(this).find("option:selected").val();


                                    $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                                    'content')
                                            }
                                        });

                                    //periksa apakan ada buku tersedia


                                        // e.preventDefault();
                                        e.preventDefault();

                                        // var nama = $("input[name=nama]").val();

                                        var link = "/admin/peminjaman/periksabuku/" + selectedText;

                                        // alert(link);
                                        $.ajax({
                                            url: link,
                                            method: 'GET',
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                nama: 'a',
                                            },
                                                success: function (response) {
                                                    if (response.success) {
                                                        maxdata=response.message;
                                                        isbn=response.isbn;
                                                        bukukategori_nama=response.bukukategori_nama;
                                                        pengarang=response.pengarang;
                                                        penerbit=response.penerbit;
                                                        nama=response.nama;
                                                            // alert(response.message);
                                                            if(maxdata!=0){
                                                var jmlsebelumnya=0;
                                                tersedia=maxdata;
                                                for (i = 0; i < localStorage.length; i++)
                                                {
                                                    var obj = localStorage.getItem(localStorage.key(i));
                                                    var buku = JSON.parse(obj);
                                                    if(buku.kode==kodebuku){
                                                        // alert(buku.kode);
                                                        jmlsebelumnya=buku.jml;
                                                        tersedia=parseInt(maxdata)-parseInt(jmlsebelumnya);
                                                    }
                                                }
                                                if(tersedia>0){
                                                            $("input#jml").prop('disabled', false);
                                                            $("input#jml").prop('value', 1);
                                                            $("input#jml").prop('min', 1);
                                                            $("input#jml").prop('max', tersedia);
                                                        }else{
                                                            $("input#jml").prop('disabled', true);
                                                            $("input#jml").prop('value', 0);
                                                            $("input#jml").prop('min', 1);
                                                            $("input#jml").prop('max', tersedia);

                                                        }
                                                            }else{

                                                                //  maxdata = 0;
                                                                 isbn = 0;
                                                                 pengarang = 0;
                                                                 penerbit = 0;
                                                                 bukukategori_nama = 0;
                                                            $("input#jml").prop('disabled', true);
                                                            $("input#jml").prop('value', 0);
                                                            $("input#jml").prop('min', 0);
                                                            $("input#jml").prop('max', tersedia);

                                                                var Toast = Swal.mixin({
                                                                    toast: true,
                                                                    position: 'top-end',
                                                                    showConfirmButton: false,
                                                                    timer: 3000
                                                                });

                                                                Toast.fire({
                                                                    icon: 'error',
                                                                    title:
                                                                        'Buku tidak tersedia! atau telah dipinjam semua '
                                                                });
                                                            }
                                                    }
                                                }
                                            });


                                });

                                document.querySelector('#isikan').addEventListener('click', function (
                                        e) {

                                            jml = $("input[name=jml]").val();
                                            // jmlbuku=jml;
                                            if(parseInt(jml)>parseInt(tersedia)){
                                                var Toast = Swal.mixin({
                                                                    toast: true,
                                                                    position: 'top-end',
                                                                    showConfirmButton: false,
                                                                    timer: 3000
                                                                });

                                                                Toast.fire({
                                                                    icon: 'error',
                                                                    title:
                                                                        'Gagal, Jumlah melebihi stok yang tersedia! '
                                                                });
                                            }else{
                                                if(tersedia!=0){
                                                        //Jika buku masih tersedia
                                                    var jmlsebelumnya=0;
                                                    for (i = 0; i < localStorage.length; i++)
                                                    {
                                                        var obj = localStorage.getItem(localStorage.key(i));
                                                        var buku = JSON.parse(obj);
                                                        if(buku.kode==kodebuku){
                                                            // alert(buku.kode);
                                                            jmlsebelumnya=buku.jml;
                                                        }
                                                    }

                                                                        var buku_ = {};
                                                                                buku_.kode = kodebuku;
                                                                                buku_.nama = nama;
                                                                                buku_.pengarang = pengarang;
                                                                                buku_.penerbit = penerbit;
                                                                                buku_.bukukategori_nama = bukukategori_nama;
                                                                                buku_.jml = parseInt(jml)+parseInt(jmlsebelumnya);
                                                                                // var ItemId = "data-" + buku_.id;
                                                                                var ItemId = buku_.kode;
                                                                                localStorage.setItem(ItemId, JSON.stringify(buku_));




                                                    var Toast = Swal.mixin({
                                                                        toast: true,
                                                                        position: 'top-end',
                                                                        showConfirmButton: false,
                                                                        timer: 3000
                                                                    });

                                                                    Toast.fire({
                                                                        icon: 'success',
                                                                        title:
                                                                            'Buku berhasil ditambahkan! '
                                                                    });
                                                                $("input#jml").prop('disabled', true);






                                                    // var buku_ = {};
                                                    //                             buku_.kode = kodebuku;
                                                    //                             buku_.nama = nama;
                                                    //                             buku_.pengarang = pengarang;
                                                    //                             buku_.penerbit = penerbit;
                                                    //                             buku_.bukukategori_nama = bukukategori_nama;
                                                    //                             buku_.jml = jml;
                                                    //                             // var ItemId = "data-" + buku_.id;
                                                    //                             var ItemId = buku_.kode;
                                                    //                             localStorage.setItem(ItemId, JSON.stringify(buku_));


                                                    //                 daftarbuku.push(kodebuku);
                                                    //                 localStorage.setItem(
                                                    //                     'daftarbuku', JSON
                                                    //                     .stringify(
                                                    //                         daftarbuku));

                                                    location.reload();


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
                                                                        'Gagal, Buku tidak tersedia! atau telah dipinjam semua '
                                                                });

                                            }
                                        }
                                        });
                              </script>

                                {{-- </form> --}}
                                <script>
                                    $(function () {

                                                for (i = 0; i < localStorage.length; i++)
                                                {
                                                    var obj = localStorage.getItem(localStorage.key(i));
                                                    var buku = JSON.parse(obj);
                                                    // alert(buku.kode);
                                    //                 data_i = JSON.parse(localStorage.getItem(daftarbuku[i]));
                                    //         // data.i = JSON.parse(localStorage.getItem('data-'+1234));
                                            $("#forminputan").append(
                                            '<input name="daftarbuku" type="text" id="inputdaftarbuku" value="' +
                                            buku.kode + '" />');


                                        $("#tbody").append(
                                            '<tr id="'+buku.kode+'"><td class="text-center">'+(i+1)+'</td><td>'+buku.kode+'</td><td>'+buku.nama+'</td><td>'+buku.jml+' Buku</td><td>'+buku.bukukategori_nama+'</td><td><button class="btn btn-icon btn-danger btn-sm" id="hapusbuku'+buku.kode+'"><span class="pcoded-micon"> <i class="fas fa-trash"></i></span></button></td> </tr>');


                                            document.querySelector('#hapusbuku'+buku.kode).addEventListener('click', function (e) {
                                                // alert(buku.kode);
                                        // localStorage.removeItem("daftarbuku");
                                        localStorage.removeItem(buku.kode);

                                        // const index = daftarbuku.indexOf(buku.kode);
                                        // alert(index);

                                        // if (index > -1) {
                                        //     daftarbuku.splice(index, 1);
                                        // }
                                        // daftarbuku.splice(i);

                                        // $("#"+buku.kode).empty();
                                        // localStorage.setItem('daftarbuku',JSON.stringify(daftarbuku));

                                        location.reload();
                                    });
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

                                    });



                                    document.querySelector('#clear').addEventListener('click', function (e) {
                                        // localStorage.removeItem("daftarbuku");
                                        // inputdaftarbuku.value = '';
                                        localStorage.clear();
                                        $("#tbody").empty();
                                    });



                                </script>


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
                                            <th> Kode Buku </th>
                                            <th> Judul</th>
                                            <th> Jumlah</th>
                                            <th> Kategori</th>
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
