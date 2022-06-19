@extends('layouts.layout1')
{{-- @extends('admin.pages.beranda') --}}


@section('title','Buku')
@section('linkpages')
data{{ $pages }}
@endsection
@section('halaman','kelas')

@section('csshere')
<style>
    .thumb-post img {
  object-fit: none; /* Do not scale the image */
  object-position: center; /* Center the image within the element */
  width: 100%;
  max-height: 250px;
  margin-bottom: 1rem;
}
</style>
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

    <!-- Default box -->

    <div class="card-body">
        <div class="row">



      <div class="col-8 col-md-8 col-lg-8">
        <div class="card">

              <div class="row">
            <div class="card-body">

                {{-- <span class="btn btn-icon btn-light ml-4"><i class="fas fa-feather"></i> EDIT {{ Str::upper($pages) }}</span> --}}

                <div class="form-group col-md-6 col-6 ml-6">
                <form method="post" action="/admin/databuku/upload/{{ $datas->id }}" enctype="multipart/form-data">
                  {{ csrf_field() }}



                    <div class="col-lg-8 d-flex align-items-stretch mb-4">

                @if($datas->gambar!='')
                {{-- <img alt="image" src="{{ asset("storage/") }}/{{ $du->profile_photo_path }}" class="rounded-circle profile-widget-picture" width="100px"> --}}

                <img alt="image" src="{{ asset("storage/") }}/{{ $datas->gambar }}"class="img-thumbnail thumb-post" width="200px">

                @else
                {{-- <img alt="image" src="https://ui-avatars.com/api/?name={{ $siswa->nama }}&color=7F9CF5&background=EBF4FF" class="rounded-circle profile-widget-picture" width="200px"> --}}
                <img alt="image" src="https://ui-avatars.com/api/?name={{ $datas->nama }}&color=7F9CF5&background=EBF4FF" class="img-thumbnail" width="200px">

                @endif


                 </div>



                {{-- <img alt="image" src="{{ asset("assets/") }}/img/products/product-3-50.png" class="rounded-circle profile-widget-picture"> --}}
                    <label for="file">Pilih Photo <code>*)</code></label>
                    <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" required>
                    @error('file')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror

                  <div class="card-footer text-right">

                    <button class="btn btn-success"><i class="fas fa-upload"></i> Simpan</button>
                  </form>

                    <form action="/admin/databuku/upload/{{ $datas->id }}" method="post" class="d-inline">
                      @method('delete')
                      @csrf
                      <input type="hidden" name="namaphoto" value="{{ $datas->gambar }}" required>
                      <button class="btn btn-icon btn-danger btn-md"
                          onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"><span
                              class="pcoded-micon"> <i class="fas fa-trash"></i> Hapus</span></button>
                  </form>
                  <a href="{{ route('admin.'.$pages) }}" class="btn btn-icon btn-dark ml-3"> <i class="fas fa-backward"></i> Batal</a>
                  </div>


                  <br>
                  <br>
                  <br>
                  {!! DNS1D::getBarcodeHTML($datas->kode, 'C39') !!}</br>
             {{-- {!! DNS1D::getBarcodeHTML($datas->kode, 'PHARMA') !!}</br> --}}

                </div>
                </div>

            </div>
            </div>
            </div>
            <div class="col-4 col-md-4 col-lg-4">
                <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(url('/buku/'.$datas->kode), 'QRCODE')}}" alt="barcode" width="50%"/>



              </div>



    <div class="col-12 col-md-12 col-lg-12">
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
                      <label for="nama">Judul Buku</label>
                      <input type="text" name="nama" id="nama"
                          class="form-control @error('nama') is-invalid @enderror" placeholder=""
                          value="{{$datas->nama}}" required>
                      @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                  </div>

                  <div class="form-group col-md-12 col-12">
                    <label for="pengarang">Pengarang</label>
                    <input type="text" name="pengarang" id="pengarang"
                        class="form-control @error('pengarang') is-invalid @enderror" placeholder=""
                        value="{{$datas->pengarang}}" required>
                    @error('pengarang')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                </div>
                  <div class="form-group col-md-12 col-12">
                    <label for="penerbit">Penerbit</label>
                    <input type="text" name="penerbit" id="penerbit"
                        class="form-control @error('penerbit') is-invalid @enderror" placeholder=""
                        value="{{$datas->penerbit}}" required>
                    @error('penerbit')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                </div>
                <div class="form-group col-md-12 col-12">
                  <label for="tempatterbit">Kota terbit</label>
                  <input type="text" name="tempatterbit" id="tempatterbit"
                      class="form-control @error('tempatterbit') is-invalid @enderror" placeholder=""
                      value="{{$datas->tempatterbit}}" required>
                  @error('tempatterbit')<div class="invalid-feedback"> {{$message}}</div>
                  @enderror
              </div>
                <div class="form-group col-md-12 col-12">
                    <label for="tahunterbit">Tanggal Terbit</label>
                    <input type="date" name="tahunterbit" id="tahunterbit"
                        class="form-control @error('tahunterbit') is-invalid @enderror" placeholder=""
                        value="{{$datas->tahunterbit}}" required>
                    @error('tahunterbit')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                </div>

                <div class="form-group col-md-12 col-12">
                    <label for="isbn">ISBN </label>
                    <input type="text" name="isbn" id="isbn"
                        class="form-control @error('isbn') is-invalid @enderror" placeholder=""
                        value="{{$datas->isbn}}" >
                    @error('isbn')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                </div>

                <div class="form-group col-md-12 col-12">
                    <label for="bahasa">Bahasa</label>
                    <input type="text" name="bahasa" id="bahasa"
                        class="form-control @error('bahasa') is-invalid @enderror" placeholder=""
                        value="{{$datas->bahasa}}" required>
                    @error('bahasa')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                </div>

                  {{-- <div class="form-group col-md-12 col-12">
                      <label>Tempat Rak Buku <code>*)</code></label>
                      <select class="form-control form-control-lg" required name="bukurak_nama">
                          @if ($datas->bukurak_nama)
                          <option>{{$datas->bukurak_nama}}</option>
                          @endif
                      @foreach ($bukurak as $t)
                          <option>{{ $t->nama }}</option>
                      @endforeach
                      </select>
                  </div>  --}}



                  <div class="form-group col-md-12 col-12">
                    <label>DDC  <code></code></label>
                    <input type="text" name="bukukategori_ddc" id="bukukategori_ddc"
                        class="form-control @error('bukukategori_ddc') is-invalid @enderror" placeholder=""
                        value="{{$datas->bukukategori_ddc}}" required>
                    @error('bukukategori_ddc')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                </div>

                <div class="form-group col-md-12 col-12">
                    <label>RAK  <code></code></label>
                    <input type="text" name="rak" id="rak"
                        class="form-control @error('rak') is-invalid @enderror" placeholder=""
                        value="{{$datas->rak}}" required>
                    @error('rak')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                </div>

                  <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Kode Buku</span>
                      </div>
                      <input type="number" name="kode" id="kode"
                      class="form-control @error('kode') is-invalid @enderror" placeholder="Otomatis di antara DDC"
                      value="{{$datas->kode}}" required min="1" readonly>
                  @error('kode')<div class="invalid-feedback"> {{$message}}</div>
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
                <!-- /.card-body -->

    <!-- /.card -->


</section>
<!-- /.content -->
@endsection
