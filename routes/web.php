<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\TypeFormController;
use App\Http\Controllers\Setting;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SmClassController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\SubjectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** for side bar menu active */
function set_active( $route ) {
    if( is_array( $route ) ){
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware'=>'auth'],function()
{
    Route::get('home',function()
    {
        return view('home');
    });
    // Route::get('home',function()
    // {
    //     return view('home');
    // });
});
Route::group(['middleware'=>'teacher'],function()
{
    Route::get('teacher/dashboard',function()
    {
        return view('teacher/dashboard');
    });

});
Route::group(['middleware'=>'student'],function()
{
    Route::get('student/dashboard',function()
    {
        return view('student/dashboard');
    });

});

Route::group(['middleware'=>'parent'],function()
{
    Route::get('parent/dashboard',function()
    {
        return view('parent/dashboard');
    });

});

Auth::routes();

// ----------------------------login ------------------------------//
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('/forgot-password', 'forgotPassword')->name('forgotPassword');
    Route::post('forgot-password', 'postForgotPassword')->name('postForgotPassword');
});

// ----------------------------- register -------------------------//
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/register','storeUser')->name('register');
});


// -------------------------- main dashboard ----------------------//
Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'index')->middleware('auth')->name('home');
    Route::get('user/profile/page', 'userProfile')->middleware('auth')->name('user/profile/page');
    Route::get('teacher/dashboard', 'teacherDashboardIndex')->middleware('auth')->name('teacher/dashboard');
    Route::get('student/dashboard', 'studentDashboardIndex')->middleware('auth')->name('student/dashboard');
    Route::get('parent/dashboard', 'parentDashboardIndex')->middleware('auth')->name('parent/dashboard');
});

// ----------------------------- user controller -------------------------//
Route::controller(UserManagementController::class)->group(function () {
    Route::get('list/users', 'index')->middleware('auth')->name('list/users');
    Route::post('change/password', 'changePassword')->name('change/password');
    Route::get('view/user/edit/{id}', 'userView')->middleware('auth');
    Route::post('user/update', 'userUpdate')->name('user/update');
    Route::post('user/delete', 'userDelete')->name('user/delete');
});

// ------------------------ setting -------------------------------//
Route::controller(Setting::class)->group(function () {
    Route::get('setting/page', 'index')->middleware('auth')->name('setting/page');
});

// ------------------------ student -------------------------------//
Route::controller(StudentController::class)->group(function () {
    Route::get('student/list', 'student')->middleware('auth')->name('student/list'); // list student
    Route::get('student/grid', 'studentGrid')->middleware('auth')->name('student/grid'); // grid student
    Route::get('student/add/page', 'studentAdd')->middleware('auth')->name('student/add/page'); // page student
    Route::post('student/add/save', 'studentSave')->name('student/add/save'); // save record student
    Route::get('student/edit/{id}', 'studentEdit'); // view for edit
    Route::post('student/update', 'studentUpdate')->name('student/update'); // update record student
    Route::post('student/delete', 'studentDelete')->name('student/delete'); // delete record student
    Route::get('student/profile/{id}', 'studentProfile')->middleware('auth'); // profile student
    Route::get('student/search_student', 'search_student')->middleware('auth'); // search student
});

// ------------------------ teacher -------------------------------//
Route::controller(TeacherController::class)->group(function () {
    Route::get('teacher/add/page', 'teacherAdd')->middleware('auth')->name('teacher/add/page'); // page teacher
    Route::get('teacher/list/page', 'teacherList')->middleware('auth')->name('teacher/list/page'); // page teacher
    Route::get('teacher/grid/page', 'teacherGrid')->middleware('auth')->name('teacher/grid/page'); // page grid teacher
    Route::post('teacher/save', 'saveRecord')->middleware('auth')->name('teacher/save'); // save record
    Route::get('teacher/edit/{id}', 'editRecord'); // view teacher record
    Route::post('teacher/update', 'updateRecordTeacher')->middleware('auth')->name('teacher/update'); // update record
    Route::post('teacher/delete', 'teacherDelete')->name('teacher/delete'); // delete record teacher
});

