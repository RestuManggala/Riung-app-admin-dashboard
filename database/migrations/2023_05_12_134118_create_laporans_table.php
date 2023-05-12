<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bank')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('rincian_transaksi')->nullable();
            $table->string('debit')->nullable();
            $table->string('kredit')->nullable();
            $table->string('no_dokumen')->nullable();
            $table->string('analisis_input')->nullable();
            $table->bigInteger('id_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
