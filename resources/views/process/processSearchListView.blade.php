@foreach($data as $proSc)
<tr onclick="pageMove.process.detail('processDetailView','{{$proSc->P_Seq}}')">
    <td>{{$proSc->P_FileName}}</td>
    <td>{{$proSc->P_File}}</td>
    <td>{{$proSc->P_Name}}</td>
    <td>{{$proSc->P_WorkLargeName}}</td>
    <td>{{$proSc->P_WorkMediumName}}</td>
    <td>{{$proSc->P_Sulmyung}}</td>
    <td>{{$proSc->P_RegId}}</td>
    <td>{{$proSc->P_RegDate}}</td>
</tr>
@endforeach