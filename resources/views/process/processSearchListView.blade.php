@foreach($data as $proSc)
<tr onclick="pageMove.process.detail('processDetailView','{{$proSc->p_seq}}')">
    <td>{{$proSc->p_filename}}</td>
    <td>{{$proSc->p_file}}</td>
    <td>{{$proSc->p_name}}</td>
    <td>{{$proSc->p_worklargename}}</td>
    <td>{{$proSc->p_workmediumname}}</td>
    <td>{{$proSc->p_sulmyung}}</td>
    <td>{{$proSc->p_regname}}</td>
    <td>{{$proSc->p_regdate}}</td>
</tr>
@endforeach