


<html>
    <head>
        <title>Cetak</title>
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
        <table width="100%" border="0">
            <tr>
            <td width="13%" align="right"><img src="assets/upload/logoyayasan.png" width="140" height="140"></td>

            <td width="80%" align="center"><p><b><font size="28px"> {{strtoupper(Fungsi::kop1())}} <br> " {{strtoupper(Fungsi::sekolahnama())}} "</font><br>
                <font size="18px"> {{strtoupper(Fungsi::kop3())}}</font>
              </b>
              <br>
              <br> <font size="14px">{{Fungsi::sekolahalamat()}}. Telp.{{Fungsi::sekolahtelp()}}  </font>
                                          </p>

                                          </td>
            {{-- <td width="80%" align="center"><p><b><font size="28px">YAYASAN PENDIDIKAN ISLAM <br> " MTS SHIROTHUL FUQOHA "</font><br>
              <font size="18px"> KENDAL PAYAK - KECAMATAN PAKISAJI - KABUPATEN MALANG</font>
            </b>
            <br>
            <br> <font size="14px">Sekretariat : Jl. Kendalpayak No.98 Pakisaji - Malang. TELP. 085746911467</font>
                                        </p>

                                        </td> --}}
            <td widht="7%"></td>
            </tr>
            <tr>
                <td colspan="3"><hr  class="style2">
                </td>
            </tr>
            </table>

                <h3>Data Pemasukan Bulan {{Fungsi::tanggalindonotgl($blnawal)}} - {{Fungsi::tanggalindonotgl($bln)}} </h3>
                <table width="100%" border="1">
                    <tr>
                        <th align="center" width="5%">
                            No
                        </th>
                        <th>
                            Nama Pemasukan
                        </th>
                        <th>
                            Tanggal
                        </th>
                        <th>
                            Nominal
                        </th>
                    </tr>


                    @foreach ($datas2 as $data)
                        <tr>
                            <td align="center" width="10%">{{$loop->index+1}}</td>
                            <td>{{$data->nama}}</td>
                            <td width="20%">{{Fungsi::tanggalindo($data->tglbayar)}}</td>
                            <td width="20%">{{Fungsi::rupiah($data->nominal)}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td align="center" colspan="3">Total Pemasukan</td>
                        <td>{{Fungsi::rupiah($totalnominal2)}}</td>
                    </tr>
                </table>

            </table>

            <h3>Data Pengeluaran Bulan {{Fungsi::tanggalindonotgl($blnawal)}} - {{Fungsi::tanggalindonotgl($bln)}}</h3>
                <table width="100%" border="1">
                    <tr>
                        <th align="center" width="5%">
                            No
                        </th>
                        <th>
                            Nama Pengeluaran
                        </th>
                        <th>
                            Tanggal
                        </th>
                        <th>
                            Nominal
                        </th>
                    </tr>


                    @foreach ($datas as $data)
                        <tr>
                            <td align="center" width="10%">{{$loop->index+1}}</td>
                            <td>{{$data->nama}}</td>
                            <td width="20%">{{Fungsi::tanggalindo($data->tglbayar)}}</td>
                            <td width="20%">{{Fungsi::rupiah($data->nominal)}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td align="center" colspan="3">Total Pengeluaran</td>
                        <td>{{Fungsi::rupiah($totalnominal)}}</td>
                    </tr>
                </table>




                <h3>Data Saldo Bulan {{Fungsi::tanggalindonotgl($blnawal)}} - {{Fungsi::tanggalindonotgl($bln)}}</h3>
                <table width="100%" border="1">
                    <tr>
                        <th>
                            Nama Transaksi
                        </th>
                        <th>
                            Nominal
                        </th>
                    </tr>


                    <tr>
                        <td  width="80%">Total Pemasukan</td>
                        <td>{{Fungsi::rupiah($totalnominal2)}}</td>
                    </tr>
                    <tr>
                        <td >Total Pengeluaran</td>
                        <td>{{Fungsi::rupiah($totalnominal)}}</td>
                    </tr>
                    <tr>
                        <td >Total Pemasukan dari Denda bulan   {{Fungsi::tanggalindonotgl($blnawal)}} - {{Fungsi::tanggalindonotgl($bln)}} </td>
                        <td>{{Fungsi::rupiah($totalnominaldenda)}}</td>
                    </tr>
                    <tr>
                        <td >Total Saldo = Total Pemasukan + Total Denda - Total Pengeluaran</td>
                        @php
                                $saldo=$totalnominal2+$totalnominaldenda-$totalnominal;
                        @endphp
                        <td> {{Fungsi::rupiah($saldo)}}</td>
                    </tr>
                </table>

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

            </th>

            <th width="34%"></th>

            <th width="30%" align="center">

                <br>Mengetahui,<br>
                <br><br>
                <br><br>
                <br><br>
                <br><br>
               <hr style="width:80%; border-top:2px dotted; border-style: none none dotted;  ">
                <b>{{Fungsi::sekolahttd()}}</b>
                <br>
                <br>
                <br>

            </th>

        </tr>
    </table>
    </body>
    </html>
