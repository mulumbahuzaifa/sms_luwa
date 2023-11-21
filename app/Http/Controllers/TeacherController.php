<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Teacher;
use Brian2694\Toastr\Facades\Toastr;

class TeacherController extends Controller
{
    /** add teacher page */
    public function teacherAdd()
    {
        return view('teacher.add-teacher');
    }

    /** teacher list */
    public function teacherList()
    {
        // $listTeacher = DB::table('users')
        //     ->join('teachers','teachers.teacher_id','users.user_id')
        //     ->select('users.user_id','users.name','users.avatar','teachers.id','teachers.gender','teachers.mobile','teachers.address')
        //     ->get();
        $data['listTeacher'] = User::listTeacher();
        $data['header_title'] = "Teachers List";
        return view('teacher.list-teachers',$data);
    }

    /** teacher Grid */
    public function teacherGrid()
    {
        // $teacherGrid = Teacher::all();
        $data['teacherGrid'] = User::listTeacher();
        $data['header_title'] = "Teachers Grid";
        return view('teacher.teachers-grid',$data);
    }

    /** save record */
    public function saveRecord(Request $request)
    {
        $request->validate([
            'name'       => 'required|string',
            'last_name'       => 'required|string',
            'gender'          => 'required|string',
            'date_of_birth'   => 'required|string',
            'phone_number'          => 'required|string',
            'email'           => 'required|email|unique:users',
            'password'        => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        try {

            $teacher = new User;
            $teacher->name   = trim($request->name);
            $teacher->last_name    = trim($request->last_name);
            $teacher->gender       = trim($request->gender);
            if(!empty($request->date_of_birth)){
                $teacher->date_of_birth= trim($request->date_of_birth);
            }
            $teacher->religion     = trim($request->religion);
            $teacher->email        = trim($request->email);
            if(!empty($request->join_date)){
                $teacher->join_date= trim($request->join_date);
            }
            $teacher->status = trim($request->status);
            $teacher->marital_status = trim($request->marital_status);
            $teacher->address = trim($request->address);
            $teacher->current_address = trim($request->current_address);
            $teacher->phone_number = trim($request->phone_number);
            $teacher->qualification = trim($request->qualification);
            $teacher->experience = trim($request->experience);
            $teacher->note = trim($request->note);
            $teacher->role_name = "Teacher";
            $teacher->position = "Teacher";
            $teacher->password = Hash::make($request->password);
            if(!empty($request->avatar)) {
                $upload_file = rand() . '.' . $request->avatar->extension();
                $request->avatar->move(storage_path('app/public/teacher-photos/'), $upload_file);
                $teacher->avatar = $upload_file;
            }
            $teacher->save();

            // $dt        = Carbon::now();


            // $user_id = DB::table('users')->select('user_id')->orderBy('id','DESC')->first();

            // $saveRecord = new Teacher;
            // $saveRecord->teacher_id    = $user_id->user_id;
            // $saveRecord->full_name     = $request->full_name;
            // $saveRecord->gender        = $request->gender;
            // $saveRecord->date_of_birth = $request->date_of_birth;
            // $saveRecord->mobile        = $request->mobile;
            // $saveRecord->joining_date  = $request->joining_date;
            // $saveRecord->qualification = $request->qualification;
            // $saveRecord->experience    = $request->experience;
            // $saveRecord->username      = $request->username;
            // $saveRecord->address       = $request->address;
            // $saveRecord->city          = $request->city;
            // $saveRecord->state         = $request->state;
            // $saveRecord->zip_code      = $request->zip_code;
            // $saveRecord->country       = $request->country;
            // $saveRecord->save();

            Toastr::success('Teacher Has been add successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            \Log::info($e);
            DB::rollback();
            Toastr::error('fail, Add new record  :)','Error');
            return redirect()->back();
        }
    }

    /** edit record */
    public function editRecord($id)
    {
        $data['teacher'] = User::getSingle($id);
        if(!empty($data['teacher'])){
            $data['header_title'] = "Teacher Edit";
            return view('teacher.edit-teacher',$data);
        }else{
            abort(404);
        }
    }

    /** update record teacher */
    public function updateRecordTeacher(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required|string',
            'last_name'       => 'required|string',
            'gender'          => 'required|string',
            'date_of_birth'   => 'required|string',
            'phone_number'          => 'required',
            'email'           => 'required|email|unique:users,email,'.$id,
        ]);
        DB::beginTransaction();
        try {
            $teacher = User::getSingle($id);
            $teacher->name   = trim($request->name);
            $teacher->last_name    = trim($request->last_name);
            $teacher->gender       = trim($request->gender);
            if(!empty($request->date_of_birth)){
                $teacher->date_of_birth= trim($request->date_of_birth);
            }
            $teacher->religion     = trim($request->religion);
            $teacher->email        = trim($request->email);
            $teacher->marital_status        = trim($request->marital_status);
            if(!empty($request->join_date)){
                $teacher->join_date= trim($request->join_date);
            }

            $teacher->address = trim($request->address);
            $teacher->current_address = trim($request->current_address);
            $teacher->phone_number = trim($request->phone_number);
            $teacher->qualification = trim($request->qualification);
            $teacher->experience = trim($request->experience);
            $teacher->note = trim($request->note);
            $teacher->status = trim($request->status);
            // $teacher->role_name = "teacher";
            // $teacher->position = "teacher";

            // if(!empty($request->password)){
            //     $teacher->password = Hash::make($request->password);

            // }

            if (!empty($request->avatar)) {
                if(!empty($request->image_hidden)){
                    unlink(storage_path('app/public/teacher-photos/'.$request->image_hidden));
                }
                $upload_file = rand() . '.' . $request->avatar->extension();
                $request->avatar->move(storage_path('app/public/teacher-photos/'), $upload_file);

                $teacher->avatar = $upload_file;
            } else {
                $upload_file = $request->image_hidden;
                $teacher->avatar = $upload_file;
            }
            $teacher->save();

            Toastr::success('Has been update successfully :)','Success');
            DB::commit();
            return redirect()->back();

        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, update record  :)','Error');
            return redirect()->back();
        }
    }

    /** delete record */
    public function teacherDelete(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $getRecord = User::getSingle($id);

            if (!empty($getRecord)) {
                // User::destroy($getRecord);
                unlink(storage_path('app/public/teacher-photos/'.$getRecord->avatar));
                $getRecord->delete();
                DB::commit();
                Toastr::success('Student deleted successfully :)','Success');
                return redirect()->back();
            } else {
                Toastr::error('Student deleted fail, try again :)','Error');
                return redirect()->back();
            }

        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Deleted record fail :)','Error');
            return redirect()->back();
        }
    }
}
