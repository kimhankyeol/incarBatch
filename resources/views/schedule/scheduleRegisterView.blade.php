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
            <div class="container-fluid">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">스케줄 등록</h5>
                        <input id="P_RegIp" type="hidden" value="{{$_SERVER["REMOTE_ADDR"]}}"/>
                        <input id="P_RegId" type="hidden" value="이수연"/>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">잡 Id</div>
                            <input id="jobSc_id" type="text" class="col-md-2 form-control form-control-sm align-self-center" readonly>
                            <div class="input-group-append">
                                <div class="btn btn-primary" onclick="pageMove.jobpopup.list('jobSearchView')">
                                <i class="fas fa-search fa-sm"></i>
                                </div>
                            </div>
                            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary mt-2">잡 명</div>
                            <input id = "jobSc_name" type="text" class="col-md-5 form-control form-control-sm mt-2" readonly>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary mt-2">스케줄 설명</div>
                            <input id="Sc_Sulmyung" type="text" class="col-md-8 form-control form-control-sm mt-2" placeholder="스케줄 설명">
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <fieldset class="cistp-fieldset">
                                <legend>실행주기</legend>
                                <div class="d-inline-table  col-md-2 right-line">
                                    <select id="jugiChange" class="form-control form-control-sm w-100" onchange="handler()">
                                        <option value="1">한번</option>
                                        <option value="2">매일</option>
                                        <option value="3">매주</option>
                                        <option value="4">매월</option>
                                        <option value="5">매년</option>
                                    </select>
                                </div>
                                    <div class="d-inline-table col-md-8">
                                    <div id="startTime">
                                        <div class="d-inline-flex w-100  align-items-center form-control-sm">
                                            <span class="font-weight-bold text-primary mx-auto ">시작시간 : </span>
                                            <input id="startdate" type="date" class="form-control col-md-4" value="{{date("Y-m-d")}}">
                                            <input id="starttime" type="time" class="form-control col-md-4" value="{{date("H:i")}}">
                                        </div>
                                    </div>
                                    <div class="d-inline-flex w-100  align-items-center">
                                    </div>
                                    {{-- 분기 처리 --}}
                                    {{-- 매일 --}}
                                    <div id="dayShow">
                                        <div class="d-inline-flex w-100  align-items-center" >
                                            <div class="d-inline-flex w-100  align-items-center form-control-sm">
                                                <span class="font-weight-bold text-primary mx-auto">매 : </span>
                                                <input id="Day" type="text" class="form-control col-md-4" numberOnly>
                                                <span class="col-md-4">일마다</span>
                                            </div>
                                        </div>
                                        <div class="d-inline-flex w-100  align-items-center">
                                        </div>
                                    </div>
                                    {{-- 매주 --}}
                                    <div id="weekShow">
                                        <div class="d-inline-flex w-100  align-items-center">
                                            <div class="d-inline-flex w-100  align-items-center form-control-sm">
                                                <span class="font-weight-bold text-primary mx-auto">주마다 다음 요일에: </span>
                                                <label class="mr-3">
                                                    <input name="yoil" checked="checked" type="checkbox" class="mr-1" value="0"> 일요일
                                                </label>
                                                <label class="mr-3">
                                                    <input name="yoil" checked="checked" type="checkbox" class="mr-1" value="1"> 월요일
                                                </label>
                                                <label class="mr-3">
                                                    <input name="yoil" checked="checked" type="checkbox" class="mr-1" value="2"> 화요일
                                                </label>
                                                <label class="mr-3">
                                                    <input name="yoil" checked="checked" type="checkbox" class="mr-1" value="3"> 수요일
                                                </label>
                                                <label class="mr-3">
                                                    <input name="yoil" checked="checked" type="checkbox" class="mr-1" value="4"> 목요일
                                                </label>
                                                <label class="mr-3">
                                                    <input name="yoil" checked="checked" type="checkbox" class="mr-1" value="5"> 금요일
                                                </label>
                                                <label class="mr-3">
                                                    <input name="yoil" checked="checked" type="checkbox" class="mr-1" value="6"> 토요일
                                                </label>
                                            </div>
                                          
                                        </div>
                                    </div>
                                     {{-- 매월 --}}
                                    <div id="monthShow">
                                        <div class="d-inline-flex w-100  align-items-center" id="monthShow">
                                            <div class="d-inline-flex w-100  align-items-center form-control-sm">
                                                <span class="font-weight-bold text-primary mx-auto">매월: </span>
                                                <select class="col-md-5 form-control form-control-sm ml-3">
                                                    @php
                                                        for($i=1;$i<=31;$i++){
                                                            echo '<option>'.$i.'</option>';
                                                        }
                                                    @endphp
                                                </select>
                                                <span>일</span>
                                            </div>
                                        </div>
                                        <div class="d-inline-flex w-100  align-items-center">
                                        </div>
                                    </div>
                                    {{-- 매년 --}}
                                    <div id="yearShow">
                                        <div class="d-inline-flex w-100  align-items-center" >
                                            <div class="d-inline-flex w-100  align-items-center form-control-sm">
                                                <span class="font-weight-bold text-primary mx-auto">매년: </span>
                                                <select  id="monthsel" class="col-md-5 form-control form-control-sm ml-3" onchange="dayChange()">
                                                    @php
                                                    for($i=1;$i<=12;$i++){
                                                        if($i==1){
                                                            echo '<option selected>'.$i.'</option>';
                                                        }else{
                                                            echo '<option>'.$i.'</option>';
                                                        }
                                                    }
                                                    @endphp
                                                </select>
                                                <select id ="daysel" class="col-md-5 form-control form-control-sm ml-3">
                                                </select>
                                                <span>월</span>
                                            </div>
                                        </div>
                                        <div class="d-inline-flex w-100  align-items-center">
                                        </div>
                                    </div>
                                    <div id="endTime">
                                        <div class="d-inline-flex w-100  align-items-center form-control-sm" >
                                            <span class="font-weight-bold text-primary mx-auto">종료시간 : </span>
                                            <input id="enddate" type="date" class="form-control col-md-4" value="2037-12-31">
                                            <input id="endtime" type="time" class="form-control col-md-4" value="00:00">
                                        </div>
                                        <div class="d-inline-flex w-100  align-items-center">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="card-body" id="jobparams1">
                                    @include('schedule.scheduleExecParam')
                                </div>
                                <hr>
                                <div class="row justify-content-end">
                                    <input type="button" class="mt-3 mr-2 btn btn-primary" value="등록" onclick="job.scRegister()" />
                                    <input type="button" class="mt-3 mr-2 btn btn-danger" value="취소" onclick="history.back()"/>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                @include('common.footer')
                {{--content 끝--}}
            </div>
        </div>
        <script type="text/javascript">
    function handler(){
        $('#startTime').show();
        $('#dayShow').hide();
        $('#weekShow').hide();
        $('#monthShow').hide();
        $('#yearShow').hide();
        $('#endTime').hide();
       var jugi = $('#jugiChange option:selected').val();
        if(jugi==1){
            $('#startTime').show();
            $('#dayShow').hide();
            $('#weekShow').hide();
            $('#monthShow').hide();
            $('#yearShow').hide();
            $('#endTime').hide();
        }else if(jugi==2){
            $('#startTime').show();
            $('#dayShow').show();
            $('#weekShow').hide();
            $('#monthShow').hide();
            $('#yearShow').hide();
            $('#endTime').show();
        }else if(jugi==3){
            $('#startTime').show();
            $('#dayShow').hide();
            $('#weekShow').show();
            $('#monthShow').hide();
            $('#yearShow').hide();
            $('#endShow').show();
        }else if(jugi==4){
            $('#startTime').show();
            $('#dayShow').hide();
            $('#weekShow').hide();
            $('#monthShow').show();
            $('#yearShow').hide();
            $('#endShow').show();
        }else if(jugi==5){
            $('#startTime').show();
            $('#dayShow').hide();
            $('#weekShow').hide();
            $('#monthShow').hide();
            $('#yearShow').show();
            $('#endShow').show();
        }
    }
    function dayChange(){
        var month = $('#monthsel option:selected').val();
        var cont = "";
        if(month%2==0){
            if(month ==2 ){
                for(var i = 1 ; i<=28;i++){
                    cont+= '<option>'+i+'</option>';
                }
            }else{
                for(var i = 1 ; i<=30;i++){
                    cont+= '<option>'+i+'</option>';
                }
            }
        }else if(month%2==1){
            for(var i = 1 ; i<=31;i++){
                cont+= '<option>'+i+'</option>';
            }
        }
        $('#daysel').html(cont);
    }
    handler();
    dayChange();
    $("input:text[numberOnly]").on("keyup", function() {
    $(this).val($(this).val().replace(/[^0-9]/g,""));
    });   
    </script>
    </body>
    </html>
