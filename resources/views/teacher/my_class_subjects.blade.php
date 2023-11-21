
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">My Class & Subjucts</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $header_title }}</li>
                    </ul>
                </div>
            </div>
        </div>
        {{-- <form method="GET" action="">
            <div class="student-group-form">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" value="{{ Request::get('class_name') }}" name="class_name" class="form-control" placeholder="Search by Class Name ...">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" value="{{ Request::get('teacher_name') }}" name="teacher_name" class="form-control" placeholder="Search by Teacher Name ...">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <select class="form-control select" name="status" required>
                                <option selected disabled>Select Status</option>
                                <option value="100" {{ Request::get('status') == 100 ? 'selected' : '' }} >Active</option>
                                <option value="1" {{ Request::get('status') == 1 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="date" value="{{ Request::get('date') }}" name="date" class="form-control" placeholder="Search by Date ...">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="search-student-btn">
                            <button type="btn" class="btn btn-primary">Search</button>
                            <a href="{{ route('assign_class_teacher.list') }}" class="btn btn-success">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </form> --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="page-title">My Class & Subjucts</h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="#" class="btn btn-outline-primary me-2"><i
                                            class="fas fa-download"></i> Download</a>
                                    <a href="{{ route('assign_class_teacher.add') }}" class="btn btn-primary"><i
                                            class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>

                        <table
                            class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                            <thead class="student-thread">
                                <tr>
                                    <th>
                                        <div class="form-check check-tables">
                                            <input class="form-check-input" type="checkbox" value="something">
                                        </div>
                                    </th>
                                    <th>#</th>
                                    <th>Class Name</th>
                                    <th>Subject Name</th>
                                    <th>Subject Level</th>
                                    <th>Timetable</th>
                                    <th>Created Date</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getRecord as $key=>$value)
                                <tr>
                                    <td>
                                        <div class="form-check check-tables">
                                            <input class="form-check-input" type="checkbox" value="something">
                                        </div>
                                    </td>
                                    <td>{{ $key++ }}</td>
                                    <td>{{ $value->class_name }}</td>
                                    <td>{{ $value->subject_name }}({{ $value->subject_code }})</td>
                                    <td>{{ $value->subject_level }}</td>
                                    <td>
                                        @php
                                            $ClassSubject = $value->getMyTimetable($value->class_id, $value->subject_id)
                                        @endphp
                                        @if (!empty($ClassSubject))
                                            {{ date('h:i A',  strtotime($ClassSubject->start_time)) }} to {{ date('h:i A',  strtotime($ClassSubject->end_time ))}}
                                            <br/>
                                            Room : {{ $ClassSubject->room_number }}
                                        @endif

                                    </td>

                                    <td>{{ date('d-m-Y H:i A',  strtotime($value->created_at)) }}</td>
                                    <td class="text-end">
                                        <a href="{{ url('teacher/my_class_subjects/class_timetable/'.$value->class_id.'/'.$value->subject_id) }}" class="btn btn-primary"> Timetable </a>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="padding: 10px; float: right;">
                            {!! $getRecord->appends(request()->input())->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@section('script')

@endsection

@endsection
