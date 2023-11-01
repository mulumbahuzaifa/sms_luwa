<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'level',
        'description',
        'compulsory',
        'class_level',
        'teacher_id', // If using a foreign key to associate with a Teacher model
    ];

    // Define relationships if necessary
    public function teacher()
    {
        return $this->belongsTo(Staff::class); // Assuming you have a Teacher model
    }
}
