<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('results', function (Blueprint $table) {
            // Add missing columns
            $table->string('exam_name')->nullable()->after('course_id');
            $table->date('exam_date')->nullable()->after('exam_name');
            $table->integer('total_marks')->default(100)->after('marks');
            $table->foreignId('teacher_id')->nullable()->after('student_id')->constrained()->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('results', function (Blueprint $table) {
            $table->dropColumn(['exam_name', 'exam_date', 'total_marks', 'teacher_id']);
        });
    }
};