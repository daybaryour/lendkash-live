@extends('layouts.app')
@section('content')
<main class="mainContent detailPage">
    <div class="container-fluid">
        <!-- page title section start -->
        <div class="page-title-row d-flex">
            <div class="page-title-row__left">
                <h1 class="page-title-row__left__title text-capitalize">Manage Invest</h1>
            </div>
            <div class="page-title-row__right mt-0">
                <a href="javascript:void(0);" id="filter" class="btn btn-outline-dark btn-filter d-lg-none">
                    <i class="icon-filter"></i>
                </a>
            </div>
        </div>
        <!--start-filter form --->
        <div class="custom-tabs mb-2 mb-lg-0">
            <ul class="nav nav-tabs d-md-flex nav-fill" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="javascript:void(0);" role="tab" onclick="loadInvestAjaxPage('approved')" aria-controls="currentInvest" aria-selected="true"> Current Invest </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="javascript:void(0);" onclick="loadInvestAjaxPage('completed')" role="tab" aria-selected="false">Past Invest</a>
                </li>
            </ul>
        </div>

        <div id="investList"></div>
    </div>
</main>

<script>
//===================Update KYC status=========================================
        $(document).ready(function () {
            loadInvestAjaxPage('approved');
        });
        //Load loan ajax page
        function loadInvestAjaxPage(status) {
            $("#investList").html('<div class="listloader text-center p-2 bg-white" ><span class="spinner-border" role="status"></span></div>');
            $.ajax({
                type: "GET",
                url: '{{ URL::To('admin/load-invest-ajax-page') }}'+'/'+status,
                data: {},
                success: function (response) {
                    $("#investList").hide().html(response).fadeIn('1000');
                    $('html,body').animate({
                        scrollTop: $("#investList").offset().top},
                        'slow');
                }
            });
        }
        //===================Update Loan status=========================================

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
                    loadInvestAjaxPage('approved');
                }
            });
        }
    </script>
@endsection
