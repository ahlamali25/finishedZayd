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
        Schema::table('teacher_applications', function (Blueprint $table) {
            $table->string('certificate_path')->nullable()->after('motivation');
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete()->after('status');
            $table->timestamp('processed_at')->nullable()->after('processed_by');
            $table->text('review_notes')->nullable()->after('processed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teacher_applications', function (Blueprint $table) {
            $table->dropColumn(['certificate_path', 'processed_at', 'review_notes']);
            $table->dropForeign(['processed_by']);
            $table->dropColumn('processed_by');
        });
    }
};
