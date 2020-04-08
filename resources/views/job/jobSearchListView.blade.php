<div>
@foreach($itemsForCurrentPage as $jobSc)
<tr onclick="pageMove.job.detail('jobDetailView','{{$jobSc->job_seq}}')">
    <td>{{$jobSc->job_seq}}</td>
    <td>{{$jobSc->job_name}}</td>
    <td>{{$jobSc->job_workLargeCtg}}</td>
    <td>{{$jobSc->job_workMediumCtg}}</td>
    <td>{{$jobSc->job_sulmyung}}</td>
    <td>{{$jobSc->job_regId}}</td>
    <td>{{$jobSc->job_regDate}}</td>
</tr>
@endforeach 
{{-- 페이징 이동 경로 --}}
<tr>
    {{$paginator->setPath('/job/jobSearch')->appends(request()->except($searchParams))->links()}}
</tr>
</div>




