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
    <div class="d-flex flex-column" style="width:100%">
      <!-- Main Content -->
      <div id="content">
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <h4 class="h3 my-4 font-weight-bold" style="color:white">중분류 코드 정보 등록</h4>
          <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-2 text-center align-self-center font-weight-bold">대분류</div>
                  <select id="WorkLarge" onchange="code.workMediumInfo()" class="col-md-3 form-control form-control-sm align-self-center">
                    @php
                    $i = 0;
                    $len = count($workLargeCtgData);
                    @endphp
                    @foreach ($workLargeCtgData as $code)
                    @if ($i == 0) {
                        <option value="{{$code->worklarge}}" selected>{{$code->shortname}}</option>  
                    @else
                        <option value="{{$code->worklarge}}">{{$code->shortname}}</option>  
                    @endIf
                    @php
                        $i++;
                    @endphp
                    @endforeach
                  </select>
                  <div class="col-md-2 text-center align-self-center font-weight-bold">중분류 코드 번호</div>
                  <input type="text" id="WorkMedium"  class="col-md-3 form-control form-control-sm align-self-center" placeholder="예)01">     
                  <div class="input-group-append col-md-2">
                    <div class="btn btn-primary" onclick="code.commonCodeExist()">
                      <i class="fas fa-search fa-sm"></i>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-1 text-center align-self-center font-weight-bold">코드명 </div>
                  <input type="text" id="CodeShortName"  class="col-md-2 form-control form-control-sm align-self-center" placeholder="pc" >
                  <div class="col-md-2 text-center align-self-center font-weight-bold">코드 전체명</div>
                  <input type="text" id="CodeLongName"  class="col-md-2 form-control form-control-sm align-self-center" placeholder="전체 pc">
                  <div class="col-md-2 text-center align-self-center font-weight-bold">사용 여부</div>
                  <select  id="Used"  class="col-md-3 form-control form-control-sm align-self-center">
                    <option value="1" selected>사용</option>
                    <option value="0" >미사용</option>
                  </select>
                </div>
                <hr>
                <div class="row">
                  <div id="FilePathDiv" class="col-md-2 text-center align-self-center font-weight-bold">경로</div>
                  <input type="text" id="FilePath"  class="col-md-2 form-control form-control-sm align-self-center" placeholder="/incar/incarproject">
                  <div class="col-md-2 text-center align-self-center font-weight-bold">설명</div>
                  <textarea type="text" id="CodeSulmyung" class="col-md-6 form-control form-control-sm" placeholder="코드 설명" style="resize: none;"></textarea>
                </div>
                <hr>
              <div class="row justify-content-end">
                <button type="button" class="mt-3 mr-2 btn btn-primary" onclick="code.register()">등록</button>
                <button type="button" class="mt-3 mr-2 btn btn-danger" onclick="history.back()">취소</b>
              </div>
              {{-- 코드타입 / 대분류 /중분류 검색된 리스트  --}}
              <div class="card-body py-3" id="commonCodeSearchList">
                <div class="table-responsive">
                  <table id="datatable" class="table table-bordered" cellspacing="0">
                      <thead>
                        <tr>
                            <th>대분류</th>
                            <th>중분류</th>
                            <th>코드</th>
                            <th>경로</th>
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
    </div>
  </div>
  <script>
    // 검색 페이징
    $(document).ready(function(){
        $(document).on('click','.pagination a',function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var WorkLarge = $(this).attr('href').split('WorkLarge=')[1].split('&')[0];
            var WorkMedium = $(this).attr('href').split('WorkMedium=')[1].split('&')[0];
            fetch_data(page,WorkLarge,WorkMedium);
        });
        function fetch_data(page,WorkLarge,WorkMedium){
            $.ajax({
                url:"/admin/commonCodeExist",
                method:"get",
                data:{
                    'page':page,
                    'WorkLarge':WorkLarge,
                    'WorkMedium':WorkMedium
                },
                success:function(resp){
                    $('#commonCodeSearchList').html(resp.returnHTML)
                },
                error:function(err){

                }
            })
        };
        //조회
        code.workMediumInfo();

    })
</script>
</body>
</html>

