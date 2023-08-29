<!doctype html>
<html lang="en">

<head>
    <title>Lendkash | Admin</title>
    <meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- favicon -->

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no,user-scalable=0">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('public/images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('public/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('public/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ url('public/images/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ url('public/images/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">


    <!-- stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="{{ url('public/css/icomoon.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ url('public/css/content.min.css')}}" type="text/css">

	<!-- Script Link -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>
        @if($type=='faq')
            <main class="mainContent faqPage faqPage--mobileView ">
                <div class="container">
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
                </div>
            </main>
            <!-- table listing end -->
        @else
            <main class="mainContent content-page">
                <div class="container">
                    <div class="content-page__wrapper">
                        {!! $cmsData['content'] !!}
                    </div>
                </div>
            </main>
        @endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
