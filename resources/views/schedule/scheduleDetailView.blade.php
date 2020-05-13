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
              <h5 class="m-0 font-weight-bold text-primary">스케줄 정보 상세</h5>
            </div>
              <input type="hidden" id="Job_RegID" class="col-md-2 form-control form-control-sm align-self-center"  value="{{$jobDetail[0]->Job_RegId}}" readonly>
            <div class="card-body">
                <div class="row">
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">잡 Id</div>
                    <input id="jobSc_id" type="text" class="col-md-2 form-control form-control-sm align-self-center"  value="{{$jobDetail[0]->Job_Seq}}" readonly>
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary mt-2">잡 명</div>
                    <input id = "jobSc_name" type="text" class="col-md-5 form-control form-control-sm mt-2" value="{{$jobDetail[0]->Job_Name}}" readonly>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary mt-2">스케줄 id</div>
                    <input id="Sc_Seq" type="text" class="col-md-3 form-control form-control-sm mt-2" value="{{$scheduleDetail[0]->Sc_Seq}}" readonly>
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary mt-2">스케줄 설명</div>
                    <input id="Sc_Sulmyung" type="text" class="col-md-3 form-control form-control-sm mt-2" value="{{$scheduleDetail[0]->Sc_Sulmyung}}" readonly>
                  </div>
                <hr>
                <div class="row">
                  <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">실행 주기 설명</div>
                  <input type="text" class="col-md-4 form-control form-control-sm align-self-center" value="{{$scheduleDetail[0]->Sc_CronSulmyung}}" readonly> 
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">시작 시간</div>
                  <input type="text" class="col-md-3 form-control form-control-sm align-self-center" value="{{$scheduleDetail[0]->Sc_CronTime}}" readonly>
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">종료 시간</div>
                  <input type="text" class="col-md-3 form-control form-control-sm align-self-center" value="{{$scheduleDetail[0]->Sc_CronEndTime}}" readonly>  
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">잡 상태</div>
                  <input type="text" class="col-md-2 form-control form-control-sm align-self-center" value="{{$scheduleDetail[0]->Sc_StatusName}}" readonly>
                  <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">구성 프로세스 개수</div>
                  <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="{{$jobDetail[0]->gusungCount}}" readonly> 
                </div>
                <hr>
                <div class="row">
                  <div class="limit-time-text col-md-2">등록자</div>
                  <input id="P_RegId" type="text" class="form-control form-control-sm limit-time-input col-md-4" value="{{$scheduleDetail[0]->Sc_RegId}}" readonly>
                  <div class="limit-time-text col-md-2">수정자</div>
                  <input type="text" class="form-control form-control-sm limit-time-input col-md-4" value="{{empty($jobDetail[0]->Job_UpdId) ? $jobDetail[0]->Job_RegId:$jobDetail[0]->Job_UpdId}}" readonly>   
                </div>
                <br>
                <div class="row">
                  <div class="limit-time-text col-md-2">등록자IP</div>
                  <input id="P_RegIp" type="text" class="form-control form-control-sm limit-time-input col-md-4" value="{{long2ip($scheduleDetail[0]->Sc_RegIP)}}" readonly>
                  <div class="limit-time-text col-md-2">수정자IP</div>
                  <input type="text" class="form-control form-control-sm limit-time-input col-md-4"  value="{{empty($jobDetail[0]->Job_UpdIP) ?long2ip( $jobDetail[0]->Job_RegIP):long2ip($jobDetail[0]->Job_UpdIP)}}" readonly>       
                </div>
                <br>
                <div class="row">
                  <div class="limit-time-text col-md-2">등록일</div>
                  <input id="P_RegDate" type="text" class="form-control form-control-sm limit-time-input col-md-4" value="{{$scheduleDetail[0]->Sc_RegDate}}" readonly>    
                  <div class="limit-time-text col-md-2">수정일</div>
                  <input type="text" class="form-control form-control-sm limit-time-input col-md-4" value="{{empty($jobDetail[0]->Job_UpdDate) ? $jobDetail[0]->Job_RegDate:$jobDetail[0]->Job_UpdDate}}" readonly> 
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12 font-weight-bold text-primary">
                    잡 파라미터
                  </div>
                  <hr>
                 
                    <div class="col-md-12" id="jobParams">
                      @if(isset($jobDetail[0]->Job_Params))
                        @php
                          $jobParamArr=explode("||",$jobDetail[0]->Job_Params);
                          $jobParamSulArr=explode("||",$scheduleDetail[0]->Sc_Param);
                          for ($i = 0; $i < count($jobParamArr); $i++) {
                          echo '<div class="d-inline-flex w-50 delYN mb-2">';
                          echo '<div class="col-md-3 small align-self-center text-center">잡 파라미터</div>';
                          echo '<select name="Job_Params" class="col-md-2 form-control form-control-sm" readonly>';
                          if($jobParamArr[$i]=="paramDate"){
                            echo '<option value="'.$jobParamArr[$i].'" selected>날짜</option></select>';
                          }else if($jobParamArr[$i]=="paramNum"){
                            echo '<option value="'.$jobParamArr[$i].'" selected>숫자</option></select>';
                          }else if($jobParamArr[$i]=="paramStr"){
                            echo '<option value="'.$jobParamArr[$i].'" selected>문자</option></select>';
                          }
                          echo '<input type="text" name="Job_paramSulmyungs" class="col-md-6 form-control form-control-sm" value="'.$jobParamSulArr[$i].'" readonly> </div>' ;
                          }
                        @endphp
                      @endif
                  </div>
                </div>
                <hr>
                <fieldset class="cistp-fieldset">
                  <legend>구성 프로그램</legend>
                  <div class="card-body">
                  {{-- 타이틀 --}}
                  <div class="row text-center">
                    <div class="right-line col-md-1 p-2 bg-primary text-white font-weight-bold rounded-0">순서
                    </div>
                    <div class="right-line col-md-2 p-2 bg-primary text-white font-weight-bold rounded-0">
                      경로</div>
                    <div class="right-line col-md-1 p-2 bg-primary text-white font-weight-bold rounded-0">
                      프로그램</div>
                    <div class="right-line col-md-2 p-2 bg-primary text-white font-weight-bold rounded-0">
                      프로그램 명</div>
                    <div class="right-line col-md-5 p-2 bg-primary text-white font-weight-bold rounded-0">
                      파라미터</div>
                      <div class="right-line col-md-1 p-2 bg-primary text-white font-weight-bold rounded-0">
                      재작업</div>
                  </div>
                  <div id="gusungList" class="row px-0 gusungList">
                      @if(isset($jobGusungContents))
                        @foreach($jobGusungContents as $data)
                        <ul class="px-0 mb-0 w-100 d-inline-flex gusungData">
                          <li class="list-group-item d-inline-flex col-md-1 p-2 rounded-0 text-center h-100 align-items-center justify-content-center">{{$data->JobGusung_Order}}</li>
                          <li class="list-group-item d-inline-flex col-md-2 p-2 rounded-0 h-100 align-items-center">{{$data->P_FilePath}}</li>
                          <li class="list-group-item d-inline-flex col-md-1 p-2 rounded-0 h-100 align-items-center">{{$data->P_File}}</li>
                          <li class="list-group-item d-inline-flex col-md-2 p-2 rounded-0 h-100 align-items-center">{{$data->P_Name}}</li>
                          <li class="list-group-item col-md-5 p-2 rounded-0">
                            <label class="m-0 w-100">
                              @if(isset($data->P_Params))
                                  @php
                                  $proParamArr=explode("||",$data->P_Params);
                                  $proParamSulArr=explode("||",$data->P_ParamSulmyungs);
                                  for ($i = 0; $i < count($proParamArr); $i++) {
                                      echo '<div class="d-inline-flex w-50 delYN mb-2">';
                                      // echo '<div class="col-md-3 small align-self-center text-center">프로그램 파라미터</div>';
                                      echo '<select name="pro_Params" class="col-md-3 form-control form-control-sm" readonly>';
                                      if($proParamArr[$i]=="paramDate"){
                                          echo '<option value="'.$proParamArr[$i].'" selected>날짜</option></select>';
                                          }else if($proParamArr[$i]=="paramNum"){
                                          echo '<option value="'.$proParamArr[$i].'" selected>숫자</option></select>';
                                          }else if($proParamArr[$i]=="paramStr"){
                                          echo '<option value="'.$proParamArr[$i].'" selected>문자</option></select>';
                                          }
                                          echo '<input type="text" name="Sc_Param" class="col-md-6 form-control form-control-sm" value="'.$proParamSulArr[$i].'" readonly></div>';
                                      }
                                      @endphp
                              @endif
                            </label>
                          </li>
                          <li class="list-group-item d-inline-flex col-md-1 p-2 rounded-0 text-center h-100 align-items-center justify-content-center">
                            @if(($data->P_ReworkYN)==1)
                                가능
                            @else
                                불가
                            @endif
                          </li>
                        </ul>
                        @endforeach
                      @endIf
                    </div>
                  </div>
                </fieldset>
                <hr>
              <div class="row justify-content-end">
                <div class="mt-3 mr-2 btn btn-danger" onclick="pageMove.job.list('jobExecuteView')">취소</div>
                {{-- <div class="mt-3 mr-2 btn btn-primary" onclick="pageMove.job.update('jobUpdateView','{{$jobDetail[0]->Job_Seq}}','{{$jobDetail[0]->Job_WorkLargeCtg}}','{{$jobDetail[0]->Job_WorkMediumCtg}}')">수정 </div>
              <div class="mt-3 mr-2 btn btn-success" onclick="popup.jobGusung('{{$jobDetail[0]->Job_Seq}}')">구성</div> --}}
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

