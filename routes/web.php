<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssignClassTeacherController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\ClassTimetableController;
use App\Http\Controllers\CommunicateController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\TypeFormController;
use App\Http\Controllers\Setting;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\SmClassController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\FeesCollectionController;
use App\Http\Controllers\PassoutController;

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
    // Route::group(['middleware'=>'admin'],function()
    // {
    //     Route::get('home',function()
    //     {
    //         return view('home');
    //     });
    // });

});
Route::group(['middleware'=>'teacher'],function()
{
    Route::get('teacher/dashboard',function()
    {
        return view('teacher/dashboard');
    });
        // ----------------------- Subjects -----------------------------//
    Route::controller(AssignClassTeacherController::class)->group(function () {

        Route::get('teacher/my_class_subjects', 'MyClassSubjects')->name('teacherClassSubjects'); // My Class Subject

    });
    Route::controller(ClassTimetableController::class)->group(function () {

        Route::get('teacher/my_class_subjects/class_timetable/{class_id}/{subject_id}', 'MyTimetableTeacher')->name('teacherClassSubjectTimetable'); // My Class Subject Timetable

    });

    // ----------------------- Examination -----------------------------//
    Route::controller(ExaminationController::class)->group(function () {

        Route::get('teacher/my_exam_timetable', 'MyExamTimetableTeacher')->name('teacher/my_exam_timetable'); // My Class Subject Timetable
        Route::get('teacher/marks_register', 'TeacherMarksRegister')->middleware('auth')->name('teacher.marks_register'); // staff/list/page
        Route::post('teacher/submit_marks_register', 'submitMarksRegister')->middleware('auth')->name('teacher.submit_marks_register'); // staff/list/page
        Route::post('teacher/single_submit_marks_register', 'singleSubmitMarksRegister')->middleware('auth')->name('teacher.single_submit_marks_register'); // staff/list/page
        Route::get('teacher/my_exam_result/print', 'MyExamResultsPrint')->middleware('auth')->name('teacher.my_exam_result_print'); // staff/list/page

    });


    Route::controller(CalenderController::class)->group(function () {
        Route::get('teacher/my_calender', 'MyCalenderTeacher')->name('teacher/my_calender'); // list student
    });
    // ------------------------ student -------------------------------//
    Route::controller(StudentController::class)->group(function () {
        Route::get('teacher/my_students', 'MyStudents')->name('teacher/my_students'); // list student

    });
    //Attendance class
    Route::controller(AttendanceController::class)->group(function () {
        Route::get('teacher/attendance/students', 'AttendanceStudentsTeacher')->middleware('auth')->name('teacher.attendanceStudents'); // class/list/page
        Route::post('teacher/attendance/students/save', 'AttendanceStudentsSubmit')->middleware('auth')->name('teacher.attendance.students.save'); // class/list/page
        Route::get('teacher/attendance/report', 'AttendanceReportTeacher')->middleware('auth')->name('teacher.attendanceReport'); // class/list/page

    });

});

Route::group(['middleware'=>'student'],function()
{
    Route::get('student/dashboard',function()
    {
        return view('student/dashboard');
    });

    Route::controller(ClassTimetableController::class)->group(function () {
        Route::get('student/timetable', 'MyTimetable')->name('student.timetable'); // list student
    });

    Route::controller(ExaminationController::class)->group(function () {
        Route::get('student/exam_timetable', 'MyExamTimetable')->name('student.exam_timetable'); // list student
        Route::get('student/my_exam_result', 'MyExamResults')->middleware('auth')->name('student.my_exam_result'); // staff/list/page
        Route::get('student/my_exam_result/print', 'MyExamResultsPrint')->middleware('auth')->name('student.my_exam_result_print'); // staff/list/page
    });

    Route::controller(CalenderController::class)->group(function () {
        Route::get('student/my_calender', 'MyCalender')->name('student/my_calender'); // list student
    });

    //Attendance class
    Route::controller(AttendanceController::class)->group(function () {
    Route::get('student/my_attendance', 'MyAttendanceStudent')->name('student/my_attendance'); // class/list/page

    });

        //Student Fees Collection
    Route::controller(FeesCollectionController::class)->group(function () {
        Route::get('student/fees_collection', 'collectFeesStudent')->name('student/fees_collection'); //Student fees collection
        Route::post('student/fees_collection', 'collectFeesStudentPayment')->name('student/fees_collection/payment'); //Student fees collection
        Route::get('student/paypal/payment-error', 'paymentError')->name('student/paypal/payment-error'); //Student fees collection
        Route::get('student/paypal/payment-success', 'paymentSuccess')->name('student/paypal/payment-success'); //Student fees collection
    });

});

