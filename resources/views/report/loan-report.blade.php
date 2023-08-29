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
                <h2>Loan Report</h2>
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
                    <form action="" id="loanFilterForm">
                        <div class="filterForm__field flex-wrap pr-0">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Loan Request ID" id="requestId">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Loan Amount" id="amount">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Loan Terms" id="term">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Loan Interest" id="interest">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Monthly/Weekly EMI" id="LoanEMI">
                                </div>
                                <div class="form-group">
                                    <select class="selectpicker form-control " title="Payment Frequency" data-size="4" id="paymentFrequency">
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                    </select>
                                </div>
                            <div class="btn_clumn mb-3 position-static">
                                <button type="button" class="btn btn-primary ripple-effect mr-1" data-toggle="tooltip" data-placement="top" title="Search" id="loanFilter"><i class="icon-search"></i></button>
                                <button type="button" class="btn btn-outline-secondary ripple-effect" data-toggle="tooltip" data-placement="top" id="loanResetForm" title="Reset"><i class="icon-loop2"></i></button>
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
                <table class="table" id="loanReport_datatable">
                    <thead>
                        <tr>
                            <th><span class="sorting">Loan Request ID</span></th>
                            <th><span class="sorting">Loan Amount <i class="icon-naira"></i></span></th>
                            <th><span class="sorting">Loan Interest</span></th>
                            <th><span class="sorting">Loan Terms</span></th>
                            <th><span class="sorting">Monthly/Weekly EMI <i class="icon-naira"></i></span></th>
                            <th><span class="sorting">Total EMI</span></th>
                            <th><span class="sorting">Payment Frequency</span></th>
                            <th><span class="sorting">Description</span></th>
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
            $('#loanReport_datatable').DataTable({
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
                    url: SITEURL + "/admin/loan-report",
                    data: {
                        requestId: $('#requestId').val(),
                        amount: $('#amount').val(),
                        term: $('#term').val(),
                        interest: $('#interest').val(),
                        LoanEMI: $('#LoanEMI').val(),
                        paymentFrequency: $('#paymentFrequency').val(),
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
                        data: 'loan_request_amount',
                        name: 'loan_request_amount'
                    },
                    {
                        data: 'loan_interest_rate',
                        name: 'loan_interest_rate'
                    },
                    {
                        data: 'loan_term',
                        name: 'loan_term'
                    },
                    {
                        data: 'emi_amount',
                        name: 'emi_amount'
                    },
                    {
                        data: 'total_emi',
                        name: 'total_emi'
                    },
                    {
                        data: 'payment_frequency',
                        name: 'payment_frequency'
                    },
                    {
                        data: 'loan_description',
                        name: 'loan_description'
                    },
                    {
                        data: 'loan_status',
                        name: 'loan_status'
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });

        });
    }

    $(document).ready(function () {
        // $(".table-responsive").mCustomScrollbar();
        fillDatatable();
        $('#loanFilter').click(function () {
            $('#loanReport_datatable').DataTable().destroy();
            fillDatatable();
        });
        $('#loanResetForm').click(function () {
            $('#loanFilterForm')[0].reset();
            $('.filter-option-inner-inner').html('Payment Frequency');
            $('#loanReport_datatable').DataTable().destroy();
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
        requestId = $('#requestId').val();
        amount = $('#amount').val();
        term = $('#term').val();
        interest = $('#interest').val();
        LoanEMI = $('#LoanEMI').val();
        paymentFrequency = $('#paymentFrequency').val();
        window.location.href="{{ URL::To('export-loan-report')}}?requestId="+requestId+"&amount="+amount+"&term="+term+"&interest="+interest+"&LoanEMI="+LoanEMI+"&paymentFrequency="+paymentFrequency;

    });
</script>

@endsection
