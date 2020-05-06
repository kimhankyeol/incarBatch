<table id ="datatable" class="table table-bordered" cellspacing="0">
    <colgroup>
      <col width="160px" />
      <col width="200px" />
      <col width="250px" />
      <col width="180px" />
      <col width="130px" />
      <col width="150px" />
    </colgroup>
    <thead>
    <tr>
        <th>ID</th>
        <th>명</th>
        <th>설명</th>
        <th>실행/예약/완료/오류</th>
        <th>예상시간</th>
        <th>최대예상시간</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center">job_1000_100_1</td>
            <td>잡1</td>
            <td>집1에 대한 설명</td>
            <td class="text-center">1/1/2/0</td>
            <td class="text-center">1시간</td>
            <td class="text-center">1시간30분</td>
        </tr>
        {{--  조회된 값이 보여주는 위치 --}}
{{--          @if(isset($data))
            @foreach($data as $monitorSc)
            <tr onclick="monitor.gusungList({{$monitorSc->Job_Seq}},{{$monitorSc->Version}})" ondblclick="">
                <td><input type=checkbox" class="d-none" value="{{$monitorSc->Job_Seq}}" />{{'job_'.$monitorSc->Job_WorkLargeCtg.'_'.$monitorSc->Job_WorkMediumCtg.'_'.$monitorSc->Job_Seq}}</td>
                <td>{{$monitorSc->Job_Name}}</td>
                <td>{{$monitorSc->Job_RegId}}</td>
                <td>{{$monitorSc->Job_Sulmyung}}</td>
                <td>{{$monitorSc->JobSM_IP}}</td>
                <td>{{$monitorSc->Job_Status}}</td>
                <td>{{substr($monitorSc->JobSM_P_StartTime,0,16)}}</td>
                <td>{{substr($monitorSc->JobSM_P_EndTime,0,16)}}</td>
                <td>{{intval($monitorSc->P_YesangTimeHap/1440)==0?"":intval($monitorSc->P_YesangTimeHap/1440)."일"}}{{intval($monitorSc->P_YesangTimeHap%1440/60)==0?"":intval($monitorSc->P_YesangTimeHap%1440/60)."시간"}}{{intval($monitorSc->P_YesangTimeHap%60)==0?"":intval($monitorSc->P_YesangTimeHap%60)."분"}}</td>
                <td>{{intval($monitorSc->P_YesangMaxTimeHap/1440)==0?"":intval($monitorSc->P_YesangMaxTimeHap/1440)."일"}}{{intval($monitorSc->P_YesangMaxTimeHap%1440/60)==0?"":intval($monitorSc->P_YesangMaxTimeHap%1440/60)."시간"}}{{intval($monitorSc->P_YesangMaxTimeHap%60)==0?"":intval($monitorSc->P_YesangMaxTimeHap%60)."분"}}</td>
                <td class="text-center"><button type="button" class="btn btn-sm btn-danger">종료</button></td>
            </tr>
            @endforeach
        @endIf  --}}
    </tbody>
</table>
{{-- 페이징 이동 경로 --}}
@if(isset($paginator))
{{$paginator->setPath('/monitoring/monitorJobSearchList')->appends(request()->except($searchParams))->links()}}
@endIf