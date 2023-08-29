@forelse ($data as $key=>$value)
    <tr>
        <td>
            <div class="custom-control custom-control-inline custom-radio mt-0">
                <input type="radio"  name="bank_id" id="bank_id_{{ $key }}" class="custom-control-input" value="{{ $value['id'] }}" @if($key==0) checked @endif>
                <label class="custom-control-label" for="bank_id_{{ $key }}">{{ ($value['bank_name'])?$value['bank_name']:'' }}</label>
            </div>
        </td>
        {{-- <td>{{ ($value['bank_code'])?$value['bank_code']:'' }}</td> --}}
        {{-- <td>{{ ($value['bvn'])?$value['bvn']:'' }}</td> --}}
        <td>{{ ($value['account_number'])?$value['account_number']:'' }}</td>
        <td>{{ ($value['account_holder_name'])?$value['account_holder_name']:'' }}</td>
        <td><a href="javascript:;" onclick="deleteBank({{ $value['id'] }});" class="">Delete</a></td>
    </tr>
    {{++$key}}
@empty
    <tr>
        <td colspan="5">
            <div class="alert alert-danger m-0" role="alert">No Data Found</div>
        </td>
    </tr>
@endforelse
