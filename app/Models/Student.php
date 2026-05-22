<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model {
    use HasFactory;
    protected $fillable = ['user_id','roll_no','father_name','dob','city','phone','blood_group','profile_pic','department','semester','section'];
    public function user() { return $this->belongsTo(User::class); }
    public function enrollments() { return $this->hasMany(Enrollment::class); }
    public function results() { return $this->hasMany(Result::class); }
    public function attendance() { return $this->hasMany(Attendance::class); }
    public function fees() { return $this->hasMany(Fee::class); }
    public function transport() { return $this->hasOne(Transport::class); }
    public function submissions() { return $this->hasMany(Submission::class); }
    public function alumni() { return $this->hasOne(Alumni::class); }
}