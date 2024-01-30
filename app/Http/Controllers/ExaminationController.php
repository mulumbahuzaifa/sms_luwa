<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacher;
use App\Models\ClassSubjectModel;
use App\Models\ExamModel;
use App\Models\ExamScheduleModel;
use App\Models\MarksGradeModel;
use App\Models\MarksRegisterModel;
use App\Models\SettingModel;
use App\Models\SmClass;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Auth;

class ExaminationController extends Controller
{
    public function examList()
    {
        $data['getRecord'] = ExamModel::getRecord();
        $data['header_title'] = "Exam List";
        return view('examinations.exam.list', $data);
    }

    public function addExam()
    {
        $data['header_title'] = "Add Exam";
        return view('examinations.exam.add', $data);
    }

    public function saveExam(Request $request){
        $exam = new ExamModel();
        $exam->name = trim($request->name);
        $exam->note = trim($request->note);
        $exam->created_by = auth()->user()->id;
        $exam->created_at = date('Y-m-d H:i:s');
        $exam->save();

        Toastr::success('Exam added successfully :)','Success');
        return redirect()->route('exam.list')->with('success', 'Exam added successfully!');
    }

    public function editExam($id)
    {
        $data['getRecord'] = ExamModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = "Edit Exam";
            return view('examinations.exam.edit', $data);
        } else {
            Toastr::error('Exam not found :(', 'Error');
            return redirect()->route('exam.list')->with('error', 'Exam not found!');
        }

    }

    public function examUpdate($id, Request $request){
        $exam = ExamModel::getSingle($id);
        $exam->name = trim($request->name);
        $exam->note = trim($request->note);
        // $exam->updated_by = auth()->user()->id;
        $exam->updated_at = date('Y-m-d H:i:s');
        $exam->save();

        Toastr::success('Exam updated successfully :)','Success');
        return redirect()->route('exam.list')->with('success', 'Exam updated successfully!');
    }

    public function examDelete($id){
        $exam = ExamModel::getSingle($id);
        if(!empty($exam)){
            $exam->is_deleted = 1;
            $exam->save();
            // $exam->delete();
            Toastr::success('Exam deleted successfully :)','Success');
            return redirect()->route('exam.list')->with('success', 'Exam deleted successfully!');
        }else{
            Toastr::error('Exam not found :(', 'Error');
            return redirect()->route('exam.list')->with('error', 'Exam not found!');
        }

    }

    public function examSchedule(Request $request){
        $data['getClass'] = SmClass::getClass();
        $data['getExam'] = ExamModel::getExam();
        $result = array();
        if(!empty($request->get('exam_id')) && !empty($request->get('class_id'))){
            $getSubject = ClassSubjectModel::MySubjects($request->get('class_id'));
            foreach ($getSubject as  $value) {
                $dataS = array();
                $dataS['subject_id'] = $value->subject_id;
                $dataS['class_id'] = $value->class_id;
                $dataS['class_name'] = $value->class_name;
                $dataS['subject_name'] = $value->subject_name;
                $dataS['subject_code'] = $value->subject_code;
                $dataS['subject_level'] = $value->subject_level;
                $dataS['subject_compulsory'] = $value->subject_compulsory;

                $getExamSchedule = ExamScheduleModel::getRecordSingle($request->get('exam_id'), $request->get('class_id'), $value->subject_id);
                if(!empty($getExamSchedule)){
                    $dataS['exam_date'] = $getExamSchedule->exam_date;
                    $dataS['start_time'] = $getExamSchedule->start_time;
                    $dataS['end_time'] = $getExamSchedule->end_time;
                    $dataS['room_number'] = $getExamSchedule->room_number;
                    $dataS['full_marks'] = $getExamSchedule->full_marks;
                    $dataS['pass_mark'] = $getExamSchedule->pass_mark;
                }else{
                    $dataS['exam_date'] = '';
                    $dataS['start_time'] = '';
                    $dataS['end_time'] = '';
                    $dataS['room_number'] = '';
                    $dataS['full_marks'] = '';
                    $dataS['pass_mark'] = '';
                }

                $result[] = $dataS;
            }

        }

        $data['getRecord'] = $result;

        $data['header_title'] = "Exam Schedule";
        return view('examinations.exam_schedule', $data);
    }

    public function marksRegister(Request $request){
        $data['getClass'] = SmClass::getClass();
        $data['getExam'] = ExamModel::getExam();

        if(!empty($request->get('exam_id')) && !empty($request->get('class_id'))){
            $data['getSubject'] = ExamScheduleModel::getSubject($request->get('exam_id'), $request->get('class_id'));
            $data['getStudent'] = User::getStudentClass( $request->get('class_id'));

        }

        $data['header_title'] = "Marks Registers";
        return view('examinations.marks_register', $data);
    }

    public function TeacherMarksRegister(Request $request){
        $data['getClass'] =  AssignClassTeacher::getMyClassSubjectGroup(Auth::user()->id);
        $data['getExam'] = ExamScheduleModel::getExamTeacher(Auth::user()->id);
        if(!empty($request->get('exam_id')) && !empty($request->get('class_id'))){
            $data['getSubject'] = ExamScheduleModel::getSubject($request->get('exam_id'), $request->get('class_id'));
            $data['getStudent'] = User::getStudentClass( $request->get('class_id'));

        }

        $data['header_title'] = "Marks Registers";
        return view('teacher.marks_register', $data);
    }

    public function submitMarksRegister(Request $request){
        // dd($request->all());
        $validation = 0;
        if(!empty($request->mark)){
            foreach ($request->mark as $mark) {
                $getExamSchedule = ExamScheduleModel::getSingle($mark['id']);

                $full_mark = $getExamSchedule->full_marks;

                $class_work = !empty($mark['class_work']) ? $mark['class_work'] : 0;
                $test       = !empty($mark['test']) ? $mark['test'] : 0;
                $exam       = !empty($mark['exam']) ? $mark['exam'] : 0;

                $full_marks       = !empty($mark['full_marks']) ? $mark['full_marks'] : 0;
                $pass_mark       = !empty($mark['pass_mark']) ? $mark['pass_mark'] : 0;

                $total_mark = $class_work + $test + $exam;

                if($full_mark >= $total_mark){

                    $getMark = MarksRegisterModel::CheckAlreadyMark($request->student_id,$request->exam_id,$request->class_id,$mark['subject_id']);

                    if(!empty($getMark)){
                        $save = $getMark;
                    }else{
                        $save               = new MarksRegisterModel;
                        $save->created_by   = Auth::user()->id;
                        $save->created_at   = date('Y-m-d H:i:s');
                    }
                    $save->student_id = $request->student_id;
                    $save->exam_id = $request->exam_id;
                    $save->class_id = $request->class_id;
                    $save->subject_id = $mark['subject_id'];
                    $save->class_work = $class_work;
                    $save->test = $test;
                    $save->exam = $exam;

                    $save->full_marks = $full_marks;
                    $save->pass_mark = $pass_mark;

                    $save->save();
                }else{
                    $validation = 1;
                }

            }

        }
        // dd($request->all());
        // Toastr::success('Marks register added successfully :)','Success');
        if($validation == 0){
            $json['status'] = 'success';
            $json['message'] = "Marks register added successfully :";
        }else{
            $json['status'] = 'error';
            $json['message'] = "Some Inputs are greater than full mark, Check marks and try again ):";
        }

        echo json_encode($json);
        // return redirect()->back()->with('success', 'Marks register added successfully!');
    }

    public function singleSubmitMarksRegister(Request $request){
        $id = $request->id;
        $getExamSchedule = ExamScheduleModel::getSingle($id);

        $full_mark = $getExamSchedule->full_marks;

        $class_work = !empty($request->class_work) ? $request->class_work : 0;
        $test = !empty($request->test) ? $request->test : 0;
        $exam = !empty($request->exam) ? $request->exam : 0;

        $total_mark = $class_work + $test + $exam;

        if($full_mark >= $total_mark){
            $getMark = MarksRegisterModel::CheckAlreadyMark($request->student_id,$request->exam_id,$request->class_id,$request->subject_id);

            if(!empty($getMark)){
                $save = $getMark;
            }else{
                $save               = new MarksRegisterModel;
                $save->created_by   = Auth::user()->id;
                $save->created_at   = date('Y-m-d H:i:s');
            }

            $save->student_id = $request->student_id;
            $save->exam_id = $request->exam_id;
            $save->class_id = $request->class_id;
            $save->subject_id = $request->subject_id;
            $save->class_work = $class_work;
            $save->test = $test;
            $save->exam = $exam;

            $save->full_marks = $getExamSchedule->full_marks;
            $save->pass_mark = $getExamSchedule->pass_mark;

            $save->save();

            $json['status'] = 'success';
            $json['message'] = "Marks register added successfully :";
        }else{
            $json['status'] = 'error';
            $json['message'] = "Total mark is greater than full mark, Check marks and try again ):";
        }


        echo json_encode($json);

    }

    public function saveExamSchedule(Request $request){
        ExamScheduleModel::deleteRecord($request->exam_id, $request->class_id);

        if(!empty($request->schedule)){
            foreach ($request->schedule as $key => $value) {
                if(!empty($value['subject_id']) && !empty($value['exam_date']) && !empty($value['start_time']) && !empty($value['end_time']) && !empty($value['room_number']) && !empty($value['full_marks']) && !empty($value['pass_mark'])){
                    $examSchedule = new ExamScheduleModel();
                    $examSchedule->exam_id = $request->exam_id;
                    $examSchedule->class_id = $request->class_id;
                    $examSchedule->subject_id = $value['subject_id'];
                    $examSchedule->exam_date = $value['exam_date'];
                    $examSchedule->start_time = $value['start_time'];
                    $examSchedule->end_time = $value['end_time'];
                    $examSchedule->room_number = $value['room_number'];
                    $examSchedule->full_marks = $value['full_marks'];
                    $examSchedule->pass_mark = $value['pass_mark'];
                    $examSchedule->created_by = auth()->user()->id;
                    $examSchedule->created_at = date('Y-m-d H:i:s');
                    $examSchedule->save();
                }
            }
            // dd($request->all());
            Toastr::success('Exam schedule added successfully :)','Success');
            return redirect()->back()->with('success', 'Exam schedule added successfully!');
        }
    }

    public function marksGrade(){
        $data['getRecord'] = MarksGradeModel::getRecord();
        $data['header_title'] = "Marks Grade";
        return view('examinations.marks_grade.list', $data);
    }

    public function submitMarksGrade(){
        $data['header_title'] = "Add New Marks Grade";
        return view('examinations.marks_grade.add', $data);
    }

    public function marksGradeEdit($id){
        $data['getRecord'] = MarksGradeModel::getSingle($id);
        $data['header_title'] = "Edit Marks Grade";
        return view('examinations.marks_grade.edit', $data);
    }

    public function saveMarksGrade(Request $request){
        // dd($request->all());
        $mark = new MarksGradeModel;
        $mark->name = trim($request->name);
        $mark->percent_from	 = trim($request->percent_from);
        $mark->percent_to = trim($request->percent_to);
        $mark->created_by = Auth::user()->id;
        $mark->created_at = date('Y-m-d H:i:s');
        $mark->save();

        Toastr::success('Marks grade added successfully :)','Success');
        return redirect('examinations/marks_grade')->with('success', 'Marks grade added successfully!');

    }
    public function marksGradeUpdate($id, Request $request){
        // dd($request->all());
        $mark = MarksGradeModel::getSingle($id);
        $mark->name = trim($request->name);
        $mark->percent_from	 = trim($request->percent_from);
        $mark->percent_to = trim($request->percent_to);
        $mark->save();

        Toastr::success('Marks grade Edited successfully :)','Success');
        return redirect('examinations/marks_grade')->with('success', 'Marks grade edited successfully!');

    }

    public function marksGradeDelete($id){
        $mark = MarksGradeModel::getSingle($id);
        $mark->delete();

        Toastr::success('Marks grade Deleted successfully :)','Success');
        return redirect('examinations/marks_grade')->with('success', 'Marks grade Deleted successfully!');

    }

    //Student Side
    public function MyExamTimetable(Request $request){
        $class_id = Auth::user()->class_id;
        $getExam = ExamScheduleModel::getExam($class_id);
        $result = array();
        foreach ($getExam as $key => $value) {
            $dataE = array();
            $dataE['name'] = $value->exam_name;
            $getExamTimetable = ExamScheduleModel::getExamTimetable($value->exam_id, $class_id);
            $resultS = array();
            foreach($getExamTimetable as $valueS){
                $dataS = array();
                $dataS['subject_name'] = $valueS->subject_name;
                $dataS['exam_date'] = $valueS->exam_date;
                $dataS['start_time'] = $valueS->start_time;
                $dataS['end_time'] = $valueS->end_time;
                $dataS['room_number'] = $valueS->room_number;
                $dataS['full_marks'] = $valueS->full_marks;
                $dataS['pass_mark'] = $valueS->pass_mark;
                $resultS[] = $dataS;
            }
            $dataE['exam'] = $resultS;
            $result[] = $dataE;
        }
        // $data['getExam'] = ExamModel::getExam();
        $data['getRecord'] = $result;
        $data['header_title'] = "My Exam Schedule";
        return view('student.my_exam_timetable', $data);
    }

    public function MyExamResults(){
        $result = array();
        $getExam = MarksRegisterModel::getExam(Auth::user()->id);
        foreach ($getExam as $key => $value) {
            $dataE = array();
            $dataE['exam_name'] = $value->exam_name;
            $dataE['exam_id'] = $value->exam_id;
            $getExamSubject = MarksRegisterModel::getExamSubjects($value->exam_id, Auth::user()->id);

            $dataSubject = array();
            foreach($getExamSubject as $exam){
                $total_score =  $exam['class_work'] + $exam['test'] + $exam['exam'];
                $dataS = array();
                $dataS['subject_name'] = $exam['subject_name'];
                $dataS['class_work'] = $exam['class_work'];
                $dataS['test'] = $exam['test'];
                $dataS['exam'] = $exam['exam'];
                $dataS['total_score'] = $total_score;
                $dataS['full_marks'] = $exam['full_marks'];
                $dataS['pass_mark'] = $exam['pass_mark'];
                $dataSubject[] = $dataS;
            }
            $dataE['subject'] = $dataSubject;
            $result[] = $dataE;
        }
        $data['getRecord'] = $result;
        $data['header_title'] = "My Exam Results";
        return view('student.my_exam_result', $data);
    }
    public function MyExamResultsPrint(Request $request){
        $exam_id = $request->exam_id;
        $student_id = $request->student_id;

        $data['getExam'] = ExamModel::getSingle($exam_id);
        $data['getStudent'] = User::getSingle($student_id);
        $data['getSetting'] = SettingModel::getSingle();

        $data['getClass'] = MarksRegisterModel::getClass($exam_id, $student_id);
        $getExamSubject = MarksRegisterModel::getExamSubjects($exam_id, $student_id);

        $dataSubject = array();
        foreach($getExamSubject as $exam){
            $total_score =  $exam['class_work'] + $exam['test'] + $exam['exam'];
            $dataS = array();
            $dataS['subject_name'] = $exam['subject_name'];
            $dataS['class_work'] = $exam['class_work'];
            $dataS['test'] = $exam['test'];
            $dataS['exam'] = $exam['exam'];
            $dataS['total_score'] = $total_score;
            $dataS['full_marks'] = $exam['full_marks'];
            $dataS['pass_mark'] = $exam['pass_mark'];
            $dataSubject[] = $dataS;
        }
        $data['getExamMark'] = $dataSubject;
        return view('exam_results_print', $data);
    }

    //Teacher Side
    public function MyExamTimetableTeacher(){
        $result = array();
        $getClass = AssignClassTeacher::getMyClassSubjectGroup(Auth::user()->id);
        foreach($getClass as $class){
            $dataC = array();
            $dataC['class_name'] = $class->class_name;
            $getExam = ExamScheduleModel::getExam($class->class_id);
            $examArray = array();
            foreach ($getExam as $key => $value) {
                $dataE = array();
                $dataE['exam_name'] = $value->exam_name;
                $getExamTimetable = ExamScheduleModel::getExamTimetable($value->exam_id, $value->class_id);
                $subjectArray = array();
                foreach($getExamTimetable as $valueS){
                    $dataS = array();
                    $dataS['subject_name'] = $valueS->subject_name;
                    $dataS['exam_date'] = $valueS->exam_date;
                    $dataS['start_time'] = $valueS->start_time;
                    $dataS['end_time'] = $valueS->end_time;
                    $dataS['room_number'] = $valueS->room_number;
                    $dataS['full_marks'] = $valueS->full_marks;
                    $dataS['pass_mark'] = $valueS->pass_mark;
                    $subjectArray[] = $dataS;
                }
                $dataE['subject'] = $subjectArray;
                $examArray[] = $dataE;
            }
            $dataC['exam'] = $examArray;
            $result[] = $dataC;
        }

        $data['getRecord'] = $result;
        $data['header_title'] = "My Exam Schedule";
        return view('teacher.my_exam_timetable', $data);
    }
}
