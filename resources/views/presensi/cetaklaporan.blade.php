<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }

        /* rubah font */
        #title {
            /* font-family: Arial, Helvetica, sans-serif; */
            font-size: 16px;
            font-weight: bold;
        }

        .tabeldatakaryawan {
            margin-top: 40px;
        }

        .tabeldatakaryawan tr td {
            padding: 5px;
        }

        .tabelpresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tabelpresensi tr th {
            border: 1px solid #131212;
            padding: 8px;
            background-color: #dbdbdb;
        }

        .tabelpresensi tr td {
            border: 1px solid #131212;
            padding: 5px;
            font-size: 12px;
        }

        .foto {
            width: 40px;
            height: 30px;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">
    <!-- menghitung selisih waktu absen -->
    <!-- <?php
    // function selisih ($jam_masuk, $jam_keluar)
    // {
    //     list($h, $m, $s) = explode(":", $jam_masuk);
    //     $dtAwal = mktime($h, $m, $s, "1", "1", "1");
    //     list($h, $m, $s) = explode(":", $jam_keluar);
    //     $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
    //     $dtSelisih = $dtAkhir - $dtAwal;
    //     $totalmenit = $dtSelisih / 60;
    //     $jam = explode(".", $totalmenit / 60);
    //     $sisamenit = ($totalmenit / 60) - $jam[0];
    //     $sisamenit2 = $sisamenit * 60;
    //     $jml_jam = $jam[0];
    //     return $jml_jam . ":" . round($sisamenit2);
    // }
    ?> -->

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <table style="width: 100%">
            <tr>
                <td style="width: 30px">
                    <img src="{{ asset('assets/img/logo-MIM2.jpeg') }}" width="95" height="80" alt="">
                </td>
                <td>
                    <span id="title">
                        LAPORAN PRESENSI KARYAWAN<br>
                        PERIODE {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                        MIS MUHAMMADIYAH TARAMAN SRAGEN<br>
                    </span>
                    <span><i>Sembungan, Taraman, Sidoharjo, Sragen, Jawa Tengah 57821 Indonesia</i></span>
                </td>
            </tr>
        </table>

        <table class="tabeldatakaryawan">
            <tr>
                <td rowspan="4">
                    <!-- menampilkan foto -->
                    @php
                    $path = Storage::url('uploads/karyawan/'.$karyawan->foto);
                    @endphp
                    <img src="{{ url($path) }}" alt="" width="85px" height="100px">
                </td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td>{{ $karyawan->nip }}</td>
            </tr>
            <tr>
                <td>Nama Karyawan</td>
                <td>:</td>
                <td>{{ $karyawan->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>No HP</td>
                <td>:</td>
                <td>{{ $karyawan->no_hp }}</td>
            </tr>
        </table>

        <!-- menampilkan data presensi -->
        <button onclick="ExportToExcel('xlsx')" class="btn btn-success" style="float: right;margin-bottom:10px;">Export</button>
        <table class="tabelpresensi" id="tbl_exporttable_to_xls">
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Foto</th>
                <th>Jam Pulang</th>
                <th>Foto</th>
                <th>Keterangan</th>
            </tr>
            @foreach ($presensi as $d)
            @php
            $path_in = Storage::url('uploads/absensi/'.$d->foto_in);
            $path_out = Storage::url('uploads/absensi/'.$d->foto_out);
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ date("d-m-Y", strtotime($d->tgl_presensi)) }}</td>
                <td>{{ $d->jam_in }}</td>
                <td><img src="{{ url($path_in) }}" alt="" class="foto"></td>
                <td>{{ $d->jam_out !== null ? $d->jam_out : 'Belum Absen' }}</td>
                <td>
                    @if ($d->jam_out !== null)
                    <img src="{{ url($path_out) }}" alt="" class="foto">
                    @else
                    <img src="{{ asset('assets/img/nophoto.png') }}" alt="" class="foto">
                    @endif
                </td>
                <td>
                    @if ($d->jam_in > '07:00')
                    Terlambat
                    @else
                    Tepat Waktu
                    @endif
                </td>
            </tr>
            @endforeach
        </table>

        {{-- TTD --}}
        <br><br>
        <table style="float:right;text-align:center;">
            <tr><td>Sragen, {{ $date = date('d F Y'); }}</td></tr>
            <tr><td>&emsp;</td></tr>
            <tr><td style="opacity:10%;">TTD</td></tr>
            <tr><td>&emsp;</td></tr>
            <tr><td>...</td></tr>
        </table>
    </section>

</body>

    <script>

        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('tbl_exporttable_to_xls');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
            return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
                XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
        }

    </script>
</html>
