
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
                        <h3 class="page-title">Assign Suject add</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('assign_subject.list') }}">Subjects</a></li>
                            <li class="breadcrumb-item active">Assign Suject add</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('assign_subject.save') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title"><span>Assign Suject To Class</span></h5>
                                    </div>

                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>Class Name<span class="login-danger">*</span></label>
                                            <select class="form-control select  @error('class_id') is-invalid @enderror" name="class_id" required>
                                                <option selected disabled>Select Class</option>
                                                @foreach ($getClass as $class)
                                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('class_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <p> Select Subjects <span class="login-danger">*</span></p>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group ">
                                                @foreach ($getSubject as $subject)
                                                {{-- <div class="form-check">
                                                    <label style="font-weight: normal">
                                                        <input type="checkbox"  name="subject_id[]"  value="{{ $subject->id }}">{{ $subject->name }}
                                                    </label>
                                                </div> --}}
                                                <div class="form-check" >
                                                    <label class="form-check-label" for="subject{{ $subject->id }}">
                                                        <input class="form-check-input" type="checkbox" name="subject_id[]" value="{{ $subject->id }}" id="subject{{ $subject->id }}">
                                                        {{ $subject->name }}({{ $subject->code }})
                                                    </label>
                                                </div>
                                                @endforeach
                                            @error('subject_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>Status<span class="login-danger">*</span></label>
                                            <select class="form-control select  @error('status') is-invalid @enderror" name="status" required>
                                                <option selected disabled>Select Status</option>
                                                <option value="0" {{ old('status') == 0 ? 'selected' : '' }} >Active</option>
                                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            @error('status')
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
