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
  $(document).ready(function() {
    var now = new Date();
    var month = (now.getMonth() + 1);               
    var day = now.getDate();
    var firstDayOfMonth = new Date( now.getFullYear(), now.getMonth() , 1 );
    var yestermonth = new Date (firstDayOfMonth.setDate( firstDayOfMonth.getDate()-1)).getMonth() +1;

    if (month < 10) 
        month = "0" + month;
    if (yestermonth < 10) 
        yestermonth = "0" + yestermonth;
    if (day < 10) 
        day = "0" + day;
    var yesterday = now.getFullYear() + '-' + yestermonth + '-' + day;
    var today = now.getFullYear() + '-' + month + '-' + day;
    $('#startDate').val(yesterday);
    $('#endDate').val(today);
  });
</script>
<body id="page-top">
  <div id="wrapper">
    @include('common.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <div class="container-fluid">
          <h4 class="h3 my-4 font-weight-bold text-primary">작업내역</h4>
          <div class="card shadow mb-4">
            <div class="py-2">
            {{-- 조건 --}}
              <div class="w-100 mr-auto my-2 mw-100 px-3 text-right">
                <div class="d-inline-flex input-group align-items-center w-auto my-1">
                  <div class="input-group align-items-center">
                    <div class="input-group align-items-center">
                      <div class="mx-2 custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input status" name="status" id="success_status" checked>
                        <label class="custom-control-label font-weight-bold text-primary" for="success_status">완료</label>
                      </div>
                      <div class="mx-2 custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input status" name="status" id="error_status" checked>
                        <label class="custom-control-label font-weight-bold text-primary" for="error_status">오류</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="d-inline-flex input-group align-items-center w-auto my-1">
                  {{-- 업무 구분 대분류 중분류 선택 --}}
                  <div class="text-center align-self-center font-weight-bold text-primary mx-2">업무 구분</div>
                  @include("code.codeSelect")
                </div>
                <div class="d-inline-flex input-group align-items-center w-auto my-1">
                  <div class="input-group align-items-center">
                    <div class="text-center align-self-center font-weight-bold text-primary mx-2">등록일</div>
                     {{-- 검색 조건 --}}
                     <input type="date" class="form-control form-control-sm" id="startDate">
                     <span class="form-control-sm"> ~ </span>
                     <input type="date" class="form-control form-control-sm" id="endDate">
                  </div>
                </div>
                <div class="d-inline-flex input-group align-items-center w-auto my-1">
                  <div class="d-inline-flex align-items-center">
                    <div class="text-center align-self-center font-weight-bold text-primary mx-2 w-100">구분</div>
                    <select class="form-control form-control-sm w-auto" id="searchType">
                      <option value="job">
                        잡
                      </option>
                      <option value="cs">
                        스케줄
                      </option>
                    </select>
                  </div>
                  {{-- 검색 단어가 있을떄 없을때 구분  --}}
                  @if(!isset($searchValue))
                    <input id="searchValue" type="text" class="form-control form-control-sm" placeholder="조회" aria-label="Search" value="{{$searchValue}}">
                  @elseif(isset($searchValue))
                    @if($searchValue=="searchWordNot")
                      <input id="searchValue" type="text" value="" class="form-control form-control-sm" placeholder="조회" aria-label="Search" >
                    @else
                      <input id="searchValue" type="text" value="{{$searchValue}}" class="form-control form-control-sm" aria-label="Search">
                    @endif
                  @endif
                  <div class="input-group-append">
                    <div class="btn btn-sm btn-primary" onclick="history.search(1)">
                      <i class="fas fa-search fa-sm"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card shadow mb-4">
            <div class="card-body py-3">
              <div class="table-responsive">
                <div class="table-responsive table-list">
                  <table id="datatable" class="table table-bordered" width="100%" cellspacing="0">
                    <colgroup>
                      <col width="180px" />
                      <col width="150px" />
                      <col width="60px" />
                      <col width="80px" />
                      <col width="200px" />
                      <col width="100px" />
                      <col width="300px" />
                      <col width="100px" />
                    </colgroup>
                    <thead>
                      <tr>
                        <th>작업일시</th>
                        <th>ID</th>
                        <th>버전</th>
                        <th>결과</th>
                        <th>프로그램 명</th>
                        <th>실행자</th>
                        <th>파라미터</th>
                        <th>작업상세</th>
                      </tr>
                    </thead>
                    <tbody>
                      {{--  조회된 값이 보여주는 위치 --}}
                      @if(isset($data))
                        @include('history.historySearchList')
                      @endIf
                    </tbody>
                  </table>
                  @if(isset($paginator))
                    {{$paginator->setPath('/history/historyListView')->appends(request()->except($searchParams))->links()}}
                  @endIf
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @include('common.footer')
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