@extends('layouts.app')
@section('content')
<main class="mainContent edit-cms">
        <div class="container-fluid">
            <!-- page title section start -->
           <div class="page-title-row d-flex align-items-center">
                <div class="page-title-row__left">
                    <h1 class="page-title-row__left__title text-capitalize">
                        Set Loan Interests
                    </h1>
                </div>
            </div>
            <div class="edit-cms__wrapper mb-3 mb-md-4">
                <form action="{{URL('admin/update-commission')}}" method="post" id="setCommissionfrm">
                    @csrf
                    @forelse ($commissionData as $commission)
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Term</label>
                                    @if($commission['type']=='one_month_admin_loan_commission')
                                        <h4 class="h-18 mb-0">1 Month</h4>
                                    @elseif($commission['type']=='three_month_admin_loan_commission')
                                        <h4 class="h-18 mb-0">3 Month</h4>
                                    @elseif($commission['type']=='six_month_admin_loan_commission')
                                        <h4 class="h-18 mb-0">6 Month</h4>
                                    @else
                                        <h4 class="h-18 mb-0">12 Month</h4>
                                    @endif

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Set Interest (%)</label>
                                    @if($commission['type']=='one_month_admin_loan_commission')
                                        <input type="text" class="form-control" placeholder="Set Interest" value="{{ $commission['value'] }}" name="one_month_admin_loan_commission" id="one_month_admin_loan_commission">
                                    @elseif($commission['type']=='three_month_admin_loan_commission')
                                        <input type="text" class="form-control" placeholder="Set Interest" value="{{ $commission['value'] }}" name="three_month_admin_loan_commission" id="three_month_admin_loan_commission">
                                    @elseif($commission['type']=='six_month_admin_loan_commission')
                                        <input type="text" class="form-control" placeholder="Set Interest" value="{{ $commission['value'] }}" name="six_month_admin_loan_commission" id="six_month_admin_loan_commission">
                                    @else
                                        <input type="text" class="form-control" placeholder="Set Interest" value="{{ $commission['value'] }}" name="twelve_month_admin_loan_commission" id="twelve_month_admin_loan_commission">
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty

                    @endforelse
                    <div class="form-group mb-0">
                        <button class="btn btn-primary ripple-effect text-uppercase" type="button" id="setCommissionbtn">Update</button>
                    </div>
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\CommissionValidation','#setCommissionfrm') !!}
            </div>
            <div class="page-title-row d-flex align-items-center">
                <div class="page-title-row__left">
                    <h1 class="page-title-row__left__title text-capitalize mb-0">
                    Set Invest Interests
                    </h1>
                </div>
            </div>
            <div class="edit-cms__wrapper mb-3 mb-md-4">
                <form action="{{URL('admin/update-invest-commission')}}" method="post" id="investCommissionfrm">
                    @csrf
                    @forelse ($investInterest as $invest)
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Term</label>
                                    @if($invest['type']=='six_month_interest')
                                        <h4 class="h-18 mb-0">6 Month</h4>
                                    @else
                                        <h4 class="h-18 mb-0">12 Month</h4>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Set Interest (%)</label>
                                    @if($invest['type']=='six_month_interest')
                                        <input type="text" class="form-control" placeholder="Set Interest" value="{{ $invest['value'] }}" name="six_month_interest" id="six_month_interest">
                                    @else
                                        <input type="text" class="form-control" placeholder="Set Interest" value="{{ $invest['value'] }}" name="twelve_month_interest" id="twelve_month_interest">
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty

                    @endforelse
                    <div class="form-group mb-0">
                        <button class="btn btn-primary ripple-effect text-uppercase" type="button" id="investCommissionbtn">Update</button>
                    </div>
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\InvestCommissionValidation','#investCommissionfrm') !!}
            </div>
            <div class="page-title-row d-flex align-items-center">
                <div class="page-title-row__left">
                    <h1 class="page-title-row__left__title text-capitalize">
                        Set Admin Commission
                    </h1>
                </div>
            </div>
            <div class="edit-cms__wrapper mb-3">
                <form action="{{URL('admin/update-wallet-commission')}}" method="post" id="walletCommissionfrm">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Set Commission Wallet to Bank Account (%)</label>
                                 <input type="text" class="form-control" placeholder="Set Commission Wallet to bank Account (%)" value="{{ !empty($walletCommission['value'])?$walletCommission['value']:'0' }}" name="wallet_commission_to_bank_account" id="wallet_commission_to_bank_account">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Set Commission for Loan request (%)</label>
                                 <input type="text" class="form-control" placeholder="Set Commission for Loan Request (%)" value="{{ !empty($getLoanCommission['value'])?$getLoanCommission['value']:'0' }}" name="commission_for_loan_request" id="commission_for_loan_request">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <button class="btn btn-primary ripple-effect text-uppercase" type="button" id="walletCommissionbtn">Update</button>
                    </div>
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\WalletCommissionValidation','#walletCommissionfrm') !!}
            </div>
        </div>
    </main>

