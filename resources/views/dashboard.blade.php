@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ url('public/css/chart.min.css')}}">
<main class="mainContent dashboard-pages">
        <div class="container-fluid">
            <div class="page-title-row filter-page-btn">
                <div class="page-title-row__left">
                    <h1 class="page-title-row__left__title text-capitalize">
                        Dashboard
                    </h1>
                </div>
                <div class="right-side">
                </div>
            </div>
            <!-- counter row -->
            <div class="boxHeader mt-2">
                <h2 class="boxHeader__heading">Total Users</h2>
            </div>
            <div class="row rowSpace">
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="counterBox bg-white">
                        <div class="counterBox__icon">
                            <i class="icon-study"></i>
                        </div>
                        <div class="counterBox__item">
                            <h3>Total Users</h3>
                            <ul class="list-inline mb-0">
                                <li>
                                    <label>{{ $userCount }}</label>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ URL::To('admin/users') }}" class="counterBox__arrow d-flex align-items-center justify-content-center"><i class="icon-back-arrow"></i></a>
                    </div>
                </div>
            </div>
            <div class="boxHeader mt-2">
                <h2 class="boxHeader__heading">Total number of loans in the system</h2>
            </div>
            <div class="row rowSpace">
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="counterBox bg-white">
                        <div class="counterBox__icon">
                            <i class="icon-profits"></i>
                        </div>
                        <div class="counterBox__item">
                            <h3>Total Completed Loans</h3>
                            <ul class="list-inline mb-0">
                                <li>
                                    <label>{{ $loanRequest['completeLoan'] }}</label>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ URL::To('admin/loans') }}" class="counterBox__arrow d-flex align-items-center justify-content-center"><i class="icon-back-arrow"></i></a>
                    </div>
                </div>
                <!-- xxxxxx -->
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="counterBox bg-white">
                        <div class="counterBox__icon">
                            <i class="icon-revenue"></i>
                        </div>
                        <div class="counterBox__item">
                            <h3>Total Active Loans</h3>
                            <ul class="list-inline mb-0">
                                <li>
                                    <label>{{ $loanRequest['activeLoan'] }}</label>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ URL::To('admin/loans') }}" class="counterBox__arrow d-flex align-items-center justify-content-center"><i class="icon-back-arrow"></i></a>
                    </div>
                </div>
                <!-- xxxxxx -->
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="counterBox bg-white">
                        <div class="counterBox__icon">
                            <i class="icon-money"></i>
                        </div>
                        <div class="counterBox__item">
                            <h3>Total Rejected Loans</h3>
                            <ul class="list-inline mb-0">
                                <li>
                                    <label>{{ $loanRequest['rejectedLoan'] }}</label>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ URL::To('admin/loans') }}" class="counterBox__arrow d-flex align-items-center justify-content-center"><i class="icon-back-arrow"></i></a>
                    </div>
                </div>
                <!-- xxxxxx -->
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="counterBox bg-white">
                        <div class="counterBox__icon">
                            <i class="icon-approve-invoice"></i>
                        </div>
                        <div class="counterBox__item">
                            <h3>Total Loan amount Lenders provided to Borrower</h3>
                            <ul class="list-inline mb-0">
                                <li>
                                    <label>{{ $loanRequest['lenderAmount'] }}</label>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ URL::To('admin/loans') }}" class="counterBox__arrow d-flex align-items-center justify-content-center"><i class="icon-back-arrow"></i></a>
                    </div>
                </div>
                <!-- xxxxxx -->
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="counterBox bg-white">
                        <div class="counterBox__icon">
                            <i class="icon-study"></i>
                        </div>
                        <div class="counterBox__item">
                            <h3>Total Amount Borrower has Requested</h3>
                            <ul class="list-inline mb-0">
                                <li>
                                    <label>{{ $loanRequest['requestAmount'] }}</label>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ URL::To('admin/loans') }}" class="counterBox__arrow d-flex align-items-center justify-content-center"><i class="icon-back-arrow"></i></a>
                    </div>
                </div>
                <!-- xxxxxx -->
                {{-- <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="counterBox bg-white">
                        <div class="counterBox__icon">
                            <i class="icon-money"></i>
                        </div>
                        <div class="counterBox__item">
                            <h3>Total Amount Borrower Need To Collect From Lenders</h3>
                            <ul class="list-inline mb-0">
                                <li>
                                    <label>{{ $loanRequest['collectAmount'] }}</label>
                                </li>
                            </ul>
                        </div>
                        <a href="javascript:void(0);" class="counterBox__arrow d-flex align-items-center justify-content-center"><i class="icon-back-arrow"></i></a>
                    </div>
                </div> --}}
            </div>
            <div class="boxHeader mt-2">
                <h2 class="boxHeader__heading">Total invests in the system</h2>
            </div>
            <div class="row rowSpace">
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="counterBox bg-white">
                        <div class="counterBox__icon">
                            <i class="icon-profits"></i>
                        </div>
                        <div class="counterBox__item">
                            <h3>Total Completed Invests</h3>
                            <ul class="list-inline mb-0">
                                <li>
                                    <label>{{ $investRequest['completeInvest'] }}</label>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ URL::To('admin/invest') }}" class="counterBox__arrow d-flex align-items-center justify-content-center"><i class="icon-back-arrow"></i></a>
                    </div>
                </div>
                <!-- xxxxxx -->
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="counterBox bg-white">
                        <div class="counterBox__icon">
                            <i class="icon-revenue"></i>
                        </div>
                        <div class="counterBox__item">
                            <h3>Total Active Invests</h3>
                            <ul class="list-inline mb-0">
                                <li>
                                    <label>{{ $investRequest['activeInvest'] }}</label>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ URL::To('admin/invest') }}" class="counterBox__arrow d-flex align-items-center justify-content-center"><i class="icon-back-arrow"></i></a>
                    </div>
                </div>
                <!-- xxxxxx -->
                {{-- <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="counterBox bg-white">
                        <div class="counterBox__icon">
                            <i class="icon-discount"></i>
                        </div>
                        <div class="counterBox__item">
                            <h3>Total Rejected Invests</h3>
                            <ul class="list-inline mb-0">
                                <li>
                                    <label>{{ $investRequest['rejectedInvest'] }}</label>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ URL::To('admin/invest') }}" class="counterBox__arrow d-flex align-items-center justify-content-center"><i class="icon-back-arrow"></i></a>
                    </div>
                </div> --}}
                <!-- xxxxxx -->
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="counterBox bg-white">
                        <div class="counterBox__icon">
                            <i class="icon-money"></i>
                        </div>
                        <div class="counterBox__item">
                            <h3>Total Invests Amount</h3>
                            <ul class="list-inline mb-0">
                                <li>
                                    <label>{{ $investRequest['investAmount'] }}</label>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ URL::To('admin/invest') }}" class="counterBox__arrow d-flex align-items-center justify-content-center"><i class="icon-back-arrow"></i></a>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="counterBox bg-white">
                        <div class="counterBox__icon">
                            <i class="icon-discount"></i>
                        </div>
                        <div class="counterBox__item">
                            <h3>Total Number of Amount was matured in Last Month</h3>
                            <ul class="list-inline mb-0">
                                <li>
                                    <label>{{ $investRequest['investMaturedAmount'] }}</label>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ URL::To('admin/invest') }}" class="counterBox__arrow d-flex align-items-center justify-content-center"><i class="icon-back-arrow"></i></a>
                    </div>
                </div>
            </div>
            <!-- Total Learners -->
            <div class="row">
                <div class="col-md-12">
                    <div class="boxHeader mt-2">
                        <h2 class="boxHeader__heading">User registered Vs Month </h2>
                    </div>
                    <div class="graphBox bg-white">
                        <canvas id="registered" class="graphBox__h475"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="boxHeader d-flex align-items-center justify-content-between">
                        <h2 class="boxHeader__heading">Invests count Vs Month</h2>
                    </div>
                    <div class="graphBox bg-white">
                        <div class="graph">
                            <canvas id="fixedDeposits" class="graphBox__h475"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="boxHeader d-flex align-items-center justify-content-between">
                        <h2 class="boxHeader__heading">Loan amount Vs Month</h2>
                    </div>
                    <div class="graphBox bg-white">
                        <canvas id="loanAmount" class="graphBox__h475"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ url('public/js/chart.min.js')}}"></script>
    <script>
        var registerUser = '<?= json_encode($registerUser) ?>';
        var userCount = '<?= json_encode($userCount) ?>';
        var userCount1 = userCount%30;
        var userCount = (userCount-userCount1)+30;
        var ctx = document.getElementById("registered");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                        label: 'User Registered ',
                        backgroundColor: "#2A05A7",
                        data: JSON.parse(registerUser),
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        fontSize: 13,
                        fontColor: "#000",
                        fontFamily: "Poppins-SemiBold",
                        padding: 25,
                    }
                },
                tooltips: {
                    displayColors: true,
                    backgroundColor: '#fff',
                    bodyFontColor: '#000',
                    titleFontColor: '#000',
                    borderWidth: 1,
                    borderColor: 'rgba(0, 0, 0, 1)',
                    cornerRadius: 2,
                    callbacks: {
                        mode: 'x',
                    },
                },
                scales: {
                    xAxes: [{
                        maxBarThickness: 20,
                        stacked: true,
                        gridLines: {
                            display: false,
                        },
                        ticks: {
                            fontColor: '#000',
                            fontSize: 11,
                        }
                    }],
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true,
                            max: JSON.parse(userCount),
                            min: 0,
                            stepSize: 30,
                            fontColor: '#000',
                            fontSize: 11,
                        },
                        type: 'linear',
                    }]
                },
            }
        });

        // for total Revenue
        var investMonthCount = '<?= json_encode($investMonthCount) ?>';
        var totalInvestCount = '<?= json_encode($investRequest["totalInvestCount"]) ?>';
        var totalInvestCount1 = totalInvestCount%30;
        var totalInvestCount = (totalInvestCount-totalInvestCount1)+30;
        var ctx = document.getElementById("fixedDeposits").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                        label: 'Fixed Deposits',
                        backgroundColor: "#02F0A1",
                        data: JSON.parse(investMonthCount),

                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        fontSize: 13,
                        fontColor: "#000",
                        fontFamily: "Poppins-SemiBold",
                        padding: 25,
                    }
                },
                tooltips: {
                    displayColors: true,
                    backgroundColor: '#fff',
                    bodyFontColor: '#000',
                    titleFontColor: '#000',
                    borderWidth: 1,
                    borderColor: 'rgba(0, 0, 0, 1)',
                    cornerRadius: 2,
                    callbacks: {
                        mode: 'x',
                    },
                },
                scales: {
                    xAxes: [{
                        maxBarThickness: 20,
                        stacked: true,
                        gridLines: {
                            display: false,
                        },
                        ticks: {
                            fontColor: '#000',
                            fontSize: 11,
                        }
                    }],
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true,
                            max: JSON.parse(totalInvestCount),
                            min: 0,
                            stepSize: 30,
                            fontColor: '#000',
                            fontSize: 11,
                        },
                        type: 'linear',
                    }]
                },
            }
        });

        // Total  Commission
        var loanMonthCount = '<?= json_encode($loanMonthCount) ?>';
        var totalLoanCount = '<?= json_encode($loanRequest["totalLoanCount"]) ?>';
        var totalLoanCount1 = totalLoanCount%30;
        var totalLoanCount = (totalLoanCount-totalLoanCount1)+30;
        var ctx = document.getElementById("loanAmount").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: 'Loan amount ',
                    backgroundColor: "#FF4D0E",
                    data: JSON.parse(loanMonthCount),
                },],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 25,
                        fontSize: 13,
                        fontColor: "#000",
                        fontFamily: "Poppins-SemiBold",
                    }
                },
                tooltips: {
                    displayColors: true,
                    backgroundColor: '#fff',
                    bodyFontColor: '#000',
                    titleFontColor: '#000',
                    borderWidth: 1,
                    borderColor: 'rgba(0, 0, 0, 1)',
                    cornerRadius: 2,
                    callbacks: {
                        mode: 'x',
                    },
                },
                scales: {
                    xAxes: [{
                        maxBarThickness: 20,
                        stacked: true,
                        gridLines: {
                            display: false,
                        },
                        ticks: {
                            fontColor: '#000',
                            fontSize: 11,
                        }
                    }],
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true,
                            max: JSON.parse(totalLoanCount),
                            min: 0,
                            stepSize: 30,
                            fontColor: '#000',
                            fontSize: 11,
                        },
                        type: 'linear',
                    }]
                },
            }
        });
    </script>
@endsection
