@extends('layouts.app')

@section('content')
<main class="mainContent">
    <div class="container-fluid">
        <!-- page title section start -->
       <div class="page-title-row d-flex align-items-center">
            <div class="page-title-row__left">
                <h1 class="page-title-row__left__title text-capitalize">Manage Transaction
                </h1>
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
                    <form action="" id="transactionFilterForm">
                        <div class="filterForm__field flex-wrap">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Request Id" id="requestId">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Amount" id="amount">
                            </div>
                            <div class="form-group">
                                <div class="icon calender-icon">
                                   <input type="text" name="from" id="transactionDate" placeholder="Transaction Date" class="form-control datetimepicker-input" data-target="#transactionDate" data-toggle="datetimepicker">
                               </div>
                           </div>
                           <div class="form-group">
                                <select class="selectpicker form-control " title="Type" data-size="4" id="type">
                                    <option value="loan">Loan</option>
                                    <option value="loan_emi">Loan Emi</option>
                                    <option value="invest">Invest</option>
                                    <option value="add_money">Add Money</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="wallet">Wallet</option>
                                </select>
                            </div>
                            <div class="btn_clumn mb-3 position-static">
                                <button type="button" class="btn btn-primary ripple-effect mr-1" data-toggle="tooltip" data-placement="top" id="filter_search" title="Search"><i class="icon-search"></i></button>
                                <button type="button" class="btn btn-outline-secondary ripple-effect" data-toggle="tooltip" data-placement="top" id="resetForm" title="Reset"><i class="icon-loop2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <!--end filter form -->

        </div>
        <!-- table listing start -->
        <div class="common-table">
            <div class="table-responsive mCustomScrollbar" data-mcs-axis='x'>
                <table class="table" id="tansactionList_datatable">
                    <thead>
                        <tr>
                            <th><span class="sorting">Transaction ID</span></th>
                            <th><span class="sorting">Request ID</span></th>
                            <th><span class="sorting">Amount <i class="icon-naira"></i></span></th>
                            <th><span class="sorting">Transaction Date</span></th>
                            <th><span class="sorting">From</span></th>
                            <th><span class="sorting">To</span></th>
                            <th><span class="sorting">Type</span></th>
                        </tr>
                    </thead>
                    <tbody id="transactionList">

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
            $('#tansactionList_datatable').DataTable({
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
                    url: SITEURL + "/admin/transaction",
                    data: {
                        requestId: $('#requestId').val(),
                        transactionDate: $('#transactionDate').val(),
                        amount: $('#amount').val(),
                        type: $('#type').val(),
                    },
                    beforeSend: function(){
                        $('#transactionList').html('');
                    },
                    type: 'GET',
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'request_id',
                        name: 'request_id'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'fromId',
                        name: 'fromId'
                    },
                    {
                        data: 'toId',
                        name: 'toId'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });

        });
    }

    $(document).ready(function () {
        //Date Picker
        $('#transactionDate').datetimepicker({
            focusOnShow: false,
            format: 'L',
            //debug:true
        });
        // $(".table-responsive").mCustomScrollbar();
        fillDatatable();
        $('#filter_search').click(function () {
            $('#tansactionList_datatable').DataTable().destroy();
            fillDatatable();
        });
        $('#resetForm').click(function () {
            $('#transactionFilterForm')[0].reset();
            $('.filter-option-inner-inner').html('Type');
            $('#tansactionList_datatable').DataTable().destroy();
            fillDatatable();
        });
    });
</script>

@endsection
