<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parent extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'address',
    ];

    // Define any relationships if needed
    // For example, if a parent can have multiple students, you can define a relationship like this:
    // public function students()
    // {
    //     return $this->hasMany(Student::class);
    // }
}
