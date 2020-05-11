@php
if (isset($JobDetailList)) {
  echo '<h5 class="my-4 font-weight-bold text-primary">'.'job_'.$JobDetailList[0]->Job_WorkLargeCtg.'_'.$JobDetailList[0]->Job_WorkMediumCtg.'_'.$JobDetailList[0]->Job_Seq.' - '.$JobDetailList[0]->Job_Name.'</h5>';
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
      <col width="180px" />
      <col width="350px" />
      <col width="150px" />
      <col width="150px" />
    </colgroup>
      <thead>
        <tr>
          <th>순번</th>
          <th>ID</th>
          <th>설명</th>
          <th>실행시각</th>
          <th>완료시각</th>
          <th>완료/실행/대기/오류</th>
          <th>파라미터</th>
          <th>예상시간</th>
          <th>최대예상시간</th>
      </tr>
      </thead>
      <tbody>
        {{-- <tr class="jobExeOneDbClick">
          <td class="text-center Sc_Seq" data-value="{{1}}">4</td>
          <td class="Job_Seq" data-value="{{1}}">job_1000_100_1_1</td>
          <td>잡1</td>
          <td class="text-center">2020-05-06 06:20</td>
          <td class="text-center"></td>
          <td class="text-center">1/1/2/0</td>
          <td class="text-center">2020 || 05 || 01 || KB손해보험</td>
          <td class="text-center">1시간30분</td>
          <td class="text-center">2시간</td>
        </tr>
        <tr class="jobExeOneDbClick">
          <td class="text-center Sc_Seq" data-value="{{2}}">3</td>
          <td class="Job_Seq" data-value="{{1}}">job_1000_100_1_1</td>
          <td>잡1</td>
          <td class="text-center">2020-05-06 01:00</td>
          <td class="text-center">2020-05-06 02:00</td>
          <td class="text-center">4/0/0/0</td>
          <td class="text-center">2020 || 04 || 01 || KB손해보험</td>
          <td class="text-center">1시간30분</td>
          <td class="text-center">2시간</td>
        </tr>
        <tr>
          <td class="text-center">2</td>
          <td>job_1000_100_1</td>
          <td>잡1</td>
          <td class="text-center">2020-05-05 16:30</td>
          <td class="text-center">2020-05-05 17:30</td>
          <td class="text-center">4/0/0/0</td>
          <td class="text-center">2020 || 04 || 01 || KB손해보험</td>
          <td class="text-center">1시간30분</td>
          <td class="text-center">2시간</td>
        </tr>
        <tr>
          <td class="text-center">1</td>
          <td>job_1000_100_1</td>
          <td>잡1</td>
          <td class="text-center">2020-05-05 10:00</td>
          <td class="text-center">2020-05-05 11:00</td>
          <td class="text-center">4/0/0/0</td>
          <td class="text-center">2020 || 03 || 01 || KB손해보험</td>
          <td class="text-center">1시간30분</td>
          <td class="text-center">2시간</td>
        </tr> --}}
            {{--  조회된 값이 보여주는 위치 --}}
          @if (isset($JobDetailList))
            @foreach($JobDetailList as $detailSc )
              <tr class="jobExeOneDbClick">
                <td class="text-center Sc_Seq" data-value="{{$detailSc->Sc_Seq}}">{{$detailSc->Sc_Seq}}</td>
                <td class="Job_Seq" data-value="{{$detailSc->Sc_Seq}}">{{'job_'.$detailSc->Job_WorkLargeCtg.'_'.$detailSc->Job_WorkMediumCtg.'_'.$detailSc->Job_Seq}}</td>
                <td>{{$detailSc->Sc_Sulmyung}}</td>
                <td class="text-center">{{$detailSc->Sc_StartTime}}</td>
                <td class="text-center">{{$detailSc->Sc_EndTime}}</td>
                <td class="text-center">{{$detailSc->cnt}}</td>
                <td class="text-center">{{$detailSc->Sc_Param}}</td>
                <td class="text-center">{{$detailSc->P_YesangTimeHap}}</td>
                <td class="text-center">{{$detailSc->P_YesangMaxTimeHap}}</td>
              </tr>
              @endforeach
            @endIf 
      </tbody>
  </table>
