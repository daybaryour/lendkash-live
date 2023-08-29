@if(!empty($notificationList) && count($notificationList) > 0)
    @foreach($notificationList as $notification)
        <div class="notificationPage__item">
            <p>{{ $notification->message }}</p>
            <span>{{ getFormatDayName($notification->created_at) }}</span>
        </div>
    @endforeach
    <div class="common-pagination d-flex align-items-center justify-content-end">
        <div class="count-wrap d-flex align-items-center">
            <div class="count font-md">

            </div>
        </div>
        <div class="pagination-item ">
               {{ $notificationList->links() }}
        </div>
    </div>
@else
<li class="alert alert-danger" role="alert">No Data Found</li>
@endif
<script>
     $(document).ready(function () {
        $(".pagination li a").on('click', function (e) {
            e.preventDefault();
            var pageLink = $(this).attr('href');
            if(pageLink != null && pageLink != undefined){
                getAllNotificationList(pageLink);
            }
        });
    });

</script>
