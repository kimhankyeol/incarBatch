@php
if (isset($detailList)) {
  $arrNum = ($page -1) * 5;
  echo '<h5 class="my-4 font-weight-bold text-primary" id="monitorJob" data-value="'.$detailList[$arrNum]->Job_Seq.'">'.'job_'.$detailList[$arrNum]->Job_WorkLargeCtg.'_'.$detailList[$arrNum]->Job_WorkMediumCtg.'_'.$detailList[$arrNum]->Job_Seq.' - '.$detailList[$arrNum]->Job_Name.'</h5>';
} else {
  echo '<h5 class="my-4 font-weight-bold text-primary">상세 잡 리스트</h5>';
}
@endphp
<table id="datatable2" class="table table-bordered" cellspacing="0">
    <colgroup>
      <col width="80px" />
      <col width="180px" />
      <col width="140px" />
      <col width="150px" />
      <col width="150px" />
      <col width="60px" />
      <col width="60px" />
      <col width="60px" />
      <col width="60px" />
      <col width="350px" />
      {{--  <col width="150px" />
      <col width="150px" />  --}}
    </colgroup>
      <thead>
        <tr>
          <th>순번</th>
          <th>ID</th>
          <th>설명</th>
          <th>실행시각</th>
          <th>완료시각</th>
          <th>완료</th>
          <th>실행</th>
          <th>대기</th>
          <th>오류</th>
          <th>파라미터</th>
          {{--  <th>예상시간</th>
          <th>최대예상시간</th>  --}}
      </tr>
      </thead>
      <tbody>
            {{--  조회된 값이 보여주는 위치 --}}
          @if (isset($detailList))
            @foreach($detailList as $detailSc)
              <tr class="jobExeOneDbClick">
                <td class="text-center Sc_Seq" data-value="{{$detailSc->Sc_Seq}}">{{$detailSc->Sc_Seq}}</td>
                <td class="Job_Seq" data-value="{{$detailSc->Job_Seq}}">{{'job_'.$detailSc->Job_WorkLargeCtg.'_'.$detailSc->Job_WorkMediumCtg.'_'.$detailSc->Job_Seq}}</td>
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
                      # code...
                      #echo '<label class="m-0">';
                      #echo '<input class="form-control form-control-sm col-md-6 border-0 bg-transparent shadow-none" type="text" readonly="" value="파라미터 '.intVal($i+1).' '.explode('||',$detailSc->Job_ParamSulmyungs)[explode('||',$detailSc->JobGusung_ParamPos)[$i]].'">';
                      echo '<p class="form-control form-control-sm d-inline-block w-auto readonly mx-2 my-0">'.explode('||',$detailSc->Sc_Param)[$i].'</p>';
                      #echo '</label>';
                    }
                  @endphp
                </td>

                {{--  <td class="text-center">{{$detailSc->P_YesangTimeHap}}</td>
                <td class="text-center">{{$detailSc->P_YesangMaxTimeHap}}</td>  --}}
              </tr>
              @endforeach
            @endIf 
      </tbody>
  </table>
  {{-- 페이징 ajax 해야함 !!!! --}}
@if(isset($paginator))
  {{$paginator->setPath('/monitoring/monitorJobDetailList')->appends(request()->except($searchParams))->links()}}
@endIf