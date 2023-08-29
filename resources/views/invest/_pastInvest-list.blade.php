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
                <div class="filterForm__field flex-wrap">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Request ID" id="investRequestId">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Amount" id="investAmount">
                    </div>
                    <div class="form-group">
                        <div class="icon calender-icon">
                            <input type="text" name="from" id="startDate" placeholder="Date of Invest Deposit" class="form-control datetimepicker-input" data-target="#startDate" data-toggle="datetimepicker">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="icon calender-icon">
                            <input type="text" name="from" id="endDate" placeholder="Date of Maturity" class="form-control datetimepicker-input" data-target="#endDate" data-toggle="datetimepicker">
                        </div>
                    </div>
                    <div class="form-group">
                        <select class="selectpicker form-control " title="Term" data-size="4" id="investTerm">
                            <option value="6">Half yearly</option>
                            <option value="12">Yearly</option>
                        </select>
                    </div>
                    <div class="btn_clumn mb-3">
                        <button type="button" class="btn btn-primary ripple-effect mr-1" data-toggle="tooltip" id="filter_search" data-placement="top" title="Search"><i class="icon-search"></i></button>
                        <button type="button" class="btn btn-outline-secondary ripple-effect" data-toggle="tooltip" id="resetForm" data-placement="top" title="Reset"><i class="icon-loop2"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="common-table">
    <div class="table-responsive">
        <table class="table" id="activeInvest_datatable">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th><span class="sorting">User Name</span></th>
                    <th><span class="sorting">Invest Amount <i class="icon-naira"></i></span></th>
                    <th><span class="sorting">Term (In Months)</span></th>
                    <th><span class="sorting">Interest</span></th>
                    <th><span class="sorting">Maturity Amount <i class="icon-naira"></i></span></th>
                    <th><span class="sorting">Date and time of Invest Deposit</span></th>
                    <th><span class="sorting">Date and time of Maturity</span></th>
                </tr>
            </thead>
            <tbody id="investDataList">

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
            $('#activeInvest_datatable').DataTable({
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
                    url: SITEURL + "/admin/load-invest-request",
                    data: {
                        investRequestId: $('#investRequestId').val(),
                        investTerm: $('#investTerm').val(),
                        startDate: $('#startDate').val(),
                        endDate: $('#endDate').val(),
                        investAmount: $('#investAmount').val(),
                        status: 'completed',
                    },
                    beforeSend: function(){
                        $('#investDataList').html('');
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
                    }
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
            $('#activeInvest_datatable').DataTable().destroy();
            fillDatatable();
        });
        $('#resetForm').click(function () {
            $('#activeFilterForm')[0].reset();
            $('.filter-option-inner-inner').html('Term');
            $('#activeInvest_datatable').DataTable().destroy();
            fillDatatable();
        });
    });
    // $(".table-responsive").mCustomScrollbar();
    $('.selectpicker').selectpicker();
    var currentDate = moment().format('DD/MM/YYYY');
    $('#startDate, #endDate').datetimepicker({// initialize datepicker
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


