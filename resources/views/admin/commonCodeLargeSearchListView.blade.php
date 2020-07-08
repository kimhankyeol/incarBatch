
@foreach($data as $code)
<tr onclick="pageMove.admin.commonCodeLargeDetail('{{$code->worklarge}}')">
    <td>{{$code->worklarge}}</td>
    <td>{{$code->longname}}</td>
    @if($code->used=="1")
        <td>사용</td>
    @else
        <td>미사용</td>
    @endIf
</tr>
@endforeach
   
