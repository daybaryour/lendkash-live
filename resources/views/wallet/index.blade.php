@extends('layouts.app')

@section('content')

<main class="mainContent">
    <div class="container-fluid">
        <!-- page title section start -->
       <div class="page-title-row d-flex align-items-center">
            <div class="page-title-row__left page-title-row__left--subtittle w-100">
                <h1 class="page-title-row__left__title text-capitalize">
                    Manage Transfer
                </h1>
                <div class="d-sm-flex justify-content-between">
                    <h2>Transfer wallet money to bank</h2>
                    <h2 class="mt-2 mt-sm-0">Wallet Balance : <i class="icon-naira"></i> {{ getAdminInfo()->wallet_balance }}</h2>
                </div>
            </div>
        </div>

        <!--transfer money sec-->
        <div class="commonBox bg-white p-30">
            <form action="{{URL('admin/add-bank')}}" method="post" id="addBankfrm">
                @csrf
                <div id="field-list">
                    <div class="row">
                        <div class="col-md-6 col-lg-3">
                            <div class="form-group mb-0">
                                <label>Select Bank</label>
                                <select class="selectpicker form-control " title="Select Bank" data-size="4" name="bank_name" id="bank_name" aria-describedby="bank_name-error">
                                    @forelse ($banks as $bank)
                                        <option value="{{ $bank['id'] }}">{{ $bank['name'] }}</option>
                                    @empty
                                        <option value="loan">No records found.</option>
                                    @endforelse
                                </select>
                            </div>
                            <div><span id="bank_name-error" class="help-block error-help-block"></span></div>
                        </div>
                        {{-- <div class="col-md-6 col-lg-3">
                            <div class="form-group">
                                <label>Bank Code</label>
                                <input type="text" placeholder="Bank Code" class="form-control" name="bank_code" id="bank_code">
                            </div>
                        </div> --}}
                        <div class="col-md-6 col-lg-3">
                            <div class="form-group">
                                <label>Account No.</label>
                                <input type="text" placeholder="Account No." class="form-control" name="account_number" id="account_number">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="form-group">
                                <label>Account Holder Name</label>
                                <input type="text" placeholder="Account Holder Name" class="form-control" name="account_holder_name" id="account_holder_name">
                            </div>
                        </div>
                        {{-- <div class="col-md-6 col-lg-3">
                            <div class="form-group">
                                <label>BVN</label>
                                <input type="text" placeholder="BVN" class="form-control" name="bvn" id="bvn">
                            </div>
                        </div> --}}
                        <div class="col-md-6 col-lg-3">
                            <div class="form-group">
                                <button class="btn btn-secondary ripple-effect btn-append text-uppercase width-120 button-margin" type="button" id="addBankbtn">Add Bank</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            {!! JsValidator::formRequest('App\Http\Requests\AddBankValidation','#addBankfrm') !!}
        </div>
        <!-- table listing start -->
        <div class="common-table mt-3">
            <div class="table-responsive mCustomScrollbar" data-mcs-axis='x'>

                    <table class="table">
                        <thead>
                            <tr>
                                <th><span>Bank Name</span></th>
                                {{-- <th><span>Bank Code</span></th>
                                <th><span>BVN</span></th> --}}
                                <th><span>Account Number</span></th>
                                <th><span>Account Holder Name</span></th>
                                <th><span>Action</span></th>
                            </tr>
                        </thead>
                        <tbody id="bankList">
                        </tbody>
                    </table>
                    <div class="btnRow text-right p-30">
                        <button class="btn btn-secondary ripple-effect btn-append text-uppercase width-120" onclick="askpaymenyModal()">Proceed</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- table listing end -->

    </div>
</main>

<div class="modal fade" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog"
            id="bankTransfer" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="icon-cross"></i>
                </button>
                <h4 class="modal-title">Enter Amount</h4>
            </div>
            <form action="{{URL('admin/bank-transfer')}}" method="post" id="payBankfrm">
                @csrf
                <input type="hidden" name="bankId" id="bankId">
                <div class="modal-body text-center pt-3">
                    <input type="text" id="transferAmount" name="transferAmount" class="form-control" value="">
                    <span id="transferAmount-error" class="help-block error-help-block"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-block btn btn-secondary ripple-effect btn-append text-uppercase"  id="payButton" disabled>Transfer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function askpaymenyModal() {
    var bank_id = $("input[name='bank_id']:checked").val();
    $('#transferAmount').val('');
    $('#bankId').val(bank_id);
    $("#bankTransfer").modal('show');
}
//=================== Create bank transfer =========================================
$("#payButton").on('click', (function (e) {
    // e.preventDefault();
    var frm = $('#payBankfrm');
    if (frm.valid()) {
        showButtonLoader('payButton', 'Transfer', 'disable');
        $.ajax({
            url: "{{url('admin/bank-transfer')}}",
            type: "POST",
            data: new FormData(frm[0]),
            contentType: false,
            cache: false,
            processData: false,
            success: function (response)
            {
                // showButtonLoader('payButton', 'Transfer', 'enable');
                console.log(response);
                var result =  JSON.parse(response);
                if(result.success == true){
                    toastr.success(result.message, '', {timeOut: 2000});
                }else{
                    toastr.error(result.message, '', {timeOut: 2000});
                }
                setTimeout(function(){ location.reload(); }, 1000);
            },
            error: function (response) {
                showButtonLoader('payButton', 'Transfer', 'enable');
            },
        });
    }
}));
//=================== Add bank =========================================
$("#addBankbtn").on('click', (function (e) {
    // e.preventDefault();
    var frm = $('#addBankfrm');
    if (frm.valid()) {
        showButtonLoader('addBankbtn', 'ADD BANK', 'disable');
        $.ajax({
            url: "{{url('admin/add-bank')}}",
            type: "POST",
            data: new FormData(frm[0]),
            contentType: false,
            cache: false,
            processData: false,
            success: function (response)
            {
                showButtonLoader('addBankbtn', 'ADD BANK', 'enable');
                var result =  JSON.parse(response);
                if(result.success == true){
                    toastr.success(result.message, '', {timeOut: 2000});
                }else{
                    toastr.error(result.message, '', {timeOut: 2000});
                }
                $('.filter-option-inner-inner').html('Select Bank');
                $('#addBankfrm')[0].reset();
                loadBankList();
            },
            error: function (response) {
                showButtonLoader('addBankbtn', 'ADD BANK', 'enable');
            },
        });
    }
}));

//===================Load Bank list=========================================
        $(document).ready(function () {
            //called when key is pressed in textbox
            $("#transferAmount").keypress(function (e) {
                //if the letter is not digit then display error and don't type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    //display error message
                    $("#transferAmount-error").html("This field must be an integer.").show();
                    $('#payButton').prop('disabled', true);
                }else{
                    $("#transferAmount-error").html("").hide();
                    $('#payButton').prop('disabled', false);
                }
            });
            loadBankList();
        });
        function loadBankList() {
            $.ajax({
                type: 'get',
                url: '{{ URL::To('admin/load-bank-list') }}',
                dataType: "json",
                success: function (data) {
                    $('#bankList').html(data.html);
                }
            });
        }
        function deleteBank(bankId) {
            $.ajax({
                type: 'get',
                url: '{{ URL::To('admin/delete-bank') }}'+'/'+bankId,
                dataType: "json",
                success: function (result) {
                    if(result.success == true){
                        toastr.success(result.message, '', {timeOut: 2000});
                    }else{
                        toastr.error(result.message, '', {timeOut: 2000});
                    }
                    loadBankList();
                }
            });
        }
</script>
@endsection
