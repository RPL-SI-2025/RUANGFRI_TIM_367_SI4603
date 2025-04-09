<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class laporinventaris extends Model
{
    protected $table = 'laporinventaris';

    protected $primaryKey = 'id';

    protected $fillable = ['id_logistik', 'id_mahasiswa', 'datetime', 'foto_awal', 'foto_akhir', 'deskripsi'];


    public static function getData($nim, $password)
    {
        return self::join('mahasiswa', 'laporinventaris.id_mahasiswa', '=', 'mahasiswa.id')
                    ->where('mahasiswa.nim', $nim)
                    ->where('mahasiswa.password', $password)
                    ->select('laporinventaris.*', 'mahasiswa.nama as nama_mahasiswa')
                    ->get();
    }


    public static function updateData($id, $data)
    {
        $laporan = self::find($id);
        if ($laporan) {
            $laporan->update([
                'id_logistik'  => $data['id_logistik'] ?? $laporan->id_logistik,
                'id_mahasiswa' => $data['id_mahasiswa'] ?? $laporan->id_mahasiswa,
                'datetime'     => $data['datetime'] ?? $laporan->datetime,
                'foto_awal'    => $data['foto_awal'] ?? $laporan->foto_awal,
                'foto_akhir'   => $data['foto_akhir'] ?? $laporan->foto_akhir,
                'deskripsi'    => $data['deskripsi'] ?? $laporan->deskripsi,
            ]);
            return true;
        }
        return false;
    }
}


