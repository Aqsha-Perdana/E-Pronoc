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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->string('registration_code')->unique()->nullable(); // Generated after submit
            $table->string('title');
            $table->date('date');
            $table->string('focus_area'); // Bidang Fokus
            $table->string('focus');      // Topik Spesifik
            $table->longText('abstract')->nullable();
            $table->longText('introduction')->nullable();
            $table->longText('project_method')->nullable();
            $table->longText('bibliography')->nullable();
            $table->string('statement_letter')->nullable(); // File path
            $table->enum('status', ['DRAFT', 'SUBMITTED', 'APPROVED', 'REJECTED'])->default('DRAFT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
