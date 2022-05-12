@extends('layouts.layout1')
{{-- @extends('admin.pages.beranda') --}}


@section('title','bukudigital')
@section('linkpages')
data{{ $pages }}
@endsection
@section('halaman','bukudigital')

@section('csshere')
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
            $(function() {
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
            });
        </script>
@endif
@endsection


{{-- DATATABLE --}}
@section('headtable')
@endsection

@section('bodytable')
@endsection

@section('foottable')
@endsection

@section('container')
<!-- Main content -->
<section class="content">


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


    <div class="card-body">
        <div class="row">


    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">

            <div class="card-body">


                <form action="/admin/{{ $pages }}/{{$datas->id}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> EDIT</span>
            </div>
            <div class="card-body">
                <div class="row">     <div class="form-group col-md-12 col-12">
                    <label for="nama">Nama </label>
                    <input type="text" name="nama" id="nama"
                        class="form-control @error('nama') is-invalid @enderror" placeholder=""
                        value="{{ $datas->nama}}" required>
                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                </div>

                <div class="form-group col-md-12 col-12" id="tipe">
                    <label>Tipe<code>*)</code></label>
                    <select class="form-control form-control-lg @error('file') is-invalid @enderror @error('link') is-invalid @enderror" required name="tipe" id="tipeselect">

                        <option>{{ $datas->tipe}}</option>
                        <option>Link</option>
                        <option>Upload</option>
                    </select>
                    @error('link')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                    @error('file')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                </div>

                <script>
                    $(document).ready(function () {
                        var inputan=$('#inputan');
                        var tipe=$('#tipe');
                        var tipeselect=$('#tipeselect');
                        var inputanklink=`
                                <label for="link">Alamat file <code>*)</code></label>
                                <input type="text" name="link" id="link" class="form-control @error('link') is-invalid @enderror" value="{{$datas->link}}" required>
                                @error('link')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror

                            `;
                            var inputanupload=`


                                <label for="file">Pilih File <code></code></label>
                                <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" >
                                @error('file')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            `;

                            // inputan.html(inputanklink);

                            if (tipeselect.val()=='Link'){
                                inputan.html(inputanklink);
                            }else{
                                inputan.html(inputanupload);
                            }
                            tipeselect.change(function(e) {
                            if (tipeselect.val()=='Link'){
                                inputan.html(inputanklink);
                            }else{
                                inputan.html(inputanupload);
                            }
                        });


                    });
                </script>
                        <div class="form-group col-md-12 col-12" id="inputan">
                        </div>


                </div>


            </div>
            <div class=" text-right">

              <a href="{{ route('admin.'.$pages) }}" class="btn btn-icon btn-dark ml-3"> <i class="fas fa-backward"></i> Batal</a>
              <button class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>

            </div>
            <!-- /.card-body -->

        </div>
    </div>
    <!-- /.card -->

    </div>

</section>
<!-- /.content -->
@endsection
