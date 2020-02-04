<!DOCTYPE html>
<html>

<head>
    <title>hi</title>
</head>

<body>
    <table width="100%" Height="100%" border="1">
        <thead>
        <tr>
            <td align="left" width="25%" rowspan="2">LOGO</td>
            <td width="50%" style="vertical-align:middle"></td>
            <td width="25%"><font size="9"><b>Supplier</b></font></td>
        </tr>
        <tr>
            <td width="50%" style="vertical-align:middle;text-align:center"><font size="11"><b>TANDA TERIMA FAKTUR SEMENTARA</b></font></td>
            <td width="25%"><font size="9">{{$SUPP_NAME}}</font></td>
        </tr>
        <tr>
            <td align="left" width="25%"></td>
            <td align="center" width=50%>
            <b>{{$TTF_NUM}} / {{$BRANCH_NAME}}</b>
            </td>
            <td align="left" width="25%"></td>
        </tr>
        <tr>
            <td align="left" width="25%"></td>
            <td align="center" width=50%>
                {{-- {{$barcode}} --}}

                <tcpdf method="write1DBarcode" params="{{$barcode}}" />
            </td>
            <td align="left" width="25%"></td>
        </tr>
        </thead>

        <tr>
            <td colspan="3">
            <br><br><br>
                {{-- <tcpdf method="writeHTML" params="{{$BPB_TTF}}, true, false, false, false, ''">" /> --}}
                {{$BPB_TTF}}
            </td>
        </tr>


            <tr>
                <td colspan="3" align="center">
                    <br>
                    <br>
                    <br> Harap Kembali pada tanggal <b>DD-MON-YY HH:MI:SS</b>
                    <br> (Untuk Proses Validasi)
                    <br>
                    <div>
                        {{$REPRINT_MARK}}
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="3" align="center">
                    <br>
                    <br>
                    <br>
                    <br>
                    <ul>
                        <li>Di cetak pada <b>DD-MON-YY HH:MI:SS</b></li>
                        <li>SYARAT DAN KETENTUAN BERLAKU</li>
                        <li>Jika ada perbedaan data antara dokumen tercetak dengan system Indogrosir , maka data yang valid ada pada system Indogrosir</li>
                    </ul>
                </td>
            </tr>

    </table>

</body>

</html>
