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
                <h2>User Report</h2>
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
                    <form action="" id="userFilterForm">
                        <div class="filterForm__field flex-wrap">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Name" id="name">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email" id="email">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Mobile Number" id="mobile">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="BVN" id="bvn">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Location" id="location">
                            </div>
                            <div class="btn_clumn mb-3">
                                <button type="button" class="btn btn-primary ripple-effect mr-1" data-toggle="tooltip" data-placement="top" title="Search" id="userFilter"><i class="icon-search"></i></button>
                                <button type="button" class="btn btn-outline-secondary ripple-effect" data-toggle="tooltip" data-placement="top" id="userResetForm" title="Reset"><i class="icon-loop2"></i></button>
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
                <table class="table" id="userReport_datatable">
                    <thead>
                        <tr>
                            <th><span class="sorting">Id</span></th>
                            <th><span class="sorting">Name</span></th>
                            <th><span class="sorting">Email</span></th>
                            <th><span class="sorting">Mobile Number</span></th>
                            <th><span class="sorting">BVN</span></th>
                            <th><span class="sorting">Bank Name</span></th>
                            <th><span class="sorting">Employment</span></th>
                            <th><span class="sorting">Location</span></th>
                            <th><span class="sorting">Total Loans</span></th>
                            <th><span class="sorting">Total Invests <i class="icon-naira"></i></span></th>
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
            $('#userReport_datatable').DataTable({
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
                    url: SITEURL + "/admin/user-report",
                    data: {
                        name: $('#name').val(),
                        email: $('#email').val(),
                        mobile: $('#mobile').val(),
                        bvn: $('#bvn').val(),
                        location: $('#location').val(),
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
                        data: 'bvn',
                        name: 'bvn'
                    },
                    {
                        data: 'bank_name',
                        name: 'bank_name'
                    },
                    {
                        data: 'employer_detail',
                        name: 'employer_detail'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'user_loan_count_count',
                        name: 'user_loan_count_count'
                    },
                    {
                        data: 'invest_loan_count_count',
                        name: 'invest_loan_count_count'
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
        $('#userFilter').click(function () {
            $('#userReport_datatable').DataTable().destroy();
            fillDatatable();
        });
        $('#userResetForm').click(function () {
            $('#userFilterForm')[0].reset();
            $('#userReport_datatable').DataTable().destroy();
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
        mobile = $('#mobile').val();
        locationData = $('#location').val();
        bvn = $('#bvn').val();
        window.location.href="{{ URL::To('export-user-report')}}?name="+name+"&email="+email+"&mobile="+mobile+"&bvn="+bvn+"&location="+locationData;

    });
</script>

@endsection
