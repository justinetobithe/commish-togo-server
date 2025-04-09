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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('conversation_id')->constrained('conversations')->onDelete('cascade');
            $table->unsignedBigInteger('sender_id');
            $table->foreign('sender_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('recipient_id');
            $table->foreign('recipient_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
