
@extends('layouts.master')
@section('content')

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Parents</h3>
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
                            <input type="text" value="{{ Request::get('name') }}" name="name" class="form-control" placeholder="Search by Name ...">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <input type="text" value="{{ Request::get('email') }}" name="email" class="form-control" placeholder="Search by Email ...">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <input type="text" value="{{ Request::get('occupation') }}" name="occupation" class="form-control" placeholder="Search by Admission No ...">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <input type="text" value="{{ Request::get('address') }}" name="address" class="form-control" placeholder="Search by Roll-No ...">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <input type="text" value="{{ Request::get('phone_number') }}" name="phone_number" class="form-control" placeholder="Search by Phone No ...">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <select class="form-control select" name="gender">
                                <option selected disabled value="">Search By Gender</option>
                                <option value="Female" {{ Request::get('gender') == 'Female' ? "selected" :""}}>Female</option>
                                <option value="Male" {{ Request::get('gender') == 'Male' ? "selected" :""}}>Male</option>
                                <option value="Others" {{ Request::get('gender') == 'Others' ? "selected" :""}}>Others</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="search-student-btn">
                            <button type="btn" class="btn btn-secondary">Search</button>
                            <a href="{{ route('student/list') }}" class="btn btn-success">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        {{-- message --}}
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="page-title">Parents (Total : {{ $parentList->total() }})</h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="#" class="btn btn-outline-primary me-2"><i
                                            class="fas fa-download"></i> Download</a>
                                    <a href="{{ route('parent.add') }}" class="btn btn-primary"><i
                                            class="fas fa-plus"></i></a>
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
                                    <th>Name</th>
                                    <th>Email</th>>
                                    <th>Gender</th>
                                    <th>Contact</th>
                                    <th>Occupation</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th></th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parentList as $key=>$parent)
                                <tr>
                                    <td>
                                        <div class="form-check check-tables">
                                            <input class="form-check-input" type="checkbox" value="something">
                                        </div>
                                    </td>
                                    <td>PRT{{ ++$key }}</td>
                                    {{-- <td  class="id">{{ $list->name }} {{ $list->last_name }}</td> --}}
                                    <td hidden class="avatar">{{ $parent->avatar }}</td>
                                    <td>
                                        <h2 class="table-avatar">
                                            @if ($parent->avatar)
                                            <a href="#"class="avatar avatar-sm me-2">
                                                <img class="avatar-img rounded-circle" src="{{ Storage::url('parent-photos/'.$parent->avatar) }}" alt="">
                                            </a>
                                            @endif
                                            <a href="#">{{ $parent->name }} {{ $parent->last_name }}</a>
                                        </h2>
                                    </td>
                                    <td>{{ $parent->email }}</td>
                                    <td>{{ $parent->gender }}</td>
                                    <td>{{ $parent->phone_number }}</td>
                                    <td>{{ $parent->occupation }}</td>
                                    <td>{{ $parent->address }}</td>
                                    <td>{{ ($parent->status == 0) ? 'Active' : 'Inactive' }}
                                    </td>
                                    <td>
                                        {{ date('d-m-Y',  strtotime($parent->created_at)) }}
                                    </td>
                                    <td><a href="{{ route('parent.student', $parent->id) }}" class="btn btn-sm bg-primary">
                                        My Student
                                    </a></td>
                                    <td class="text-end">
                                            <div class="actions">

                                                <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                                    <i class="feather-eye"></i>
                                                </a>
                                                <a href="{{ route('parent.edit', $parent->id) }}" class="btn btn-sm bg-danger-light">
                                                    <i class="feather-edit"></i>
                                                </a>
                                                    <form action="{{ route('parent.delete', $parent->id) }}" method="POST">

                                                            @csrf
                                                            {{-- @method('DELETE') --}}
                                                            <button  type="submit" class="btn btn-sm btn-danger" >
                                                                <i class="feather-trash-2 me-1"></i>
                                                            </button>
                                                    </form>
                                                    <a href="{{ route('parent.edit', $parent->id) }}" class="btn btn-sm bg-danger-light">
                                                    <i class="feather-edit"></i>
                                                </a>

                                            </div>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        {!! $parentList->appends(request()->input())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@section('script')

@endsection

@endsection
