<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model {
    use HasFactory;

    protected $fillable = ['course_id','title','description','due_date','file_path'];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function course() { return $this->belongsTo(Course::class); }
    public function submissions() { return $this->hasMany(Submission::class); }
}