<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function proseslogin(Request $request)
    {
        if (Auth::guard('karyawan')->attempt(['nip'=> $request->nip, 'password' => $request->password])) {
            return redirect('/dashboard');
        } else {
            return redirect('/')->with(['warning' => 'NIP / Password Salah']);
        }
    }

    public function proseslogout(){
        if(Auth::guard('karyawan')->check()){
            Auth::guard('karyawan')->logout();
            return redirect('/');
        }
    }

    //proses logout admin
    public function proseslogoutadmin()
    {
        if(Auth::guard('user')->check()){
            Auth::guard('user')->logout();
            return redirect('/panel');
        }
    }

    //proses login admin
    public function prosesloginadmin(Request $request)
    {
        if (Auth::guard('user')->attempt(['email'=> $request->email, 'password' => $request->password])) {
            return redirect('/panel/dashboardadmin');
        } else {
            return redirect('/panel')->with(['warning' => 'Username atau Password Salah']);
        }
    }

    // Di dalam controller yang sesuai
    public function getPresensi(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $presensiData = Presensi::whereDate('tanggal', $tanggal)->get();

        return view('nama.view.presensi', ['presensiData' => $presensiData]);
    }
}


