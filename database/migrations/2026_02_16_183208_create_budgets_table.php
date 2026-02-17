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
    Schema::create('budgets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->decimal('amount', 15, 2); // Límite del presupuesto
        $table->string('period'); // "monthly", "weekly", "yearly"
        $table->date('start_date');
        $table->date('end_date');
        $table->boolean('alert_enabled')->default(true);
        $table->integer('alert_percentage')->default(80); // Alertar al 80%
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
