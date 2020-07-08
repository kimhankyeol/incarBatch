@foreach($data as $code)
<tr onclick="pageMove.admin.commonCodeMediumDetail('{{$code->worklarge}}','{{$code->workmedium}}')">
    <td>{{$code->worklargename}}</td>
    <td>{{$code->shortname}}</td>
    <td>{{$code->worklarge.$code->workmedium}}</td>
    @if(empty($code->filepath))
        <td style="text-align: center">-</td>
    @elseif($code->filepath=='[NULL]')
        <td style="text-align: center">-</td>
    @else
        <td>{{$code->filepath}}</td>
    @endif
    
    @if($code->used=="1")
        <td>사용</td>
    @else
        <td>미사용</td>
    @endIf
</tr>
@endforeach