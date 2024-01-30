
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Passout</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin/passout/list') }}">Passouts</a></li>
                <li class="breadcrumb-item active">Create Passout</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Create Passout</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form>
                    <div class="card-body">
                    <div class="form-group">
                        <label for="name">Student Name</label>
                        <select class="form-control select2" name="name" style="width: 100%;">
                            <option selected="selected">Choose Name</option>
                            <option>Dumba Sentamu</option>
                            <option>Oluwa Daglous</option>
                            <option>Mulumba Huzaifa</option>
                            <option>Sali Yusuf</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Student Class</label>
                        <select class="form-control select2" name="class" style="width: 100%;">
                            <option selected="selected">Choose Class</option>
                            <option>Senior 1</option>
                            <option>Senior 2</option>
                            <option>Senior 3</option>
                            <option>Senior 4</option>
                            <option>Senior 5</option>
                            <option>Senior 6</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="destination">Destination</label>
                        <input type="text" class="form-control" id="destination" name="destination" placeholder="Destination">
                    </div>
                    <div class="form-group">
                        <label>Return Date and time:</label>
                        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime"/>
                            <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                            <label>Reason :</label>
                            <textarea id="summernote1" name="description">
                                Place <em>some</em> <u>text</u> <strong>here</strong>
                            </textarea>
                            {{-- <textarea id="summernote" class="form-control" name="description"></textarea> --}}
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                </div>
                <!-- /.card -->

            </div>
            <!--/.col (left) -->

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
    //Initialize Select2 Elements
    $('.select2').select2()

    $('#summernote1').summernote({
        height: 200,
    });

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })
</script>

@endsection

@endsection
