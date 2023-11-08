<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Department;
use App\Models\SmClass;
use App\Models\Staff;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;

class SmClassController extends Controller
{
    /** Class list */
    public function classList()
    {
        $smClasses = SmClass::orderBy('class_code', 'desc')->paginate(12);
        return view('smclass.list-smclass', ['smClasses' => $smClasses]);
    }

    /** class add */
   public function addClass()
   {
       $departments = Department::all();
       $teachers = Staff::all();
       return view('smclass.add-smclass', ['departments' => $departments, 'teachers' => $teachers]);
   }

    /** Parent save record */
    public function smClassSave(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'level' => 'required|string',
            'class_code' => 'required|string',
            'year' => 'required|string',
            'class_teacher_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $smClass = new SmClass();
            $smClass->name = $request->name;
            $smClass->level = $request->level;
            $smClass->class_code = $request->class_code;
            $smClass->year = $request->year;
            $smClass->class_teacher_id = $request->class_teacher_id;

            $smClass->save();

            Toastr::success('Class has been added successfully.', 'Success');
            DB::commit();

            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to add new Class.', 'Error');
            return redirect()->back();
        }
    }
    /** edit record */
    public function editSmClass($id)
    {
        $smClassEdit = SmClass::where('id',$id)->first();
        $teachers = Staff::all();
        return view('smclass.edit-smclass', ['teachers' => $teachers, 'smClassEdit' => $smClassEdit]);
    }

    /** update record */
    public function SmClassUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'level' => 'required|string',
            'class_code' => 'required|string',
            'year' => 'required|string',
            'class_teacher_id' => 'required',
        ]);
        // Find the class by ID
        $smClass = SmClass::find($id);

        if (!$smClass) {
            Toastr::error('fail, smClass not found. :)','Error');
            return redirect()->back();
        }
        // Update smClass attributes

        $smClass->name = $request->input('name');
        $smClass->level = $request->input('level');
        $smClass->class_code = $request->input('class_code');
        $smClass->year = $request->input('year');
        $smClass->class_teacher_id = $request->input('class_teacher_id');


        // Save the updated smClass
        $smClass->save();
        Toastr::success('Has been update successfully :)','Success');
        return redirect()->back();

    }

       /** student delete */
    public function smClassDelete($id)
    {
        DB::beginTransaction();
        try {

            // Find the department by ID
            $smClass = SmClass::find($id);

            if (!$smClass) {
                Toastr::error('smClass not found.', 'Error');
                return redirect()->back();
            }

            // Delete the smClass
            $smClass->delete();

            Toastr::success('Class has been deleted successfully.', 'Success');
            DB::commit();
            return redirect()->back();



        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Class deleted fail :)','Error');
            return redirect()->back();
        }
    }
}
