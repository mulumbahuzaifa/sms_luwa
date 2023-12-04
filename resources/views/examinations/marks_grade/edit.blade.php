
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
                        <h3 class="page-title">Edit Marks Grade</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('exam.list') }}">Exams</a></li>
                            <li class="breadcrumb-item active">Edit Marks Grade</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('marksGrade.update', $getRecord->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title"><span>Edit Marks Grade Details </span></h5>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>Grade Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter Grade Name" value="{{ old('name', $getRecord->name) }}">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>Percent From<span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('percent_from') is-invalid @enderror" name="percent_from" placeholder="Enter Percent From" value="{{ old('percent_from', $getRecord->percent_from) }}">
                                            @error('percent_from')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>Percent To <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('percent_to') is-invalid @enderror" name="percent_to" placeholder="Enter Percent To" value="{{ old('percent_to', $getRecord->percent_to) }}">
                                            @error('percent_to')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary">Update</button>
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
