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
                <h6 class="m-0 font-weight-bold text-primary" style="text-align: center;">프로그램 정보 등록</h6>
                </div>
                <div class="card-body">
                <div class="row">
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">프로그램 ID</div>
                    <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="프로그램 ID" readonly>
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">프로그램 명</div>
                    <input id="programName" type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="프로그램 명">
                    <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">설명</div>
                    <textarea id = "programExplain" type="text" class="col-md-3 form-control form-control-sm" placeholder="설명" style="resize: none;"></textarea>
                </div>
                <hr>
                <div class="row">
                    <!-- <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">잡 등록자</div>
                    <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="김한결" readonly> -->
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">업무구분</div>
                    <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">대분류</div>
                    <select class="col-md-3 form-control form-control-sm">
                    <option>
                        인카금융서비스
                    </option>
                    </select>
                    <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">중분류</div>
                    <select class="col-md-3 form-control form-control-sm">
                    <option>
                        정보기술연구소
                    </option>
                    <option>
                        교육
                    </option>
                    <option>
                        제도관리
                    </option>
                    </select>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">프로그램 상태</div>
                    <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="-" readonly>
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary" checked>재작업</div>
                    <input id="retry" type="checkbox" class="col-md-1 form-control form-control-sm align-self-center">
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">사용 DB</div>
                    <input id="UseDb" type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="사용 DB">           
                </div>
                <hr>
                <!-- <div class="row">
                    <div class="col-md-12 text-center align-self-center font-weight-bold text-primary">프로그램 예상 시간</div>
                    <div class="col-md-1 font-weight-bold text-primary" style="text-align: right">일</div>
                    <input id="P_day" type="text" class="col-md-3 form-control form-control-sm align-self-center" id="Job_YesangTime1" placeholder="일 단위(숫자)로 입력해주세요" numberOnly>
                    <div class="col-md-1 font-weight-bold text-primary" style="text-align: right">시간</div>
                    <input id="P_hour" type="text" class="col-md-3 form-control form-control-sm align-self-center" id="Job_YesangTime2" placeholder="시 단위(숫자)로 입력해주세요" numberOnly>
                    <div class="col-md-1 font-weight-bold text-primary" style="text-align: right">분</div>
                    <input id="P_min" type="text" class="col-md-3 form-control form-control-sm align-self-center" id="Job_YesangTime3" placeholder="분 단위(숫자)로 입력해주세요" numberOnly>
                </div> -->
                <div class="row">
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">프로그램 예상 시간</div>
                    <input id="yaeTime" type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="분단위로 입력해주세요">
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">프로그램 최대 예상 시간</div>
                    <input id="yaeMaxTime" type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="분단위로 입력해주세요">
                    <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">경로</div>
                    <input id="path" type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="경로를 지정해주세요">              
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">등록자</div>
                    <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="" readonly>
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">등록자IP</div>
                    <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="" readonly>
                    <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">등록일</div>
                    <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="" readonly>              
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">수정자</div>
                    <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="" readonly>
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">수정자IP</div>
                    <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="" readonly>
                    <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">수정일</div>
                    <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="" readonly>              
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 font-weight-bold text-primary">
                    프로그램 파라미터 타입
                    </div>
                    <hr>
                    {{-- program 변수가 추가되는 부분 --}}
                    <div class="col-md-12" id="proParams">
                    </div>
                    <div style="width:100%; text-align: center">
                    {{-- 프로그램변수가 추가되는 함수  process.addDivParam()   삭제되는 함수는 process.delDivParam() //jobF unc.js 에 있음 --}}
                    <input type="button" class="mt-3 btn btn-info " value="프로그램 변수 추가 +" style="margin: 0px 5px;"  onclick="process.addDivParam()"/>
                    </div>
                </div>
                <hr>
                <input type="button" class="mt-3 btn btn-info float-right" value="수정" style="margin: 0px 5px;" />
                <input type="button" class="mt-3 btn btn-danger float-right" value="취소" style="margin: 0px 5px;" />
                <input type="button" class="mt-3 btn btn-primary float-right" value="등록" onclick="process.register()" />
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