<div>
@foreach($itemsForCurrentPage as $jobSc)
<tr onclick="pageMove.job.detail('jobDetailView','{{$jobSc->Job_Seq}}')">
    <td>{{$jobSc->Job_Seq}}</td>
    <td>{{$jobSc->Job_Name}}</td>
    <td>{{$jobSc->Job_WorkLargeCtg}}</td>
    <td>{{$jobSc->Job_WorkMediumCtg}}</td>
    <td>{{$jobSc->Job_Sulmyung}}</td>
    <td>{{$jobSc->Job_RegId}}</td>
    <td>{{$jobSc->Job_RegDate}}</td>
</tr>
@endforeach 
{{-- 페이징 이동 경로 --}}
<tr>
    {{$paginator->setPath('/job/jobSearch')->appends(request()->except($searchParams))->links()}}
</tr>
</div>




