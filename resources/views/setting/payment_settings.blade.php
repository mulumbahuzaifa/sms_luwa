@extends('layouts.master')
@section('content')
{!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Settings</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('setting/page') }}">Settings</a></li>
                            <li class="breadcrumb-item active">Payment Settings</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="settings-menu-links">
                <ul class="nav nav-tabs menu-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('setting/page') }}">General Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('setting/localization') }}">Localization</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('setting/payment') }}">Payment Settings</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('setting/social') }}">Social Links</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('setting/others') }}">Others</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Payment Details</h5>
                        </div>
                        <div class="card-body pt-0">
                            <form action="" method="POST">
                                @csrf
                                <div class="settings-form">
                                    <div class="form-group">
                                        <label>Paypal Bussiness Email </label>
                                        <input type="email" name="paypal_email" value="{{ $getRecord->paypal_email }}" class="form-control" placeholder="Paypal Bussiness Email">
                                    </div>
                                    <div class="form-group">
                                        <label>School Stripe Key</label>
                                        <input type="text" name="stripe_key" value="{{ $getRecord->stripe_key }}" class="form-control" placeholder="School Stripe Key">
                                    </div>
                                    <div class="form-group">
                                        <label>School Stripe Secret</label>
                                        <input type="text" name="stripe_secret" value="{{ $getRecord->stripe_secret }}" class="form-control" placeholder="School Stripe Key">
                                    </div>

                                    <div class="form-group mb-0">
                                        <div class="settings-btns">
                                            <button type="submit" class="btn btn-orange">Update</button>
                                            <a  href="{{ route('setting/payment') }}" class="btn btn-grey">Cancel</a>
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
