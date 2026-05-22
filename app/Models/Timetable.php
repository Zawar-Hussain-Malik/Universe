<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Timetable extends Model {
    use HasFactory;
    protected $fillable = ['course_id','day','time','room_no'];
    public function course() { return $this->belongsTo(Course::class); }
}