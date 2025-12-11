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
        Schema::table('progress_reports', function (Blueprint $table) {
            $table->string('focus_area')->nullable()->after('status');
            $table->string('focus')->nullable()->after('focus_area');
            $table->text('introduction')->nullable()->after('focus');
            $table->text('project_method')->nullable()->after('introduction');
            $table->text('results')->nullable()->after('project_method');
            $table->text('bibliography')->nullable()->after('results');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progress_reports', function (Blueprint $table) {
            $table->dropColumn(['focus_area', 'focus', 'introduction', 'project_method', 'results', 'bibliography']);
        });
    }
};
