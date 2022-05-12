@extends('layouts.layout1')
{{-- @extends('admin.pages.beranda') --}}


@section('title','Buku')
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
    <th> KD Buku - Judul Buku </th>
    <th> ISBN </th>
    <th> Kategori </th>
    <th> Jumlah </th>
    <th class="text-center"> Tersedia </th>
    <th class="text-center"> Dipinjam </th>
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
                url: "{{ route('admin.buku.multidel') }}",
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
    <td> {{ $data->kode }} - {{ $data->nama }}</td>
    @php
       $isbn='-'; 
    @endphp
    @if ($data->isbn)
       @php
       $isbn=$data->isbn;
       @endphp
    @endif
    <td>{{ $isbn }}</td>
    <td class="text-center">{{ $data->bukukategori_nama }}</td>
    @php
        $jml=0;

        $cekjml = DB::table('bukudetail')->where('buku_kode',$data->kode)->count();
        $cekjmlada = DB::table('bukudetail')->where('buku_kode',$data->kode)->where('status','ada')->count();
        $cekjmldipinjam = DB::table('bukudetail')->where('buku_kode',$data->kode)->where('status','dipinjam')->count();
    @endphp
    <td class="text-center">{{$cekjml}}</td>
    <td class="text-center">
        {{-- {{$cekjmlada}}   --}}
        @if ($cekjmlada>0)
        {{-- <button class="btn btn-icon btn-info btn-sm "  data-toggle="tooltip" data-placement="top" title="Pinjam!" id="isikan{{ $data->kode }}"><i class="fas fa-shopping-cart"></i>
        </button> --}}
        @else
        {{-- <button class="btn btn-icon btn-secondary btn-sm "  data-toggle="tooltip" data-placement="top" title="Pinjam!" ><i class="fas fa-shopping-cart" disabled></i> </button> --}}
        @endif
        <div class="row">
            <div class="col-sm-6">
                <input type="hidden" name="{{$data->kode}}" id="{{$data->kode}}" value="{{$data->kode}}">
                <input type="number" class="form-control-plaintext form-control2 no-border text-center btn btn-light" name="tersedia{{$data->kode}}" id="tersedia{{$data->kode}}" value="{{$cekjmlada}}" min="0" max="{{$cekjmlada}}"> 

            </div>
            <div class="col-sm-6">
                <button class="btn btn-icon btn-info btn-sm "  data-toggle="tooltip" data-placement="top" title="Pinjam!" id="isikan{{ $data->kode }}"><i class="fas fa-shopping-cart"></i>
                </button>
            </div>
        </div>
       
    </td>
    <td class="text-center">{{$cekjmldipinjam}}    
        @if ($cekjmldipinjam>0)
        
        <a href="{{ route("admin.pengembalian")}}" class="btn btn-icon btn-success btn-sm "  data-toggle="tooltip" data-placement="top" title="Kembalikan!" >
            <i class="fas fa-hands"></i>
         </a>
        @else
        <button class="btn btn-icon btn-secondary btn-sm "  data-toggle="tooltip" data-placement="top" title="Kembalikan!" ><i class="fas fa-hands"></i> </button>
        @endif 
    </td>

    <td class="text-center">
        <a class="btn btn-icon btn-secondary btn-sm " href="{{ url('/admin/buku/') }}/{{ $data->id }}/bukudetail"  data-toggle="tooltip" data-placement="top" title="Lihat selengkapnya!"> <i class="fas fa-angle-double-right"></i> </a>
        <x-button-edit link="/admin/{{ $pages }}/{{$data->id}}" />
        <x-button-delete link="/admin/{{ $pages }}/{{$data->id}}" />
    </td>
</tr>
<script>
    // alert({{$cekjmlada}});
    // va
     if($("input#tersedia{{$data->kode}}").val()>0){
        $("#isikan{{$data->kode}}").prop('disabled', false);
        $("#isikan{{$data->kode}}").prop('class', 'btn btn-icon btn-info btn-sm');
        $("#isikan{{$data->kode}}").prop('title', 'Pinjam!');

        $("input#tersedia{{$data->kode}}").prop('min','1');
        $("input#tersedia{{$data->kode}}").prop('max','{{$cekjmlada}}');
     }else{
         $("input#tersedia{{$data->kode}}").prop('readonly',true);
        $("#isikan{{$data->kode}}").prop('disabled', false);
        $("#isikan{{$data->kode}}").prop('class', 'btn btn-icon btn-secondary btn-sm');
        $("#isikan{{$data->kode}}").prop('title', 'Buku tidak tersedia!');
        // alert('buku tidak tersedia');
        }
        
     
    // $("input#tersedia{{$data->kode}}").prop('disabled'.true);

    document.querySelector('#isikan{{ $data->kode }}').addEventListener('click', function (
                                        e) {
                                                // alert($("input#tersedia{{$data->kode}}").val());
                                            if($("input#tersedia{{$data->kode}}").val()>0){


                                                // masukkan data ke dalam local storage
                                                        
                                                                        var buku_ = {};  
                                                                                buku_.kode = '{{$data->kode}}';  
                                                                                buku_.nama = '{{$data->nama}}';
                                                                                buku_.pengarang ='{{$data->pengarang}}';   
                                                                                buku_.penerbit = '{{$data->penerbit}}';  
                                                                                buku_.bukukategori_nama = '{{$data->bukukategori_nama}}';   
                                                                                buku_.jml = parseInt($("input#tersedia{{$data->kode}}").val());   
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
                                                                    'Buku berhasil ditambahkan, Periksa menu peminjaman! '
                                                            });
                                                            $("#isikan{{$data->kode}}").prop('disabled', false);
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
                                                                    'Gagal, Buku tidak tersedial! '
                                                            });
                                                            $("#isikan{{$data->kode}}").prop('disabled', false);
                                                // alert('buku tidak tersedia');
                                            }
                                            // alert(isikan{{ $data->kode }});
                                        });
