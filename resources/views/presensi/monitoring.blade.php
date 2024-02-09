@extends('layouts.admin.tabler')
@section('content')
<!-- ... Bagian HTML sebelumnya ... -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <h2 class="page-title">
                    Monitoring Presensi
                </h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body" >
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <!-- ... (icon SVG) ... -->
                                        </svg>
                                    </span>
                                    <input type="text" id="tanggal" name="tanggal" value="" class="form-control" placeholder="Tanggal Presensi" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>NIP</th>
                                            <th>Nama Karyawan</th>
                                            <th>Jam Masuk</th>
                                            <th>Foto Masuk</th>
                                            <th>Jam Keluar</th>
                                            <th>Foto Keluar</th>
                                            <th>Keterangan</th>
                                            <th>Lokasi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="loadpresensi"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modal-tampilkan peta" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lokasi Presensi User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="loadmap">
            </div>
        </div>
    </div>
</div>
<!-- ... Bagian HTML setelahnya ... -->

@endsection

@push('myscript')
<script>
    $(function() {
        $("#tanggal").datepicker({ 
            autoclose: true, 
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });

        $("#tanggal").change(function(e) {
            var tanggal = $(this).val();
            $.ajax({
                type: 'POST',
                url: '/getpresensi',
                data: {
                    _token: "{{ csrf_token() }}",
                    tanggal: tanggal
                },
                cache: false,
                success: function(respond){
                    $("#loadpresensi").html(respond);
                }
            })
        });

    });
</script>
@endpush