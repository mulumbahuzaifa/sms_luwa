
@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ul>
                </div>
            </div>
        </div>
        {{-- message --}}
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="profile-header">
                    <div class="row align-items-center">
                        <div class="col-auto profile-image">
                            <a href="#">
                                @if (!empty(Session::get('avatar')))
                                <img class="rounded-circle" alt="{{ Session::get('name') }}" src="{{ Storage::url('teacher-photos/'.Session::get('avatar')) }}">
                                @else
                                <img class="rounded-circle" src="{{ URL::to('images/photo_defaults.jpg') }}" alt="{{ Session::get('name') }}">
                                @endif
                            </a>
                        </div>
                        <div class="col ms-md-n2 profile-user-info">
                            <h4 class="user-name mb-0">{{ Session::get('name') }}</h4>
                            <h6 class="text-muted">{{ $teacher->position }}</h6>
                            <div class="user-Location"><i class="fas fa-map-marker-alt"></i> {{ $teacher->address }}</div>
                            <div class="about-text">{{ $teacher->note }}</div>
                        </div>
                        <div class="col-auto profile-btn">
                            <a href="" class="btn btn-primary">Edit</a>
                        </div>
                    </div>
                </div>
                <div class="profile-menu">
                    <ul class="nav nav-tabs nav-tabs-solid">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#per_details_tab">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#edit_details_tab">Edit</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#password_tab">Password</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content profile-tab-cont">

                    <div class="tab-pane fade show active" id="per_details_tab">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title d-flex justify-content-between">
                                            <span>Personal Details</span>
                                            <a class="edit-link" data-bs-toggle="modal"
                                                href="#edit_personal_details"><i
                                                    class="far fa-edit me-1"></i>Edit</a>
                                        </h5>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Name</p>
                                            <p class="col-sm-9">{{ Session::get('name') }}</p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Date of Birth</p>
                                            <p class="col-sm-9">{{ date('d-m-Y',  strtotime($teacher->date_of_birth)) }}</p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Email</p>
                                            <p class="col-sm-9"><a href="#"
                                                    class="__cf_email__"
                                                    data-cfemail="{{ $teacher->email }}">{{ $teacher->email }}</a>
                                            </p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Mobile</p>
                                            <p class="col-sm-9">{{ $teacher->phone_number }}</p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0">Address</p>
                                            <p class="col-sm-9 mb-0">{{ $teacher->current_address }},<br>
                                             </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title d-flex justify-content-between">
                                            <span>Account Status</span>
                                            <a class="edit-link" href="#"><i class="far fa-edit me-1"></i>Edit</a>
                                        </h5>
                                        <button class="btn btn-success" type="button"><i class="fe fe-check-verified"></i>{{ ($teacher->status == 0) ? 'Active' : 'Inactive' }} Active</button>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title d-flex justify-content-between">
                                            <span>Skills </span>
                                            <a class="edit-link" href="#"><i class="far fa-edit me-1"></i>Edit</a>
                                        </h5>
                                        {{-- <div class="skill-tags">
                                            <span>Html5</span>
                                            <span>CSS3</span>
                                            <span>WordPress</span>
                                            <span>Javascript</span>
                                            <span>Android</span>
                                            <span>iOS</span>
                                            <span>Angular</span>
                                            <span>PHP</span>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="edit_details_tab" class="tab-pane fade">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <form action="{{ route('update/teacher/profile', $teacher->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="form-control" name="id" value="{{ $teacher->id }}">
                                        <div class="row">


                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>First Name <span class="login-danger">*</span></label>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter First Name" value="{{ old('name',  $teacher->name) }}">
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>Last Name <span class="login-danger">*</span></label>
                                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="Enter Last Name" value="{{ old('last_name',  $teacher->last_name) }}">
                                                    @error('last_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>Gender <span class="login-danger">*</span></label>
                                                    <select class="form-control select  @error('gender') is-invalid @enderror" name="gender">
                                                        <option selected disabled>Select Gender</option>
                                                        <option value="Female" {{ old('religion',$teacher->gender) == 'Female' ? "selected" :""}}>Female</option>
                                                        <option value="Male" {{ old('religion',$teacher->gender) == 'Male' ? "selected" :""}}>Male</option>
                                                        <option value="Others" {{ old('religion',$teacher->gender) == 'Others' ? "selected" :""}}>Others</option>
                                                    </select>
                                                    @error('gender')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>Religion</label>
                                                    <input class="form-control @error('religion') is-invalid @enderror" type="text" name="religion" placeholder="Religion" value="{{ old('religion', $teacher->religion) }}">
                                                    @error('religion')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms calendar-icon">
                                                    <label>Date Of Birth <span class="login-danger">*</span></label>
                                                    <input type="date" class="form-control  @error('date_of_birth') is-invalid @enderror" name="date_of_birth" placeholder="DD-MM-YYYY" value="{{ old('date_of_birth', $teacher->date_of_birth) }}">
                                                    @error('date_of_birth')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>Mobile <span class="login-danger">*</span></label>
                                                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" placeholder="Enter Phone" value="{{ old('phone_number',$teacher->phone_number) }}">
                                                    @error('phone_number')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group local-forms">
                                                    <label>Marital Status <span class="login-danger">*</span></label>
                                                    <input type="text" class="form-control @error('marital_status') is-invalid @enderror" name="marital_status" placeholder="Marital Status" value="{{ old('marital_status', $teacher->marital_status) }}">
                                                    @error('marital_status')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-4">
                                                <div class="form-group students-up-files">
                                                    <label>Update Profile Photo (150px X 150px)</label>
                                                    <div class="uplod">
                                                        @if ($teacher->avatar)
                                                        <h2 class="table-avatar">
                                                            <a class="avatar avatar-sm me-2">
                                                                <img class="avatar-img rounded-circle" src="{{ Storage::url('teacher-photos/'.$teacher->avatar) }}" alt="{{ $teacher->name }}">
                                                            </a>
                                                        </h2>
                                                        @endif
                                                        <label class="file-upload image-upbtn mb-0 @error('avatar') is-invalid @enderror">
                                                            Choose File <input type="file" name="avatar">
                                                        </label>
                                                        <input type="hidden" name="image_hidden" value="{{ old('avatar', $teacher->avatar) }}">
                                                        @error('avatar')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <h5 class="form-title"><span>Address</span></h5>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group local-forms">
                                                    <label>Current Address <span class="login-danger">*</span></label>
                                                    <input type="text" class="form-control @error('current_address') is-invalid @enderror" name="current_address" placeholder="Enter Current Address" value="{{ old('current_address',$teacher->current_address) }}">
                                                    @error('current_address')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group local-forms">
                                                    <label>Permanent Address <span class="login-danger">*</span></label>
                                                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Enter Permanent address" value="{{ old('address', $teacher->address) }}">
                                                    @error('address')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="student-submit">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="password_tab" class="tab-pane fade">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Change Password</h5>
                                <div class="row">
                                    <div class="col-md-10 col-lg-6">
                                        <form action="{{ route('change/password') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label>Old Password</label>
                                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" value="{{ old('current_password') }}">
                                                @error('current_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" value="{{ old('new_password') }}">
                                                @error('new_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" class="form-control @error('new_confirm_password') is-invalid @enderror" name="new_confirm_password" value="{{ old('new_confirm_password') }}">
                                                @error('new_confirm_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
