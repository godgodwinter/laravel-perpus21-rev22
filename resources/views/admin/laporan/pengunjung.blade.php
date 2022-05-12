@extends('layouts.layout1')



@section('title','Anggota')
@section('linkpages')
data{{ $pages }}
@endsection
@section('halaman','kelas')

@section('csshere')
@endsection

@section('jshere')
<script>
    $(function () {
      $('.select2').select2()
    });
</script>
<script src="{{ asset("assets/") }}/plugins/Chart.bundle.js"></script>
<script>

//     let labelku='';
//     let dataku='';
//     $(document).ready(function(){

//         fetch_customer_data();
// //  fetch_customer_data();
// cari = $("input[name=cari]").val();
// bln = $("input[name=bln]").val();

//  function fetch_customer_data(query = '')
//  {
//   $.ajax({
//    url:"{{ route('admin.api.chart1') }}",
//    method:'GET',
//    data:{
//             "_token": "{{ csrf_token() }}",
//         },
//    dataType:'json',
//    success:function(data)
//    {
// //  alert(data.label);
//  labelku=data.label;
//  dataku=data.data;

//     //    $('#jmldata').html(data.jml);
//         // console.log($('#tampil').html(data.datas);
//         // console.log(data.datas);
//     // $('tbody').html(data.table_data);
//     // $('#total_records').text(data.total_data);
//    }
//   })
//  }


// });


    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [@foreach ($label as $l)
            " {{$l}} ",
            @endforeach],
            datasets: [{
                    label: '# Jumlah Pengunjung per bulan',
                    data: [{{$data}}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
        },
        options: {
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
            }
        }
    });
</script>
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
      <h2 class="text-center display-4">Laporan Pengunjung</h2>
    </div>
    <!-- /.container-fluid -->
  </section>

    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <form action="{{ route('pengunjung.cetak')}}" method="get">
                            @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group ">
                                    <input type="text" class="form-control form-control search" placeholder="Cari . . ." name="cari"  id="cari" autocomplete="off">
                                    <div class="input-group-append">
                                        <button  class="btn btn btn-default search"  id="tombolcari">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>

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
                            <div class="col-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-default float-right" type="submit" ><i class="fas fa-print"></i> Cetak PDF
                                    </button>

                                </div>
                            </div>

                        </div>
                    </form>
                        <div class="form-group">
                        </div>
                    </div>
                </div>


      <!-- Default box -->
      <div class="card  col-sm-10 offset-1">
        <div class="card-header">
          <h3 class="card-title">Grafik Pengunjung</h3>

        </div>

      <div class="card-body  col-sm-7 offset-2">
        <div class="chart">
            <canvas id="myChart" width="400" height="400"></canvas>
        </div>
      </div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

            <script>
                $("button#tombolcari").click(function(){
                    return false
                });
                $(document).ready(function(){

                //  fetch_customer_data();
                cari = $("input[name=cari]").val();
                bln = $("input[name=bln]").val();

                 function fetch_customer_data(query = '')
                 {
                  $.ajax({
                   url:"{{ route('admin.laporan.pengunjungapi') }}",
                   method:'GET',
                   data:{
                            "_token": "{{ csrf_token() }}",
                            cari: cari,
                            bln: bln,
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
                        // console.log(cari);
                  var query = $(this).val();
                  fetch_customer_data(query);
                 });


                 $(document).on('change', '#bln', function(){
                cari = $("input[name=cari]").val();
                bln = $("input[name=bln]").val();
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
            <label>Jumlah : {{$jml}} Pengunjung</label>

        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 20%">
                          Nama
                      </th>
                      <th style="width: 30%">
                          Identitas
                      </th>
                      <th>
                          Tanggal Berkunjung
                      </th>
                      <th style="width: 8%" class="text-center">
                          Tipe
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
                              {{$data->nama}}
                          </a>
                          {{-- <br/> --}}
                          {{-- <small>
                              Created 01.01.2019
                          </small> --}}
                      </td>
                      <td>
                        {{$data->nomeridentitas}}
                      </td>
                      <td class="project_progress">
                          {{-- <div class="progress progress-sm">
                              <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%">
                              </div>
                          </div> --}}
                          <small>
                             {{Fungsi::tanggalindo($data->tgl)}}
                          </small>
                      </td>
                      <td class="project-state">
                          @php

                          @endphp
                          <span class="badge badge-success">{{$data->tipe}}</span>
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
