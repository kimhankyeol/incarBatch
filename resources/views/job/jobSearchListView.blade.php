@foreach($data as $jobSc)
<tr onclick="pageMove.job.detail('jobDetailView','{{$jobSc->job_seq}}')" style="text-align: center">
    <td>{{'job_'.$jobSc->job_worklargectg.'_'.$jobSc->job_workmediumctg.'_'.$jobSc->job_seq}}</td>
    <td>{{$jobSc->job_worklargename}}</td>
    <td>{{$jobSc->job_workmediumname}}</td>
    <td>{{$jobSc->job_name}}</td>
    <td>{{$jobSc->job_sulmyung}}</td>
    <td>{{$jobSc->job_regname}}</td>
    <td>{{$jobSc->job_regdate}}</td>
</tr>
@endforeach