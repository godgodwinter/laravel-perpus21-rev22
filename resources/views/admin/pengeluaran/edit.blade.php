@extends('layouts.layout1')
{{-- @extends('admin.pages.beranda') --}}


@section('title','pengeluaran')
@section('linkpages')
data{{ $pages }}
@endsection
@section('halaman','pengeluaran')

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


                <form action="/admin/{{ $pages }}/{{$datas->id}}" method="post">
                    @method('put')
                    @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> EDIT</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-12 col-12">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama"
                            class="form-control @error('nama') is-invalid @enderror" placeholder=""
                            value="{{$datas->nama}}" required>
                        @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-12 col-12">
                        <label>Kategori<code>*)</code></label>
                        <select class="form-control form-control-lg" required name="kategori_nama">
                            @if ($datas->kategori_nama)
                            <option>{{$datas->kategori_nama}}</option>
                            @endif
                            <option>Umum</option>
                            <option>Perbaikan</option>
                            <option>Kegiatan Sekolah</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6 col-6">
                        <label for="nominal">Nominal <code>*)</code></label>
                        <input type="number" name="nominal" id="nominal" class="form-control @error('nominal') is-invalid @enderror" value="{{$datas->nominal}}" required>
                        <input type="text" name="labelrupiah" min="0" id="labelrupiah" class="form-control-plaintext" readonly="" value="Rp 0,00" >
                        @error('nominal')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div>

                    <script type="text/javascript">

                        var rupiah = document.getElementById('nominal');
                        var labelrupiah = document.getElementById('labelrupiah');
                        rupiah.addEventListener('keyup', function(e){
                          // tambahkan 'Rp.' pada saat form di ketik
                          // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                          // rupiah.value = formatRupiah(this.value, 'Rp. ');
                          labelrupiah.value = formatRupiah(this.value, 'Rp. ');
                        });

                        /* Fungsi formatRupiah */
                        function formatRupiah(angka, prefix){
                          var number_string = angka.replace(/[^,\d]/g, '').toString(),
                          split   		= number_string.split(','),
                          sisa     		= split[0].length % 3,
                          rupiah     		= split[0].substr(0, sisa),
                          ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

                          // tambahkan titik jika yang di input sudah menjadi angka ribuan
                          if(ribuan){
                            separator = sisa ? '.' : '';
                            rupiah += separator + ribuan.join('.');
                          }

                          rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                          return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                        }
                      </script>
                    @if(old('tglbayar'))
                        @php
                            $tgl=$datas->tglbayar;
                        @endphp
                    @else
                    @php
                        $tgl=date('Y-m-d');
                    @endphp
                    @endif
                    <div class="form-group col-md-6 col-6">
                        <label>Tanggal Pengeluaran</label>
                        <input type="date" class="form-control" name="tglbayar" @error('tglbayar') is-invalid @enderror" value="{{ $tgl }}" >
                        @error('tglbayar')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                    </div>


                    <div class="form-group col-md-6 col-6">
                        <label for="catatan">Catatan <code></code></label>
                        <input type="text" name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" value="{{$datas->catatan}}" >
                        @error('catatan')<div class="invalid-feedback"> {{$message}}</div>
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
