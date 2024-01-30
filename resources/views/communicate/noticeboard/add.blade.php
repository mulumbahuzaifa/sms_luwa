
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
                        <h3 class="page-title">Add New Notice Board</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin/communicate/notice_board') }}">Exams</a></li>
                            <li class="breadcrumb-item active">Add New Notice Board</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin/communicate/notice_board/save') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title"><span>Notice Board Details Add</span></h5>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>Title <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="Notice Board Title" value="{{ old('title') }}">
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>Notice Date <span class="login-danger">*</span></label>
                                            <input type="date" class="form-control @error('notice_date') is-invalid @enderror" name="notice_date" value="{{ old('notice_date') }}">
                                            @error('notice_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>Publish Date <span class="login-danger">*</span></label>
                                            <input type="date" class="form-control @error('publish_date') is-invalid @enderror" name="publish_date" value="{{ old('publish_date') }}">
                                            @error('publish_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms2">
                                            <label style="display: block;">Message To <span class="login-danger">*</span></label>
                                            <label ><input type="checkbox" name="message_to[]" value="Student">Student</label>
                                            <label ><input type="checkbox" name="message_to[]" value="Parent">Parent</label>
                                            <label ><input type="checkbox" name="message_to[]" value="Teacher">Teacher</label>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>Message </label>
                                            <textarea class="summernote form-control" name="message" ></textarea>
                                            {{-- <textarea class="form-control" name="note" id="" cols="30" rows="10" value="{{ old('note') }}" placeholder="Note">{{ old('note') }}</textarea> --}}
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
<script type="text/javascript">
    $(document).ready(function () {
        $('.summernote').summernote({
            height: 200,
            codemirror: {
                theme: 'monkai'
            }
        });
    });
</script>
@endpush
@endsection
