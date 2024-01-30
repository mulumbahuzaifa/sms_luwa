<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmClass extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'name',
    //     'level',
    //     'class_code',
    //     'year',
    //     'class_teacher_id', // If using a foreign key to associate with a Teacher model
    // ];

    protected $table = 'sm_classes';

    static public function getRecord(){
        $return = SmClass::orderBy('id', 'desc')->paginate(20);
        return $return;
    }

    static public function getSingle($id){
        return self::find($id);
    }

    static public function getClass(){
        $return = SmClass::select('sm_classes.*')
            ->where('sm_classes.is_deleted', '=', 0)
            ->where('sm_classes.status', '=', 0)
            ->orderBy('sm_classes.class_code', 'desc')
            ->paginate(20);
        return $return;
    }

    static public function getStudentClass(){
        $return = SmClass::orderBy('class_code', 'desc')->get();
        return $return;
    }

    // Define relationships if necessary
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function classTeacher()
    {
        return $this->belongsTo(User::class, 'class_teacher_id'); // Assuming you have a Teacher model
    }
}
