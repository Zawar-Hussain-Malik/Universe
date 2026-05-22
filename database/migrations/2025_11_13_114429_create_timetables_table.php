<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('day');
            $table->string('time');
            $table->string('room_no');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('timetables');
    }
};