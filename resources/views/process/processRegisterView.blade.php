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
                        <input id="P_RegIp" type="hidden" value="{{$_SERVER["REMOTE_ADDR"]}}"/>
                        <input id="P_RegId" type="hidden" value="1611698"/>
                    </div>
                    <div class="card-body">
                        <div class="custom-row">
                            {{-- 업무 구분 대분류 중분류 선택 --}}
                            <div class="text-center align-self-center font-weight-bold text-primary mx-2">업무 구분</div>
                            @include("code.codeSelect")
                            {{-- <div class="text-center align-self-center font-weight-bold text-primary mx-2">프로그램 ID</div> --}}
                            <div class="text-center align-self-center font-weight-bold text-primary">프로그램 경로</div>
                            <input id ="processPath" type="text" class="form-control form-control-sm align-self-center"readonly>
                            <input id ="processFile" type="text" class="form-control form-control-sm align-self-center" placeholder="파일명">
                            <div class="mx-1 custom-control custom-checkbox small align-middle">
                                <input id="retry" type="checkbox" class="custom-control-input" value="0" checked>
                                <label class="custom-control-label font-weight-bold text-primary" for="retry">재작업</label>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">프로그램 명</div>
                            <input id="programName" type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="프로그램 명">
                            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary mt-2">프로그램 설명</div>
                            <input id = "programExplain" type="text" class="col-md-6 form-control form-control-sm mt-2" placeholder="설명">
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <div class="col-md-12 text-center align-self-center font-weight-bold text-primary">배치 작업 평균 소요시간</div>
                                <div class="d-inline-block col-md-3 text-center align-self-center font-weight-bold text-primary">일 / 시 / 분</div>
                                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime1" value="0" numberOnly>
                                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime2" value="0" numberOnly>
                                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime3" value="0" numberOnly>
                            </div>
                            <div class="col-md-6 text-center">
                                <div class="col-md-12 text-center align-self-center font-weight-bold text-primary">배치 작업 최대 소요시간</div>
                                <div class="d-inline-block col-md-3 text-center align-self-center font-weight-bold text-primary">일 / 시 / 분</div>
                                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime1" value="0" numberOnly>
                                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime2" value="0" numberOnly>
                                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime3" value="0" numberOnly>
                            </div>
                        </div>
                        <hr>
                        <div class="row align-items-center">
                             {{-- 업무 구분 대분류 중분류 선택 --}}
                            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">텍스트 입력</div>
                            <div class="col-md-2 mx-2 custom-control custom-checkbox small">
                                <input id="P_TextInputCheck" type="checkbox" class="custom-control-input">
                                <label class="custom-control-label font-weight-bold text-primary" for="P_TextInputCheck">텍스트 입력 여부</label>
                            </div>
                        </div>
                        <div class="row">
                            <textarea id="P_TextInput" type="text" class="col-md-12 form-control form-control-sm align-self-center mt-2"  style="height: 300px" disabled ></textarea>
                        </div>
                        <hr>
                        <h6 class="col-md-12 font-weight-bold text-primary ">
                            프로그램 파라미터 타입
                        </h6>
                        <hr>
                        <div class="row">
                        {{-- program 변수가 추가되는 부분 --}}
                            <div class="col-md-12" id="proParams"></div>
                            <div class="col-md-12 text-center">
                                <input type="button" class="mt-3 btn btn-info" value="프로그램 변수 추가 +"  onclick="process.addDivParam()"/>
                            </div>
                        </div>
                        <hr>
                        <div class="row justify-content-end">
                            <input type="button" class="mt-3 mr-2 btn btn-primary" value="등록" onclick="process.register()" />
                            {{-- <input type="button" class="mt-3 mr-2 btn btn-info" value="수정"/> --}}
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
   $('#P_TextInputCheck').click(function(){
        var chk = $(this).is(":checked");
        if(chk){
            $('#P_TextInput').removeAttr("disabled", "");
            $('#P_TextInput').removeAttr("disabled", "");
            $('#P_TextInput').val("#주석입니다. 변수1(열) 변수2(열) 변수3(열)");
        }else{
         
            $('#P_TextInput').attr("disabled","disabled");
            $('#P_TextInput').attr("disabled","disabled");
            $('#P_TextInput').val("");
        }
   });
  </script>
<script>
    function workLargeChgSel(){
     var WorkLarge =  $('#workLargeVal').val();
          $.ajax({
            url:"/code/workMediumCtg2",
            method:"get",
            data:{
              "WorkLarge":$('#workLargeVal').val()
            },
            success:function(resp){
              $("#workMediumVal").html(resp.returnHTML);
            },
            error:function(error){
  
            }
          })
    }
    </script>
