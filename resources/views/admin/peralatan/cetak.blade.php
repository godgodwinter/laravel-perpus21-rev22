


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
            <td widht="7%"></td>
            </tr>
            <tr>
                <td colspan="3"><hr  class="style2">
                </td>
            </tr>
            </table>
            {{-- <center><h2>@yield('title')</h2></center> --}}

                <h3>Laporan Pengunjung </h3>
                <table width="100%" border="1">
                    <tr>
                      <td align="center">No</td>
                      <td align="left"><b>Nama</b></td>
                      <td align="center"><b> Tanggal Barang Masuk</b></td>
                    </tr>
                    @foreach ($datas as $data)
                        <tr>
                            <td align="center">{{$loop->index+1}}</td>
                            <td>{{$data->nama}}</td>
                            <td>{{Fungsi::tanggalindocreated($data->created_at)}}</td>
                        </tr>
                    @endforeach
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
                {{-- <hr style="width:70%; border-top:2px dotted; border-style: none none dotted;  "> --}}

            </th>

            <th width="34%"></th>

            <th width="30%" align="center">
                {{-- .........,..........................,  @php
               echo  date('Y');
            @endphp --}}

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
                {{-- <img src="data:image/png;base64,{{DNS2D::getBarcodePNG(url('/pengunjung/cetak/'), 'QRCODE')}}" alt="barcode" width="150px" height="150px"/> --}}

            </th>

        </tr>
    </table>
    </body>
    </html>
