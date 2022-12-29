<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';

    protected $fillable = [
        'NISN',
        'jenis_kelamin',
        'nama',
        'asal_sekolah',
        'email',
        'nomor_handphone',
        'nomor_hp_ayah',
        'nomor_hp_ibu',
        'pilih_referensi',
        'nama_bank',
        'pemilik_rekening',
        'nominal',
        'foto',
        'tervalidasi',
        'pembayaran'
    ];
}
