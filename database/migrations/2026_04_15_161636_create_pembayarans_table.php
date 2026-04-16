<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periksa_id')->constrained('periksa')->cascadeOnDelete();
            $table->string('bukti_bayar')->nullable(); // Untuk menyimpan path foto
            $table->enum('status', ['menunggu', 'lunas'])->default('menunggu'); // Default menunggu
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayarans');
    }
};