<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('api_keys', function (Blueprint $table) {
            $table->id(); // Uses bigint auto-increment
            $table->string('name');
            $table->string('mask')->unique();
            $table->text('value'); // Encrypted API key
            $table->string('hash')->unique(); // SHA-256 hash for verification
            $table->unsignedBigInteger('user_id'); // Match users.id type
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_keys');
    }
};
