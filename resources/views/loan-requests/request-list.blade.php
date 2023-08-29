@extends('layouts.app')
@section('content')
<main class="mainContent detailPage">
    <div class="container-fluid">
        <h2 class="h-20 font-semi topHead">Manage Loan</h2>
        <div class="custom-tabs">
            <ul class="nav nav-tabs d-lg-flex nav-fill" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="javascript:void(0);" onclick="loadLoanAjaxPage('pending')" role="tab" aria-selected="false">Under Approval</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="javascript:void(0);" role="tab" onclick="loadLoanAjaxPage('active')" aria-controls="activeLoans" aria-selected="true">Active Loans</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="javascript:void(0);" role="tab"
                    onclick="loadLoanAjaxPage('waiting')" aria-selected="false">Loan Waiting</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="javascript:void(0);" onclick="loadLoanAjaxPage('cancelled')" role="tab" aria-selected="false">Cancelled Loans</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="javascript:void(0);" onclick="loadLoanAjaxPage('rejected')" role="tab" aria-selected="false">Rejected Loans</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="javascript:void(0);" onclick="loadLoanAjaxPage('completed')" role="tab" aria-selected="false">Completed Loans</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="javascript:void(0);" onclick="loadLoanAjaxPage('expired')" role="tab" aria-selected="false">Expired Loans</a>
                </li>
            </ul>
        </div>
        <div id="loanList"></div>

    </div>
</main>
<!--End Category Odering  -->
<div class="modal fade" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog" id="lenderListModel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="icon-cross"></i>
                </button>
            </div>
            <div class="modal-body pt-3">
                <div class="modal-heading">
                    <h2>Lenders List</h2>
                </div>
                    <!-- table listing start -->
                <div class="common-table">
                    <div class="table-responsive" id="lenderList">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- table listing end -->
<!--Approve-loan-request-->
<div class="modal fade " data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog" id="approveLoan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="modal-heading">
                    <h4>Are you sure you want to approve this loan.</h4>
                </div>
                <div class="btn-row mt-30">
                    <button class="btn btn-outline-secondary width-120 ripple-effect text-uppercase" data-dismiss="modal">NO</button>
                    <button class="btn btn-primary width-120 ripple-effect text-uppercase">YES</button>
                </div>
            </div>

        </div>
    </div>
</div>
<!--approve loan request-->
 <!--Approve-loan-request-->
<div class="modal fade " data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog" id="rejectLoan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="modal-heading">
                    <h4>Are you sure you want to reject this loan.</h4>
                </div>
                <div class="btn-row mt-30">
                    <button class="btn btn-outline-secondary width-120 ripple-effect text-uppercase" data-dismiss="modal">NO</button>
                    <button class="btn btn-primary width-120 ripple-effect text-uppercase">YES</button>
                </div>
            </div>

        </div>
    </div>
</div>
<!--approve loan request-->

<script>
//===================Update KYC status=========================================
        $(document).ready(function () {
            loadLoanAjaxPage('pending');
        });
        function updateKycStatus(id, status) {
            url = $('#myonoffswitch' + id).data('url') + '/' + id + '/' + status;
            $.ajax({
                type: 'get',
                url: url,
                dataType: "json",
                success: function (data) {
                    if (data.success == 'yes') {
                        toastr.success(data.message, '', {
                            timeOut: 2000
                        });
                        location.reload();
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        }
        //Load loan ajax page
        function loadLoanAjaxPage(status) {
            $("#loanList").html('<div class="listloader text-center p-2 bg-white" ><span class="spinner-border" role="status"></span></div>');
            $.ajax({
                type: "GET",
                url: '{{ URL::To('admin/load-loan-ajax-page') }}'+'/'+status,
                data: {},
                success: function (response) {
                    $("#loanList").hide().html(response).fadeIn('1000');
                    $('html,body').animate({
                        scrollTop: $("#loanList").offset().top},
                        'slow');
                }
            });
        }
        //Load loan Lender List
        function loadLoanAjaxLenders(requestId) {
            $("#lenderList").html('<div class="listloader text-center p-2 bg-white" ><span class="spinner-border" role="status"></span></div>');
            $.ajax({
                type: "GET",
                url: '{{ URL::To('admin/load-loan-ajax-lenders') }}'+'/'+requestId,
                success: function (response) {
                    $("#lenderList").html(response);
                    $("#lenderListModel").modal('show');
                }
            });
        }
        //===================Update Loan status=========================================

        function changeLoanStatus(id,status) {
            $('#dropdown'+id).html('<div class="spinner-border" role="status"></div>');
            $.ajax({
                type: "GET",
                url: '{{ URL::To('admin/update-loan-status') }}'+'/'+id+'/'+status,
                data: {},
                success: function (response) {
                    var result =  JSON.parse(response);
                    if(result.success == true){
                        toastr.success(result.message, '', {timeOut: 2000});
                    }else{
                        toastr.error(result.message, '', {timeOut: 2000});
                    }
                    loadLoanAjaxPage('pending');
                }
            });
        }
    </script>
@endsection
