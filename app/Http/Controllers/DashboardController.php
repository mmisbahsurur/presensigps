<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        //menampilkan jam masuk/pulang di dashboard
        $hariini = date("Y-m-d");
        $bulanini = date("m") * 1; //1 atau Januari
        $tahunini = date("Y"); //2023
        $nip = Auth::guard('karyawan')->user()->nip;
        $presensihariini = DB::table('presensi')->where('nip', $nip)->where('tgl_presensi', $hariini)->first();
        //rekap presensi sebulan
        $historibulanini = DB::table('presensi')
            ->where('nip', $nip)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
            ->orderBy('tgl_presensi')
            ->get(); 

        $rekappresensi = DB::table('presensi')
            ->selectRaw('COUNT(nip) as jmlhadir, SUM(IF(jam_in > "07:00",1,0)) as jmlterlambat')
            ->where('nip', $nip)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
            ->first();
        
        //bagian leaderbard
        $leaderboard = DB::table('presensi')
            ->join('karyawan', 'presensi.nip', '=', 'karyawan.nip')
            ->where('tgl_presensi', $hariini)
            ->orderBy('jam_in')
            ->get();

        //nama bulan direkap bagian dashboard bisa berganti
        $namabulan = ["", "Januari","Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        
        //rekap izin didashboard
        $rekapizin = DB::table('pengajuan_izin')
            ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('nip', $nip)
            ->whereRaw('MONTH(tgl_izin)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_izin)="' . $tahunini . '"')
            ->where('status_approved', 1)
            ->first();

        return view('dashboard.dashboard', compact('presensihariini', 'historibulanini', 'namabulan', 'bulanini', 'tahunini', 'rekappresensi', 'leaderboard', 'rekapizin'));
    }

    //method dashboard admin
    public function dashboardadmin()
    {
        //rekap presensi dashboard admin (/hari)
        $hariini = date("Y-m-d");
        $rekappresensi = DB::table('presensi')
            ->selectRaw('COUNT(nip) as jmlhadir, SUM(IF(jam_in > "07:00",1,0)) as jmlterlambat')
            ->where('tgl_presensi', $hariini)
            ->first();

        $rekapizin = DB::table('pengajuan_izin')
            ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('tgl_izin', $hariini)
            ->where('status_approved', 1)
            ->first();
        
        return view('dashboard.dashboardadmin', compact('rekappresensi', 'rekapizin'));
    }
}
