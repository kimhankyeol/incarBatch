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
  <div id="wrapper"  class="bodyBgImg">
    {{-- 블레이드 주석 쓰는 법--}}
    {{--사이드바 시작--}}
    @include('common.sidebar')
    {{--사이드바 끝--}}
    {{--content 시작--}}
    <div class="d-flex flex-column" style="width:100%">
      <!-- Main Content -->
      <div id="content">
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h4 class="h3 my-4 font-weight-bold" style="color:white">대분류 코드 수정</h4>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-body">
                <hr>
                <div class="row">
                  <div class="col-md-3 text-center align-self-center font-weight-bold">대분류 코드</div>
                  <input type="text" id="WorkLarge"  class="col-md-3 form-control form-control-sm align-self-center" value="{{$commonCodeDetail[0]->worklarge}}" readonly>
                  <div class="col-md-3 text-center align-self-center font-weight-bold">사용 여부</div>
                  <select  id="Used"  class="col-md-3 form-control form-control-sm align-self-center">
                    @if($commonCodeDetail[0]->used==1)
                    <option value="1" selected>사용</option>
                    <option value="0" >미사용</option>
                    @else
                    <option value="1">사용</option>
                    <option value="0" selected>미사용</option>
                    @endif
                  </select>
                </div>
                <hr>
                
                <div class="row">
                  <div class="col-md-3 text-center align-self-center font-weight-bold">코드 명</div>
                  <input type="text" id="CodeShortName"  class="col-md-3 form-control form-control-sm align-self-center" value="{{$commonCodeDetail[0]->shortname}}">
                  <div class="col-md-3 text-center align-self-center font-weight-bold">코드 전체명</div>
                  <input type="text" id="CodeLongName"  class="col-md-3 form-control form-control-sm align-self-center" value="{{$commonCodeDetail[0]->longname}}">     
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-2 text-center align-self-center font-weight-bold">설명</div>
                  <textarea type="text" id="CodeSulmyung" class="col-md-10 form-control form-control-sm" style="resize: none;">{{$commonCodeDetail[0]->sulmyung}}</textarea>
                </div>
                <hr>
              <div class="row justify-content-end">
                <button type="button" class="mt-3 mr-2 btn btn-success" onclick="code.largeUpdate()">수정</button>
                <button type="button" class="mt-3 mr-2 btn btn-danger" onclick="history.back()">취소</b>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

