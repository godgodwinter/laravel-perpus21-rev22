@extends('layouts.layout1')
{{-- @extends('admin.pages.beranda') --}}


@section('title','Anggota')
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
    <th> Tipe</th>
    <th> No Telp</th>
    <th> Alamat</th>
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
                url: "{{ route('admin.users.multidel') }}",
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
    <td>{{ $data->tipe }}</td>
    <td>{{ $data->telp }}</td>
    <td><p data-toggle="tooltip" data-placement="top" title="{{ $data->alamat }}">{{ substr($data->alamat,0,20) }}</p></td>

    <td class="text-center">
        {{-- <a class="btn btn-icon btn-secondary btn-sm " href="{{ url('/admin/inputnilai/kelas') }}/{{ $data->id }}"
        data-toggle="tooltip" data-placement="top" title="Lihat selengkapnya!"> <i
            class="fas fa-angle-double-right"></i> </a> --}}
        <x-button-edit link="/admin/{{ $pages }}/{{$data->id}}" />
        <x-button-delete link="/admin/{{ $pages }}/{{$data->id}}" />
    </td>
</tr>
@endforeach

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
                            <form action="/admin/{{ $pages }}" method="post" enctype="multipart/form-data">
                                @csrf
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                      </div>
                      <div class="modal-body">

                        <div class="col-12 col-md-12 col-lg-12">
                        <div class="card-body">
                        <div class="row">

                                <div class="form-group col-md-12 col-12">
                                    <label for="nama">Nama @yield('title')</label>
                                    <input type="text" name="nama" id="nama"
                                        class="form-control @error('nama') is-invalid @enderror" placeholder=""
                                        value="{{old('nama')}}" required>
                                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                                    @enderror
                                </div>

                            <div class="form-group col-md-12 col-12">
                                <img alt="image" src="https://ui-avatars.com/api/?name=img&color=7F9CF5&background=EBF4FF" class="img-thumbnail" width="200px">

                                <label for="file">Pilih Photo <code></code></label>
                                <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" >
                                @error('file')<div class="invalid-feedback"> {{$message}}</div>
                                @enderror
                            </div>

                                <div class="form-group col-md-12 col-12">
                                    <label>Tipe Anggota<code>*)</code></label>
                                    <select class="form-control form-control-lg" required name="tipe">
                                        @if (old('tipe'))
                                        <option>{{old('tipe')}}</option>
                                        @endif
                                        <option >Umum</option>
                                        <option >Siswa</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-12 col-12">
                                    <label for="nomeridentitas">Nomer Identitas / NIS / KTP / SIM</label>
                                    <input type="number" name="nomeridentitas" id="nomeridentitas"
                                        class="form-control @error('nomeridentitas') is-invalid @enderror" placeholder=""
                                        value="{{old('nomeridentitas')}}" required>
                                    @error('nomeridentitas')<div class="invalid-feedback"> {{$message}}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 col-12">
                                    <label for="tempatlahir">Tempat Lahir <code>*)</code></label>
                                    <input type="text" name="tempatlahir" id="tempatlahir" class="form-control @error('tempatlahir') is-invalid @enderror" value="{{old('tempatlahir')}}" required>
                                    @error('tempatlahir')<div class="invalid-feedback"> {{$message}}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 col-12">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tgllahir" @error('tgllahir') is-invalid @enderror" value="{{old('tgllahir')}}" >
                                    @error('tgllahir')<div class="invalid-feedback"> {{$message}}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 col-12">
                                    <label>Jenis Kelamin <code>*)</code></label>
                                    <select class="form-control form-control-lg" required name="jk">
                                    @if (old('jk'))
                                    <option>{{old('jk')}}</option>
                                    @endif


                                        <option>Laki-laki</option>
                                        <option>Perempuan</option>
                                    </select>
                                </div>


                                <div class="form-group col-md-12 col-12">
                                    <label for="telp">Telp <code></code></label>
                                    <input type="text" name="telp" id="telp" class="form-control @error('telp') is-invalid @enderror" value="{{old('telp')}}" >
                                    @error('telp')<div class="invalid-feedback"> {{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12 col-12">
                                    <label>Agama <code>*)</code></label>
                                    <select class="form-control form-control-lg" required name="agama">
                                    @if (old('agama'))
                                    <option>{{old('agama')}}</option>
                                    @endif
                                    <option>Islam</option>
                                    <option>Kristen</option>
                                    <option>Katholik</option>
                                    <option>Hindu</option>
                                    <option>Budha</option>
                                    <option>Konghucu</option>
                                    <option>Lain-lain</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-12 col-12">
                                    <label for="alamat">Alamat <code>*)</code></label>
                                    <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{old('alamat')}}" required>
                                    @error('alamat')<div class="invalid-feedback"> {{$message}}</div>
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
                        <a href="{{ asset('assets/doc/perpus-anggota.xlsx') }}" target="_blank"><button type="button" class="btn btn-success" >Contoh Data</button></a>

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

