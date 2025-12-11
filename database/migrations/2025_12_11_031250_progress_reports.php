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
        Schema::create('progress_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposals_id');
            $table->date('report_date');
            $table->text('progress_description')->nullable();
            $table->integer('percentage_complete')->default(0);
            $table->string('status')->default('In Progress'); // In Progress, Blocked, Complete, On Hold
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('proposals_id')
                ->references('id')
                ->on('proposals')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_report');
    }
};
