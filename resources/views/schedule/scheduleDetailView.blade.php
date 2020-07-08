<!DOCTYPE html>
<html lang="en">
@include('common.head')
<script>document.title="스케줄 상세"</script>
<link rel="stylesheet" href="/css/tab.css">
<script>
function tabHideShow(pSeq){
  $('.tab-pane').removeClass('active show');
  $('.gpLi').removeClass('active')
  $('#'+pSeq).addClass('active show');
  $('#gpLi'+pSeq).addClass('active');
}
</script>
<body id="page-top">
  <div id="wrapper" class="bodyBgImg">
    {{-- 블레이드 주석 쓰는 법--}}
    {{--사이드바 시작--}}
    @include('common.sidebar')
    {{--사이드바 끝--}}
    {{--content 시작--}}
    <div class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <!-- DataTales Example -->
          <h4 class="h3 my-4 font-weight-bold" style="color:white">스케줄</h4>
          <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-2 text-center align-self-center font-weight-bold">잡 Id</div>
                    <input id="jobSc_id" type="text" class="col-md-2 form-control form-control-sm align-self-center"  value="{{'job_'.$jobDetail[0]->job_worklargectg.'_'.$jobDetail[0]->job_workmediumctg.'_'.$jobDetail[0]->job_seq}}" readonly>
                    <div class="col-md-2 text-center align-self-center font-weight-bold mt-2">잡 명</div>
                    <input id = "jobSc_name" type="text" class="col-md-5 form-control form-control-sm mt-2" value="{{$jobDetail[0]->job_name}}" readonly>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-2 text-center align-self-center font-weight-bold mt-2">스케줄 Id</div>
                    <input type="text" class="col-md-2 form-control form-control-sm mt-2" value="{{'job_'.$jobDetail[0]->job_worklargectg.'_'.$jobDetail[0]->job_workmediumctg.'_'.$jobDetail[0]->job_seq.'_'.$scheduleDetail[0]->sc_seq}}" readonly>
                    <div class="col-md-2 text-center align-self-center font-weight-bold">실행 주기 설명</div>
                    <input type="text" class="col-md-5 form-control form-control-sm align-self-center" value="{{$scheduleDetail[0]->sc_cronsulmyung}}" readonly> 
                  </div>
                <hr>
                <div class="row">
                  <div class="col-md-2 text-center align-self-center font-weight-bold mt-2">스케줄 설명</div>
                  <textarea id="Sc_Sulmyung"  class="col-md-10 form-control form-control-sm mt-2"  maxlength="2000" placeholder="스케줄 설명" readonly>{{$scheduleDetail[0]->sc_sulmyung}}</textarea>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-2 text-center align-self-center font-weight-bold">시작 시간</div>
                  <input type="text" class="col-md-3 form-control form-control-sm align-self-center" value="{{$scheduleDetail[0]->sc_crontime}}" readonly>
                  <div class="col-md-2 text-center align-self-center font-weight-bold">종료 시간</div>
                  <input type="text" class="col-md-3 form-control form-control-sm align-self-center" value="{{$scheduleDetail[0]->sc_cronendtime}}" readonly>  
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-6 text-center">
                    <div class="col-md-12 text-center align-self-center font-weight-bold ">배치 작업 평균 소요시간</div>
                    <div class="d-inline-block col-md-3 text-center align-self-center font-weight-bold ">일 / 시 / 분</div>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center"  value="{{empty($scheduleTotalTime[0]->sc_yesangtime) ? 0:intval($scheduleTotalTime[0]->sc_yesangtime/1440)}}" readonly numberOnly>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" value="{{empty($scheduleTotalTime[0]->sc_yesangtime) ? 0:intval($scheduleTotalTime[0]->sc_yesangtime%1440/60)}}" readonly numberOnly>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center"  value="{{empty($scheduleTotalTime[0]->sc_yesangtime) ? 0:intval($scheduleTotalTime[0]->sc_yesangtime%60)}}" readonly numberOnly>
                  </div>
                  <div class="col-md-6 text-center">
                    <div class="col-md-12 text-center align-self-center font-weight-bold ">배치 작업 최대 소요시간</div>
                    <div class="d-inline-block col-md-3 text-center align-self-center font-weight-bold ">일 / 시 / 분</div>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center"  value="{{empty($scheduleTotalTime[0]->sc_yesangmaxtime) ? 0:intval($scheduleTotalTime[0]->sc_yesangmaxtime/1440)}}" readonly numberOnly>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" value="{{empty($scheduleTotalTime[0]->sc_yesangmaxtime) ? 0:intval($scheduleTotalTime[0]->sc_yesangmaxtime%1440/60)}}" readonly numberOnly>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center"  value="{{empty($scheduleTotalTime[0]->sc_yesangmaxtime) ? 0:intval($scheduleTotalTime[0]->sc_yesangmaxtime%60)}}" readonly numberOnly>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-3 text-center align-self-center font-weight-bold">스케줄 상태</div>
                  <input type="text" class="col-md-2 form-control form-control-sm align-self-center" value="{{$scheduleDetail[0]->sc_statusname}}" readonly>
                  @if(isset($jobGusungContents))
                    <div class="col-md-3 text-center align-self-center font-weight-bold">구성 프로세스 개수</div>
                    <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="{{isset($jobGusungContents) ? count($jobGusungContents):0}}" readonly>
                  @endIf 
                </div>
                <hr>
                <div class="row justify-content-center">
                  <div class="limit-time-text col-md-auto">등록자</div>
                  <input id="P_RegId" type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto" value="{{$scheduleDetail[0]->sc_regid}}" readonly>
                  <div class="limit-time-text col-md-auto">등록자IP</div>
                  <input id="P_RegIp" type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto" value="{{$scheduleDetail[0]->sc_regip}}" readonly>
                  <div class="limit-time-text col-md-auto">등록일</div>
                  <input id="P_RegDate" type="text" class="form-control form-control-sm limit-time-input col-md-auto w-auto" value="{{$scheduleDetail[0]->sc_regdate}}" readonly>    
                  <div class="limit-time-text col-md-auto">수정자</div>
                  <input type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto" value="{{empty($scheduleDetail[0]->sc_updid) ? $scheduleDetail[0]->sc_regid:$scheduleDetail[0]->sc_updid}}" readonly>   
                  <div class="limit-time-text col-md-auto">수정자IP</div>
                  <input type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto"  value="{{empty($scheduleDetail[0]->sc_updip) ? $scheduleDetail[0]->sc_regip:$scheduleDetail[0]->sc_updip}}" readonly>       
                  <div class="limit-time-text col-md-auto">수정일</div>
                  <input type="text" class="form-control form-control-sm limit-time-input col-md-auto w-auto" value="{{empty($scheduleDetail[0]->sc_upddate) ? $scheduleDetail[0]->sc_regdate:$scheduleDetail[0]->sc_upddate}}" readonly> 
                </div>
                <hr>
                <div class="row justify-content-center">
                  <div class="limit-time-text col-md-2">비고</div>
                  <textarea id="Sc_Note" class="form-control col-md-10" maxlength="2000" readonly>{{$scheduleDetail[0]->sc_note}}</textarea>
                </div>
                <hr>
                
                <fieldset class="cistp-fieldset">
                  <legend>파라미터 입력</legend>
                  <div class="col-md-12">
                        @if(isset($jobDetail[0]->job_params))
                          @php
                            $jobParamArr=explode("||",$jobDetail[0]->job_params);
                            $jobParamSulArr=explode("||",$jobDetail[0]->job_paramsulmyungs);
                            for ($i = 0; $i < count($jobParamArr); $i++) {
                            echo '<div class="d-inline-flex w-50 delYN mb-2">';
                            echo '<div class="col-md-3 small align-self-center text-center">잡 파라미터 '.intVal($i+1).')</div>';
                            if($jobParamArr[$i]=="paramNum"){
                              echo '<input type="text" class="col-md-2  form-control form-control-sm" placeholder="숫자" readonly/>';
                              echo '<input type="text" name="Sc_Param" class="col-md-6 form-control form-control-sm" placeholder="'.$jobParamSulArr[$i].'" numberonly> </div>' ;
                              echo '<input type="hidden" name="Job_Params"  value="'.$jobParamArr[$i].'"/>';
                              echo '<input type="hidden" name="jobParamSulArr" value="'.$jobParamSulArr[$i].'"/>';
                            }else if($jobParamArr[$i]=="paramStr"){
                              echo '<input type="text" class="col-md-2 form-control form-control-sm" placeholder="문자" readonly/>';
                              echo '<input type="text" name="Sc_Param" class="col-md-6 form-control form-control-sm" placeholder="'.$jobParamSulArr[$i].'"> </div>' ;
                              echo '<input type="hidden" name="Job_Params"  value="'.$jobParamArr[$i].'"/>';
                              echo '<input type="hidden" name="jobParamSulArr" value="'.$jobParamSulArr[$i].'"/>';
                            }
                            }
                          @endphp
                        @endif
                      </div>
                </fieldset>
  
              <fieldset class="cistp-fieldset">
                <legend>구성 프로그램</legend>
                @if(isset($jobGusungContents))
                  <ul class="nav nav-tabs">
                    @foreach($jobGusungContents as $index => $data)
                      @if($index==0)
                        <li id="{{'gpLi'.$data->p_seq}}" class="active gpLi"><a class="active" href="{{'#'.$data->p_seq}}"  onclick="tabHideShow('{{$data->p_seq}}')"  data-toggle="tab">{{intVal($index+1)."번 프로그램 : ".$data->p_file}}</a></li>
                      @else
                        <li id="{{'gpLi'.$data->p_seq}}" class="gpLi"><a href="{{'#'.$data->p_seq}}" data-toggle="tab"  onclick="tabHideShow('{{$data->p_seq}}')">{{intVal($index+1)."번 프로그램 : ".$data->p_file}}</a></li>
                      @endif
                    @endforeach
                  </ul>
                  <div class="tab-content">
                    @foreach($jobGusungContents as $index => $data)
                      @include('schedule.scheduleGusungProgramDetailTabView')
                    @endforeach
                  </div>
                @endif
              </fieldset>
              <fieldset class="cistp-fieldset">
                <legend>스케줄 재작업 히스토리</legend>
                  <table id="datatable" class="table table-bordered" cellspacing="0">
                    <colgroup>
                      <col width="8%" />
                      <col width="30%" />
                      <col width="16%" />
                      <col width="16%" />
                      <col width="10%" />
                      <col width="20%" />
                    </colgroup>
                      <thead>
                        <tr>
                          <th>스케줄 번호</th>
                          <th>스케줄 설명</th>
                          <th>스케줄 시작 일시</th>
                          <th>스케줄 종료 일시</th>
                          <th>상태</th>
                          <th>비고</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($scheduleReworkHistory as $i => $value)
                          <tr class="text-center" style="{{(count($scheduleReworkHistory)==intVal($i+1)) ? "background-color:#eaecf4":"" }}">
                              <td>{{$value->sc_seq}}</td>
                              <td><textarea class="form-control" style="width:100%" readonly>{{$value->sc_sulmyung}}</textarea></td>
                              <td>{{$value->sc_starttime}}</td>
                              <td>{{$value->sc_endtime}}</td>
                              <td>{{$value->sc_status}}</td>
                              <td>{{$value->sc_note}}</td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
              </fieldset>
              
                <hr>
              <div class="row justify-content-end">
                <div class="mt-3 mr-2 btn btn-secondary" onclick="job.scheduleDump()">삭제</div>
                <div class="mt-3 mr-2 btn btn-danger" onclick="location.href='/schedule/scheduleListView?page=1'">취소</div>
              </div>              
            </div>
          </div>
        </div>
      </div>
       <input type="hidden" id="Sc_Seq" class="col-md-2 form-control form-control-sm align-self-center"  value="{{$scheduleDetail[0]->sc_seq}}" readonly>
       {{-- <input type="hidden" id="Job_RegID" class="col-md-2 form-control form-control-sm align-self-center"  value="{{$jobDetail[0]->job_regid}}" readonly>
        <input type="hidden" id="Sc_Status" class="col-md-2 form-control form-control-sm align-self-center"  value="{{$scheduleDetail[0]->sc_status}}" readonly> --}}
  {{--content 끝--}}
    <script>
      $("input:text[numberOnly]").on("keyup", function() {
        $(this).val($(this).val().replace(/[^0-9]/g,""));
      });    
      const popup = {
        jobGusung:function(Job_Seq){
          window.open('/popup/jobGusung?Job_Seq='+Job_Seq, '잡 구성', 'top=10, left=10, width=1400, height=720, status=no, location=no, directories=no, status=no, menubar=no, toolbar=no, scrollbars=yes, resizable=no');
        }
      }
    </script>
    </div>
  </div>
</body>
</html>

