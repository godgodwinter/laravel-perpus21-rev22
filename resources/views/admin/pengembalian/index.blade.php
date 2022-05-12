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
   
        localStorage.clear(); 
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
        <div class="col-12 col-md-12 col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="row">


                        <div class="col-12 col-md-12 col-lg-12">
                                {{-- <form action="#" method="post">
                                @csrf --}}
                              

                                <form action="/admin/pengembalian/periksaanggota" method="post" id="formanggota">
                                    @csrf
                                    <div class="card-body">
                                        
                                        <div class="form-group">
                                            <label>Pilih Anggota :</label>
                                            <select class="form-control form-control-md" id="tags" select2 select2-hidden-accessible  name="nomeridentitas" required>
                                                <option value="" disabled selected>Pilih Anggota</option>
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
                                        
                                       
                                        
                                        <div class="row" id="forminputan">
                                            {{-- <div class="form-group col-md-12 col-12">
                                            <label for="nama">Kode Panggil</label>
                                            <input type="text" name="nama" id="nama"
                                                class="form-control" placeholder="" required>
                                        </div> --}}

                                        </div>

                                    </div>

                                    <div class="card-footer text-right">
                                        <button class="btn btn-success" id="kirimdata">Periksa</button>
                                    </div>
                                </form>
                                
                                  
                                <script type="text/javascript">
                                    var values = $('#tags option[selected="true"]').map(function() { return $(this).val(); }).get();
        
                                      // you have no need of .trigger("change") if you dont want to trigger an event
                                      $('#tags').select2({ 
                                    placeholder: "Pilih Anggota"
                                   });

                                   $("#tags").select2({
                                    theme: "classic"
                                    });

                                    
                                // $("select#tags").change(function(e){
                                //     var selectedText = $(this).find("option:selected").val();
                                //      kode = $(this).find("option:selected").val();
                                //     //  alert(kode);
                                //     $("form#formanggota").prop('action', '/admin/pengembalian/periksaanggota/'+kode);
                                // });
                                   </script>


                            </div>

                        <!-- /.card-body -->

                    </div>
                </div>
                <!-- /.card -->

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
