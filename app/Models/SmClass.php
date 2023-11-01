<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'level',
        'class_code',
        'year',
        'class_teacher_id', // If using a foreign key to associate with a Teacher model
    ];

    // Define relationships if necessary
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function classTeacher()
    {
        return $this->belongsTo(Staff::class, 'class_teacher_id'); // Assuming you have a Teacher model
    }
}
