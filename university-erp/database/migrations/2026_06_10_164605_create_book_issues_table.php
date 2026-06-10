<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_issues', function (Blueprint $table) {

            $table->id();

            $table->foreignId('student_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->foreignId('book_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->date('issue_date');

            $table->date('return_date');

            $table->date('actual_return_date')
                  ->nullable();

            $table->decimal('fine',10,2)
                  ->default(0);

            $table->enum('status',[
                'issued',
                'returned'
            ])->default('issued');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_issues');
    }
};