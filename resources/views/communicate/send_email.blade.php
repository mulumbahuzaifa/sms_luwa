
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
                        <h3 class="page-title">Send Email</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Send Email</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin/communicate/send_email/save') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    {{-- <div class="col-12">
                                        <h5 class="form-title"><span>Notice Board Details Add</span></h5>
                                    </div> --}}
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>Subject <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" placeholder="Add Subject" value="{{ old('subject') }}">
                                            @error('subject')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>Users (Parents/Students/Teachers)</label>
                                            <select name="user_id" class="form-control select2" style="width: 100%;">
                                                <option value="">Select</option>
                                            </select>
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
                                            <textarea id="summernote" class="form-control" name="message"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary">Send Email</button>
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
        //Initialize Select2 Elements
        $('.select2').select2({
            ajax: {
                url: "{{ route('admin/communicate/send_email/get_users') }}",
                dataType: 'json',
                delay: 250,
                data: function (data) {
                    return {
                        search: data.term, // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
            }
        });

        $('#summernote').summernote({
            height: 200,
            codemirror: {
                theme: 'monkai'
            }
        });
    });
</script>
@endpush
@endsection
