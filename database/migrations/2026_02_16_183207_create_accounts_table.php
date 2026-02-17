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
    Schema::create('accounts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('name'); // Ej: "Cuenta de ahorros", "Tarjeta Visa"
        $table->string('type'); // "checking", "savings", "credit_card", "cash"
        $table->decimal('balance', 15, 2)->default(0); // Saldo actual
        $table->string('currency', 3)->default('PEN'); // PEN, USD, EUR
        $table->string('color')->default('#10B981'); // Color para visualización
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
