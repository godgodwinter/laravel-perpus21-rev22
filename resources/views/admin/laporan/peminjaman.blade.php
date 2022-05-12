@extends('layouts.layout1')



@section('title','Anggota')
@section('linkpages')
data{{ $pages }}
@endsection
@section('halaman','kelas')

@section('csshere')
<style type="text/css">
    .container {
        width: 50%;
        margin: 15px auto;
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

@section('container')

<section class="content-header">
    <div class="container-fluid">
      <h2 class="text-center display-4">Laporan  Peminjaman dan Pengembalian</h2>
    </div>
    <!-- /.container-fluid -->
  </section>

    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="row">
                            <div class="col-4">
                                <div class="input-group ">
                                    <input type="text" class="form-control form-control search" placeholder="Cari . . ." name="cari"  id="cari" autocomplete="off">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn btn-default search">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div class="col-3">
                                <select class="form-control" required name="status" id="status">

                                    <option value="semua">Semua</option>
                                    <option value="belum">Belum Kembali</option>
                                    <option value="sudah">Sudah Kembali</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    @php
                                        if(old('bln')!=null){
                                            $bln=old('bln');
                                        }else{
                                            $bln=date('Y-m');
                                        }

                                    @endphp
                                    <input type="month" name="bln" id="bln"
                                        class="form-control  search" placeholder=""
                                        value="{{$bln}}" required>

                                </div>
                            </div>    
                            <div class="col-2">       
                                    @php
                                        $status='semua';
                                        $cari='null';
                                    @endphp
                                <a href="{{url('/admin/datapeminjaman/cetak/'.$bln.'/'.$status.'/'.$cari)}}" type="submit" value="cetak" id="blncetak"
                                 class="btn btn-icon btn-default btn-md"><span class="pcoded-micon"> <i class="fas fa-print"></i>   Cetak PDF </span></a>
                            </div>
                        </div>
                        <div class="form-group">
                        </div>
                    </div>
                </div>

            <script>
                $(document).ready(function(){

                //  fetch_customer_data();
                cari = $("input[name=cari]").val();
                bln = $("input[name=bln]").val();

                 function fetch_customer_data(query = '')
                 {
                  $.ajax({
                   url:"{{ route('admin.laporan.api.peminjaman') }}",
                   method:'GET',
                   data:{
                            "_token": "{{ csrf_token() }}",
                            cari: cari,
                            bln: bln,
                            status: status,
                        },
                   dataType:'json',
                   success:function(data)
                   {
                       $('#tampil').html(data.show);
                       $('#jmldata').clear;
                       $('#jmldata').html('<label>Jumlah : '+data.message+' Pengunjung</label>');
                    //    $('#jmldata').html(data.jml);
                        // console.log($('#tampil').html(data.datas);
                        // console.log(data.datas);
                    // $('tbody').html(data.table_data);
                    // $('#total_records').text(data.total_data);
                   }
                  })
                 }

                 $(document).on('keyup', '.search', function(){
                cari = $("input[name=cari]").val();
                bln = $("input[name=bln]").val();
                status = $("select[name=status]").val();
                        // console.log(cari);
                  var query = $(this).val();
                  fetch_customer_data(query);
                 });


                 $(document).on('change', '#bln', function(){
                cari = $("input[name=cari]").val();
                bln = $("input[name=bln]").val();
                status = $("select[name=status]").val();
                $("#blncetak").prop('href','{{url('/admin/datapeminjaman/cetak/')}}/'+bln+'/semua/null');
                        // console.log(cari);
                  var query = $(this).val();
                  fetch_customer_data(query);
                 });


                 $(document).on('change', '#status', function(){
                cari = $("input[name=cari]").val();
                bln = $("input[name=bln]").val();
                status = $("select[name=status]").val();
                        // console.log(cari);
                  var query = $(this).val();
                  fetch_customer_data(query);
                 });
                //  $("button#clear").click(function(){

                //     //  alert('');
                //      $("input[name=cari]").val('');
                //  });
                });
                </script>
              <!-- Default box -->
      <div class="card col-md-10 offset-md-1">
        <div class="card-header" id="jmldata">
            <label>Jumlah : {{$jml}} Buku dipinjam</label>

        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 20%">
                          Judul
                      </th>
                      <th >
                          Detail Buku
                      </th>
                      <th style="width: 10%">
                          Tanggal Pinjam
                      </th>
                      <th style="width: 10%">
                          Peminjam
                      </th>
                      <th style="width: 5%" class="text-center">
                          Status
                      </th>

                  </tr>
              </thead>
              <tbody id="tampil">
                  {{-- {{dd($datas)}} --}}
                  @foreach ($datas as $data)

                  <tr>
                      <td>
                         {{$loop->index+1}}
                      </td>
                      <td>
                          <a>
                              {{$data->buku_nama}}
                          </a>
                          {{-- <br/> --}}
                          {{-- <small>
                              Created 01.01.2019
                          </small> --}}
                      </td>
                      <td>
                       Pengarang {{$data->buku_pengarang}}
                       <small>
                        Penerbit {{$data->buku_penerbit}}
                       </small>
                      </td>
                      <td class="project_progress">
                          {{-- <div class="progress progress-sm">
                              <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%">
                              </div>
                          </div> --}}
                          <small>
                             {{Fungsi::tanggalindo($data->tgl_pinjam)}}
                          </small>
                      </td>
                      <td>
                          @php
                              $jmlambilpeminjam=DB::table('peminjaman')->where('kodetrans',$data->kodetrans)->count();
                              $ambilpeminjam=DB::table('peminjaman')->where('kodetrans',$data->kodetrans)->first();
                          @endphp
                          @if($jmlambilpeminjam>0)

                        {{$data->nomeridentitas}} - {{$ambilpeminjam->nama}}
                          @else
                            Data Tidak ditemukan
                          @endif
                      </td>
                      <td class="project-state">
                          @php
                                if($data->statuspengembalian==null){
                                    $status="Belum dikembalikan";
                                    $warna='warning';
                                }else{
                                    $status="Sudah dikembalikan";
                                    $warna='success';
                                }
                          @endphp
                          <span class="badge badge-{{$warna}}">{{$status}}</span>
                      </td>

                  </tr>
                  @endforeach

              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->


        </div>


    </section>
    @endsection
