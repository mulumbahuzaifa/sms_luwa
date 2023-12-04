<?php

namespace App\Http\Controllers;

use App\Models\ClassSubjectModel;
use App\Models\ClassSubjectTimetableModel;
use App\Models\SmClass;
use App\Models\Subject;
use App\Models\WeekModel;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Auth;

class ClassTimetableController extends Controller
{
    public function list(Request $request){
        // $data['getRecord'] = ClassSubjectModel::getRecord();
        $data['getClass'] = SmClass::getClass();

        if (!empty($request->class_id)) {
            $data['getSubject'] = ClassSubjectModel::MySubjects( $request->class_id);
        }

        $getWeek = WeekModel::getRecord();
        $week = array();
        foreach( $getWeek as $value){
            $dataW = array();
            $dataW['week_id'] = $value->id;
            $dataW['week_name'] = $value->name;
            if (!empty($request->class_id) && !empty($request->subject_id)) {
              $ClassSubject  = ClassSubjectTimetableModel::getRecordClassSubject($request->class_id, $request->subject_id, $value->id);

              if (!empty($ClassSubject)) {
                $dataW['start_time'] = $ClassSubject->start_time;
                $dataW['end_time'] = $ClassSubject->end_time;
                $dataW['room_number'] = $ClassSubject->room_number;
              }else{
                $dataW['start_time'] = '';
                $dataW['end_time'] = '';
                $dataW['room_number'] = '';
              }
            }else{
                $dataW['start_time'] = '';
                $dataW['end_time'] = '';
                $dataW['room_number'] = '';
            }

            $week[] = $dataW;
        }
        $data['week'] = $week;

        $data['header_title'] = "Class Timetable list";
        return view('class_timetable.list', $data);
    }

    public function get_subject(Request $request){
        $getSubject = ClassSubjectModel::MySubjects( $request->class_id);
        $html = "<option value=''>Select</option>";
        foreach($getSubject as $value){
            $html .= "<option value='".$value->subject_id."'>".$value->subject_name."</option>";
        }
        $json['html'] = $html;
        echo json_encode($json);
    }

    public function insert_update(Request $request){
        ClassSubjectTimetableModel::where('class_id', '=', $request->class_id)->where('subject_id', '=', $request->subject_id)->delete();

        foreach ($request->timetable as  $timetable) {
            if (!empty($timetable['week_id']) && !empty($timetable['start_time']) && !empty($timetable['end_time']) && !empty($timetable['room_number'])) {
                $save = new ClassSubjectTimetableModel;
                $save->class_id = $request->class_id;
                $save->subject_id = $request->subject_id;
                $save->week_id = $timetable['week_id'];
                $save->start_time = $timetable['start_time'];
                $save->end_time = $timetable['end_time'];
                $save->room_number = $timetable['room_number'];
                $save->save();
            }
        }
        Toastr::success('Class Timetable Assigned Successfully)','Success');
        return redirect()->back()->with('success', 'Class Timetable Assigned Successfully');

    }

    //student side
    public function MyTimetable(){


        $result = array();
        $getRecord = ClassSubjectModel::MySubjects(Auth::user()->class_id);
        foreach ($getRecord as $key => $value) {
            $dataS['name'] = $value->subject_name;

            $getWeek = WeekModel::getRecord();
            $week = array();
            foreach( $getWeek as $valueW){
                $dataW = array();
                $dataW['week_id'] = $valueW->id;
                $dataW['week_name'] = $valueW->name;

                $ClassSubject  = ClassSubjectTimetableModel::getRecordClassSubject($value->class_id, $value->subject_id, $valueW->id);

                  if (!empty($ClassSubject)) {
                    $dataW['start_time'] = $ClassSubject->start_time;
                    $dataW['end_time'] = $ClassSubject->end_time;
                    $dataW['room_number'] = $ClassSubject->room_number;
                  }else{
                    $dataW['start_time'] = '';
                    $dataW['end_time'] = '';
                    $dataW['room_number'] = '';
                  }

                $week[] = $dataW;
            }
            $dataS['week'] = $week;
            $result[] = $dataS;
        }

        $data['getRecord'] = $result;

        $data['header_title'] = "My Timetable";
        return view('student.my_timetable', $data);
    }

    //teacher side
    public function MyTimetableTeacher($class_id, $subject_id){

        $data['getClass'] = SmClass::getSingle($class_id);
        $data['getSubject'] = Subject::getSingle($subject_id);

        $getWeek = WeekModel::getRecord();
        $week = array();
        foreach( $getWeek as $valueW){
            $dataW = array();
            $dataW['week_name'] = $valueW->name;

            $ClassSubject  = ClassSubjectTimetableModel::getRecordClassSubject($class_id, $subject_id, $valueW->id);

                if (!empty($ClassSubject)) {
                $dataW['start_time'] = $ClassSubject->start_time;
                $dataW['end_time'] = $ClassSubject->end_time;
                $dataW['room_number'] = $ClassSubject->room_number;
                }else{
                $dataW['start_time'] = '';
                $dataW['end_time'] = '';
                $dataW['room_number'] = '';
                }

            $result[] = $dataW;
        }
        $dataS['week'] = $week;

        $data['getRecord'] = $result;

        $data['header_title'] = "My Timetable";
        return view('teacher.my_timetable', $data);
    }
}
