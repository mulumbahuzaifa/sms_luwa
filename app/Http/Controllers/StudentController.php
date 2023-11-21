<?php

namespace App\Http\Controllers;

use App\Models\SmClass;
use DB;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use GuzzleHttp\Psr7\Response;
use Hash;
use Auth;

class StudentController extends Controller
{
    /** index page student list */
    public function student()
    {
        // $studentList = Student::all();
        // return view('student.student',compact('studentList'));

        $data['studentList'] = User::studentList();
        $data['header_title'] = "Student List";
        return view('student.student', $data);
    }

      /** student search */
    public function search_student(Request $request){
        $data = $request->input('search');
        $studentList = DB::table('students')->where('first_name', 'LIKE', '%'.$data."%")->orWhere('last_name', 'LIKE', '%'.$data."%")->get();
        return view('student.student-search',compact('studentList'));
    }

    /** index page student grid */
    public function studentGrid()
    {
        $data['studentList'] = User::studentList();
        $data['header_title'] = "Student List";
        return view('student.student-grid', $data);
    }

    /** student add page */
    public function studentAdd()
    {
        $data['getClass'] = SmClass::getClass();
        $data['header_title'] = "Student Add";
        return view('student.add-student', $data);
    }

    /** student save record */
    public function studentSave(Request $request)
    {
        $request->validate([
            'name'    => 'required|string',
            'last_name'     => 'required|string',
            'gender'        => 'required|string',
            'date_of_birth' => 'required',
            'roll_number'          => 'required|max:50',
            'admission_number'   => 'required|max:50',
            'email'         => 'required|email|unique:users',
            'class_id'         => 'required',
            'height'         => 'max:10',
            'weight'         => 'max:10',
            'blood_group'         => 'max:10',
            'caste'         => 'max:50',
            'religion'         => 'max:50',
            'phone_number'         => 'max:15|min:8',
        ]);

        DB::beginTransaction();
        try {
            // dd($request->all());
            $student = new User;
            $student->name   = trim($request->name);
            $student->last_name    = trim($request->last_name);
            $student->gender       = trim($request->gender);
            // $student->user_id       = trim($request->user_id);
            if(!empty($request->date_of_birth)){
                $student->date_of_birth= trim($request->date_of_birth);
            }
            $student->roll_number         = trim($request->roll_number);
            $student->admission_number         = trim($request->admission_number);
            $student->blood_group  = trim($request->blood_group);
            $student->religion     = trim($request->religion);
            $student->caste     = trim($request->caste);
            $student->email        = trim($request->email);
            $student->class_id        = trim($request->class_id);
            if(!empty($request->join_date)){
                $student->join_date= trim($request->join_date);
            }
            if(!empty($request->admission_date)){
                $student->admission_date= trim($request->admission_date);
            }
            $student->status = trim($request->status);
            $student->phone_number = trim($request->phone_number);
            $student->weight = trim($request->weight);
            $student->height = trim($request->height);
            $student->role_name = "Student";
            $student->position = "Student";
            $student->password = Hash::make($request->password);

            if(!empty($request->avatar)) {
                $upload_file = rand() . '.' . $request->avatar->extension();
                $request->avatar->move(storage_path('app/public/student-photos/'), $upload_file);
                $student->avatar = $upload_file;
            }
            $student->save();

            Toastr::success('Has been add successfully :)','Success');
            DB::commit();

            return redirect()->back();

        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new student  :)','Error');
            return redirect()->back();
        }
    }

    /** view for edit student */
    public function studentEdit($id)
    {
        // $studentEdit = Student::where('id',$id)->first();
        $data['studentEdit'] = User::getSingle($id);
        if(!empty($data['studentEdit'])){
            $data['getClass'] = SmClass::getClass();
            $data['header_title'] = "Student Edit";
            return view('student.edit-student',$data);
        }else{
            abort(404);
        }

    }

    /** update record */
    public function studentUpdate($id, Request $request)
    {
        $request->validate([
            'name'    => 'required|string',
            'last_name'     => 'required|string',
            'gender'        => 'required|string',
            'date_of_birth' => 'required',
            'roll_number'          => 'required|max:50',
            'admission_number'   => 'required|max:50',
            'email'         => 'required|email|unique:users,email,'.$id,
            'class_id'         => 'required',
            'height'         => 'max:10',
            'weight'         => 'max:10',
            'blood_group'         => 'max:10',
            'caste'         => 'max:50',
            'religion'         => 'max:50',
            'phone_number'         => 'max:15|min:8',
        ]);

        DB::beginTransaction();
        try {
            $student = User::getSingle($id);
            $student->name   = trim($request->name);
            $student->last_name    = trim($request->last_name);
            $student->gender       = trim($request->gender);
            // $student->user_id       = trim($request->user_id);
            if(!empty($request->date_of_birth)){
                $student->date_of_birth= trim($request->date_of_birth);
            }
            $student->roll_number         = trim($request->roll_number);
            $student->admission_number         = trim($request->admission_number);
            $student->blood_group  = trim($request->blood_group);
            $student->religion     = trim($request->religion);
            $student->caste     = trim($request->caste);
            $student->email        = trim($request->email);
            $student->class_id        = trim($request->class_id);
            if(!empty($request->join_date)){
                $student->join_date= trim($request->join_date);
            }
            if(!empty($request->admission_date)){
                $student->admission_date= trim($request->admission_date);
            }
            $student->status = trim($request->status);
            $student->phone_number = trim($request->phone_number);
            $student->weight = trim($request->weight);
            $student->height = trim($request->height);
            $student->role_name = "Student";
            $student->position = "Student";

            // if(!empty($request->password)){
            //     $student->password = Hash::make($request->password);

            // }

            if (!empty($request->avatar)) {
                if(!empty($request->image_hidden)){
                    unlink(storage_path('app/public/student-photos/'.$request->image_hidden));
                }
                $upload_file = rand() . '.' . $request->avatar->extension();
                $request->avatar->move(storage_path('app/public/student-photos/'), $upload_file);

                $student->avatar = $upload_file;
            } else {
                $upload_file = $request->image_hidden;
                $student->avatar = $upload_file;
            }
            $student->save();

            Toastr::success('Has been update successfully :)','Success');
            DB::commit();

            return redirect()->back();


        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, update student  :)','Error');
            return redirect()->back();
        }
    }

    /** student delete */
    public function studentDelete($id)
    {
        DB::beginTransaction();
        try {
            $getRecord = User::getSingle($id);

            if (!empty($getRecord)) {
                // User::destroy($getRecord);
                unlink(storage_path('app/public/student-photos/'.$getRecord->avatar));
                $getRecord->delete();
                DB::commit();
                Toastr::success('Student deleted successfully :)','Success');
                return redirect()->back();
            }

        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Student deleted fail :)','Error');
            return redirect()->back();
        }
    }

    /** student profile page */
    public function studentProfile($id)
    {
        $studentProfile = Student::where('id',$id)->first();
        return view('student.student-profile',compact('studentProfile'));
    }

    //Teacher side work

    public function MyStudents(){
        $data['studentList'] = User::getTeacherStudent(Auth::user()->id);
        $data['header_title'] = "My Student List";
        return view('teacher.my_student', $data);
    }


}
