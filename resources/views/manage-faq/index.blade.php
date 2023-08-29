@extends('layouts.app')

@section('content')
<main class="mainContent faqPage">
    <div class="container-fluid">
        <!-- page title section start -->
        <!-- page title section start -->
            <div class="page-title-row d-flex">
                <div class="page-title-row__left page-title-row__left--subtittle">
                    <h1 class="page-title-row__left__title text-capitalize">
                        Manage CMS
                    </h1>
                    <h2>Manage FAQ</h2>
                </div>
                <div class="page-title-row__right">
                    <a href="{{ URL::To('admin/add-faqs') }}"  class="btn btn-primary ripple-effect">
                    Add FAQ
                    </a>
                </div>
            </div>
            <!-- page title section end -->
        <!-- page title section end -->
        <!-- table listing start -->
        <div class="common-box min-h500">
            <div class="accordion" id="accordion">
                @if(!empty($getFaqsList) && count($getFaqsList) > 0)
                    @foreach($getFaqsList as $key => $faq)
                        <div class="card">
                            <div class="card-header" id="heading{{$key}}">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#question{{$key}}" aria-expanded="false" aria-controls="heading{{$key}}">
                                    <span></span> {{@$faq->question}}
                                </button>
                                <ul class="list-inline right-cnt mb-0">

                                    <li class="list-inline-item">
                                        <a href="{{url('admin/edit-faq/').'/'.base64_encode($faq->id)}}"><i class="icon-pencil"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <div id="question{{$key}}" class="collapse" aria-labelledby="heading{{$key}}" data-parent="#accordion">
                                <div class="card-body">
                                    <p class="mb-0">
                                        {!! @$faq->answer !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-danger text-center">No Record Found</div>
                @endif
            </div>
        </div>
        <!-- table listing end -->
    </div>
</main>
@endsection
