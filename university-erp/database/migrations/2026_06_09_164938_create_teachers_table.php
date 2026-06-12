<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            // Check and add columns only if they don't exist
            if (!Schema::hasColumn('teachers', 'dob')) {
                $table->date('dob')->nullable();
            }
            if (!Schema::hasColumn('teachers', 'gender')) {
                $table->enum('gender', ['male', 'female', 'other'])->nullable();
            }
            if (!Schema::hasColumn('teachers', 'qualification')) {
                $table->text('qualification')->nullable();
            }
            if (!Schema::hasColumn('teachers', 'address')) {
                $table->text('address')->nullable();
            }
            if (!Schema::hasColumn('teachers', 'bio')) {
                $table->text('bio')->nullable();
            }
            if (!Schema::hasColumn('teachers', 'blood_group')) {
                $table->string('blood_group')->nullable();
            }
            if (!Schema::hasColumn('teachers', 'emergency_contact')) {
                $table->string('emergency_contact')->nullable();
            }
            if (!Schema::hasColumn('teachers', 'national_id')) {
                $table->string('national_id')->nullable();
            }
            if (!Schema::hasColumn('teachers', 'website')) {
                $table->string('website')->nullable();
            }
            if (!Schema::hasColumn('teachers', 'linkedin')) {
                $table->string('linkedin')->nullable();
            }
            if (!Schema::hasColumn('teachers', 'facebook')) {
                $table->string('facebook')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn([
                'dob', 'gender', 'qualification', 'address', 'bio',
                'blood_group', 'emergency_contact', 'national_id',
                'website', 'linkedin', 'facebook'
            ]);
        });
    }
};