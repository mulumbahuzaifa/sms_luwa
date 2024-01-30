<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                <li class="{{set_active(['setting/page'])}}">
                    <a href="{{ route('setting/page') }}">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
                @endif
                <li class="submenu {{set_active(['home','teacher/dashboard','student/dashboard', 'parent/dashboard'])}}">
                    <a href="#"><i class="feather-grid"></i>
                        <span> Dashboard</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                        <li><a href="{{ route('home') }}" class="{{set_active(['home'])}}">Admin Dashboard</a></li>
                        {{-- <li><a href="{{ route('teacher/dashboard') }}" class="{{set_active(['teacher/dashboard'])}}">Teacher Dashboard</a></li>
                        <li><a href="{{ route('student/dashboard') }}" class="{{set_active(['student/dashboard'])}}">Student Dashboard</a></li>
                        <li><a href="{{ route('parent/dashboard') }}" class="{{set_active(['parent/dashboard'])}}">Parent Dashboard</a></li> --}}
                        @elseif (Session::get('role_name') === 'Teacher')
                        <li><a href="{{ route('teacher/dashboard') }}" class="{{set_active(['teacher/dashboard'])}}">Teacher Dashboard</a></li>
                        @elseif (Session::get('role_name') === 'Student')
                        <li><a href="{{ route('student/dashboard') }}" class="{{set_active(['student/dashboard'])}}">Student Dashboard</a></li>
                        @elseif (Session::get('role_name') === 'Parent')
                        <li><a href="{{ route('parent/dashboard') }}" class="{{set_active(['parent/dashboard'])}}">Parent Dashboard</a></li>
                        @endif
                    </ul>
                </li>
                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                    <li class="submenu {{set_active(['list/users'])}} {{ (request()->is('view/user/edit/*')) ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-shield-alt"></i>
                            <span>User Management</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('list/users') }}" class="{{set_active(['list/users'])}} {{ (request()->is('view/user/edit/*')) ? 'active' : '' }}">List Users</a></li>
                        </ul>
                    </li>
                    <li class="submenu  {{set_active(['admin/add/page','admin/list/page'])}}">
                        <a href="#"><i class="fas fa-user"></i>
                            <span> Admin</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('admin/list/page') }}" class="{{set_active(['admin/list/page'])}}">Admin List</a></li>
                            <li><a href="{{ route('admin/add/page') }}" class="{{set_active(['admin/add/page'])}}">Admin Add</a></li>
                        </ul>
                    </li>
                    <li class="submenu  {{set_active(['teacher/add/page','teacher/list/page','teacher/grid/page','teacher/edit'])}} {{ (request()->is('teacher/edit/*')) ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-chalkboard-teacher"></i>
                            <span> Teachers</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('teacher/list/page') }}" class="{{set_active(['teacher/list/page','teacher/grid/page'])}}">Teacher List</a></li>
                            {{-- <li><a href="teacher-details.html">Teacher View</a></li> --}}
                            <li><a href="{{ route('teacher/add/page') }}" class="{{set_active(['teacher/add/page'])}}">Teacher Add</a></li>
                            {{-- <li><a class="{{ (request()->is('teacher/edit/*')) ? 'active' : '' }}">Teacher Edit</a></li> --}}
                        </ul>
                    </li>
                    <li class="submenu {{set_active(['student/list','student/grid','student/add/page'])}} {{ (request()->is('student/edit/*')) ? 'active' : '' }} {{ (request()->is('student/profile/*')) ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-graduation-cap"></i>
                            <span> Students</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('student/list') }}"  class="{{set_active(['student/list','student/grid'])}}">Student List</a></li>
                                <li><a href="{{ route('student/add/page') }}" class="{{set_active(['student/add/page'])}}">Student Add</a></li>
                            {{-- <li><a class="{{ (request()->is('student/edit/*')) ? 'active' : '' }}">Student Edit</a></li> --}}
                            {{-- <li><a href=""  class="{{ (request()->is('student/profile/*')) ? 'active' : '' }}">Student View</a></li> --}}
                        </ul>
                    </li>
                    <li class="submenu {{set_active(['parent/list', 'parent/add/page'])}}">
                        <a href="#"><i class="fas fa-book-reader"></i>
                            <span> Parents</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('parent.list') }}" class="{{set_active(['parent/list'])}}">Parents List</a></li>
                                <li><a href="{{ route('parent.add') }}" class="{{set_active(['parent/add/page'])}}">Parent Add</a></li>
                            {{-- <li><a href="{{ route('department/edit/page') }}" class="{{set_active(['department/edit/page'])}}">Department Edit</a></li> --}}
                        </ul>
                    </li>
                    <li class="submenu {{set_active(['staff/librarians', 'staff/nurses', 'staff/wardens', 'staff/accountants', 'staff/security_guards'])}}">
                        <a href="#"><i class="fas fa-book-reader"></i>
                            <span> Staffs</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="#" class="{{set_active(['staff/librarians'])}}">Librarians</a></li>
                            <li><a href="#" class="{{set_active(['staff/nurses'])}}">Nurses</a></li>
                            <li><a href="#" class="{{set_active(['staff/wardens'])}}">Wardens</a></li>
                            <li><a href="#" class="{{set_active(['staff/accountants'])}}">Accountants</a></li>
                            <li><a href="#" class="{{set_active(['staff/security_guards'])}}">Security Guards</a></li>
                        </ul>
                    </li>
                    <li class="submenu {{set_active(['department/list/page','department/add/page','department/edit/page'])}}">
                        <a href="#"><i class="fas fa-building"></i>
                            <span> Departments</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('department/list/page') }}" class="{{set_active(['department/list/page'])}}">Department List</a></li>
                                <li><a href="{{ route('department/add/page') }}" class="{{set_active(['department/add/page'])}}">Department Add</a></li>

                            {{-- <li><a href="{{ route('department/edit/page') }}" class="{{set_active(['department/edit/page'])}}">Department Edit</a></li> --}}
                        </ul>
                    </li>

                    <li class="submenu  {{set_active(['class/list/page','subject/list/page','admin/assign_subject/list', 'admin/class_timetable/list'])}}">
                        <a href="#"><i class="fas fa-book-reader"></i>
                            <span> Academics</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('class.list') }}" class="{{set_active(['class/list/page'])}}">Classes</a></li>
                            <li><a href="{{ route('subject.list') }}" class="{{set_active(['subject/list/page'])}}">Subject List</a></li>
                            <li><a href="{{ route('assign_subject.list') }}" class="{{set_active(['admin/assign_subject/list'])}}">Assign Subjects->Class</a></li>
                            <li><a href="{{ route('assign_class_teacher.list') }}" class="{{set_active(['admin/assign_class_teacher/list'])}}">Assign Class->Teacher</a></li>
                            <li><a href="{{ route('class_timetable.list') }}" class="{{set_active(['admin/class_timetable/list'])}}">Class Timetables</a></li>
                        </ul>
                    </li>
                    <li class="submenu  {{set_active(['examinations/list/page', 'examinations/schedule/page', 'examinations/marks_register'])}}">
                        <a href="#"><i class="fas fa-clipboard-list"></i>
                            <span> Examination</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('exam.list') }}" class="{{set_active(['examinations/list/page'])}}">Exam List</a></li>
                            <li><a href="{{ route('exam.schedule') }}" class="{{set_active(['examinations/schedule/page'])}}">Exam Schedule</a></li>
                            <li><a href="{{ route('exam.marks_register') }}" class="{{set_active(['examinations/marks_register'])}}">Marks Register</a></li>
                            <li><a href="{{ route('exam.marks_grade') }}" class="{{set_active(['examinations/marks_grade'])}}">Marks Grade</a></li>
                        </ul>
                    </li>
                    <li class="submenu  {{set_active(['attendance/students', 'attendance/report'])}}">
                        <a href="#"><i class="fas fa-table"></i>
                            <span> Attendance</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('attendance.students') }}" class="{{set_active(['attendance/students'])}}">Students Attendance</a></li>
                            <li><a href="{{ route('attendance.report') }}" class="{{set_active(['attendance/report'])}}">Attendance Report</a></li>
                        </ul>
                    </li>
                    <li class="submenu  {{set_active(['admin/communicate/notice_board', 'admin/communicate/send_email'])}}">
                        <a href="#"><i class="fas fa-table"></i>
                            <span> Communicate</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('admin/communicate/notice_board') }}" class="{{set_active(['admin/communicate/notice_board'])}}">Notice Board</a></li>
                            <li><a href="{{ route('admin/communicate/send_email') }}" class="{{set_active(['admin/communicate/send_email'])}}">Send Email</a></li>
                        </ul>
                    </li>
                    <li class="submenu  {{set_active(['admin/holiday/homework'])}}">
                        <a href="#"><i class="nav-icon fas fa-book"></i>
                            <span> Holiday</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('admin/holiday/homework') }}" class="{{set_active(['admin/holiday/homework'])}}">HomeWork</a></li>
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="fas fa-clipboard"></i>
                            <span> Invoices</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="invoices.html">Invoices List</a></li>
                            <li><a href="invoice-grid.html">Invoices Grid</a></li>
                            <li><a href="add-invoice.html">Add Invoices</a></li>
                            <li><a href="edit-invoice.html">Edit Invoices</a></li>
                            <li><a href="view-invoice.html">Invoices Details</a></li>
                            <li><a href="invoices-settings.html">Invoices Settings</a></li>
                        </ul>
                    </li>
                @endif

                @if (Session::get('role_name') === 'Student')
                    <li class="submenu {{set_active(['student/my_subjects','student/timetable','student/exam_timetable'])}}">
                        <a href="#"><i class="fas fa-book-reader"></i>
                            <span>Academics</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('subject.student') }}" class="{{set_active(['student/my_subjects'])}}">My Subjects</a></li>
                            <li><a href="{{ route('student.timetable') }}" class="{{set_active(['student/timetable'])}}">Class Timetable</a></li>
                        </ul>
                    </li>
                    <li class="submenu  {{set_active(['student/exam_timetable', 'student/my_exam_result'])}}">
                        <a href="#"><i class="fas fa-clipboard-list"></i>
                            <span> Examination</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('student.exam_timetable') }}" class="{{set_active(['student/exam_timetable'])}}">Exam Timetable</a></li>
                            <li><a href="{{ route('student.my_exam_result') }}" class="{{set_active(['student/my_exam_result'])}}">Exam Result</a></li>

                        </ul>
                    </li>
                    <li class="submenu  {{set_active(['student/my_calender'])}}">
                        <a href="#"><i class="fas fa-book-reader"></i>
                            <span> My Calender</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('student/my_calender') }}" class="{{set_active(['student/my_calender'])}}">My Calender</a></li>
                        </ul>
                    </li>
                    <li class="submenu  {{set_active(['student/my_attendance'])}}">
                        <a href="#"><i class="fas fa-table"></i>
                            <span>Attendance</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('student/my_attendance') }}" class="{{set_active(['student/my_attendance'])}}">My Attendance</a></li>
                        </ul>
                    </li>
                    <li class="submenu  {{set_active(['student/fees_collection'])}}">
                        <a href="#"><i class="fas fa-comment-dollar"></i>
                            <span>Fees</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('student/fees_collection') }}" class="{{set_active(['student/fees_collection'])}}">Fees Collection</a></li>
                        </ul>
                    </li>

                @elseif (Session::get('role_name') === 'Teacher')
                    <li class="submenu">
                        <a href="#"><i class="fas fa-book-reader"></i>
                            <span>My Class & Subjects</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('teacherClassSubjects') }}">My Class & Subjects</a></li>
                            {{-- <li><a href="{{ route('subject.student') }}">My Subjects</a></li> --}}
                            {{-- <li><a href="{{ route('subject.add') }}">Subject Add</a></li> --}}
                        </ul>
                    </li>
                    <li class="submenu {{set_active(['teacher/my_students'])}}">
                        <a href="#"><i class="fas fa-graduation-cap"></i>
                            <span>My Students</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('teacher/my_students') }}"  class="{{set_active(['student/list'])}}">Student List</a></li>
                        </ul>
                    </li>
                    <li class="submenu  {{set_active(['teacher/my_calender'])}}">
                        <a href="#"><i class="fas fa-book-reader"></i>
                            <span> My Calender</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('teacher/my_calender') }}" class="{{set_active(['teacher/my_calender'])}}">My Calender</a></li>
                        </ul>
                    </li>
                    <li class="submenu {{set_active(['teacher/my_exam_timetable','teacher/marks_register'])}}">
                        <a href="#"><i class="fas fa-graduation-cap"></i>
                            <span>Exams</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('teacher/my_exam_timetable') }}"  class="{{set_active(['teacher/my_exam_timetable'])}}">Exams Timetable</a></li>
                            <li><a href="{{ route('teacher.marks_register') }}" class="{{set_active(['teacher/marks_register'])}}">Marks Register</a></li>
                        </ul>
                    </li>
                    <li class="submenu  {{set_active(['teacher/attendance/students', 'teacher/attendance/report'])}}">
                        <a href="#"><i class="fas fa-table"></i>
                            <span> Attendance</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('teacher.attendanceStudents') }}" class="{{set_active(['teacher/attendance/students'])}}">Students Attendance</a></li>
                            <li><a href="{{ route('teacher.attendanceReport') }}" class="{{set_active(['teacher/attendance/report'])}}">Attendance Report</a></li>
                        </ul>
                    </li>
                @endif

                <li class="menu-title">
                    <span>Management</span>
                </li>
                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                    <li class="submenu {{set_active(['admin/fees_collection'])}}">
                        <a href="#"><i class="fas fa-file-invoice-dollar"></i>
                            <span> Accounts</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li> <a href="{{ route('admin/fees_collection') }}" class="{{set_active(['admin/fees_collection'])}}"><i class="fas fa-comment-dollar"></i>Fees Collection</a></li>
                            <li><a href="expenses.html">Expenses</a></li>
                            <li><a href="salary.html">Salary</a></li>
                            <li><a href="add-fees-collection.html">Add Fees</a></li>
                            <li><a href="add-expenses.html">Add Expenses</a></li>
                            <li><a href="add-salary.html">Add Salary</a></li>
                        </ul>
                    </li>
                @endif
                {{-- <li>
                    <a href="holiday.html"><i class="fas fa-holly-berry"></i> <span>Holiday</span></a>
                </li> --}}
                {{-- <li>
                    <a href="fees.html"><i class="fas fa-comment-dollar"></i> <span>Fees</span></a>
                </li> --}}

                <li>
                    <a href="{{ route('admin/events/list') }}"><i class="fas fa-calendar-day"></i> <span>Events</span></a>
                </li>
                <li>
                    <a href="{{ route('admin/passout/list') }}"><i class="fas fa-holly-berry"></i> <span>Passout Processing</span></a>
                </li>
                <li>
                    <a href=""><i class="fas fa-hospital"></i> <span>Sickbay</span></a>
                </li>
                {{-- <li>
                    <a href="time-table.html"><i class="fas fa-table"></i> <span>Time Table</span></a>
                </li> --}}
                <li>
                    <a href="library.html"><i class="fas fa-book"></i> <span>Library</span></a>
                </li>
                <li>
                    <a href="library.html"><i class="fas fa-home"></i> <span>Domitory</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
