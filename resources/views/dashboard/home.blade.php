
@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Welcome {{ Session::get('name') }}!</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">{{ Session::get('name') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Students</h6>
                                <h3>{{ $numberOfStudents }}</h3>
                            </div>
                            <div class="db-icon">
                                <img src="assets/img/icons/dash-icon-01.svg" alt="Dashboard Icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Teachers</h6>
                                <h3>{{ $numberOfTeachers }}</h3>
                            </div>
                            <div class="db-icon">
                                <img src="assets/img/icons/dash-icon-02.svg" alt="Dashboard Icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Department</h6>
                                <h3>{{ $numberOfDepartments }}</h3>
                            </div>
                            <div class="db-icon">
                                <img src="assets/img/icons/dash-icon-03.svg" alt="Dashboard Icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Classes</h6>
                                <h3>{{ $numberOfClasses }}</h3>
                            </div>
                            <div class="db-icon">
                                <img src="assets/img/icons/dash-icon-04.svg" alt="Dashboard Icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-6">

                <div class="card card-chart">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="card-title">Overview</h5>
                            </div>
                            <div class="col-6">
                                <ul class="chart-list-out">
                                    <li><span class="circle-blue"></span>Teacher</li>
                                    <li><span class="circle-green"></span>Student</li>
                                    <li class="star-menus"><a href="javascript:;"><i
                                                class="fas fa-ellipsis-v"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" height="150px"></canvas>
                        <div id="apexcharts-area"></div>
                    </div>
                </div>

            </div>
            <div class="col-md-12 col-lg-6">

                <div class="card card-chart">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="card-title">Number of Students</h5>
                            </div>
                            <div class="col-6">
                                <ul class="chart-list-out">
                                    <li><span class="circle-blue"></span>Girls</li>
                                    <li><span class="circle-green"></span>Boys</li>
                                    <li class="star-menus"><a href="javascript:;"><i
                                                class="fas fa-ellipsis-v"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="bar"></div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 d-flex">

                <div class="card flex-fill student-space comman-shadow">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title">Star Students</h5>
                        <ul class="chart-list-out student-ellips">
                            <li class="star-menus"><a href="javascript:;"><i class="fas fa-ellipsis-v"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="table star-student table-hover table-center table-borderless table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th class="text-center">Marks</th>
                                        <th class="text-center">Percentage</th>
                                        <th class="text-end">Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap">
                                            <div>PRE2209</div>
                                        </td>
                                        <td class="text-nowrap">
                                            <a href="profile.html">
                                                <img class="rounded-circle"src="{{ URL::to('assets/img/profiles/avatar-01.jpg') }}" width="25" alt="Star Students"> Soeng Souy
                                            </a>
                                        </td>
                                        <td class="text-center">1185</td>
                                        <td class="text-center">98%</td>
                                        <td class="text-end">
                                            <div>2019</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap">
                                            <div>PRE1245</div>
                                        </td>
                                        <td class="text-nowrap">
                                            <a href="profile.html">
                                                <img class="rounded-circle"src="{{ URL::to('assets/img/profiles/avatar-01.jpg') }}" width="25" alt="Star Students"> Soeng Souy
                                            </a>
                                        </td>
                                        <td class="text-center">1195</td>
                                        <td class="text-center">99.5%</td>
                                        <td class="text-end">
                                            <div>2018</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap">
                                            <div>PRE1625</div>
                                        </td>
                                        <td class="text-nowrap">
                                            <a href="profile.html">
                                                <img class="rounded-circle"src="{{ URL::to('assets/img/profiles/avatar-01.jpg') }}" width="25" alt="Star Students"> Soeng Souy
                                            </a>
                                        </td>
                                        <td class="text-center">1196</td>
                                        <td class="text-center">99.6%</td>
                                        <td class="text-end">
                                            <div>2017</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap">
                                            <div>PRE2516</div>
                                        </td>
                                        <td class="text-nowrap">
                                            <a href="profile.html">
                                                <img class="rounded-circle"src="{{ URL::to('assets/img/profiles/avatar-01.jpg') }}" width="25" alt="Star Students"> Soeng Souy
                                            </a>
                                        </td>
                                        <td class="text-center">1187</td>
                                        <td class="text-center">98.2%</td>
                                        <td class="text-end">
                                            <div>2016</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap">
                                            <div>PRE2209</div>
                                        </td>
                                        <td class="text-nowrap">
                                            <a href="profile.html">
                                                <img class="rounded-circle"src="{{ URL::to('assets/img/profiles/avatar-01.jpg') }}" width="25" alt="Star Students"> Soeng Souy
                                            </a>
                                        </td>
                                        <td class="text-center">1185</td>
                                        <td class="text-center">98%</td>
                                        <td class="text-end">
                                            <div>2015</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xl-6 d-flex">

                <div class="card flex-fill comman-shadow">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title ">Upcoming events </h5>
                        <ul class="chart-list-out student-ellips">
                            <li class="star-menus"><a href="javascript:;"><i class="fas fa-ellipsis-v"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="activity-groups">
                            <div class="activity-awards">
                                <div class="award-boxs">
                                    <img src="assets/img/icons/award-icon-01.svg" alt="Award">
                                </div>
                                <div class="award-list-outs">
                                    <h4>Sports gala</h4>
                                    <h5>Anuall sporting gala for all classes</h5>
                                </div>
                                <div class="award-time-list">
                                    <span>12th October </span>
                                </div>
                            </div>
                            <div class="activity-awards">
                                <div class="award-boxs">
                                    <img src="assets/img/icons/award-icon-02.svg" alt="Award">
                                </div>
                                <div class="award-list-outs">
                                    <h4>PTA meeting</h4>
                                    <h5>Parent teacher meeting for all classes</h5>
                                </div>
                                <div class="award-time-list">
                                    <span>1 Month</span>
                                </div>
                            </div>
                            <div class="activity-awards">
                                <div class="award-boxs">
                                    <img src="assets/img/icons/award-icon-03.svg" alt="Award">
                                </div>
                                <div class="award-list-outs">
                                    <h4>Internation conference in "St.John School"</h4>
                                    <h5>Adminstration to attended internation conference in "St.John School"</h5>
                                </div>
                                <div class="award-time-list">
                                    <span>30th October</span>
                                </div>
                            </div>
                            <div class="activity-awards mb-0">
                                <div class="award-boxs">
                                    <img src="assets/img/icons/award-icon-04.svg" alt="Award">
                                </div>
                                <div class="award-list-outs">
                                    <h4>MDD competitions</h4>
                                    <h5>Music dance and drama competitins for all classes</h5>
                                </div>
                                <div class="award-time-list">
                                    <span>1st Decrember</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- <div class="row">
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card flex-fill fb sm-box">
                    <div class="social-likes">
                        <p>Like us on facebook</p>
                        <h6>50,095</h6>
                    </div>
                    <div class="social-boxs">
                        <img src="assets/img/icons/social-icon-01.svg" alt="Social Icon">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card flex-fill twitter sm-box">
                    <div class="social-likes">
                        <p>Follow us on twitter</p>
                        <h6>48,596</h6>
                    </div>
                    <div class="social-boxs">
                        <img src="assets/img/icons/social-icon-02.svg" alt="Social Icon">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card flex-fill insta sm-box">
                    <div class="social-likes">
                        <p>Follow us on instagram</p>
                        <h6>52,085</h6>
                    </div>
                    <div class="social-boxs">
                        <img src="assets/img/icons/social-icon-03.svg" alt="Social Icon">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card flex-fill linkedin sm-box">
                    <div class="social-likes">
                        <p>Follow us on linkedin</p>
                        <h6>69,050</h6>
                    </div>
                    <div class="social-boxs">
                        <img src="assets/img/icons/social-icon-04.svg" alt="Social Icon">
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script type="text/javascript">

      var labels =  {{ Js::from($labels) }};
      var users =  {{ Js::from($data) }};

      const data = {
        labels: labels,
        datasets: [{
          label: 'My First dataset',
          backgroundColor: 'rgb(255, 99, 132)',
          borderColor: 'rgb(255, 99, 132)',
          data: users,
        }]
      };

      const config = {
        type: 'line',
        data: data,
        options: {}
      };

      const myChart = new Chart(
        document.getElementById('myChart'),
        config
      );

</script>
<script type="text/javascript">

$(document).ready(function () {
    if ($("#apexcharts-area-chart").length > 0) {
        var options = {
            chart: { height: 350, type: "line", toolbar: { show: false } },
            dataLabels: { enabled: false },
            stroke: { curve: "smooth" },
            series: [
                {
                    name: "Teachers",
                    color: "#3D5EE1",
                    data: [45, 60, 75, 51, 42, 42, 30],
                },
                {
                    name: "Students",
                    color: "#70C4CF",
                    data: [24, 48, 56, 32, 34, 52, 25],
                },
            ],
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
            },
        };
        var chart = new ApexCharts(
            document.querySelector("#apexcharts-area-chart"),
            options
        );
        chart.render();
    }
});

</script>

@endsection
