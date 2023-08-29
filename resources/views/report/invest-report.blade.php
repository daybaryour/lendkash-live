@extends('layouts.app')

@section('content')
<main class="mainContent">
    <div class="container-fluid">
        <!-- page title section start -->
    <div class="page-title-row d-flex">
            <div class="page-title-row__left page-title-row__left--subtittle">
                <h1 class="page-title-row__left__title text-capitalize">
                    Manage Report
                </h1>
                <h2>Invest Report</h2>
            </div>
            <div class="page-title-row__right mt-0">
                <a href="javascript:void(0);" id="filter" class="btn btn-outline-dark btn-filter d-lg-none">
                <i class="icon-filter"></i>
                </a>
                <a href="javascript:void(0);" id="exportReport" class="btn btn-outline-secondary btn-filter" data-toggle="tooltip" data-placement="top" title="Download Report">
                <i class="icon-cloud"></i>
                </a>
            </div>
        </div>
        <!--start-filter form --->
        <div class="filterForm" id="searchFilter">
            <div class="filterHead d-lg-none d-flex justify-content-between">
                <h3 class="h-24 font-semi">Filter</h3>
                <a href="javascript:void(0);" id="filterClose"><i class="icon-cross"></i></a>
            </div>
            <div class="flex-row justify-content-between align-items-end">
                <div class="left">
                    <h5 class="font-md label">Search By</h5>
                    <form action="" id="investFilterForm">
                        <div class="filterForm__field flex-wrap pr-0">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Name" id="name" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email" id="email" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Mobile Number" id="mobile" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Amount" id="amount" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <div class="icon calender-icon">
                                   <input type="text" name="from" id="startDate" placeholder="Date of Invest" class="form-control datetimepicker-input" data-target="#startDate" data-toggle="datetimepicker" autocomplete="off">
                               </div>
                            </div>
                            <div class="form-group">
                                <div class="icon calender-icon">
                                   <input type="text" name="from" id="endDate" placeholder="Date of Maturity" class="form-control datetimepicker-input" data-target="#endDate" data-toggle="datetimepicker" autocomplete="off">
                               </div>
                            </div>
                             <div class="form-group">
                                <select class="selectpicker form-control " title="Status" data-size="4" id="status">
                                    <option value="pending">Pending</option>
                                    <option value="approved">approved</option>
                                    <option value="completed">Completed</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="btn_clumn mb-3 position-static">
                                <button type="button" class="btn btn-primary ripple-effect mr-1" data-toggle="tooltip" data-placement="top" title="Search" id="investFilter"><i class="icon-search"></i></button>
                                <button type="button" class="btn btn-outline-secondary ripple-effect" data-toggle="tooltip" data-placement="top" id="investResetForm" title="Reset"><i class="icon-loop2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end filter form -->
        <!-- table listing start -->
        <div class="common-table">
            <div class="table-responsive">
                <table class="table" id="investReport_datatable">
                    <thead>
                        <tr>
                            <th><span class="sorting">Id</span></th>
                            <th><span class="sorting">Name</span></th>
                            <th><span class="sorting">Email</span></th>
                            <th><span class="sorting">Mobile Number</span></th>
                            <th><span class="sorting">Amount <i class="icon-naira"></i></span></th>
                            <th><span class="sorting">Term</span></th>
                            <th><span class="sorting">Interest</span></th>
                            <th><span class="sorting">Maturity Amount <i class="icon-naira"></i></span></th>
                            <th><span class="sorting">Date and time of Invest Deposit</span></th>
                            <th><span class="sorting">Date and time of Maturity</span></th>
                            {{-- <th><span class="sorting">Total Amount including interest <i class="icon-naira"></i></span></th> --}}
                            <th><span class="sorting">Status</span></th>
                        </tr>
                    </thead>
                    <tbody id="reportList">

                    </tbody>
                </table>
            </div>
        </div>
        <!-- table listing end -->
    </div>
</main>

<script>
    //===================load user list=========================================
    function fillDatatable() {
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#investReport_datatable').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                lengthMenu: false,
                lengthChange: false,
                "info":     false,
                responsive: true,
                oLanguage: {
                    sProcessing: '<tr><td class="listloader text-center" colspan="6"><div class="spinner-border" role="status"></div> </td></tr>',
                    oPaginate: {
                        sNext: '<i class="icon-right-arrow"></i>',
                        sPrevious: '<i class="icon-left-arrow"></i>'
                    },
                    sEmptyTable: '<div class="alert alert-danger" role="alert">No Data Found</div>'
                },
                ajax: {
                    url: SITEURL + "/admin/invest-report",
                    data: {
                        name: $('#name').val(),
                        email: $('#email').val(),
                        mobile: $('#mobile').val(),
                        amount: $('#amount').val(),
                        startDate: $('#startDate').val(),
                        endDate: $('#endDate').val(),
                        status: $('#status').val(),
                    },
                    beforeSend: function(){
                        $('#reportList').html('');
                    },
                    type: 'GET',
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'mobile_number',
                        name: 'mobile_number'
                    },
                    {
                        data: 'invest_amount',
                        name: 'invest_amount'
                    },
                    {
                        data: 'invests_term',
                        name: 'invests_term'
                    },
                    {
                        data: 'interest_rate',
                        name: 'interest_rate'
                    },
                    {
                        data: 'maturity_amount',
                        name: 'maturity_amount'
                    },
                    {
                        data: 'invest_start_date',
                        name: 'invest_start_date'
                    },
                    {
                        data: 'invest_end_date',
                        name: 'invest_end_date'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });

        });
    }

    $(document).ready(function () {
        var currentDate = moment().format('DD/MM/YYYY');
        $('#startDate, #endDate').datetimepicker({// initialize datepicker
            useCurrent: false,
            format: "L",
            // minDate: moment(),
            ignoreReadonly: true,
        });

        $("#startDate").on("change.datetimepicker", function (e) {       // on changes start date
            $('#endDate').datetimepicker('minDate', e.date);             // set minimum end date to fromDate
        });

        $("#endDate").on("change.datetimepicker", function (e) {             // on changes of end date
            $('#startDate').datetimepicker('maxDate', e.date);               // start date's mamimux date set to end date
        });




        // $(".table-responsive").mCustomScrollbar();
        fillDatatable();
        $('#investFilter').click(function () {
            $('#investReport_datatable').DataTable().destroy();
            fillDatatable();
        });
        $('#investResetForm').click(function () {
            $('#investFilterForm')[0].reset();
            $('button[data-id="status"] .filter-option-inner-inner').html('Status');
            $('#investReport_datatable').DataTable().destroy();
            fillDatatable();
        });
    });
    // $(".table-responsive").mCustomScrollbar();
    //fiter Open Close
    $('#filter').on('click', function (e) {
        $('.filterForm').addClass("filterForm--open");
        e.preventDefault();
        if (screen.width < 992) {
            $(".filterForm__field").mCustomScrollbar();
        }
    });
    //
    $('#filterClose').on('click', function (e) {
        $('.filterForm').removeClass("filterForm--open");
        e.preventDefault();
    });
    // Export Report
    $('#exportReport').on('click', function (e) {
        name = $('#name').val();
        email = $('#email').val();
        amount = $('#amount').val();
        mobile = $('#mobile').val();
        startDate = $('#startDate').val();
        endDate = $('#endDate').val();
        status = $('#status').val();
        window.location.href="{{ URL::To('export-invest-report')}}?name="+name+"&email="+email+"&amount="+amount+"&mobile="+mobile+"&startDate="+startDate+"&endDate="+endDate+"&status="+status;

    });
</script>

@endsection
