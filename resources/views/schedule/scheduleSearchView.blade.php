@foreach($data as $jobSc)
<tr onclick="pageMove.schedule.detail('scheduleDetailView','{{$jobSc->sc_seq}}','{{$jobSc->job_seq}}')">
    <td>{{'job_'.$jobSc->job_worklargectg.'_'.$jobSc->job_workmediumctg.'_'.$jobSc->job_seq}}</td>
    <td class="text-center">{{$jobSc->sc_seq}}</td>
    <td>{{$jobSc->sc_sulmyung}}</td>
    <td>{{$jobSc->job_worklargename}}</td>
    <td>{{$jobSc->job_workmediumname}}</td>
    <td>{{$jobSc->job_name}}</td>
    <td>{{$jobSc->sc_cronsulmyung}}</td>
    <td class="text-center">{{$jobSc->sc_regid}}</td>
    <td>{{$jobSc->sc_regdate}}</td>
</tr>
@endforeach