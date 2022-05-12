@section('title')zzz
{{-- Laporan Pemasukan dan Pengeluaran di {{ $settings->sekolahnama }} --}}
@endsection

@section('kepsek')
asda
@endsection

@section('alamat')
asd23
@endsection

@section('telp')
qwe
@endsection

@section('namasekolah')
zxc
@endsection

@section('logo','logoyayasan.png')

{{-- DATATABLE --}}



<html>
    <head>
        <title>@yield('title')</title>
    </head>
    <body>
        <style type="text/css">
        table {
            border-spacing: 0;
            margin: 2px;
          }
        th {
                padding: 5px;
            }
        td {
                padding: 5px;
            }
            table tr td,
            table tr th{
                font-size: 12px;
                font-family: Georgia, 'Times New Roman', Times, serif;
            }
            td{
                height:10px;
            }
            body {
                font-size: 12px;
                font-family:Georgia, 'Times New Roman', Times, serif;
                }
            h1 h2 h3 h4 h5{
                line-height: 1.2;
            }
            .spa{
              letter-spacing:3px;
            }
          hr.style2 {
            border-top: 3px double #8c8b8b;
          }
        </style>
        {{-- <table width="100%" border="0">
            <tr>
            <td width="13%" align="right"><img src="assets/upload/logoyayasan.png" width="140" height="140"></td>
            <td width="80%" align="center"><p><b><font size="28px">YAYASAN PENDIDIKAN ISLAM <br> " {{Fungsi::sekolahnama()}} "</font><br>
              <font size="18px"> KENDAL PAYAK - KECAMATAN PAKISAJI - KABUPATEN MALANG</font>
            </b>
            <br>
            <br> <font size="14px">Sekretariat :{{Fungsi::sekolahalamat()}}. TELP. {{Fungsi::sekolahtelp()}}</font>
                                        </p>

                                        </td>
            <td widht="7%"></td>
            </tr>
            <tr>
                <td colspan="3"><hr  class="style2">
                </td>
            </tr>
            </table> --}}
            {{-- <center><h2>@yield('title')</h2></center> --}}

                <table width="100%" border="0">
                    <tr>
                        <td align="left" width="60%"><b>Nama : {{$datas->nama}} <br>
                        Nomer Identitas : {{$datas->nomeridentitas}}<br>
                        @php
                            if($datas->jaminan_nama==null){
                                $jaminan_nama=$datas->nomeridentitas;
                            }else{
                                $jaminan_nama=$datas->jaminan_nama;
                            }
                        @endphp
                        Jaminan : {{$datas->jaminan_tipe}} - {{$jaminan_nama}} <br>

                        </b></td>
                        <td align="left" width="40%"><b>Kode Transaksi : {{$datas->kodetrans}} <br>
                            Tamggal Pinjam :  {{Fungsi::tanggalgaring($datas->tgl_pinjam)}}<br>
                            Tanggal Harus Kembali :  {{Fungsi::tanggalgaring($datas->tgl_harus_kembali)}}<br>
                            Tanggal Dikembalikan :  {{Fungsi::tanggalgaringcreated($datas->created_at)}}
                         </b></td>

                    </tr>
                </table>
                <br>
                <table width="100%" border="1">
                    <tr>
                        <td align="center"><b>JUMLAH</b></td>
                        <td align="left"><b>JUDUL BUKU</b></td>
                        <td align="center"><b>ISBN</b></td>
                        <td align="center"><b>PENERBIT</b></td>
                        <td align="center"><b>STATUS</b></td>
                        <td align="center"><b>DENDA</b></td>

                    </tr>
                    @php
                    $totaldenda=0;
                    @endphp
                    @foreach ($detaildatas as $dd)
                        <tr>
                            <td align="center">
                                @php
                                $jmldatapinjam=DB::table('pengembaliandetail')->where('kodetrans',$datas->kodetrans)->where('buku_kode',$dd->buku_kode)->orderBy('created_at', 'desc')->count();
                                @endphp
                                {{$jmldatapinjam}}
                                </td>
                                <td>
                                    {{$dd->buku_nama}}
                                </td>
                                <td>
                                    {{$dd->buku_isbn}}
                                </td>
                                <td>
                                    {{$dd->buku_penerbit}}
                                </td>
                                <td>

                                    @php
                                        $statuspengembalian='Sudah Kembali';
                                    @endphp
                                {{$statuspengembalian}}
                                </td>


                                @php
                                $dendatotalbuku=$dd->totaldenda*$jmldatapinjam;
                                $totaldenda+=$dendatotalbuku;
                            @endphp
                                <td>
                                    {{Fungsi::rupiah($dendatotalbuku)}}
                                </td>
                        </tr>
                    @endforeach
                </table>


                <br>

                <table width="100%" border="0">
                    <tr>
                        <td align="left" width="70%">

                        </td>
                        <td align="left" width="30%"><b>Denda per hari : {{$datas->denda}} <br>
                            Total Denda :  {{Fungsi::rupiah($totaldenda)}}
                         </b></td>

                    </tr>
                </table>

                <br>
                <br>
                <br>

    <table width="100%" border="0">
        <tr>
            <th width="3%"></th>
            <th width="30%" align="center">
                <br>
               <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <br><br><br><br><br><br><br><br>
                {{-- <hr style="width:70%; border-top:2px dotted; border-style: none none dotted;  "> --}}

            </th>

            <th width="34%"></th>

            <th width="30%" align="center">

                <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(url('/invoice/'.$datas->kodetrans), 'QRCODE')}}" alt="barcode" width="150px" height="150px"/>


            </th>
            <th width="3%"></th>

        </tr>

    </table>

    </body>
    </html>
