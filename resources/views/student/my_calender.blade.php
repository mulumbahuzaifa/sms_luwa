
@extends('layouts.master')

@section('styles')
<style type="text/css">
    .fc-daygrid-event{
        white-space: normal;
    }

    .fc-event {

    color: #262705 !important;

}

</style>
@endsection

@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title"> My Calender</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('student/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">My Calender</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        {{-- <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="page-title">{{ $value['name'] }}</h3>
                                </div>
                            </div>
                        </div> --}}
                        <div id="calendar"></div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@section('script')
<script src="{{ URL::to('assets/dist/fullcalender/index.global.js') }}"></script>
<script type="text/javascript">
    var events = new Array();
    @foreach ($getMyTimetable as $value)
        @foreach ($value['week'] as $week)
            events.push({
                title: '{{ $value['name'] }}',
                daysOfWeek: [{{ $week['fullcalendar_day'] }}],
                startTime: '{{ $week['start_time'] }}',
                endTime: '{{ $week['end_time'] }}',
            });
        @endforeach
    @endforeach
    @foreach ($getExamTimetable as $valueE)
        @foreach ($valueE['exam'] as $exam)
            events.push({
                title: '{{ $valueE['name'] }} - {{ $exam['subject_name'] }} ({{ date('h:i A', strtotime($exam['start_time'])) }} to {{ date('h:i A', strtotime($exam['end_time'])) }})',
                start: '{{ $exam['exam_date'] }}',
                end: '{{ $exam['exam_date'] }}',
                color: 'red',
                url: '{{ url('student/exam_timetable') }}',
            });
        @endforeach
    @endforeach
    var calendarID = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarID,{
        initialView: 'timeGridWeek',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        initialDate: '<?=date('Y-m-d')?>',
        navLinks: true,
        editable: false,
        selectable: true,
        events: events,

    });
    calendar.render();
</script>
@endsection

@endsection
