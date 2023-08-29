<table class="table">
    <thead>
        <tr>
            <th><span class="sorting">Name</span></th>
            <th><span class="sorting">Amount</span></th>
            <th><span class="sorting">Date</span></th>
            <th><span class="sorting">Time</span></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($lenders as $lender)
            <tr>
                <td>{{ $lender['user_name'] }}</td>
                <td>{{ $lender['paid_amount'] }}</td>
                <td>{{ date('d/m/Y',strtotime($lender['created_at'])) }}</td>
                <td>{{ date('h:i A',strtotime($lender['created_at'])) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">
                    <div class="alert alert-danger m-0" role="alert">No Data Found</div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
