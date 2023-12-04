<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class StudentAttendanceModel extends Model
{
    use HasFactory;

    protected $table = 'student_attendance';

    static public function CheckAlreadyAttendance($student_id, $class_id,$attendance_date){
        return self::where('student_id', '=' ,$student_id)->where('class_id', '=',$class_id)->where('attendance_date', '=', $attendance_date)->first();
    }

    static public function getRecord(){
        $return = StudentAttendanceModel::select('student_attendance.*','sm_classes.name as class_name',
        'student.name as student_name', 'student.last_name as student_last_name','created_by.name as student_created_by',
        'created_by.last_name as student_created_by_last_name')
                ->join('sm_classes', 'sm_classes.id','=', 'student_attendance.class_id')
                ->join('users as student', 'student.id', '=' ,'student_attendance.student_id')
                ->join('users as created_by', 'created_by.id', '=' ,'student_attendance.created_by');
                if (!empty(Request::get('student_id'))) {
                    $return = $return->where('student_attendance.student_id','=', Request::get('student_id'));
                }
                if (!empty(Request::get('student_name'))) {
                    $return = $return->where('student.name','like', '%'.Request::get('student_name').'%')->orWhere('student.last_name', 'like', '%'.Request::get('student_name').'%');
                }
                if (!empty(Request::get('class_id'))) {
                    $return = $return->where('student_attendance.class_id','=', Request::get('class_id'));
                }
                if (!empty(Request::get('attendance_date'))) {
                    $return = $return->where('student_attendance.attendance_date','=', Request::get('attendance_date'));
                }
                if (!empty(Request::get('attendance_type'))) {
                    $return = $return->where('student_attendance.attendance_type','=', Request::get('attendance_type'));
                }

        $return = $return->orderBy('student_attendance.id', 'desc')
                ->paginate(50);
        return $return;
    }

    static public function getRecordStudent($student_id){
        $return = StudentAttendanceModel::select('student_attendance.*','sm_classes.name as class_name')
                ->join('sm_classes', 'sm_classes.id','=', 'student_attendance.class_id')
                ->where('student_attendance.student_id', '=',$student_id);
                if (!empty(Request::get('class_id'))) {
                    $return = $return->where('student_attendance.class_id','=', Request::get('class_id'));
                }
                if (!empty(Request::get('attendance_date'))) {
                    $return = $return->where('student_attendance.attendance_date','=', Request::get('attendance_date'));
                }
                if (!empty(Request::get('attendance_type'))) {
                    $return = $return->where('student_attendance.attendance_type','=', Request::get('attendance_type'));
                }

        $return = $return->orderBy('student_attendance.id', 'desc')
                ->paginate(50);
        return $return;
    }

    static public function getClassStudent($student_id){
        return StudentAttendanceModel::select('student_attendance.*','sm_classes.name as class_name')
                ->join('sm_classes', 'sm_classes.id','=', 'student_attendance.class_id')
                ->where('student_attendance.student_id', '=',$student_id)
                ->groupBy('student_attendance.class_id')
                ->get();

    }

    static public function getRecordTeacher($class_ids){
        if (!empty($class_ids)) {
            $return = StudentAttendanceModel::select('student_attendance.*','sm_classes.name as class_name',
            'student.name as student_name', 'student.last_name as student_last_name','created_by.name as student_created_by',
            'created_by.last_name as student_created_by_last_name')
                    ->join('sm_classes', 'sm_classes.id','=', 'student_attendance.class_id')
                    ->join('users as student', 'student.id', '=' ,'student_attendance.student_id')
                    ->join('users as created_by', 'created_by.id', '=' ,'student_attendance.created_by')
                    ->whereIn('student_attendance.class_id', $class_ids);

                    if (!empty(Request::get('student_id'))) {
                        $return = $return->where('student_attendance.student_id','=', Request::get('student_id'));
                    }
                    if (!empty(Request::get('student_name'))) {
                        $return = $return->where('student.name','like', '%'.Request::get('student_name').'%')->orWhere('student.last_name', 'like', '%'.Request::get('student_name').'%');
                    }
                    if (!empty(Request::get('class_id'))) {
                        $return = $return->where('student_attendance.class_id','=', Request::get('class_id'));
                    }
                    if (!empty(Request::get('attendance_date'))) {
                        $return = $return->where('student_attendance.attendance_date','=', Request::get('attendance_date'));
                    }
                    if (!empty(Request::get('attendance_type'))) {
                        $return = $return->where('student_attendance.attendance_type','=', Request::get('attendance_type'));
                    }

            $return = $return->orderBy('student_attendance.id', 'desc')
                    ->paginate(50);
            return $return;
        }else{
            return "";
        }
    }
}
