<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_historis', function (Blueprint $table) {
            $table->id('id_data');

            $table->unsignedBigInteger('id_user');

            $table->integer('total_tenaga');
            $table->integer('tenaga_produktif');
            $table->decimal('jam_kerja', 5, 2);
            $table->integer('target_produksi');

            $table->foreign('id_user')
                ->references('id_user')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_historis');
    }
};
