<table id ="datatable" class="table table-bordered" cellspacing="0">
    <colgroup>
      <col width="160px" />
      <col width="200px" />
      <col width="100px" />
      <col width="300px" />
      <col width="150px" />
      <col width="100px" />
      <col width="150px" />
      <col width="150px" />
      <col width="130px" />
      <col width="130px" />
      {{--  <col width="100px" />  --}}
      <col width="100px" />
    </colgroup>
    <thead>
    <tr>
        <th>ID</th>
        <th>명</th>
        <th>실행자</th>
        <th>설명</th>
        <th>IP</th>
        <th>상태</th>
        <th>시작일</th>
        <th>종료일</th>
        <th>예상시간</th>
        <th>최대예상시간</th>
        {{--  <th>재작업</th>  --}}
        <th>종료</th>
    </tr>
    </thead>
    <tbody>
        {{--  조회된 값이 보여주는 위치 --}}
        @if(isset($data))
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
        @endIf
    </tbody>
</table>
{{-- 페이징 이동 경로 --}}
@if(isset($paginator))
{{$paginator->setPath('/monitoring/monitorJobSearchList')->appends(request()->except($searchParams))->links()}}
@endIf