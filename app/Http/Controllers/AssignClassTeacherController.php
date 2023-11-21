<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacher;
use App\Models\SmClass;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Brian2694\Toastr\Facades\Toastr;

class AssignClassTeacherController extends Controller
{
    public function list(Request $request){
        $data['getRecord'] = AssignClassTeacher::getRecord();

        $data['header_title'] = "Assign Class Teacher list";
        return view('assign_class_teacher.list', $data);
    }

    public function add(Request $request){
        $data['getClass'] = SmClass::getClass();
        $data['getTeacher'] = User::getTeacher();
        $data['header_title'] = "Assign Class Teacher Add";
        return view('assign_class_teacher.add', $data);
    }

    public function insert(Request $request){
        if(!empty($request->class_id) && !empty($request->teacher_id)){

            foreach($request->teacher_id as $teacher_id){
                $getAlreadyFirst = AssignClassTeacher::getAlreadyFirst($request->class_id, $teacher_id);

                if(!empty($getAlreadyFirst)){
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();

                    Toastr::error('Subject Already Assigned)','Error');
                }
                else{
                    $data = new AssignClassTeacher();
                    $data->class_id = $request->class_id;
                    $data->teacher_id = $teacher_id;
                    $data->status = $request->status;
                    $data->created_by = Auth::user()->id;
                    $data->save();
                }

            }
            Toastr::success('Teacher to Class Assigned Successfully)','Success');
            return redirect()->route('assign_class_teacher.list')->with('success', 'Teacher to Class Assigned Successfully');

        }else{
            Toastr::success('Please fill up all field)','Success');
            return redirect()->back()->with('error', 'Please fill up all field');
        }
    // dd($request->all());
    }
    public function edit($id){

        $getRecord = AssignClassTeacher::getSingle($id);
        if(!empty($getRecord)){
            $data['getRecord'] = $getRecord;
            $data['getAssignTeacherID'] = AssignClassTeacher::getAssignTeacherID($getRecord->class_id);
            $data['getClass'] = SmClass::getClass();
            $data['getTeacher'] = User::getTeacher();
            $data['header_title'] = "Assign Class Teacher Edit";
            return view('assign_class_teacher.edit', $data);

        }else{
            Toastr::error('No data found)','Error');
            return redirect()->route('assign_class_teacher.list')->with('error', 'No data found');
        }

    }
    public function update(Request $request){

        AssignClassTeacher::deleteTeacher($request->class_id);

        if(!empty($request->class_id) && !empty($request->teacher_id)){

            foreach($request->teacher_id as $teacher_id){
                $getAlreadyFirst = AssignClassTeacher::getAlreadyFirst($request->class_id, $teacher_id);

                if(!empty($getAlreadyFirst)){
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                    Toastr::error('Subject Already Assigned)','Error');
                }
                else{
                    $data = new AssignClassTeacher();
                    $data->class_id = $request->class_id;
                    $data->teacher_id = $teacher_id;
                    $data->status = $request->status;
                    $data->created_by = Auth::user()->id;
                    $data->save();
                }
            }
            Toastr::success('Class to Teacher Updated Successfully)','Success');
            return redirect()->route('assign_class_teacher.list')->with('success', 'Subject Assigned Successfully');
        }else{
            Toastr::success('Please fill up all field)','Success');
            return redirect()->back()->with('error', 'Please fill up all field');
        }
    }

    public function edit_single($id){

        $getRecord = AssignClassTeacher::getSingle($id);
        if(!empty($getRecord)){
            $data['getRecord'] = $getRecord;
            $data['getClass'] = SmClass::getClass();
            $data['getTeacher'] = User::getTeacher();
            $data['header_title'] = "Assign Class Teacher Edit";
            return view('assign_class_teacher.edit_single', $data);

        }else{
            Toastr::error('No data found)','Error');
            return redirect()->route('assign_class_teacher.list')->with('error', 'No data found');
        }

    }

    public function update_single(Request $request, $id){

        $getAlreadyFirst = AssignClassTeacher::getAlreadyFirst($request->class_id, $request->subject_id);

        if(!empty($getAlreadyFirst)){
            $getAlreadyFirst->status = $request->status;
            $getAlreadyFirst->save();
            Toastr::success('Status Successfully Updated)','Success');
            return redirect()->route('assign_class_teacher.list')->with('success', 'Subject Assigned Successfully');
        }
        else{
            $data = AssignClassTeacher::getSingle($id);
            $data->class_id = $request->class_id;
            $data->teacher_id = $request->teacher_id;
            $data->status = $request->status;
            $data->save();
            Toastr::success('Assign Class to Teachers Updated Successfully)','Success');
            return redirect()->route('assign_class_teacher.list')->with('success', 'Subject Assigned Successfully');

        }

    }
    public function delete($id){
        $getSingle = AssignClassTeacher::getSingle($id);
        // $getSingle->delete();
        $getSingle->is_deleted = 1;
        $getSingle->save();

        Toastr::success('Class to Teachers Assigned Deleted Successfully)','Success');
        return redirect()->route('assign_class_teacher.list')->with('success', 'Subject Assigned Deleted Successfully');
    }

    //Teacher Side Part
    public function MyClassSubjects(){
        $data['getRecord'] = AssignClassTeacher::getMyClassSubjects(Auth::user()->id);
        $data['header_title'] = "My Class & Subjects";
        return view('teacher.my_class_subjects',$data);
    }


}
