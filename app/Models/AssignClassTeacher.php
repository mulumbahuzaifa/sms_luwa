<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class AssignClassTeacher extends Model
{
    use HasFactory;

    protected $table = 'assign_class_teacher';

    static public function getAlreadyFirst($class_id, $teacher_id){
        return self::where('class_id', '=', $class_id)->where('teacher_id', '=', $teacher_id)->first();
    }

    static public function getSingle($id){
        return self::find($id);
    }

    static public function getRecord(){
        $return = self::select('assign_class_teacher.*', 'sm_classes.name as class_name', 'teacher.name as teacher_name', 'users.name as created_by_name')
            ->join('users as teacher', 'teacher.id', '=', 'assign_class_teacher.teacher_id')
            ->join('sm_classes', 'sm_classes.id', '=', 'assign_class_teacher.class_id')
            ->join('users', 'users.id', '=', 'assign_class_teacher.created_by')
            ->where('assign_class_teacher.is_deleted', '=', 0);
            if(!empty(Request::get('class_name'))){
                $return = $return->where('sm_classes.name', 'like', '%'.Request::get('class_name').'%');
            }
            if(!empty(Request::get('teacher_name'))){
                $return = $return->where('teacher.name', 'like', '%'.Request::get('teacher_name').'%');
            }
            if(!empty(Request::get('status'))){
                $status = (Request::get('status') == 100) ? 0 : 1;
                $return = $return->where('assign_class_teacher.status', '=', $status);
            }
            if(!empty(Request::get('date'))){
                $return = $return->whereDate('assign_class_teacher.created_at', '=', Request::get('date'));
            }
        $return = $return->orderBy('assign_class_teacher.id', 'asc')
            ->paginate(20);

        return $return;
    }
    static public function getMyClassSubjects($teacher_id){
        return AssignClassTeacher::select('assign_class_teacher.*', 'sm_classes.name as class_name', 'subjects.name as subject_name', 'subjects.code as subject_code', 'subjects.level as subject_level', 'sm_classes.id as class_id','subjects.id as subject_id')
            ->join('sm_classes', 'sm_classes.id', '=', 'assign_class_teacher.class_id')
            ->join('class_subject', 'class_subject.class_id', '=', 'sm_classes.id')
            ->join('subjects', 'subjects.id', '=', 'class_subject.subject_id')
            ->where('assign_class_teacher.is_deleted', '=', 0)
            ->where('assign_class_teacher.status', '=', 0)
            // ->where('subjects.is_deleted', '=', 0)
            // ->where('subjects.status', '=', 0)
            ->where('class_subject.is_deleted', '=', 0)
            ->where('class_subject.status', '=', 0)
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->paginate(20);

    }
    static public function getMyClassSubjectCount($teacher_id){
        return AssignClassTeacher::select('assign_class_teacher.id')
            ->join('sm_classes', 'sm_classes.id', '=', 'assign_class_teacher.class_id')
            ->join('class_subject', 'class_subject.class_id', '=', 'sm_classes.id')
            ->join('subjects', 'subjects.id', '=', 'class_subject.subject_id')
            ->where('assign_class_teacher.is_deleted', '=', 0)
            ->where('assign_class_teacher.status', '=', 0)
            ->where('class_subject.is_deleted', '=', 0)
            ->where('class_subject.status', '=', 0)
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->count();

    }

    static public function getMyClassSubjectGroup($teacher_id){
        return AssignClassTeacher::select('assign_class_teacher.*', 'sm_classes.name as class_name', 'sm_classes.id as class_id')
            ->join('sm_classes', 'sm_classes.id', '=', 'assign_class_teacher.class_id')
            ->where('assign_class_teacher.is_deleted', '=', 0)
            ->where('assign_class_teacher.status', '=', 0)
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->groupBy('assign_class_teacher.class_id')
            ->get();

    }
    static public function getTeacherClassCount($teacher_id){
        return AssignClassTeacher::select('assign_class_teacher.id')
            ->join('sm_classes', 'sm_classes.id', '=', 'assign_class_teacher.class_id')
            ->where('assign_class_teacher.is_deleted', '=', 0)
            ->where('assign_class_teacher.status', '=', 0)
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->count();

    }
    static public function getMyCalendarTeacher($teacher_id){
        return AssignClassTeacher::select('class_subject_timetable.*', 'sm_classes.name as class_name', 'sm_classes.id as class_id'
        , 'subjects.name as subject_name', 'week.name as week_name', 'week.fullcalendar_day')
            ->join('sm_classes', 'sm_classes.id', '=', 'assign_class_teacher.class_id')
            ->join('class_subject', 'class_subject.class_id', '=', 'assign_class_teacher.class_id')
            ->join('class_subject_timetable', 'class_subject_timetable.subject_id', '=', 'class_subject.subject_id')
            ->join('subjects', 'subjects.id', '=', 'class_subject_timetable.subject_id')
            ->join('week', 'week.id', '=', 'class_subject_timetable.week_id')
            ->where('assign_class_teacher.is_deleted', '=', 0)
            ->where('assign_class_teacher.status', '=', 0)
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->get();

    }

    static public function getAssignTeacherID($class_id){
        $return = self::where('class_id','=', $class_id)->where('is_deleted','=', 0)->get();
        return $return;
    }

    static public function deleteTeacher($class_id){
        $return = self::where('class_id','=', $class_id)->delete();
        return $return;
    }

    static public function getMyTimetable($class_id, $subject_id){

        $getWeek = WeekModel::getWeekUsingName(date('l'));

        return ClassSubjectTimetableModel::getRecordClassSubject($class_id, $subject_id, $getWeek->id);

    }
}
