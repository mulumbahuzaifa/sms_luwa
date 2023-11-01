<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'category',
        'HOD', 'date_created'// "Teaching" or "Non-Teaching"
    ];

    // Define relationships for sub-departments
    // public function subDepartments()
    // {
    //     return $this->hasMany(Department::class, 'parent_department_id');
    // }

    // Define relationships if necessary for staff or other entities within a department
    // For example, a 'Department' might have many 'Staff'
    public function staff()
    {
        return $this->hasMany(Staff::class);
    }
}
