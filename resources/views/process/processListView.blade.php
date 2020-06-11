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
<body id="page-top" class="bodyBgImg">
  <div id="wrapper">
    {{-- 블레이드 주석 쓰는 법--}}
    {{--사이드바 시작--}}
    @include('common.sidebar')
    {{--사이드바 끝--}}
    {{--content 시작--}}
    <div class="d-flex flex-column">
      <!-- Main Content -->
      <!-- Main Content -->
      <div id="content">
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <!-- DataTales Example -->
          <h4 class="h3 my-4 font-weight-bold" style="color:white">프로그램</h4>
          <div class="card shadow mb-4">
            <div class="d-flex justify-content-end card-header py-3">
              <div class="d-none d-sm-inline-block form-inline ml-auto my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group align-items-center">
                  {{-- 업무 구분 대분류 중분류 선택 --}}
                  <div class="text-center align-self-center font-weight-bold mx-2">업무 구분</div>
                  @include("code.codeSelect")
                  <select class="form-control bg-light small">
                    <option>
                      프로그램 명
                    </option>
                  </select>
                  {{-- 검색 단어가 있을떄 없을때 구분  --}}
                  @if(!isset($searchWord))
                    <input id="searchWord" type="text" class="form-control bg-light small" placeholder="조회" aria-label="Search" value="{{$searchWord}}">
                  @elseif(isset($searchWord))
                  @if($searchWord=="searchWordNot")
                      <input id="searchWord" type="text" value="" class="form-control bg-light small" placeholder="조회" aria-label="Search" >
                  @else
                    <input id="searchWord" type="text" value="{{$searchWord}}" class="form-control bg-light small" aria-label="Search">
                  @endif
                  @endif
                  <div class="input-group-append">
                    <div class="btn btn_orange"  onclick="process.search('1')">
                      <i class="fas fa-search fa-sm" style="color:white"></i>
                    </div>
                  </div>
                  <button type="button" class="btn btn_orange mx-2" style="color:white"  onclick="pageMove.process.list('processRegisterView')">등록</button>
                </div>
              </div>
            </div>
            <div class="card-body py-3">
              <div class="table-list overflow-auto">
                  <table id="datatable" class="table table-bordered" cellspacing="0">
                    <colgroup>
                      <col width="130px" />
                      <col width="110px" />
                      <col width="150px" />
                      <col width="120px" />
                      <col width="120px" />
                      <col width="310px" />
                      <col width="100px" />
                      <col width="190px" />
                    </colgroup>
                    <thead>
                      <tr>
                        <th>경로</th>
                        <th>프로그램</th>
                        <th>프로그램 명</th>
                        <th>대분류</th>
                        <th>중분류</th>
                        <th>설명</th>
                        <th>등록자</th>
                        <th>등록일자</th>
                      </tr>
                    </thead>
                    <tbody>
                      {{--  조회된 값이 보여주는 위치 --}}
                      @if(isset($data))
                        @include('process.processSearchListView')
                      @endIf
                    </tbody>
                  </table>
                  @if(isset($paginator))
                    {{$paginator->setPath('/process/processListView')->appends(request()->except($searchParams))->links()}}
                  @endIf
              </div>
            </div>
          </div>
        </div>
      </div>
      {{--content 끝--}}
    </div>
  </div>
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
            },
            error:function(error){
  
            }
          })
    }
    </script>
</body>
</html>