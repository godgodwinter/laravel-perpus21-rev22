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
    <th width="80px" class="text-center">
        <input type="checkbox" id="chkCheckAll"> <label for="chkCheckAll"> All</label></th>
    <th> KD Buku - Judul Buku </th>
    <th class="text-center"> Pengarang </th>
    <th class="text-center"> Jumlah </th>
    <th class="text-center"> Tersedia </th>
    <th class="text-center"> Dipinjam </th>
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
        
        $("#cetakbukuchecked").click(function (e) {
            e.preventDefault();
            var allids = [];
            $("input:checkbox[name=ids]:checked").each(function () {
                allids.push($(this).val());
            });
            $("#databukuchecked").val(allids);

            if($("#databukuchecked").val()==''){
                // alert('datakosong');
                $('#tombolcetak').prop('disabled',true);
            }else{
                // alert('dataterisi');
                $('#tombolcetak').prop('disabled',false);
            }
                // alert(allids);
                
            // $.ajax({
            //     url: "{{ route('admin.buku.multidel') }}",
            //     type: "DELETE",
            //     data: {
            //         _token: $("input[name=_token]").val(),
            //         ids: allids
            //     },
            //     success: function (response) {
            //         $.each(allids, function ($key, val) {
            //             $("#sid" + val).remove();
            //         })
            //     }
            // });
            // alert('asd');
            
        });

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
    <td> 
        <a class="btn btn-icon btn-light btn-sm " href="#"  data-toggle="tooltip" data-placement="top" title=" {{ $data->nama }}">
            {{-- {{ App\Models\buku::find($data->id)->code }} --}}
           {{$data->kode}}  - {{ substr($data->nama, 0 ,20) }}</a>
        </td>
    <td ><p data-toggle="tooltip" data-placement="top" title="{{ $data->pengarang }}">{{ substr($data->pengarang, 0 ,15) }}</p></td>
    {{-- @php
       $isbn='-'; 
    @endphp
    @if ($data->isbn)
       @php
       $isbn=$data->isbn;
       @endphp
    @endif
    <td>{{ $isbn }}</td> --}}
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
    <td class="text-center"> 
        {{-- <a href="{{ route("admin.pengembalian")}}" class="btn btn-icon btn-light btn-sm "  data-toggle="tooltip" data-placement="top" title="Kembalikan!" >  --}}
        {{$cekjmldipinjam}}  
      {{-- </a> --}}
       
    </td>

</tr>
<script>
    // alert({{$cekjmlada}});
    // va
    $( document ).ready(function() {


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
            }


        $("input#tersedia{{$data->kode}}").bind("keyup", function(e) {
            var cekjmlada={{$cekjmlada}};
            if(($("input#tersedia{{$data->kode}}").val()>0) && ($("input#tersedia{{$data->kode}}").val()<=parseInt(cekjmlada))){
                $("#isikan{{$data->kode}}").prop('disabled', false);
                $("#isikan{{$data->kode}}").prop('class', 'btn btn-icon btn-info btn-sm');
                $("#isikan{{$data->kode}}").prop('title', 'Pinjam!');

                $("input#tersedia{{$data->kode}}").prop('min','1');
                $("input#tersedia{{$data->kode}}").prop('max','{{$cekjmlada}}');
            }else if($("input#tersedia{{$data->kode}}").val()>parseInt(cekjmlada)){
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
                                                            $("#isikan{{$data->kode}}").prop('disabled', true);

            }else{
                // $("input#tersedia{{$data->kode}}").prop('readonly',true);
                $("#isikan{{$data->kode}}").prop('disabled', false);
                $("#isikan{{$data->kode}}").prop('class', 'btn btn-icon btn-secondary btn-sm');
                $("#isikan{{$data->kode}}").prop('title', 'Buku tidak tersedia!');
                // alert('buku tidak tersedia');
                }
        });
    

});
        
     
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
        <form action="{{route('buku.checked.cetak')}}" method="get">
            @csrf

                
            <a href="#" type="submit" value="cetak" id="cetakbukuchecked"
            class="btn btn-icon btn-warning btn-sm ml-2"  data-toggle="tooltip" data-placement="top" title="Pilih satu atau beberapa buku dahulu!"><span class="pcoded-micon"> <i class="fas fa-print"></i>   Buat Link Cetak </span></a>

            
            <input type="hidden" name="databukuchecked" class="databukuchecked " id="databukuchecked" value="">
            <button href="#" type="submit" value="cetak" id="tombolcetak"
            class="btn btn-icon btn-default btn-sm ml-2" disabled  data-toggle="tooltip" data-placement="top" title="Tekan tombol Buat link cetak dahulu"><span class="pcoded-micon" > <i class="fas fa-print"></i>   Cetak PDF </span></button>
        </form>
        </td>
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
    </div>


       
<!-- /.content -->
@endsection

@section('container-modals')



@endsection

