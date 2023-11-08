
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Add Class</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('class.list') }}">Classes</a></li>
                            <li class="breadcrumb-item active">Add Class</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('class.save') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title"><span>Class Details</span></h5>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Class Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter Class Name" value="{{ old('name') }}">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Class Code <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('class_code') is-invalid @enderror" name="class_code" placeholder="Enter Class Code" value="{{ old('class_code') }}">
                                            @error('class_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Level <span class="login-danger">*</span></label>
                                            <select class="form-control select  @error('level') is-invalid @enderror" name="level">
                                                <option selected disabled>Select level</option>
                                                <option value="O-Level" {{ old('level') == 'O-Level' ? "selected" :""}}>O-Level</option>
                                                <option value="A-Level" {{ old('level') == 'A-Level' ? "selected" :""}}>A-Level</option>
                                            </select>
                                            @error('level')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Class Teacher <span class="login-danger">*</span></label>
                                            <select class="form-control @error('class_teacher_id') is-invalid @enderror" name="class_teacher_id">
                                                <option value="" disabled>Select Class-Teacher</option>
                                                @foreach ($teachers as $teacher)
                                                    <option value="{{ $teacher->id }}" {{ old('class_teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->first_name  }} {{ $teacher->last_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('class_teacher_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Year <span class="login-danger">*</span></label>
                                            <input class="form-control @error('year') is-invalid @enderror" type="text" name="year" placeholder="Enter class year" value="{{ old('year') }}">
                                            @error('year')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary">Submit</button>
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


@endsection
