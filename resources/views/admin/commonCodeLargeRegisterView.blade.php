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
              <h5 class="m-0 font-weight-bold text-primary">코드 정보 상세</h5>
            </div>
            <div class="card-body">
                <hr>
                <div class="row">
                  <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">대분류 코드</div>
                  <input type="text" id="WorkLarge"  class="col-md-1 form-control form-control-sm align-self-center" value="" >
                  <div class="input-group-append col-md-2">
                    <div class="btn btn-primary" onclick="code.commonCodeLargeExist()">
                      <i class="fas fa-search fa-sm"></i>
                    </div>
                  </div>
                  <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">사용 여부</div>
                  <select  id="Used"  class="col-md-3 form-control form-control-sm align-self-center">
                    <option value="1" selected>사용</option>
                    <option value="0" >미사용</option>
                  </select> 
                </div>
                <hr>
                
                <div class="row">
                  <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">코드 명</div>
                  <input type="text" id="CodeShortName"  class="col-md-3 form-control form-control-sm align-self-center" value="" >
                  <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">코드 전체명</div>
                  <input type="text" id="CodeLongName"  class="col-md-3 form-control form-control-sm align-self-center" value="">     
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">설명</div>
                  <textarea type="text" id="CodeSulmyung" class="col-md-10 form-control form-control-sm" style="resize: none;" ></textarea>
                </div>
                <hr>
              <div class="row justify-content-end">
                <button type="button" class="mt-3 mr-2 btn btn-success" onclick="code.largeRegister()">등록</button>
                <button type="button" class="mt-3 mr-2 btn btn-danger" onclick="history.back()">취소</b>
              </div>
                {{-- 코드타입 / 대분류 /중분류 검색된 리스트  --}}
              <div class="card-body py-3" id="commonCodeSearchList">
                <div class="table-responsive">
                  <table id="datatable" class="table table-bordered" cellspacing="0">
                      <thead>
                        <tr>
                            <th>대분류</th>
                            <th>코드</th>
                            <th>사용 여부</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
                </div>
              </div>
          </div>
        </div>
      </div>
    @include('common.footer')
    </div>
  </div>
  <script>
    // 검색 페이징
    $(document).ready(function(){
        $(document).on('click','.pagination a',function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var WorkLarge = $(this).attr('href').split('WorkLarge=')[1].split('&')[0];
            fetch_data(page,WorkLarge);
        });
        function fetch_data(page,WorkLarge){
            $.ajax({
                url:"/admin/commonCodeLargeExist",
                method:"get",
                data:{
                    'page':page,
                    'WorkLarge':WorkLarge,
                },
                success:function(resp){
                    $('#commonCodeSearchList').html(resp.returnHTML)
                },
                error:function(err){

                }
            })
        };
        code.commonCodeLargeExist();
    });
  
</script>
</body>
</html>

