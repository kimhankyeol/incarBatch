@foreach($data as $jobSc)
<tr onclick="pageMove.job.detail('jobDetailView','{{$jobSc->Job_Seq}}')">
    <td>{{'job_'.$jobSc->Job_Seq.'_'.$jobSc->Job_WorkLargeCtg.'_'.$jobSc->Job_WorkMediumCtg}}</td>
    <td>{{$jobSc->Job_Name}}</td>
    <td>{{$jobSc->Job_WorkLargeCtg}}</td>
    <td>{{$jobSc->Job_WorkMediumCtg}}</td>
    <td>{{$jobSc->Job_Sulmyung}}</td>
    <td>{{$jobSc->Job_RegId}}</td>
    <td>{{$jobSc->Job_RegDate}}</td>
</tr>
@endforeach