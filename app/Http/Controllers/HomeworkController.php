<?php

namespace App\Http\Controllers;

use App\Models\ClassSubjectModel;
use App\Models\HomeworkModel;
use App\Models\SmClass;
use Illuminate\Http\Request;
use Auth;
use Brian2694\Toastr\Facades\Toastr;

class HomeworkController extends Controller
{
    public function Homework(){
        $data['getRecord'] = HomeworkModel::getRecord();
        $data['header_title'] = "Homework";
        return view('homework.list', $data);
    }

    public function HomeworkAdd(){
        $data['getClass'] = SmClass::getClass();

        $data['header_title'] = "Add Homework";
        return view('homework.add', $data);
    }

    public function ajax_get_subject(Request $request){
        $class_id = $request->class_id;
        $getSubject = ClassSubjectModel::MySubjects($class_id);
        $html = '';
        $html .= '<option value="">Select Subject</option>';
        foreach ($getSubject as $value){
            $html .= '<option value="'.$value->subject_id.'">'.$value->subject_name.'</option>';

        }
        $json['success'] = $html;
        echo json_encode($json);
    }

    public function HomeworkSave(Request $request){
        $homework = new HomeworkModel();
        $homework->class_id = trim($request->class_id);
        $homework->subject_id = trim($request->subject_id);
        $homework->homework_date = trim($request->homework_date);
        $homework->submission_date = trim($request->submission_date);
        $homework->description = trim($request->description);
        $homework->created_by = Auth::user()->id;
        if(!empty($request->document_file)) {
            $upload_file = rand() . '.' . $request->document_file->extension();
            $request->document_file->move(storage_path('app/public/homework/'), $upload_file);
            $homework->document_file = $upload_file;
        }
        $homework->save();

        Toastr::success('Homework Added Successfully', 'Success');
        return redirect()->route('admin/holiday/homework');

    }

    public function HomeworkEdit($id){
        $data['getClass'] = SmClass::getClass();
        $getRecord = HomeworkModel::getSingle($id);
        $data['getRecord'] = $getRecord;

        $getSubject = ClassSubjectModel::MySubjects($getRecord->class_id);
        $data['getSubject'] = $getSubject;

        $data['header_title'] = "Edit Homework";
        return view('homework.edit', $data);
    }

    public function HomeworkUpdate(Request $request, $id){

        $homework = HomeworkModel::getSingle($id);
        $homework->class_id = trim($request->class_id);
        $homework->subject_id = trim($request->subject_id);
        $homework->homework_date = trim($request->homework_date);
        $homework->submission_date = trim($request->submission_date);
        $homework->description = trim($request->description);
        // $homework->updated_by = Auth::user()->id;
        if(!empty($request->document_file)) {
            $upload_file = rand() . '.' . $request->document_file->extension();
            $request->document_file->move(storage_path('app/public/homework/'), $upload_file);
            $homework->document_file = $upload_file;
        }
        $homework->save();

        Toastr::success('Homework Updated Successfully', 'Success');
        return redirect()->route('admin/holiday/homework');

    }

    public function HomeworkDelete($id){
        $homework = HomeworkModel::getSingle($id);
        // $homework->delete();
        $homework->is_deleted = 1;
        $homework->save();
        Toastr::success('Homework Deleted Successfully', 'Success');
        return redirect()->back();
    }

}
