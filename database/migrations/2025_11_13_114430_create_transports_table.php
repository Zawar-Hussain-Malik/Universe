<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('transport', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('route');
            $table->string('bus_no');
            $table->string('driver')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('transport');
    }
};