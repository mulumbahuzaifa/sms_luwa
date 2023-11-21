<?php

namespace App\Http\Controllers;

use App\Models\ClassSubjectModel;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Subject;
use App\Models\Department;
use App\Models\SmClass;

class SubjectController extends Controller
{
     /** subjects list */
     public function subjectList()
     {
         $subjects = Subject::orderBy('id', 'desc')->paginate(12);
         return view('subject.list-subject', ['subjects' => $subjects]);
     }

     /** subject add */
    public function addSubject()
    {
        $departments = Department::all();
        $classes = SmClass::all();
        return view('subject.add-subject', ['departments' => $departments, 'classes' => $classes]);
    }

    /** subject save record */
    public function subjectSave(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string',
            'level' => 'required|string',
            'compulsory' => 'required',
            'department_id' => 'required',

        ]);

        DB::beginTransaction();
        try {
            $subject = new Subject();
            $subject->name = $request->name;
            $subject->code = $request->code;
            $subject->level = $request->level;
            $subject->description = $request->description;
            $subject->compulsory = $request->compulsory;
            $subject->department_id	 = $request->department_id	;

            $subject->save();

            Toastr::success('Subject has been added successfully.', 'Success');
            DB::commit();

            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to add new subject.', 'Error');
            return redirect()->back();
        }
    }
    /** edit record */
    public function subjectEdit($id)
    {
        $subjectEdit = Subject::where('id',$id)->first();
        $departments = Department::all();
        $classes = SmClass::all();
        return view('subject.edit-subject', ['departments' => $departments, 'subjectEdit' => $subjectEdit, 'classes' => $classes]);
    }

    /** update record */
    public function subjectUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string',
            'level' => 'required|string',
            'compulsory' => 'required',
            'department_id' => 'required',
        ]);
        // dd($request->all());
        // Find the subject by ID
        $subject = Subject::find($id);

        if (!$subject) {
            Toastr::error('fail, subject not found. :)','Error');
            return redirect()->back();
        }
        // Update subject attributes

        $subject->name = $request->input('name');
        $subject->code = $request->input('code');
        $subject->level = $request->input('level');
        $subject->description = $request->input('description');
        $subject->compulsory = $request->input('compulsory');
        $subject->department_id = $request->input('department_id');

        // Save the updated subject
        $subject->save();
        Toastr::success('Has been update successfully :)','Success');
        return redirect()->back();

    }

       /** student delete */
    public function subjectDelete($id)
    {
        DB::beginTransaction();
        try {

            // Find the department by ID
            $subject = Subject::find($id);

            if (!$subject) {
                Toastr::error('Subject not found.', 'Error');
                return redirect()->back();
            }

            // Delete the subject
            $subject->delete();

            Toastr::success('Subject has been deleted successfully.', 'Success');
            DB::commit();
            return redirect()->back();



        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Subject deleted fail :)','Error');
            return redirect()->back();
        }
    }

    //Students Part
    public function mySubjects(){
        // $subjects = Subject::orderBy('id', 'desc')->paginate(12);
        $data['subjects'] = ClassSubjectModel::MySubjects(Auth::user()->class_id);
        return view('student.my_subjects', $data);
    }

}
