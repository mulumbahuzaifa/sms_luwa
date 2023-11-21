
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">My Subjects</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Subjects</li>
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
                                    <h3 class="page-title">My Subjects</h3>
                                </div>
                                {{-- <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="#" class="btn btn-outline-primary me-2"><i
                                            class="fas fa-download"></i> Download</a>
                                    <a href="{{ route('subject.add') }}" class="btn btn-primary"><i
                                            class="fas fa-plus"></i></a>
                                </div> --}}
                            </div>
                        </div>

                        <table
                            class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                            <thead class="student-thread">
                                <tr>
                                    <th>
                                        <div class="form-check check-tables">
                                            <input class="form-check-input" type="checkbox" value="something">
                                        </div>
                                    </th>
                                    <th>Subject Name</th>
                                    <th>Code</th>
                                    <th>Level</th>
                                    <th>Compulsory</th>
                                    {{-- <th>Class</th> --}}
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subjects as $subject)
                                <tr>
                                    <td>
                                        <div class="form-check check-tables">
                                            <input class="form-check-input" type="checkbox" value="something">
                                        </div>
                                    </td>
                                    <td>{{ $subject->subject_name }}</td>
                                    <td>
                                        <h2>
                                            <a>{{ $subject->subject_code }}</a>
                                        </h2>
                                    </td>
                                    <td>{{ $subject->subject_level }}</td>
                                    <td>
                                        @if($subject->subject_compulsory == 0)
                                        Compulsory
                                        @else
                                        Optional
                                        @endif
                                    </td>
                                    {{-- <td>{{ $subject->class->name }}</td> --}}
                                    <td class="text-end">
                                        <form action="{{ route('subject.delete', $subject->id) }}" method="POST">
                                            <div class="actions">
                                                <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                                    <i class="feather-eye"></i>
                                                </a>
                                                <a href="{{ route('subject.edit', $subject->id) }}" class="btn btn-sm bg-danger-light">
                                                    <i class="feather-edit"></i>
                                                </a>
                                                @csrf
                                                {{-- @method('DELETE') --}}
                                                <button  type="submit" class="btn btn-sm btn-danger" >
                                                    <i class="feather-trash-2 me-1"></i>
                                                </button>
                                            </div>
                                        </form>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{!! $subjects->links()!!}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@section('script')

@endsection

@endsection
