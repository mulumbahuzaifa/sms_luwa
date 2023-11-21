
@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Edit Teachers</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('teacher/list/page') }}">Teachers</a></li>
                        <li class="breadcrumb-item active">Edit Teachers</li>
                    </ul>
                </div>
            </div>
        </div>
        {{-- message --}}
        {!! Toastr::message() !!}
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('teacher/update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="form-control" name="id" value="{{ $teacher->id }}">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="form-title"><span>Basic Details</span></h5>
                                </div>

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
                                    <div class="form-group local-forms calendar-icon">
                                        <label>Joining Date <span class="login-danger">*</span></label>
                                        <input type="date" class="form-control  @error('join_date') is-invalid @enderror" name="join_date" placeholder="DD-MM-YYYY" value="{{ old('marital_status',$teacher->join_date)}}">
                                        @error('join_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Status <span class="login-danger">*</span></label>
                                        <select class="form-control select  @error('status') is-invalid @enderror" name="status">
                                            <option selected disabled>Select Status</option>
                                            <option value="0" {{ old('status', $teacher->status) == 0 ? "selected" :""}}>Active</option>
                                            <option value="1" {{ old('status', $teacher->status) == 1 ? "selected" :""}}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 local-forms">
                                    <div class="form-group local-forms calendar-icon">
                                        <label>Qualification <span class="login-danger">*</span></label>
                                        <textarea class="form-control @error('qualification') is-invalid @enderror" name="qualification" placeholder="Enter Teacher Qualifications" value="{{ old('qualification', $teacher->qualification) }}">{{ old('qualification', $teacher->qualification) }}</textarea>
                                        @error('qualification')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Experience <span class="login-danger">*</span></label>
                                        <textarea class="form-control @error('experience') is-invalid @enderror" name="experience" placeholder="Enter Work Experience" value="{{ old('experience', $teacher->experience) }}">{{ old('experience', $teacher->experience) }}</textarea>
                                        @error('experience')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Note </label>
                                        <textarea class="form-control @error('note') is-invalid @enderror" name="note" placeholder="Enter Some Note" value="{{ old('note', $teacher->note) }}">{{ old('note', $teacher->note) }}</textarea>
                                        @error('note')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group students-up-files">
                                        <label>Upload Student Photo (150px X 150px)</label>
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
                                    <h5 class="form-title"><span>Login Details</span></h5>
                                </div>

                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Email ID <span class="login-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Enter Mail Id" value="{{ old('email', $teacher->email) }}" >
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Password <span class="login-danger">*</span></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter Password" value="******" readonly>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group local-forms">
                                        <label>Repeat Password <span class="login-danger">*</span></label>
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Repeat Password" value="*****" readonly>
                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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
    </div>
</div>
@endsection
