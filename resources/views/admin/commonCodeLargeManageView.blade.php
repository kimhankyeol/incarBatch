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
   
           <!-- Main Content -->
      <div id="content">
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <!-- DataTales Example -->
          <h4 class="h3 my-4 font-weight-bold text-primary">대분류 코드 관리</h4>
          <div class="card shadow mb-4">
            <div class="d-flex justify-content-end card-header py-3">
              <div class="d-none d-sm-inline-block form-inline ml-auto my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group align-items-center">
                  {{-- 검색 조건 --}}
                  <select class="form-control bg-light border-primary small">
                    <option>
                      코드 명칭
                    </option>
                  </select>
                  {{-- 검색 단어가 있을떄 없을때 구분  --}}
                  @if(!isset($searchWord))
                    <input id="searchWord" type="text" class="form-control bg-light border-primary small" placeholder="조회" aria-label="Search">
                  @elseif(isset($searchWord))
                    @if($searchWord=="searchWordNot")
                    <input id="searchWord" type="text" value="" class="form-control bg-light border-primary small" aria-label="Search">
                    @elseif($searchWord!="searchWordNot")
                    <input id="searchWord" type="text" value="{{$searchWord}}" class="form-control bg-light border-primary small" aria-label="Search">
                    @endif
                  @endif
                  <div class="input-group-append">
                    <div class="btn btn-primary" onclick="code.largeSearch('1')">
                      <i class="fas fa-search fa-sm"></i>
                    </div>
                  </div>
                  <button type="button" class="btn btn-primary mx-2" onclick="pageMove.admin.register('commonCodeLargeRegisterView')">등록</button>
                </div>
              </div>
            </div>
            <div class="card-body py-3">
              <div class="table-responsive">
                <table id="datatable" class="table table-bordered" cellspacing="0">
                    <thead>
                      <tr>
                        <th>코드</th>
                        <th>대분류</th>
                        <th>사용 여부</th>
                      </tr>
                    </thead>
                    <tbody>
                        {{--  조회된 값이 보여주는 위치 --}}
                        @if(isset($data))
                        @include('admin.commonCodeLargeSearchListView')
                        @endIf
                    </tbody>
                </table>
                    {{-- 페이징 이동 경로 --}}
                    @if(isset($data))
                    {{$data->setPath('/admin/commonCodeLargeManageView')->appends(request()->except($searchParams))->links()}}
                    @endIf
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