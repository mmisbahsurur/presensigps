<?php

namespace App\Http\Controllers;

use App\Exports\LckhExport;
use App\Models\Lckh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;

class LCKHController extends Controller
{
    public function index(Request $request){
        // kolom pencarian di data karyawan admin
        $query = Lckh::query();
        $query->select('lckh.*');
        //menampilkan data pada table dashboard admin
        $query->orderBy('kegiatan');
        if ($request->has('cari')) {
            $query->where('nama_lengkap', 'like', '%' . $request->cari . '%');
            $query->orwhere('kegiatan', 'like', '%' . $request->cari . '%');
            $query->orWhere('output', 'like', '%' . $request->cari . '%');
            $query->orWhere('keterangan', 'like', '%' . $request->cari . '%');
        }

        //banyaknya data yg ditampilkan disetiap halaman
        $lckh = $query->paginate(10);
        return view('lckh.index', compact('lckh'));
    }

    public function store(Request $request) 
    {
        $tanggal        = $request->tanggal;
        $nama_lengkap   = $request->nama_lengkap;
        $kegiatan       = $request->kegiatan;
        $output         = $request->output;
        $keterangan     = $request->keterangan;

        // proses simpan data
        try {
            $data = [
                'tanggal' => $tanggal,
                'nama_lengkap' =>$nama_lengkap,
                'kegiatan' => $kegiatan,
                'output' => $output,
                'keterangan' => $keterangan,
                'created_at' => now(),
            ];
            $simpan = DB::table('lckh')->insert($data);
            
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    //function edit karyawan bagian admin
    public function edit(Request $request)
    {
        $id = $request->id;
        $lckh = DB::table('lckh')->where('id', $id)->first();
        return view('lckh.edit', compact('lckh'));
    }

    public function update($id, Request $request){
        $tanggal        = $request->tanggal;
        $nama_lengkap   = $request->nama_lengkap;
        $kegiatan       = $request->kegiatan;
        $output         = $request->output;
        $keterangan     = $request->keterangan;
        
        try {

            $data = [
                'tanggal' => $tanggal,
                'nama_lengkap' => $nama_lengkap,
                'kegiatan' => $kegiatan,
                'output' => $output,
                'keterangan' => $keterangan,
                'created_at' => now(),
            ];
            $update = DB::table('lckh')->where('id', $id)->update($data);
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
        
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    //proses delete data karyawan di admin
    public function delete($id){
        $delete = DB::table('lckh')->where('id', $id)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function export_excel(Request $request)
	{
        return Excel::download(new LckhExport, 'data.xlsx');
	}

}
