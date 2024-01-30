
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Collect Fees</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Collect Fees</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="student-group-form">
            <form action="" method="GET">
                <div class="row">
                    <div class="col-lg-2 col-md-3">
                        <div class="form-group">
                            <select class="form-control" name="class_id">
                                <option selected disabled>Select Class</option>
                                @foreach ($getClass as $smClass)
                                    <option value="{{ $smClass->id }}" {{ Request::get('class_id') == $smClass->id ? "selected" :""}}>{{ $smClass->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control" name="first_name" value="{{ Request::get('first_name') }}" placeholder="Student First-Name ...">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control" name="last_name" value="{{ Request::get('last_name') }}" placeholder="Student Last-Name ...">
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="search-student-btn">
                            <button type="btn" class="btn btn-outline-primary">Search</button>
                            <a href="{{ route('admin/fees_collection') }}" class="btn btn-danger">Reset</a>

                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">

                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="page-title">Search Results</h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="#" class="btn btn-outline-warning me-2"><i
                                            class="fas fa-download"></i> Download</a>
                                    {{-- <a href="{{ route('class.add') }}" class="btn btn-primary"><i
                                            class="fas fa-plus"></i></a> --}}
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" style="overflow: auto;">
                            <table
                                class="table border-0 star-student table-hover table-center mb-0  table-striped">
                                <thead class="student-thread">
                                    <tr>
                                        <th>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </th>
                                        <th>STUDENT ID</th>
                                        <th>STUDENT NAME</th>
                                        <th>Class NAME</th>
                                        <th>TOTAL AMOUNT (UGX)</th>
                                        <th>PAID AMOUNT (UGX)</th>
                                        <th>REMAINING AMOUNT (UGX)</th>
                                        <th>CREATED DATE</th>
                                        <th class="text-end">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($getRecord))
                                        @forelse ($getRecord as $smClass)
                                        @php
                                            $paid_amount = $smClass->getPaidAmount($smClass->id, $smClass->class_id);
                                            $remainingAmount = $smClass->amount - $paid_amount;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="form-check check-tables">
                                                    <input class="form-check-input" type="checkbox" value="something">
                                                </div>
                                            </td>
                                            <td>{{ $smClass->id }}</td>
                                            <td>{{ $smClass->name }} {{ $smClass->last_name }}</td>
                                            <td>{{ $smClass->class_name }}</td>
                                            <td>UGx {{ number_format($smClass->amount, 2) }}</td>
                                            <td>UGx {{ number_format($paid_amount, 2) }}</td>
                                            <td>UGx {{ number_format($remainingAmount, 2) }}</td>
                                            <td>{{ date('d-m-Y H:i A',  strtotime($smClass->created_at)) }}</td>

                                            <td class="text-end">
                                                <a href="{{ route('admin/fees_collection/add', $smClass->id) }}" class="btn btn-outline-success">COLLECT FEES</a>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="100%">No Record Found </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="100%">No Record Found </td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                        @if (!empty($getRecord))
                            {!! $getRecord->links()!!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@section('script')

@endsection

@endsection
