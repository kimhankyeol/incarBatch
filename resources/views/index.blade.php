<?php
//분기 처리 해주는 php 위치 
$ifViewRender = new App\Http\Controllers\Render\IfViewRender;
$ifViewRender->setRenderInfo($_SERVER['REQUEST_URI']);
//include 될 blade.php 의 경로 + 파일명을 가져옴
//render 할 viewName index.blade include에 들어감
$renderInfo = $ifViewRender->getRender();
//title 변경 스크립트  common/head.blade 쓰이는 변수 
$titleInfo  = $ifViewRender->getHtmlTitle();
//url 에따른 resource 변경 추가 할떄   common/head.blade 쓰이는 변수 
$resourceInfo = $ifViewRender->getResource();
//사이드바 정보   common/sidebar.blade
$sidebarInfo = $ifViewRender->getSidebarArray();

?>
<!DOCTYPE html>
<html lang="en">
  {{--include 의 경로는 public/resource/view/부터 시작함--}}
{{-- head 부분 --}}
@include('common.head')
<body id="page-top">
  <div id="wrapper">
    {{-- 블레이드 주석 쓰는 법--}}
    {{--사이드바 시작--}}
    @include('common.sidebar')
    {{--사이드바 끝--}}
    {{--content 시작--}}
    <div id="content-wrapper" class="d-flex flex-column">
       {{--이 부분은 요청 경로를 통해 유동적으로 변경--}}
      @include($renderInfo)
     {{--Footer start  --}}
      @include('common.footer')
      {{--Footer end  --}}
    {{--content 끝--}}
  </div>
</body>
</html>
