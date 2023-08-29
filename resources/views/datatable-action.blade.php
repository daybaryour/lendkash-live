<!-- Customer actions -->
@if ($action_type_info['type']=='customer')
    @if ($action_type_info['columnType']=='status')
        <div class="switch">
            <label>
                @if($data->status=='active')
                    <input type="checkbox" checked  data-url="{{URL::To('/admin/update-user-status')}}"   onchange="updateUserStatus({{$data->id.',0'}})"   id="useronoffswitch{{$data->id}}"  >
                    <span class="lever"></span>
                @else
                    <input type="checkbox"   data-url="{{URL::To('/admin/update-user-status')}}"   onchange="updateUserStatus({{$data->id.',1'}})"   id="useronoffswitch{{$data->id}}">
                    <span class="lever"></span>
                @endif
            </label>
        </div>
    @endif
    @if ($action_type_info['columnType']=='kycStatus')
        <div class="switch">
            <label>
                @if($data->is_approved==1)
                    <input type="checkbox" checked data-url="{{URL::To('/admin/update-kyc-status')}}" onchange="updateKycStatus({{$data->id.',0'}})" id="myonoffswitch{{$data->id}}">
                    <span class="lever"></span>
                @else
                    <input type="checkbox" data-url="{{URL::To('/admin/update-kyc-status')}}" onchange="updateKycStatus({{$data->id.',1'}})" id="myonoffswitch{{$data->id}}">
                    <span class="lever"></span>
                @endif
            </label>
        </div>
    @endif
@endif
<!-- loan Request actions -->
@if ($action_type_info['type']=='loanRequest')
    @if ($action_type_info['columnType']=='loan_description')
        @if(!empty($data['loan_description']))
            {{ str_limit($data['loan_description'],50) }}... <a href="javascript:void(0);" onclick="readMoreModel('{{$data['loan_description']}}')" class="theme-color">Read More</a>
        @else
            -
        @endif
    @endif
    @if ($action_type_info['columnType']=='action')
        @if ($action_type_info['loan_status']=='pending')
            <div class="dropdown" id="dropdown{{$data->id}}">
                <a href="javascript:void(0)" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="icon-more"></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeLoanStatus({{$data->id}},'approved')">Approve</a>
                    <a class="dropdown-item" href="javascript:void(0);" onclick="changeLoanStatus({{$data->id}},'rejected')">Reject</a>
                    <!-- <a class="dropdown-item" href="javascript:void(0);" >Mark as Flag</a> -->
                </div>
            </div>
        @endif
        @if ($action_type_info['loan_status']=='active' || $action_type_info['loan_status']=='completed' || $action_type_info['loan_status']=='expired')
            <a href="javascript:void()" class="btn btn-primary ripple-effect text-uppercase" onclick="loadLoanAjaxLenders({{$data->id}})">View</a>
        @endif
    @endif
@endif
<!-- Invest Request actions -->
@if ($action_type_info['type']=='investRequest')
    @if ($action_type_info['columnType']=='action')
        <div class="dropdown" id="dropdown{{$data->id}}">
            <a href="javascript:void(0)" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="icon-more"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
                <a class="dropdown-item" href="javascript:void(0);" onclick="changeInvestStatus({{$data->id}},'approved')">Approve</a>
                <a class="dropdown-item" href="javascript:void(0);" onclick="changeInvestStatus({{$data->id}},'rejected')">Reject</a>
                <!-- <a class="dropdown-item" href="javascript:void(0);" >Mark as Flag</a> -->
            </div>
        </div>
    @endif
@endif
<!-- Support Request actions -->
@if ($action_type_info['type']=='support')
    @if ($action_type_info['columnType']=='description')
        @if(!empty($data['description']))
            {{ str_limit($data['description'],50) }}... <a href="javascript:void(0);" onclick="readMoreModel('{{$data['description']}}')" class="theme-color">Read More</a>
        @else
            -
        @endif
    @endif
@endif
<!-- Loan Report actions -->
@if ($action_type_info['type']=='loanReport')
    @if ($action_type_info['columnType']=='loan_description')
        @if(!empty($data['loan_description']))
            {{ str_limit($data['loan_description'],50) }}... <a href="javascript:void(0);" onclick="readMoreModel('{{$data['loan_description']}}')" class="theme-color">Read More</a>
        @else
            -
        @endif
    @endif
    @if ($action_type_info['columnType']=='status')
        @if ($data['loan_status']=='active')
            <span class="text-primary">Active Loans</span>
        @endif
        @if ($data['loan_status']=='pending')
            <span class="text-info">Under Approval</span>
        @endif
        @if ($data['loan_status']=='completed')
            <span class="text-success">Loan Completed</span>
        @endif
        @if ($data['loan_status']=='approved')
            <span class="text-success">Approved</span>
        @endif
        @if ($data['loan_status']=='rejected')
            <span class="text-danger">Rejected</span>
        @endif
        @if ($data['loan_status']=='cancelled')
            <span class="text-danger">Cancelled</span>
        @endif
        @if ($data['loan_status']=='expired')
            <span class="text-danger">Expired</span>
        @endif
    @endif
@endif
<!-- Loan Report actions -->
@if ($action_type_info['type']=='investReport')
    @if ($action_type_info['columnType']=='status')
        @if ($data['status']=='rejected')
            <span class="text-danger">Rejected</span>
        @endif
        @if ($data['status']=='pending')
            <span class="text-info">Under Approval</span>
        @endif
        @if ($data['status']=='completed')
            <span class="text-success">Completed</span>
        @endif
        @if ($data['status']=='approved')
            <span class="text-primary">Approved</span>
        @endif
    @endif
@endif
<!-- Transaction Status -->
@if ($action_type_info['type']=='transaction')
    @if ($action_type_info['columnType']=='type')
        @if ($data['transaction_type']=='bank_transfer')
            <span class="">Bank Transfer</span>
        @endif
        @if ($data['transaction_type']=='loan')
            <span class="">Loan</span>
        @endif
        @if ($data['transaction_type']=='loan_emi')
            <span class="">Loan EMI</span>
        @endif
        @if ($data['transaction_type']=='invest')
            <span class="">Invest</span>
        @endif
        @if ($data['transaction_type']=='wallet')
            <span class="">Wallet</span>
        @endif
        @if ($data['transaction_type']=='add_money')
            <span class="">Add Money</span>
        @endif
    @endif
@endif
