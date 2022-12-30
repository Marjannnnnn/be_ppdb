<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->string('NISN')->unique();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('nama');
            $table->string('asal_sekolah');
            $table->string('email')->unique();
            $table->string('nomor_handphone');
            $table->string('nomor_hp_ayah');
            $table->string('nomor_hp_ibu');
            $table->string('pilih_referensi');
            $table->string('nama_bank')->nullable();
            $table->string('pemilik_rekening')->nullable();
            $table->string('nominal')->nullable();
            $table->string('foto')->nullable();
            $table->enum('tervalidasi', ['diterima', 'ditolak'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendaftaran');
    }
};
