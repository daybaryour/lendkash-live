@extends('layouts.app')
@section('content')
<main class="mainContent notificationPage">
    <div class="container-fluid">
        <!-- page title section start -->
        <div class="page-title-row d-flex align-items-center">
            <div class="page-title-row__left">
                <h1 class="page-title-row__left__title text-capitalize mb-0">
                Notifications </h1>
            </div>
        </div>

        <div class="notification-wrap box-shadow commonBox">

            <div id="set-all-notification-list">
                <!--set resturant all notification list-->
            </div>

        </div>
    </div>
</main>
<script>
    $(document).ready(function(){
        getAllNotificationList();
    });

    function getAllNotificationList(pageLink){
        // $('#set-all-notification-list').html('<div class="text-center"><img class="icon spinner" src="'+SITEURL+'/public/admin/images/loader.svg" alt="loader"></div>');
        var url = pageLink ||'{{url("admin/get-all-notification-list")}}';
        $.ajax({
            type: "GET",
            url: url,
            success: function (response) {
                if(response.success == true){
                    $('#set-all-notification-list').html(response.html);
                }
            }
        });
    }
</script>
@endsection
