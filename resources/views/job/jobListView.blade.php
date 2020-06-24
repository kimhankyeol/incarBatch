<!DOCTYPE html>
<html lang="en">
@include('common.head')
<script>document.title="잡 목록"</script>
<body id="page-top">
    <div id="wrapper" class="bodyBgImg">
    {{-- 블레이드 주석 쓰는 법--}}
    {{--사이드바 시작--}}
    @include('common.sidebar')
    {{--사이드바 끝--}}
    {{--content 시작--}}
    <div class="d-flex flex-column">
        <!-- Main Content -->
      <div id="content">
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <!-- DataTales Example -->
          <h4 class="h3 my-4 font-weight-bold" style="color:white">잡</h4>
          <div class="card shadow mb-4">
            <div class="d-flex justify-content-end card-header py-3">
              <div class="d-none d-sm-inline-block form-inline ml-auto my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group align-items-center">
                   {{-- 업무 구분 대분류 중분류 선택 --}}
                  <div class="text-center align-self-center font-weight-bold mx-2">업무 구분</div>
                  @include("code.codeSelect")
                   {{-- 검색 조건 --}}
                  <select class="form-control bg-light small">
                    <option>
                      잡명
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
                    <div class="btn btn_orange"  onclick="job.search()">
                      <i class="fas fa-search fa-sm" style="color:white"></i>
                    </div>
                  </div>
                  <button type="button"  class="btn btn_orange mx-2" style="color:white" onclick="pageMove.job.register('jobRegisterView')">등록</button>
                </div>
              </div>
            </div>
            <div class="card-body py-3">
              <div class="table-list overflow-auto">
                <table id="datatable" class="table table-bordered hoverTable" cellspacing="0">
                  <colgroup>
                    <col width="15%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="17%" />
                    <col width="23%" />
                    <col width="10%" />
                    <col width="15%" />
                  </colgroup>
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>대분류</th>
                        <th>중분류</th>
                        <th>잡 명</th>
                        <th>설명</th>
                        <th>등록자</th>
                        <th>등록일</th>
                      </tr>
                    </thead>
                    <tbody>
                        {{--  조회된 값이 보여주는 위치 --}}
                        @if(isset($data))
                        @include('job.jobSearchListView')
                        @endIf
                    </tbody>
                </table>
                {{-- 페이징 이동 경로 --}}
                    @if(isset($paginator))
                    {{$paginator->setPath('/job/jobListView')->appends(request()->except($searchParams))->links()}}
                    @endIf
              </div>
            </div>
          </div>
        </div>
      </div>
    {{--content 끝--}}
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
