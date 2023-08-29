@forelse ($notifications as $item)
    <div class="dropdown_item">
        <p class="info_txt mb-2 text-left">{{ $item['message'] }}</p>
        <span class="d-block text-right">{{ getFormatDayName($item['created_at']) }}</span>
    </div>
@empty
    <div class="alert alert-danger m-0" role="alert">No Data Found</div>
@endforelse
