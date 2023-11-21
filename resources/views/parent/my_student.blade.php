
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Parent Student List ({{ $getParent->name }} {{ $getParent->last_name }})</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Parents</li>
                    </ul>
                </div>
            </div>
        </div>
        <form method="GET" action="">
            <div class="student-group-form">
                <div class="row">
                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <input type="text" value="{{ Request::get('id') }}" name="id" class="form-control" placeholder="Search by ID ...">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <input type="text" value="{{ Request::get('name') }}" name="name" class="form-control" placeholder="Search by Name ...">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <input type="text" value="{{ Request::get('email') }}" name="email" class="form-control" placeholder="Search by Email ...">
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="search-student-btn">
                            <button type="btn" class="btn btn-secondary">Search</button>
                            <a href="{{ route('parent.student', $parent_id) }}" class="btn btn-success">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        @if (!empty($getSearchStudent))
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Student List </h3>
                                    </div>

                                </div>
                            </div>
                            <div class="table-responsive">
                                <table
                                    class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </th>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Email</th>>
                                            <th>Parent Name</th>
                                            <th>Created Date</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getSearchStudent as $key=>$list )
                                        <tr>
                                            <td>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </td>
                                            <td>STD{{ ++$key }}</td>
                                            {{-- <td  class="id">{{ $list->name }} {{ $list->last_name }}</td> --}}
                                            <td hidden class="avatar">{{ $list->avatar }}</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    @if ($list->avatar)
                                                    <a href="student-details.html"class="avatar avatar-sm me-2">
                                                        <img class="avatar-img rounded-circle" src="{{ Storage::url('student-photos/'.$list->avatar) }}" alt="">
                                                    </a>
                                                    @endif
                                                    <a href="student-details.html">{{ $list->name }} {{ $list->last_name }}</a>
                                                </h2>
                                            </td>
                                            <td>{{ $list->email }}</td>
                                            <td>{{ $list->parent_name }}</td>

                                            <td>{{ date('d-m-Y', strtotime($list->created_at)) }}
                                            </td>
                                            <td class="text-end">
                                                <div class="">
                                                    <a href="{{ url('parent/assign_student_parent/'.$list->id.'/'.$parent_id) }}" class="btn btn-sm bg-danger-light">
                                                        Add Student to Parent
                                                    </a>
                                                    {{-- <form action="{{ route('student/delete', $list->id) }}" method="POST">
                                                        @csrf
                                                        <button  type="submit" class="btn btn-sm btn-danger" >
                                                            <i class="feather-trash-2 me-1"></i>
                                                        </button>
                                                    </form> --}}
                                                    {{-- <a class="btn btn-sm bg-danger-light student_delete" data-bs-toggle="modal" data-bs-target="#studentUser">
                                                        <i class="feather-trash-2 me-1"></i>
                                                    </a> --}}
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="page-title">Parent Student List </h3>
                                </div>

                            </div>
                        </div>
                        <div class="table-responsive">
                            <table
                            class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                <thead class="student-thread">
                                    <tr>
                                        <th>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </th>
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>Email</th>>
                                        <th>Parent Name</th>
                                        <th>Created Date</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getRecord as $key=>$list )
                                    <tr>
                                        <td>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </td>
                                        <td>STD{{ ++$key }}</td>
                                        {{-- <td  class="id">{{ $list->name }} {{ $list->last_name }}</td> --}}
                                        <td hidden class="avatar">{{ $list->avatar }}</td>
                                        <td>
                                            <h2 class="table-avatar">
                                                @if ($list->avatar)
                                                <a href="student-details.html"class="avatar avatar-sm me-2">
                                                    <img class="avatar-img rounded-circle" src="{{ Storage::url('student-photos/'.$list->avatar) }}" alt="">
                                                </a>
                                                @endif
                                                <a href="student-details.html">{{ $list->name }} {{ $list->last_name }}</a>
                                            </h2>
                                        </td>
                                        <td>{{ $list->email }}</td>
                                        <td>{{ $list->parent_name }}</td>

                                        <td>{{ date('d-m-Y', strtotime($list->created_at)) }}
                                        </td>
                                        <td class="text-end">
                                            <div class="">
                                                <a href="{{ url('parent/assign_student_parent_delete/'.$list->id) }}" class="btn btn-sm btn-danger">
                                                    Remove Student From Parent
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                        </div>
                        {{-- {!! $parentList->appends(request()->input())->links() !!} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@section('script')

@endsection

@endsection
