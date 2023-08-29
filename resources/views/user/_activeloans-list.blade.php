<!--start filter-->
<div class="filterForm mt-lg-3" id="searchFilter">
    <div class="filterHead d-lg-none d-flex justify-content-between">
        <h3 class="h-24 font-semi">Filter</h3>
        <a href="javascript:void(0);" id="filterClose"><i class="icon-cross"></i></a>
    </div>
    <div class="flex-row justify-content-between align-items-end">
        <div class="left">
            <h5 class="font-md label">Search By</h5>
            <form action="" id="activeFilterForm">
                <div class="filterForm__field flex-wrap pr-0">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Loan Request ID" id="loanRequestId">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Loan Interest" id="loanInterest">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Loan Amount" id="loanAmount">
                    </div>
                    <div class="form-group">
                        <div class="icon calender-icon">
                           <input type="text" name="from" id="previous_emi_date" placeholder="Previous Payment Date" class="form-control datetimepicker-input" data-target="#previous_emi_date" data-toggle="datetimepicker" >
                       </div>
                    </div>
                    <div class="form-group">
                        <div class="icon calender-icon">
                           <input type="text" name="from" id="next_emi_date" placeholder="Next EMI Due Date" class="form-control datetimepicker-input" data-target="#next_emi_date" data-toggle="datetimepicker" >
                       </div>
                    </div>
                    <div class="form-group">
                        <div class="icon calender-icon">
                           <input type="text" name="from" id="emi_start_date" placeholder="EMI start Date" class="form-control datetimepicker-input" data-target="#emi_start_date" data-toggle="datetimepicker" >
                       </div>
                    </div>
                    <div class="form-group">
                        <div class="icon calender-icon">
                           <input type="text" name="from" id="emi_end_date" placeholder="EMI End Date" class="form-control datetimepicker-input" data-target="#emi_end_date" data-toggle="datetimepicker" >
                       </div>
                   </div>

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Monthly/Weekly EMI" id="LoanEMI">
                    </div>
                    <div class="btn_clumn mb-3 position-sticky">
                        <button type="button" class="btn btn-primary ripple-effect mr-1" data-toggle="tooltip" id="filter_search" data-placement="top" title="Search"><i class="icon-search"></i></button>
                        <button type="button" class="btn btn-outline-secondary ripple-effect" data-toggle="tooltip" id="resetForm" data-placement="top" title="Reset"><i class="icon-loop2"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end filter-->
<div class="page-title-row d-flex align-items-center justify-content-end m-lg-0">
    <div class="page-title-row__right">
        <a href="javascript:void(0);" id="filter" class="btn btn-outline-dark btn-filter d-lg-none mt-3 mt-lg-0">
          <i class="icon-filter"></i>
        </a>
    </div>
</div>
<div class="common-table">
    <div class="table-responsive">
        <table class="table" id="activeLoan_datatable">
            <thead>
                <tr>
                    <th><span class="sorting">#ID</span></th>
                    <th><span class="sorting">User Name</span></th>
                    <th><span class="sorting" >Loan Amount Requested <i class="icon-naira"></i></span></th>
                    <th><span class="sorting" >Loan Amount <i class="icon-naira"></i></span></th>
                    <th><span class="sorting">Loan Interest</span></th>
                    <th><span class="sorting">Loan Amount with Interest <i class="icon-naira"></i></span></th>
                    <th><span class="sorting">Loan Terms (In Months)</span></th>
                    <th><span class="sorting">Monthly/Weekly EMI</span></th>
                    <th><span class="sorting">Previous Payment Date</span></th>
                    <th><span class="sorting">Next EMI Due Date</span></th>
                    <th><span class="sorting">EMI start Date</span></th>
                    <th><span class="sorting">EMI End Date</span></th>
                    <th><span class="sorting">Paid EMIs</span></th>
                    <th><span class="sorting">EMI Left</span></th>
                    <th><span class="sorting">EMI Remaining Amount <i class="icon-naira"></i></span></th>
                    <th><span class="sorting">Total EMI </span></th>
                    <th><span>Lenders List </span></th>
                </tr>
            </thead>
            <tbody id="requestList">

            </tbody>
        </table>
    </div>
</div>
<!-- table listing end -->
<script>
    //===================load user list=========================================
    function fillDatatable() {
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#activeLoan_datatable').DataTable({
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
                    url: SITEURL + "/admin/load-loan-request",
                    data: {
                        user_id: $('#userId').val(),
                        loanRequestId: $('#loanRequestId').val(),
                        loanInterest: $('#loanInterest').val(),
                        loanTerm: $('#loanTerm').val(),
                        LoanEMI: $('#LoanEMI').val(),
                        loanAmount: $('#loanAmount').val(),
                        previous_emi_date: $('#previous_emi_date').val(),
                        next_emi_date: $('#next_emi_date').val(),
                        emi_start_date: $('#emi_start_date').val(),
                        emi_end_date: $('#emi_end_date').val(),
                        loan_status: 'active'
                    },
                    beforeSend: function(){
                        $('#requestList').html('');
                    },
                    type: 'GET',
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'loan_request_amount',
                        name: 'loan_request_amount'
                    },
                    {
                        data: 'received_amount',
                        name: 'received_amount'
                    },
                    {
                        data: 'loan_interest_rate',
                        name: 'loan_interest_rate'
                    },
                    {
                        data: 'loan_amount_with_interest',
                        name: 'loan_amount_with_interest'
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
                        data: 'last_emi_date',
                        name: 'last_emi_date'
                    },
                    {
                        data: 'next_emi_date',
                        name: 'next_emi_date'
                    },
                    {
                        data: 'loan_start_date',
                        name: 'loan_start_date'
                    },
                    {
                        data: 'loan_end_date',
                        name: 'loan_end_date'
                    },
                    {
                        data: 'paid_emis',
                        name: 'paid_emis'
                    },
                    {
                        data: 'emi_left',
                        name: 'emi_left'
                    },
                    {
                        data: 'emi_remaining_amount',
                        name: 'emi_remaining_amount'
                    },
                    {
                        data: 'total_emi',
                        name: 'total_emi'
                    },
                    {
                        data: 'action',
                        name: 'action',
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
        // $(".table-responsive").mCustomScrollbar();
        fillDatatable();
        $('#filter_search').click(function () {
            $('#activeLoan_datatable').DataTable().destroy();
            fillDatatable();
        });
        $('#resetForm').click(function () {
            $('#activeFilterForm')[0].reset();
            $('#activeLoan_datatable').DataTable().destroy();
            fillDatatable();
        });
    });
    // $(".table-responsive").mCustomScrollbar();
     // view lender
    function lenderView() {
        $("#lenderList").modal('show');
    }
    var currentDate = moment().format('DD/MM/YYYY');
    $('#previous_emi_date, #next_emi_date, #emi_start_date, #emi_end_date').datetimepicker({// initialize datepicker
        useCurrent: false,
        format: "L",
        // minDate: moment(),
        ignoreReadonly: true,
    });

    $("#emi_start_date").on("change.datetimepicker", function (e) {       // on changes start date
        $('#emi_end_date').datetimepicker('minDate', e.date);             // set minimum end date to fromDate
    });

    $("#emi_end_date").on("change.datetimepicker", function (e) {             // on changes of end date
        $('#emi_start_date').datetimepicker('maxDate', e.date);               // start date's mamimux date set to end date
    });

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
</script>


