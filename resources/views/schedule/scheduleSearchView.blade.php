@foreach($data as $jobSc)
<tr onclick="pageMove.job.detail('jobDetailView','{{$jobSc->Job_Seq}}')">
    <td>{{'job_'.$jobSc->Job_WorkLargeCtg.'_'.$jobSc->Job_WorkMediumCtg.'_'.$jobSc->Job_Seq}}</td>
    <td>{{'Schedule'.$jobSc->Sc_Seq}}</td>
    <td>{{$jobSc->Sc_Sulmyung}}</td>
    <td>{{$jobSc->Job_WorkLargeName}}</td>
    <td>{{$jobSc->Job_WorkMediumName}}</td>
    <td>{{$jobSc->Job_Name}}</td>
    <td>{{$jobSc->Sc_Crontab}}</td>
    <td>{{$jobSc->Job_RegId}}</td>
    <td>{{$jobSc->Job_RegDate}}</td>
</tr>
@endforeach
