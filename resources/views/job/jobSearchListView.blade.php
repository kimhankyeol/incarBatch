<div>
    @foreach($itemsForCurrentPage as $jobSc)
    <tr ondblclick="pageMove.job.detail('jobDetailView','{{$jobSc->Job_Seq}}')">
        <td style="width:100px">{{$jobSc->Job_Seq}}</td>
        <td style="width:100px">{{$jobSc->Job_Name}}</td>
        <td style="width:100px">{{$jobSc->Job_WorkLargeCtg}}</td>
        <td style="width:100px">{{$jobSc->Job_WorkMediumCtg}}</td>
        <td style="width:400px">dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd</td>
        <!-- <td>{{$jobSc->Job_Sulmyung}}</td> -->
        <td style="width:100px">{{$jobSc->Job_RegId}}</td>
        <td style="width:200px">{{$jobSc->Job_RegDate}}</td>
    </tr>
    @endforeach 
    {{-- 페이징 이동 경로 --}}
    <tr>
        {{$paginator->setPath('/job/jobSearch')->appends(request()->except($searchParams))->links()}}
    </tr>
</div>




