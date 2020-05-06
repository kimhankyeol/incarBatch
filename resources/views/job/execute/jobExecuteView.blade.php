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
         <h4 class="h3 my-4 font-weight-bold text-primary">잡 실행</h4>
          <div class="card shadow mb-4">
            <div class="d-flex justify-content-end card-header py-3">
              <div class="d-none d-sm-inline-block form-inline ml-auto my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group align-items-center">
                   {{-- 업무 구분 대분류 중분류 선택 --}}
                  <div class="text-center align-self-center font-weight-bold text-primary mx-2">업무 구분</div>
                  @include("code.codeSelect")
                   {{-- 검색 조건 --}}
                  <select class="form-control bg-light border-primary small">
                    <option>
                      잡명
                    </option>
                  </select>
                  {{-- 검색 단어가 있을떄 없을때 구분  --}}
                  @if(!isset($searchWord))
                    <input id="searchWord" type="text" class="form-control bg-light border-primary small" placeholder="조회" aria-label="Search" value="{{$searchWord}}">
                  @elseif(isset($searchWord))
                    @if($searchWord=="searchWordNot")
                      <input id="searchWord" type="text" value="" class="form-control bg-light border-primary small" placeholder="조회" aria-label="Search" >
                    @else
                      <input id="searchWord" type="text" value="{{$searchWord}}" class="form-control bg-light border-primary small" aria-label="Search">
                    @endif
                  @endif
                  <div class="input-group-append">
                    <div class="btn btn-primary" onclick="job.search('1')">
                      <i class="fas fa-search fa-sm"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body py-3">
              <div class="table-list">
                <table id="datatable" class="table table-bordered" cellspacing="0">
                  <colgroup>
                    <col width="170px" />
                    <col width="150px" />
                    <col width="100px" />
                    <col width="100px" />
                    <col width="320px" />
                    <col width="110px" />
                    <col width="130px" />
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
                        @include('job.execute.jobSearchExecuteView')
                        @endIf
                    </tbody>
                </table>
                {{-- 페이징 이동 경로 --}}
                    @if(isset($paginator))
                    {{$paginator->setPath('/job/jobListView')->appends(request()->except($searchParams))->links()}}
                    @endIf
                </div>
            </div>
        <div class="container-fluid">
            <div class = "card shadow mb-4">
                <div class = "card-header py-3">
                    <h6 class = "m-0 font-weight-bold text-primary">작업 진행율</h6>
                </div>
                <div class = "card-body">
                    <div class= "progress mb-4">
                        <div class = "progress-bar bg-info" role="progressbar" style = "width:80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax='100'></div>
                    </div>
                </div>
                <div class = "Job_log">
                  {{-- 이 부분 나중에 css 바꾸면됨 --}}
                  <div class= "mb-4" id="jobTailLog">
                    <div>
                      <h6 class = "m-0 font-weight-bold text-primary" style="padding:0rem 1.25rem">로그</h6>
                    </div>
                    {{-- 로그가 보이는 영역 --}}
                    <textarea class = "Job_logarea" readonly>
                    </textarea>
                  </div>
                </div>
            </div>
        </div>
      </div>
       @include('common.footer')
    </div>
    {{-- 이 부분은 로그 추가 눌렀을떄 job_seq, line개수 받아오기 위한 input    jobTailAddView tailAdd()함수에서 쓸 값임--}}
    <input type="hidden" id="jobSeq" >

    <script>
      //더보기 클릭
      function tailAdd(){
        var jobSeq = $('#jobSeq').val();
        var line = parseInt($('#lineNum').val());
        //100줄씩 추가 
        var lineMore = 100 ; 
        line = parseInt(line + lineMore);
        if($("#setNum").is(":checked")){
            $("#setNum").val(1);
        }else{
            $("#setNum").val(0);
        }
        var setNum = $("#setNum").val();
        //라인수가 10000개 이상 30000개 미만일떄 분기처리 
        if(line>=10000&&line<30000){
          var result = confirm('로그 라인 수가 큽니다.\n 그래도 조회하시겠습니까?');
          if(result){
            $.ajax({
                url:"/job/jobTailAdd",
                method:"get",
                data:{
                    "line":line,
                    "Job_Seq":jobSeq,
                    "setNum":setNum
                },
                success:function(data){
                  if(data.lineTotal<line){
                    parseInt($('#lineNum').val(parseInt(data.lineTotal)));
                  }else if(data.lineTotal>=line){
                    parseInt($('#lineNum').val(parseInt(line)));
                  }
                  $('#jobSeq').val(jobSeq);
                  $('#jobTailLog').html(data.returnHTML);
                  //로그 출력하는 부분에 스크롤 맨아래쪽향하게 
                  var $logarea = $('.Job_logarea');
                  $logarea.scrollTop($logarea[0].scrollHeight);
                },
                error:function(err){
                  
                }
            })
          }else{
            return false;
          }
        }else if(line>=30000){
          //3만개 이상이면
          alert("조회하는 라인수가 너무 많습니다.\n 로그를 다운로드 받아주세요 ")
          return false;
        }else if(line<10000){
           //만개 미만
           $.ajax({
                url:"/job/jobTailAdd",
                method:"get",
                data:{
                    "line":line,
                    "Job_Seq":jobSeq,
                    "setNum":setNum
                },
                success:function(data){
                  // //토탈라인수 초과할떄 안할떄 분기 처리
                  // if(data.lineTotal<line){
                  //   parseInt($('#lineNum').val(parseInt(data.lineTotal)));
                  // }else if(data.lineTotal>=line){
                  //   parseInt($('#lineNum').val(parseInt(line)));
                  // }
                  $('#jobSeq').val(jobSeq);
                  $('#jobTailLog').html(data.returnHTML);
                  //로그 출력하는 부분에 스크롤 맨아래쪽향하게 
                  var $logarea = $('.Job_logarea');
                  $logarea.scrollTop($logarea[0].scrollHeight);
                },
                error:function(err){
                  
                }
            })
        }
      }
      // 라인수 입력  jobTailAddview search
      function tailAddSearch(){
          var jobSeq = $('#jobSeq').val();
          var line = $('#lineNum').val();
          if($("#setNum").is(":checked")){
              $("#setNum").val(1);
          }else{
              $("#setNum").val(0);
          }
          var setNum = $('#setNum').val();
          //라인수가 10000개 이상 30000개 미만일떄 분기처리 
          if(line>=10000&&line<30000){
            var result = confirm('로그 라인 수가 큽니다.\n 그래도 조회하시겠습니까?');
            if(result){
              $.ajax({
                  url:"/job/jobTailAdd",
                  method:"get",
                  data:{
                      "line":line,
                      "Job_Seq":jobSeq,
                      "setNum":setNum
                  },
                  success:function(data){
                    // if(data.lineTotal<line){
                    //   parseInt($('#lineNum').val(parseInt(data.lineTotal)));
                    // }else if(data.lineTotal>=line){
                    //   parseInt($('#lineNum').val(parseInt(line)));
                    // }
                    $('#jobSeq').val(jobSeq);
                    $('#jobTailLog').html(data.returnHTML);
                    //로그 출력하는 부분에 스크롤 맨아래쪽향하게 
                    var $logarea = $('.Job_logarea');
                    $logarea.scrollTop($logarea[0].scrollHeight);
                  },
                  error:function(err){
                    
                  }
              })
            }else{
              return false;
            }
          }else if(line>=30000){
            //3만개 이상이면
            alert("조회하는 라인수가 너무 많습니다.\n 로그를 다운로드 받아주세요 ")
            return false;
          }else if(line<10000){
            //만개 미만
            $.ajax({
                url:"/job/jobTailAdd",
                method:"get",
                data:{
                    "line":line,
                    "Job_Seq":jobSeq,
                    "setNum":setNum
                },
                success:function(data){
                  // //토탈라인수 초과할떄 안할떄 분기 처리
                  // if(data.lineTotal<line){
                  //   parseInt($('#lineNum').val(parseInt(data.lineTotal)));
                  // }else if(data.lineTotal>=line){
                  //   parseInt($('#lineNum').val(parseInt(line)));
                  // }
                  $('#jobSeq').val(jobSeq);
                  $('#jobTailLog').html(data.returnHTML);
                  //로그 출력하는 부분에 스크롤 맨아래쪽향하게 
                  var $logarea = $('.Job_logarea');
                  $logarea.scrollTop($logarea[0].scrollHeight);
                },
                error:function(err){
                  
                }
            })
          }
      }

      $(document).ready(function(){
        var dbclick=false;    
        $(document).on('click','.jobExeOneDbClick',function(event){
            var jobSeqIndex = $('.jobExeOneDbClick').index(this);
            var jobSeq = $('.Job_Seq').eq(jobSeqIndex).attr("data-value");

            //tr 색 바꾸기  활성된거
            if($('.jobExeOneDbClick').not(jobSeqIndex).css({'background-color':'rgb(255, 255, 255)'})){
                $('.jobExeOneDbClick').eq(jobSeqIndex).css({'background-color':'rgb(218, 221, 235)'});
            }else {
                $('.jobExeOneDbClick').not(jobSeqIndex).css({'background-color':'rgb(255, 255, 255)'});
            }
            setTimeout(function(){
                if(dbclick ==false){
                    console.log("1번클릭  jobseq: "+jobSeq);
                    tailAddFirst(10,jobSeq);
                }   
            },400)    
        }).on('dblclick','.jobExeOneDbClick',function(event){
            dbclick = true
            var jobSeqIndex = $('.jobExeOneDbClick').index(this);
            var jobSeq = $('.Job_Seq').eq(jobSeqIndex).attr("data-value");
            pageMove.jobpopup.jobAction('jobAction',jobSeq);
            setTimeout(function(){   
                dbclick = false
            },500)
        })
    })

    //처음 잡을 클릭해서 로그 조회하는것  
    function tailAddFirst(line,jobSeq){
        $.ajax({
            url:"/job/jobTailAdd",
            method:"get",
            data:{
                "line":line,
                "Job_Seq":jobSeq,
                "setNum":0
            },
            success:function(data){
                
                $('#jobSeq').val(jobSeq);
                $('#lineNum').val(line);
                $('#jobTailLog').html(data.returnHTML);
            },
            error:function(err){

            }
        })
    }
    </script>
</body>
</html>