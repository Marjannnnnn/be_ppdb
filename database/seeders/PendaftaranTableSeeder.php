<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PendaftaranTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pendaftaran')->insert([
            'NISN' => 1234567894,
            'jenis_kelamin' => 'Laki-laki',
            'nama' => 'Kevin Yardan Fauzan',
            'asal_sekolah' => 'OPM Bandung',
            'email' => 'nivkaiser@gmail.com',
            'nomor_handphone' => 234567891678,
            'nomor_hp_ayah' => 234567891678,
            'nomor_hp_ibu' => 234567891678,
            'pilih_referensi' => 'iyah',
        ]);
    }
}
