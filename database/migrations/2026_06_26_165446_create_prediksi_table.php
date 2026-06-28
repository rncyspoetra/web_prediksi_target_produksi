<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prediksi', function (Blueprint $table) {
            $table->id('id_prediksi');

            $table->unsignedBigInteger('id_data');

            $table->decimal('hasil_prediksi', 15, 2);
            $table->decimal('nilai_error', 15, 2);
            $table->decimal('persentase_error', 8, 2);

            $table->foreign('id_data')
                ->references('id_data')
                ->on('data_historis')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prediksi');
    }
};
