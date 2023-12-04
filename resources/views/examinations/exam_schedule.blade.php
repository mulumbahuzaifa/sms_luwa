
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title"> Examinations Schedule</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Examinations Schedule</li>
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
                                    <h3 class="page-title">Search Examinations Schedule</h3>
                                </div>
                                {{-- <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="#" class="btn btn-outline-primary me-2"><i
                                            class="fas fa-download"></i> Download</a>
                                    <a href="{{ route('exam.add') }}" class="btn btn-primary"><i
                                            class="fas fa-plus"></i></a>
                                </div> --}}
                            </div>
                        </div>
                        <form method="GET" action="">
                            <div class="student-group-form">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <select name="exam_id" class="form-control">
                                                <option value="">Select Exam</option>
                                                @foreach ($getExam as $exam)
                                                    <option {{ (Request::get('exam_id') == $exam->id) ? 'selected' : '' }} value="{{ $exam->id }}">{{ $exam->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <select name="class_id" class="form-control">
                                                <option value="">Select Class</option>
                                                @foreach ($getClass as $class)
                                                    <option {{ (Request::get('class_id') == $class->id) ? 'selected' : '' }} value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="search-student-btn">
                                            <button type="btn" class="btn btn-secondary">Search</button>
                                            <a href="{{ route('exam.schedule') }}" class="btn btn-success">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        @if (!empty($getRecord))
        <form action="{{ url('examination/schedule/save') }}" method="POST">
            @csrf
            <input type="text" hidden name="exam_id" value="{{ Request::get('exam_id') }}"></input>
            <input type="text" hidden name="class_id" value="{{ Request::get('class_id') }}"></input>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">

                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Examinations Schedule</h3>
                                    </div>

                                </div>
                            </div>
                            <div class="table-responsive">
                                <table
                                    class="table border-0 star-student table-hover table-center mb-0  table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>#</th>
                                            <th>Subject Name</th>
                                            <th>Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Room Number</th>
                                            <th>Full Marks</th>
                                            <th class="text-end">Pass Marks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                            $j = 1;
                                        @endphp
                                        @foreach ($getRecord as $record)
                                        <tr>
                                            <td>{{ $j++ }}</td>
                                            <td>
                                                {{ $record['subject_name'] }}
                                                <input type="hidden" name="schedule[{{ $i }}][subject_id]" value="{{ $record['subject_id'] }}"></input>

                                            </td>
                                            <td>
                                                <input type="date" class="form-control" name="schedule[{{ $i }}][exam_date]" value="{{ $record['exam_date'] }}">
                                            </td>
                                            <td>
                                                <input type="time" class="form-control" name="schedule[{{ $i }}][start_time]" value="{{ $record['start_time'] }}">
                                            </td>
                                            <td>
                                                <input type="time" class="form-control" name="schedule[{{ $i }}][end_time]" value="{{ $record['end_time'] }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="schedule[{{ $i }}][room_number]" value="{{ $record['room_number'] }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="schedule[{{ $i }}][full_marks]" value="{{ $record['full_marks'] }}">
                                            </td>
                                            <td class="text-end">
                                                <input type="text" class="form-control" name="schedule[{{ $i }}][pass_mark]" value="{{ $record['pass_mark'] }}">
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                                <div style="text-align: center; padding: 20px;">
                                    <button class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endif

    </div>

</div>

@section('script')

@endsection

@endsection
