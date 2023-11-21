<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\SmClass;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use Brian2694\Toastr\Facades\Toastr;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    /** home dashboard */
    public function index()
    {
        $numberOfStudents = Student::count();
        $numberOfTeachers = Teacher::count();
        $numberOfDepartments = Department::count();
        $numberOfClasses = SmClass::count();
        return view('dashboard.home', compact('numberOfStudents', 'numberOfTeachers', 'numberOfDepartments', 'numberOfClasses'));
    }

    /** profile user */
    public function userProfile()
    {
        $data['teacher'] = User::getSingle(Auth::User()->id);
        $data['getClass'] = SmClass::getClass();
        if(Auth::User()->role_name == 'Teacher')
            return view('dashboard.teacher_profile', $data);
        elseif (Auth::User()->role_name == 'Student') {
            return view('dashboard.student_profile', $data);
        }elseif (Auth::User()->role_name == 'Parent') {
            return view('dashboard.parent_profile', $data);
        }
        else{
            return view('dashboard.profile', $data);
        }

    }
    /** profile user */
    public function teacherProfile()
    {
        $data['teacher'] = User::getSingle(Auth::User()->id);
        return view('dashboard.teacher_profile', $data);
    }
    /** profile user */
    public function studentProfile()
    {
        $data['student'] = User::getSingle(Auth::User()->id);
        return view('dashboard.student_profile', $data);
    }
    /** profile user */
    public function parentProfile()
    {
        $data['parent'] = User::getSingle(Auth::User()->id);
        return view('dashboard.parent_profile', $data);
    }

    public function updateTeacherProfile(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'name'       => 'required|string',
            'last_name'       => 'required|string',
            'gender'          => 'required|string',
            'date_of_birth'   => 'required|string',
            'phone_number'   => 'max:15|min:8',
            'marital_status'   => 'max:50',
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
            $teacher->marital_status        = trim($request->marital_status);
            $teacher->address = trim($request->address);
            $teacher->current_address = trim($request->current_address);
            $teacher->phone_number = trim($request->phone_number);


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

            Toastr::success('Details Updated successfully :)','Success');
            DB::commit();
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, update record  :)','Error');
            return redirect()->back();
        }
    }
    public function updateUserProfile(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'name'             => 'required|string',
            'last_name'        => 'required|string',
            'email'            => 'required|email|unique:users,email,'.$id,

        ]);
        DB::beginTransaction();
        try {
            $teacher = User::getSingle($id);
            $teacher->name   = trim($request->name);
            $teacher->last_name    = trim($request->last_name);
            $teacher->email       = trim($request->email);

            $teacher->save();

            Toastr::success('Details Updated successfully :)','Success');
            DB::commit();
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, update record  :)','Error');
            return redirect()->back();
        }
    }

    /** teacher dashboard */
    public function teacherDashboardIndex()
    {
        $data['teacher'] = User::getSingle(Auth::User()->id);
        return view('dashboard.teacher_dashboard', $data);
    }

    /** student dashboard */
    public function studentDashboardIndex()
    {
        $data['student'] = User::getSingle(Auth::User()->id);
        return view('dashboard.student_dashboard', $data);
    }

    /** student dashboard */
    public function parentDashboardIndex()
    {
        $data['parent'] = User::getSingle(Auth::User()->id);
        return view('dashboard.parent_dashboard', $data);
    }
}