// ----------------------- department -----------------------------//
Route::controller(DepartmentController::class)->group(function () {
    Route::get('department/list/page', 'departmentList')->middleware('auth')->name('department/list/page'); // department/list/page
    Route::get('department/add/page', 'indexDepartment')->middleware('auth')->name('department/add/page'); // page add department
    // Route::get('department/edit/page', 'editDepartment')->middleware('auth')->name('department/edit/page'); // page add department
    Route::post('department/add/save', 'departmentSave')->name('department/add/save'); // save record department
    Route::get('department/edit/{id}', 'editDepartment')->middleware('auth')->name('department/edit/page'); // view for edit
    Route::post('department/update/{id}', 'departmentUpdate')->name('department/update'); // update record department
    Route::post('department/delete/{id}', 'departmentDelete')->name('department/delete');
});

// ----------------------- staff -----------------------------//
Route::controller(StaffController::class)->group(function () {
    Route::get('staff/list/page', 'staffList')->middleware('auth')->name('staff.list'); // staff/list/page
    Route::get('staff/add/page', 'addStaff')->middleware('auth')->name('staff.add'); // page add department
    Route::post('staff/add/save', 'staffSave')->name('staff.save'); // save record staff
    Route::get('staff/edit/{id}', 'editStaff')->middleware('auth')->name('staff.edit'); // view for edit
    Route::post('staff/update/{id}', 'staffUpdate')->name('staff.update'); // update record department
    Route::post('staff/delete/{id}', 'staffDelete')->name('staff.delete');
});

// ----------------------- smClasses -----------------------------//
Route::controller(SmClassController::class)->group(function () {
    Route::get('class/list/page', 'classList')->middleware('auth')->name('class.list'); // class/list/page
    Route::get('class/add/page', 'addClass')->middleware('auth')->name('class.add'); // page add department
    Route::post('class/add/save', 'smClassSave')->name('class.save'); // save record class
    Route::get('class/edit/{id}', 'editSmClass')->middleware('auth')->name('class.edit'); // view for edit
    Route::post('class/update/{id}', 'SmClassUpdate')->name('class.update'); // update record department
    Route::post('class/delete/{id}', 'smClassDelete')->name('class.delete');
});

// ----------------------- smParents -----------------------------//
Route::controller(ParentController::class)->group(function () {
    Route::get('parent/list/page', 'parentList')->middleware('auth')->name('parent.list'); // class/list/page
    Route::get('parent/add/page', 'parentAdd')->middleware('auth')->name('parent.add'); // page add department
    Route::post('parent/add/save', 'parentSave')->name('parent.save'); // save record class
    Route::get('parent/edit/{id}', 'parentEdit')->middleware('auth')->name('parent.edit'); // view for edit
    Route::post('parent/update/{id}', 'parentUpdate')->name('parent.update'); // update record department
    Route::post('parent/delete/{id}', 'parentDelete')->name('parent.delete');
});

// ----------------------- Subjects -----------------------------//
Route::controller(SubjectController::class)->group(function () {
    Route::get('subject/list/page', 'subjectList')->middleware('auth')->name('subject.list'); // class/list/page
    Route::get('subject/add/page', 'addSubject')->middleware('auth')->name('subject.add'); // page add department
    Route::post('subject/add/save', 'subjectSave')->name('subject.save'); // save record class
    Route::get('subject/edit/{id}', 'subjectEdit')->middleware('auth')->name('subject.edit'); // view for edit
    Route::post('subject/update/{id}', 'subjectUpdate')->name('subject.update'); // update record department
    Route::post('subject/delete/{id}', 'subjectDelete')->name('subject.delete');
});

// -----------------------Assign Subjects -----------------------------//
Route::controller(ClassSubjectController::class)->group(function () {
    Route::get('admin/assign_subject/list', 'list')->middleware('auth')->name('assign_subject.list'); // class/list/page
    Route::get('admin/assign_subject/add', 'add')->middleware('auth')->name('assign_subject.add'); // page add department
    Route::post('admin/assign_subject/add', 'insert')->name('assign_subject.save'); // save record class
    Route::get('admin/assign_subject/edit/{id}', 'edit')->middleware('auth')->name('assign_subject.edit'); // view for edit
    Route::get('admin/assign_subject/edit_single/{id}', 'edit_single')->middleware('auth')->name('assign_subject.edit_single'); // view for edit
    Route::post('admin/assign_subject/edit/{id}', 'update')->name('assign_subject.update'); // update record department
    Route::post('admin/assign_subject/edit_single/{id}', 'update_single')->name('assign_subject.update_single'); // update record department
    Route::post('admin/assign_subject/delete/{id}', 'delete')->name('assign_subject.delete');
});

