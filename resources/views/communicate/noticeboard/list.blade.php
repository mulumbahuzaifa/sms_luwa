
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Notice Board</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Notice Board</li>
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
                                    <h3 class="page-title">Search Students Attendance</h3>
                                </div>
                            </div>
                        </div>
                        <form method="GET" action="">
                            <div class="student-group-form">
                                <div class="row">
                                    <div class="col-lg-2 col-md-3">
                                        <div class="form-group local-forms">
                                            <label for="">Title</label>
                                            <input type="text" class="form-control" placeholder="Search By Title" value="{{ Request::get('title') }}" name="title">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <div class="form-group local-forms">
                                            <label for="">Notice Date From</label>
                                            <input type="date" class="form-control" value="{{ Request::get('notice_date_from') }}"  name="notice_date_from">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <div class="form-group local-forms">
                                            <label for="">Notice Date To</label>
                                            <input type="date" class="form-control" value="{{ Request::get('notice_date_to') }}"  name="notice_date_to">
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-3">
                                        <div class="form-group local-forms">
                                            <label for="">Published Date From</label>
                                            <input type="date" class="form-control" value="{{ Request::get('publish_date_from') }}"  name="publish_date_from">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <div class="form-group local-forms">
                                            <label for="">Published Date To</label>
                                            <input type="date" class="form-control" value="{{ Request::get('publish_date_to') }}"  name="publish_date_to">
                                        </div>
                                    </div>


                                    <div class="col-lg-2 col-md-3">
                                        <div class="form-group local-forms">
                                            <label for="">Meassage To</label>
                                            <select name="message_to" class="form-control">
                                                <option value="">Select</option>
                                                <option {{ (Request::get('message_to') == "Student") ? 'selected' : '' }} value="Student">Student</option>
                                                <option {{ (Request::get('message_to') == "Parent") ? 'selected' : '' }} value="Parent">Parent</option>
                                                <option {{ (Request::get('message_to') == "Teacher") ? 'selected' : '' }} value="Teacher">Teacher</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="search-student-btn">
                                            <button type="btn" class="btn btn-secondary">Search</button>
                                            <a href="{{ route('admin/communicate/notice_board') }}" class="btn btn-success">Reset</a>
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
                                    <h3 class="page-title">Notice Board List</h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="#" class="btn btn-outline-primary me-2"><i
                                            class="fas fa-download"></i> Download</a>
                                    <a href="{{ route('admin/communicate/notice_board/add') }}" class="btn btn-primary"><i
                                            class="fas fa-plus"></i></a>
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
                                        <th>Title</th>
                                        <th>Notice Date</th>
                                        <th>Published Date</th>
                                        <th>Message To</th>
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
                                        <td>{{ $value->title }}</td>
                                        <td>{{ date('d-m-Y',  strtotime($value->notice_date)) }}</td>
                                        <td>{{ date('d-m-Y',  strtotime($value->publish_date))  }}</td>
                                        <td>
                                            @foreach ($value->getMessage as $message)
                                                @if ($message->message_to == "Teacher")
                                                    <div>Teacher</div>
                                                @elseif ($message->message_to == "Parent")
                                                    <div>Parent</div>
                                                @elseif ($message->message_to == "Student")
                                                    <div>Student</div>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $value->created_by_name }} {{ $value->created_by_last_name }}</td>
                                        <td>{{ date('d-m-Y H:i A',  strtotime($value->created_at)) }}</td>
                                        <td class="text-end">
                                            <div class="actions">
                                                <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                                    <i class="feather-eye"></i>
                                                </a>
                                                <a href="{{ route('admin/communicate/notice_board/edit', $value->id) }}" class="btn btn-sm bg-danger-light">
                                                    <i class="feather-edit"></i>
                                                </a>
                                                <form action="{{ route('admin/communicate/notice_board/delete', $value->id) }}" method="POST">

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
