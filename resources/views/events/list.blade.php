
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
                    <h3 class="page-title">Events</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Events</li>
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
                    <h3 class="card-title">List of Events</h3>
                    <div class="card-tools">
                        <div class="col-auto text-end float-end ms-auto download-grp">
                            <a href="{{ route('admin/events/add') }}" class="btn btn-primary"><i
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
                        <th>Title</th>
                        <th>Description</th>
                        <th>RSVP</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Countdown</th>
                        <th style="width: 40px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td>1.</td>
                        <td>Update software</td>
                        <td>Update software</td>
                        <td>Oluwa Daglous</td>
                        <td><span class="badge bg-danger">Done</span></td>
                        <td>17/03/2024</td>
                        <td>7:00AM</td>
                        <td>
                            <div class="progress progress-xs">
                            <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                            </div>
                        </td>
                        <td></td>
                        </tr>
                        <tr>
                        <td>2.</td>
                        <td>Clean database</td>
                        <td>Clean database</td>
                        <td>Oluwa Daglous</td>
                        <td><span class="badge bg-warning">Active</span></td>
                        <td>17/03/2024</td>
                        <td>7:00AM</td>
                        <td>
                            <div class="progress progress-xs">
                            <div class="progress-bar bg-warning" style="width: 70%"></div>
                            </div>
                        </td>
                        <td></td>
                        </tr>
                        <tr>
                        <td>3.</td>
                        <td>Cron job running</td>
                        <td>Cron job running</td>
                        <td>Oluwa Daglous</td>
                        <td><span class="badge bg-primary">Done</span></td>
                        <td>17/03/2024</td>
                        <td>7:00AM</td>
                        <td>
                            <div class="progress progress-xs progress-striped active">
                            <div class="progress-bar bg-primary" style="width: 30%"></div>
                            </div>
                        </td>

                        <td></td>
                        </tr>
                        <tr>
                        <td>4.</td>
                        <td>Fix and squish bugs</td>
                        <td>Fix and squish bugs</td>
                        <td>Oluwa Daglous</td>
                        <td><span class="badge bg-success">Pending</span></td>
                        <td>17/03/2024</td>
                        <td>7:00AM</td>
                        <td>
                            <div class="progress progress-xs progress-striped active">
                            <div class="progress-bar bg-success" style="width: 90%"></div>
                            </div>
                        </td>
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
