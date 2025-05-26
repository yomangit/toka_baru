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
        Schema::create('observer_actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('by_who')->nullable();
            $table->foreign('by_who')->references('id')->on('users')->onDelete('cascade');
            $table->string('action')->nullable();
            $table->string('due_date')->nullable();
            $table->string('completion_date')->nullable();
            $table->string('reference');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observer_actions');
    }
};
