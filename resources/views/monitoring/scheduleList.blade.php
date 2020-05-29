<table id ="scheduleList" class="table table-bordered" cellspacing="0">
    <colgroup>
        <col width="80px" />
        <col width="200px" />
        <col width="200px" />
        <col width="250px" />
        <col width="120px" />
        <col width="180px" />
        <col width="180px" />
        <col width="180px" />
        <col width="80px" />
        <col width="80px" />
        <col width="80px" />
        <col width="80px" />
        <col width="400px" />
        {{--  <col width="150px" />
        <col width="150px" />  --}}
        <col width="150px" />
        <col width="300px" />
        <col width="100px" />
    </colgroup>
    <thead>
    <tr>
        <th rowspan="2">순서</th>
        <th rowspan="2">쉘</th>
        <th rowspan="2">명</th>
        <th rowspan="2">설명</th>
        <th rowspan="2">상태</th>
        <th rowspan="2">시작일</th>
        <th rowspan="2">실행시각</th>
        <th rowspan="2">완료시각</th>
        <th colspan="4">프로그램 상태</th>
        <th rowspan="2">파라미터</th>
        <th rowspan="2">등록일</th>
        <th rowspan="2">비고</th>
        <th rowspan="2">재작업</th>
    </tr>
    <tr>
        <th>완료</th>
        <th>실행중</th>
        <th>대기</th>
        <th>오류</th>
    </tr>
    </thead>
    <tbody>
        {{--  조회된 값이 보여주는 위치 --}}
        @if(isset($data))
            @foreach($data as $monitorSc)
            <tr class="OneDbClickCss1" data-Job_Seq="{{$monitorSc->Job_Seq}}" data-Sc_Seq="{{$monitorSc->Sc_Seq}}" data-RegDate="{{$monitorSc->Sc_RegDate}}" onclick="monitor.scheduleProcessList({{$monitorSc->Job_Seq}},{{$monitorSc->Sc_Seq}})" ondblclick="monitor.scheduleDetailPopup({{$monitorSc->Job_Seq}},{{$monitorSc->Sc_Seq}})">
                <td class="text-center">{{$monitorSc->rnum}}</td>
                <td class="text-center">{{'job_'.$monitorSc->Job_WorkLargeCtg.'_'.$monitorSc->Job_WorkMediumCtg.'_'.$monitorSc->Job_Seq.'_'.$monitorSc->Sc_Seq.'.sh'}}</td>
                <td>{{$monitorSc->Job_Name}}</td>
                <td>{{$monitorSc->Sc_Sulmyung}}</td>
                <td class="text-center">{{$monitorSc->Sc_Status}}</td>
                <td class="text-center">{{$monitorSc->Sc_CronTime}}</td>
                <td class="text-center">{{$monitorSc->Sc_StartTime}}</td>
                <td class="text-center">{{$monitorSc->Sc_EndTime}}</td>
                <td class="text-center">{{$monitorSc->Status90}}개</td>
                <td class="text-center">{{$monitorSc->Status20}}개</td>
                <td class="text-center">{{$monitorSc->Status10}}개</td>
                <td class="text-center">{{$monitorSc->Status40}}개</td>
                <td class="overflow-auto" style="text-overflow: clip;">
                  @php
                    $paramLength = count(explode('||',$monitorSc->Sc_Param));
                    for ($i=0; $i < $paramLength; $i++) { 
                      echo '<p class="form-control form-control-sm d-inline-block w-auto readonly mx-2 my-0">'.explode('||',$monitorSc->Sc_Param)[$i].'</p>';
                    }
                  @endphp
                </td>
                <td class="text-center">{{explode(" ",$monitorSc->Sc_RegDate)[0]}}</td>
                <td>{{explode(" ",$monitorSc->Sc_Note)[0]}}</td>
                @php
                    if(intVal($monitorSc->Status20<=0)) {
                        if((int)$monitorSc->Status90+(int)$monitorSc->Status40 !=0){
                            echo '<td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="monitor.reWorkScheduleChk('.$monitorSc->Sc_Seq.')">재작업</button></td>';
                        } else {
                            echo '<td class="text-center">-</td>';
                        }
                    } else {
                        echo '<td class="text-center">-</td>';
                    }
                @endphp
            </tr>
            @endforeach
        @endIf 
    </tbody>
</table>
{{-- 페이징 이동 경로 --}}
@if(isset($paginator))
    {{$paginator->setPath('/monitoring/scheduleList')->appends(request()->except($searchParams))->links()}}
@endIf

