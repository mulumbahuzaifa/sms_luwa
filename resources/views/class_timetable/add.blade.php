
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Add Class Timetable</h3>
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
                                    <a href="{{ route('class_timetable.add') }}" class="btn btn-primary"><i
                                            class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>

                        <form method="GET" action="">
                            <div class="student-group-form">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                            <input type="text" value="{{ Request::get('class_name') }}" name="class_name" class="form-control" placeholder="Search by Class Name ...">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                            <input type="text" value="{{ Request::get('subject_name') }}" name="subject_name" class="form-control" placeholder="Search by Subject Name ...">
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
    </div>

</div>

@section('script')

@endsection

@endsection
