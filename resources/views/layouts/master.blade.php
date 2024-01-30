<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>E-SHULE SCHOOL MANAGEMENT SYSTEM</title>
    <link rel="shortcut icon" href="{{ URL::to('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/icons/flags/flags.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/css/bootstrap-datetimepicker.min.cs') }}s">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/simple-calendar/simple-calendar.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/datatables/datatables.min.css') }}">
    <!-- daterange picker -->
  <link rel="stylesheet" href="{{ URL::to('assets/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ URL::to('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ URL::to('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ URL::to('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- Select2 -->
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/bs-stepper/css/bs-stepper.min.css') }}">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{ URL::to('assets/plugins/dropzone/min/dropzone.min.css') }}">
    <!-- summernote -->
  <link rel="stylesheet" href="{{ URL::to('assets/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::to('assets/css/style.css') }}">
    {{-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet"> --}}
	{{-- message toastr --}}
    <link rel="stylesheet" href="{{ URL::to('assets/dist/css/adminlte.min.css') }}">

	<link rel="stylesheet" href="{{ URL::to('assets/css/toastr.min.css') }}">
	<script src="{{ URL::to('assets/js/toastr_jquery.min.js') }}"></script>
	<script src="{{ URL::to('assets/js/toastr.min.js') }}"></script>
    @yield('styles')

</head>
<body>
    <div class="main-wrapper">
        <div class="header">
            <div class="header-left">
                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ URL::to('assets/img/logo.png') }}" alt="Logo">
                </a>
                <a href="{{ route('home') }}" class="logo logo-small">
                    <img src="{{ URL::to('assets/img/logo-small.png') }}" alt="Logo" width="30" height="30">
                </a>
                @elseif (Session::get('role_name') === 'Teacher')
                <a href="{{ route('teacher/dashboard') }}" class="logo">
                    <img src="{{ URL::to('assets/img/logo.png') }}" alt="Logo">
                </a>
                <a href="{{ route('teacher/dashboard') }}" class="logo logo-small">
                    <img src="{{ URL::to('assets/img/logo-small.png') }}" alt="Logo" width="30" height="30">
                </a>
                @elseif (Session::get('role_name') === 'Student')
                <a href="{{ route('student/dashboard') }}" class="logo">
                    <img src="{{ URL::to('assets/img/logo.png') }}" alt="Logo">
                </a>
                <a href="{{ route('student/dashboard') }}" class="logo logo-small">
                    <img src="{{ URL::to('assets/img/logo-small.png') }}" alt="Logo" width="30" height="30">
                </a>
                @elseif (Session::get('role_name') === 'Parent')
                <a href="{{ route('parent/dashboard') }}" class="logo">
                    <img src="{{ URL::to('assets/img/logo.png') }}" alt="Logo">
                </a>
                <a href="{{ route('parent/dashboard') }}" class="logo logo-small">
                    <img src="{{ URL::to('assets/img/logo-small.png') }}" alt="Logo" width="30" height="30">
                </a>
                @endif
            </div>
            <div class="menu-toggle">
                <a href="javascript:void(0);" id="toggle_btn">
                    <i class="fas fa-bars"></i>
                </a>
            </div>

            <div class="top-nav-search">
                <form>
                    <input type="text" class="form-control" placeholder="Search here">
                    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <a class="mobile_btn" id="mobile_btn">
                <i class="fas fa-bars"></i>
            </a>
            <ul class="nav user-menu">
                {{-- <li class="nav-item dropdown noti-dropdown language-drop me-2">
                    <a href="#" class="dropdown-toggle nav-link header-nav-list" data-bs-toggle="dropdown">
                        <img src="assets/img/icons/header-icon-01.svg" alt="">
                    </a>
                    <div class="dropdown-menu ">
                        <div class="noti-content">
                            <div>
                                <a class="dropdown-item" href="javascript:;"><i class="flag flag-lr me-2"></i>English</a>
                                <a class="dropdown-item" href="javascript:;"><i class="flag flag-kh me-2"></i>Khmer</a>
                            </div>
                        </div>
                    </div>
                </li> --}}

                <li class="nav-item dropdown noti-dropdown me-2">
                    <a href="#" class="dropdown-toggle nav-link header-nav-list" data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/img/icons/header-icon-05.svg') }}" alt="">
                    </a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Notifications</span>
                            <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="#">
                                        <div class="media d-flex">
                                            <span class="avatar avatar-sm flex-shrink-0">
                                                {{-- @if (!empty(Auth::user()->avatar)) --}}
                                                <img class="avatar-img rounded-circle" alt="User Image"
                                                    src="{{ URL::to('assets/img/profiles/avatar-02.jpg') }}">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Carlson Tech</span> has
                                                    approved <span class="noti-title">your estimate</span></p>
                                                <p class="noti-time"><span class="notification-time">4 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="#">
                                        <div class="media d-flex">
                                            <span class="avatar avatar-sm flex-shrink-0">
                                                <img class="avatar-img rounded-circle" alt="User Image" src="{{ URL::to('assets/img/profiles/avatar-11.jpg') }}">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">International Software Inc</span> has sent you a invoice in the amount of <span class="noti-title">$218</span></p>
                                                <p class="noti-time"><span class="notification-time">6 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="#">
                                        <div class="media d-flex">
                                            <span class="avatar avatar-sm flex-shrink-0">
                                                <img class="avatar-img rounded-circle" alt="User Image" src="{{ URL::to('assets/img/profiles/avatar-17.jpg') }}">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">John Hendry</span> sent a cancellation request <span class="noti-title">Apple iPhone XR</span></p>
                                                <p class="noti-time"><span class="notification-time">8 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="#">
                                        <div class="media d-flex">
                                            <span class="avatar avatar-sm flex-shrink-0">
                                                <img class="avatar-img rounded-circle" alt="User Image" src="{{ URL::to('assets/img/profiles/avatar-13.jpg') }}">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Mercury Software Inc</span> added a new product <span class="noti-title">Apple MacBook Pro</span></p>
                                                <p class="noti-time"><span class="notification-time">12 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="{{ url('chat') }}">View all Notifications</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item zoom-screen me-2">
                    <a href="#" class="nav-link header-nav-list win-maximize">
                        <img src="{{ asset('assets/img/icons/header-icon-04.svg') }}" alt="">
                    </a>
                </li>

                <li class="nav-item dropdown has-arrow new-user-menus">
                    <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <span class="user-img">
                            @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                            <img class="rounded-circle" src="{{ !empty(Session::get('avatar')) ? Storage::url('admin-photos/'.Session::get('avatar')) : URL::to('images/photo_defaults.jpg') }}" width="31"alt="{{ Session::get('name') }}">
                            @elseif (Session::get('role_name') === 'Teacher')
                            <img class="rounded-circle" src="{{ !empty(Session::get('avatar')) ? Storage::url('teacher-photos/'.Session::get('avatar')) : URL::to('images/photo_defaults.jpg') }}" width="31"alt="{{ Session::get('name') }}">
                            @elseif (Session::get('role_name') === 'Student')

                            <img class="rounded-circle" src="{{ !empty(Session::get('avatar')) ? Storage::url('student-photos/'.Session::get('avatar')) : URL::to('images/photo_defaults.jpg') }}" width="31"alt="{{ Session::get('name') }}">
                            @elseif (Session::get('role_name') === 'Parent')

                            <img class="rounded-circle" src="{{ !empty(Session::get('avatar')) ? Storage::url('parent-photos/'.Session::get('avatar')) : URL::to('images/photo_defaults.jpg') }}" width="31"alt="{{ Session::get('name') }}">
                            @endif
                            <div class="user-text">
                                <h6>{{ Session::get('name') }}</h6>
                                <p class="text-muted mb-0">{{ Session::get('role_name') }}</p>
                            </div>
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="user-header">
                            <div class="avatar avatar-sm">
                                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                                <img src="{{ URL::to('images/photo_defaults.jpg') }}" alt="{{ Session::get('name') }}" class="avatar-img rounded-circle">
                                @elseif (Session::get('role_name') === 'Teacher')
                                <img src="{{ Storage::url('teacher-photos/'.Session::get('avatar')) }}" alt="{{ Session::get('name') }}" class="avatar-img rounded-circle">
                                @elseif (Session::get('role_name') === 'Student')
                                <img src="{{ Storage::url('student-photos/'.Session::get('avatar')) }}" alt="{{ Session::get('name') }}" class="avatar-img rounded-circle">
                                @elseif (Session::get('role_name') === 'Parent')
                                <img src="{{ Storage::url('parent-photos/'.Session::get('avatar')) }}" alt="{{ Session::get('name') }}" class="avatar-img rounded-circle">
                                @endif

                            </div>
                            <div class="user-text">
                                <h6>{{ Session::get('name') }}</h6>
                                <p class="text-muted mb-0">{{ Session::get('role_name') }}</p>
                            </div>
                        </div>
                        @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                        <a class="dropdown-item" href="{{ route('user/profile/page') }}">My Profile</a>
                        @elseif (Session::get('role_name') === 'Teacher')
                        <a class="dropdown-item" href="{{ route('teacher/profile/page') }}">My Profile</a>
                        @elseif (Session::get('role_name') === 'Student')
                        <a class="dropdown-item" href="{{ route('student/profile/page') }}">My Profile</a>
                        @elseif (Session::get('role_name') === 'Parent')
                        <a class="dropdown-item" href="{{ route('parent/profile/page') }}">My Profile</a>
                        @endif
                        <a class="dropdown-item" href="inbox.html">Inbox</a>
                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
		{{-- side bar --}}
		@include('sidebar.sidebar')
		{{-- content page --}}
        @yield('content')
        <footer>
            <p>Copyright © 2023 Luwa Technologies</p>
        </footer>

    </div>

    <script src="{{ URL::to('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="{{ URL::to('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/feather.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/apexchart/chart-data.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/simple-calendar/jquery.simple-calendar.js') }}"></script>
    <script src="{{ URL::to('assets/js/calander.js') }}"></script>
    <script src="{{ URL::to('assets/js/circle-progress.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/select2/js/select2.min.js') }}"></script>

    <script src="{{ URL::to('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ URL::to('assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ URL::to('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ URL::to('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ URL::to('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ URL::to('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Bootstrap Switch -->
    <script src="{{ URL::to('assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <!-- BS-Stepper -->
    <script src="{{ URL::to('assets/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
    <!-- dropzonejs -->
    <script src="{{ URL::to('assets/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <!-- AdminLTE App -->

    <script src="{{ URL::to('assets/dist/js/adminlte.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ URL::to('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>

    <script src="{{ URL::to('assets/js/script.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script> --}}

    @yield('script')
    @stack('scripts')
</body>
</html>
