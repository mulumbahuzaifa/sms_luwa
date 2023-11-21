
@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Edit Students</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('student/add/page') }}">Student</a></li>
                                <li class="breadcrumb-item active">Edit Students</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-sm-12">
                    <div class="card comman-shadow">
                        <div class="card-body">
                            <form action="{{ route('student/update',  $studentEdit->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" name="id" value="{{ old('id', $studentEdit->id) }}" readonly>
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title student-info">Edit Student Information
                                            <span>
                                                <a href="javascript:;"><i class="feather-more-vertical"></i></a>
                                            </span>
                                        </h5>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>First Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter First Name" value="{{ old('name', $studentEdit->name) }}">
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
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="Enter Last Name" value="{{ old('last_name', $studentEdit->last_name) }}">
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Admission Number <span class="login-danger">*</span></label>
                                            <input class="form-control @error('admission_number') is-invalid @enderror" type="text" name="admission_number" placeholder="Enter Admission Number" value="{{ old('admission_number', $studentEdit->admission_number) }}">
                                            @error('admission_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Roll Number <span class="login-danger">*</span></label>
                                            <input class="form-control @error('roll_number') is-invalid @enderror" type="text" name="roll_number" placeholder="Enter Roll Number" value="{{ old('roll_number', $studentEdit->roll_number) }}">
                                            @error('roll_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Class <span class="login-danger">*</span></label>
                                            <select class="form-control select @error('class_id') is-invalid @enderror" required name="class_id">
                                                <option selected disabled>Please Select Class </option>
                                                @foreach ($getClass as $value)
                                                    <option value="{{ $value->id }}" {{ old('class_id', $studentEdit->class_id) == $value->id ? "selected" :""}}>{{ $value->name }}</option>

                                                @endforeach

                                            </select>
                                            @error('class_id')
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
                                                <option value="Female" {{ old('gender', $studentEdit->gender) == 'Female' ? "selected" :"Female"}}>Female</option>
                                                <option value="Male" {{ old('gender', $studentEdit->gender) == 'Male' ? "selected" :""}}>Male</option>
                                                <option value="Others" {{ old('gender', $studentEdit->gender) == 'Others' ? "selected" :""}}>Others</option>
                                            </select>
                                            @error('gender')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms calendar-icon">
                                            <label>Date Of Birth <span class="login-danger">*</span></label>
                                            <input class="form-control  @error('date_of_birth') is-invalid @enderror" required name="date_of_birth" type="date" placeholder="DD-MM-YYYY" value="{{ old('date_of_birth', $studentEdit->date_of_birth) }}">
                                            @error('date_of_birth')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Caste</label>
                                            <input class="form-control @error('caste') is-invalid @enderror" type="text" name="caste" placeholder="Caste" value="{{ old('caste', $studentEdit->caste) }}">
                                            @error('caste')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Religion</label>
                                            <input class="form-control @error('religion') is-invalid @enderror" type="text" name="religion" placeholder="Religion" value="{{ old('religion', $studentEdit->religion) }}">
                                            @error('religion')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Phone Number</label>
                                            <input class="form-control @error('phone_number') is-invalid @enderror" type="text" name="phone_number" placeholder="Phone Number" value="{{ old('phone_number', $studentEdit->phone_number) }}">
                                            @error('phone_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Admission Date <span class="login-danger">*</span></label>
                                            <input class="form-control  @error('admission_date') is-invalid @enderror"  type="date" name="admission_date" placeholder="DD-MM-YYYY" value="{{ old('admission_date', $studentEdit->admission_date) }}">
                                            @error('admission_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Blood Group <span class="login-danger">*</span></label>
                                            <select class="form-control select @error('blood_group') is-invalid @enderror" name="blood_group">
                                                <option selected disabled>Please Select Group </option>
                                                <option value="A+" {{ old('blood_group', $studentEdit->blood_group) == 'A+' ? "selected" :""}}>A+</option>
                                                <option value="B+" {{ old('blood_group', $studentEdit->blood_group) == 'B+' ? "selected" :""}}>B+</option>
                                                <option value="O+" {{ old('blood_group', $studentEdit->blood_group) == 'O+' ? "selected" :""}}>O+</option>
                                            </select>
                                            @error('blood_group')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Height</label>
                                            <input class="form-control @error('height') is-invalid @enderror" type="text" name="height" placeholder="Height" value="{{ old('height', $studentEdit->height) }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Weight</label>
                                            <input class="form-control @error('weight') is-invalid @enderror" type="text" name="weight" placeholder="Weight" value="{{ old('weight', $studentEdit->weight) }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Status <span class="login-danger">*</span></label>
                                            <select class="form-control select  @error('status') is-invalid @enderror" name="status">
                                                <option selected disabled>Select Status</option>
                                                <option value="0" {{ old('status', $studentEdit->status) == 0 ? "selected" :""}}>Active</option>
                                                <option value="1" {{ old('status', $studentEdit->status) == 1 ? "selected" :""}}>Inactive</option>
                                            </select>
                                            @error('status')
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
                                                @if ($studentEdit->avatar)
                                                <h2 class="table-avatar">
                                                    <a class="avatar avatar-sm me-2">
                                                        <img class="avatar-img rounded-circle" src="{{ Storage::url('student-photos/'.$studentEdit->avatar) }}" alt="User Image">
                                                    </a>
                                                </h2>
                                                @endif
                                                <label class="file-upload image-upbtn mb-0 @error('avatar') is-invalid @enderror">
                                                    Choose File <input type="file" name="avatar">
                                                </label>
                                                <input type="hidden" name="image_hidden" value="{{ old('avatar', $studentEdit->avatar) }}">
                                                @error('avatar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <hr />

                                    <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>E-Mail <span class="login-danger">*</span></label>
                                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" placeholder="Enter Email Address" value="{{ old('email', $studentEdit->email) }}">
                                            <span class="profile-views"><i class="fas fa-envelope"></i></span>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-12 col-sm-12">
                                        <div class="form-group local-forms">
                                            <label>Password <span class="login-danger">*</span></label>
                                            <input type="password" class="form-control pass-input @error('password') is-invalid @enderror" name="password" >
                                            <span class="profile-views feather-eye toggle-password"></span>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div> --}}
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
