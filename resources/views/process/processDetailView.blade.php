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
      <!-- End of Topbar -->
      <!-- Begin Page Content -->
      <div class="container-fluid">
        <!-- Page Heading -->
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">프로그램 정보 상세</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <input type="hidden" id="p_seq" value="{{$processDetail[0]->P_Seq}}" />
              <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">프로그램 ID</div>
              <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="{{'pro'.$processDetail[0]->P_Seq.'_'.$processDetail[0]->P_WorkLargeCtg.'_'.$processDetail[0]->P_WorkMediumCtg.'_'.date("YmdHis",strtotime($processDetail[0]->P_RegDate))}}" readonly>
              <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">프로그램 명</div>
              <input id="programName" type="text" class="col-md-2 form-control form-control-sm align-self-center" value="{{$processDetail[0]->P_Name}}" readonly>
              <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">설명</div>
              <textarea id="programExplain" type="text" class="col-md-3 form-control form-control-sm" readonly>{{$processDetail[0]->P_Sulmyung}}</textarea>
            </div>
            <hr>
            <div class="row align-items-center">
              <span class="col-md-1 font-weight-bold text-primary">업무구분</span>
              <span class="col-md-1 text-center align-self-center font-weight-bold text-primary">대분류</span>
              <select id="workLargeVal" class="col-md-2 form-control form-control-sm" readonly>
                <option value="{{$processDetail[0]->P_WorkLargeCtg}}" selected>{{$processDetail[0]->P_WorkLargeName}}</option>
              </select>
              <span class="col-md-1 text-center align-self-center font-weight-bold text-primary">중분류</span>
              <select id="workMediumVal" class="col-md-2 form-control form-control-sm" readonly>
                <option value="{{$processDetail[0]->P_WorkMediumCtg}}" selected>{{$processDetail[0]->P_WorkMediumName}}</option>
              </select>
              @if(($processDetail[0]->P_ReworkYN)==1)
              <div class="col-md-1 mx-2 custom-control custom-checkbox small">
                  <input id="retry" type="checkbox" class="custom-control-input" checked="checked" value="{{ $processDetail[0]->P_ReworkYN }}" onclick="return false;">
                  <label class="custom-control-label font-weight-bold text-primary" for="retry">재작업</label>
              </div>
              @else
              <div class="col-md-1 mx-2 custom-control custom-checkbox small">
                <input id="retry" type="checkbox" class="custom-control-input" value="{{ $processDetail[0]->P_ReworkYN }}"  onclick="return false;">
                <label class="custom-control-label font-weight-bold text-primary" for="retry">재작업</label>
              </div>
              @endif
              <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">프로그램 상태</div>
              <input type="text" class="col-md-1 form-control form-control-sm align-self-center" placeholder="" readonly>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">사용 DB</div>
              <input id="UseDb" type="text" class="col-md-2 form-control form-control-sm align-self-center" value="{{ $processDetail[0]->P_UseDB }}" readonly>           
              <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">경로</div>
              <input id="path" type="text" class="col-md-6 form-control form-control-sm align-self-center" value="{{ $processDetail[0]->P_FilePath }}" readonly>           
            </div>
            <hr>
            <div class="row">
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
            <div class="row">
              <div class="col-md-6">
                  <div class="limit-time-text">등록자</div>
                  <input type="text" class="form-control form-control-sm limit-time-input" placeholder="11111111" readonly>
                  <div class="limit-time-text">등록자IP</div>
                  <input type="text" class="form-control form-control-sm limit-time-input" placeholder="192.168.168.168" readonly>
                  <div class="limit-time-text">등록일</div>
                  <input type="text" class="form-control form-control-sm limit-time-input" placeholder="2020-02-02" readonly>              
              </div>
              <div class="col-md-6">
                  <div class="limit-time-text">수정자</div>
                  <input type="text" class="form-control form-control-sm limit-time-input" placeholder="11111111" readonly>
                  <div class="limit-time-text">수정자IP</div>
                  <input type="text" class="form-control form-control-sm limit-time-input" placeholder="192.168.168.168" readonly>
                  <div class="limit-time-text">수정일</div>
                  <input type="text" class="form-control form-control-sm limit-time-input" placeholder="2020-02-02" readonly>              
              </div>
            </div>
            <hr>
            <div class="row">
              <h6 class="col-md-12 font-weight-bold text-primary">
                프로그램 파라미터 타입
              </div>
              <hr>
              {{-- 프로그램변수가 추가되는 부분 --}}
              <div class="w-75 m-auto">
                <div class="row">
                    @php
                      $proParamArr=explode("||",$processDetail[0]->P_Params);
                      $proParamSulArr=explode("||",$processDetail[0]->P_ParamSulmyungs);
                      for ($i = 0; $i < count($proParamArr); $i++) {
                       echo '<div class="col-md-3 small align-self-center text-center">프로그램 파라미터</div>';
                       echo '<select name="pro_Params" class="col-md-2 form-control form-control-sm" readonly>';
                       if($proParamArr[$i]=="paramDate"){
                        echo '<option value="'.$proParamArr[$i].'" selected>날짜</option></select>';
                       }else if($proParamArr[$i]=="paramNum"){
                        echo '<option value="'.$proParamArr[$i].'" selected>숫자</option></select>';
                       }else if($proParamArr[$i]=="paramStr"){
                        echo '<option value="'.$proParamArr[$i].'" selected>문자</option></select>';
                       }
                       echo '<input type="text" name="pro_paramSulmyungs" class="col-md-6 form-control form-control-sm" value="'.$proParamSulArr[$i].'" readonly>';
                      }
                    @endphp
                  </div>
              </div>
            <hr>
            <div class="row justify-content-end">
              <input type="button" class="mt-3 mr-2 btn btn-primary" value="등록" onclick="process.register()" />
              <input type="button" class="mt-3 mr-2 btn btn-info" value="수정" onclick="process.update()"/>
              <input type="button" class="mt-3 mr-2 btn btn-danger" value="취소" onclick="history.back()"/>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('common.footer')
{{--content 끝--}}
    </div>
  </div>
</body>
</html>