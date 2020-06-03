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
@include('popup.popupCommon.head')
@include('popup.popupCommon.popupJs')
<script>
  function monitoringLogMore(){
    if($('#lineCount').val()>=1000){
      alert('웹 상에서는 1000줄을 초과하여 로그를 출력할 수 없습니다.\n 서버 상에서 로그를 확인해주세요');
      return false;
    }
    if($('#lineCount').val()==""){
      $('#lineCount').val(0);
    }
    //1 최신 0 과거
    if($("#headTail").is(":checked")){
      $('#headTail').val(1);
    }else{
      $('#headTail').val(0);
    }
    //1 라인넘버 o 2 라인넘버 x
    if($("#setNum").is(":checked")){
      $('#setNum').val(1);
    }else{
      $('#setNum').val(0);
    }
    $.ajax({
      url:'/popup/monitoringLogMore',
      method:'get',
      data:{
        'Job_Seq':$('#Job_Seq').val(),
        'Sc_Seq':$('#Sc_Seq').val(),
        'P_Seq': $('#P_Seq').val(),
        'loop':$('#loop option:selected').val(),
        'lineCount':$('#lineCount').val(),
        'searchWord':$('#searchWord').val(),
        'headTail':$('#headTail').val(),
        'setNum':$('#setNum').val()
      },
      success:function(resp){
        if(resp.msg=="success"){
          $('#logFileOutput').html(resp.lineAdd);
          $('#Job_Seq').val(resp.Job_Seq);
          $('#Sc_Seq').val(resp.Sc_Seq);
          $('#P_Seq').val(resp.P_Seq);
          $('#proName').html('프로그램 명 : <span style="color:#858796;">'+resp.processName+'</span>');
          $('#proLogName').html('프로그램 로그 경로: <span style="color:#858796;">'+resp.fileName+'</span>');
          $('#proLogUpdDate').html('프로그램 로그 수정일시: <span style="color:#858796;">'+resp.lastModifiedDatetime+'</span>');
          if(resp.fileSize>0){
            $('#proLogSize').html('프로그램 로그 사이즈: <span style="color:#858796;">'+resp.fileSize+'MB</span>');
          }else{
            $('#proLogSize').html('프로그램 로그 사이즈: <span style="color:#858796;">'+resp.fileSize+'MB 이하</span>');
          }
          $('#loop option:selected').val(resp.loop);
          $('#lineCount').val(resp.lineCount);
          if(resp.headTail==1){
            $('#headTail').prop("checked",true);
          }else{
            $('#headTail').prop("checked",false);
          }
          if(resp.setNum==1){
            $('#setNum').prop("checked",true);
          }else{
            $('#setNum').prop("checked",false);
          }
          $('#logFileOutput').scrollTop(0);
        }else if(resp.msg=="failedOne"){
        //디비에는 조회가 되지만 파일이 서버상에 없는경우
        //이 경우는 잡 또는 프로그램이 실행을 하지 않아 로그가 생기지 않았거나 데몬이 안돌았거나 
          alert("로그 파일이 존재하지 않습니다. \n 예)  잡 또는 프로그램이 실행을 하지 않아 로그가 생기지 않는 오류입니다. ");
          window.close();
        }else if(resp.msg=="failedTwo"){
        //로그파일명 조회가 안될경우
          alert("DB에 로그 파일명이 존재하지 않습니다. \n DB를 확인해주세요.");
          window.close();
        }

      
      }
    })
  }
  function monitoringLogSearch(){
    if($('#lineCount').val()>=1000){
      alert('웹 상에서는 1000줄을 초과하여 로그를 출력할 수 없습니다.\n 서버 상에서 로그를 확인해주세요');
      return false;
    }
    if($("#headTail").is(":checked")){
      $('#headTail').val(1);
    }else{
      $('#headTail').val(0);
    }
    if($("#setNum").is(":checked")){
      $('#setNum').val(1);
    }else{
      $('#setNum').val(0);
    }
    $('#lineCount').val(0);
    $.ajax({
      url:'/popup/monitoringLogMore',
      method:'get',
      data:{
        'Job_Seq':$('#Job_Seq').val(),
        'Sc_Seq':$('#Sc_Seq').val(),
        'P_Seq': $('#P_Seq').val(),
        'loop':$('#loop option:selected').val(),
        'lineCount':$('#lineCount').val(),
        'searchWord':$('#searchWord').val(),
        'headTail':$('#headTail').val(),
        'setNum':$('#setNum').val()
      },
      success:function(resp){
        $('#logFileOutput').html(resp.lineAdd);
        $('#Job_Seq').val(resp.Job_Seq);
        $('#Sc_Seq').val(resp.Sc_Seq);
        $('#P_Seq').val(resp.P_Seq);
        $('#proName').html('프로그램 명 : <span style="color:#858796;">'+resp.processName+'</span>');
        $('#proLogName').html('프로그램 로그 경로: <span style="color:#858796;">'+resp.fileName+'</span>');
        $('#proLogUpdDate').html('프로그램 로그 수정일시: <span style="color:#858796;">'+resp.lastModifiedDatetime+'</span>');
        if(resp.fileSize>0){
          $('#proLogSize').html('프로그램 로그 사이즈: <span style="color:#858796;">'+resp.fileSize+'MB</span>');
        }else{
          $('#proLogSize').html('프로그램 로그 사이즈: <span style="color:#858796;">'+resp.fileSize+'MB 이하</span>');
        }
        $('#loop option:selected').val(resp.loop);
        $('#lineCount').val(resp.lineCount);
        $('#searchWord').val($('#searchWord').val());
        if(resp.headTail==1){
          $('#headTail').prop("checked",true);
        }else{
          $('#headTail').prop("checked",false);
        }
        if(resp.setNum==1){
          $('#setNum').prop("checked",true);
        }else{
          $('#setNum').prop("checked",false);
        }
        $('#logFileOutput').scrollTop(0);
      }
    })
  }
 
  $(document).ready(function(){
    monitoringLogMore();
  })
