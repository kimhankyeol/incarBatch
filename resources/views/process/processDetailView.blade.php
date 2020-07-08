<!DOCTYPE html>
<html lang="en">
@include('common.head')
<script>document.title="프로그램 상세 정보"</script>
<body id="page-top" class="bodyBgImg">
  <div id="wrapper">
    {{-- 블레이드 주석 쓰는 법--}}
    {{--사이드바 시작--}}
    @include('common.sidebar')
    {{--사이드바 끝--}}

    {{--content 시작--}}
    <div class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <div class="container-fluid">
            <h4 class="h3 my-4 font-weight-bold" style="color:white">프로그램 상세 정보</h4>
                <div class="card shadow">
                    <div class="card-body">
                      <div class="row w-100 mx-auto">
                          <div class="text-center align-self-center font-weight-bold  col-md-2">대분류</div>
                          <input id="workLargeVal" type="text" class="form-control form-control-sm  col-md-4" value="{{$processDetail[0]->p_worklargename}}" style="cursor:not-allowed" readonly>
                          <div class="text-center align-self-center font-weight-bold   col-md-2">중분류</div>
                          <input id="workMediumVal" type="text" class="form-control form-control-sm  col-md-4" value="{{$processDetail[0]->p_workmediumname}}" readonly>
                      </div>
                      <hr>
                      <div class="row w-100 mx-auto">
                          <div class="text-center align-self-center font-weight-bold col-md-2">프로그램 경로</div>
                          <input id ="processPath" type="text" class="form-control form-control-sm align-self-center col-md-4"  value="{{"/home/batch".$processDetail[0]->filepath."/program"}}" readonly>
                          <input id ="processFile" type="text" class="form-control form-control-sm align-self-center col-md-3" value="{{$processDetail[0]->p_file}}" readonly>
                          <div class="mx-2 custom-control custom-checkbox small align-middle">
                            <input id="retry" type="checkbox" class="custom-control-input" {{$processDetail[0]->p_reworkyn==1?"checked":""}} value="{{ $processDetail[0]->p_reworkyn }}" onclick = "return false">
                            <label class="custom-control-label font-weight-bold" for="retry">재작업</label>
                          </div>
                      </div>
                      <hr>
                      <div class="row w-100 mx-auto">
                        <div class="col-md-2 text-center align-self-center font-weight-bold">프로그램 명</div>
                        <input id="programName" type="text" class="col-md-4 form-control form-control-sm align-self-center" value="{{$processDetail[0]->p_name}}" readonly>
                        <div class="col-md-2 text-center align-self-center font-weight-bold">프로그램 상태</div>
                        <input id ="programStatus" type="text" class="col-md-1 form-control form-control-sm align-self-center text-center font-weight-bold" value="{{$proUsed}}" readonly>
                      </div>
                      <hr>
                      <div class="row w-100 mx-auto">
                        <div class="col-md-2 text-center align-self-center font-weight-bold">설명</div>
                        <textarea id = "programExplain" type="text" class="col-md-10 form-control form-control-sm"  readonly>{{$processDetail[0]->p_sulmyung}}</textarea>
                      </div>
                      <hr>
                      <div class="row w-100 mx-auto">
                        <div class="col-md-6 text-center">
                          <div class="col-md-12 text-center align-self-center font-weight-bold">배치 작업 평균 소요시간</div>
                          <div class="d-inline-block col-md-3 text-center align-self-center font-weight-bold">일 / 시 / 분</div>
                          <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime1" value="{{intval($processDetail[0]->p_yesangtime/1440)}}" readonly numberOnly>
                          <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime2" value="{{intval($processDetail[0]->p_yesangtime%1440/60)}}" readonly numberOnly>
                          <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime3" value="{{intval($processDetail[0]->p_yesangtime%60)}}" readonly >
                        </div>
                        <div class="col-md-6 text-center">
                          <div class="col-md-12 text-center align-self-center font-weight-bold">배치 작업 최대 소요시간</div>
                          <div class="d-inline-block col-md-3 text-center align-self-center font-weight-bold">일 / 시 / 분</div>
                          <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime1" value="{{intval($processDetail[0]->p_yesangmaxtime/1440)}}" readonly numberOnly>
                          <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime2" value="{{intval($processDetail[0]->p_yesangmaxtime%1440/60)}}" readonly numberOnly>
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
                        <div class="col-md-3 text-center align-self-center font-weight-bold">입력 파일</div>
                        @if(($processDetail[0]->p_textinputcheck)==1)
                          <div class="col-md-2 custom-control custom-checkbox small">
                              <input id="P_TextInputCheck" type="checkbox" class="custom-control-input" checked="checked" value="{{ $processDetail[0]->p_textinputcheck }}" onclick = "return false">
                              <label class="custom-control-label font-weight-bold" for="P_TextInputCheck">입력 파일여부</label>
                          </div>
                          @else
                          <div class="col-md-2 custom-control custom-checkbox small">
                            <input id="P_TextInputCheck" type="checkbox" class="custom-control-input" value="{{ $processDetail[0]->p_textinputcheck }}" onclick = "return false">
                            <label class="custom-control-label font-weight-bold" for="P_TextInputCheck">텍스트 입력여부</label>
                          </div>
                        @endif
                        <div class="col-md-2 text-center align-self-center font-weight-bold">출력 파일</div>
                        @if(($processDetail[0]->p_fileoutputcheck)==1)
                          <div class="col-md-3 custom-control custom-checkbox small">
                              <input id="P_FileOutputCheck" type="checkbox" class="custom-control-input" checked="checked" value="{{ $processDetail[0]->p_fileoutputcheck }}" onclick = "return false">
                              <label class="custom-control-label font-weight-bold" for="P_FileOutputCheck">출력 파일여부</label>
                          </div>
                          @else
                          <div class="col-md-2 custom-control custom-checkbox small">
                            <input id="P_FileOutputCheck" type="checkbox" class="custom-control-input" value="{{ $processDetail[0]->p_fileoutputcheck }}" onclick = "return false">
                            <label class="custom-control-label font-weight-bold" for="P_FileOutputCheck">출력 파일여부</label>
                          </div>
                        @endif
                        @if(($processDetail[0]->p_privatecheck)==1)
                          <div class="col-md-2 text-center align-self-center font-weight-bold private"> 개인정보</div>
                          <div class="col-md-2 custom-control custom-checkbox small private">
                              <input id="P_PrivateCheck" type="checkbox" checked="checked" value="{{ $processDetail[0]->p_privatecheck }}" readonly class="custom-control-input">
                              <label class="custom-control-label font-weight-bold " for="P_PrivateCheck">개인정보 체크</label>
                          </div>
                        @else
                          <div class="col-md-2 text-center align-self-center font-weight-bold private"> 개인정보</div>
                          <div class="col-md-2 custom-control custom-checkbox small private">
                              <input id="P_PrivateCheck" type="checkbox" value="{{ $processDetail[0]->p_privatecheck }}" readonly class="custom-control-input">
                              <label class="custom-control-label font-weight-bold " for="P_PrivateCheck">개인정보 체크</label>
                          </div>
                        @endif
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
                              echo '<div class="col-md-auto small align-self-center text-center">파라미터</div>';
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
                        <input type="button" class="mt-3 mr-2 btn btn-info" value="수정" onclick="process.edit('{{$processDetail[0]->p_seq}}')"/>
                        <input type="button" class="mt-3 mr-2 btn btn-danger" value="취소" onclick="location.href = '/process/processListView'"/>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        {{--content 끝--}}
      </div>
    </div>
    <input id="WorkLarge" hidden  value="{{$processDetail[0]->p_worklargectg}}" readonly>
    <input id="WorkMedium" hidden  value="{{$processDetail[0]->p_workmediumctg}}" readonly>
  </body>
  </html>