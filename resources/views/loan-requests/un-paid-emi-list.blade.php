@extends('layouts.app')

@section('content')
<main class="mainContent">
    <div class="container-fluid">
        <!-- page title section start -->
       <div class="page-title-row d-flex align-items-center">
            <div class="page-title-row__left">
                <h1 class="page-title-row__left__title text-capitalize">Missed EMI List</h1>
            </div>
            <div class="page-title-row__right">
                <a href="javascript:void(0);" id="filter" class="btn btn-outline-dark btn-filter d-lg-none">
                  <i class="icon-filter"></i>
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
                    <form action="" id="ratingFilterForm">
                        <div class="filterForm__field flex-wrap pr-0">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="User Name" id="userName">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Request Id" id="requestId">
                            </div>
                            <div class="btn_clumn mb-3 position-static">
                                <button type="button" class="btn btn-primary ripple-effect mr-1" data-toggle="tooltip" data-placement="top" id="filter_search" title="Search"><i class="icon-search"></i></button>
                                <button type="button" class="btn btn-outline-secondary ripple-effect" data-toggle="tooltip" data-placement="top" id="resetForm" title="Reset"><i class="icon-loop2"></i></button>
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
                <table class="table" id="emiListDataTable">
                    <thead>
                        <tr>
                            <th><span class="sorting">User Name</span></th>
                            <th><span class="sorting">#Request ID</span></th>
                            <th><span class="sorting">#EMI Number</span></th>
                            <th><span class="sorting">Amount <i class="icon-naira"></i></span></th>
                            <th><span class="sorting">EMI Date</span></th>
                            <th><span class="sorting">EMI Paid Date</span></th>
                            <th><span class="sorting">Status</th>
                            <th><span class="sorting">Action</th>
                        </tr>
                    </thead>
                    <tbody id="dataList">

                    </tbody>
                </table>
            </div>
        </div>
        <!-- table listing end -->

    </div>
</main>
<script>
    //Load loan ajax page
    function payMissedEmi(emiId) {
        $(".paybtn"+emiId).html('<div class="listloader text-center p-2 bg-white" ><span class="spinner-border" role="status"></span></div>');
        $.ajax({
            type: "GET",
            url: '{{ URL::To('admin/pay-missed-loan-emi') }}'+'/'+emiId,
            data: {},
            success: function (response) {
                var result =  JSON.parse(response);
                if(result.success == true){
                    toastr.success(result.message, '', {timeOut: 2000});
                }else{
                    toastr.error(result.message, '', {timeOut: 2000});
                }
                $('#emiListDataTable').DataTable().destroy();
                fillDatatable();
            }
        });
    }
    //===================load user list=========================================
    function fillDatatable() {
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#emiListDataTable').DataTable({
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
                    url: SITEURL + "/admin/un-paid-emi-list",
                    data: {
                        requestId: $('#requestId').val(),
                        userName: $('#userName').val()
                    },
                    beforeSend: function(){
                        $('#dataList').html('');
                    },
                    type: 'GET',
                },
                columns: [
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'request_id',
                        name: 'request_id'
                    },
                    {
                        data: 'emi_number',
                        name: 'emi_number'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'emi_date',
                        name: 'emi_date'
                    },
                    {
                        data: 'emi_paid_date',
                        name: 'emi_paid_date'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [0, 'desc']
                ]
            });

        });
    }

    $(document).ready(function () {
        $('#commissionDate').datetimepicker({// initialize datepicker
            useCurrent: false,
            format: "L",
            // minDate: moment(),
            ignoreReadonly: true,
        });
        // $(".table-responsive").mCustomScrollbar();
        fillDatatable();
        $('#filter_search').click(function () {
            $('#emiListDataTable').DataTable().destroy();
            fillDatatable();
        });
        $('#resetForm').click(function () {
            $('#ratingFilterForm')[0].reset();
            $('#emiListDataTable').DataTable().destroy();
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
</script>

@endsection
