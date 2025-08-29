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
        Schema::create('hasil_voting', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('id_user'); 
            $table->unsignedBigInteger('id_calon'); 
            $table->datetime('tanggal')->default(DB::raw('CURRENT_TIMESTAMP')); 
            $table->timestamps(); 

       
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_calon')->references('id')->on('calon_osis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hasil_voting');
    }
};
