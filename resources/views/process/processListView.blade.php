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
      <!-- Main Content -->
  <div id="content">
    <!-- End of Topbar -->
    <!-- Begin Page Content -->
    <div class="container-fluid" style="height: 100%">
      <!-- Page Heading -->
      <!-- DataTales Example -->
      <div class="card shadow mb-4" style="height: 100%">
        <div class="d-flex justify-content-end card-header py-3">
          <h5 class="p-2 font-weight-bold text-primary">프로그램</h5>
          <div class="d-none d-sm-inline-block form-inline ml-auto my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group align-items-center" style="display:inline-flex">
              <div class="text-center align-self-center font-weight-bold text-primary mx-2">업무구분</div>
              <div class=" text-center align-self-center font-weight-bold text-primary mx-2">대분류</div>
                  <select class="form-control form-control-sm">
                    <option>
                      인카금융서비스
                    </option>
                  </select>
                  <div class="text-center align-self-center font-weight-bold text-primary mx-2">중분류</div>
                  <select class="form-control form-control-sm ml-2 mr-5">
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
                  <select class="form-control bg-light small" style="border: 1px solid #4E73DF !important;">
                    <option>
                      프로그램 명
                    </option>
                    <option>
                      등록자
                    </option>
                  </select>
                  {{-- 검색 단어가 있을떄 없을때 구분  --}}
                  @if(!isset($searchWord))
                    <input id="searchWord" type="text" class="form-control bg-light border-0 small" placeholder="조회" aria-label="Search" style="border: 1px solid #4E73DF !important;">
                  @elseif(isset($searchWord))
                    <input id="searchWord" type="text" value="{{$searchWord}}" class="form-control bg-light border-0 small" aria-label="Search" style="border: 1px solid #4E73DF !important;">
                  @endif
                  <div class="input-group-append">
                    <div class="btn btn-primary" onclick="process.search('1')">
                      <i class="fas fa-search fa-sm"></i>
                    </div>
                  </div>
                  <div class=" text-center align-self-center font-weight-bold text-primary mx-2">
                    <div class="btn btn-primary" onclick="pageMove.process.list('processRegisterView')" style="cursor:pointer">등록</div>
                  </div>
            </div>
          </div>
        </div>
        <div class="card-body py-3">
          <div class="table-responsive">
            <div class="table-responsive">
              <table id="datatable" class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th style="background-color:#47579c; color : #fff">프로그램 ID</th>
                        <th style="background-color:#47579c; color : #fff">프로그램 명</th>
                        <th style="background-color:#47579c; color : #fff">업무구분(대분류)</th>
                        <th style="background-color:#47579c; color : #fff">업무구분(중분류)</th>
                        <th style="background-color:#47579c; color : #fff">프로그램 설명</th>
                        <th style="background-color:#47579c; color : #fff">프로그램 등록자</th>
                        <th style="background-color:#47579c; color : #fff">프로그램 등록시점</th>
                      </tr>
                    </thead>
                  <tbody>
                      {{--  조회된 값이 보여주는 위치 --}}
                @if(isset($data))
                  @include('process.processSearchListView')
                @endIf
                  </tbody>
              </table>
              @if(isset($data))
                {{-- 페이징 이동 경로 --}}
                  {{$data->setPath('/process/processListView')->appends(request()->except($searchParams))->links()}}
              @endIf
          </div>
              
          </div>
        </div>
      </div>
    </div>
  </div>
      @include('common.footer')
    {{--content 끝--}}
    </div>
</body>
</html>
  
  
