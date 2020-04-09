@foreach($processSearchContent as $proSc)
<tr onclick="pageMove.process.detail('processDetailView','{{$proSc->p_seq}}')">
    <td>{{$proSc->P_Name}}</td>
    <td>{{$proSc->P_Name}}</td>
    <td>{{$proSc->P_Name}}</td>
    <td>{{$proSc->P_Name}}</td>
    <td>{{$proSc->P_Name}}</td>
    <td>{{$proSc->P_Name}}</td>
    <td>{{$proSc->P_Name}}</td>
</tr>
@endforeach 
