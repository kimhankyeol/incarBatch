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
<script>$(function(){$("#scheduleList").colResizable({onDrag:null,liveDrag:true});});</script>
<script>
	var colResiz = function(){
    const scTable = document.getElementById("scheduleListTable");
    const scpTable = document.getElementById("scheduleProcessListTable");
    if(!scTable.children[0]) {
      $("#scheduleList").colResizable({
        liveDrag:true, 
        partialRefresh:true,
        onDrag:null
      });
    }
    if(!scpTable.children[2]) {
      $("#scheduleProcessList").colResizable({
        liveDrag:true, 
        partialRefresh:true,
        onDrag:null
      });
    }
	}
</script>
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
      var searchPage = href_param.split('page=')[1];
      
      var scheduleProcessList = document.getElementById("scheduleProcessListTable");
      scheduleProcessList.style.display = "none";
      $.ajax({
        url: href,
        method: "get",
        data: {
          "page": searchPage
        },
        success: function (resp) {
          console.log(resp.returnHTML);
          $('#scheduleListTable').html(resp.returnHTML)
        }
      })
    });
    $( document ).ajaxComplete(function( event, request, settings ) {
      colResiz();
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
                    <label class="custom-control-label font-weight-bold text-primary" for="status_start">실행중</label>
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
              <div id="scheduleListTable" class="table-responsive overflow-x-scroll" style="height: calc((1vh) * 50);">
                @include('monitoring.scheduleList')
              </div>
              <div id="scheduleProcessListTable" class="table-responsive overflow-x-scroll">
                @include('monitoring.scheduleProcessList')
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- 잡시퀀스 , 스케줄시퀀스,프로그램 시퀀스 --}}
    <input type="hidden" id="jobSeq">
    <input type="hidden" id="scSeq">
    <input type="hidden" id="pSeq">
    <input type="hidden" id="regDate">
    {{--  Modal 모달  --}}
    <div class="modal fade" id="reworkModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold modal-title text-danger">재작업</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <textarea id="Sc_Note" class="form-control" maxlength="2000" placeholder="재작업 사유" onkeyup="check_text(this);" onkeypress="check_text(this);"> </textarea>
            <span id="text_cnt" class="d-block text-right text-gray-500">text_cnt</span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info" onclick="monitor.reWorkSchedule()">재작업</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
          </div>
        </div>
      </div>
    </div>
    <script>
      $("#Sc_Note").val('');
      $("#text_cnt").html('0 / 2000 Byte');
      function check_text(obj){
        var text_cnt = $(obj).val().length;
        if(text_cnt >= 2000) {
          event.preventDefault();
          alert("2000 Byte 이상 작성할 수 없습니다.");
        }
        $("#text_cnt").html(text_cnt+' / 2000 Byte');
      }
    </script> 
</body>
</html>
