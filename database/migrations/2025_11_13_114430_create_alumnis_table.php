<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->year('graduation_year');
            $table->string('company')->nullable();
            $table->string('designation')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('alumni');
    }
};