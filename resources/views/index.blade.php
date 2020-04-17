<?php
//분기 처리 해주는 php 위치 
$ifViewRender = new App\Http\Controllers\Render\IfViewRender;
$ifViewRender->setRenderInfo($_SERVER['REQUEST_URI']);
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
        index 입니다.

        {{-- 팝업 임시 버튼 --}}
        <div class="m-5 b-5 text-center">
            <button type="button" class="btn btn-info" onclick="popup.processInfo()">프로세스상세</button>
            <button type="button" class="btn btn-info" onclick="popup.jobGusung()">잡 구성</button>
            <button type="button" class="btn btn-info" onclick="popup.jobAction()">잡 실행</button>
        </div>
        @include('common.footer')
    {{--content 끝--}}
    </div>
    {{-- 팝업 스크립트 --}}
    <script>
        const popup = {
            processInfo: function processInfo() {
                window.open('/popup/processInfo', '프로세스 상세정보', 'top=10, left=10, width=1080, height=547, status=no, location=no, directories=no, status=no, menubar=no, toolbar=no, scrollbars=yes, resizable=no');
            },
            jobGusung: function jobGusung() {
                window.open('/popup/jobGusung', '잡 구성', 'top=10, left=10, width=1400, height=720, status=no, location=no, directories=no, status=no, menubar=no, toolbar=no, scrollbars=yes, resizable=no');
            },
            jobAction: function jobAction() {
                window.open('/popup/jobAction', '잡 실행', 'top=10, left=10, width=1280, height=720, status=no, location=no, directories=no, status=no, menubar=no, toolbar=no, scrollbars=yes, resizable=no');
            }
        }
    </script>
</body>
</html>