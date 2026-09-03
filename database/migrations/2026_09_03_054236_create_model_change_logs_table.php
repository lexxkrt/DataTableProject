<?php

use App\Models\User;
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
        Schema::create('model_change_logs', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->string('action');
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->string('username')->nullable();
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->json('changes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_change_logs');
    }
};
