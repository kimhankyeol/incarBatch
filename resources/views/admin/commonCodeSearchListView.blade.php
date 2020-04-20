@foreach($data as $code)
<tr onclick="pageMove.admin.commonCodeManageDetail('{{$code->Codetype}}','{{$code->WorkLarge}}','{{$code->WorkMedium}}')">
    <td>{{$code->Codetype}}</td>
    <td>{{$code->WorkLarge}}</td>
    @if($code->WorkMedium=="all")
        <td>-</td>
    @else
        <td>{{$code->WorkMedium}}</td>
    @endIf
    <td>{{$code->ShortName}}</td>
    <td>{{$code->LongName}}</td>
    @if($code->Used=="1")
        <td>사용</td>
    @else
        <td>미사용</td>
    @endIf
    
</tr>
@endforeach