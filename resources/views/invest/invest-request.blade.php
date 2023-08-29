@extends('layouts.app')

@section('content')
<main class="mainContent">
    <div class="container-fluid">
        <!-- page title section start -->
       <div class="page-title-row d-flex align-items-center">
            <div class="page-title-row__left">
                <h1 class="page-title-row__left__title text-capitalize">Manage Invest Request</h1>
            </div>
            <div class="page-title-row__right">
                <a href="javascript:void(0);" id="filter" class="btn btn-outline-dark btn-filter d-lg-none">
                  <i class="icon-filter"></i>
                </a>
            </div>
        </div>
        <!--start-filter form --->
        <div class="filterForm mt-lg-3" id="searchFilter">
            <div class="filterHead d-lg-none d-flex justify-content-between">
                <h3 class="h-24 font-semi">Filter</h3>
                <a href="javascript:void(0);" id="filterClose"><i class="icon-cross"></i></a>
            </div>
            <div class="flex-row justify-content-between align-items-end">
                    <div class="left">
                    <h5 class="font-md label">Search By</h5>
                    <form action="" id="pendingFilterForm">
                        <div class="filterForm__field flex-wrap">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Request ID" id="investRequestId">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Amount" id="investAmount">
                            </div>
                            <div class="form-group">
                                <div class="icon calender-icon">
                                    <input type="text" name="from" id="startDate" placeholder="Date of Invest Requested" class="form-control datetimepicker-input" data-target="#startDate" data-toggle="datetimepicker">
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
        <!--end filter form -->
        <!-- table listing start -->
        <div class="common-table">
            <div class="table-responsive">
                <table class="table" id="pendingInvest_datatable">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th><span class="sorting">User Name</span></th>
                            <th><span class="sorting">Invest Amount <i class="icon-naira"></i></span></th>
                            <th><span class="sorting">Term (In Months)</span></th>
                            <th><span class="sorting">Interest</span></th>
                            <th><span class="sorting">Maturity Amount <i class="icon-naira"></i></span></th>
                            <th><span class="sorting">Date and time of Invest Requested</span></th>
                            <th><span class="sorting">Action</span></th>
                        </tr>
                    </thead>
                    <tbody id="investList">

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
            $('#pendingInvest_datatable').DataTable({
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
                    url: SITEURL + "/admin/invest-request",
                    data: {
                        investRequestId: $('#investRequestId').val(),
                        investTerm: $('#investTerm').val(),
                        startDate: $('#startDate').val(),
                        investAmount: $('#investAmount').val(),
                    },
                    beforeSend: function(){
                        $('#investList').html('');
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
                        data: 'created_at',
                        name: 'created_at'
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
        var currentDate = moment().format('DD/MM/YYYY');
        $('#startDate, #endtDate').datetimepicker({// initialize datepicker
            useCurrent: false,
            format: "L",
            // minDate: moment(),
            ignoreReadonly: true,
        });

        $("#startDate").on("change.datetimepicker", function (e) {       // on changes start date
            $('#endtDate').datetimepicker('minDate', e.date);             // set minimum end date to fromDate
        });



        // $(".table-responsive").mCustomScrollbar();
        fillDatatable();
        $('#filter_search').click(function () {
            $('#pendingInvest_datatable').DataTable().destroy();
            fillDatatable();
        });
        $('#resetForm').click(function () {
            $('#pendingFilterForm')[0].reset();
            $('.filter-option-inner-inner').html('Term');
            $('#pendingInvest_datatable').DataTable().destroy();
            fillDatatable();
        });
    });
//===================Update Invest status=========================================

function changeInvestStatus(id,status) {
    $('#dropdown'+id).html('<div class="spinner-border" role="status"></div>');
    $.ajax({
        type: "GET",
        url: '{{ URL::To('admin/update-invest-status') }}'+'/'+id+'/'+status,
        data: {},
        success: function (response) {
            var result =  JSON.parse(response);
            if(result.success == true){
                toastr.success(result.message, '', {timeOut: 2000});
            }else{
                toastr.error(result.message, '', {timeOut: 2000});
            }
            $('#pendingInvest_datatable').DataTable().destroy();
            fillDatatable();
        }
    });
}

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

@endsection
