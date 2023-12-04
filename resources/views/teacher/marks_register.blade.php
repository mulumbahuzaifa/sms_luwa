
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title"> Marks Register</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Marks Register</li>
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
                                    <h3 class="page-title">Search Marks Register</h3>
                                </div>
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
                                                    <option {{ (Request::get('exam_id') == $exam->exam_id) ? 'selected' : '' }} value="{{ $exam->exam_id }}">{{ $exam->exam_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <select name="class_id" class="form-control">
                                                <option value="">Select Class</option>
                                                @foreach ($getClass as $class)
                                                    <option {{ (Request::get('class_id') == $class->class_id) ? 'selected' : '' }} value="{{ $class->class_id }}">{{ $class->class_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="search-student-btn">
                                            <button type="btn" class="btn btn-secondary">Search</button>
                                            <a href="{{ route('exam.marks_register') }}" class="btn btn-success">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        @if (!empty($getSubject) && !empty($getSubject->count()))
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Marks Register</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table
                                    class="table border-0 star-student table-hover table-center mb-0  table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>STUDENT NAME</th>
                                            @foreach ($getSubject as $subject)
                                                <th>
                                                    {{ $subject->subject_name }} <br/>
                                                    ({{ $subject->subject_code }} : {{ $subject->pass_mark }} / {{ $subject->full_marks }})
                                                </th>
                                            @endforeach

                                            <th class="text-end">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($getStudent) && !empty($getStudent->count()))
                                            @foreach ($getStudent as $student)
                                            <form name="post" method="POST" class="submitForm" action="{{ url('teacher/submit_marks_register') }}">
                                                @csrf
                                                <input type="hidden" name="exam_id" value="{{ Request::get('exam_id') }}">
                                                <input type="hidden" name="class_id" value="{{ Request::get('class_id') }}">
                                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                <tr>
                                                    <td>{{ $student->name }} {{ $student->last_name }}</td>
                                                    @php
                                                        $i = 1;
                                                        $totalStudentMark = 0;
                                                        $totalFullMarks = 0;
                                                        $totalPassMark = 0;
                                                        $pass_fail_val = 0;
                                                    @endphp
                                                    @foreach ($getSubject as $subject)
                                                    @php
                                                        $totalMark = 0;
                                                        $totalFullMarks = $totalFullMarks + $subject->full_marks;
                                                        $totalPassMark = $totalPassMark + $subject->pass_mark;
                                                        $getMark = $subject->getMark($student->id, Request::get('exam_id'), Request::get('class_id'), $subject->subject_id);
                                                        if(!empty($getMark)) {
                                                            $totalMark = $getMark->class_work + $getMark->test + $getMark->exam;
                                                        }
                                                        $totalStudentMark = $totalStudentMark + $totalMark;
                                                    @endphp
                                                        <td>
                                                            <div style="margin-bottom: 10px;">
                                                                Class Work
                                                                <input type="hidden" name="mark[{{ $i }}][full_marks]" value="{{ $subject->full_marks }}">
                                                                <input type="hidden" name="mark[{{ $i }}][pass_mark]" value="{{ $subject->pass_mark }}">

                                                                <input type="hidden" name="mark[{{ $i }}][id]" value="{{ $subject->id }}">
                                                                <input type="hidden" name="mark[{{ $i }}][subject_id]" value="{{ $subject->subject_id }}">
                                                                <input type="text" style="width: 200px;" placeholder="Enter Marks" name="mark[{{ $i }}][class_work]" id="class_work_{{ $student->id }}{{ $subject->subject_id }}" value="{{ !empty($getMark) ? $getMark->class_work : '' }}" class="form-control" >
                                                            </div>
                                                            <div style="margin-bottom: 10px;">
                                                                Test
                                                                <input type="text" style="width: 200px;" placeholder="Enter Marks" name="mark[{{ $i }}][test]" id="test_{{ $student->id }}{{ $subject->subject_id }}" value="{{ !empty($getMark) ? $getMark->test : '' }}" class="form-control" >
                                                            </div>
                                                            <div style="margin-bottom: 10px;">
                                                                Exam
                                                                <input type="text" style="width: 200px;" placeholder="Enter Marks" name="mark[{{ $i }}][exam]" id="exam_{{ $student->id }}{{ $subject->subject_id }}" value="{{ !empty($getMark) ? $getMark->exam : '' }}" class="form-control" >
                                                            </div>
                                                            <div style="margin-bottom: 10px;">
                                                                <button type="button" class="btn btn-primary SaveSingleSubject" id="{{ $student->id }}" data-schedule="{{ $subject->id  }}" data-val="{{ $subject->subject_id  }}" data-class="{{ Request::get('class_id') }}" data-exam="{{ Request::get('exam_id') }}">Save</button>
                                                            </div>
                                                            @if (!empty($getMark))
                                                            @php
                                                                $getLoopGrade = App\Models\MarksGradeModel::getGrade($totalMark)
                                                            @endphp
                                                            <div style="margin-bottom: 10px;">
                                                                Total Marks: {{ $totalMark }} <br/>
                                                                Pass Mark : {{ $subject->pass_mark }}
                                                            </div>
                                                            @if (!empty($getLoopGrade))
                                                            <div style="margin-bottom: 10px;">
                                                                <b>Grade : </b>{{ $getLoopGrade }} <br />
                                                            </div>
                                                            @endif
                                                                @if ($totalMark >= $subject->pass_mark)
                                                                    <div style="margin-bottom: 10px;">
                                                                        <b>Result : </b><span style="color:green; font-weight:bold; padding:10px;">Pass</span>
                                                                    </div>
                                                                @else
                                                                    <div style="margin-bottom: 10px; ">
                                                                        <b>Result : </b> <span style="color:red; font-weight:bold; padding:10px;">Fail</span>
                                                                    </div>
                                                                    @php
                                                                        $pass_fail_val = 1;
                                                                    @endphp
                                                                @endif

                                                            @endif

                                                        </td>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                    <td class="text-end">
                                                        <button type="submits" class="btn btn-success">Save</button>
                                                        <br />
                                                        @if(!empty($totalStudentMark))

                                                            <b>Total Marks : </b>{{ $totalStudentMark }} / {{ $totalFullMarks }}
                                                            <br />
                                                            <b>Total Pass Mark : </b>{{ $totalPassMark }}
                                                            <br />
                                                            @php
                                                                $percentage = ($totalStudentMark * 100) / $totalFullMarks;
                                                                $getGrade = App\Models\MarksGradeModel::getGrade($percentage);

                                                            @endphp
                                                            <b>Percentage : </b>{{ round($percentage, 2) }}%
                                                            <br />
                                                            @if (!empty($getGrade))
                                                                <b>Grade : </b>{{ $getGrade }}
                                                                <br />
                                                            @endif
                                                            @if ($pass_fail_val == 1)
                                                                <b>Result : </b><span style="color:red; font-weight:bold; padding:10px;">Fail</span>
                                                            @else
                                                                <b>Result : </b><span style="color:green; font-weight:bold; padding:10px;">Pass</span>
                                                            @endif
                                                        @endif


                                                    </td>
                                                </tr>
                                            </form>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                {{-- <div style="text-align: center; padding: 20px;">
                                    <button class="btn btn-primary">Submit</button>
                                </div> --}}
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
        $('.submitForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var type = form.attr('method');
            var data = form.serialize();
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

        $('.SaveSingleSubject').on('click', function(e) {
            e.preventDefault();
            var form = $(this);
            var student_id = form.attr('id');
            var subject_id = form.attr('data-val');
            var exam_id = form.attr('data-exam');
            var class_id = form.attr('data-class');
            var id = form.attr('data-schedule');

            var class_work = $('#class_work_'+student_id+subject_id).val();
            var test= $('#test_'+student_id+subject_id).val();
            var exam = $('#exam_'+student_id+subject_id).val();
            var url = "{{ url('teacher/single_submit_marks_register') }}";
            var type = 'POST';
            var data = {
                id: id,
                student_id: student_id,
                subject_id: subject_id,
                exam_id: exam_id,
                class_id: class_id,
                class_work: class_work,
                test: test,
                exam: exam,
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
