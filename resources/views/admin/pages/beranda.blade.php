@extends('layouts.layout1')
{{-- @extends('admin.pages.beranda') --}}


@section('title','Beranda')
@section('linkpages')
data{{ $pages }}
@endsection
@section('halaman','kelas')

@section('csshere')
@endsection

@section('jshere')
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
                    label: '# Jumlah buku dipinjam per bulan',
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


    var ctx = document.getElementById("myChartpengunjung");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [@foreach ($labelpengunjung as $l)
            " {{$l}} ",
            @endforeach],
            datasets: [{
                    label: '# Jumlah pengunjung per bulan',
                    data: [{{$datapengunjung}}],
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

@if (session('tipe'))
        @php
        $tipe=session('tipe');
        @endphp
@else
        @php
            $tipe='light';
        @endphp
@endif

@if (session('icon'))
        @php
        $icon=session('icon');
        @endphp
@else
        @php
            $icon='far fa-lightbulb';
        @endphp
@endif

@php
  $message=session('status');
@endphp
@if (session('status'))
<x-alert tipe="{{ $tipe }}" message="{{ $message }}" icon="{{ $icon }}"/>

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
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                  <li class="breadcrumb-item active">Index</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card  col-sm-10 offset-1">
        <div class="card-header">
          <h3 class="card-title">Grafik Pengunjung</h3>


        </div>

      <div class="card-body col-sm-7 offset-3">
        <div class="chart">
            <canvas id="myChartpengunjung" width="400" height="400"></canvas>
        </div>
      </div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->


      <!-- Default box -->
      <div class="card  col-sm-10 offset-1">
        <div class="card-header">
          <h3 class="card-title">Grafik Peminjaman</h3>


        </div>

      <div class="card-body col-sm-7 offset-3">
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


    </section>
    <!-- /.content -->
@endsection

