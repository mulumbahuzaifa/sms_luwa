<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamScheduleModel extends Model
{
    use HasFactory;

    protected $table = 'exam_schedule';

    static public function getSingle($id){
        return self::find($id);
    }


    static public function getRecordSingle($exam_id, $class_id, $subject_id){
        return ExamScheduleModel::where('exam_id', '=', $exam_id)->where('class_id', '=', $class_id)->where('subject_id', '=', $subject_id)->first();
    }


    static public function deleteRecord($exam_id, $class_id){
        ExamScheduleModel::where('exam_id', '=', $exam_id)->where('class_id', '=', $class_id)->delete();
    }

    static public function getExam($class_id){
        return ExamScheduleModel::select('exam_schedule.*', 'exams.name as exam_name')
            ->join('exams', 'exams.id', '=', 'exam_schedule.exam_id')
            ->where('exam_schedule.class_id', '=', $class_id)
            ->groupBy('exam_schedule.exam_id')
            ->orderBy('exam_schedule.id', 'desc')
            ->get();
    }
    static public function getExamTeacher($teacher_id){
        return ExamScheduleModel::select('exam_schedule.*', 'exams.name as exam_name')
            ->join('exams', 'exams.id', '=', 'exam_schedule.exam_id')
            ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'exam_schedule.class_id')
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->groupBy('exam_schedule.exam_id')
            ->orderBy('exam_schedule.id', 'desc')
            ->get();
    }

    static public function getExamTimetable($exam_id, $class_id){
        return ExamScheduleModel::select('exam_schedule.*', 'subjects.name as subject_name', 'subjects.code as subject_code','subjects.compulsory as subject_compulsory')
            ->join('subjects', 'subjects.id', '=', 'exam_schedule.subject_id')
            ->where('exam_schedule.exam_id', '=', $exam_id)
            ->where('exam_schedule.class_id', '=', $class_id)
            ->get();
    }

    static public function getSubject($exam_id, $class_id){
        return ExamScheduleModel::select('exam_schedule.*', 'subjects.name as subject_name', 'subjects.code as subject_code','subjects.compulsory as subject_compulsory')
            ->join('subjects', 'subjects.id', '=', 'exam_schedule.subject_id')
            ->where('exam_schedule.exam_id', '=', $exam_id)
            ->where('exam_schedule.class_id', '=', $class_id)
            ->get();
    }

    static public function getExamCalendarTeacher($teacher_id){
        return ExamScheduleModel::select('exam_schedule.*','sm_classes.name as class_name' ,'subjects.name as subject_name', 'subjects.code as subject_code','exams.name as exam_name')
            ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'exam_schedule.class_id')
            ->join('sm_classes', 'sm_classes.id', '=', 'exam_schedule.class_id')
            ->join('subjects', 'subjects.id', '=', 'exam_schedule.subject_id')
            ->join('exams', 'exams.id', '=', 'exam_schedule.exam_id')
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->get();
    }

    static public function getMark($student_id, $exam_id, $class_id, $subject_id){
        return MarksRegisterModel::CheckAlreadyMark($student_id, $exam_id, $class_id,$subject_id);
    }
}
