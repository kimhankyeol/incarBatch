@php
if (isset($detailList)) {
  $arrNum = ($page1 -1) * 5;
  echo '<h5 class="my-4 font-weight-bold text-primary" id="monitorJob" data-value="'.$detailList[$arrNum]->Job_Seq.'">'.'job_'.$detailList[$arrNum]->Job_WorkLargeCtg.'_'.$detailList[$arrNum]->Job_WorkMediumCtg.'_'.$detailList[$arrNum]->Job_Seq.' - '.$detailList[$arrNum]->Job_Name.'</h5>';
} else {
  echo '<h5 class="my-4 font-weight-bold text-primary">상세 잡 리스트</h5>';
}
@endphp
<table id="datatable2" class="table table-bordered" cellspacing="0">
    <colgroup>
      <col width="80px" />
      <col width="200px" />
      <col width="140px" />
      <col width="150px" />
      <col width="150px" />
      <col width="60px" />
      <col width="60px" />
      <col width="60px" />
      <col width="60px" />
      <col width="350px" />
      <col width="100px" />
    </colgroup>
      <thead>
        <tr>
          <th>순서</th>
          <th>쉘</th>
          <th>설명</th>
          <th>실행시각</th>
          <th>완료시각</th>
          <th>완료</th>
          <th>실행</th>
          <th>대기</th>
          <th>오류</th>
          <th>파라미터</th>
          <th>재작업</th>
      </tr>
      </thead>
      <tbody>
            {{--  조회된 값이 보여주는 위치 --}}
          @if (isset($detailList))
            @foreach($detailList as $index=>$detailSc)
              <tr class="OneDbClickCss" onclick="monitor.scheduleProcessList({{$detailSc->Job_Seq}},{{$detailSc->Sc_Seq}})" ondblclick="monitor.scheduleDetailPopup({{$detailSc->Job_Seq}},{{$detailSc->Sc_Seq}})">
                <td class="text-center Sc_Seq" data-value="{{$detailSc->Sc_Seq}}">{{$index+1}}</td>
                <td class="Job_Seq" data-value="{{$detailSc->Job_Seq}}">{{'job_'.$detailSc->Job_WorkLargeCtg.'_'.$detailSc->Job_WorkMediumCtg.'_'.$detailSc->Job_Seq.'_'.$detailSc->Sc_Seq.'.sh'}}</td>
                <td>{{$detailSc->Sc_Sulmyung}}</td>
                <td class="text-center">{{$detailSc->Sc_StartTime=="0000-00-00 00:00:00"?"":$detailSc->Sc_StartTime}}</td>
                <td class="text-center">{{$detailSc->Sc_EndTime=="0000-00-00 00:00:00"?"":$detailSc->Sc_EndTime}}</td>
                <td class="text-center">{{$detailSc->Status90}}개</td>
                <td class="text-center">{{$detailSc->Status20}}개</td>
                <td class="text-center">{{$detailSc->Status10}}개</td>
                <td class="text-center">{{$detailSc->Status40}}개</td>
                {{--  <td class="text-center">{{$detailSc->Sc_Param}}</td>  --}}

                <td class="overflow-auto">
                  @php
                    $paramLength = count(explode('||',$detailSc->Sc_Param));
                    for ($i=0; $i < $paramLength; $i++) { 
                      echo '<p class="form-control form-control-sm d-inline-block w-auto readonly mx-2 my-0">'.explode('||',$detailSc->Sc_Param)[$i].'</p>';
                    }
                  @endphp
                </td>
                <td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="monitor.reWorkSchedule({{$detailSc->Sc_Seq}})">재작업</button></td>
              </tr>
              @endforeach
            @endIf 
      </tbody>
  </table>
@if(isset($paginator1))
  {{$paginator1->setPath('/monitoring/monitorJobDetailList')->appends(request()->except($searchParams))->links()}}
@endIf