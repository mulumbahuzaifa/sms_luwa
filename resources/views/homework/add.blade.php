
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
                        <h3 class="page-title">Add New Homework</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin/holiday/homework') }}">Homework</a></li>
                            <li class="breadcrumb-item active">Add New Homework</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin/holiday/homework/save') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    {{-- <div class="col-12">
                                        <h5 class="form-title"><span>Notice Board Details Add</span></h5>
                                    </div> --}}
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>Class <span class="login-danger">*</span></label>
                                            <select class="form-control" id="getClass" name="class_id" required>
                                                <option value="">Select Class</option>
                                                @foreach ($getClass as $class)
                                                    <option {{ (Request::get('class_id') == $class->id) ? 'selected' : '' }} value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>Subject <span class="login-danger">*</span></label>
                                            <select class="form-control" name="subject_id" required id="getSubject">
                                                <option value="">Select Subject</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>HomeWork Date <span class="login-danger">*</span></label>
                                            <input type="date" class="form-control" name="homework_date" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>Submission Date <span class="login-danger">*</span></label>
                                            <input type="date" class="form-control" name="submission_date" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>Document</label>
                                            <input type="file" class="form-control" name="document_file">
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>Description <span class="login-danger">*</span></label>
                                            <textarea id="summernote" class="form-control" name="description" ></textarea>
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
        $('#summernote').summernote({
            height: 200,

        });
        $('#getClass').change(function () {
            var class_id = $(this).val();
            var url = "{{ url('admin/ajax_get_subject') }}";
            var type = 'POST';
            var data = {
                class_id: class_id,
                "_token": '{{ csrf_token() }}'
            };
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                dataType: 'json',
                success: function(data) {
                    $('#getSubject').html(data.success);
                    // if(data.status == 'success') {
                    //     toastr.success(data.message);
                    // } else {
                    //     toastr.error(data.message);
                    // }
                }
            });
        });
    });
</script>
@endpush
@endsection