</script>
<body class="bg-gradient-primary">
  <div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="p-3">
              <div class="text-left">
                <h4 class="font-weight-bold text-primary mb-4">프로그램 로그</h4>
              </div>
              <div class="text-left">
                <h6 id="proName" class="font-weight-bold text-primary mb-4"></h6>
                <h6 id="proLogName" class="font-weight-bold text-primary mb-4"></h6>
                <h6 id="proLogUpdDate" class="font-weight-bold text-primary mb-4"></h6>
                <h6 id="proLogSize" class="font-weight-bold text-primary mb-4"></h6>
              </div>
              <hr>
              <div class="d-inline-block w-100">
                {{-- <button class="btn btn-sm btn-primary mx-1">오름차순</button>
                <button class="btn btn-sm btn-primary mx-1">내림차순</button> --}}
                <span class="text-primary">최신순</span><input id="headTail" type="checkbox" style="margin-right: 20px" checked>
                <span class="text-primary">라인 넘버</span><input id="setNum" type="checkbox" style="margin-right: 20px" checked>
                <span class="text-primary">로그 출력  </span>
                <select id="loop" class="d-inline-block form-control form-control-sm w-auto">
                  <option selected>10</option>
                  <option>50</option>
                  <option>100</option>
                  <option>200</option>
                </select>
                <span class="text-primary" style="margin-right: 20px">개씩</span>
                <span class="text-primary">라인 : <input type="text" id="lineCount" value="" style="border: none" readonly></span>
                <div class="d-inline-block float-right">
                  <input type="text" id="searchWord" class="d-inline-block form-control form-control-sm w-auto" value=""
                    placeholder="검색" />
                  <button type="button" onclick="monitoringLogSearch()" class="btn btn-sm btn-primary">
                    <i class="fas fa-search fa-sm"></i>
                  </button>

                </div>
              </div>
              <div class="border-left-primary pl-3 mt-2">
                <div id="logFileOutput" style="overflow-x:scroll;">
                </div>
              </div>
              <div class="btn_more_wrap">
                <button type="button" onclick="monitoringLogMore()" class="btn_more"><i class="ico_more"></i>더보기</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<input type="hidden" id="Job_Seq" value="{{$Job_Seq}}" />
<input type="hidden" id="Sc_Seq" value="{{$Sc_Seq}}"/>
<input type="hidden" id="P_Seq" value="{{$P_Seq}}"/>
</body>
  </html>