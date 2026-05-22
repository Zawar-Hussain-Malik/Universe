<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('roll_no')->unique();
            $table->string('department');
            $table->string('semester');
            $table->string('section')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('students');
    }
};