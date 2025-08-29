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
        Schema::create('calon_osis', function (Blueprint $table) {
            $table->id(); // Primary key, auto increment
            $table->unsignedBigInteger('id_user'); // Foreign key untuk tabel user
            $table->string('nama_calon', 35); // Nama calon
            $table->text('visimisi'); // Kolom visimisi
            $table->string('NIS', 255); // NIS
            $table->string('kelas', 25); // Kelas
            $table->string('gambar', 50)->nullable(); // Gambar (opsional)
            $table->string('slogan', 255)->nullable(); // Slogan (opsional)
            $table->integer('jumlah_vote')->nullable(); // Jumlah vote (default NULL)
            $table->string('periode', 12); // Periode
            $table->timestamps(); // Kolom created_at dan updated_at
            $table->softDeletes(); // Kolom deleted_at untuk soft delete

            // Tambahkan index atau foreign key jika diperlukan
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calon_osis');
    }
};
