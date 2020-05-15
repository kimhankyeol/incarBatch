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
              <h5 class="m-0 font-weight-bold text-primary">잡 정보 등록</h5>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">잡 명(쉘 명) </div>
                  <input type="text" id="Job_UniqueName"  class="col-md-2 form-control form-control-sm align-self-center" placeholder="" readonly>
                  <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">잡 명</div>
                  <input type="text" id="Job_Name"  class="col-md-2 form-control form-control-sm align-self-center" placeholder="예)손해보험 수수료">
                  <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">설명</div>
                  <textarea type="text" id="Job_Sulmyung" class="col-md-4 form-control form-control-sm" placeholder="설명" style="resize: none;"></textarea>
                </div>
                <hr>
                <div class="row">
                  <div class="outher-code">
                    {{-- 업무 구분 대분류 중분류 선택 --}}
                    <div class="text-center align-self-center font-weight-bold text-primary mx-2">업무 구분</div>
                    @include("code.codeSelect")
                  </div>
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">잡 등록자</div>
                  <input type="text" id="Job_RegID" class="col-md-2 form-control form-control-sm align-self-center" placeholder="김한결" value="김한결" readonly>
                  {{-- <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">잡 상태</div>
                  <input type="text" class="col-md-1 form-control form-control-sm align-self-center" placeholder="-" readonly>
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">구성 프로세스 개수</div>
                  <input type="text" class="col-md-1 form-control form-control-sm align-self-center" placeholder="-" readonly>               --}}
                </div>
                <hr>
                <div class="col-md-12 font-weight-bold text-primary">
                  잡 파라미터 타입
                </div>
                <hr>
                <div class="row">
                  {{-- 잡변수가 추가되는 부분 --}}
                  <div class="col-md-12" id="jobParams"></div>
                  <div class="col-md-12 text-center">
                    <input type="button" class="mt-3 btn btn-info " value="잡 변수 추가 +"  onclick="job.addDivParam()"/>
                  </div>
                </div>
                <hr>
              <div class="row justify-content-end">
                <button type="button" class="mt-3 mr-2 btn btn-primary" onclick="job.register()">등록</button>
                <button type="button" class="mt-3 mr-2 btn btn-danger" onclick="history.back()">취소</b>
              </div>
            </div>
          </div>
        </div>
      </div>
    @include('common.footer')
    {{--content 끝--}}
<script>
  $("input:text[numberOnly]").on("keyup", function() {
    $(this).val($(this).val().replace(/[^0-9]/g,""));
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
    </div>
  </div>
</body>
</html>

