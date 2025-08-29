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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('kelamin');
            $table->dropColumn('alamat');
            $table->enum('status_pemilihan', ['Belum Memilih', 'Sudah Memilih'])->after('password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('kelamin', ['laki-laki','perempuan']);
            $table->string('alamat');
            $table->dropColumn('status_pemilihan');
        });
    }
};
