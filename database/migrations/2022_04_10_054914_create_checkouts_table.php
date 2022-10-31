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
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi');
            $table->string('nama');
            $table->string('nohp');
            $table->string('kota_kecamatan');
            $table->text('alamat');
            $table->text('catatan')->nullable();
            $table->enum('jenis_pembayaran',['TF','COD']);
            $table->enum('jenis_pengiriman',['J&T', 'JNE', 'Sicepat' ]);
            $table->double('ongkir');
            $table->double('grand_total');
            $table->enum('status',['0','1']);
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
        Schema::dropIfExists('checkouts');
    }
};
