@extends('layouts.presensi')
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<!--mengatur ukuran tanggal/datepicker-->
<style>
    .datepicker-modal{
        max-height: 470px !important;
    }
    .datepicker-modal-display{
        background-color: #0f3a7e !important;
    }
</style>
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Form LCKH</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection
@section('content')
<div class="row" style="margin-top:70px">
    <div class="col">
        <form method="POST" action="/presensi/storelckh" id="frmLckh">
            @csrf
            <div class="form-group">
                <input type="text" id="tgl_lckh" name="tgl_lckh" class="form-control datepicker" placeholder="Tanggal">
            </div>
            <div class="form-group">
                <textarea name="nama_lengkap" id="nama_lengkap" cols="30" rows="2" class="form-control" placeholder="Nama Lengkap"></textarea>
            </div>
            <div class="form-group">
                <textarea name="kegiatan" id="kegiatan" cols="30" rows="2" class="form-control" placeholder="Kegiatan"></textarea>
            </div>
            <div class="form-group">
                <textarea name="output" id="output" cols="30" rows="2" class="form-control" placeholder="Output"></textarea>
            </div>
            <div class="form-group">
                <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control" placeholder="Keterangan"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary w-100">Kirim</button>
            </div>
        </form>
    </div>
</div>
@endsection
<!--menambahkan datepicker-->
@push('myscript')
<script>
    var currYear = (new Date()).getFullYear();

    $(document).ready(function() {
        $(".datepicker").datepicker({
            format: "yyyy-mm-dd"
        });

        //validasi lckh(tidak boleh kosong)
        $("#frmLckh").submit(function() {
            var tgl_lckh = $("#tgl_lckh").val();
            var nama_lengkap = $("#nama_lengkap").val();
            var kegiatan = $("#kegiatan").val();
            var output = $("#output").val();
            var keterangan = $("#keterangan").val();
            if (tgl_lckh == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Tanggal harus diisi',
                    icon: 'warning',
                });
                return false;
            } else if (nama_lengkap == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Nama Lengkap harus diisi',
                    icon: 'warning',
                });
                return false;
            } else if (kegiatan == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Kegiatan harus diisi',
                    icon: 'warning',
                });
                return false;
            } else if (output == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Output harus diisi',
                    icon: 'warning',
                });
                return false;
            } else if (keterangan == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Keterangan harus diisi',
                    icon: 'warning',
                });
                return false;
            }
        });
    });

</script>
@endpush
