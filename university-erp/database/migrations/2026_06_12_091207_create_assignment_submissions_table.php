<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->datetime('submission_date');
            $table->string('file_path')->nullable();
            $table->text('comments')->nullable();
            $table->float('marks')->nullable();
            $table->text('feedback')->nullable();
            $table->string('status')->default('pending');
            $table->foreignId('graded_by')->nullable()->constrained('teachers')->onDelete('set null');
            $table->datetime('graded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assignment_submissions');
    }
};