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
              <h5 class="m-0 font-weight-bold text-primary">잡 정보 수정</h5>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">ID</div>
                  <input type="text" id="Job_UniqueName"  class="col-md-2 form-control form-control-sm align-self-center" placeholder="{{'job_'.$jobDetail[0]->Job_WorkLargeCtg.'_'.$jobDetail[0]->Job_WorkMediumCtg.'_'.$jobDetail[0]->Job_Seq}}" readonly>
                  <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">잡 명</div>
                <input type="text" id="Job_Name"  class="col-md-2 form-control form-control-sm align-self-center" value="{{$jobDetail[0]->Job_Name}}" >
                  <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">설명</div>
                <textarea type="text" id="Job_Sulmyung" class="col-md-4 form-control form-control-sm" >{{$jobDetail[0]->Job_Sulmyung}}</textarea>
                </div>
                <hr>
                <div class="row">
                  <div id="codeLargeView" class="outher-code">
                    <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">업무구분</div>
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary" >대분류</div>
                    <input type="text" class="col-md-2 form-control form-control-sm" readonly value="{{$jobDetail[0]->Job_WorkLargeName}}"/>
                    <input type="hidden" id="Job_WorkLargeCtg" value="{{$jobDetail[0]->Job_WorkLargeCtg}}"/>
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">중분류</div>
                    <input type="hidden" id="Job_WorkMediumCtg" value="{{$jobDetail[0]->Job_WorkMediumCtg}}"/>
                    <input type="text" class="col-md-2 form-control form-control-sm" readonly value="{{$jobDetail[0]->Job_WorkMediumName}}"/>
                  </div>
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">잡 상태</div>
                  <table class="table table-bordered m-0 w-auto text-center">
                    <thead>
                      <th class="p-1">실행중</th>
                      <th class="p-1">예약</th>
                      <th class="p-1">오류</th>
                      <th class="p-1">종료</th>
                    </thead>
                    <tbody>
                      <td class="p-1">{{$jobStatusCheck[0]->v_exec}}</td>
                      <td class="p-1">{{$jobStatusCheck[0]->v_yeyak}}</td>
                      <td class="p-1">{{$jobStatusCheck[0]->v_error}}</td>
                      <td class="p-1">{{$jobStatusCheck[0]->v_end}}</td>
                    </tbody>
                  </table>
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">구성 프로세스 개수</div>
                  <input type="text" class="col-md-1 form-control form-control-sm align-self-center" placeholder="{{$jobDetail[0]->gusungCount}}" readonly> 
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-6 text-center">
                    <div class="col-md-12 text-center align-self-center font-weight-bold text-primary">예상시간</div>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Job_YesangTime1" value="{{empty($jobTotalTime[0]->Job_YesangTime) ? 0:intval($jobTotalTime[0]->Job_YesangTime/1440)}}" readonly numberOnly>
                    <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">일</div>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Job_YesangTime2" value="{{empty($jobTotalTime[0]->Job_YesangTime) ? 0:intval($jobTotalTime[0]->Job_YesangTime%1440/60)}}" readonly numberOnly>
                    <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">시</div>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Job_YesangTime3" value="{{empty($jobTotalTime[0]->Job_YesangTime) ? 0:intval($jobTotalTime[0]->Job_YesangTime%60)}}" readonly numberOnly>
                    <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">분</div>
                  </div>
                  <div class="col-md-6 text-center">
                    <div class="col-md-12 text-center align-self-center font-weight-bold text-primary">최대 예상시간</div>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Job_YesangMaxTime1" value="{{empty($jobTotalTime[0]->Job_YesangMaxTime) ? 0:intval($jobTotalTime[0]->Job_YesangMaxTime/1440)}}" readonly numberOnly>
                    <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">일</div>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Job_YesangMaxTime2" value="{{empty($jobTotalTime[0]->Job_YesangMaxTime) ? 0:intval($jobTotalTime[0]->Job_YesangMaxTime%1440/60)}}" readonly numberOnly>
                    <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">시</div>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Job_YesangMaxTime3" value="{{empty($jobTotalTime[0]->Job_YesangMaxTime) ? 0:intval($jobTotalTime[0]->Job_YesangMaxTime%60)}}" readonly numberOnly>
                    <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">분</div>
                  </div>
                </div>
                <hr>
                <div class="row justify-content-center">
                  <div class="limit-time-text col-md-auto">등록자</div>
                  <input id="P_RegId" type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto" value="{{$jobDetail[0]->Job_RegId}}" readonly>
                  <div class="limit-time-text col-md-auto">등록자IP</div>
                  <input id="P_RegIp" type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto" value="{{long2ip($jobDetail[0]->Job_RegIP)}}" readonly>
                  <div class="limit-time-text col-md-auto">등록일</div>
                  <input id="P_RegDate" type="text" class="form-control form-control-sm limit-time-input col-md-auto w-auto" value="{{$jobDetail[0]->Job_RegDate}}" readonly>    
                  <div class="limit-time-text col-md-auto">수정자</div>
                  <input type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto" value="{{empty($jobDetail[0]->Job_UpdId) ? $jobDetail[0]->Job_RegId:$jobDetail[0]->Job_UpdId}}" readonly>   
                  <div class="limit-time-text col-md-auto">수정자IP</div>
                  <input type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto"  value="{{empty($jobDetail[0]->Job_UpdIP) ?long2ip( $jobDetail[0]->Job_RegIP):long2ip($jobDetail[0]->Job_UpdIP)}}" readonly>       
                  <div class="limit-time-text col-md-auto">수정일</div>
                  <input type="text" class="form-control form-control-sm limit-time-input col-md-auto w-auto" value="{{empty($jobDetail[0]->Job_UpdDate) ? $jobDetail[0]->Job_RegDate:$jobDetail[0]->Job_UpdDate}}" readonly> 
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12 font-weight-bold text-primary">
                    잡 파라미터 타입
                  </div>
                  <hr>
                  {{-- 잡변수가 추가되는 부분 --}}
                    <div class="col-md-12" id="jobParams">
                      @if(isset($jobDetail[0]->Job_Params))
                        @php
                          $jobParamArr=explode("||",$jobDetail[0]->Job_Params);
                          $jobParamSulArr=explode("||",$jobDetail[0]->Job_ParamSulmyungs);
                          for ($i = 0; $i < count($jobParamArr); $i++) {
                          echo '<div class="d-inline-flex w-50 delYN mb-2" style="float: left">';
                          echo '<div class="col-md-3 small align-self-center text-center">잡 파라미터</div>';
                          echo '<select name="Job_Params" class="col-md-2 form-control form-control-sm" >';
                          if($jobParamArr[$i]=="paramNum"){
                            echo '<option value="'.$jobParamArr[$i].'" selected>숫자</option><option value="paramStr" >문자</option></select>';
                          }else if($jobParamArr[$i]=="paramStr"){
                            echo '<option value="paramNum" >숫자</option><option value="'.$jobParamArr[$i].'" selected>문자</option></select>';
                          }
                          echo '<input type="text" name="Job_paramSulmyungs" class="col-md-6 form-control form-control-sm" value="'.$jobParamSulArr[$i].'">' ;
                          echo '<button type="button" class="col-md-auto delParam btn-danger form-control-sm text-center">삭제</button>';
                          echo '</div>';
                          }
                        @endphp
                      @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                  {{-- 잡변수가 추가되는 부분 --}}
                  <div class="col-md-12" id="jobParams"></div>
                  <div class="col-md-12 text-center">
                    <input type="button" class="mt-3 btn btn-info " value="잡 변수 추가 +"  onclick="job.addDivParam()"/>
                  </div>
                </div>
                <hr>
              <div class="row justify-content-end">
                <div class="mt-3 mr-2 btn btn-primary" onclick="job.update('{{$jobDetail[0]->Job_Seq}}')">수정 </div>
                <div class="mt-3 mr-2 btn btn-danger" onclick="history.back()">취소</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @include('common.footer')
    {{--content 끝--}}
    <script>
      $("input:text[numberOnly]").on("keyup", function() {
        $(this).val($(this).val().replace(/[^0-9]/g,""));
      });    
      const popup = {
        jobGusung:function(Job_Seq){
          window.open('/popup/jobGusung?Job_Seq='+Job_Seq, '잡 구성', 'top=10, left=10, width=1400, height=720, status=no, location=no, directories=no, status=no, menubar=no, toolbar=no, scrollbars=yes, resizable=no');
        }
      }
    </script>
    </div>
  </div>
</body>
</html>

