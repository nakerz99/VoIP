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
        Schema::create('call_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('call_ticket_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('note');
            $table->enum('type', ['general', 'escalation', 'resolution', 'follow_up'])->default('general');
            $table->boolean('is_internal')->default(false); // internal agent notes vs customer-facing
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_notes');
    }
};
