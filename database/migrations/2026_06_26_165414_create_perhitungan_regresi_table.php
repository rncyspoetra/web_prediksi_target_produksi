<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perhitungan_regresi', function (Blueprint $table) {
            $table->id('id_perhitungan_regresi');

            $table->unsignedBigInteger('id_user');

            $table->decimal('intercept', 15, 6);
            $table->decimal('beta1', 15, 6);
            $table->decimal('beta2', 15, 6);
            $table->decimal('beta3', 15, 6);

            $table->foreign('id_user')
                ->references('id_user')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perhitungan_regresi');
    }
};
