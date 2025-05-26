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
        Schema::create('event_user_securities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('responsible_role_id')->nullable();
            $table->foreign('responsible_role_id')->references('id')->on('responsible_roles')->onDelete('cascade');
            $table->unsignedBigInteger('division_id')->nullable();
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('type_event_report_id')->nullable();
            $table->foreign('type_event_report_id')->references('id')->on('type_event_reports')->onDelete('cascade');
            $table->unsignedBigInteger('company_category_id')->nullable();
            $table->foreign('company_category_id')->references('id')->on('company_categories')->onDelete('cascade');
            $table->unsignedBigInteger('busines_unit_id')->nullable();
            $table->foreign('busines_unit_id')->references('id')->on('busines_units')->onDelete('cascade');
            $table->unsignedBigInteger('dept_by_business_unit_id')->nullable();
            $table->foreign('dept_by_business_unit_id')->references('id')->on('dept_by_business_units')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_user_securities');
    }
};