Route::group(['middleware'=>'parent'],function()
{
    Route::get('parent/dashboard',function()
    {
        return view('parent/dashboard');
    });

});

Route::group(['middleware'=>'common'],function()
{
    Route::get('chat', [ChatController::class, 'chat']);

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
    Route::get('/home', 'index')->middleware('admin')->name('home');
    Route::get('user/profile/page', 'userProfile')->middleware('auth')->name('user/profile/page');
    Route::post('user/profile/page', 'updateUserProfile')->middleware('auth')->name('update/profile');
    Route::get('teacher/profile/page', 'userProfile')->middleware('teacher')->name('teacher/profile/page');
    Route::post('teacher/profile/page', 'updateTeacherProfile')->middleware('teacher')->name('update/teacher/profile');
    Route::get('student/profile/page', 'userProfile')->middleware('student')->name('student/profile/page');
    // Route::post('student/profile/page', 'updateStudentProfile')->middleware('student')->name('update/student/profile');
    Route::get('parent/profile/page', 'userProfile')->middleware('parent')->name('parent/profile/page');
    // Route::post('parent/profile/page', 'updateParentProfile')->middleware('parent')->name('update/parent/profile');
    Route::get('teacher/dashboard', 'teacherDashboardIndex')->middleware('teacher')->name('teacher/dashboard');
    Route::get('student/dashboard', 'studentDashboardIndex')->middleware('student')->name('student/dashboard');
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
    Route::get('setting/localization', 'localization')->middleware('auth')->name('setting/localization');
    Route::get('setting/payment', 'payment')->middleware('auth')->name('setting/payment');
    Route::post('setting/payment', 'paymentUpdate')->middleware('auth')->name('setting/payment/update');
    Route::get('setting/social', 'socialMedia')->middleware('auth')->name('setting/social');
    Route::get('setting/others', 'other')->middleware('auth')->name('setting/others');
    Route::post('setting/update', 'update')->middleware('auth')->name('setting/update');
});

// ------------------------ student -------------------------------//
Route::controller(StudentController::class)->group(function () {
    Route::get('student/list', 'student')->middleware('auth')->name('student/list'); // list student
    Route::get('student/grid', 'studentGrid')->middleware('auth')->name('student/grid'); // grid student
    Route::get('student/add/page', 'studentAdd')->middleware('auth')->name('student/add/page'); // page student
    Route::post('student/add/save', 'studentSave')->name('student/add/save'); // save record student
    Route::get('student/edit/{id}', 'studentEdit')->middleware('auth'); // view for edit
    Route::post('student/update/{id}', 'studentUpdate')->middleware('auth')->name('student/update'); // update record student
    Route::post('student/delete/{id}', 'studentDelete')->middleware('auth')->name('student/delete'); // delete record student
    Route::get('student/profile/{id}', 'studentProfile')->middleware('auth'); // profile student
    Route::get('student/search_student', 'search_student')->middleware('auth'); // search student
});

// ------------------------ admin -------------------------------//
Route::controller(AdminController::class)->group(function () {
    Route::get('admin/add/page', 'adminAdd')->middleware('auth')->name('admin/add/page'); // page admin
    Route::get('admin/list/page', 'adminList')->middleware('auth')->name('admin/list/page'); // page admin
    Route::get('admin/grid/page', 'adminGrid')->middleware('auth')->name('admin/grid/page'); // page grid admin
    Route::post('admin/save', 'saveRecord')->middleware('auth')->name('admin/save'); // save record
    Route::get('admin/edit/{id}', 'editRecord')->middleware('auth')->name('admin/edit'); // view admin record
    Route::post('admin/update/{id}', 'updateRecordAdmin')->middleware('auth')->name('admin/update'); // update record
    Route::post('admin/delete/{id}', 'adminDelete')->name('admin/delete'); // delete record admin
});
// ------------------------ teacher -------------------------------//
Route::controller(TeacherController::class)->group(function () {
    Route::get('teacher/add/page', 'teacherAdd')->middleware('auth')->name('teacher/add/page'); // page teacher
    Route::get('teacher/list/page', 'teacherList')->middleware('auth')->name('teacher/list/page'); // page teacher
    Route::get('teacher/grid/page', 'teacherGrid')->middleware('auth')->name('teacher/grid/page'); // page grid teacher
    Route::post('teacher/save', 'saveRecord')->middleware('auth')->name('teacher/save'); // save record
    Route::get('teacher/edit/{id}', 'editRecord')->middleware('auth')->name('teacher/edit'); // view teacher record
    Route::post('teacher/update/{id}', 'updateRecordTeacher')->middleware('auth')->name('teacher/update'); // update record
    Route::post('teacher/delete/{id}', 'teacherDelete')->name('teacher/delete'); // delete record teacher
});

