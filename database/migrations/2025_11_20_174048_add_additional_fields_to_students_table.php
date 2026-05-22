<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('father_name')->nullable()->after('roll_no');
            $table->date('dob')->nullable()->after('father_name');
            $table->string('city')->nullable()->after('dob');
            $table->string('phone')->nullable()->after('city');
            $table->string('blood_group')->nullable()->after('phone');
            $table->string('profile_pic')->nullable()->after('blood_group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['father_name', 'dob', 'city', 'phone', 'blood_group', 'profile_pic']);
        });
    }
};
