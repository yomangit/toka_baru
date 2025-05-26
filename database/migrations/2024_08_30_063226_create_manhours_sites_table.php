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
        Schema::create('manhours_sites', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->integer('Company_Employee')->nullable();
            $table->integer('Company_Workhours')->nullable();
            $table->integer('Company_Cummulatives')->nullable();
            $table->integer('Contractor_Employee')->nullable();
            $table->integer('Contractor_Workhours')->nullable();
            $table->integer('Contractor_Cummulatives')->nullable();
            $table->integer('Total_Employee')->nullable();
            $table->integer('Total_Workhours')->nullable();
            $table->integer('Total_Cummulatives')->nullable();
            $table->integer('Cummulatives_Manhours_By_LTI')->nullable();
            $table->integer('Manhours_Lost')->nullable();
            $table->integer('LTI')->nullable();
            $table->integer('LTI_Date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manhours_sites');
    }
};
