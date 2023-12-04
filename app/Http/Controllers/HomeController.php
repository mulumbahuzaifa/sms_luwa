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
Use Charts;

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
        $numberOfStudents = User::getStudents()->count();
        $numberOfTeachers = User::getTeacher()->count();
        $numberOfDepartments = Department::count();
        $numberOfClasses = SmClass::count();

        $users = User::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
                    ->whereYear('created_at', date('Y'))
                    ->groupBy(DB::raw("Month(created_at)"))
                    ->pluck('count', 'month_name');

        $labels = $users->keys();
        $data = $users->values();

        // dd($labels, $data);

        return view('dashboard.home', compact('numberOfStudents', 'numberOfTeachers', 'numberOfDepartments', 'numberOfClasses', 'labels', 'data',));
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

    public function makeChart($type)
    {
        switch ($type) {
            case 'bar':
            $users = User::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))
            ->get();
            $chart = Charts::database($users, 'bar', 'highcharts')
            ->title("Monthly new Register Users")
            ->elementLabel("Total Users")
            ->dimensions(1000, 500)
            ->responsive(true)
            ->groupByMonth(date('Y'), true);
            break;
            case 'pie':
            $chart = Charts::create('pie', 'highcharts')
            ->title('HDTuto.com Laravel Pie Chart')
            ->labels(['Codeigniter', 'Laravel', 'PHP'])
            ->values([5,10,20])
            ->dimensions(1000,500)
            ->responsive(true);
            break;
            case 'donut':
            $chart = Charts::create('donut', 'highcharts')
            ->title('HDTuto.com Laravel Donut Chart')
            ->labels(['First', 'Second', 'Third'])
            ->values([5,10,20])
            ->dimensions(1000,500)
            ->responsive(true);
            break;
            case 'line':
            $chart = Charts::create('line', 'highcharts')
            ->title('HDTuto.com Laravel Line Chart')
            ->elementLabel('HDTuto.com Laravel Line Chart Lable')
            ->labels(['First', 'Second', 'Third'])
            ->values([5,10,20])
            ->dimensions(1000,500)
            ->responsive(true);
            break;
            case 'area':
            $chart = Charts::create('area', 'highcharts')
            ->title('HDTuto.com Laravel Area Chart')
            ->elementLabel('HDTuto.com Laravel Line Chart label')
            ->labels(['First', 'Second', 'Third'])
            ->values([5,10,20])
            ->dimensions(1000,500)
            ->responsive(true);
            break;
            case 'geo':
            $chart = Charts::create('geo', 'highcharts')
            ->title('HDTuto.com Laravel GEO Chart')
            ->elementLabel('HDTuto.com Laravel GEO Chart label')
            ->labels(['ES', 'FR', 'RU'])
            ->colors(['#3D3D3D', '#985689'])
            ->values([5,10,20])
            ->dimensions(1000,500)
            ->responsive(true);
            break;
            default:
            break;
        }
        return view('chart', compact('chart'));
    }
}
