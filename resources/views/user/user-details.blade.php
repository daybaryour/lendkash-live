@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ url('public/css/jquery.fancybox.min.css')}}" type="text/css">
<main class="mainContent detailPage">
    <div class="container-fluid">
        <!-- page title section start -->
       <div class="page-title-row">
            <div class="page-title-row__left page-title-row__left--subtittle">
                <h1 class="page-title-row__left__title text-capitalize">
                    Manage User
                </h1>
                <h2>View</h2>
            </div>
        </div>
        <!-- Review Content-->
        <div class="detailSec">
        <h2 class="h-20 font-semi topHead">Personal Details </h2>
            <h5 class="mt-2 mt-sm-0">Wallet Balance : <i class="icon-naira"></i> {{ ($user['user_detail']['wallet_balance'])?$user['user_detail']['wallet_balance']:'0' }}</h5>
        <div class="box-shadow commonBox p-30 detailSec__box">
            <div class="userDetail">
                <div class="userDetail__head d-flex align-items-center">
                    <div class="userDetail__head__img">
                        <img src="{{ getUploadedImage($user['user_detail']['user_image'],'user_image') }}" alt="user">
                    </div>
                    <div class="userDetail__content">
                        <h3>{{ ($user['name'])?$user['name']:'' }}</h3>
                        <ul class="list-unstyled mb-0">
                            <li class="list-inline-item">
                                <i class="icon-email"></i> {{ ($user['email'])?$user['email']:'' }}
                            </li>
                            <li class="list-inline-item">
                                <i class="icon-call"></i> {{ ($user['mobile_number'])?$user['mobile_number']:'' }}
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <h2 class="h-20 font-semi topHead">KYC Details</h2>
        <div class="box-shadow commonBox p-30 detailSec__box">
            <ul class="list-unstyled detailLst d-flex flex-wrap">
                <input type="hidden" id="userId" value="{{ ($user['id'])?$user['id']:'' }}">
                <li class="list-inline-item">
                   <label>Name</label>
                   {{ ($user['name'])?$user['name']:'' }}
                </li>
                <li class="list-inline-item">
                   <label>Address</label>
                   {{ ($user['user_detail']['address'])?$user['user_detail']['address']:'' }}
                </li>
                <li class="list-inline-item">
                   <label>BVN</label>
                   {{ ($user['user_detail']['bvn'])?$user['user_detail']['bvn']:'' }}
                </li>
                <li class="list-inline-item">
                   <label>Employment</label>
                   {{ ($user['user_detail']['employer_detail'])?$user['user_detail']['employer_detail']:'' }}
                </li>
                <li class="list-inline-item">
                   <label>Location</label>
                   {{ ($user['user_detail']['address'])?$user['user_detail']['address']:'' }}
                </li>
                <li class="list-inline-item">
                   <label>Upload Documents 01 </label>
                   <div class="documentimg">
                        @php
                            $id_proof_path_parts = pathinfo($user['user_detail']['id_proof_document']);
                        @endphp
                        @if(!empty($id_proof_path_parts['extension']) && $id_proof_path_parts['extension']=='pdf')
                            <a data-fancybox="gallery" href="{{ getUploadedImage($user['user_detail']['id_proof_document'],'user_document') }}">
                                <img src="{{ url('public/images/pdf.png') }}" alt="pan card" class="img-fluid">
                            </a>
                        @else
                            <a data-fancybox="gallery" href="{{ getUploadedImage($user['user_detail']['id_proof_document'],'user_document') }}">
                                <img src="{{ getUploadedImage($user['user_detail']['id_proof_document'],'user_document') }}" alt="pan card" class="img-fluid">
                            </a>
                        @endif
                    </div>
                   Government Issued ID
                </li>
                <li class="list-inline-item">
                   <label>Upload Documents 02</label>
                   <div class="documentimg">
                        @php
                            $doc_path_parts = pathinfo($user['user_detail']['employment_document']);
                        @endphp
                        @if(!empty($doc_path_parts['extension']) && $doc_path_parts['extension']=='pdf')
                            <a data-fancybox="gallery" href="{{ getUploadedImage($user['user_detail']['employment_document'],'user_document') }}">
                                <img src="{{ url('public/images/pdf.png') }}" alt="pan card" class="img-fluid">
                            </a>
                        @else
                            <a data-fancybox="gallery" href="{{ getUploadedImage($user['user_detail']['employment_document'],'user_document') }}">
                                <img src="{{ getUploadedImage($user['user_detail']['employment_document'],'user_document') }}" alt="pan card" class="img-fluid">
                            </a>
                        @endif
                    </div>
                   Payslip / CAC /Employment Letter
                </li>
                <li class="list-inline-item">
                   <label>KYC Verified</label>
                    <div class="switch">
                        <label>
                            @if($user['user_detail']['is_approved']==1)
                                <input type="checkbox" checked  data-url="{{URL::To('/admin/update-kyc-status')}}"   onchange="updateKycStatus({{$user['id'].',0'}})"   id="myonoffswitch{{$user['id']}}"  >
                                <span class="lever"></span>
                            @else
                                <input type="checkbox"   data-url="{{URL::To('/admin/update-kyc-status')}}"   onchange="updateKycStatus({{$user['id'].',1'}})"   id="myonoffswitch{{$user['id']}}">
                                <span class="lever"></span>
                            @endif
                        </label>
                    </div>
                </li>
            </ul>
            <h4 class="detailHead font-semi">Bank Info </h4>
            <ul class="list-unstyled detailLst">
                <li class="list-inline-item">
                   <label>Bank Name</label>
                   {{ ($user['user_detail']['bank_name'])?$user['user_detail']['bank_name']:'' }} Bank
                </li>
                <li class="list-inline-item">
                   <label>Account Number</label>
                   {{ ($user['user_detail']['account_number'])?$user['user_detail']['account_number']:'' }}
                </li>
                <li class="list-inline-item">
                   <label>BVN</label>
                   {{ ($user['user_detail']['bvn'])?$user['user_detail']['bvn']:'' }}
                </li>
            </ul>
        </div>
        <h2 class="h-20 font-semi topHead">Loan Requested</h2>
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
<script  src="{{ url('public/js/jquery.fancybox.js')}}"></script>
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

         //fancy box
        $(".fancybox").fancybox({
            openEffect  : 'none',
            closeEffect : 'none',
            arrows:true
        });
    </script>
@endsection
