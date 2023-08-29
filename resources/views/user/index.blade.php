@extends('layouts.app')

@section('content')
<main class="mainContent">
    <div class="container-fluid">
        <!-- page title section start -->
       <div class="page-title-row d-flex align-items-center">
            <div class="page-title-row__left">
                <h1 class="page-title-row__left__title text-capitalize">Manage User</h1>
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
                    <div class="filterForm__field flex-wrap pr-0">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Name" id="filter_name">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email" id="filter_email">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Mobile Number" id="filter_mobile">
                        </div>
                        <div class="btn_clumn mb-3 position-static">
                            <button type="button" class="btn btn-primary ripple-effect mr-1" data-toggle="tooltip" data-placement="top" id="filter_search" title="Search"><i class="icon-search"></i></button>
                            <button type="button" class="btn btn-outline-secondary ripple-effect" data-toggle="tooltip" data-placement="top" id="reset" title="Reset"><i class="icon-loop2"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        <!--end filter form -->
        </div>
        <!-- table listing start -->
        <div class="common-table">
            <div class="table-responsive">
                <table class="table" id="users_datatable">
                    <thead>
                        <tr>
                            <th><span class="sorting">Id</span></th>
                            <th><span class="sorting">Name</span></th>
                            <th><span class="sorting">Email</span></th>
                            <th><span class="sorting">Mobile Number</span></th>
                            <th><span class="sorting">KYC Verify</span></th>
                            <th><span class="sorting">Status</span></th>
                            <th class="w_80">Action</th>
                        </tr>
                    </thead>
                    <tbody id="userList">

                    </tbody>
                </table>
            </div>
        </div>
        <!-- table listing end -->
    </div>
</main>

<script defer src="{{ url('public/js/custom/users.js')}}"></script>
<script>
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
