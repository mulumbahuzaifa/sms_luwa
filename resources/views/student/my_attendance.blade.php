
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">My Attendance </h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('student/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Student Attendance </li>
                    </ul>
                </div>
            </div>
        </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Search Attendance Report</h3>
                                    </div>
                                </div>
                            </div>
                            <form method="GET" action="">
                                <div class="student-group-form">
                                    <div class="row">

                                        <div class="col-lg-2 col-md-3">
                                            <div class="form-group">
                                                <select name="class_id" class="form-control" >
                                                    <option value="">Select Class</option>
                                                    @foreach ($getClass as $class)
                                                        <option {{ (Request::get('class_id') == $class->class_id) ? 'selected' : '' }} value="{{ $class->class_id }}">{{ $class->class_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-3">
                                            <div class="form-group">
                                                <input type="date" class="form-control" name="attendance_date"  value="{{ Request::get('attendance_date') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-3">
                                            <div class="form-group">
                                                <select name="attendance_type" class="form-control" >
                                                    <option value="">Select Attendance</option>
                                                        <option {{ (Request::get('attendance_type') == 1) ? 'selected' : '' }} value="1">Present</option>
                                                        <option {{ (Request::get('attendance_type') == 2) ? 'selected' : '' }} value="2">Late</option>
                                                        <option {{ (Request::get('attendance_type') == 3) ? 'selected' : '' }} value="3">Absent</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="search-student-btn">
                                                <button type="btn" class="btn btn-secondary">Search</button>
                                                <a href="{{ route('student/my_attendance') }}" class="btn btn-success">Reset</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">My Attendance</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table
                                class="table border-0 star-student table-hover table-center mb-0  table-striped">
                                <thead class="student-thread">
                                    <tr>
                                        <th>Class NAME</th>
                                        <th>Attendance</th>
                                        <th>Attendance Date</th>
                                        <th class="text-end">Created date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($getRecord as $value )
                                    <tr>
                                        <td>{{ $value->class_name }}</td>
                                        <td>
                                            @if ($value->attendance_type == 1)
                                                Present
                                            @elseif ($value->attendance_type == 2)
                                                Late
                                            @elseif ($value->attendance_type == 3)
                                                Absent
                                            @endif
                                        </td>
                                        <td>{{ date('d-m-Y ',  strtotime($value->attendance_date)) }}</td>
                                        <td class="text-end">{{ date('d-m-Y H:i A',  strtotime($value->created_at)) }}</td>
                                    </tr>

                                    @empty
                                        <tr>
                                            <td colspan="100%"><b>Record Not Found</b></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div>
                                {!! $getRecord->links()!!}
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

</div>

@section('script')
<script>

</script>
@endsection

@endsection
