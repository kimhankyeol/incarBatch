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
<html lang="en" class="bg-light">
@include('popup.popupCommon.head')
@include('popup.popupCommon.popupJs')
<body id="page-top">
  <div id="wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <div class="container-fluid">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">스케줄 프로그램 상세 정보</h5>
                    </div>
                    <div class="card-body">
                      <div class="custom-row">
                          <input id="P_Seq" type="hidden" value="{{$processDetail[0]->P_Seq}}"/>
                          <div class="text-center align-self-center font-weight-bold text-primary mx-2">대분류</div>
                          <input id="workLargeVal" type="text" class="form-control form-control-sm mx-2" value="{{$processDetail[0]->P_WorkLargeName}}" style="cursor:not-allowed" readonly>
                          <div class="text-center align-self-center font-weight-bold text-primary mx-2">중분류</div>
                          <input id="workMediumVal" type="text" class="form-control form-control-sm mx-2" value="{{$processDetail[0]->P_WorkMediumName}}" readonly>
                          <div class="text-center align-self-center font-weight-bold text-primary">프로그램 ID</div>
                          <input id ="processPath" type="text" class="form-control form-control-sm align-self-center"  value="{{$processDetail[0]->FilePath}}" readonly>
                          <input id ="processFile" type="text" class="form-control form-control-sm align-self-center" value="{{$processDetail[0]->P_File}}" readonly>
                          <div class="mx-2 custom-control custom-checkbox small align-middle">
                            <input id="retry" type="checkbox" class="custom-control-input" {{$processDetail[0]->Sc_ReworkYN==1?"checked":""}} value="{{ $processDetail[0]->Sc_ReworkYN }}" onclick = "return false">
                            <label class="custom-control-label font-weight-bold text-primary" for="retry">재작업</label>
                          </div>
                      </div>
                      <hr>
                      <div class="row w-100 mx-auto">
                          <div class="col-md-auto text-center align-self-center font-weight-bold text-primary">프로그램 명</div>
                          <input id="programName" type="text" class="col-md-2 form-control form-control-sm align-self-center" value="{{$processDetail[0]->P_Name}}" readonly>
                          <div class="col-md-auto text-center align-self-center font-weight-bold text-primary">설명</div>
                          <input id = "programExplain" type="text" class="col-md-5 form-control form-control-sm" value="{{$processDetail[0]->P_Sulmyung}}" readonly>
                          <div class="col-md-auto text-center align-self-center font-weight-bold text-primary">프로그램 상태</div>
                          <input id= "programStatus" type="text" class="col-md-1 form-control form-control-sm align-self-center text-center" value="{{$processDetail[0]->JobSM_P_Status}}" readonly>
                      </div>
                      <hr>
                      <div class="row w-100 mx-auto">
                        <div class="col-md-6 text-center">
                          <div class="col-md-12 text-center align-self-center font-weight-bold text-primary">예상시간</div>
                          <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">일</div>
                          <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime1" value="{{intval($processDetail[0]->P_YesangTime/1440)}}" readonly numberOnly>
                          <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">시</div>
                          <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime2" value="{{intval($processDetail[0]->P_YesangTime%1440/60)}}" readonly numberOnly>
                          <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">분</div>
                          <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime3" value="{{intval($processDetail[0]->P_YesangTime%60)}}" readonly >
                        </div>
                        <div class="col-md-6 text-center">
                          <div class="col-md-12 text-center align-self-center font-weight-bold text-primary">최대 예상시간</div>
                          <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">일</div>
                          <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime1" value="{{intval($processDetail[0]->P_YesangMaxTime/1440)}}" readonly numberOnly>
                          <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">시</div>
                          <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime2" value="{{intval($processDetail[0]->P_YesangMaxTime%1440/60)}}" readonly numberOnly>
                          <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">분</div>
                          <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime3" value="{{intval($processDetail[0]->P_YesangMaxTime%60)}}" readonly numberOnly>
                        </div>
                      </div>
                      <hr>
                      <div class="row justify-content-center w-100 mx-auto">
                        <div class="limit-time-text col-md-auto">등록자</div>
                        <input id="P_RegId" type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto" value="{{$processDetail[0]->P_RegId}}" readonly>
                        <div class="limit-time-text col-md-auto">등록자IP</div>
                        <input id="P_RegIp" type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto" value="{{long2ip($processDetail[0]->P_RegIP)}}" readonly>
                        <div class="limit-time-text col-md-auto">등록일</div>
                        <input id="P_RegDate" type="text" class="form-control form-control-sm limit-time-input col-md-auto w-auto" value="{{$processDetail[0]->P_RegDate}}" readonly>    
                        <div class="limit-time-text col-md-auto">수정자</div>
                        <input type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto" value="{{empty($processDetail[0]->P_UpdId) ? $processDetail[0]->P_RegId:$processDetail[0]->P_UpdId}}" readonly>   
                        <div class="limit-time-text col-md-auto">수정자IP</div>
                        <input type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto"  value="{{empty($processDetail[0]->P_UpdIP) ?long2ip( $processDetail[0]->P_RegIP):long2ip($processDetail[0]->P_UpdIP)}}" readonly>       
                        <div class="limit-time-text col-md-auto">수정일</div>
                        <input type="text" class="form-control form-control-sm limit-time-input col-md-auto w-auto" value="{{empty($processDetail[0]->P_UpdDate) ? $processDetail[0]->P_RegDate:$processDetail[0]->P_UpdDate}}" readonly> 
                      </div>
                      <hr>
                      <div class="row w-100 mx-auto">
                        {{-- 업무 구분 대분류 중분류 선택 --}}
                        <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">텍스트 입력</div>
                        @if(($processDetail[0]->P_TextInputCheck)==1)
                          <div class="col-md-3 mx-2 custom-control custom-checkbox small">
                              <input id="P_TextInputCheck" type="checkbox" class="custom-control-input" checked="checked" value="{{ $processDetail[0]->P_TextInputCheck }}" onclick = "return false">
                              <label class="custom-control-label font-weight-bold text-primary" for="P_TextInputCheck">텍스트 입력여부</label>
                          </div>
                          @else
                          <div class="col-md-3 mx-2 custom-control custom-checkbox small">
                            <input id="P_TextInputCheck" type="checkbox" class="custom-control-input" value="{{ $processDetail[0]->P_TextInputCheck }}" onclick = "return false">
                            <label class="custom-control-label font-weight-bold text-primary" for="P_TextInputCheck">텍스트 입력여부</label>
                          </div>
                        @endif
                        @if(($processDetail[0]->P_TextInputCheck)==1)
                          <textarea id="P_TextInput" type="text" class="col-md-12 form-control form-control-sm align-self-center mt-2" style="height: 300px" readonly>{{$processDetail[0]->P_TextInput}}</textarea>
                        @else
                        @endif
                      </div>
                      <hr>
                      {{-- 프로그램변수가 추가되는 부분 --}}
                      <div class="row w-100 mx-auto">
                        <h6 class="col-md-12 font-weight-bold text-primary">프로그램 파라미터 타입</h6>
                        @if(isset($processDetail[0]->P_Params))
                          @php
                            $proParamArr=explode("||",$processDetail[0]->P_Params);
                            $proParamSulArr=explode("||",$processDetail[0]->P_ParamSulmyungs);
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
                          @if($processDetail[0]->Sc_ReworkYN==0)
                            <button type="button" class="mt-3 mr-2 btn btn-info" onclick="popup.reWorkModifi({{$processDetail[0]->Sc_P_Seq}})">재작업</button>
                          @endif
                        <button type="button" class="mt-3 mr-2 btn btn-danger" onclick="window.close();">닫기</button>
                      </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </body>
  </html>