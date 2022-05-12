


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
        @for ($data=0; $data<$jmldata ; $data++ )
        <table width="100%" border="0">
            @php
                $datas=DB::table('buku')->where('id',$str[$data])->first();
            @endphp
            <tr>
                <td width="40%"><font size="20px">JUDUL BUKU</font></td>
                <td><font size="20px">{{$datas->nama}} </font></td>
         
            </tr>
                <tr>
                    <td width="40%"><font size="20px">DDC</font></td>
                    <td><font size="20px">{{$datas->bukukategori_ddc}} </font></td>
             
                </tr>
                <tr>
                    <td width="40%"><font size="20px">PENGARANG</font></td>
                    <td><font size="20px">{{$datas->pengarang}} </font></td>
             
                </tr>
                <tr>
                    <td width="40%"><font size="20px">ISBN</font></td>
                    <td><font size="20px">{{$datas->isbn}}</font></td>
             
                </tr>
            </table>
            <br>
            <br>
            <hr>
            <br>
            <br>
            
        <table width="100%" border="1">
            <tr>
                <th width="10%">No</th>
                <th>Nama Peminjam</th>
                <th width="30%">Tanggal Kembali</th>
            </tr>
@php
    $jmlrow=10;
@endphp
@for ($i=0; $i <$jmlrow ; $i++)
    <tr>
        <td></td>
        <td></td>
        <td></td>
    </tr>

@endfor

            </table>
            {{-- <center><h2>@yield('title')</h2></center> --}}

               

                <br>
                <br>
            
                @endfor

    </body>
    </html>
