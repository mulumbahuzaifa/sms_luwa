<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarksRegisterModel extends Model
{
    use HasFactory;

    protected $table  = 'marks_register';

    static public function CheckAlreadyMark($student_id, $exam_id, $class_id, $subject_id ){
        return MarksRegisterModel::where('student_id', '=', $student_id)->where('exam_id', '=', $exam_id)->where('class_id', '=', $class_id)->where('subject_id', '=', $subject_id)->first();
    }

    static public function getExam($student_id){
        return MarksRegisterModel::select('marks_register.*', 'exams.name as exam_name')
            ->join('exams', 'exams.id', '=', 'marks_register.exam_id')
            ->where('marks_register.student_id', '=', $student_id)
            ->groupBy('marks_register.exam_id')
            ->orderBy('marks_register.id', 'desc')
            ->get();
    }

    static public function getExamSubjects($exam_id, $student_id){
        return MarksRegisterModel::select('marks_register.*', 'exams.name as exam_name', 'subjects.name as subject_name', 'subjects.code as subject_code','subjects.compulsory as subject_compulsory')
            ->join('exams', 'exams.id', '=', 'marks_register.exam_id')
            ->join('subjects', 'subjects.id', '=', 'marks_register.subject_id')
            ->where('marks_register.exam_id', '=', $exam_id)
            ->where('marks_register.student_id', '=', $student_id)
            ->orderBy('marks_register.id', 'desc')
            ->get();
    }
}
