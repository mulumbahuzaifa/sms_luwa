
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<!-- Content Wrapper. Contains page content -->
<div class="page-wrapper">
    <div class="content container-fluid">
        <!-- Content Header (Page header) -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Pass Outs</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Passout Processing</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List Passouts Issued</h3>
                    <div class="card-tools">
                        <div class="col-auto text-end float-end ms-auto download-grp">
                            <a href="{{ route('admin/passout/add') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0 table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        <th style="width: 10px">#</th>
                        <th>Students Name</th>
                        <th>Class</th>
                        <th>STD Number</th>
                        <th>Destination</th>
                        <th>Reason</th>
                        <th>Parents Contact</th>
                        <th>Date Time</th>
                        <th>Issued By</th>
                        <th>Return Date</th>
                        <th style="width: 40px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1.</td>
                            <td>Oluwa Daglous</td>
                            <td>Form 1</td>
                            <td>STD102</td>
                            <td>Home</td>
                            <td>Update software</td>
                            <td>07008080899</td>
                            <td>17/03/2024 (7:00AM)</td>
                            <td>ADMIN</td>
                            <td>30/03/2024 (7:00AM)</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>Oluwa Daglous</td>
                            <td>Form 1</td>
                            <td>STD102</td>
                            <td>Home</td>
                            <td>Update software</td>
                            <td>07008080899</td>
                            <td>17/03/2024 (7:00AM)</td>
                            <td>ADMIN</td>
                            <td>30/03/2024 (7:00AM)</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td>Oluwa Daglous</td>
                            <td>Form 1</td>
                            <td>STD102</td>
                            <td>Home</td>
                            <td>Update software</td>
                            <td>07008080899</td>
                            <td>17/03/2024 (7:00AM)</td>
                            <td>ADMIN</td>
                            <td>30/03/2024 (7:00AM)</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>4.</td>
                            <td>Oluwa Daglous</td>
                            <td>Form 1</td>
                            <td>STD102</td>
                            <td>Home</td>
                            <td>Update software</td>
                            <td>07008080899</td>
                            <td>17/03/2024 (7:00AM)</td>
                            <td>ADMIN</td>
                            <td>30/03/2024 (7:00AM)</td>
                            <td></td>
                        </tr>
                    </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->

        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
  </div>
</div>

@section('script')

<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": false, "lengthChange": false, "autoWidth": false,
        "buttons": ["excel", "pdf", "print"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    //   $('#example2').DataTable({
    //     "paging": true,
    //     "lengthChange": false,
    //     "searching": false,
    //     "ordering": true,
    //     "info": true,
    //     "autoWidth": false,
    //     "responsive": true,
    //   });
    });
  </script>

@endsection

@endsection
