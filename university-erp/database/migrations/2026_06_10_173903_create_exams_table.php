<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {

            $table->id();

            $table->foreignId('course_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('title');

            $table->enum('exam_type',[
                'Midterm',
                'Final',
                'Quiz',
                'Assignment',
                'Viva'
            ]);

            $table->date('exam_date');

            $table->integer('total_marks');

            $table->year('session');

            $table->integer('semester');

            $table->enum('status',[
                'upcoming',
                'completed'
            ])->default('upcoming');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};