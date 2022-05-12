@extends('layouts.layout1')
{{-- @extends('admin.pages.beranda') --}}


@section('title')
Buku <b>{{$buku->nama}}</b>
@endsection
@section('linkpages')
data{{ $pages }}
@endsection
@section('halaman','bukudetail')

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
         <label for="chkCheckAll"> All</label></th>
        {{-- <th> Kode Panggil </th> --}}
    <th> Kondisi </th>
    <th> Status </th>
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
                url: "{{ route('admin.bukudetail.multidel') }}",
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
    <td class="text-center">
        {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
    {{-- <td> {{ $data->buku_kode}}  --}}
    <input type="hidden" value="{{ $data->buku_kode}}" name="{{ $data->buku_kode}}">
    </td>
    <td>{{ $data->kondisi }}</td>
    <td>{{ ucfirst($data->status) }}</td>

    <script>


        $(document).ready(function () {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    }
                });


                document.querySelector('#isikan{{ $data->buku_kode}}').addEventListener('click', function (
                e) {
                    e.preventDefault();

var nama = $("input[name={{ $data->buku_kode}}]").val();

var link = "/admin/peminjaman/periksa/" + nama;
// alert(link);

$.ajax({
    url: link,
    method: 'GET',
    data: {
        "_token": "{{ csrf_token() }}",
        nama: nama,
    },
                            success:function(response){
                            if(response.success){
                                                        if (response
                                                            .message != 0) {
                                                                // alert(response.message);

                                                            let daftarbuku2;
                                                            if (localStorage.getItem(
                                                                    'daftarbuku') ===
                                                                null) {
                                                                daftarbuku2 = [];
                                                            } else {
                                                                daftarbuku2 = JSON.parse(
                                                                    localStorage
                                                                    .getItem(
                                                                        'daftarbuku'));
                                                            }


                                                            var hasilperiksa=0;
                                                            for (let i = 0; i < daftarbuku2.length; i++) {
                                                                          if(daftarbuku2[i]==nama){
                                                                              hasilperiksa++;
                                                                          }else{

                                                                            // alert('belum ada');
                                                                          }
                                                                    }
                                                                // alert(hasilperiksa);
                                                                if(hasilperiksa>0){
                                                                            var Toast = Swal.mixin({
                                                                                toast: true,
                                                                                position: 'top-end',
                                                                                showConfirmButton: false,
                                                                                timer: 3000
                                                                            });

                                                                            Toast.fire({
                                                                                icon: 'error',
                                                                                title:
                                                                                    'Data sudah ditambahkan! '
                                                                            });


                                                                }else{


                                                                    var buku_ = {};
                                                                            buku_.id = response.data;
                                                                            buku_.buku_nama = response.buku_nama;
                                                                            buku_.bukukategori_nama = response.bukukategori_nama;
                                                                            // var ItemId = "data-" + buku_.id;
                                                                            var ItemId = buku_.id;
                                                                            localStorage.setItem(ItemId, JSON.stringify(buku_));


                                                                daftarbuku2.push(nama);
                                                                localStorage.setItem(
                                                                    'daftarbuku', JSON
                                                                    .stringify(
                                                                        daftarbuku2));

                                                                        var Toast = Swal.mixin({
                                                                            toast: true,
                                                                            position: 'top-end',
                                                                            showConfirmButton: false,
                                                                            timer: 3000
                                                                        });

                                                                        Toast.fire({
                                                                            icon: 'success',
                                                                            title: nama +
                                                                                'Data berhasil ditambahkan!'
                                                                        });

                                                                        location.reload();
                                                                }
                                                                    }



                            }else{
                            alert("Error")
                            // alert(response.message) //Message come from controller
                            }
                            },
                            error:function(error){

                            alert('Gagal! Angka harus 1-100!') //Message come from controller
                            console.log(error)
                            }
                            });
                            });
                            });
    </script>
</tr>
@endforeach

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

        <div class="col-12 col-md-12 col-lg-8">

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



                        <form action="{{url("/admin/buku/".$buku->id."/databukudetail/cari")}}" method="GET">

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