<script>
//=================== Update Commission =========================================
$("#setCommissionbtn").on('click', (function (e) {
    // e.preventDefault();
    var frm = $('#setCommissionfrm');
    if (frm.valid()) {
        showButtonLoader('setCommissionbtn', 'UPDATE', 'disable');
        $.ajax({
            url: "{{url('admin/update-commission')}}",
            type: "POST",
            data: new FormData(frm[0]),
            contentType: false,
            cache: false,
            processData: false,
            success: function (response)
            {
                showButtonLoader('setCommissionbtn', 'UPDATE', 'enable');
                var result =  JSON.parse(response);
                if(result.success == true){
                    toastr.success(result.message, '', {timeOut: 2000});
                }else{
                    toastr.error(result.message, '', {timeOut: 2000});
                }
            },
            error: function (response) {
                showButtonLoader('setCommissionbtn', 'UPDATE', 'enable');
            },
        });
    }
}));
//=================== Update Invest Commission =========================================
$("#investCommissionbtn").on('click', (function (e) {
    // e.preventDefault();
    var frm = $('#investCommissionfrm');
    if (frm.valid()) {
        showButtonLoader('investCommissionbtn', 'UPDATE', 'disable');
        $.ajax({
            url: "{{url('admin/update-invest-commission')}}",
            type: "POST",
            data: new FormData(frm[0]),
            contentType: false,
            cache: false,
            processData: false,
            success: function (response)
            {
                showButtonLoader('investCommissionbtn', 'UPDATE', 'enable');
                var result =  JSON.parse(response);
                if(result.success == true){
                    toastr.success(result.message, '', {timeOut: 2000});
                }else{
                    toastr.error(result.message, '', {timeOut: 2000});
                }
            },
            error: function (response) {
                showButtonLoader('investCommissionbtn', 'UPDATE', 'enable');
            },
        });
    }
}));
//=================== Update Wallet Commission =========================================
$("#walletCommissionbtn").on('click', (function (e) {
    // e.preventDefault();
    var frm = $('#walletCommissionfrm');
    if (frm.valid()) {
        showButtonLoader('walletCommissionbtn', 'UPDATE', 'disable');
        $.ajax({
            url: "{{url('admin/update-wallet-commission')}}",
            type: "POST",
            data: new FormData(frm[0]),
            contentType: false,
            cache: false,
            processData: false,
            success: function (response)
            {
                showButtonLoader('walletCommissionbtn', 'UPDATE', 'enable');
                var result =  JSON.parse(response);
                if(result.success == true){
                    toastr.success(result.message, '', {timeOut: 2000});
                }else{
                    toastr.error(result.message, '', {timeOut: 2000});
                }
            },
            error: function (response) {
                showButtonLoader('walletCommissionbtn', 'UPDATE', 'enable');
            },
        });
    }
}));
</script>
@endsection
