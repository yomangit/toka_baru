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
        Schema::create('event_keywords', function (Blueprint $table) {
            $table->id();
            $table->string('report_type')->nullable();
            $table->string('keyword')->nullable();
            $table->string('reference')->nullable();
            $table->string('event_date')->nullable();
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_keywords');
    }
};
