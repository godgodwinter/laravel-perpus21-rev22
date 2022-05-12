@extends('layouts.layout1')
{{-- @extends('admin.pages.beranda') --}}


@section('title')
Buku <b>{{$buku->nama}}</b>
@endsection
@section('linkpages')
data{{ $pages }}
@endsection
@section('halaman','kelas')

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
</section>

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

    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
           
            <div class="card-body">

  
                <form action="/admin/buku/{{$buku->id}}/{{ $pages }}/{{$datas->id}}" method="post">
                    @method('put')
                    @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> EDIT</span>
            </div>
            <div class="card-body">
                <div class="row">
                      </div>
                   
                    <div class="form-group col-md-12 col-12">
                        <label>Kondisi<code>*)</code></label>
                        <select class="form-control form-control-lg" required name="kondisi">  
                            @if ($datas->kondisi)
                            <option>{{$datas->kondisi}}</option>                        
                            @endif
                            <option>Bagus</option>
                            <option>Layak</option>
                            <option>Tidak Layak</option>
                        </select>
                    </div> 

                    
                    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Kode Panggil</span>
                        </div>
                        <input type="number" name="kode" id="kode"
                        class="form-control @error('kode') is-invalid @enderror" placeholder="Otomatis dari Kode buku dan Iterasi detail buku"
                        value="{{old('kode')}}" required min="1" readonly>
                    @error('kode')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror


                </div>

                </div>
             
           
            </div>
            <div class=" text-right">
                
              <a href="{{ url('/admin/buku/'.$buku->id) }}/bukudetail" class="btn btn-icon btn-dark ml-3"> <i class="fas fa-backward"></i> Batal</a>
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
