<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->decimal('midterm_marks', 5, 2)->default(0);
            $table->decimal('final_marks', 5, 2)->default(0);
            $table->decimal('assignment_marks', 5, 2)->default(0);
            $table->decimal('total_marks', 5, 2)->default(0);
            $table->string('grade')->nullable();
            $table->decimal('gpa', 3, 2)->default(0);
            $table->year('session')->default(date('Y'));  // Add default value
            $table->integer('semester')->default(1);  // Add default value
            $table->timestamps();
            $table->unique(['student_id', 'course_id', 'session', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};