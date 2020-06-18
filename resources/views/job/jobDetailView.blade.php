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
  @php
   echo var_dump($jobStatusCheck);   
  @endphp
  <div id="wrapper"  class="bodyBgImg">
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
          <h4 class="h3 my-4 font-weight-bold" style="color:white">잡 정보 상세</h4>
          <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-3 text-center align-self-center font-weight-bold">ID</div>
                  <input type="text" id="Job_UniqueName"  class="col-md-3 form-control form-control-sm align-self-center" placeholder="{{'job_'.$jobDetail[0]->job_worklargectg.'_'.$jobDetail[0]->job_workmediumctg.'_'.$jobDetail[0]->job_seq}}" readonly>
                  <div class="col-md-3 text-center align-self-center font-weight-bold">잡 명</div>
                <input type="text" id="Job_Name"  class="col-md-3 form-control form-control-sm align-self-center" value="{{$jobDetail[0]->job_name}}" readonly>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-3 text-center align-self-center font-weight-bold">설명</div>
                  <textarea type="text" id="Job_Sulmyung" class="col-md-9 form-control form-control-sm" readonly>{{$jobDetail[0]->job_sulmyung}}</textarea>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3 text-center align-self-center font-weight-bold">업무구분</div>
                    <div class="col-md-2 text-center align-self-center font-weight-bold" >대분류</div>
                    <input type="text" class="col-md-2 form-control form-control-sm" readonly value="{{$jobDetail[0]->job_worklargename}}"/>
                    <div class="col-md-2 text-center align-self-center font-weight-bold">중분류</div>
                    <input type="text" class="col-md-2 form-control form-control-sm" readonly value="{{$jobDetail[0]->job_workmediumname}}"/>
                  <!-- <div id="codeLargeView" class="outher-code align-self-center">
                  </div> -->
                </div>
                <hr>
                <div class="row">
                <div class="col-md-3 text-center align-self-center font-weight-bold">잡 상태</div>
                  <table class="table table-bordered m-0 text-center col-md-3">
                    <thead>
                      <th class="p-1">실행중</th>
                      <th class="p-1">예약</th>
                      <th class="p-1">오류</th>
                      <th class="p-1">종료</th>
                    </thead>
                    <tbody>
                      <td class="p-1">{{$jobStatusCheck['v_exec']}}</td>
                      <td class="p-1">{{$jobStatusCheck['v_yeyak']}}</td>
                      <td class="p-1">{{$jobStatusCheck['v_error']}}</td>
                      <td class="p-1">{{$jobStatusCheck['v_end']}}</td>
                    </tbody>
                  </table>
                  <div class="col-md-3 text-center align-self-center font-weight-bold">구성 프로세스 개수</div>
                  <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="{{$jobDetail[0]->gusungcount}}" readonly> 
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-6 text-center">
                    <div class="col-md-12 text-center align-self-center font-weight-bold ">배치 작업 평균 소요시간</div>
                    <div class="d-inline-block col-md-3 text-center align-self-center font-weight-bold ">일 / 시 / 분</div>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Job_YesangTime1" value="{{empty($jobTotalTime[0]->job_yesangtime) ? 0:intval($jobTotalTime[0]->job_yesangtime/1440)}}" readonly numberOnly>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Job_YesangTime2" value="{{empty($jobTotalTime[0]->job_yesangtime) ? 0:intval($jobTotalTime[0]->job_yesangtime%1440/60)}}" readonly numberOnly>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Job_YesangTime3" value="{{empty($jobTotalTime[0]->job_yesangtime) ? 0:intval($jobTotalTime[0]->job_yesangtime%60)}}" readonly numberOnly>
                  </div>
                  <div class="col-md-6 text-center">
                    <div class="col-md-12 text-center align-self-center font-weight-bold ">배치 작업 최대 소요시간</div>
                    <div class="d-inline-block col-md-3 text-center align-self-center font-weight-bold ">일 / 시 / 분</div>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Job_YesangMaxTime1" value="{{empty($jobTotalTime[0]->job_yesangmaxtime) ? 0:intval($jobTotalTime[0]->job_yesangmaxtime/1440)}}" readonly numberOnly>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Job_YesangMaxTime2" value="{{empty($jobTotalTime[0]->job_yesangmaxtime) ? 0:intval($jobTotalTime[0]->job_yesangmaxtime%1440/60)}}" readonly numberOnly>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Job_YesangMaxTime3" value="{{empty($jobTotalTime[0]->job_yesangmaxtime) ? 0:intval($jobTotalTime[0]->job_yesangmaxtime%60)}}" readonly numberOnly>
                  </div>
                </div>
                <hr>
                <div class="row justify-content-center">
                  <div class="limit-time-text col-md-auto">등록자</div>
                  <input id="P_RegId" type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto" value="{{$jobDetail[0]->job_regid}}" readonly>
                  <div class="limit-time-text col-md-auto">등록자IP</div>
                  <input id="P_RegIp" type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto" value="{{$jobDetail[0]->job_regip}}" readonly>
                  <div class="limit-time-text col-md-auto">등록일</div>
                  <input id="P_RegDate" type="text" class="form-control form-control-sm limit-time-input col-md-auto w-auto" value="{{$jobDetail[0]->job_regdate}}" readonly>    
                  <div class="limit-time-text col-md-auto">수정자</div>
                  <input type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto" value="{{empty($jobDetail[0]->job_updid) ? $jobDetail[0]->job_regid:$jobDetail[0]->job_updid}}" readonly>   
                  <div class="limit-time-text col-md-auto">수정자IP</div>
                  <input type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto"  value="{{empty($jobDetail[0]->job_updip) ?$jobDetail[0]->job_regip:$jobDetail[0]->job_updip}}" readonly>       
                  <div class="limit-time-text col-md-auto">수정일</div>
                  <input type="text" class="form-control form-control-sm limit-time-input col-md-auto w-auto" value="{{empty($jobDetail[0]->job_upddate) ? $jobDetail[0]->job_regdate:$jobDetail[0]->job_upddate}}" readonly> 
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12 font-weight-bold ">
                    잡 파라미터 타입
                  </div>
                  <hr>
                  {{-- 잡변수가 추가되는 부분 --}}
                    <div class="col-md-12" id="jobParams">
                      @if(isset($jobDetail[0]->job_params))
                        @php
                          $jobParamArr=explode("||",$jobDetail[0]->job_params);
                          $jobParamSulArr=explode("||",$jobDetail[0]->job_paramsulmyungs);
                          for ($i = 0; $i < count($jobParamArr); $i++) {
                          echo '<div class="d-inline-flex w-50 delYN mb-2">';
                          echo '<div class="col-md-3 small align-self-center text-center">잡 파라미터</div>';
                          if($jobParamArr[$i]=="paramNum"){
                            echo '<input type="text" name="Job_Params" class="col-md-2 form-control form-control-sm" placeholder="숫자" readonly/>';
                          }else if($jobParamArr[$i]=="paramStr"){
                            echo '<input type="text" name="Job_Params" class="col-md-2 form-control form-control-sm" placeholder="문자" readonly/>';
                          }
                          echo '<input type="text" name="Job_paramSulmyungs" class="col-md-6 form-control form-control-sm" value="'.$jobParamSulArr[$i].'" readonly> </div>' ;
                          }
                        @endphp
                      @endif
                  </div>
                </div>
                <hr>
              <div class="row justify-content-end">
                <div class="mt-3 mr-2 btn btn-danger" onclick="pageMove.job.list('jobListView')">취소</div>
                <div class="mt-3 mr-2 btn btn-primary" onclick="pageMove.job.update('jobUpdateView','{{$jobDetail[0]->job_seq}}','{{$jobDetail[0]->job_worklargectg}}','{{$jobDetail[0]->job_workmediumctg}}')">수정 </div>
              <div class="mt-3 mr-2 btn btn-success" onclick="job.jobGusung('{{$jobDetail[0]->job_seq}}')">구성</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <input type="hidden" id="Job_RegID" class="col-md-2 form-control form-control-sm align-self-center"  value="{{$jobDetail[0]->job_regid}}" readonly>
    {{--content 끝--}}
    <script>
      $("input:text[numberOnly]").on("keyup", function() {
        $(this).val($(this).val().replace(/[^0-9]/g,""));
      });    
    </script>
    </div>
  </div>
</body>
</html>

