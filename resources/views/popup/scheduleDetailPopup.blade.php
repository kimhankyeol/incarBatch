<?php
//분기 처리 해주는 php 위치 
$ifViewRender = new App\Http\Controllers\Render\IfViewRender;
$ifViewRender->setRenderInfo($_SERVER['REQUEST_URI']);
//include 될 blade.php 의 경로 + 파일명을 가져옴
//title 변경 스크립트  common/head.blade 쓰이는 변수 
$titleInfo  = $ifViewRender->getHtmlTitle();
//url 에따른 resource 변경 추가 할떄   common/head.blade 쓰이는 변수 
$resourceInfo = $ifViewRender->getResource();
//사이드바 정보   common/sidebar.blade
$sidebarInfo = $ifViewRender->getSidebarArray();
?>
<!DOCTYPE html>
<html lang="en">
@include('common.head')
<body class="bodyPopupBg">
    {{--content 시작--}}
      <!-- Main Content -->
      <div id="content">
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <h4 class="p-2 flex-grow-1 font-weight-bold text-white">스케줄 정보 상세</h4>
          <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row mb-2">
                  <div class="col-md-2 text-center align-self-center font-weight-bold">잡 ID</div>
                    <input id="jobSc_id" type="text" class="col-md-2 form-control form-control-sm align-self-center"  value="{{'job_'.$jobDetail[0]->job_worklargectg.'_'.$jobDetail[0]->job_workmediumctg.'_'.$jobDetail[0]->job_seq}}" readonly>
                    <div class="col-md-2 text-center align-self-center font-weight-bold">잡 명</div>
                    <input id = "jobSc_name" type="text" class="col-md-6 form-control form-control-sm" value="{{$jobDetail[0]->job_name}}" readonly>
                  </div>
                  <div class="row mb-2">
                    <div class="col-md-2 text-center align-self-center font-weight-bold">스케줄 번호</div>
                    <input id="Sc_Seq" type="text" class="col-md-2 form-control form-control-sm" value="{{$scheduleDetail[0]->sc_version}}" readonly>
                    <div class="col-md-2 text-center align-self-center font-weight-bold">실행 주기 설명</div>
                    <input type="text" class="col-md-6 form-control form-control-sm align-self-center" value="{{$scheduleDetail[0]->sc_cronsulmyung}}" readonly>   
                  </div>
                <div class="row mb-2">
                  <div class="col-md-2 text-center align-self-center font-weight-bold">스케줄 설명</div>
                  <textarea id="Sc_Sulmyung" type="text" class="col-md-10 form-control form-control-sm" readonly>{{$scheduleDetail[0]->sc_sulmyung}}</textarea>
                </div>
                <br>
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
                <br>
                <div class="row justify-content-center">
                  <div class="limit-time-text col-md-2">비고</div>
                  <textarea id="Sc_Note" class="form-control col-md-10" maxlength="2000" readonly> </textarea>
                </div>
                <hr>
                <div class="row mb-2">
                  <div class="col-md-3 text-center align-self-center font-weight-bold">시작 시간</div>
                  <input type="text" class="col-md-3 form-control form-control-sm align-self-center" value="{{$scheduleDetail[0]->sc_crontime}}" readonly>
                  <div class="col-md-3 text-center align-self-center font-weight-bold">종료 시간</div>
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
                <div class="row mb-2">
                  <div class="col-md-3 text-center align-self-center font-weight-bold">잡 상태</div>
                  <input type="text" class="col-md-3 form-control form-control-sm align-self-center" value="{{$scheduleDetail[0]->sc_statusname}}" readonly>
                  <div class="col-md-3 text-center align-self-center font-weight-bold">구성 프로세스 개수</div>
                  <input type="text" class="col-md-3 form-control form-control-sm align-self-center" placeholder="{{$jobDetail[0]->gusungcount}}" readonly> 
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12 font-weight-bold">
                    잡 파라미터
                  </div>
                  <hr>
                  <div class="col-md-12" id="jobParams">
                    @if(isset($jobDetail[0]->job_params))
                      @php
                        $jobParamArr=explode("||",$jobDetail[0]->job_params);
                        $jobParamSulArr=explode("||",$scheduleDetail[0]->sc_param);
                        for ($i = 0; $i < count($jobParamArr); $i++) {
                        echo '<div class="d-inline-flex w-50 delYN mb-2">';
                        echo '<div class="col-md-3 small align-self-center text-center">잡 파라미터</div>';
                        echo '<select name="Job_Params" class="col-md-2 form-control form-control-sm" readonly>';
                        if($jobParamArr[$i]=="paramNum"){
                          echo '<option value="'.$jobParamArr[$i].'" selected>숫자</option></select>';
                        }else if($jobParamArr[$i]=="paramStr"){
                          echo '<option value="'.$jobParamArr[$i].'" selected>문자</option></select>';
                        }
                        echo '<input type="text" name="Job_paramSulmyungs" class="col-md-6 form-control form-control-sm" value="'.$jobParamSulArr[$i].'" readonly> </div>' ;
                        }
                      @endphp
                    @endif
                  </div>
                </div>
                <fieldset class="cistp-fieldset mt-2">
                  <legend>구성 프로그램</legend>
                  {{-- 타이틀 --}}
                  <div class="overflow-auto">
                    <table id="datatable" class="table table-bordered" cellspacing="0">
                      <colgroup>
                        <col width="80px" />
                        <col width="200px" />
                        <col width="200px" />
                        <col width="200px" />
                        <col width="400px" />
                        <col width="200px" />
                        <col width="100px" />
                      </colgroup>
                      <thead>
                        <tr>
                          <th>순서</th>
                          <th>경로</th>
                          <th>프로그램</th>
                          <th>프로그램 명</th>
                          <th>파라미터</th>
                          <th>로그파일</th>
                          <th>재작업</th>
                        </tr>
                      </thead>
                      <tbody>
                      @if(isset($jobGusungContents))
                        @foreach($jobGusungContents as $index=> $data)
                          <tr>
                            <td class="text-center">{{$index+1}}</td>
                            <td>{{$data->p_filepath}}</td>
                            <td>{{$data->p_file}}</td>
                            <td class="text-center">{{$data->p_name}}</td>
                            <td>
                            @if(isset($data->p_params))
                              @php
                                $jobParamSulArr=explode("||",$scheduleDetail[0]->sc_param);
                                $Job_Params=explode("||",$data->job_params);
                                $JobGusung_ParamPos=explode("||",$data->jobgusung_parampos);
                                echo '<label class="mx-0 mb-1 row">';
                                for ($i = 0; $i < count($JobGusung_ParamPos); $i++) {
                                  echo '<p type="text" class="form-control form-control-sm d-inline-block col-md-3 overflow-auto readonly my-0 readonly">'.$jobParamSulArr[$JobGusung_ParamPos[$i]].'</p>';
                                }
                                echo '</label>';
                              @endphp
                            @endif
                            </td>
                            <td>
                             {{$data->sc_logfile}}
                            </td>
                            <td class="text-center">
                              @if(($data->sc_reworkyn)==1)
                                <label class="m-0 font-weight-bold">가능</label>
                              @else
                                <label class="m-0  font-weight-bold text-danger">불가능</label>
                              @endif
                            </td>
                          </tr>
                        @endforeach
                      @endIf
                      </tbody>
                    </table>
                  </div>
                  <button style="margin-top:10px;float: right;" class="btn btn_orange" onclick="window.close()"> 닫기 </button>
                </fieldset>
            </div>
          </div>
        </div>
      </div>
<input type="hidden" id="Job_RegID" class="col-md-2 form-control form-control-sm align-self-center"  value="{{$jobDetail[0]->job_regid}}" readonly>
</body>
</html>
