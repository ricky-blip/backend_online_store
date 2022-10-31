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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merk_id'); //FK
            $table->string('nama_product');
            $table->double('harga');
            $table->string('gambar')->nullable();
            $table->text('spesifikasi');
            $table->enum('status',['0','1']);
            $table->timestamps();

            $table->foreign('merk_id')->references('id')->on('merks')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
