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
        <th rowspan="2">쉘 명</th>
        <th rowspan="2">잡 명</th>
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
            @foreach($data as $index => $monitorSc)
            <tr class="OneDbClickCss1" data-Job_Seq="{{$monitorSc->job_seq}}" data-Sc_Seq="{{$monitorSc->sc_seq}}" data-RegDate="{{$monitorSc->sc_regdate}}" data-Sc_Version="{{$monitorSc->sc_version}}" onclick="monitor.scheduleProcessList({{$monitorSc->job_seq}},{{$monitorSc->sc_seq}})" ondblclick="monitor.scheduleDetailPopup({{$monitorSc->job_seq}},{{$monitorSc->sc_seq}})">
                <td class="text-center">{{$index+1}}</td>
                <td class="text-center">{{'job_'.$monitorSc->job_worklargectg.'_'.$monitorSc->job_workmediumctg.'_'.$monitorSc->job_seq.'_'.$monitorSc->sc_seq.'.sh'}}</td>
                <td>{{$monitorSc->job_name}}</td>
                <td>{{$monitorSc->sc_sulmyung}}</td>
                <td class="text-center">{{$monitorSc->sc_status}}</td>
                <td class="text-center">{{$monitorSc->sc_crontime}}</td>
                <td class="text-center">{{$monitorSc->sc_starttime}}</td>
                <td class="text-center">{{$monitorSc->sc_endtime}}</td>
                <td class="text-center">{{$monitorSc->status90}}개</td>
                <td class="text-center">{{$monitorSc->status20}}개</td>
                <td class="text-center">{{$monitorSc->status10}}개</td>
                <td class="text-center">{{$monitorSc->status40}}개</td>
                <td class="overflow-auto" style="text-overflow: clip;">
                  @php
                    $paramLength = count(explode('||',$monitorSc->sc_param));
                    for ($i=0; $i < $paramLength; $i++) { 
                      echo '<p class="form-control form-control-sm d-inline-block w-auto readonly mx-2 my-0">'.explode('||',$monitorSc->sc_param)[$i].'</p>';
                    }
                  @endphp
                </td>
                <td class="text-center">{{explode(" ",$monitorSc->sc_regdate)[0]}}</td>
                <td>{{$monitorSc->sc_note}}</td>
                @php
                    if(intVal($monitorSc->status20<=0)) {
                        //한개라도 실행중이면 재작업 불가
                        if(((int)$monitorSc->status90+(int)$monitorSc->status40 !=0 )&&(int)$monitorSc->sc_rebutton==0){
                            echo '<td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="monitor.reWorkScheduleChk('.$monitorSc->sc_seq.')">재작업</button></td>';
                        } else {
                            echo '<td class="text-center">-</td>';
                        }
                    } else {
                        echo '<td class="text-center">-</td>';
                    }
                @endphp
            </tr>
            @endforeach
       
    </tbody>
</table>
{{-- 페이징 이동 경로 --}}

{{-- @if(isset($paginator1)&&(isset($paginator)&&$paginator==null))
{{$paginator1->setPath('/monitoring/scheduleList')->appends(request()->except($searchParams))->links()}}
@endIf --}}


@endIf 

