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
        Schema::create('prediksi_target', function (Blueprint $table) {
            $table->id('id_prediksi_target');

            $table->unsignedBigInteger('id_user');

            $table->dateTime('tanggal');

            $table->integer('total_tenaga');
            $table->integer('tenaga_produktif');
            $table->decimal('jam_kerja', 5, 2);

            $table->decimal('hasil_prediksi', 15, 2);

            $table->foreign('id_user')
                ->references('id_user')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prediksi_target');
    }
};
