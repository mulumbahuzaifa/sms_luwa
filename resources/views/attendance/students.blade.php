
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title"> Students Attendance</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Students Attendance</li>
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
                                    <h3 class="page-title">Search Students Attendance</h3>
                                </div>
                            </div>
                        </div>
                        <form method="GET" action="">
                            <div class="student-group-form">
                                <div class="row">

                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <select name="class_id" id="getClass" class="form-control" required>
                                                <option value="">Select Class</option>
                                                @foreach ($getClass as $class)
                                                    <option {{ (Request::get('class_id') == $class->id) ? 'selected' : '' }} value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <input type="date" class="form-control" id="getAttendanceDate" name="attendance_date" required value="{{ Request::get('attendance_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="search-student-btn">
                                            <button type="btn" class="btn btn-outline-primary">Search</button>
                                            <a href="{{ route('attendance.students') }}" class="btn btn-danger">Reset</a>

                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-2">
                                        <div class="search-student-btn">
                                            <button type="btn" class="btn btn-secondary">Search</button>
                                            <a href="{{ route('attendance.students') }}" class="btn btn-success">Reset</a>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        @if(!empty(Request::get('class_id')) && !empty(Request::get('attendance_date')))
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Students List</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table
                                class="table border-0 star-student table-hover table-center mb-0  table-striped">
                                <thead class="student-thread">
                                    <tr>
                                        <th>STUDENT ID</th>
                                        <th>STUDENT NAME</th>
                                        <th class="text-end">ATTENDANCE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($getStudent) && !empty($getStudent->count()))
                                        @foreach ($getStudent as $student)
                                        @php
                                            $attendance_type = '';
                                            $getAttendance = $student->getAttendance($student->id, Request::get('class_id'), Request::get('attendance_date'));
                                            if (!empty($getAttendance->attendance_type)) {
                                                $attendance_type = $getAttendance->attendance_type;
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $student->id }}</td>
                                            <td>{{ $student->name }} {{ $student->last_name }}</td>
                                            <td class="text-end">
                                                <label style="margin-left: 10px;">
                                                    <input value="1" type="radio" id="{{ $student->id }}" {{ ($attendance_type == '1') ? 'checked' : '' }} class="SaveAttendance" name="attendace{{ $student->id }}"> Present</label>
                                                <label style="margin-left: 10px;">
                                                    <input value="2" type="radio" id="{{ $student->id }}" {{ ($attendance_type == '2') ? 'checked' : '' }} class="SaveAttendance" name="attendace{{ $student->id }}"> Late</label>
                                                <label style="margin-left: 10px;">
                                                    <input value="3" type="radio" id="{{ $student->id }}" {{ ($attendance_type == '3') ? 'checked' : '' }} class="SaveAttendance" name="attendace{{ $student->id }}"> Absent</label>
                                                {{-- <label style="margin-left: 10px;">
                                                    <input value="4" type="radio" id="{{ $student->id }}" class="SaveAttendance" name="attendace{{ $student->id }}"> Half Day</label> --}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

</div>

@section('script')
<script>
$(document).ready(function() {
        $('.SaveAttendance').on('change', function(e) {
            e.preventDefault();
            var form = $(this);
            var student_id = form.attr('id');
            var attendance_type = form.val();
            var class_id = $('#getClass').val();
            var attendance_date = $('#getAttendanceDate').val();

            var url = "{{ url('attendance/students/save') }}";
            var type = 'POST';
            var data = {
                student_id: student_id,
                attendance_type: attendance_type,
                class_id: class_id,
                attendance_date: attendance_date,
                "_token": '{{ csrf_token() }}'
            };
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(data) {
                    if(data.status == 'success') {
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        });
    });
</script>
@endsection

@endsection