// ----------------------- department -----------------------------//
Route::controller(DepartmentController::class)->group(function () {
    Route::get('department/list/page', 'departmentList')->middleware('auth')->name('department/list/page'); // department/list/page
    Route::get('department/add/page', 'indexDepartment')->middleware('auth')->name('department/add/page'); // page add department
    // Route::get('department/edit/page', 'editDepartment')->middleware('auth')->name('department/edit/page'); // page add department
    Route::post('department/add/save', 'departmentSave')->middleware('auth')->name('department/add/save'); // save record department
    Route::get('department/edit/{id}', 'editDepartment')->middleware('auth')->name('department/edit/page'); // view for edit
    Route::post('department/update/{id}', 'departmentUpdate')->middleware('auth')->name('department/update'); // update record department
    Route::post('department/delete/{id}', 'departmentDelete')->middleware('auth')->name('department/delete');
});

// ----------------------- staff -----------------------------//
Route::controller(StaffController::class)->group(function () {
    Route::get('staff/list/page', 'staffList')->middleware('auth')->name('staff.list'); // staff/list/page
    Route::get('staff/add/page', 'addStaff')->middleware('auth')->name('staff.add'); // page add department
    Route::post('staff/add/save', 'staffSave')->middleware('auth')->name('staff.save'); // save record staff
    Route::get('staff/edit/{id}', 'editStaff')->middleware('auth')->name('staff.edit'); // view for edit
    Route::post('staff/update/{id}', 'staffUpdate')->middleware('auth')->name('staff.update'); // update record department
    Route::post('staff/delete/{id}', 'staffDelete')->middleware('auth')->name('staff.delete');
});

// ----------------------- smClasses -----------------------------//
Route::controller(SmClassController::class)->group(function () {
    Route::get('class/list/page', 'classList')->middleware('auth')->name('class.list'); // class/list/page
    Route::get('class/add/page', 'addClass')->middleware('auth')->name('class.add'); // page add department
    Route::post('class/add/save', 'smClassSave')->middleware('auth')->name('class.save'); // save record class
    Route::get('class/edit/{id}', 'editSmClass')->middleware('auth')->name('class.edit'); // view for edit
    Route::post('class/update/{id}', 'SmClassUpdate')->middleware('auth')->name('class.update'); // update record department
    Route::post('class/delete/{id}', 'smClassDelete')->middleware('auth')->name('class.delete');
});

// ----------------------- smParents -----------------------------//
Route::controller(ParentController::class)->group(function () {
    Route::get('parent/list/page', 'parentList')->middleware('auth')->name('parent.list'); // class/list/page
    Route::get('parent/add/page', 'parentAdd')->middleware('auth')->name('parent.add'); // page add department
    Route::post('parent/add/save', 'parentSave')->name('parent.save'); // save record class
    Route::get('parent/edit/{id}', 'parentEdit')->middleware('auth')->name('parent.edit'); // view for edit
    Route::post('parent/update/{id}', 'parentUpdate')->middleware('auth')->name('parent.update'); // update record department
    Route::post('parent/delete/{id}', 'parentDelete')->middleware('auth')->name('parent.delete');
    Route::get('parent/my-student/{id}', 'myStudent')->middleware('auth')->name('parent.student');
    Route::get('parent/assign_student_parent/{student_id}/{parent_id}', 'assignStudentParent')->middleware('auth')->name('assign_student_parent');
    Route::get('parent/assign_student_parent_delete/{student_id}', 'assignStudentParentDelete')->middleware('auth')->name('assign_student_parent.delete');
});

