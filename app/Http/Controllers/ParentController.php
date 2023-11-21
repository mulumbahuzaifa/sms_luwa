<?php

namespace App\Http\Controllers;

use DB;
use App\Models\SmParent;
use App\Models\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Hash;
use Auth;
use Str;

class ParentController extends Controller
{
    /** index page parent list */
    public function parentList()
    {
        // $parentList = SmParent::orderBy('id', 'desc')->paginate(12);
        $data['parentList'] = User::parentList();
        $data['header_title'] = "Parent List";
        return view('parent.parent',$data);
    }

    /** parent add page */
    public function parentAdd()
    {
        $data['header_title'] = "Parent List";
        return view('parent.add-parent', $data);
    }

    /** parent save record */
    public function parentSave(Request $request)
    {
        $request->validate([
            'name'    => 'required|string',
            'last_name'     => 'required|string',
            'gender'        => 'required|string',
            'email'         => 'required|email|unique:users',
            'phone_number'         => 'max:15|min:8',
            'address'         => 'max:255',
            'occupation'         => 'max:255',
        ]);

        DB::beginTransaction();
        try {
            $parent = new User;
            $parent->name   = trim($request->name);
            $parent->last_name    = trim($request->last_name);
            $parent->gender       = trim($request->gender);
            $parent->email        = trim($request->email);
            $parent->status = trim($request->status);
            $parent->occupation = trim($request->occupation);
            $parent->address = trim($request->address);
            $parent->phone_number = trim($request->phone_number);
            $parent->role_name = "Parent";
            $parent->position = "Parent";
            $parent->password = Hash::make($request->password);

            if(!empty($request->avatar)) {
                $upload_file = rand() . '.' . $request->avatar->extension();
                $request->avatar->move(storage_path('app/public/parent-photos/'), $upload_file);
                $parent->avatar = $upload_file;
            }
            $parent->save();

            Toastr::success('Parent Has been add successfully :)','Success');
            DB::commit();

            return redirect()->back();

        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new Parent  :)','Error');
            return redirect()->back();
        }
    }

    /** view for edit parent */
    public function parentEdit($id)
    {
        $data['parentEdit'] = User::getSingle($id);
        if(!empty($data['parentEdit'])){
            $data['header_title'] = "Student Edit";
            return view('parent.edit-parent',$data);
        }else{
            abort(404);
        }
    }

    /** update record */
    public function parentUpdate(Request $request, $id)
    {
        $request->validate([
            'name'    => 'required|string',
            'last_name'     => 'required|string',
            'gender'        => 'required|string',
            'email'         => 'required|email|unique:users,email,'.$id,
            'phone_number'         => 'max:15|min:8',
            'address'         => 'max:255',
            'occupation'         => 'max:255',
        ]);

        DB::beginTransaction();
        try {
            $parent = User::getSingle($id);
            $parent->name   = trim($request->name);
            $parent->last_name    = trim($request->last_name);
            $parent->gender       = trim($request->gender);
            $parent->email        = trim($request->email);
            $parent->status = trim($request->status);
            $parent->occupation = trim($request->occupation);
            $parent->address = trim($request->address);
            $parent->phone_number = trim($request->phone_number);
            $parent->role_name = "Parent";
            $parent->position = "Parent";

            if (!empty($request->avatar)) {
                if(!empty($request->image_hidden)){
                    unlink(storage_path('app/public/parent-photos/'.$request->image_hidden));
                }
                $upload_file = rand() . '.' . $request->avatar->extension();
                $request->avatar->move(storage_path('app/public/parent-photos/'), $upload_file);

                $parent->avatar = $upload_file;
            } else {
                $upload_file = $request->image_hidden;
                $parent->avatar = $upload_file;
            }
            $parent->save();

            Toastr::success('Has been update successfully :)','Success');
            DB::commit();

            return redirect()->back();


        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, update parent  :)','Error');
            return redirect()->back();
        }
    }

    /** parent delete */

    public function parentDelete($id)
    {
        DB::beginTransaction();
        try {
            $getRecord = User::getSingle($id);

            if (!empty($getRecord)) {
                unlink(storage_path('app/public/parent-photos/'.$getRecord->avatar));
                $getRecord->delete();
                DB::commit();
                Toastr::success('Parent deleted successfully :)','Success');
                return redirect()->back();
            }

        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Parent deleted fail :)','Error');
            return redirect()->back();
        }
    }

    /** parent profile page */
    public function parentProfile($id)
    {
        $parentProfile = SmParent::where('id',$id)->first();
        return view('parent.parent-profile',compact('parentProfile'));
    }

    /** parent assign student page */
    public function myStudent($id)
    {
        $data['getParent'] = User::getSingle($id);
        $data['parent_id'] = $id;
        $data['getSearchStudent'] = User::getSearchStudent();
        $data['getRecord'] = User::getMyStudent($id);
        $data['header_title'] = "Parent Student List";
        return view('parent.my_student',$data);
    }

    public function assignStudentParent($student_id, $parent_id){
        $student = User::getSingle($student_id);
        $student->parent_id = $parent_id;
        $student->save();

        Toastr::success('Student Successfully Assigned to Parent :)','Success');
        return redirect()->back();
    }

    public function assignStudentParentDelete($student_id){
        $student = User::getSingle($student_id);
        $student->parent_id = null;
        $student->save();

        Toastr::success('Student Successfully Removed from Parent Successfully :)','Success');
        return redirect()->back();
    }

}
