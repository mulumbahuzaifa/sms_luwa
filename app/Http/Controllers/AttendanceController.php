<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacher;
use App\Models\SmClass;
use App\Models\StudentAttendanceModel;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class AttendanceController extends Controller
{
    public function AttendanceStudents(Request $request){
        $data['getClass'] = SmClass::getClass();

        if(!empty($request->get('class_id')) && !empty($request->get('attendance_date'))){
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
        }

        $data['header_title'] = "Students Attendance";
        return view('attendance.students', $data);
    }

    public function AttendanceStudentsSubmit(Request $request){
        // dd($request->all());
        $check_attendance = StudentAttendanceModel::CheckAlreadyAttendance($request->student_id,$request->class_id,$request->attendance_date);
        if (!empty($check_attendance)) {
            $attendance = $check_attendance;
        }else{
            $attendance = new StudentAttendanceModel();
            $attendance->student_id = $request->student_id;
            $attendance->class_id = $request->class_id;
            $attendance->attendance_date = $request->attendance_date;
        }
        $attendance->created_by = Auth::user()->id;
        $attendance->attendance_type = $request->attendance_type;
        $attendance->save();

        $json['status'] = 'success';
        $json['message'] = "Attendance created successfully";
        echo json_encode($json);
    }

    public function AttendanceReport(Request $request){
        $data['getClass'] = SmClass::getClass();
        // if(!empty($request->get('class_id')) && !empty($request->get('attendance_date'))){
            $data['getRecord'] = StudentAttendanceModel::getRecord();
        // }
        $data['header_title'] = "Attendance Report";
        return view('attendance.report', $data);
    }


    //Teacher Side
    public function AttendanceStudentsTeacher(Request $request){
        $data['getClass'] =  AssignClassTeacher::getMyClassSubjectGroup(Auth::user()->id);

        if(!empty($request->get('class_id')) && !empty($request->get('attendance_date'))){
            $data['getStudent'] = User::getStudentClass($request->get('class_id'));
        }

        $data['header_title'] = "Students Attendance";
        return view('teacher.attendance.students', $data);
    }

    public function AttendanceReportTeacher(Request $request){
        $getClass =  AssignClassTeacher::getMyClassSubjectGroup(Auth::user()->id);
        $classArray = array();
        foreach ($getClass as $key => $value) {
            $classArray[] = $value->class_id;
        }
        $data['getClass'] = $getClass;
        $data['getRecord'] = StudentAttendanceModel::getRecordTeacher($classArray);

        $data['header_title'] = "Attendance Report";
        return view('teacher.attendance.report', $data);
    }

    public function MyAttendanceStudent(Request $request){
        // $getClass =  AssignClassTeacher::getMyClassSubjectGroup(Auth::user()->id);
        // $classArray = array();
        // foreach ($getClass as $key => $value) {
        //     $classArray[] = $value->class_id;
        // }
        $data['getClass'] = StudentAttendanceModel::getClassStudent(Auth::user()->id);
        $data['getRecord'] = StudentAttendanceModel::getRecordStudent(Auth::user()->id);
        $data['header_title'] = "My Attendance";
        return view('student.my_attendance', $data);
    }
}
