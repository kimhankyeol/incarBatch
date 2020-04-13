@foreach($data as $proSc)
<tr onclick="pageMove.process.detail('processDetailView','{{$proSc->P_Seq}}')">
    <td>{{$proSc->P_Name}}</td>
    <td>{{$proSc->P_Name}}</td>
    <td>{{$proSc->P_Name}}</td>
    <td>{{$proSc->P_Name}}</td>
    <td>{{$proSc->P_Name}}</td>
    <td>{{$proSc->P_Name}}</td>
    <td>{{$proSc->P_Name}}</td>
</tr>
@endforeach