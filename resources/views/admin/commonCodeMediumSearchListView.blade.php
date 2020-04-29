@foreach($data as $code)
<tr onclick="pageMove.admin.commonCodeMediumDetail('{{$code->WorkLarge}}','{{$code->WorkMedium}}')">
    <td>{{$code->WorkLargeName}}</td>
    <td>{{$code->ShortName}}</td>
    <td>{{$code->WorkLarge.$code->WorkMedium}}</td>
    @if(empty($code->FilePath))
    <td style="text-align: center">-</td>
    @else
    <td>{{$code->FilePath}}</td>
    @endif
    
    @if($code->Used=="1")
        <td>사용</td>
    @else
        <td>미사용</td>
    @endIf
</tr>
@endforeach