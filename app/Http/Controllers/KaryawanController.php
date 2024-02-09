<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        // kolom pencarian di data karyawan admin
        $query = Karyawan::query();
        $query->select('karyawan.*');
        //menampilkan data pada table dashboard admin
        $query->orderBy('nama_lengkap');
        if ($request->has('cari')) {
            $query->where('nama_lengkap', 'like', '%' . $request->cari . '%');
        }
        //banyaknya data yg ditampilkan disetiap halaman
        $karyawan = $query->paginate(10);

        return view('karyawan.index', compact('karyawan'));
    }

    public function store(Request $request) 
    {
        $nip = $request->nip;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make('12345');
        
        if($request->hasFile('foto')){
            $foto = $nip. "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = null;
        }

        // proses simpan data
        try {
            $data = [
                'nip' => $nip,
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto,
                'password' => $password
            ];
            $simpan = DB::table('karyawan')->insert($data);
            if ($simpan) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                
            }return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            //dd($e->message);
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    //function edit karyawan bagian admin
    public function edit(Request $request)
    {
        $nip = $request->nip;
        $karyawan = DB::table('karyawan')->where('nip', $nip)->first();
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update($nip, Request $request){
        $nip = $request->nip;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make('12345');
        $old_foto = $request->old_foto;
        if($request->hasFile('foto')){
            $foto = $nip. "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $old_foto;
        }

        // proses simpan data
        try {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto,
                'password' => $password
            ];
            $update = DB::table('karyawan')->where('nip', $nip)->update($data);
            if ($update) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $folderPathOld = "public/uploads/karyawan/" . $old_foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                
            }return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
        } catch (\Exception $e) {
            //dd($e->message);
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    //proses delete data karyawan di admin
    public function delete($nip){
        $delete = DB::table('karyawan')->where('nip', $nip)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }
}
