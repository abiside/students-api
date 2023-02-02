<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'name',
        'last_name',
        'email',
    ];

    public function courses()
    {
        $this->belongsToMany(Course::class);
    }
}
