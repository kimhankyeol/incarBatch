<table id ="datatable" class="table table-bordered" cellspacing="0">
    <colgroup>
        <col width="160px" />
        <col width="200px" />
        <col width="250px" />
        <col width="180px" />
        <col width="130px" />
        <col width="150px" />
        <col width="100px" />
    </colgroup>
    <thead>
    <tr>
        <th>ID</th>
        <th>명</th>
        <th>설명</th>
        <th>실행/예약/완료/오류</th>
        <th>예상시간</th>
        <th>최대예상시간</th>
        <th>등록일</th>
    </tr>
    </thead>
    <tbody>
        {{--  조회된 값이 보여주는 위치 --}}
        @if(isset($data))
            @foreach($data as $monitorSc)
            <tr class="jobOneDbClick" onclick="monitor.detailList({{$monitorSc->Job_Seq}})" ondblclick="">
                <td class="text-center"><input type="checkbox" class="d-none" value="{{$monitorSc->Job_Seq}}" />{{'job_'.$monitorSc->Job_WorkLargeCtg.'_'.$monitorSc->Job_WorkMediumCtg.'_'.$monitorSc->Job_Seq}}</td>
                <td>{{$monitorSc->Job_Name}}</td>
                <td>{{$monitorSc->Job_Sulmyung}}</td>
                <td class="text-center">{{$monitorSc->cnt}}</td>
                <td class="text-center">{{intval($monitorSc->P_YesangTimeHap/1440)==0?"":intval($monitorSc->P_YesangTimeHap/1440)."일"}}{{intval($monitorSc->P_YesangTimeHap%1440/60)==0?"":intval($monitorSc->P_YesangTimeHap%1440/60)."시간"}}{{intval($monitorSc->P_YesangTimeHap%60)==0?"":intval($monitorSc->P_YesangTimeHap%60)."분"}}</td>
                <td class="text-center">{{intval($monitorSc->P_YesangMaxTimeHap/1440)==0?"":intval($monitorSc->P_YesangMaxTimeHap/1440)."일"}}{{intval($monitorSc->P_YesangMaxTimeHap%1440/60)==0?"":intval($monitorSc->P_YesangMaxTimeHap%1440/60)."시간"}}{{intval($monitorSc->P_YesangMaxTimeHap%60)==0?"":intval($monitorSc->P_YesangMaxTimeHap%60)."분"}}</td>
                <td class="text-center">{{substr($monitorSc->Job_RegDate,0,10)}}</td>
            </tr>
            @endforeach
        @endIf 
    </tbody>
</table>
{{-- 페이징 이동 경로 --}}
@if(isset($paginator))
{{$paginator->setPath('/monitoring/monitorJobSearchList')->appends(request()->except($searchParams))->links()}}
@endIf
