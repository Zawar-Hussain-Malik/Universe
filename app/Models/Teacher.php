<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model {
    use HasFactory;
    protected $fillable = ['user_id','designation','department'];
    public function user() { return $this->belongsTo(User::class); }
    public function courses() { return $this->hasMany(Course::class); }
}