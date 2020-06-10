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
<body id="page-top">
  <div id="wrapper">
    {{-- 블레이드 주석 쓰는 법--}}
    {{--사이드바 시작--}}
    @include('common.sidebar')
    {{--사이드바 끝--}}

    {{--content 시작--}}
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <div class="container-fluid">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">프로그램 상세 정보</h5>
                    </div>
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
                          <textarea id = "programExplain" type="text" class="col-md-5 form-control form-control-sm"  readonly>{{$processDetail[0]->p_sulmyung}}</textarea>
                          <div class="col-md-auto text-center align-self-center font-weight-bold text-primary">프로그램 상태</div>
                          <input id ="programStatus" type="text" class="col-md-1 form-control form-control-sm align-self-center text-center font-weight-bold" value="{{$proUsed}}" readonly>
                      </div>
                      <hr>
                      <div class="row w-100 mx-auto">
                        <div class="col-md-6 text-center">
                          <div class="col-md-12 text-center align-self-center font-weight-bold text-primary">배치 작업 평균 소요시간</div>
                          <div class="d-inline-block col-md-3 text-center align-self-center font-weight-bold text-primary">일 / 시 / 분</div>
                          <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime1" value="{{intval($processDetail[0]->p_yesangtime/1440)}}" readonly numberOnly>
                          <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime2" value="{{intval($processDetail[0]->p_yesangtime%1440/60)}}" readonly numberOnly>
                          <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime3" value="{{intval($processDetail[0]->p_yesangtime%60)}}" readonly >
                        </div>
                        <div class="col-md-6 text-center">
                          <div class="col-md-12 text-center align-self-center font-weight-bold text-primary">배치 작업 최대 소요시간</div>
                          <div class="d-inline-block col-md-3 text-center align-self-center font-weight-bold text-primary">일 / 시 / 분</div>
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
                        {{-- 업무 구분 대분류 중분류 선택 --}}
                        <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">텍스트 입력</div>
                        @if(($processDetail[0]->p_textinputcheck)==1)
                          <div class="col-md-3 mx-2 custom-control custom-checkbox small">
                              <input id="P_TextInputCheck" type="checkbox" class="custom-control-input" checked="checked" value="{{ $processDetail[0]->p_textinputcheck }}" onclick = "return false">
                              <label class="custom-control-label font-weight-bold text-primary" for="P_TextInputCheck">텍스트 입력여부</label>
                          </div>
                          @else
                          <div class="col-md-3 mx-2 custom-control custom-checkbox small">
                            <input id="P_TextInputCheck" type="checkbox" class="custom-control-input" value="{{ $processDetail[0]->p_textinputcheck }}" onclick = "return false">
                            <label class="custom-control-label font-weight-bold text-primary" for="P_TextInputCheck">텍스트 입력여부</label>
                          </div>
                        @endif
                        @if(($processDetail[0]->p_textinputcheck)==1)
                          <textarea id="P_TextInput" type="text" class="col-md-12 form-control form-control-sm align-self-center mt-2" style="height: 300px" readonly>{{$processDetail[0]->p_textinput}}</textarea>
                        @else
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
                        <input type="button" class="mt-3 mr-2 btn btn-info" value="수정" onclick="process.edit()"/>
                        <input type="button" class="mt-3 mr-2 btn btn-danger" value="취소" onclick="location.href = '/process/processListView'"/>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        @include('common.footer')
        {{--content 끝--}}
      </div>
    </div>
    <input id="WorkLarge" hidden  value="{{$processDetail[0]->p_worklargectg}}" readonly>
    <input id="WorkMedium" hidden  value="{{$processDetail[0]->p_workmediumctg}}" readonly>
  </body>
  </html>
  @php
    $tabDelimitedLines = explode("\n", $processDetail[0]->p_textinput);
    $myArray = Array();

    foreach ($tabDelimitedLines as $lineIndex => $line) {
        $fields = explode("\t", $line);
        foreach ($fields as $fieldIndex => $field) {
            if ($lineIndex == 0) {
                // assuming first line is header info
                $headers[] = $field;
            } else {
                // put the other lines into an array
                // in whatever format you want
                $myArray[$lineIndex - 1][$headers[$fieldIndex]] = $field;
            }
        }
    }
    $json = json_encode($myArray);
    echo var_dump($tabDelimitedLines);
    echo var_dump($myArray);
  @endphp