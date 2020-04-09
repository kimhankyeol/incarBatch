@foreach($itemsForCurrentPage as $proSc)
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
{{-- 페이징 이동 경로 --}}
<tr>
    {{$paginator->setPath('/process/processSearch')->appends(request()->except($searchParams))->links()}}
</tr>