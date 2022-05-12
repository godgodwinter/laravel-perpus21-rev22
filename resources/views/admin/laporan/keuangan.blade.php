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
                                <a href="{{url('/admin/datakeuangan/cetak/'.$bln)}}" type="submit" value="cetak" id="blncetak"
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
                   url:"{{ route('admin.laporan.api.keuangan') }}",
                   method:'GET',
                   data:{
                            "_token": "{{ csrf_token() }}",
                            bln: bln,
                        },
                   dataType:'json',
                   success:function(data)
                   {
                       $('#tampilpemasukan').html(data.outputpemasukan);
                       $('#tampilpengeluaran').html(data.outputpengeluaran);
                       $('#tampildenda').html(data.outputdenda);
                       $('#tampilsaldo').html(data.outputsaldo);
                   }
                  })
                 }


                 $(document).on('change', '#bln', function(){
                bln = $("input[name=bln]").val();
                $("#blncetak").prop('href','{{url('/admin/datakeuangan/cetak/')}}/'+bln);
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
        <hr>
        <hr>
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
              {{-- <tr>
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

              </tr> --}}
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
                   Total Saldo = Total Pemasukan - Total Pengeluaran
                  </th>

                  <th style="width: 18%" class="text-center">
                   <small>   Total Saldo :</small><br>
                      <strong>{{Fungsi::rupiah(($totalnominal2)-($totalnominal))}}</strong>
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
