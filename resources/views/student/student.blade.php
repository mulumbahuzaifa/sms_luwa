
@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Students List</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('student/list') }}">Student</a></li>
                                <li class="breadcrumb-item active">All Students</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="student-group-form">
                {{-- <form action="search_student" method="GET">
                <div class="row">

                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <input type="text" name="search" class="form-control" placeholder="Search by Name ...">
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="search-student-btn">
                            <button type="btn" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </div>
            </form> --}}
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
                                <input type="text" value="{{ Request::get('admission_number') }}" name="admission_number" class="form-control" placeholder="Search by Admission No ...">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                                <input type="text" value="{{ Request::get('roll_number') }}" name="roll_number" class="form-control" placeholder="Search by Roll-No ...">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                                <input type="text" value="{{ Request::get('religion') }}" name="religion" class="form-control" placeholder="Search by Religion ...">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                                <input type="text" value="{{ Request::get('class') }}" name="class" class="form-control" placeholder="Search by Class ...">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                                <input type="text" value="{{ Request::get('caste') }}" name="caste" class="form-control" placeholder="Search by Caste ...">
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
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                                <input type="date" value="{{ Request::get('date') }}" name="date" class="form-control" placeholder="Search by Amsission Date ...">
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
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table comman-shadow">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Students (Total : {{ $studentList->total() }})</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="{{ route('student/list') }}" class="btn btn-outline-gray me-2 active"><i class="feather-list"></i></a>
                                        <a href="{{ route('student/grid') }}" class="btn btn-outline-gray me-2"><i class="feather-grid"></i></a>
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Download</a>
                                        <a href="{{ route('student/add/page') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive" style="overflow: auto;">
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
                                            <th>Parent Name</th>
                                            <th>Email</th>
                                            <th>Admission-No</th>
                                            <th>Roll-No</th>
                                            <th>Class</th>
                                            <th>Gender</th>
                                            <th>DOB</th>
                                            <th>Caste</th>
                                            <th>Religion</th>
                                            <th>Contact</th>
                                            <th>Admission-Date</th>
                                            <th>Joining-Date</th>
                                            <th>Blood Group</th>
                                            <th>Height</th>
                                            <th>Weight</th>
                                            <th>Status</th>
                                            <th>Created-Date</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($studentList as $key=>$list )
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
                                            <td>{{ $list->parent_name }} {{ $list->parent_last_name }}</td>
                                            <td>{{ $list->email }}</td>
                                            <td>{{ $list->admission_number }}</td>
                                            <td>{{ $list->roll_number }}</td>
                                            <td>{{ $list->class_name }}</td>
                                            <td>{{ $list->gender }}</td>
                                            <td>
                                                @if ($list->date_of_birth)
                                                {{ date('d-m-Y',  strtotime($list->date_of_birth)) }}
                                                @endif
                                            </td>
                                            <td>{{ $list->caste }}</td>
                                            <td>{{ $list->religion }}</td>
                                            <td>{{ $list->phone_number }}</td>
                                            <td>
                                                @if ($list->admission_date)
                                                {{ date('d-m-Y',  strtotime($list->admission_date)) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($list->join_date)
                                                {{ date('d-m-Y',  strtotime($list->join_date)) }}
                                                @endif
                                            </td>
                                            <td>{{ $list->blood_group }}</td>
                                            <td>{{ $list->height }}</td>
                                            <td>{{ $list->weight }}</td>
                                            <td>{{ ($list->status == 0) ? 'Active' : 'Inactive' }}
                                            </td>
                                            <td class="text-end">
                                                <div class="actions">
                                                    <a href="{{ url('student/edit/'.$list->id) }}" class="btn btn-sm bg-danger-light">
                                                        <i class="feather-edit"></i>
                                                    </a>
                                                    <form action="{{ route('student/delete', $list->id) }}" method="POST">
                                                        @csrf
                                                        {{-- @method('DELETE') --}}
                                                        <button  type="submit" class="btn btn-sm btn-danger" >
                                                            <i class="feather-trash-2 me-1"></i>
                                                        </button>
                                                    </form>
                                                    {{-- <a class="btn btn-sm bg-danger-light student_delete" data-bs-toggle="modal" data-bs-target="#studentUser">
                                                        <i class="feather-trash-2 me-1"></i>
                                                    </a> --}}
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div style="padding: 10px; float: right;">
                                    {!! $studentList->appends(request()->input())->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- model student delete --}}
    <div class="modal fade contentmodal" id="studentUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header pb-0 border-bottom-0  justify-content-end">
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                        class="feather-x-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="delete-wrap text-center">
                            <div class="del-icon">
                                <i class="feather-x-circle"></i>
                            </div>
                            <input type="hidden" name="id" class="e_id" value="">
                            <input type="hidden" name="avatar" class="e_avatar" value="">
                            <h2>Sure you want to delete</h2>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-success me-2">Yes</button>
                                <a class="btn btn-danger" data-bs-dismiss="modal">No</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('script')

    {{-- delete js --}}
    <script>
        $(document).on('click','.student_delete',function()
        {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.id').text());
            $('.e_avatar').val(_this.find('.avatar').text());
        });
    </script>
    @endsection

@endsection
