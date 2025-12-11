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
        Schema::create('final_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposals_id');
            $table->string('title');
            $table->date('date')->nullable();
            $table->string('focus_area')->nullable();
            $table->string('focus')->nullable();
            $table->text('abstract')->nullable();
            $table->text('introduction')->nullable();
            $table->text('project_method')->nullable();
            $table->text('bibliography')->nullable();
            $table->string('statement_letter')->nullable();
            $table->string('status')->default('Pending');
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
        Schema::dropIfExists('final_reports');
    }
};
