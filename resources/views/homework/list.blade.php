
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">HomeWork</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">HomeWork</li>
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
                                    <h3 class="page-title">Search Homework</h3>
                                </div>
                            </div>
                        </div>
                        <form method="GET" action="">
                            <div class="student-group-form">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3">
                                        <div class="form-group local-forms">
                                            <label for="">Class</label>
                                            <input type="text" class="form-control" placeholder="Search By Class Name" value="{{ Request::get('class_name') }}" name="class_name">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <div class="form-group local-forms">
                                            <label for="">Subject</label>
                                            <input type="date" class="form-control" placeholder="Search By Subject Name" value="{{ Request::get('subject_name') }}"  name="subject_name">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <div class="form-group local-forms">
                                            <label for="">HomeWork Date From</label>
                                            <input type="date" class="form-control" value="{{ Request::get('homework_date_from') }}"  name="homework_date_from">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <div class="form-group local-forms">
                                            <label for="">HomeWork Date To</label>
                                            <input type="date" class="form-control" value="{{ Request::get('homework_date_to') }}"  name="homework_date_to">
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-3">
                                        <div class="form-group local-forms">
                                            <label for="">Submission Date From</label>
                                            <input type="date" class="form-control" value="{{ Request::get('submission_date_from') }}"  name="submission_date_from">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <div class="form-group local-forms">
                                            <label for="">Submission Date To</label>
                                            <input type="date" class="form-control" value="{{ Request::get('submission_date_to') }}"  name="submission_date_to">
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="search-student-btn">
                                            <button type="btn" class="btn btn-secondary">Search</button>
                                            <a href="{{ route('admin/holiday/homework') }}" class="btn btn-success">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                <div class="card card-table">
                    <div class="card-body">

                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="page-title">HomeWork List</h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="#" class="btn btn-outline-warning me-2"><i
                                            class="fas fa-download"></i> Download</a>
                                    <a href="{{ route('admin/holiday/homework/add') }}" class="btn btn-outline-primary me-2"><i
                                            class="fas fa-plus"></i>ADD</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table
                                class="table border-0 star-student table-hover table-center mb-0  table-striped">
                                <thead class="student-thread">
                                    <tr>
                                        <th>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </th>
                                        <th>#</th>
                                        <th>Class</th>
                                        <th>Subject</th>
                                        <th>Homework Date</th>
                                        <th>Submission Date</th>
                                        <th>Document</th>
                                        <th>Created-By</th>
                                        <th>Created-Date</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @forelse ($getRecord as $value)
                                    <tr>
                                        <td>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </td>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $value->class_name }}</td>
                                        <td>{{ $value->subject_name }}</td>
                                        <td>{{ date('d-m-Y',  strtotime($value->homework_date)) }}</td>
                                        <td>{{ date('d-m-Y',  strtotime($value->submission_date))  }}</td>
                                        <td>
                                            @if ($value->document_file)
                                            <a href="{{ asset('storage/homework/'.$value->document_file) }}" target="_blank" class="btn btn-sm bg-success-light">
                                                <i class="feather-download"></i>
                                            </a>
                                            @else
                                            <span class="badge bg-danger">No Document</span>
                                            @endif
                                        </td>
                                        <td>{{ $value->created_by_name }} {{ $value->created_by_last_name }}</td>
                                        <td>{{ date('d-m-Y H:i A',  strtotime($value->created_at)) }}</td>
                                        <td class="text-end">
                                            <div class="actions">
                                                <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                                    <i class="feather-eye"></i>
                                                </a>
                                                <a href="{{ route('admin/holiday/homework/edit', $value->id) }}" class="btn btn-sm bg-danger-light">
                                                    <i class="feather-edit"></i>
                                                </a>
                                                <form action="{{ route('admin/holiday/homework/delete', $value->id) }}" method="POST">

                                                    @csrf
                                                    <button  type="submit" class="btn btn-sm btn-danger" >
                                                        <i class="feather-trash-2 me-1"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="100%">Record Not Found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {!! $getRecord->appends(request()->input())->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@section('script')

@endsection

@endsection
