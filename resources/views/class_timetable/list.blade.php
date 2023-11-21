
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Class Timetables List</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Class Timetables</li>
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
                                    <h3 class="page-title">Search Class Timetable</h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    {{-- <a href="#" class="btn btn-outline-primary me-2"><i
                                            class="fas fa-download"></i> Download</a> --}}
                                    {{-- <a href="{{ route('class_timetable.add') }}" class="btn btn-primary"><i
                                            class="fas fa-plus"></i></a> --}}
                                </div>
                            </div>
                        </div>

                        <form method="GET" action="">
                            <div class="student-group-form">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                            <select name="class_id" class="form-control getClass" required>
                                                <option value="">Select</option>
                                                @foreach ($getClass as $class)
                                                    <option {{ (Request::get('class_id') == $class->id) ? 'selected' : '' }} value="{{  $class->id }}">{{  $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                            <select name="subject_id" class="form-control getSubject" required>
                                                <option value="">Select</option>
                                                @if (!empty($getSubject))
                                                    @foreach ($getSubject as $subject)
                                                        <option {{ (Request::get('subject_id') == $subject->subject_id) ? 'selected' : '' }} value="{{  $subject->subject_id }}">{{  $subject->subject_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="search-student-btn">
                                            <button type="btn" class="btn btn-primary">Search</button>
                                            <a href="{{ route('class_timetable.list') }}" class="btn btn-success">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>



                    </div>
                </div>
            </div>
        </div>
        @if (!empty(Request::get('class_id')) && !empty(Request::get('subject_id')))
        <form action="{{ url('admin/class_timetable/add') }}" method="POST">
            @csrf
            <input type="text" hidden name="subject_id" value="{{ Request::get('subject_id') }}"></input>
            <input type="text" hidden name="class_id" value="{{ Request::get('class_id') }}"></input>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Class Timetable</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="add-time-table.html" class="btn btn-primary">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table
                                    class="table border-0 star-student table-hover table-center mb-0  table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>Week</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Room</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($week as $list )
                                        <tr>
                                            <td>
                                                 <input type="hidden"  name="timetable[{{ $i }}][week_id]" value="{{ $list['week_id'] }}"></input>
                                                {{ $list['week_name'] }}
                                            </td>
                                            <td>
                                                <input type="time" name="timetable[{{ $i }}][start_time]" value="{{ $list['start_time']  }}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="time" name="timetable[{{ $i }}][end_time]" value="{{ $list['end_time']  }}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" style="width: 200px;" name="timetable[{{ $i }}][room_number]" value="{{ $list['room_number']  }}" class="form-control">
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
    <script>
        $('.getClass').change(function(){
            var class_id = $(this).val();
            $.ajax({
                url: "{{ url('admin/class_timetable/get_subject') }}",
                type: "POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    class_id:class_id,
                },
                dataType: "json",
                success: function(response){
                    $('.getSubject').html(response.html);
                },
            });
        });
    </script>

@endsection

@endsection
