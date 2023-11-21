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
        'department_id', // If using a foreign key to associate with a Teacher model
    ];

    static public function getSubject(){
        $return = Subject::orderBy('id', 'desc')->get();
        return $return;
    }

    static public function getSingle($id){
        return self::find($id);
    }
    // Define relationships if necessary
    public function teacher()
    {
        return $this->belongsTo(Staff::class); // Assuming you have a Teacher model
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id'); // Assuming you have a Department model
    }

    // public function class()
    // {
    //     return $this->belongsTo(SmClass::class, 'class_id'); // Assuming you have a Department model
    // }
}
