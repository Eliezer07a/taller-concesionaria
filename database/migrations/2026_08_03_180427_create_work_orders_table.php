<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnostic_ticket_id')->constrained()->onDelete('cascade');
            $table->string('tracking_code')->unique();
            $table->text('description');
            $table->decimal('cost', 10, 2);
            $table->string('status')->default('en_proceso');
            $table->string('current_progress')->default('0%');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