// ----------------------- Subjects -----------------------------//
Route::controller(SubjectController::class)->group(function () {
    Route::get('subject/list/page', 'subjectList')->middleware('auth')->name('subject.list'); // class/list/page
    Route::get('subject/add/page', 'addSubject')->middleware('auth')->name('subject.add'); // page add department
    Route::post('subject/add/save', 'subjectSave')->middleware('auth')->name('subject.save'); // save record class
    Route::get('subject/edit/{id}', 'subjectEdit')->middleware('auth')->name('subject.edit'); // view for edit
    Route::post('subject/update/{id}', 'subjectUpdate')->middleware('auth')->name('subject.update'); // update record department
    Route::post('subject/delete/{id}', 'subjectDelete')->middleware('auth')->name('subject.delete');
    Route::get('student/my_subjects', 'mySubjects')->middleware('auth')->name('subject.student'); // search student
    // Route::get('teacher/my_class_subjects', 'teacherClassSubjects')->middleware('auth')->name('teacherClassSubjects'); // search student

});

// -----------------------Assign Subjects -----------------------------//
Route::controller(ClassSubjectController::class)->group(function () {
    Route::get('admin/assign_subject/list', 'list')->middleware('auth')->name('assign_subject.list'); // class/list/page
    Route::get('admin/assign_subject/add', 'add')->middleware('auth')->name('assign_subject.add'); // page add department
    Route::post('admin/assign_subject/add', 'insert')->name('assign_subject.save'); // save record class
    Route::get('admin/assign_subject/edit/{id}', 'edit')->middleware('auth')->name('assign_subject.edit'); // view for edit
    Route::get('admin/assign_subject/edit_single/{id}', 'edit_single')->middleware('auth')->name('assign_subject.edit_single'); // view for edit
    Route::post('admin/assign_subject/edit/{id}', 'update')->middleware('auth')->name('assign_subject.update'); // update record department
    Route::post('admin/assign_subject/edit_single/{id}', 'update_single')->middleware('auth')->name('assign_subject.update_single'); // update record department
    Route::post('admin/assign_subject/delete/{id}', 'delete')->middleware('auth')->name('assign_subject.delete');
});

// -----------------------Assign Class to Teacher -----------------------------//
Route::controller(AssignClassTeacherController::class)->group(function () {
    Route::get('admin/assign_class_teacher/list', 'list')->middleware('auth')->name('assign_class_teacher.list'); // class/list/page
    Route::get('admin/assign_class_teacher/add', 'add')->middleware('auth')->name('assign_class_teacher.add'); // page add department
    Route::post('admin/assign_class_teacher/add', 'insert')->middleware('auth')->name('assign_class_teacher.save'); // save record class
    Route::get('admin/assign_class_teacher/edit/{id}', 'edit')->middleware('auth')->name('assign_class_teacher.edit'); // view for edit
    Route::get('admin/assign_class_teacher/edit_single/{id}', 'edit_single')->middleware('auth')->name('assign_class_teacher.edit_single'); // view for edit
    Route::post('admin/assign_class_teacher/edit/{id}', 'update')->middleware('auth')->name('assign_class_teacher.update'); // update record department
    Route::post('admin/assign_class_teacher/edit_single/{id}', 'update_single')->middleware('auth')->name('assign_class_teacher.update_single'); // update record department
    Route::post('admin/assign_class_teacher/delete/{id}', 'delete')->middleware('auth')->name('assign_class_teacher.delete');
});

//Class Timetable
Route::controller(ClassTimetableController::class)->group(function () {
    Route::get('admin/class_timetable/list', 'list')->middleware('auth')->name('class_timetable.list'); // class/list/page
    Route::post('admin/class_timetable/get_subject', 'get_subject')->middleware('auth')->name('get_subject'); // page add department
    Route::post('admin/class_timetable/add', 'insert_update')->middleware('auth')->name('class_timetable.insert_update'); // save record class
    // Route::get('admin/assign_class_teacher/edit/{id}', 'edit')->middleware('auth')->name('assign_class_teacher.edit'); // view for edit
    // Route::get('admin/assign_class_teacher/edit_single/{id}', 'edit_single')->middleware('auth')->name('assign_class_teacher.edit_single'); // view for edit
    // Route::post('admin/assign_class_teacher/edit/{id}', 'update')->name('assign_class_teacher.update'); // update record department
    // Route::post('admin/assign_class_teacher/edit_single/{id}', 'update_single')->name('assign_class_teacher.update_single'); // update record department
    // Route::post('admin/assign_class_teacher/delete/{id}', 'delete')->name('assign_class_teacher.delete');
});

