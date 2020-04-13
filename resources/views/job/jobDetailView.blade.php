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
              <h6 class="m-0 font-weight-bold text-primary" style="text-align: center;">잡 정보 상세</h6>
            </div>
            <div class="card-body">
              <form id="jobRegisterForm">
                <div class="row">
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">잡 명(쉘 명) </div>
                  <input type="text" id="Job_UniqueName"  class="col-md-2 form-control form-control-sm align-self-center" placeholder="{{'job_'.$jobDetail[0]->Job_Seq.'_'.$jobDetail[0]->Job_WorkLargeCtg.'_'.$jobDetail[0]->Job_WorkMediumCtg}}" readonly>
                  <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">잡 명</div>
                <input type="text" id="Job_Name"  class="col-md-2 form-control form-control-sm align-self-center" value="{{$jobDetail[0]->Job_Name}}" readonly>
                  <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">설명</div>
                <textarea type="text" id="Job_Sulmyung" class="col-md-4 form-control form-control-sm"style="resize: none;" readonly>{{$jobDetail[0]->Job_Sulmyung}}</textarea>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">잡 등록자</div>
                  <input type="text" id="Job_RegID" class="col-md-2 form-control form-control-sm align-self-center"  value="{{$jobDetail[0]->Job_RegId}}" readonly>
                  <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">업무구분</div>
                  <div class="col-md-1 text-center align-self-center font-weight-bold text-primary" name="Job_WorkLargeCtg">대분류</div>
                  <select class="col-md-2 form-control form-control-sm">
                    <option>
                      인카금융서비스
                    </option>
                  </select>
                  <div class="col-md-1 text-center align-self-center font-weight-bold text-primary" name="Job_WorkMediumCtg">중분류</div>
                  <select class="col-md-2 form-control form-control-sm">
                    <option>
                      정보기술연구소
                    </option>
                    <option>
                      교육
                    </option>
                    <option>
                      제도관리
                    </option>
                  </select>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">잡 상태</div>
                  <input type="text" class="col-md-3 form-control form-control-sm align-self-center" placeholder="-" readonly>
                  <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">구성 프로세스</div>
                  <input type="text" class="col-md-3 form-control form-control-sm align-self-center" placeholder="-" readonly>              
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12 text-center align-self-center font-weight-bold text-primary">잡 예상 시간</div>
                  <div class="col-md-1 font-weight-bold text-primary" style="text-align: right">일</div>
                <input type="text" class="col-md-3 form-control form-control-sm align-self-center" id="Job_YesangTime1" value="{{intval($jobDetail[0]->Job_YesangTime/1440)}}" readonly numberOnly>
                  <div class="col-md-1 font-weight-bold text-primary" style="text-align: right">시간</div>
                  <input type="text" class="col-md-3 form-control form-control-sm align-self-center" id="Job_YesangTime2" value="{{intval($jobDetail[0]->Job_YesangTime%24/60)}}" readonly numberOnly>
                  <div class="col-md-1 font-weight-bold text-primary" style="text-align: right">분</div>
                  <input type="text" class="col-md-3 form-control form-control-sm align-self-center" id="Job_YesangTime3" value="{{intval($jobDetail[0]->Job_YesangTime%60)}}" readonly numberOnly>
                  
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12 text-center align-self-center font-weight-bold text-primary">잡 최대 예상 시간</div>
                  <div class="col-md-1 font-weight-bold text-primary" style="text-align: right">일</div>
                  <input type="text" class="col-md-3 form-control form-control-sm align-self-center" id="Job_YesangMaxTime1" value="{{intval($jobDetail[0]->Job_YesangMaxTime/1440)}}" readonly numberOnly>
                  <div class="col-md-1 font-weight-bold text-primary" style="text-align: right">시간</div>
                  <input type="text" class="col-md-3 form-control form-control-sm align-self-center" id="Job_YesangMaxTime2" value="{{intval($jobDetail[0]->Job_YesangMaxTime%24/60)}}" readonly numberOnly>
                  <div class="col-md-1 font-weight-bold text-primary" style="text-align: right">분</div>
                  <input type="text" class="col-md-3 form-control form-control-sm align-self-center" id="Job_YesangMaxTime3" value="{{intval($jobDetail[0]->Job_YesangMaxTime%60)}}" readonly numberOnly>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">등록일</div>
                  <input type="text" class="col-md-3 form-control form-control-sm align-self-center" placeholder="" readonly>
                  <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">최종 수정일</div>
                  <input type="text" class="col-md-3 form-control form-control-sm align-self-center" placeholder="" readonly>              
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12 font-weight-bold text-primary">
                    잡 파라미터 타입
                  </div>
                  <hr>
                  {{-- 잡변수가 추가되는 부분 --}}
                    <div class="col-md-12" id="jobParams">
                      <div class="row delYN" style="padding-bottom: 10px;">
                        @php
                          $jobParamArr=explode("||",$jobDetail[0]->Job_Params);
                          $jobParamSulArr=explode("||",$jobDetail[0]->Job_ParamSulmyungs);
                          for ($i = 0; $i < count($jobParamArr); $i++) {
                           echo '<div class="col-md-3 small align-self-center text-center">잡 파라미터</div>';
                           echo '<select name="Job_Params" class="col-md-4  form-control form-control-sm" >';
                           if($jobParamArr[$i]=="paramDate"){
                            echo '<option value="'.$jobParamArr[$i].'" selected>날짜</option></select>';
                           }else if($jobParamArr[$i]=="paramNum"){
                            echo '<option value="'.$jobParamArr[$i].'" selected>숫자</option></select>';
                           }else if($jobParamArr[$i]=="paramStr"){
                            echo '<option value="'.$jobParamArr[$i].'" selected>문자</option></select>';
                           }
                           echo '<input type="text" name="Job_paramSulmyungs" class="col-md-4  form-control form-control-sm" value="'.$jobParamSulArr[$i].'" readonly>';
                          }
                        @endphp
                      </div>
                  </div>
                </div>
                <hr>
              </form>
              <div id="jobBtnRender">
                <div style="cursor: pointer" class="mt-3 btn btn-danger float-right" onclick="history.back()">취소</div>
                @if($jobDetail[0]->Job_RegId=="1611698")
                <div style="cursor: pointer" class="mt-3 btn btn-primary float-right" onclick="">수정 </div>
                <div style="cursor: pointer" class="mt-3 btn btn-success float-right" onclick="job.jobProcessConf()">구성</div>
                @endIf
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
</script>
    </div>
  </div>
</body>
</html>





