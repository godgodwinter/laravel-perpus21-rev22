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
      <h2 class="text-center display-4">Laporan Keuangan</h2>
    </div>
    <!-- /.container-fluid -->
  </section>

    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="row">
                            <div class="col-6 mr-4">
                                <form action="{{ route('admin.laporan.keuangan') }}" method="GET">
                                <div class="form-group d-flex px-2">

                                    <input type="month" name="blnawal" id="bln"
                                        class="form-control  search mr-2" placeholder=""
                                        value="{{$blnawal}}" required>
                                    <input type="month" name="bln" id="bln"
                                        class="form-control  search mr-2" placeholder=""
                                        value="{{$bln}}" required>

                                        <button type="submit" value="cetak" id="blncetak"
                                        class="btn btn-icon btn-primary btn-md form-control"><span class="pcoded-micon">  Pilih Bulan </span></button>

                                </div></form>

                            </div>

                            <div class="col-3">
                                <a href="{{url('/admin/datakeuangan/cetak/'.$bln)}}" type="submit" value="cetak" id="blncetak"
                                 class="btn btn-icon btn-default btn-md"><span class="pcoded-micon"> <i class="fas fa-print"></i>   Cetak PDF </span></a>
                            </div>
                        </div>
                        <div class="form-group">
                        </div>
                    </div>
                </div>

              <!-- Default box -->
      <div class="card col-md-10 offset-md-1">
        <div class="card-header" id="jmldata">
            {{-- <label>Pengeluaran :  {{$jml}} Transaksi</label> --}}

        </div>
        <div class="card-body p-0">
          <table class="table  projects">
              <tbody id="tampilpemasukan">

                  <tr class="thead-dark">
                      <th colspan="2">
                        Data  Pemasukan
                      </th>

                      <th style="width: 18%" class="text-center">
                          {{$jml2}} Transaksi
                      </th>
                      <th style="width: 18%" class="text-center">
                       <small>   Total Nominal :</small><br>
                          <strong>{{Fungsi::rupiah($totalnominal2)}}</strong>
                      </th>

                  </tr>
                {{-- {{dd($datas)}} --}}
                @foreach ($datas2 as $data)

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
                    <td class="text-center">
                      {{Fungsi::tanggalindo($data->tglbayar)}}
                    </td>

                    <td class="project-state">
                      {{Fungsi::rupiah($data->nominal)}}
                    </td>

                </tr>
                @endforeach

            </tbody>
    </table>
        <table class="table  projects">
            <tbody id="tampilpengeluaran">
              <tr class="thead-dark">
                  <th colspan="2">
                    Data  Pengeluaran
                  </th>

                  <th style="width: 18%" class="text-center">
                      {{$jml}} Transaksi
                  </th>
                  <th style="width: 18%" class="text-center">
                   <small>   Total Nominal :</small><br>
                      <strong>{{Fungsi::rupiah($totalnominal)}}</strong>
                  </th>

              </tr>
                {{-- {{dd($datas)}} --}}
                @foreach ($datas as $data)

                <tr>
                    <td>
                       {{$loop->index+1}}
                    </td>
                    <td >
                        <a>
                            {{$data->nama}}
                        </a>
                        {{-- <br/> --}}
                        {{-- <small>
                            Created 01.01.2019
                        </small> --}}
                    </td>
                    <td class="text-center">
                      {{Fungsi::tanggalindo($data->tglbayar)}}
                    </td>

                    <td class="project-state">
                      {{Fungsi::rupiah($data->nominal)}}
                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>
        <table class="table  projects">
          <tbody id="tampilsaldo">
              <tr>
                <td colspan="4"> </td>
              </tr>
              <tr>
                  <th colspan="2">
                    Data  Pemasukan
                  </th>

                  <th style="width: 18%" class="text-center">
                      {{$jml2}} Transaksi
                  </th>
                  <th style="width: 18%" class="text-center">
                   <small>   Total Nominal :</small><br>
                      <strong>{{Fungsi::rupiah($totalnominal2)}}</strong>
                  </th>

              </tr>
              <tr>
                  <th colspan="2">
                    Data  Pemasukan Denda
                  </th>

                  <th style="width: 18%" class="text-center">
                      {{$jmldenda}} Transaksi
                  </th>
                  <th style="width: 18%" class="text-center">
                   <small>   Total Nominal :</small><br>
                      <strong>{{Fungsi::rupiah($totalnominaldenda)}}</strong>
                  </th>

              </tr>
              <tr>
                  <th colspan="2">
                    Data  Pengeluaran
                  </th>

                  <th style="width: 18%" class="text-center">
                      {{$jml}} Transaksi
                  </th>
                  <th style="width: 18%" class="text-center">
                   <small>   Total Nominal :</small><br>
                      <strong>{{Fungsi::rupiah($totalnominal)}}</strong>
                  </th>

              </tr>
              <tr>
                  <th colspan="3">
                   Total Saldo = Total Pemasukan + Total Pemasukan dari  Denda - Total Pengeluaran
                  </th>

                  <th style="width: 18%" class="text-center">
                   <small>   Total Saldo :</small><br>
                      <strong>{{Fungsi::rupiah(($totalnominal2+$totalnominaldenda)-($totalnominal))}}</strong>
                  </th>

              </tr>
          </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

        </div>


    </section>
    @endsection