//Attendance class
Route::controller(AttendanceController::class)->group(function () {
    Route::get('attendance/students', 'AttendanceStudents')->middleware('auth')->name('attendance.students'); // class/list/page
    Route::post('attendance/students/save', 'AttendanceStudentsSubmit')->middleware('auth')->name('attendance.students.save'); // class/list/page
    Route::get('attendance/report', 'AttendanceReport')->middleware('auth')->name('attendance.report'); // class/list/page

});

//Fees Collection
Route::controller(FeesCollectionController::class)->group(function () {
    Route::get('admin/fees_collection', 'collect_fees')->middleware('auth')->name('admin/fees_collection'); // fees collection
    Route::get('admin/fees_collection/add/{student_id}', 'collect_fees_add')->middleware('auth')->name('admin/fees_collection/add'); // fees collection
    Route::post('admin/fees_collection/add/{student_id}', 'collect_fees_insert')->middleware('auth')->name('admin/fees_collection/insert'); // fees collection
    Route::get('admin/fees_collection/edit', 'collect_fees_edit')->middleware('auth')->name('admin/fees_collection/edit'); // admin/fees_collection/edit
    Route::post('admin/fees_collection/delete', 'collect_fees_delete')->middleware('auth')->name('admin/fees_collection/delete'); // class/list/page

});

// ----------------------- Examination -----------------------------//
Route::controller(ExaminationController::class)->group(function () {
    Route::get('examination/list/page', 'examList')->middleware('auth')->name('exam.list'); // staff/list/page
    Route::get('examination/add/page', 'addExam')->middleware('auth')->name('exam.add'); // page add department
    Route::post('examination/add/save', 'saveExam')->middleware('auth')->name('exam.save'); // save record staff
    Route::get('examination/edit/{id}', 'editExam')->middleware('auth')->name('exam.edit'); // view for edit
    Route::post('examination/update/{id}', 'examUpdate')->middleware('auth')->name('exam.update'); // update record department
    Route::post('examination/delete/{id}', 'examDelete')->middleware('auth')->name('exam.delete');

    Route::get('examination/schedule/page', 'examSchedule')->middleware('auth')->name('exam.schedule'); // staff/list/page
    Route::post('examination/schedule/save', 'saveExamSchedule')->middleware('auth')->name('examSchedule.save'); // save record staff

    Route::get('examinations/marks_register', 'marksRegister')->middleware('auth')->name('exam.marks_register'); // staff/list/page
    Route::post('examinations/submit_marks_register', 'submitMarksRegister')->middleware('auth')->name('exam.submit_marks_register'); // staff/list/page
    Route::post('examinations/single_submit_marks_register', 'singleSubmitMarksRegister')->middleware('auth')->name('exam.single_submit_marks_register'); // staff/list/page

    Route::get('examinations/marks_grade', 'marksGrade')->middleware('auth')->name('exam.marks_grade'); // staff/list/page
    Route::get('examinations/submit_marks_grade', 'submitMarksGrade')->middleware('auth')->name('exam.submit_marks_grade'); // staff/list/page
    Route::post('examinations/submit_marks_grade/save', 'saveMarksGrade')->middleware('auth')->name('exam.submit_marks_grade_save'); // staff/list/page
    Route::get('examination/marks_grade/edit/{id}', 'marksGradeEdit')->middleware('auth')->name('marks_grade.edit'); // view for edit
    Route::post('examination/marks_grade/update/{id}', 'marksGradeUpdate')->middleware('auth')->name('marksGrade.update'); // update record department
    Route::post('examination/marks_grade/delete/{id}', 'marksGradeDelete')->middleware('auth')->name('marksGrade.delete');

    Route::get('admin/my_exam_result/print', 'MyExamResultsPrint')->middleware('auth')->name('admin.my_exam_result_print'); // staff/list/page

});

//------------------------------------------Communications---------------------------------------//