</script>
@endforeach

<tr>
    <td class="text-left" colspan="8">
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
                               
                    <div class="form-group col-md-4 col-4 mt-1 text-right">
                                    <input type="text" name="cari" id="cari"
                                        class="form-control form-control-sm @error('cari') is-invalid @enderror"
                                        value="{{$request->cari}}" placeholder="Cari...">
                                    @error('cari')<div class="invalid-feedback"> {{$message}}</div>
                                    @enderror
                    </div>
                               

                                       
                    <div class="form-group col-md-4 col-4 mt-1 text-left">
                         

                        <button type="submit" value="CARI" class="btn btn-icon btn-info btn-sm mt-0"><span
                            class="pcoded-micon"> <i class="fas fa-search"></i> Pecarian</span></button>

                    </div>                     
                    <div class="form-group col-md-4 col-4 mt-1 text-right">
                            
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

    <div class="col-12 col-md-12 col-lg-12">

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
                            <form action="/admin/{{ $pages }}" method="post">
                                @csrf
                                <div class="card-header">
                                    <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> Tambah
                                        @yield('title')</span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-12 col-12">
                                            <label for="nama">Judul Buku</label>
                                            <input type="text" name="nama" id="nama"
                                                class="form-control @error('nama') is-invalid @enderror" placeholder=""
                                                value="{{old('nama')}}" required>
                                            @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12 col-12">
                                            <label for="penerbit">Penerbit</label>
                                            <input type="text" name="penerbit" id="penerbit"
                                                class="form-control @error('penerbit') is-invalid @enderror" placeholder=""
                                                value="{{old('penerbit')}}" required>
                                            @error('penerbit')<div class="invalid-feedback"> {{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12 col-12">
                                            <label for="tahunterbit">Tanggal Terbit</label>
                                            <input type="text" name="tahunterbit" id="tahunterbit"
                                                class="form-control @error('tahunterbit') is-invalid @enderror" placeholder=""
                                                value="{{old('tahunterbit')}}" required>
                                            @error('tahunterbit')<div class="invalid-feedback"> {{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-12 col-12">
                                            <label for="isbn">ISBN </label>
                                            <input type="text" name="isbn" id="isbn"
                                                class="form-control @error('isbn') is-invalid @enderror" placeholder=""
                                                value="{{old('isbn')}}" >
                                            @error('isbn')<div class="invalid-feedback"> {{$message}}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group col-md-12 col-12">
                                            <label for="bahasa">Bahasa</label>
                                            <input type="text" name="bahasa" id="bahasa"
                                                class="form-control @error('bahasa') is-invalid @enderror" placeholder=""
                                                value="{{old('bahasa')}}" required>
                                            @error('bahasa')<div class="invalid-feedback"> {{$message}}</div>
                                            @enderror
                                        </div>
                                       
                                        {{-- <div class="form-group col-md-12 col-12">
                                            <label>Tempat Rak Buku <code>*)</code></label>
                                            <select class="form-control form-control-lg" required name="bukurak_nama">  
                                                @if (old('bukurak_nama'))
                                                <option>{{old('bukurak_nama')}}</option>                        
                                                @endif
                                            @foreach ($bukurak as $t)
                                                <option>{{ $t->nama }}</option>
                                            @endforeach
                                            </select>
                                        </div>  --}}

                                        
                                        <div class="form-group col-md-12 col-12">
                                            <label>DDC / Kategori Buku <code>*)</code></label>
                                            <select class="form-control form-control-lg" required name="bukukategori_nama">  
                                                @if (old('bukukategori_nama'))
                                                <option>{{old('bukukategori_nama')}}</option>                        
                                                @endif
                                            @foreach ($bukukategori as $t)
                                                <option value="{{ $t->nama }}">{{ $t->kode }} / {{ $t->nama }}</option>
                                            @endforeach
                                            </select>
                                        </div> 
                                        
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">Kode Buku</span>
                                            </div>
                                            <input type="number" name="kode" id="kode"
                                            class="form-control @error('kode') is-invalid @enderror" placeholder="Otomatis di antara DDC"
                                            value="{{old('kode')}}" required min="1" readonly>
                                        @error('kode')<div class="invalid-feedback"> {{$message}}</div>
                                        @enderror


                                    </div>


                                    <div class="row">
                                        <div class="form-group mb-0 col-12">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
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
    </div>
</div>

       
<!-- /.content -->
@endsection

@section('container-modals')

              <!-- Import Excel -->
              <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

