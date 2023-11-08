
@extends('layouts.master')
@section('content')
@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"
@endpush
{{-- message --}}
{!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Add Department</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('department/list/page') }}">Departments</a></li>
                            <li class="breadcrumb-item active">Add Department</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('department/add/save') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title"><span>Department Details</span></h5>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Department Code <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" placeholder="Enter Department Code" value="{{ old('code') }}">
                                            @error('code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Department Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter Department Name" value="{{ old('name') }}">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Head of Department <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('HOD') is-invalid @enderror" name="HOD" placeholder="Enter Head Of Department" value="{{ old('HOD') }}">
                                            @error('HOD')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms calendar-icon">
                                            <label>Department Start Date <span class="login-danger">*</span></label>
                                            <input type="text" id="datepicker" class="form-control @error('date_created') is-invalid @enderror" name="date_created" placeholder="Select Date" value="{{ old('date_created') }}">
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
                                                <option value="Teaching" {{ old('category') == 'Teaching' ? 'selected' : '' }}>Teaching</option>
                                                <option value="Non-Teaching" {{ old('category') == 'Non-Teaching' ? 'selected' : '' }}>Non-Teaching</option>

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
                                            <textarea class="form-control" name="description" id="" cols="30" rows="10" value="{{ old('description') }}"></textarea>

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


@push('scripts')
{{-- <script>
$(document).ready(function(){
    $('#datepicker').datepicker({
        format: 'dd-mm-yyyy', // Set the desired date format
        autoclose: true, // Close the datepicker when a date is selected
        todayHighlight: true // Highlight today's date
    });
});
</script> --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr('#datepicker', {
        enableTime: false,
        dateFormat: 'd-m-Y',
    })
</script>
@endpush
@endsection
