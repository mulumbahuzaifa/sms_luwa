
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">My Exam Results</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('student/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Exam Results</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($getRecord as $value)

            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="page-title">{{ $value['exam_name'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table
                                class="table border-0 star-student table-hover table-center mb-0  table-striped">
                                <thead class="student-thread">
                                    <tr>
                                        {{-- <th>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </th> --}}
                                        <th>Subjects</th>
                                        <th>Class Work</th>
                                        <th>Test</th>
                                        <th>Exam</th>
                                        <th>Total Score</th>
                                        <th>Pass Marks</th>
                                        <th>Full Marks</th>
                                        <th>Results</th>
                                        {{-- <th class="text-end">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total = 0;
                                        $full_marks = 0;
                                        $result_validation = 0;
                                    @endphp
                                    @foreach ($value['subject'] as $exam)
                                        @php
                                            $total += $exam['total_score'];
                                            $full_marks += $exam['full_marks'];
                                        @endphp
                                        <tr>
                                            {{-- <th>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </th> --}}
                                            <td style="width: 250px">{{ $exam['subject_name'] }}</td>
                                            <td>{{ $exam['class_work'] }}</td>
                                            <td>{{ $exam['test'] }}</td>
                                            <td>{{ $exam['exam'] }}</td>
                                            <td>{{ $exam['total_score'] }}</td>
                                            <td>{{ $exam['full_marks'] }}</td>
                                            <td>{{ $exam['pass_mark'] }}</td>
                                            <td>
                                                @if ($exam['total_score'] >= $exam['pass_mark'])
                                                    <span class="badge bg-success" style="padding: 10px; font-weight:bold;">Pass</span>
                                                @else
                                                @php
                                                    $result_validation = 1;
                                                @endphp
                                                    <span class="badge bg-danger" style="padding: 10px; font-weight:bold;">Fail</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        @php
                                            $percentage = ($total * 100) / $full_marks;
                                            $getGrade = App\Models\MarksGradeModel::getGrade($percentage);

                                        @endphp
                                        <td colspan="2">
                                            <b>Grand Total : {{ $total }}/{{ $full_marks }}</b>
                                        </td>
                                        <td colspan="2">
                                            <b>Percentage : {{ round($percentage, 2) }}%</b>
                                        </td>
                                        <td colspan="2">
                                            <b>Grade : {{ $getGrade }}</b>
                                        </td>
                                        <td colspan="3">
                                            <b>Result : @if ($result_validation == 0)
                                                <span class="badge bg-success" style="padding: 10px;">Pass</span>
                                                @else
                                                <span class="badge bg-danger" style="padding: 10px; ">Fail</span>
                                                @endif
                                            </b>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

@section('script')

@endsection

@endsection
