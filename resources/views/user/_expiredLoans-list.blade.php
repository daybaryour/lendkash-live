<!--start filter-->
<div class="filterForm mt-lg-3" id="searchFilter">
    <div class="filterHead d-lg-none d-flex justify-content-between">
        <h3 class="h-24 font-semi">Filter</h3>
        <a href="javascript:void(0);" id="filterClose"><i class="icon-cross"></i></a>
    </div>
    <div class="flex-row justify-content-between align-items-end">
        <div class="left">
            <h5 class="font-md label">Search By</h5>
            <form action="" id="waitingFilterForm">
                <div class="filterForm__field flex-wrap">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Loan Request ID" id="loanRequestId">
                    </div>
                    <div class="form-group">
                        <div class="icon calender-icon">
                            <input type="text" name="from" id="loanRequestDate" placeholder="Loan Requested Date" class="form-control datetimepicker-input" data-target="#loanRequestDate" data-toggle="datetimepicker">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="icon calender-icon">
                            <input type="text" name="from" id="loanExpiredDate" placeholder="Loan Expiry Date" class="form-control datetimepicker-input" data-target="#loanExpiredDate" data-toggle="datetimepicker">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Loan Interest" id="loanInterest">
                    </div>
                    {{-- <div class="form-group">
                        <input type="text" class="form-control" placeholder="Monthly EMI" id="LoanEMI">
                    </div> --}}
                    <div class="btn_clumn mb-3">
                        <button type="button" class="btn btn-primary ripple-effect mr-1" data-toggle="tooltip" data-placement="top" id="filter_search" title="Search"><i class="icon-search"></i></button>
                        <button type="button" class="btn btn-outline-secondary ripple-effect" data-toggle="tooltip" data-placement="top" title="Reset" id="resetForm"><i class="icon-loop2"></i></button>
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
        <table class="table" id="expiredLoan_datatable">
            <thead>
                <tr>
                    <th><span class="sorting">#ID</span></th>
                    <th><span class="sorting">User Name</span></th>
                    <th><span class="sorting">Loan Amount Request<i class="icon-naira"></i></span></th>
                    <th><span class="sorting">Loan Amount Received<i class="icon-naira"></i></span></th>
                    <th><span class="sorting">Loan Interest</span></th>
                    <th><span class="sorting">Loan Terms (In Months)</span></th>
                    {{-- <th><span class="sorting">Monthly EMI <i class="icon-naira"></i></span></th> --}}
                    <th><span class="sorting">Total EMI</span></th>
                    <th><span class="sorting">Payment Frequency</span></th>
                    <th><span class="sorting">Requested Date and Time</span></th>
                    <th><span class="sorting">Expiry Date and Time</span></th>
                    <th><span class="sorting">Percentage of Amount Received (%)</span></th>
                    <th><span class="sorting">Lenders</span></th>
                </tr>
            </thead>
            <tbody id="requestList"></tbody>
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
                $('#expiredLoan_datatable').DataTable({
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
                            loanRequestDate: $('#loanRequestDate').val(),
                            LoanEMI: $('#LoanEMI').val(),
                            loanExpiredDate: $('#loanExpiredDate').val(),
                            loan_status: 'expired'
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
                            data: 'loan_term',
                            name: 'loan_term'
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
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'request_expiry_date',
                            name: 'request_expiry_date'
                        },
                        {
                            data: 'received_amount_percent',
                            name: 'received_amount_percent'
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
                $('#expiredLoan_datatable').DataTable().destroy();
                fillDatatable();
            });
            $('#resetForm').click(function () {
                $('#waitingFilterForm')[0].reset();
                $('#expiredLoan_datatable').DataTable().destroy();
                fillDatatable();
            });
        });
        // $(".table-responsive").mCustomScrollbar();
        $('.selectpicker').selectpicker();
        var currentDate = moment().format('DD/MM/YYYY');
        $('#loanRequestDate, #loanExpiredDate').datetimepicker({// initialize datepicker
            useCurrent: false,
            format: "L",
            // minDate: moment(),
            ignoreReadonly: true,
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
