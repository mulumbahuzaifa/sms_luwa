
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Teachers</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Teachers</li>
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
                            <input type="text" value="{{ Request::get('religion') }}" name="religion" class="form-control" placeholder="Search by Religion ...">
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
                            <a href="{{ route('teacher/list/page') }}" class="btn btn-success">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="page-title">Teachers ({{ $listTeacher->count() }})</h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="{{ route('teacher/list/page') }}" class="btn btn-outline-gray me-2 active"><i
                                            class="feather-list"></i></a>
                                    <a href="{{ route('teacher/grid/page') }}" class="btn btn-outline-gray me-2"><i
                                            class="feather-grid"></i></a>
                                    <a href="#" class="btn btn-outline-primary me-2"><i
                                            class="fas fa-download"></i> Download</a>
                                    <a href="{{ route('teacher/add/page') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="DataList" class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                <thead class="student-thread">
                                    <tr>
                                        <th>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>Teacher-Name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>DOB</th>
                                        <th>DOJ</th>
                                        <th>Mobile Number</th>
                                        <th>Marital Status</th>
                                        <th>Current-Address</th>
                                        <th>Parmanent-Address</th>
                                        <th>Qualifications</th>
                                        <th>Work Experience</th>
                                        <th>Note</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listTeacher as $list)
                                    <tr>
                                        <td>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox"
                                                    value="something">
                                            </div>
                                        </td>
                                        <td hidden class="id">{{ $list->id }}</td>
                                        <td>{{ $list->user_id }}</td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="teacher-details.html" class="avatar avatar-sm me-2">
                                                    @if (!empty($list->avatar))
                                                        <img class="avatar-img rounded-circle" src="{{ Storage::url('teacher-photos/'.$list->avatar) }}" alt="{{ $list->name }}">
                                                    @else
                                                        <img class="avatar-img rounded-circle" src="{{ URL::to('images/photo_defaults.jpg') }}" alt="{{ $list->name }}">
                                                    @endif
                                                </a>
                                                <a href="teacher-details.html">{{ $list->name }} {{ $list->last_name }}</a>
                                            </h2>
                                        </td>
                                        <td>{{ $list->email }}</td>
                                        <td>{{ $list->gender }}</td>
                                        <td>
                                            @if ($list->date_of_birth)
                                            {{ date('d-m-Y',  strtotime($list->date_of_birth)) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($list->join_date)
                                                {{ date('d-m-Y',  strtotime($list->join_date)) }}
                                            @endif
                                        </td>
                                        <td>{{ $list->phone_number }}</td>
                                        <td>{{ $list->marital_status }}</td>
                                        <td>{{ $list->current_address }}</td>
                                        <td>{{ $list->address }}</td>
                                        <td>{{ $list->qualification }}</td>
                                        <td>{{ $list->experience }}</td>
                                        <td>{{ $list->note }}</td>
                                        <td>{{ ($list->status == 0) ? 'Active' : 'Inactive' }}
                                        </td>
                                        <td>{{ date('d-m-Y',  strtotime($list->created_at)) }}</td>
                                        <td class="text-end">
                                            <div class="actions">
                                                <a href="{{ url('teacher/edit/'.$list->id) }}" class="btn btn-sm bg-danger-light">
                                                    <i class="feather-edit"></i>
                                                </a>
                                                    <form action="{{ route('teacher/delete', $list->id) }}" method="POST">
                                                        @csrf
                                                        {{-- @method('DELETE') --}}
                                                        <button  type="submit" class="btn btn-sm btn-danger" >
                                                            <i class="feather-trash-2 me-1"></i>
                                                        </button>
                                                    </form>
                                                {{-- <a class="btn btn-sm bg-danger-light teacher_delete" data-bs-toggle="modal" data-bs-target="#teacherDelete">
                                                    <i class="feather-trash-2 me-1"></i>
                                                </a> --}}
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- model teacher delete --}}
<div class="modal fade contentmodal" id="teacherDelete" tabindex="-1" aria-hidden="true">
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
        $(document).on('click','.teacher_delete',function()
        {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.id').text());
        });
    </script>
@endsection

@endsection
