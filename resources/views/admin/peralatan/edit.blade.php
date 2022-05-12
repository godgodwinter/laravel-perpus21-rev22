@extends('layouts.layout1')
{{-- @extends('admin.pages.beranda') --}}


@section('title','Peralatan')
@section('linkpages')
data{{ $pages }}
@endsection
@section('halaman','kelas')

@section('csshere')
@endsection

@section('jshere')
@endsection


@section('notif')

@if (session('tipe'))
@php
$tipe=session('tipe');
@endphp
@else
@php
$tipe='light';
@endphp
@endif

@if (session('icon'))
@php
$icon=session('icon');
@endphp
@else
@php
$icon='far fa-lightbulb';
@endphp
@endif

@php
$message=session('status');
@endphp
@if (session('status'))
<x-alert tipe="{{ $tipe }}" message="{{ $message }}" icon="{{ $icon }}" />

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

    <div class="col-12 col-md-12 col-lg-6">
        <div class="card">

            <div class="card-body">


                <form action="/admin/{{ $pages }}/{{$datas->id}}" method="post">
                    @method('put')
                    @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> EDIT</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-12 col-12">
                        <label for="nama">Nama @yield('title')</label>
                        <input type="text" name="nama" id="nama"
                            class="form-control @error('nama') is-invalid @enderror" placeholder=""
                            value="{{$datas->nama}}" required>
                        @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div>

                    {{-- <div class="form-group col-md-12 col-12">
                        <label>Kategori<code>*)</code></label>
                        <select class="form-control form-control-lg" required name="kategori_nama">
                            @if ($datas->kategori_nama)
                            <option>{{$datas->kategori_nama}}</option>
                            @endif
                            @foreach ($peralatankategori as $t)
                                <option>{{ $t->nama }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="form-group col-md-12 col-12">
                        <label>Kondisi<code>*)</code></label>
                        <select class="form-control form-control-lg" required name="kondisi">
                            @if ($datas->kondisi)
                            <option>{{$datas->kondisi}}</option>
                            @endif
                            @foreach ($kondisi as $t)
                                <option>{{ $t->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12 col-12">
                        <label>Tanggal Masuk</label>
                        <input type="date" class="form-control" name="tgl_masuk" @error('tgl_masuk') is-invalid @enderror" value="{{$datas->tgl_masuk}}" >
                        @error('tgl_masuk')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
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
