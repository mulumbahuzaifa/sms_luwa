<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'email',
        'phone_number',
        'address',
        'role',
        'employee_id',
        'joining_date',
        'salary',
        'qualifications',
        'department_id', // If using a foreign key to associate with a Department model
    ];

    // Define relationships if necessary
    public function department()
    {
        return $this->belongsTo(Department::class); // Assuming you have a Department model
    }
}
