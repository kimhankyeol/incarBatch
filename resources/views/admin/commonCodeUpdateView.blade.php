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
              <h5 class="m-0 font-weight-bold text-primary">코드 정보 수정</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div id="codeLargeView" class="list-code"></div>
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">대분류 코드 번호</div>
                  <input type="text" id="WorkLarge"  class="col-md-3 form-control form-control-sm align-self-center" value="{{$commonCodeDetail[0]->WorkLarge}}" readonly>
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">중분류 코드 번호</div>
                  <input type="text" id="WorkMedium"  class="col-md-3 form-control form-control-sm align-self-center" value="{{$commonCodeDetail[0]->WorkMedium}}" readonly>     
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">코드명 </div>
                  <input type="text" id="CodeShortName"  class="col-md-2 form-control form-control-sm align-self-center" value="{{$commonCodeDetail[0]->ShortName}}" >
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">코드 전체명</div>
                  <input type="text" id="CodeLongName"  class="col-md-2 form-control form-control-sm align-self-center" value="{{$commonCodeDetail[0]->LongName}}">
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">사용 여부</div>
                  <select  id="Used"  class="col-md-3 form-control form-control-sm align-self-center">
                    @if($commonCodeDetail[0]->Used==1)
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
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">경로</div>
                  <input type="text" id="FilePath"  class="col-md-2 form-control form-control-sm align-self-center" value="{{$commonCodeDetail[0]->FilePath}}">
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">설명</div>
                  <textarea type="text" id="CodeSulmyung" class="col-md-6 form-control form-control-sm" style="resize: none;">{{$commonCodeDetail[0]->Sulmyung}}</textarea>
                </div>
                <hr>
              <div class="row justify-content-end">
                <button type="button" class="mt-3 mr-2 btn btn-success" onclick="code.update()">수정</button>
                <button type="button" class="mt-3 mr-2 btn btn-danger" onclick="history.back()">취소</b>
              </div>
          </div>
        </div>
      </div>
    @include('common.footer')
    </div>
  </div>
</body>
</html>

