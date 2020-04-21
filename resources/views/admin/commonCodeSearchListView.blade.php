@foreach($data as $code)
<tr onclick="pageMove.admin.commonCodeManageDetail('{{$code->WorkLarge}}','{{$code->WorkMedium}}')">
    <td>{{$code->WorkLarge}}</td>
    <td>{{$code->WorkLarge.$code->WorkMedium}}</td>
    <td>{{$code->WorkLargeName.' -> '.$code->ShortName}}</td>
    <td>{{$code->LongName}}</td>
    @if($code->Used=="1")
        <td>사용</td>
    @else
        <td>미사용</td>
    @endIf
    
</tr>
@endforeach