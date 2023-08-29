@extends('layouts.app')
@section('content')
<main class="mainContent detailPage">
    <div class="container-fluid">
        <!-- page title section start -->
       <div class="page-title-row">
            <div class="page-title-row__left page-title-row__left--subtittle">
                <h1 class="page-title-row__left__title text-capitalize">
                    Reviews & Ratings
                </h1>
                <h2>View</h2>
            </div>
        </div>

        <!-- Review Content-->
        <h2 class="h-20 font-semi topHead">Review provided by Borrower To Lender</h2>
        <div class="common-table">
            <div class="table-responsive mCustomScrollbar" data-mcs-axis='x'>
                <table class="table">
                    <thead>
                        <tr>
                            <th><span class="">Lender Name</span></th>
                            <th><span class="">Rating</span></th>
                            <th><span class="">Review</span></th>
                            <th><span class="">Flag</span></th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($lenderRatings as $lender)
                            <tr>
                                <td>{{ getUserNameByUserId($lender['to_id']) }}</td>
                                <td>
                                    @for ($i = 1; $i <=5 ; $i++)
                                        <i class="icon-star @if($lender['rating']>=$i) active @endif"></i>
                                    @endfor
                                </td>
                                <td>{{ str_limit($lender['reviews'],50) }}... <a href="javascript:void(0);" onclick="readMoreModel('{{$lender['reviews']}}')" class="theme-color">Read More</a></td>
                                <td>
                                    @if($lender['flag']==0)
                                        <a href="javascript:void(0);" onclick="changeRatingFlag({{ $lender['id'] }})" class="btn btn-primary ripple-effect">Mark as Flag</a>
                                    @else
                                        1
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>reviews
                                <td colspan="5">
                                    <div class="alert alert-danger" role="alert">
                                        No Data Found
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <h2 class="h-20 font-semi topHead mt-3 mt-md-4">Review provided by lender To Borrower</h2>
        <div class="common-table">
            <div class="table-responsive mCustomScrollbar" data-mcs-axis='x'>
                <table class="table">
                    <thead>
                        <tr>
                            <th><span class="">Lender Name</span></th>
                            <th><span class="">Rating</span></th>
                            <th><span class="">Review</span></th>
                            <th><span class="">Flag</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($borrowerRatings as $borrower)
                            <tr>
                                <td>{{ getUserNameByUserId($borrower['from_id']) }}</td>
                                <td>
                                    @for ($i = 1; $i <=5 ; $i++)
                                        <i class="icon-star @if($borrower['rating']>=$i) active @endif"></i>
                                    @endfor
                                </td>
                                <td>{{ str_limit($borrower['reviews'],50) }}... <a href="javascript:void(0);" onclick="readMoreModel('{{$borrower['reviews']}}')" class="theme-color">Read More</a></td>
                                <td>
                                    @if($borrower['flag']==0)
                                        <a href="javascript:void(0);" onclick="changeRatingFlag({{ $borrower['id'] }})" class="btn btn-primary ripple-effect">Mark as Flag</a>
                                    @else
                                        1
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>reviews
                                <td colspan="5">
                                    <div class="alert alert-danger" role="alert">
                                        No Data Found
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>
<div class="modal fade" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog"
            id="readMore" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="icon-cross"></i>
                </button>
            </div>
            <div class="modal-body text-center pt-3">
                <p class="mb-0" id="readMoreText"></p>
            </div>

        </div>
    </div>
</div>
<script>

//===================Update Loan status=========================================

function changeRatingFlag(id) {
    $.ajax({
        type: "GET",
        url: '{{ URL::To('admin/change-rating-flag') }}'+'/'+id+'/'+status,
        data: {},
        success: function (response) {
            var result =  JSON.parse(response);
            if(result.success == true){
                toastr.success(result.message, '', {timeOut: 2000});
                setTimeout(function(){ location.reload(); }, 2000);
            }else{
                toastr.error(result.message, '', {timeOut: 2000});
            }

        }
    });
}
</script>
@endsection
