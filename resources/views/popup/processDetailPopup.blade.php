
<!DOCTYPE html>
<html lang="en">
@include('popup.popupCommon.head')
<script>document.title="프로그램 상세 팝업"</script>
@include('popup.popupCommon.popupJs')
<body class="bodyPopupBg">
        <!-- Main Content -->
      <div id="content" class="gusung-popup">
          <div class="container-fluid">
              <h4 class="p-2 flex-grow-1 font-weight-bold text-white">스케줄 프로그램 상세 정보</h4>
              <div class="card shadow mb-4">
                  <div class="card-body">
                    <div class="custom-row">
                        <input id="Job_Seq" type="hidden" value="{{$processDetail[0]->job_seq}}"/>
                        <input id="P_Seq" type="hidden" value="{{$processDetail[0]->p_seq}}"/>
                        <input id="Sc_Seq" type="hidden" value="{{$processDetail[0]->sc_seq}}"/>
                        <div class="text-center align-self-center font-weight-bold mx-2">대분류</div>
                        <input id="workLargeVal" type="text" class="form-control form-control-sm mx-2" value="{{$processDetail[0]->p_worklargename}}" style="cursor:not-allowed" readonly>
                        <div class="text-center align-self-center font-weight-bold mx-2">중분류</div>
                        <input id="workMediumVal" type="text" class="form-control form-control-sm mx-2" value="{{$processDetail[0]->p_workmediumname}}" readonly>
                        <div class="text-center align-self-center font-weight-bold">프로그램 ID</div>
                        <input id ="processPath" type="text" class="form-control form-control-sm align-self-center"  value="{{$processDetail[0]->filepath}}" readonly>
                        <input id ="processFile" type="text" class="form-control form-control-sm align-self-center" value="{{$processDetail[0]->p_file}}" readonly>
                        <div class="mx-2 custom-control custom-checkbox small align-middle">
                          <input id="retry" type="checkbox" class="custom-control-input" {{$processDetail[0]->sc_reworkyn==1?"checked":""}} value="{{ $processDetail[0]->sc_reworkyn }}" onclick = "return false">
                          <label class="custom-control-label font-weight-bold" for="retry">재작업</label>
                        </div>
                    </div>
                    <hr>
                    <div class="row w-100 mx-auto">
                        <div class="col-md-auto text-center align-self-center font-weight-bold">프로그램 명</div>
                        <input id="programName" type="text" class="col-md-2 form-control form-control-sm align-self-center" value="{{$processDetail[0]->p_name}}" readonly>
                        <div class="col-md-auto text-center align-self-center font-weight-bold">설명</div>
                        <input id = "programExplain" type="text" class="col-md-5 form-control form-control-sm" value="{{$processDetail[0]->p_sulmyung}}" readonly>
                        <div class="col-md-auto text-center align-self-center font-weight-bold">프로그램 상태</div>
                        <input id= "programStatus" type="text" class="col-md-1 form-control form-control-sm align-self-center text-center" value="{{$processDetail[0]->jobsm_p_status}}" readonly>
                    </div>
                    <hr>
                    <div class="row w-100 mx-auto">
                      <div class="col-md-6 text-center">
                        <div class="col-md-12 text-center align-self-center font-weight-bold">예상시간</div>
                        <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold">일</div>
                        <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime1" value="{{intval($processDetail[0]->p_yesangtime/1440)}}" readonly numberOnly>
                        <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold">시</div>
                        <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime2" value="{{intval($processDetail[0]->p_yesangtime%1440/60)}}" readonly numberOnly>
                        <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold">분</div>
                        <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime3" value="{{intval($processDetail[0]->p_yesangtime%60)}}" readonly >
                      </div>
                      <div class="col-md-6 text-center">
                        <div class="col-md-12 text-center align-self-center font-weight-bold">최대 예상시간</div>
                        <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold">일</div>
                        <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime1" value="{{intval($processDetail[0]->p_yesangmaxtime/1440)}}" readonly numberOnly>
                        <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold">시</div>
                        <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime2" value="{{intval($processDetail[0]->p_yesangmaxtime%1440/60)}}" readonly numberOnly>
                        <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold">분</div>
                        <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime3" value="{{intval($processDetail[0]->p_yesangmaxtime%60)}}" readonly numberOnly>
                      </div>
                    </div>
                    <hr>
                    <div class="row justify-content-center w-100 mx-auto">
                      <div class="limit-time-text col-md-auto">등록자</div>
                      <input id="P_RegId" type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto" value="{{$processDetail[0]->p_regid}}" readonly>
                      <div class="limit-time-text col-md-auto">등록자IP</div>
                      <input id="P_RegIp" type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto" value="{{$processDetail[0]->p_regip}}" readonly>
                      <div class="limit-time-text col-md-auto">등록일</div>
                      <input id="P_RegDate" type="text" class="form-control form-control-sm limit-time-input col-md-auto w-auto" value="{{$processDetail[0]->p_regdate}}" readonly>    
                      <div class="limit-time-text col-md-auto">수정자</div>
                      <input type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto" value="{{empty($processDetail[0]->p_updid) ? $processDetail[0]->p_regid:$processDetail[0]->p_updid}}" readonly>   
                      <div class="limit-time-text col-md-auto">수정자IP</div>
                      <input type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto"  value="{{empty($processDetail[0]->p_updip) ? $processDetail[0]->p_regip:$processDetail[0]->p_updip}}" readonly>       
                      <div class="limit-time-text col-md-auto">수정일</div>
                      <input type="text" class="form-control form-control-sm limit-time-input col-md-auto w-auto" value="{{empty($processDetail[0]->p_upddate) ? $processDetail[0]->p_regdate:$processDetail[0]->p_upddate}}" readonly> 
                    </div>
                    <hr>
                    <div class="row w-100 mx-auto">
                      <div class="col-md-2 text-center align-self-center font-weight-bold">로그 경로</div>
                    <input type="text" class="d-inline-block col-md-10 form-control form-control-sm align-self-center" value="{{'/home/script/log'.$processDetail[0]->sc_logfile}}" readonly>
                    </div>
                    <hr>
                    <div class="row w-100 mx-auto">
                      {{-- 업무 구분 대분류 중분류 선택 --}}
                      <div class="col-md-2 text-center align-self-center font-weight-bold">텍스트 파일</div>
                      <input type="text" class="d-inline-block col-md-10 form-control form-control-sm align-self-center"  value="{{'/home/incar/work'.$processDetail[0]->filepath.'/'.$processDetail[0]->p_textinput}}" readonly>
                    </div>
                    <hr>
                    {{-- 프로그램변수가 추가되는 부분 --}}
                    <div class="row w-100 mx-auto">
                      <h6 class="col-md-12 font-weight-bold">프로그램 파라미터 타입</h6>
                      @if(isset($processDetail[0]->p_params))
                        @php
                          $proParamArr=explode("||",$processDetail[0]->p_params);
                          $proParamSulArr=explode("||",$processDetail[0]->p_paramsulmyungs);
                          for ($i = 0; $i < count($proParamArr); $i++) {
                            echo '<div class="d-inline-flex w-50 delYN mb-2">';
                            echo '<div class="col-md-auto small align-self-center text-center">'.intVal($i+1).') 파라미터</div>';
                          if($proParamArr[$i]=="paramNum"){
                            echo '<input type="text" name="Job_Params" class="col-md-2 form-control form-control-sm" placeholder="숫자" readonly/>';
                          }else if($proParamArr[$i]=="paramStr"){
                            echo '<input type="text" name="Job_Params" class="col-md-2 form-control form-control-sm" placeholder="문자" readonly/>';
                          }
                          echo '<input type="text" name="pro_paramSulmyungs" class="form-control form-control-sm" value="'.$proParamSulArr[$i].'" readonly></div>';
                          }
                        @endphp
                      @endif
                    </div>
                    <hr>
                    <div class="row justify-content-end">
                        @if($processDetail[0]->sc_reworkyn==0)
                          <button type="button" class="mt-3 mr-2 btn btn-info" onclick="popup.reWorkModifi({{$processDetail[0]->sc_p_seq}})">재작업</button>
                        @endif
                      <button type="button" class="mt-3 mr-2 btn btn-danger" onclick="window.close();">닫기</button>
                    </div>
                </div>
            </div>
          </div>
  </body>
  </html>