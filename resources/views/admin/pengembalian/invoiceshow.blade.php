@extends('layouts.layout1')
{{-- @extends('admin.pages.beranda') --}}


@section('title')
Invoice Peminjaman
{{-- <code>{{$datapinjam->kodetrans}}</code> --}}
@endsection
@section('linkpages')
data{{ $pages }}
@endsection
@section('halaman','kelas')

@section('csshere')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
    $(function () {
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

    @if((session('clearlocal')=='yes'))

        localStorage.clear();
        $("#tbody").empty();
   @endif

    });


</script>
@endif
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
            <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                  <div class="col-12">
                    <h4>
                      <i class="fas fa-globe"></i> {{Fungsi::sekolahnama()}}
                      <small class="float-right">Date: {{Fungsi::tanggalindocreated($datapinjam->created_at)}}</small>
                    </h4>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                  <div class="col-sm-4 invoice-col">
                    {{-- From --}}
                    <address>
                      <strong>Perpustakaan.</strong><br>
                      {{Fungsi::sekolahalamat()}}<br>
                      {{-- San Francisco, CA 94107<br> --}}
                      Telp: {{Fungsi::sekolahtelp()}}<br>
                      {{-- Email: info@almasaeedstudio.com --}}
                    </address>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 invoice-col">
                    {{-- To --}}
                    Peminjam:
                    <address>
                      <strong>
                        <b></b> {{$datapinjam->nomeridentitas}} - {{$datapinjam->nama}}<br></strong><br>
                      Identitas : {{$datapinjam->jaminan_tipe}}<br>
                      {{-- San Francisco, CA 94107<br>
                      Phone: (555) 539-1037<br>
                      Email: john.doe@example.com --}}
                    </address>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 invoice-col">
                    <b>Invoice # <code>{{$datapinjam->kodetrans}}</code></b><br>
                    {{-- <br> --}}
                    <b>Tanggal Pinjam:</b> {{Fungsi::tanggalgaring($datapinjam->tgl_pinjam)}}<br>
                    <b>Tanggal Harus Kembali:</b> {{Fungsi::tanggalgaring($datapinjam->tgl_harus_kembali)}}<br>
                    <b>Tanggal Dikembalikan:</b> {{Fungsi::tanggalgaringcreated($datapinjam->created_at)}}<br>
                    {{-- <b>Account:</b> 968-34567 --}}
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                  <div class="col-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                      <tr>
                        <th>Qty</th>
                        <th>Judul Buku</th>
                        <th>ISBN #</th>
                        <th>Penerbit</th>
                        <th>Status</th>
                        <th>Denda</th>
                      </tr>
                      </thead>
                      <tbody>
                          @php
                            $totaldenda=0;
                          @endphp
                        @foreach ($datas as $data)
                      <tr>
                        @php
                        $jmldatapinjam=DB::table('pengembaliandetail')->where('kodetrans',$datapinjam->kodetrans)->where('buku_kode',$data->buku_kode)->orderBy('created_at', 'desc')->count();

                        @endphp
                        <td>{{$jmldatapinjam}}</td>
                        <td>{{$data->buku_nama}}</td>
                        <td>{{$data->buku_isbn}}</td>
                        <td>{{$data->buku_penerbit}}</td>
                        @php
                        $statuspengembalian='Sudah Kembali';
                        @endphp

                        <td><code>{{$statuspengembalian}}</code></td>
                        <td >
                            @php
                                $dendatotalbuku=$data->totaldenda*$jmldatapinjam;
                                $totaldenda+=$dendatotalbuku;
                            @endphp
                          <span data-toggle="tooltip" data-placement="top" title="Terlambat {{Fungsi::periksaterlambat($data->tgl_harus_kembali)}} Hari!"> {{Fungsi::rupiah($dendatotalbuku)}}  </span>
                        </td>
                      </tr>
                      @endforeach
                      </tbody>
                    </table>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                  <!-- accepted payments column -->
                  <div class="col-6">
                    {{-- <p class="lead">Payment Methods:</p>
                    <img src="../../dist/img/credit/visa.png" alt="Visa">
                    <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                    <img src="../../dist/img/credit/american-express.png" alt="American Express">
                    <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                      Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                      plugg
                      dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                    </p> --}}
                  </div>
                  <!-- /.col -->
                  <div class="col-6">
                    {{-- <p class="lead">Amount Due 2/22/2014</p> --}}
                    <br>

                    <div class="table-responsive">
                      <table class="table">
                        {{-- <tr>
                          <th style="width:50%">Subtotal:</th>
                          <td>$250.30</td>
                        </tr>
                        <tr>
                          <th>Tax (9.3%)</th>
                          <td>$10.34</td>
                        </tr>
                        <tr>
                          <th>Shipping:</th>
                          <td>$5.80</td>
                        </tr> --}}
                        <tr>
                            <th> Denda terlambat per hari:</th>
                            <td>{{Fungsi::rupiah(Fungsi::defaultdenda())}}</td>
                          </tr>
                        <tr>
                          <th>Total Denda:</th>
                          <td>{{Fungsi::rupiah($totaldenda)}}</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                  <div class="col-12">
                    {{-- <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a> --}}
                    <a type="button" class="btn btn-default float-right" href="{{url('/invoice/'.$datapinjam->kodetrans)}}"><i class="fas fa-print"></i> Show
                    </a>
                    <a type="button" class="btn btn-primary float-right" style="margin-right: 5px;" href="{{url('/cetak/pengembalianshow/'.$datapinjam->kodetrans)}}">
                      <i class="fas fa-download"></i> Generate PDF
                    </a>
                    <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(url('/invoice/'.$datapinjam->kodetrans), 'QRCODE')}}" alt="barcode" class="float-left"/>
                </div>
              </div>
              <!-- /.invoice -->
<!-- /.content -->
            </div>
            <form action="{{route('admin.peminjaman.invoice.destroy',$datapinjam->kodetrans)}}" method="post" class="d-inline">
@method('delete')
@csrf
            <button class="btn btn-danger mr-1 btn-sm" style="margin-left: 5px;" onclick="return  confirm('Anda yakin menghapus data ini? Y/N')" ><span
                class="pcoded-micon"> <i class="fas fa-trash"></i></span></button>
            </form>
@endsection

@section('container-modals')

<!-- Import Excel -->
<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
