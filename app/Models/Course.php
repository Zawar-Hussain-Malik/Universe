<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model {
    use HasFactory;
    protected $fillable = ['name','code','credit_hours','department','teacher_id'];
    public function teacher() { return $this->belongsTo(Teacher::class); }
    public function enrollments() { return $this->hasMany(Enrollment::class); }
    public function assignments() { return $this->hasMany(Assignment::class); }
    public function attendance() { return $this->hasMany(Attendance::class); }
    public function results() { return $this->hasMany(Result::class); }
    public function timetable() { return $this->hasOne(Timetable::class); }
}