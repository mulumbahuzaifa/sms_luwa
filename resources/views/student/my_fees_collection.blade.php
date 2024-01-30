
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Fees Collection</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('student/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Fees Collection</li>
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
                                    <h3 class="page-title">Fees Collection</h3>
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="#" id="addFees" class="btn btn-outline-warning me-2"><i
                                            class="fas fa-download"></i> Add fees</a>
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
                                        <th>Class Name</th>
                                        <th>Total Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Remaining Amount</th>
                                        <th>Payment Type</th>
                                        <th>Remark</th>
                                        <th>CREATED BY</th>
                                        <th>CREATED DATE</th>
                                        {{-- <th class="text-end">ACTION</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($getFees as $value)
                                    <tr>
                                        <td>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </td>
                                        <td>{{ $value->class_name }}</td>
                                        <td>UGx {{ number_format($value->total_amount, 2) }}</td>
                                        <td>UGx {{ number_format($value->paid_amount, 2) }}</td>
                                        <td>UGx {{ number_format($value->remaining_amount, 2) }}</td>
                                        <td>{{ $value->payment_type }}</td>
                                        {{-- <td>UGx {{ number_format($value->amount, 2) }}</td> --}}
                                        <td>{{ $value->remark }}</td>
                                        <td>{{ $value->creator_name }}</td>
                                        <td>{{ date('d-m-Y H:i A',  strtotime($value->created_at)) }}</td>
{{--
                                        <td class="text-end">
                                            <a href="{{ route('admin/fees_collection/add') }}" class="btn btn-outline-success">COLLECT FEES</a>
                                        </td> --}}
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%">No Record Found </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
{{-- model student delete --}}
<div class="modal fade contentmodal" id="AddFeesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content doctor-profile">
            <div class="modal-header pb-0 border-bottom-0 ">
                <h5 class="modal-title">ADD FEES</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                    class="feather-x-circle"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <div class="delete-wrap text-center">
                        <div class="form-group">
                            <label class="col-form-label">Class : {{ $getStudent->class_name }}</label>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Total Amount : UGX {{ number_format($getStudent->amount, 2) }}</label>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Paid Amount : UGX {{ number_format($getPaidFees, 2) }}</label>
                        </div>
                        <div class="form-group">
                            @php
                                $remainingAmount = $getStudent->amount - $getPaidFees;
                            @endphp
                            <label class="col-form-label">Remaining Amount : UGX {{ number_format($remainingAmount, 2) }}</label>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Amount</label>
                            <input type="text" class="form-control" name="amount">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Payment Type <span style="color: red;">*</span></label>
                            <select class="form-control" name="payment_type" id="" required>
                                <option value="">Select</option>
                                <option value="Paypal">PayPal</option>
                                <option value="Stripe">Stripe</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Remark</label>
                            <textarea class="form-control" name="remark" id="" cols="30" rows="10"></textarea>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-success me-2">Submit</button>
                            <a class="btn btn-danger" data-bs-dismiss="modal">Close</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('script')
<script type="text/javascript">
    $('#addFees').click(function(){
        $('#AddFeesModal').modal('show');
    })
</script>
@endsection

@endsection
