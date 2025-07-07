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
        Schema::create('call_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caller_id')->constrained()->onDelete('cascade');
            $table->foreignId('agent_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('phone_number');
            $table->enum('call_type', ['inbound', 'outbound', 'transferred', 'missed']);
            $table->enum('status', ['completed', 'abandoned', 'transferred', 'voicemail']);
            $table->timestamp('call_started_at');
            $table->timestamp('call_ended_at')->nullable();
            $table->integer('call_duration')->default(0); // in seconds
            $table->text('summary')->nullable();
            $table->string('voip_call_id')->nullable(); // for 3CX integration
            $table->json('voip_metadata')->nullable(); // additional VOIP data
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_logs');
    }
};
