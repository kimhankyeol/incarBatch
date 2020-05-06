@foreach($data as $jobSc)
<tr class="jobExeOneDbClick">
<td class="Job_Seq" data-value="{{$jobSc->Job_Seq}}">{{'job_'.$jobSc->Job_WorkLargeCtg.'_'.$jobSc->Job_WorkMediumCtg.'_'.$jobSc->Job_Seq}}</td>
    <td>{{$jobSc->Job_WorkLargeName}}</td>
    <td>{{$jobSc->Job_WorkMediumName}}</td>
    <td>{{$jobSc->Job_Name}}</td>
    <td>{{$jobSc->Job_Sulmyung}}</td>
    <td>{{$jobSc->Job_RegId}}</td>
    <td>{{$jobSc->Job_RegDate}}</td>
</tr>
@endforeach

