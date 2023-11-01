
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Edit Department</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="departments.html">Department</a></li>
                            <li class="breadcrumb-item active">Edit Department</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('department/update' , $departmentEdit->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                {{-- @method('PUT') --}}
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title"><span>Department Details</span></h5>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Department Code <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" placeholder="Department Code" value="{{ $departmentEdit->code }}">
                                            @error('code')
                                                <div class="alert alert-danger mt-1 mb-1" >
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Department Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Department Name" value="{{ $departmentEdit->name }}">
                                            @error('name')
                                                <div class="alert alert-danger mt-1 mb-1">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Head of Department <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('HOD') is-invalid @enderror" name="HOD" placeholder="Head Of Department" value="{{ $departmentEdit->HOD }}">
                                            @error('HOD')
                                                <div class="alert alert-danger mt-1 mb-1">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms calendar-icon">
                                            <label>Department Start Date <span class="login-danger">*</span></label>
                                                <input type="text" id="datepicker" class="form-control datetimepicker" @error('date_created') is-invalid @enderror" name="date_created" placeholder="DD-MM-YYYY" value="{{ $departmentEdit->date_created }}">
                                                @error('date_created')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Category <span class="login-danger">*</span></label>
                                            {{-- <input type="text" class="form-control" name="no_of_students"> --}}
                                            <select class="form-control @error('category') is-invalid @enderror" name="category">
                                                <option value="">Select Category</option>
                                                <option value="Teaching" {{ $departmentEdit->category == 'Teaching' ? 'selected' : '' }}>Teaching</option>
                                                <option value="Non-Teaching" {{ $departmentEdit->category == 'Non-Teaching' ? 'selected' : '' }}>Non-Teaching</option>

                                            </select>
                                            @error('category')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms calendar-icon">
                                            <label>Department Description </label>
                                            <textarea class="form-control" name="description" id="" cols="30" rows="10" value="{{ $departmentEdit->description }}"></textarea>

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
