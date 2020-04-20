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
                        <h5 class="m-0 font-weight-bold text-primary">프로그램 정보 등록</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">프로그램 ID</div>
                            <input id ="id1" type="text" class="col-md-2 form-control form-control-sm align-self-center" value="/home/incar/incarproject" readonly>
                            <input id ="id2" type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="경로">
                            <input id ="id3" type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="파일명">
                            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">프로그램 명</div>
                            <input id="programName" type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="프로그램 명">
                            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary mt-2">설명</div>
                            <input id = "programExplain" type="text" class="col-md-6 form-control form-control-sm mt-2" placeholder="설명">
                            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary mt-2">프로그램 상태</div>
                            <input type="text" class="col-md-2 form-control form-control-sm align-self-center mt-2" placeholder="" readonly>
                        </div>
                        <hr>
                        <div class="row align-items-center">
                             {{-- 업무 구분 대분류 중분류 선택 --}}
                            <div id="codeLargeView" class="outher-code"></div>
                            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">사용 DB</div>
                            <input id="UseDb" type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="사용 DB">           
                            <div class="col-md-1 mx-2 custom-control custom-checkbox small">
                                <input id="retry" type="checkbox" class="custom-control-input" value="0">
                                <label class="custom-control-label font-weight-bold text-primary" for="retry">재작업</label>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <div class="col-md-12 text-center align-self-center font-weight-bold text-primary">예상시간</div>
                                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">일</div>
                                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime1" value="0" numberOnly>
                                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">시</div>
                                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime2" value="0" numberOnly>
                                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">분</div>
                                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime3" value="0" numberOnly>
                            </div>
                            <div class="col-md-6 text-center">
                                <div class="col-md-12 text-center align-self-center font-weight-bold text-primary">최대 예상시간</div>
                                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">일</div>
                                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime1" value="0" numberOnly>
                                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">시</div>
                                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime2" value="0" numberOnly>
                                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">분</div>
                                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime3" value="0" numberOnly>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="limit-time-text">등록자</div>
                                <input id="P_RegId" type="text" class="form-control form-control-sm limit-time-input" placeholder="이수연" value="이수연" readonly>
                                <div class="limit-time-text">등록자IP</div>
                                <input id="P_RegIp" type="text" class="form-control form-control-sm limit-time-input" placeholder="" readonly>
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
                        <h6 class="col-md-12 font-weight-bold text-primary">
                            프로그램 파라미터 타입
                        </h6>
                        <hr>
                        {{-- program 변수가 추가되는 부분 --}}
                        <div class="row">
                            <div class="col-md-12" id="proParams"></div>
                            {{-- 프로그램변수가 추가되는 함수  process.addDivParam()   삭제되는 함수는 process.delDivParam() //jobF unc.js 에 있음 --}}
                            <div class="col-md-12 text-center">
                                <input type="button" class="mt-3 btn btn-info" value="프로그램 변수 추가 +"  onclick="process.addDivParam()"/>
                            </div>
                        </div>
                        <hr>
                        <div class="row justify-content-end">
                            <input type="button" class="mt-3 mr-2 btn btn-primary" value="등록" onclick="process.register()" />
                            <input type="button" class="mt-3 mr-2 btn btn-info" value="수정"/>
                            <input type="button" class="mt-3 mr-2 btn btn-danger" value="취소"/>
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
<script>
   // jobJS/codeFunc 대분류 조회
    code.workLargeCtg();
</script>