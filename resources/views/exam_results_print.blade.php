<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Exam Results</title>
    <style type="text/css">
        @page{
            size: 8.3in 11.7in;
        }
        @page{
            size: A4;
        }
        .margin-bottom{
            margin-bottom: 3px;
        }
        .table-bg{
            border-collapse: collapse;
            width: 100%;
            font-size: 15px;
            text-align: center;
        }
        .th{
            border: 1px solid #000;
            padding: 10px;
        }
        .td{
            border: 1px solid #000;
            padding: 3px;
        }
        .text-container{
            text-align: left;
            padding-left: 5px;
        }
        @media print {
            @page{
                margin: 0px;
                margin-left: 20px;
                margin-right: 20px;
            }
        }
    </style>
</head>
<body>
    <div id="page">
        <table style="width: 100%; text-align:center;">
            <tr>
                <td width="5%"></td>
                <td width="15%">
                    @if ($getSetting->logo)
                    <img style="width: 100px;" src="{{ Storage::url('setting/'.$getSetting->logo) }}" alt="{{ $getSetting->website_name }}">
                    @else
                    <img style="width: 100px;" src="{{ URL::to('assets/img/logo.png') }}" alt="{{ $getSetting->website_name }}">
                    @endif
                </td>
                <td align="left">
                    <h1>{{ $getSetting->website_name }}</h1>
                </td>
            </tr>
        </table>
        <table style="width: 100%;">
            <tr>
                <td width="5%"></td>
                <td width="70%">
                    <table class="margin-bottom" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td width="27%">STUDENT NAME : </td>
                                <td style="border-bottom: 1px solid; width: 100%;">
                                    {{ $getStudent->name }} {{ $getStudent->last_name }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="margin-bottom" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td width="27%">ADMISSION NO : </td>
                                <td style="border-bottom: 1px solid; width: 100%;">
                                    {{ $getStudent->admission_number }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="margin-bottom" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td width="27%">CLASS : </td>
                                <td style="border-bottom: 1px solid; width: 100%;">{{ $getClass->class_name }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="margin-bottom" style="width: 100%;">
                        <tbody>
                            <tr>

                                <td width="11%">TERM : </td>
                                <td style="border-bottom: 1px solid; width: 80%;">
                                    {{ $getExam->name }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </td>
                <td width="5%"></td>
                <td width="20%" valign="top">
                    @if ($getStudent->avatar)
                    <img style="border-radius: 6px;" width="100px" height="100px" src="{{ Storage::url('student-photos/'.$getStudent->avatar) }}" alt="{{ $getStudent->name }}">
                    @else
                    <img style="border-radius: 6px;" width="100px" height="100px" src="{{ URL::to('assets/img/logo.png') }}" alt="{{ $getStudent->name }}">
                    @endif
                    <br>
                    GENDER : {{ $getStudent->gender }}
                </td>
            </tr>
        </table>
        <br>
        <div>
            <table
                class="table-bg">
                <thead>
                    <tr>
                        <th class="th" style="text-align: left;">Subjects</th>
                        <th class="th">Class Work</th>
                        <th class="th">Test</th>
                        <th class="th">Exam</th>
                        <th class="th">Total Score</th>
                        <th class="th">Pass Marks</th>
                        <th class="th">Full Marks</th>
                        <th class="th">Results</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                        $full_marks = 0;
                        $result_validation = 0;
                    @endphp
                    @foreach ($getExamMark as $exam)
                        @php
                            $total += $exam['total_score'];
                            $full_marks += $exam['full_marks'];
                        @endphp
                        <tr>
                            {{-- <th>
                                <div class="form-check check-tables">
                                    <input class="form-check-input" type="checkbox" value="something">
                                </div>
                            </th> --}}
                            <td class="td text-container" style="width: 250px">{{ $exam['subject_name'] }}</td>
                            <td class="td">{{ $exam['class_work'] }}</td>
                            <td class="td">{{ $exam['test'] }}</td>
                            <td class="td">{{ $exam['exam'] }}</td>
                            <td class="td">{{ $exam['total_score'] }}</td>
                            <td class="td">{{ $exam['full_marks'] }}</td>
                            <td class="td">{{ $exam['pass_mark'] }}</td>
                            <td class="td">
                                @if ($exam['total_score'] >= $exam['pass_mark'])
                                    <span class="badge bg-success" style="padding: 10px; font-weight:bold;">Pass</span>
                                @else
                                @php
                                    $result_validation = 1;
                                @endphp
                                    <span class="badge bg-danger" style="padding: 10px; font-weight:bold;">Fail</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        @php
                            $percentage = ($total * 100) / $full_marks;
                            $getGrade = App\Models\MarksGradeModel::getGrade($percentage);

                        @endphp
                        <td class="td" colspan="2">
                            <b>Grand Total : {{ $total }}/{{ $full_marks }}</b>
                        </td>
                        <td class="td" colspan="2">
                            <b>Percentage : {{ round($percentage, 2) }}%</b>
                        </td>
                        <td class="td" colspan="2">
                            <b>Grade : {{ $getGrade }}</b>
                        </td>
                        <td class="td" colspan="3">
                            <b>Result : @if ($result_validation == 0)
                                <span class="badge bg-success" style="padding: 10px;">Pass</span>
                                @else
                                <span class="badge bg-danger" style="padding: 10px; ">Fail</span>
                                @endif
                            </b>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
        <div>
            <p></p>
        </div>
        <table class="margin-bottom" style="width: 100%;">
            <tbody>
                <tr>
                    <td width="15%">SIGNATURE : </td>
                    <td style="border-bottom: 1px solid; width: 100%;"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        window.print();
    </script>

</body>
</html>
