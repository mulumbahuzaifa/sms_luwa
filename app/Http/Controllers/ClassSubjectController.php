<?php

namespace App\Http\Controllers;

use App\Models\ClassSubjectModel;
use App\Models\SmClass;
use App\Models\Subject;
use Illuminate\Http\Request;
use Auth;
use Brian2694\Toastr\Facades\Toastr;

class ClassSubjectController extends Controller
{
    public function list(Request $request){
        $data['getRecord'] = ClassSubjectModel::getRecord();

        $data['header_title'] = "Subject Assign list";
        return view('assign_subject.list', $data);
    }

    public function add(Request $request){
        $data['getClass'] = SmClass::getClass();
        $data['getSubject'] = Subject::getSubject();

        $data['header_title'] = "Assign Subject Add";
        return view('assign_subject.add', $data);
    }

    public function insert(Request $request){
        if(!empty($request->class_id) && !empty($request->subject_id)){

            foreach($request->subject_id as $subject_id){
                $getAlreadyFirst = ClassSubjectModel::getAlreadyFirst($request->class_id, $subject_id);

                if(!empty($getAlreadyFirst)){
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();

                    Toastr::error('Subject Already Assigned)','Error');
                }
                else{
                    $data = new ClassSubjectModel();
                    $data->class_id = $request->class_id;
                    $data->subject_id = $subject_id;
                    $data->status = $request->status;
                    $data->created_by = Auth::user()->id;
                    $data->save();
                }


            }
            Toastr::success('Subject Assigned Successfully)','Success');
            return redirect()->route('assign_subject.list')->with('success', 'Subject Assigned Successfully');

        }else{
            Toastr::success('Please fill up all field)','Success');
            return redirect()->back()->with('error', 'Please fill up all field');
        }
    }

    public function edit($id){

        $getRecord = ClassSubjectModel::getSingle($id);
        if(!empty($getRecord)){
            $data['getRecord'] = $getRecord;
            $data['getAssignSubjectID'] = ClassSubjectModel::getAssignSubjectID($getRecord->class_id);
            $data['getClass'] = SmClass::getClass();
            $data['getSubject'] = Subject::getSubject();
            $data['header_title'] = "Assign Subject Edit";
            return view('assign_subject.edit', $data);

        }else{
            Toastr::error('No data found)','Error');
            return redirect()->route('assign_subject.list')->with('error', 'No data found');
        }

    }
    public function edit_single($id){

        $getRecord = ClassSubjectModel::getSingle($id);
        if(!empty($getRecord)){
            $data['getRecord'] = $getRecord;
            $data['getClass'] = SmClass::getClass();
            $data['getSubject'] = Subject::getSubject();
            $data['header_title'] = "Assign Subject Edit";
            return view('assign_subject.edit_single', $data);

        }else{
            Toastr::error('No data found)','Error');
            return redirect()->route('assign_subject.list')->with('error', 'No data found');
        }

    }

    public function update(Request $request){
        ClassSubjectModel::deleteSubject($request->class_id);

        if(!empty($request->class_id) && !empty($request->subject_id)){

            foreach($request->subject_id as $subject_id){
                $getAlreadyFirst = ClassSubjectModel::getAlreadyFirst($request->class_id, $subject_id);

                if(!empty($getAlreadyFirst)){
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                    Toastr::error('Subject Already Assigned)','Error');
                }
                else{
                    $data = new ClassSubjectModel();
                    $data->class_id = $request->class_id;
                    $data->subject_id = $subject_id;
                    $data->status = $request->status;
                    $data->created_by = Auth::user()->id;
                    $data->save();
                }
            }
            Toastr::success('Subject Assigned Successfully)','Success');
            return redirect()->route('assign_subject.list')->with('success', 'Subject Assigned Successfully');
        }else{
            Toastr::success('Please fill up all field)','Success');
            return redirect()->back()->with('error', 'Please fill up all field');
        }
    }
    public function update_single(Request $request, $id){

        $getAlreadyFirst = ClassSubjectModel::getAlreadyFirst($request->class_id, $request->subject_id);

        if(!empty($getAlreadyFirst)){
            $getAlreadyFirst->status = $request->status;
            $getAlreadyFirst->save();
            Toastr::success('Status Successfully Updated)','Success');
            return redirect()->route('assign_subject.list')->with('success', 'Subject Assigned Successfully');
        }
        else{
            $data = ClassSubjectModel::getSingle($id);
            $data->class_id = $request->class_id;
            $data->subject_id = $request->subject_id;
            $data->status = $request->status;
            $data->save();
            Toastr::success('Subject Assigned Successfully)','Success');
            return redirect()->route('assign_subject.list')->with('success', 'Subject Assigned Successfully');

        }

    }

    public function delete($id){
        $getSingle = ClassSubjectModel::getSingle($id);
        // $getSingle->delete();
        $getSingle->is_deleted = 1;
        $getSingle->save();

        Toastr::success('Subject Assigned Deleted Successfully)','Success');
        return redirect()->route('assign_subject.list')->with('success', 'Subject Assigned Deleted Successfully');
    }
}
