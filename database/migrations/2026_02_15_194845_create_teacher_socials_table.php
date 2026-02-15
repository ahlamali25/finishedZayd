<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_socials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id'); // ربط الرابط بالمعلمة
            $table->string('facebook_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_socials');
    }
};