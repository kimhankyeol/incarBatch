@foreach($jobSearchContent as $jobSc)
<tr onclick="job.detail('{{$jobSc->job_seq}}')">
    <td>{{$jobSc->job_name}}</td>
    <td>{{$jobSc->job_exp}}</td>
    <td>{{$jobSc->job_regDate}}</td>
    <td>{{$jobSc->job_register}}</td>
    <td>{{$jobSc->job_name}}</td>
    <td>{{$jobSc->job_exp}}</td>
    <td>{{$jobSc->job_regDate}}</td>
    <td>{{$jobSc->job_register}}</td>
</tr>
@endforeach 