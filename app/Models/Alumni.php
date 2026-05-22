<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alumni extends Model {
    use HasFactory;
    
    protected $table = 'alumni';
    
    protected $fillable = ['student_id','graduation_year','company','designation'];
    public function student() { return $this->belongsTo(Student::class); }
}