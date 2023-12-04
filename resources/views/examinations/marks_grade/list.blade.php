
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Marks Grade</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Marks Grade</li>
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
                                    <h3 class="page-title">Marks Grade List</h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="#" class="btn btn-outline-primary me-2"><i
                                            class="fas fa-download"></i> Download</a>
                                    <a href="{{ route('exam.submit_marks_grade') }}" class="btn btn-primary"><i
                                            class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>

                        <table
                            class="table border-0 star-student table-hover table-center mb-0  table-striped">
                            <thead class="student-thread">
                                <tr>
                                    <th>
                                        <div class="form-check check-tables">
                                            <input class="form-check-input" type="checkbox" value="something">
                                        </div>
                                    </th>
                                    <th>Grade</th>
                                    <th>Percent From</th>
                                    <th>Percent To</th>
                                    <th>Created By</th>
                                    <th>Created-Date</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getRecord as $value)
                                <tr>
                                    <td>
                                        <div class="form-check check-tables">
                                            <input class="form-check-input" type="checkbox" value="something">
                                        </div>
                                    </td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->percent_from }}</td>
                                    <td>{{ $value->percent_to}}</td>
                                    <td>{{ $value->created_name}}</td>
                                    <td>{{ date('d-m-Y H:i A',  strtotime($value->created_at)) }}</td>
                                    <td class="text-end">
                                        <div class="actions">
                                            <a href="javascript:;" class="btn btn-sm bg-success-light me-2">
                                                <i class="feather-eye"></i>
                                            </a>
                                            <a href="{{ route('marks_grade.edit', $value->id) }}" class="btn btn-sm bg-danger-light">
                                                <i class="feather-edit"></i>
                                            </a>
                                            <form action="{{ route('marksGrade.delete', $value->id) }}" method="POST">
                                                @csrf
                                                {{-- @method('DELETE') --}}
                                                <button  type="submit" class="btn btn-sm btn-danger" >
                                                    <i class="feather-trash-2 me-1"></i>
                                                </button>
                                            </form>
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

@section('script')

@endsection

@endsection
