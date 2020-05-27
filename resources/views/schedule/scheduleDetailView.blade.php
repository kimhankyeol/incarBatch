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
              <input type="hidden" id="Sc_Seq" class="col-md-2 form-control form-control-sm align-self-center"  value="{{$scheduleDetail[0]->Sc_Seq}}" readonly>
              <input type="hidden" id="Sc_Status" class="col-md-2 form-control form-control-sm align-self-center"  value="{{$scheduleDetail[0]->Sc_Status}}" readonly>
            <div class="card-body">
                <div class="row">
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">잡 Id</div>
                    <input id="jobSc_id" type="text" class="col-md-2 form-control form-control-sm align-self-center"  value="{{'job_'.$jobDetail[0]->Job_WorkLargeCtg.'_'.$jobDetail[0]->Job_WorkMediumCtg.'_'.$jobDetail[0]->Job_Seq}}" readonly>
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary mt-2">잡 명</div>
                    <input id = "jobSc_name" type="text" class="col-md-5 form-control form-control-sm mt-2" value="{{$jobDetail[0]->Job_Name}}" readonly>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary mt-2">스케줄 Id</div>
                    <input id="Sc_Seq" type="text" class="col-md-2 form-control form-control-sm mt-2" value="{{'job_'.$jobDetail[0]->Job_WorkLargeCtg.'_'.$jobDetail[0]->Job_WorkMediumCtg.'_'.$jobDetail[0]->Job_Seq.'_'.$scheduleDetail[0]->Sc_Seq.'.sh'}}" readonly>
                    <div class="col-md-2 text-center align-self-center font-weight-bold text-primary mt-2">스케줄 설명</div>
                    <textarea id="Sc_Sulmyung"  class="col-md-6 form-control form-control-sm mt-2" placeholder="스케줄 설명" readonly>{{$scheduleDetail[0]->Sc_Sulmyung}}</textarea>
                    {{-- <input id="Sc_Sulmyung" type="text" class="col-md-3 form-control form-control-sm mt-2" value="{{$scheduleDetail[0]->Sc_Sulmyung}}" readonly> --}}
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
                  <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">스케줄 상태</div>
                  <input type="text" class="col-md-2 form-control form-control-sm align-self-center" value="{{$scheduleDetail[0]->Sc_StatusName}}" readonly>
                  @if(isset($jobGusungContents))
                    <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">구성 프로세스 개수</div>
                    <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="{{isset($jobGusungContents) ? count($jobGusungContents):0}}" readonly>
                  @endIf 
                </div>
                <hr>
                <div class="row justify-content-center">
                  <div class="limit-time-text col-md-auto">등록자</div>
                  <input id="P_RegId" type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto" value="{{$scheduleDetail[0]->Sc_RegId}}" readonly>
                  <div class="limit-time-text col-md-auto">등록자IP</div>
                  <input id="P_RegIp" type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto" value="{{$scheduleDetail[0]->Sc_RegIP}}" readonly>
                  <div class="limit-time-text col-md-auto">등록일</div>
                  <input id="P_RegDate" type="text" class="form-control form-control-sm limit-time-input col-md-auto w-auto" value="{{$scheduleDetail[0]->Sc_RegDate}}" readonly>    
                  <div class="limit-time-text col-md-auto">수정자</div>
                  <input type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto" value="{{empty($scheduleDetail[0]->Sc_UpdId) ? $scheduleDetail[0]->Sc_RegId:$scheduleDetail[0]->Sc_UpdId}}" readonly>   
                  <div class="limit-time-text col-md-auto">수정자IP</div>
                  <input type="text" class="form-control form-control-sm limit-time-input col-md-1 w-auto"  value="{{empty($scheduleDetail[0]->Sc_UpdIP) ? $scheduleDetail[0]->Sc_RegIP:$scheduleDetail[0]->Sc_UpdIP}}" readonly>       
                  <div class="limit-time-text col-md-auto">수정일</div>
                  <input type="text" class="form-control form-control-sm limit-time-input col-md-auto w-auto" value="{{empty($scheduleDetail[0]->Sc_UpdDate) ? $scheduleDetail[0]->Sc_RegDate:$scheduleDetail[0]->Sc_UpdDate}}" readonly> 
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
                          if($jobParamArr[$i]=="paramDate"){
                            echo '<input type="text" name="Job_Params" class="col-md-2 form-control form-control-sm" placeholder="날짜" readonly/>';
                          }else if($jobParamArr[$i]=="paramNum"){
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
                <fieldset class="cistp-fieldset">
                  <legend>구성 프로그램</legend>
                      <div class="table-list">
                        <table id="datatable" class="table table-bordered" cellspacing="0">
                          <colgroup>
                            <col width="3%" />
                            <col width="7%" />
                            <col width="10%" />
                            <col width="10%" />
                            <col width="40%" />
                            <col width="10%" />
                            <col width="20%" />
                          </colgroup>
                            <thead>
                              <tr>
                                <th>순서</th>
                                <th>경로</th>
                                <th>프로그램</th>
                                <th>프로그램 명</th>
                                <th>파라미터</th>
                                <th>재작업</th>
                                <th>로그파일</th>
                              </tr>
                            </thead>
                            <tbody>
                            @if(isset($jobGusungContents))
                                @foreach($jobGusungContents as $index=> $data)
                                  <tr style="text-align: center">
                                      <td>{{$index+1}}</td>
                                      <td>{{$data->P_FilePath}}</td>
                                      <td>{{$data->P_File}}</td>
                                      <td>{{$data->P_Name}}</td>
                                      <td>
                                      @if(isset($data->P_Params))
                                          @php
                                          $jobParamSulArr=explode("||",$scheduleDetail[0]->Sc_Param);
                                          $Job_Params=explode("||",$data->Job_Params);
                                          $JobGusung_ParamPos=explode("||",$data->JobGusung_ParamPos);
                                          for ($i = 0; $i < count($JobGusung_ParamPos); $i++) {
                                              echo '<div class="d-inline-flex w-50 delYN mb-2">';
                                              if($Job_Params[$i]=="paramNum"){
                                                echo ($i+1).")   ";
                                                echo '<input type="text" name="pro_Params" class="col-md-3 form-control form-control-sm" placeholder="숫자" readonly/>';
                                              }else if($Job_Params[$i]=="paramStr"){
                                                echo ($i+1).")   ";
                                                echo '<input type="text" name="pro_Params" class="col-md-3 form-control form-control-sm" placeholder="문자" readonly/>';
                                              }
                                                echo '<input type="text" name="Sc_Param" class="col-md-6 form-control form-control-sm" value="'.$jobParamSulArr[$JobGusung_ParamPos[$i]].'" readonly></div>';
                                              }
                                              @endphp
                                      @endif
                                      </td>
                                      <td>
                                        @if(($data->P_ReworkYN)==1)
                                        <label class="m-0 font-weight-bold text-primary">가능</label>
                                        @else
                                          <label class="m-0  font-weight-bold text-danger">불가능</label>
                                        @endif
                                      </td>
                                      <td>
                                       {{$data->Sc_LogFile}}
                                      </td>
                                  </tr>
                                  @endforeach
                              @endIf
                            </tbody>
                        </table>
                    </div>
                </fieldset>
                <hr>
              <div class="row justify-content-end">
                <div class="mt-3 mr-2 btn btn-secondary" onclick="job.scheduleDump()">삭제</div>
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

