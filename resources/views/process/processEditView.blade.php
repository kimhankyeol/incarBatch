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
            <h4 class="h3 my-4 font-weight-bold" style="color:white">프로그램 정보 수정</h4>
                <div class="card shadow">
                    <div class="card-body">
                      <div class="custom-row">
                        <input id="P_Seq" type="hidden" value="{{$processDetail[0]->p_seq}}"/>
                        <div class="text-center align-self-center font-weight-bold text-primary mx-2">대분류</div>
                        <input id="workLargeVal" type="text" class="form-control form-control-sm mx-2" value="{{$processDetail[0]->p_worklargename}}" style="cursor:not-allowed" readonly>
                        <div class="text-center align-self-center font-weight-bold text-primary mx-2">중분류</div>
                        <input id="workMediumVal" type="text" class="form-control form-control-sm mx-2" value="{{$processDetail[0]->p_workmediumname}}" readonly>
                        <div class="text-center align-self-center font-weight-bold text-primary">프로그램 경로</div>
                        <input id ="processPath" type="text" class="form-control form-control-sm align-self-center"  value="{{$processDetail[0]->filepath}}" readonly>
                        <input id ="processFile" type="text" class="form-control form-control-sm align-self-center" value="{{$processDetail[0]->p_file}}" readonly>
                          <div class="mx-2 custom-control custom-checkbox small align-middle">
                            <input id="retry" type="checkbox" class="custom-control-input" {{$processDetail[0]->p_reworkyn==1?"checked":""}} value="{{ $processDetail[0]->p_reworkyn }}" onclick = "return false">
                            <label class="custom-control-label font-weight-bold text-primary" for="retry">재작업</label>
                          </div>
                      </div>
                      <hr>
                      <div class="row w-100 mx-auto">
                          <div class="col-md-auto text-center align-self-center font-weight-bold text-primary">프로그램 명</div>
                          <input id="programName" type="text" class="col-md-2 form-control form-control-sm align-self-center" value="{{$processDetail[0]->p_name}}" readonly>
                          <div class="col-md-auto text-center align-self-center font-weight-bold text-primary">설명</div>
                          <textarea id = "programExplain" type="text" class="col-md-5 form-control form-control-sm">{{$processDetail[0]->p_sulmyung}}</textarea>
                          <div class="col-md-auto text-center align-self-center font-weight-bold text-primary">프로그램 상태</div>
                          <input type="text" class="col-md-1 form-control form-control-sm align-self-center text-center font-weight-bold" value="{{$proUsed}}" readonly>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-md-6 text-center">
                          <div class="col-md-12 text-center align-self-center font-weight-bold text-primary">배치 작업 평균 소요시간</div>
                          <div class="d-inline-block col-md-3 text-center align-self-center font-weight-bold text-primary">일 / 시 / 분</div>
                          <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime1" value="{{intval($processDetail[0]->p_yesangtime/1440)}}" numberOnly>
                          <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime2" value="{{intval($processDetail[0]->p_yesangtime%1440/60)}}" numberOnly>
                          <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime3" value="{{intval($processDetail[0]->p_yesangtime%60)}}">
                        </div>
                        <div class="col-md-6 text-center">
                          <div class="col-md-12 text-center align-self-center font-weight-bold text-primary">배치 작업 최대 소요시간</div>
                          <div class="d-inline-block col-md-3 text-center align-self-center font-weight-bold text-primary">일 / 시 / 분</div>
                            <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime1" value="{{intval($processDetail[0]->p_yesangmaxtime/1440)}}"numberOnly>
                            <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime2" value="{{intval($processDetail[0]->p_yesangmaxtime%1440/60)}}" numberOnly>
                            <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime3" value="{{intval($processDetail[0]->p_yesangmaxtime%60)}}" numberOnly>
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
                      <div class="row">
                        <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">텍스트 입력</div>
                        @if(($processDetail[0]->p_textinputcheck)==1)
                          <div class="col-md-3 mx-2 custom-control custom-checkbox small">
                              <input id="P_TextInputCheck" type="checkbox" class="custom-control-input" checked="checked" value="{{ $processDetail[0]->p_textinputcheck }}">
                              <label class="custom-control-label font-weight-bold text-primary" for="P_TextInputCheck">텍스트 입력여부</label>
                          </div>
                        @else
                          <div class="col-md-3 mx-2 custom-control custom-checkbox small">
                            <input id="P_TextInputCheck" type="checkbox" class="custom-control-input" value="{{ $processDetail[0]->p_textinputcheck }}" readonly>
                            <label class="custom-control-label font-weight-bold text-primary" for="P_TextInputCheck">텍스트 입력여부</label>
                          </div>
                        @endif
                        @if(($processDetail[0]->p_textinputcheck)==1)
                          <textarea id="P_TextInput" type="text" class="col-md-12 form-control form-control-sm align-self-center mt-2" style="height: 300px" >{{$processDetail[0]->p_textinput}}</textarea>
                        @else
                          <textarea id="P_TextInput" type="text" class="col-md-12 form-control form-control-sm align-self-center mt-2" style="height: 300px"  readonly>{{isset($processDetail[0]->p_textinput)? '':$processDetail[0]->p_textinput}}</textarea>
                        @endif
                      </div>
                      <hr>
                      {{-- 프로그램변수가 추가되는 부분 --}}
                      <div class="row w-100 mx-auto">
                        <h6 class="col-md-12 font-weight-bold text-primary">프로그램 파라미터 타입</h6>
                        @if(isset($processDetail[0]->p_params))
                          @php
                            $proParamArr=explode("||",$processDetail[0]->p_params);
                            $proParamSulArr=explode("||",$processDetail[0]->p_paramsulmyungs);
                            echo '<div class="col-md-12" id="proParams">';
                            for ($i = 0; $i < count($proParamArr); $i++) {
                              echo '<div class="d-inline-flex w-50 delYN mb-2">';
                              echo '<div class="col-md-3 small align-self-center text-center">파라미터</div>';
                              echo '<select name="proParamType" class="col-md-2 form-control form-control-sm">';
                              if($proParamArr[$i]=="paramNum"){
                                echo '<option value="paramStr">문자</option> <option value="'.$proParamArr[$i].'" selected>숫자</option> </select>';
                              }else if($proParamArr[$i]=="paramStr"){
                                echo '<option value="'.$proParamArr[$i].'" selected>문자</option> <option value="paramNum">숫자</option> </select>';
                              }
                              echo '<input type="text" name="proParamSulmyungInput" class="col-md-6 form-control form-control-sm" value="'.$proParamSulArr[$i].'">';
                              echo '<button type="button" class="btn btn-sm col-md-auto delParam btn-danger form-control-sm text-center" onclick="process.deleteDivParam()">삭제</button>';
                              echo '</div>';
                            }
                            echo '</div>';
                          @endphp
                        @endif  
                        {{-- 프로그램변수가 추가되는 함수  process.addDivParam()   삭제되는 함수는 process.delDivParam() //jobF unc.js 에 있음 --}}
                        <div class="col-md-12 text-center">
                            <input type="button" class="mt-3 btn btn-info" value="프로그램 변수 추가 +"  onclick="process.addDivParam()"/>
                        </div>
                      </div>
                      <hr>
                    
                      <div class="row justify-content-end">
                          <input type="button" class="mt-3 mr-2 btn btn-primary" value="저장" onclick="process.update('upd')" />
                          {{--  <input type="button" class="mt-3 mr-2 btn btn-danger" value="삭제" onclick="process.update('del')" />  --}}
                          <input type="button" class="mt-3 mr-2 btn btn-info" value="취소" onclick="location.href = '/process/processListView'"/>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <input id="P_UpdIP" type="hidden" value="{{$_SERVER["REMOTE_ADDR"]}}"/>
        <input id="P_UpDate" type="hidden" value="{{date("Y-m-d H:i:s")}}"/>
        <input id="P_Seq" type="hidden" value="{{$processDetail[0]->p_seq}}"/>
      </div>
    </div>
  </body>
  </html>

  <script>
      $('#P_TextInputCheck').click(function(){
         var chk = $(this).is(":checked");
         if(chk){
          $('#P_TextInput').removeAttr("readonly", "");
          $('#P_TextInput').removeAttr("readonly", "");
         }else{
          $('#P_TextInput').attr("readonly","readonly");
          $('#P_TextInput').attr("readonly","readonly");
             
         }
      });
   </script>