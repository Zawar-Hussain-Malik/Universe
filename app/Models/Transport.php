<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transport extends Model {
    use HasFactory;
    
    protected $table = 'transport';
    
    protected $fillable = ['student_id','route','bus_no','driver'];
    public function student() { return $this->belongsTo(Student::class); }
}