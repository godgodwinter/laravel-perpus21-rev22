@extends('layouts.layout1')
{{-- @extends('admin.pages.beranda') --}}


@section('title','Pengaturan')
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
<!-- Main content -->
<section class="content">
  <div class="container-fluid">

      <!-- Default box -->

      <div class="col-12 col-md-12 col-lg-12">
          <div class="card">

              <div class="card-body">


                  <form action="/admin/{{ $pages }}/1" method="post">
                      @method('put')
                      @csrf
                      <div class="card-header">
                          <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> Pengaturan
                              Aplikasi</span>
                      </div>
                      <div class="card-body">
                          <div class="row">

                              <div class="form-group col-md-6 col-6">
                                  <label for="aplikasijudul">Judul Aplikasi</label>
                                  <input type="text" name="aplikasijudul" id="nama"
                                      class="form-control @error('nama') is-invalid @enderror" placeholder=""
                                      value="{{ Fungsi::aplikasijudul() }}" required>
                                  @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                                  @enderror
                              </div>

                              <div class="form-group col-md-6 col-6">
                                  <label for="aplikasijudulsingkat">Nama Aplikasi Singkat</label>
                                  <input type="text" name="aplikasijudulsingkat" id="aplikasijudulsingkat"
                                      class="form-control @error('aplikasijudulsingkat') is-invalid @enderror"
                                      placeholder="" value="{{ Fungsi::aplikasijudulsingkat() }}" required>
                                  @error('aplikasijudulsingkat')<div class="invalid-feedback"> {{$message}}</div>
                                  @enderror
                              </div>


                              <div class="form-group col-md-6 col-6">
                                  <label for="paginationjml">Pagination</label>
                                  <input type="number" name="paginationjml" id="paginationjml"
                                      class="form-control @error('paginationjml') is-invalid @enderror" placeholder=""
                                      value="{{ Fungsi::paginationjml() }}" required min="3" max="50">
                                  @error('paginationjml')<div class="invalid-feedback"> {{$message}}</div>
                                  @enderror
                              </div>

                              {{-- <div class="form-group col-md-6 col-6">
                                <label for="passdefaultadmin">Password Admin Default</label>
                                <input type="text" name="passdefaultadmin" id="passdefaultadmin"
                                    class="form-control @error('passdefaultadmin') is-invalid @enderror"
                                    placeholder="" value="{{ Fungsi::passdefaultadmin() }}" required>
                                @error('passdefaultadmin')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div> --}}


                            {{-- <div class="form-group col-md-6 col-6">
                              <label for="passdefaultpegawai">Password Pustakawan Default</label>
                              <input type="text" name="passdefaultpegawai" id="passdefaultpegawai"
                                  class="form-control @error('passdefaultpegawai') is-invalid @enderror"
                                  placeholder="" value="{{ Fungsi::passdefaultpegawai() }}" required>
                              @error('passdefaultpegawai')<div class="invalid-feedback"> {{$message}}</div>
                              @enderror
                          </div> --}}


                        <div class="form-group col-md-6 col-6">
                          <label for="defaultdenda"> Denda Terlambat /perhari</label>
                          <input type="text" name="defaultdenda" id="defaultdenda"
                              class="form-control @error('defaultdenda') is-invalid @enderror"
                              placeholder="" value="{{ Fungsi::defaultdenda() }}" required>
                          @error('defaultdenda')<div class="invalid-feedback"> {{$message}}</div>
                          @enderror
                      </div>


                      {{-- <div class="form-group col-md-6 col-6">
                        <label for="defaultminbayar">Minimal Nominal Pembayaran</label>
                        <input type="text" name="defaultminbayar" id="defaultminbayar"
                            class="form-control @error('defaultminbayar') is-invalid @enderror"
                            placeholder="" value="{{ Fungsi::defaultminbayar() }}" required min="1">
                        @error('defaultminbayar')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div> --}}


                    <div class="form-group col-md-6 col-6">
                      <label for="defaultmaxbukupinjam">Jumlah Maximal Buku dipinjam</label>
                      <input type="text" name="defaultmaxbukupinjam" id="defaultmaxbukupinjam"
                          class="form-control @error('defaultmaxbukupinjam') is-invalid @enderror"
                          placeholder="" value="{{ Fungsi::defaultmaxbukupinjam() }}" required min="1">
                      @error('defaultmaxbukupinjam')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                  </div>

                    <div class="form-group col-md-6 col-6">
                      <label for="defaultmaxharipinjam">Jumlah Maximal Hari Peminjaman</label>
                      <input type="text" name="defaultmaxharipinjam" id="defaultmaxharipinjam"
                          class="form-control @error('defaultmaxharipinjam') is-invalid @enderror"
                          placeholder="" value="{{ Fungsi::defaultmaxharipinjam() }}" required min="1">
                      @error('defaultmaxharipinjam')<div class="invalid-feedback"> {{$message}}</div>
                      @enderror
                  </div>

                          </div>


                      </div>



                      <div class="card-header">
                          <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> Pengaturan
                              Sekolah</span>
                      </div>
                      <div class="card-body">
                          <div class="row">
                              <div class="form-group col-md-6 col-6">
                                  <label for="sekolahnama">Nama Sekolah </label>
                                  <input type="text" name="sekolahnama" id="sekolahnama"
                                      class="form-control @error('sekolahnama') is-invalid @enderror" placeholder=""
                                      value="{{ Fungsi::sekolahnama() }}" required>
                                  @error('sekolahnama')<div class="invalid-feedback"> {{$message}}</div>
                                  @enderror
                              </div>


                              <div class="form-group col-md-6 col-6">
                                <label for="kop1">Nama Yayasan</label>
                                <input type="text" name="kop1" id="kop1"
                                    class="form-control @error('kop1') is-invalid @enderror" placeholder=""
                                    value="{{ Fungsi::kop1() }}" required>
                                @error('kop1')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6 col-6">
                                <label for="sekolahalamat">Alamat Sekolah</label>
                                <input type="text" name="sekolahalamat" id="sekolahalamat"
                                    class="form-control @error('sekolahalamat') is-invalid @enderror" placeholder=""
                                    value="{{ Fungsi::sekolahalamat() }}" required>
                                @error('sekolahalamat')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6 col-6">
                                <label for="kop3">Nama Daerah</label>
                                <input type="text" name="kop3" id="kop3"
                                    class="form-control @error('kop3') is-invalid @enderror" placeholder=""
                                    value="{{ Fungsi::kop3() }}" required>
                                @error('kop3')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div>

                              <div class="form-group col-md-6 col-6">
                                  <label for="sekolahtelp">No Telp Sekolah</label>
                                  <input type="text" name="sekolahtelp" id="sekolahtelp"
                                      class="form-control @error('sekolahtelp') is-invalid @enderror" placeholder=""
                                      value="{{ Fungsi::sekolahtelp() }}" required>
                                  @error('sekolahtelp')<div class="invalid-feedback"> {{$message}}</div>
                                  @enderror
                              </div>


                          <div class="form-group col-md-6 col-6">
                            <label for="sekolahttd"> Nama Tanda tangan 1</label>
                            <input type="text" name="sekolahttd" id="sekolahttd"
                                class="form-control @error('sekolahttd') is-invalid @enderror"
                                placeholder="" value="{{ Fungsi::sekolahttd() }}" >
                            @error('sekolahttd')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                          </div>


                          <div class=" text-right">

                            <a href="{{ route('admin.'.$pages) }}" class="btn btn-icon btn-dark ml-3"> <i
                                    class="fas fa-backward"></i> Batal</a>
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </form>

                      </div>

                      </div>
                    </div>

      {{-- <div class="col-12 col-md-12 col-lg-12">
        <div class="card">

            <div class="card-body">
                      <div class="card-body">

                              <div class="card-header">
                                  <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> Data Seeder
                                      dan Reset</span>
                              </div>

                              <div class="card-body ml-3">

                                <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">

                                  <form action="{{ route('reset.hard') }}" method="post" class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger btn-lg"
                                        onclick="return  confirm('Anda yakin melakukan Hard Reset aplikasi? Y/N')"  data-toggle="tooltip" data-placement="top" title="Untuk membersihkan semua data! Jadi aplikasi baru dengan data kosong!"><span
                                            class="pcoded-micon"> <i class="fas fa-power-off"></i> Hard reset aplikasi!</span></button>
                                  </form>

                                  <form action="{{ route('reset.default') }}" method="post" class="d-inline ml-1">
                                    @csrf
                                    <button class="btn btn-danger btn-lg"
                                        onclick="return  confirm('Anda yakin melakukan Hard Reset aplikasi? Y/N')"  data-toggle="tooltip" data-placement="top" title="Untuk membersihkan semua data! Jadi aplikasi baru dengan data kosong!"><span
                                            class="pcoded-micon"> <i class="fas fa-power-off"></i> Reset Settings!</span></button>
                                  </form>

                                  <button type="button" class="btn btn-icon btn-warning btn-md ml-1" data-toggle="modal"  data-placement="top" title="File sampah sisa export dan import! Agar tidak membebani server."  data-target="#cleartemp"><i class="fas fa-trash"></i>
                                    Hapus File Sampah
                                  </button>

                                </div>
                            </div>


                            <div class="card-body ml-3">

                                <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">

                                  <form action="{{ route('seeder.anggota') }}" method="post" class="d-inline">
                                    @csrf
                                    <button class="btn btn-info btn-lg"
                                        onclick="return  confirm('Anda yakin memasukan data palsu ? Y/N')"  data-toggle="tooltip" data-placement="top" title="Untuk membersihkan semua data! Jadi aplikasi baru dengan data kosong!"><span
                                            class="pcoded-micon"> <i class="fas fa-power-off"></i>Seeder Anggota!</span></button>
                                  </form>



                                  <form action="{{ route('seeder.buku') }}" method="post" class="d-inline ml-1">
                                    @csrf
                                    <button class="btn btn-info btn-lg"
                                        onclick="return  confirm('Anda yakin memasukan data palsu ? Y/N')"  data-toggle="tooltip" data-placement="top" title="Untuk membersihkan semua data! Jadi aplikasi baru dengan data kosong!"><span
                                            class="pcoded-micon"> <i class="fas fa-power-off"></i> Seeder Buku!</span></button>
                                  </form>

                                  <form action="{{ route('seeder.bukudetail') }}" method="post" class="d-inline ml-1">
                                    @csrf
                                    <button class="btn btn-info btn-lg"
                                        onclick="return  confirm('Anda yakin memasukan data palsu ? Y/N')"  data-toggle="tooltip" data-placement="top" title="Untuk membersihkan semua data! Jadi aplikasi baru dengan data kosong!"><span
                                            class="pcoded-micon"> <i class="fas fa-power-off"></i> Seeder BukuDetail!</span></button>
                                  </form>

                                </div>
                            </div>
                      </div>
              </div>
          </div>
      </div> --}}
    </section>

@endsection


@section('container-modals')

              <!-- Import Excel -->
              <div class="modal fade" id="cleartemp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form method="post" action="{{ route('cleartemp') }}" enctype="multipart/form-data">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Temporari</h5>
                      </div>
                      <div class="modal-body">

                        {{ csrf_field() }}

                        <label></label>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Hapus!</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
@endsection
