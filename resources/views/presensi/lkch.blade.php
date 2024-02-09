@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">LCKH</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection

<!--membuat button upload surat izin-->
@section ('content')
<div class="row" style="margin-top:70px">
    <div class="col">
        @php 
        $messagesuccess = Session::get('success');
        $messageerror = Session::get('error');
        @endphp
        @if(Session::get('success'))
        <div class="alert alert-success">
            {{ $messagesuccess }}
        </div>
        @endif
        @if(Session::get('error'))
        <div class="alert alert-danger">
            {{ $messageerror }}
        </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col">
        @foreach ($datalkch as $d)
        <ul class="listview image-listview">
            <li>
                <div class="item">
                    <div class="in">
                        <div>
                            <b>{{ $d->tanggal }} ({{ $d->kegiatan }})</b><br>
                            <small class="text-muted">{{ $d->output }}</small>
                        </div>
                        <span class="badge bg-success">{{ $d->keterangan}}</span>
                        
                    </div>
                </div>
            </li>
        </ul>
        @endforeach
    </div>
</div>
<div class="fab-button bottom-right" style="margin-bottom:70px">
    <a href="/presensi/buatlckh" class="fab">
        <ion-icon name="add-outline"></ion-icon>
    </a>
</div>
@endsection