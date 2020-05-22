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
<script>
  function workLargeChgSel(){
    var WorkLarge =  $('#workLargeVal').val();
    $.ajax({
      url:"/code/workMediumCtg",
      method:"get",
      data:{
        "WorkLarge":WorkLarge
      },
      success:function(resp){
        $("#workMediumVal").html(resp.returnHTML);
      }
    })
  }
  $(document).ready( function() {
    var now = new Date();
    var month = (now.getMonth() + 1);               
    var day = now.getDate();
    if (month < 10) 
        month = "0" + month;
    if (day < 10) 
        day = "0" + day;
    var today = now.getFullYear() + '-' + month + '-' + day;
    $('#startDate').val(today);
    $('#endDate').val(today);
    var dbclick=false;
    // 모니터 리스트
    $(document).on('click','.OneDbClickCss',function(event){
      var OneDbClickCss = $('.OneDbClickCss').index(this);
      //tr 색 바꾸기  활성된거
      if($('.OneDbClickCss').not(OneDbClickCss).css({'background-color':'rgb(255, 255, 255)'})){
          $('.OneDbClickCss').eq(OneDbClickCss).css({'background-color':'rgb(218, 221, 235)'});
      }else {
          $('.OneDbClickCss').not(OneDbClickCss).css({'background-color':'rgb(255, 255, 255)'});
      }
    })
    // 페이징
    $(document).on('click', '.pagination .page-link', function (event) {
      event.preventDefault();
      var href = $(this).attr('href').split('?')[0];
      var href_param = $(this).attr('href').split('?')[1];

      if(href=="/monitoring/monitorJobSearchList") {
        var searchPage = href_param.split('page=')[1];
        var noneTable = document.getElementById("datatable2");
        var noneTable2 = document.getElementById("scheduleProcessList");
        noneTable.children[2].style.display ="none";
        if(noneTable.nextElementSibling != null || noneTable.nextElementSibling != undefined) {
          noneTable.nextElementSibling.style.display = "none";
        }
        noneTable2.style.display = "none";
        $.ajax({
          url: href,
          method: "get",
          data: {
            "page": searchPage
          },
          success: function (resp) {
            $('#monitorDatatable').html(resp.returnHTML)
          }
        })
      } else if(href=="/monitoring/monitorJobDetailList") {
        var Job_Seq = $('#monitorJob').attr("data-value");
        var page = href_param.split('page=')[1];
        var noneTable = document.getElementById("datatable3");
        noneTable.style.display ="none"
        monitor.detailList(Job_Seq, page);
      }
    });
  });
</script>
<body id="page-top">
  <div id="wrapper">
    @include('common.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <div class="container-fluid">
          <h3 class="my-4 font-weight-bold text-primary">모니터링</h3>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <div class="form-inline navbar-search justify-content-end">
                <div class="input-group align-items-center mb-2 w-100">
                  <div class="mx-1 custom-control custom-checkbox small">
                    <input id="status_start" type="checkbox" class="custom-control-input jobStatus" value="20" checked="true">
                    <label class="custom-control-label font-weight-bold text-primary" for="status_start">실행</label>
                  </div>
                  <div class="mx-1 custom-control custom-checkbox small">
                    <input id="status_reservation" type="checkbox" class="custom-control-input jobStatus" value="30" checked="true">
                    <label class="custom-control-label font-weight-bold text-primary" for="status_reservation">예약</label>
                  </div>
                  <div class="mx-1 custom-control custom-checkbox small">
                    <input id="status_end" type="checkbox" class="custom-control-input jobStatus" value="90" checked="true">
                    <label class="custom-control-label font-weight-bold text-primary" for="status_end">완료</label>
                  </div>
                  <div class="mx-1 custom-control custom-checkbox small">
                    <input id="status_error" type="checkbox" class="custom-control-input jobStatus" value="40" checked="true">
                    <label class="custom-control-label font-weight-bold text-primary" for="status_error">오류</label>
                  </div>
                </div>
                <div class="input-group align-items-center">
                   {{-- 업무 구분 대분류 중분류 선택 --}}
                  <div class="text-center align-self-center font-weight-bold text-primary mx-2">업무 구분</div>
                  @include("code.codeSelect")
                  <div class="input-group align-items-center">
                    <div class="text-center align-self-center font-weight-bold text-primary mx-2">등록일</div>
                     {{-- 검색 조건 --}}
                     <input type="date" class="form-control form-control-sm" id="startDate">
                     <span class="form-control-sm"> ~ </span>
                     <input type="date" class="form-control form-control-sm" id="endDate">
                  </div>
                   {{-- 검색 조건 --}}
                  <select class="form-control form-control-sm bg-light border-primary">
                    <option>
                      잡명
                    </option>
                  </select>
                  {{-- 검색 단어가 있을떄 없을때 구분  --}}
                  @if(!isset($searchWord))
                    <input id="searchWord" type="text" class="form-control form-control-sm bg-light border-primary" placeholder="조회" aria-label="Search" value="{{$searchWord}}">
                  @elseif(isset($searchWord))
                    @if($searchWord=="searchWordNot")
                      <input id="searchWord" type="text" value="" class="form-control form-control-sm bg-light border-primary" placeholder="조회" aria-label="Search" >
                    @else
                      <input id="searchWord" type="text" value="{{$searchWord}}" class="form-control form-control-sm bg-light border-primary small" aria-label="Search">
                    @endif
                  @endif
                  <div class="input-group-append ">
                    <button type="button" class="btn btn-sm btn-primary" onclick="monitor.search('1')">
                      <i class="fas fa-search fa-sm"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body py-3">
              <div id="monitorDatatable" class="table-responsive overflow-x-scroll" style="height: calc((1vh) * 50);">
                @include('monitoring.monitorJobSearchList')
              </div>
              <div id="jobDetailList" class="table-responsive overflow-x-scroll">
                @include('monitoring.monitorJobDetailList')
              </div>
              <div id="scheduleProcessList" class="table-responsive overflow-x-scroll">
                @include('monitoring.scheduleProcessList')
              </div>
            </div>
          </div>
        </div>
      </div>
      @include('common.footer')
    {{--content 끝--}}
    </div>
    {{-- 잡시퀀스 , 스케줄시퀀스,프로그램 시퀀스 --}}
    <input type="hidden" id="jobSeq">
    <input type="hidden" id="scSeq">
    <input type="hidden" id="pSeq">
</body>
</html>
