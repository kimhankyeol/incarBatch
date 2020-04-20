@foreach($data as $proSc)
<tr onclick="pageMove.process.detail('processDetailView','{{$proSc->P_Seq}}')">
    <td>{{'pro'.$proSc->P_Seq.'_'.$proSc->P_WorkLargeCtg.'_'.$proSc->P_WorkMediumCtg.'_'.date("YmdHis",strtotime($proSc->P_RegDate))}}</td>
    <td>{{$proSc->P_Name}}</td>
    <td>{{$proSc->P_WorkLargeName}}</td>
    <td>{{$proSc->P_WorkMediumName}}</td>
    <td>{{$proSc->P_Sulmyung}}</td>
    <td>{{$proSc->P_RegId}}</td>
    <td>{{$proSc->P_RegDate}}</td>
</tr>
@endforeach