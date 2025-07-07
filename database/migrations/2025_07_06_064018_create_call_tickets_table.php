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
        // Make sure the callers table exists before creating this relationship
        if (!Schema::hasTable('callers')) {
            Schema::create('callers', function (Blueprint $table) {
                $table->id();
                $table->string('phone_number')->unique();
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->text('address')->nullable();
                $table->string('company')->nullable();
                $table->text('notes')->nullable();
                $table->boolean('is_blocked')->default(false);
                $table->json('metadata')->nullable(); // for additional caller information
                $table->timestamps();
            });
        }
        
        Schema::create('call_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caller_id')->constrained()->onDelete('cascade');
            $table->foreignId('agent_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('phone_number');
            $table->string('caller_name')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'completed', 'forwarded', 'escalated'])->default('active');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->timestamp('call_started_at');
            $table->timestamp('call_ended_at')->nullable();
            $table->integer('call_duration')->nullable(); // in seconds
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
        Schema::dropIfExists('call_tickets');
    }
};
