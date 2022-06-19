@extends('layouts.layout1')
{{-- @extends('admin.pages.beranda') --}}


@section('title','Pemasukan')
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
<tr>
    <th width="10%" class="text-center">
        <input type="checkbox" id="chkCheckAll"> <label for="chkCheckAll"> All</label></th>
    <th> Nama  </th>
    <th> Kategori</th>
    <th> Tanggal Masuk</th>
    <th> Nominal</th>
    <th width="200px" class="text-center">Aksi</th>
</tr>
@endsection

@section('bodytable')
<script>
    // console.log('asdad');
    $().jquery;
    $.fn.jquery;
    $(function (e) {
        $("#chkCheckAll").click(function () {
            $(".checkBoxClass").prop('checked', $(this).prop('checked'));
        })

        $("#deleteAllSelectedRecord").click(function (e) {
            e.preventDefault();
            var allids = [];
            $("input:checkbox[name=ids]:checked").each(function () {
                allids.push($(this).val());
            });

            $.ajax({
                url: "{{ route('admin.pemasukan.multidel') }}",
                type: "DELETE",
                data: {
                    _token: $("input[name=_token]").val(),
                    ids: allids
                },
                success: function (response) {
                    $.each(allids, function ($key, val) {
                        $("#sid" + val).remove();
                    })
                }
            });

        })

    });

</script>
@foreach ($datas as $data)
<tr id="sid{{ $data->id }}">
    <td class="text-center"> <input type="checkbox" name="ids" class="checkBoxClass " value="{{ $data->id }}">
        {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
    <td>{{ $data->nama }}</td>
    <td>{{ $data->kategori_nama }}</td>
    <td>{{ Fungsi::tanggalindo($data->tglbayar) }}</td>
    <td>{{ Fungsi::rupiah($data->nominal) }}</td>

    <td class="text-center">
        {{-- <a class="btn btn-icon btn-secondary btn-sm " href="{{ url('/admin/inputnilai/kelas') }}/{{ $data->id }}"
        data-toggle="tooltip" data-placement="top" title="Lihat selengkapnya!"> <i
            class="fas fa-angle-double-right"></i> </a> --}}
        <x-button-edit link="/admin/{{ $pages }}/{{$data->id}}" />
        <x-button-delete link="/admin/{{ $pages }}/{{$data->id}}" />
    </td>
</tr>
@endforeach

@if ($dataDenda)
<tr >
    <td class="text-center">
        {{ ((count($datas)+1)) }} </td>
    <td>Total Denda
        {{-- Bulan --}}
         {{-- {{ Fungsi::tanggalindonotgl($dataDenda->tglbayar) }} --}}
    </td>
    <td>Denda</td>
    <td>
        Semua
        {{-- {{ Fungsi::tanggalindonotgl($dataDenda->tglbayar) }} --}}

    </td>
    <td>{{ Fungsi::rupiah($dataDenda->nominal) }}</td>

    <td class="text-center">

    </td>
</tr>

@endif

<tr>
    <td class="text-left" colspan="6">
        <a href="#" class="btn btn-sm  btn-danger" id="deleteAllSelectedRecord"
            onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"><i class="fas fa-trash"></i> Hapus
            Terpilih</a></td>
</tr>

@endsection

@section('foottable')

@php
  $cari=$request->cari;
@endphp
{{ $datas->onEachSide(1)
    ->appends(['cari'=>$cari])
    ->links() }}
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><i class="far fa-file"></i> Halaman ke-{{ $datas->currentPage() }}</li>
        <li class="breadcrumb-item"><i class="fas fa-paste"></i> {{ $datas->total() }} Total Data</li>
        <li class="breadcrumb-item active" aria-current="page"><i class="far fa-copy"></i> {{ $datas->perPage() }} Data
            Perhalaman</li>
    </ol>
</nav>
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



                        <form action="{{ route('admin.'.$pages.'.cari') }}" method="GET">

                    <div class="row">

                    <div class="form-group col-md-4 col-4 mt-1 text-right">
                                    <input type="text" name="cari" id="cari"
                                        class="form-control form-control-sm @error('cari') is-invalid @enderror"
                                        value="{{$request->cari}}" placeholder="Cari...">
                                    @error('cari')<div class="invalid-feedback"> {{$message}}</div>
                                    @enderror
                    </div>



                    <div class="form-group col-md-4 col-4 mt-1 text-left">


                        <button type="submit" value="CARI" class="btn btn-icon btn-info btn-sm mt-0"><span
                            class="pcoded-micon"> <i class="fas fa-search"></i> Cari</span></button>

                    </div>
                    <div class="form-group col-md-4 col-4 mt-1 text-right">

                        <button type="button" class="btn btn-icon btn-primary btn-sm" data-toggle="modal"
                        data-target="#add"><i class="fas fa-plus"></i>
                        Tambah
                        </button>

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
                    <x-layout-table2 pages="{{ $pages }}" pagination="{{ $datas->perPage() }}" />
                </div>
                <!-- /.card-body -->

            </div>
        </div>
    </div>



</section>
<!-- /.content -->
@endsection

@section('container-modals')


              <!--Tambah -->
              <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  {{-- <form method="post" action="{{ route($pages.'.import') }}" enctype="multipart/form-data"> --}}
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                      </div>
                      <div class="modal-body">

                        <div class="col-12 col-md-12 col-lg-12">
                        <div class="card-body">
                        <div class="row">
                            <form action="/admin/{{ $pages }}" method="post" enctype="multipart/form-data">
                                @csrf


                                <div class="form-group col-md-12 col-12">
                                    <label for="nama">Nama </label>
                                    <input type="text" name="nama" id="nama"
                                        class="form-control @error('nama') is-invalid @enderror" placeholder=""
                                        value="{{old('nama')}}" required>
                                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 col-12">
                                    <label>Kategori<code>*)</code></label>
                                    <select class="form-control form-control-lg" required name="kategori_nama">
                                        @if (old('kategori_nama'))
                                        <option>{{old('kategori_nama')}}</option>
                                        @endif
                                        <option>Umum</option>
                                        {{-- <option>Denda</option> --}}
                                        <option>Pengembalian Dan</option>
                                        <option>Dana Hibah</option>
                                    </select>
                                </div>


                                <div class="form-group col-md-12 col-12">
                                    <label for="nominal">Nominal <code>*)</code></label>
                                    <input type="number" name="nominal" id="nominal" class="form-control @error('nominal') is-invalid @enderror" value="{{old('nominal')}}" required>
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
                                        $tgl=old('tglbayar');
                                    @endphp
                                @else
                                @php
                                    $tgl=date('Y-m-d');
                                @endphp
                                @endif
                                <div class="form-group col-md-12 col-12">
                                    <label>Tanggal Pemasukan</label>
                                    <input type="date" class="form-control" name="tglbayar" @error('tglbayar') is-invalid @enderror" value="{{ $tgl }}" >
                                    @error('tglbayar')<div class="invalid-feedback"> {{$message}}</div>
                                    @enderror
                                </div>


                                <div class="form-group col-md-12 col-12">
                                    <label for="catatan">Catatan <code></code></label>
                                    <input type="text" name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" value="{{old('catatan')}}" >
                                    @error('catatan')<div class="invalid-feedback"> {{$message}}</div>
                                    @enderror
                                </div>


                        </div>
                        </div>
                        </div>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <!-- Import Excel -->
              <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form method="post" action="{{ route($pages.'.import') }}" enctype="multipart/form-data">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                        <a href="{{ asset('assets/doc/perpus-pemasukan.xlsx') }}" target="_blank"><button type="button" class="btn btn-success" >Contoh Data</button></a>

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