Route::controller(CommunicateController::class)->group(function () {
    Route::get('admin/communicate/notice_board', 'NoticeBoard')->middleware('auth')->name('admin/communicate/notice_board'); // admin/communicate/notice_board
    Route::get('admin/communicate/add', 'AddNoticeBoard')->middleware('auth')->name('admin/communicate/add'); // admin/communicate/notice_board
    Route::post('admin/communicate/notice_board/save', 'SaveNoticeBoard')->middleware('auth')->name('admin/communicate/notice_board/save'); // admin/communicate/notice_board
    Route::get('admin/communicate/notice_board/edit/{id}', 'EditNoticeBoard')->middleware('auth')->name('admin/communicate/notice_board/edit'); // admin/communicate/notice_board
    Route::post('admin/communicate/notice_board/edit/{id}', 'UpdateNoticeBoard')->middleware('auth')->name('admin/communicate/notice_board/update'); // admin/communicate/notice_board
    Route::post('admin/communicate/notice_board/delete/{id}', 'DeleteNoticeBoard')->middleware('auth')->name('admin/communicate/notice_board/delete'); // admin/communicate/notice_board

    Route::get('admin/communicate/send_email', 'SendEmail')->middleware('auth')->name('admin/communicate/send_email'); // admin/communicate/notice_board
    Route::post('admin/communicate/send_email', 'SendEmailUser')->middleware('auth')->name('admin/communicate/send_email/save'); // admin/communicate/notice_board
    Route::get('admin/communicate/send_email/get_users', 'SearchUsers')->middleware('auth')->name('admin/communicate/send_email/get_users'); // admin/communicate/notice_board
    // Route::post('admin/communicate/send_email/save', 'SendEmailSave')->middleware('auth')->name('admin/communicate/send_email/save'); // admin/communicate/notice_board


});
//------------------------------------------Events---------------------------------------//

Route::controller(EventController::class)->group(function () {
    Route::get('admin/events/list', 'EventList')->middleware('auth')->name('admin/events/list'); // admin/events/list
    Route::get('admin/events/add', 'AddEvent')->middleware('auth')->name('admin/events/add'); // admin/events/add
    // Route::post('admin/events/save', 'SaveNoticeBoard')->middleware('auth')->name('admin/events/save'); // admin/events/save
    Route::get('admin/events/edit/{id}', 'EditEvent')->middleware('auth')->name('admin/events/edit'); // admin/events/edit
    // Route::post('admin/events/edit/{id}', 'UpdateNoticeBoard')->middleware('auth')->name('admin/events/update'); // admin/events/update
    // Route::post('admin/events/delete/{id}', 'DeleteNoticeBoard')->middleware('auth')->name('admin/events/delete'); // admin/events/delete


});
// HomeWork
Route::controller(HomeworkController::class)->group(function () {
    Route::get('admin/holiday/homework', 'Homework')->middleware('auth')->name('admin/holiday/homework'); // Homework
    Route::get('admin/holiday/homework/add', 'HomeworkAdd')->middleware('auth')->name('admin/holiday/homework/add'); // Homework
    Route::post('admin/ajax_get_subject', 'ajax_get_subject')->middleware('auth')->name('admin/ajax_get_subject'); // Homework
    Route::post('admin/holiday/homework/save', 'HomeworkSave')->middleware('auth')->name('admin/holiday/homework/save'); // Homework
    Route::get('admin/holiday/homework/edit/{id}', 'HomeworkEdit')->middleware('auth')->name('admin/holiday/homework/edit'); // view for edit
    Route::post('admin/holiday/homework/update/{id}', 'HomeworkUpdate')->middleware('auth')->name('admin/holiday/homework/update'); // update record department
    Route::post('admin/holiday/homework/delete/{id}', 'HomeworkDelete')->middleware('auth')->name('admin/holiday/homework/delete');
});

// PassOut
Route::controller(PassoutController::class)->group(function () {
    Route::get('admin/passout/list', 'passoutList')->middleware('auth')->name('admin/passout/list');
    Route::get('admin/passout/add', 'passoutAdd')->middleware('auth')->name('admin/passout/add');
    // Route::post('admin/passout/save', 'HomeworkSave')->middleware('auth')->name('admin/passout/save');
    Route::get('admin/passout/edit/{id}', 'passoutEdit')->middleware('auth')->name('admin/passout/edit');
    // Route::post('admin/passout/update/{id}', 'HomeworkUpdate')->middleware('auth')->name('admin/passout/update');
    // Route::post('admin/passout/delete/{id}', 'HomeworkDelete')->middleware('auth')->name('admin/passout/delete');
});
