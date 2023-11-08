<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\SmClass;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

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
        return view('dashboard.profile');
    }

    /** teacher dashboard */
    public function teacherDashboardIndex()
    {
        return view('dashboard.teacher_dashboard');
    }

    /** student dashboard */
    public function studentDashboardIndex()
    {
        return view('dashboard.student_dashboard');
    }

    /** student dashboard */
    public function parentDashboardIndex()
    {
        return view('dashboard.parent_dashboard');
    }
}
