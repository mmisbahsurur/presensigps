<?php

namespace App\Exports;

use App\Models\Lckh;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LckhExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $type = DB::table('lckh')->select('tanggal', 'kegiatan', 'output', 'keterangan')->get();
        return $type;
    }
    public function headings(): array
    {
        return [
            'tanggal',
            'kegiatan',
            'output',
            'keterangan'
        ];
    }
}
