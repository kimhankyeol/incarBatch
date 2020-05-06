@php
if (isset($GusungList)) {
    echo '<h5 class="my-4 font-weight-bold text-primary">'.'job_'.$GusungList[0]->Job_WorkLargeCtg.'_'.$GusungList[0]->Job_WorkMediumCtg.'_'.$GusungList[0]->Job_Seq.' - '.$GusungList[0]->Job_Name.'</h5>';
  } else {
    echo '<h5 class="my-4 font-weight-bold text-primary">상세 잡 리스트</h5>';
}
@endphp
<table id="datatable2" class="table table-bordered" cellspacing="0">
    <colgroup>
      <col width="50px" />
      <col width="180px" />
      <col width="140px" />
      <col width="180px" />
      <col width="100px" />
      <col width="120px" />
      <col width="120px" />
    </colgroup>
      <thead>
        <tr>
          <th>순서</th>
          <th>경로</th>
          <th>프로그램</th>
          <th>프로그램명</th>
          <th>상태</th>
          <th>예상시간</th>
          <th>최대예상시간</th>
        </tr>
      </thead>
      <tbody>
            {{--  조회된 값이 보여주는 위치 --}}
            {{--  @if (isset($GusungList))
            @foreach($GusungList as $gusungSc )
              <tr onclick="">
                <td>{{$gusungSc->JobGusung_Order}}</td>
                <td>{{$gusungSc->File_Path}}</td>
                <td>{{$gusungSc->P_File}}</td>
                <td>{{$gusungSc->P_Name}}</td>
                <td>{{$gusungSc->Job_Status}}</td>
                <td>{{intval($gusungSc->P_YesangTime/1440)==0?"":intval($gusungSc->P_YesangTime/1440)."일"}}{{intval($gusungSc->P_YesangTime%1440/60)==0?"":intval($gusungSc->P_YesangTime%1440/60)."시간"}}{{intval($gusungSc->P_YesangTime%60)==0?"":intval($gusungSc->P_YesangTime%60)."분"}}</td>
                <td>{{intval($gusungSc->P_YesangMaxTime/1440)==0?"":intval($gusungSc->P_YesangMaxTime/1440)."일"}}{{intval($gusungSc->P_YesangMaxTime%1440/60)==0?"":intval($gusungSc->P_YesangMaxTime%1440/60)."시간"}}{{intval($gusungSc->P_YesangMaxTime%60)==0?"":intval($gusungSc->P_YesangMaxTime%60)."분"}}</td>
              </tr>
              @endforeach
            @endIf  --}}
      </tbody>
  </table>