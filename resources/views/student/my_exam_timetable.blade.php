
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Exam Timetable</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">My Exam Timetable</li>
                    </ul>
                </div>
            </div>
        </div>
        @foreach ($getRecord as $value)
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">{{ $value['name'] }}</h3>
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
                                            <th>Day</th>
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
                                        @foreach ($value['exam'] as $valueW)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $valueW['subject_name'] }}</td>
                                                <td>{{ date('l', strtotime($valueW['exam_date']))  }}</td>
                                                <td>{{ date('d-m-Y', strtotime($valueW['exam_date']))  }}</td>
                                                <td>{{ !empty($valueW['start_time']) ? date('h:i A', strtotime($valueW['start_time'])) : '' }}</td>
                                                <td>{{ !empty($valueW['end_time']) ? date('h:i A', strtotime($valueW['end_time'])) : '' }}</td>
                                                <td>{{ $valueW['room_number'] }}</td>
                                                <td>{{ $valueW['full_marks'] }}</td>
                                                <td class="text-end">{{ $valueW['pass_mark'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

</div>


@endsection
