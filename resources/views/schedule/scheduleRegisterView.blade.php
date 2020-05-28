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
                            <div id ="jobSearchLenz" class="input-group-append">
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
                            <textarea id="Sc_Sulmyung"  class="col-md-8 form-control form-control-sm mt-2" placeholder="스케줄 설명"></textarea>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <fieldset class="cistp-fieldset">
                                <legend>실행주기</legend>
                                <div class="d-inline-table  col-md-2 right-line">
                                    <select id="jugiChange" class="form-control form-control-sm w-100" onchange="handler()">
                                        <option value="6" selected>즉시</option>
                                        <option value="1">한번</option>
                                        <option value="2">매일</option>
                                        <option value="3">매주</option>
                                        <option value="4">매월</option>
                                        <option value="5">매년</option>
                                    </select>
                                </div>
                                <div class="d-inline-table col-md-8">
                                    {{-- 년월시  --}}
                                    <div id="startTime">
                                        <div class="d-inline-flex w-100  align-items-center form-control-sm">
                                            <span class="font-weight-bold text-primary mx-auto ">시작일시 : </span>
                                            <input id="startdate" type="date" class="form-control col-md-4" onchange = "dateChangeVal()">
                                            <input id="starttm" type="time" class="form-control col-md-4" >
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
                                                    <input name="yoil"  type="checkbox" class="mr-1" value="0"> 일요일
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
                                                    <input name="yoil"  type="checkbox" class="mr-1" value="6"> 토요일
                                                </label>
                                            </div>
                                          
                                        </div>
                                    </div>
                                     {{-- 매월 --}}
                                    <div id="monthShow">
                                        <div class="d-inline-flex w-100  align-items-center" id="monthShow">
                                            <div class="d-inline-flex w-100  align-items-center form-control-sm">
                                                <span class="font-weight-bold text-primary mx-auto">매월: </span>
                                                <select id="daysel2" class="form-control col-md-4">
                                                </select>
                                                <span class="col-md-2">일</span>
                                                <div class="mx-1 custom-control custom-checkbox small align-middle col-md-2">
                                                    <input id="lastDay" type="checkbox" class="custom-control-input" value="0">
                                                    <label class="custom-control-label font-weight-bold text-primary" for="lastDay">말일</label>
                                                    <input id="lastDayHidden" type="hidden" class="custom-control-input">
                                                </div>
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
                                                <div id ="monthselDiv" class="col-md-2 form-control" readonly></div>
                                                <input type="hidden" id="monthsel">
                                                </select>
                                                <span class="col-md-1">월</span>
                                                <div id ="dayselDiv" class="col-md-2 form-control" readonly></div>
                                                <input type="hidden" id ="daysel" class="col-md-2 form-control"/>
                                                <span class="col-md-1">일</span>
                                                <div class="mx-1 custom-control custom-checkbox small align-middle col-md-2">
                                                    <input id="lastDay2" type="checkbox" class="custom-control-input" value="0">
                                                    <label class="custom-control-label font-weight-bold text-primary" for="lastDay2">말일</label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="d-inline-flex w-100  align-items-center">
                                        </div>
                                    </div>
                                    <div id="endTime">
                                        <div class="d-inline-flex w-100  align-items-center form-control-sm" >
                                            <span class="font-weight-bold text-primary mx-auto">종료일시 : </span>
                                            <input id="enddate" type="date" class="form-control col-md-4" value="2020-12-31">
                                            <input id="endtm" type="time" class="form-control col-md-4" value="00:00">
                                        </div>
                                        <div class="d-inline-flex w-100  align-items-center">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="card-body" id="jobparams">
                                    @include('schedule.scheduleExecParam')
                                </div>
                                <hr>
                                <div class="row justify-content-end">
                                    <input type="button" id="scChkBtnHideShow" class="mt-3 mr-2 btn btn-success" value="파라미터 체크" onclick="scheduleParamCheck()" />
                                    <input type="button" id="scReBtnHideShow" class="mt-3 mr-2 btn btn-success" style="display:none"  value="되돌리기" onclick="reScheduleParamCheck()" />
                                    <input type="button" id="scRegBtnHideShow" class="mt-3 mr-2 btn btn-primary" style="display:none"  value="등록" onclick="job.scRegister()" />
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
        $('#startTime').hide();
        $('#starttm').hide();
        $('#dayShow').hide();
        $('#weekShow').hide();
        $('#monthShow').hide();
        $('#yearShow').hide();
        $('#endTime').hide();
        var newDt = new Date().format('yyyy-MM-dd');
        var newTm = new Date().format('HH:mm');
        $('#startdate').val(newDt);
        $('#starttm').val(newTm);
        $('#daysel2').removeAttr('readonly','');
        $("#lastDay").val(0);
        $("#lastDay").prop("checked",false);
       var jugi = $('#jugiChange option:selected').val();
        if(jugi==1){
            dateChangeVal(jugi);
            $('#startTime').show();
            $('#starttm').show();
            $('#dayShow').hide();
            $('#weekShow').hide();
            $('#monthShow').hide();
            $('#yearShow').hide();
            $('#endTime').hide();
        }else if(jugi==2){
            dateChangeVal(jugi);
            $('#startTime').show();
            $('#starttm').show();
            $('#dayShow').show();
            $('#weekShow').hide();
            $('#monthShow').hide();
            $('#yearShow').hide();
            $('#endTime').show();
        }else if(jugi==3){
            dateChangeVal(jugi);
            $('#startTime').show();
            $('#starttm').show();
            $('#dayShow').hide();
            $('#weekShow').show();
            $('#monthShow').hide();
            $('#yearShow').hide();
            $('#endTime').show();
        }else if(jugi==4){
            dateChangeVal(jugi);
            $('#startTime').show();
            $('#starttm').show();
            $('#dayShow').hide();
            $('#weekShow').hide();
            $('#monthShow').show();
            $('#yearShow').hide();
            $('#endTime').show();
        }else if(jugi==5){
            dateChangeVal(jugi);
            $('#startTime').show();
            $('#starttm').show();
            $('#dayShow').hide();
            $('#weekShow').hide();
            $('#monthShow').hide();
            $('#yearShow').show();
            $('#endTime').show();
        }else if(jugi==6){
            dateChangeVal(jugi);
            $('#startTime').hide();
            $('#starttm').hide();
            $('#dayShow').hide();
            $('#weekShow').hide();
            $('#monthShow').hide();
            $('#yearShow').hide();
            $('#endShow').show();
        }
    }
    //주기가  월을 클릭하면 말일 변경30,31,28 
    function dayChange(){
        var monthCont="";
        var mm = new Date($('#startdate').val()).format('MM');
        for(var j=1 ; j<=12;j++){
            if(mm==j){
                $('#monthsel').val(j);
                $('#monthselDiv').html(j);
            }
           }
    }
    //시작일시 바뀌면 폴더경로 바뀜
    function dateChangeVal(jugi){
        var jugi2 = $('#jugiChange option:selected').val();
        if(jugi==6){
            var newDate = new Date().format('yyyyMMdd');
            var cont = '/home/script/log/'+newDate;
            $(".logFileNameChg").html(cont);
        }else{
            if(jugi2==4){
                if($("#lastDay").val()=="1"){
                    var year =new Date($('#startdate').val()).format('yyyy');
                    var month = new Date($('#startdate').val()).format('MM');
                    var lastDay = (new Date( year, month, 0) ).getDate();
                    var cont = '/home/script/log/'+chgDate;
                    var cont2 = "";
                    if(month ==2 ){
                        cont2+= '<option selected>28</option>';
                    }else if(month==1||month==3||month==5||month==7||month==8||month==10||month==12){
                        cont2+= '<option selected>31</option>';
                    }else{
                        cont2+= '<option selected>30</option>';
                    }
                    $('#daysel2').attr('readonly','readonly');
                    $('#startdate').val(new Date(year+"-"+month+"-"+lastDay).format('yyyy-MM-dd'));
                }else{
                    var year =new Date($('#startdate').val()).format('yyyy');
                    var month = new Date($('#startdate').val()).format('MM');
                    var day = new Date($('#startdate').val()).format('dd');
                    var chgDate = new Date($('#startdate').val()).format('yyyyMMdd');
                    var cont = '/home/script/log/'+chgDate;
                    var cont2 = "";
                    if(month ==2 ){
                        for(var i = 1 ; i<=28;i++){
                            if(day==i){
                                cont2+= '<option selected>'+i+'</option>';
                            }else{
                                cont2+= '<option>'+i+'</option>';
                            }
                        }
                    }else if(month==1||month==3||month==5||month==7||month==8||month==10||month==12){
                        for(var i = 1 ; i<=31;i++){
                            if(day==i){
                                cont2+= '<option selected>'+i+'</option>';
                            }else{
                                cont2+= '<option>'+i+'</option>';
                            }
                        }
                    }else{
                        for(var i = 1 ; i<=30;i++){
                            if(day==i){
                            cont2+= '<option selected>'+i+'</option>';
                            }else{
                                cont2+= '<option>'+i+'</option>';
                            }
                        }
                    }
                }
                // $('#daysel2').removeAttr('readonly','');
                $(".logFileNameChg").html(cont);
                $('#daysel2').html(cont2);
            }else if(jugi2==5){
                if($("#lastDay2").val()=="1"){
                    var year =new Date($('#startdate').val()).format('yyyy');
                    var month = new Date($('#startdate').val()).format('MM');
                    var lastDay = (new Date( year, month, 0) ).getDate();
                    var cont = '/home/script/log/'+chgDate;
                    var cont2 = "";
                    if(month ==2 ){
                        $('#daysel').val(28);
                        $('#dayselDiv').html(28);
                    }else if(month==1||month==3||month==5||month==7||month==8||month==10||month==12){
                        $('#daysel').val(31);
                        $('#dayselDiv').html(31);
                    }else{
                        $('#daysel').val(30);
                        $('#dayselDiv').html(30);
                    }
                    $('#daysel').attr('readonly','readonly');
                    $('#startdate').val(new Date(year+"-"+month+"-"+lastDay).format('yyyy-MM-dd'));
                }else{
                    var year =new Date($('#startdate').val()).format('yyyy');
                    var month = new Date($('#startdate').val()).format('MM');
                    var day = new Date($('#startdate').val()).format('dd');
                    var chgDate = new Date($('#startdate').val()).format('yyyyMMdd');
                    var cont = '/home/script/log/'+chgDate;
                    if(month ==2 ){
                        for(var i = 1 ; i<=28;i++){
                            if(day==i){
                                $('#daysel').val(i);
                                $('#dayselDiv').html(i);
                            }
                        }
                    }else if(month==1||month==3||month==5||month==7||month==8||month==10||month==12){
                        for(var i = 1 ; i<=31;i++){
                            if(day==i){
                                $('#daysel').val(i);
                                $('#dayselDiv').html(i);
                            }
                        }
                    }else{
                        for(var i = 1 ; i<=30;i++){
                            if(day==i){
                                $('#daysel').val(i);
                                $('#dayselDiv').html(i);
                            }
                        }
                    }
                }
                var monthCont="";
                for(var j=1 ; j<=12;j++){
                    if(month==j){
                        $('#monthsel').val(j);
                        $('#monthselDiv').html(j);
                    }
                }
                
                // $('#daysel2').removeAttr('readonly','');
                $(".logFileNameChg").html(cont);
            }else{
                var chgDate = new Date($('#startdate').val()).format('yyyyMMdd');
                var cont = '/home/script/log/'+chgDate;
                $(".logFileNameChg").html(cont);
            }
        }
        
    }
    handler();
    dayChange();
    $(document).ready(function(){
        $(document).on('keyup','input[numberonly]',function(event){
            $(this).val($(this).val().replace(/[^0-9]/g,""));
        })
    })
    //스케줄 파라미터 체크
    function scheduleParamCheck(){
        var scheduleParamIndex=0;
        if($('input[name=Sc_Param]').length==0){
           alert('잡이 선택되지 않아 파라미터 체크를 할 수 없습니다.');
        }else{
            $('input[name=Sc_Param]').each(function(){
                if (!$.trim($(this).val()).length) {
                scheduleParamIndex++;
                }
            });
            if(scheduleParamIndex==0){
                var cont ="";
                var strType ="";
                var errorNumCheck=0;
                var errorStrCheck=0;
                for(var i = 0 ; i<$('input[name=Job_Params').length;i++){
                    if($('input[name=Job_Params').eq(i).val()=="paramNum"){
                        strType="숫자";
                        //숫자 타입 입력 안되면 오류 체크
                        if(!$.isNumeric($('input[name=Sc_Param]').eq(i).val())){
                            errorNumCheck++;
                        }
                    }else{
                        strType="문자";
                        if($.isNumeric($('input[name=Sc_Param]').eq(i).val())){
                            //문자에서는 숫자도 입력가능하니  confirm 으로 한번더 물어봐야됨
                            errorStrCheck++;
                        }
                    }
                    cont+="파라미터 "+parseInt(i+1)+"번 : 설명 -"+$('input[name=jobParamSulArr]').eq(i).val()+" , 타입 - "+strType+" , 입력 값 - "+$('input[name=Sc_Param]').eq(i).val()+"\n";
                }
                //타입 에러 없이 입력이 잘되었으면
                if(errorNumCheck==0&&errorStrCheck==0){
                    var res = confirm("입력한 정보가 맞습니까 ? \n"+cont+"\n")
                    if(res == true) {
                        $('#scChkBtnHideShow').hide();
                        $('#jobSearchLenz').hide();
                        $('#scReBtnHideShow').show();
                        $('#scRegBtnHideShow').show();
                        $('input[name=Sc_Param]').attr("readonly",true);
                    }else{
                        return false;
                    } 
                }else if (errorNumCheck!=0&&errorStrCheck==0){
                    alert('숫자 타입의 변수가 제대로 입력되지 않았습니다.')
                    return false;
                }else if (errorNumCheck==0&&errorStrCheck!=0){
                    var res2 = confirm('문자 타입의 변수에 숫자로 입력되었습니다. 그래도 진행하시겠습니까?');
                    if(res2){
                        var res = confirm("입력한 정보가 맞습니까 ? \n"+cont+"\n")
                        if(res == true){
                            $('#scChkBtnHideShow').hide();
                            $('#jobSearchLenz').hide();
                            $('#scReBtnHideShow').show();
                            $('#scRegBtnHideShow').show();
                            $('input[name=Sc_Param]').attr("readonly",true);
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }else if (errorNumCheck!=0&&errorStrCheck!=0){
                    alert('숫자 / 문자 타입의 변수가 제대로 입력되지 않았습니다.')
                    return false;
                }

               
            }else{
                alert('파라미터가 입력되지 않아 파라미터 체크를 할 수 없습니다.') ;
                return false;
            }
          
        }
    }
    //되돌리기 
    function reScheduleParamCheck(){
        var res = confirm("다시 되돌리시겠습니까? ");
        if(res){
            $('#scChkBtnHideShow').show();
            $('#jobSearchLenz').show();
            $('#scReBtnHideShow').hide();
            $('#scRegBtnHideShow').hide();
            $('input[name=Sc_Param]').attr("readonly",false);
            $('input[name=Sc_Param]').val("");
        }else{
            return false;
        }
    }
    //체크 값변경
    $('#lastDay').change(function(){
        if ($("#lastDay").is(":checked")) {
            $("#lastDay").val(1);
            var year =new Date($('#startdate').val()).format('yyyy');
            var month = new Date($('#startdate').val()).format('MM');
            var lastDay = ( new Date( year, month, 0) ).getDate();

            var chgDate = new Date($('#startdate').val()).format('yyyyMMdd');
            var cont = '/home/script/log/'+chgDate;
            var cont2 = "";
            if(month ==2 ){
                cont2+= '<option selected>28</option>';
            }else if(month==1||month==3||month==5||month==7||month==8||month==10||month==12){
                cont2+= '<option selected>31</option>';
            }else{
                cont2+= '<option selected>30</option>';
            }
            $('#daysel2').attr('readonly','readonly');
            $('#startdate').val(new Date(year+"-"+month+"-"+lastDay).format('yyyy-MM-dd'));
            $(".logFileNameChg").html(cont);
            $('#daysel2').html(cont2);
        } else {
            $("#lastDay").val(0);
            var year =new Date($('#startdate').val()).format('yyyy');
            var month = new Date($('#startdate').val()).format('MM');
            var day = new Date($('#startdate').val()).format('dd');
            var chgDate = new Date($('#startdate').val()).format('yyyyMMdd');
            var cont = '/home/script/log/'+chgDate;
            var cont2 = "";
            if(month ==2 ){
                for(var i = 1 ; i<=28;i++){
                    if(day==i){
                        cont2+= '<option selected>'+i+'</option>';
                    }else{
                        cont2+= '<option>'+i+'</option>';
                    }
                }
            }else if(month==1||month==3||month==5||month==7||month==8||month==10||month==12){
                for(var i = 1 ; i<=31;i++){
                    if(day==i){
                        cont2+= '<option selected>'+i+'</option>';
                    }else{
                        cont2+= '<option>'+i+'</option>';
                    }
                }
            }else{
                for(var i = 1 ; i<=30;i++){
                    if(day==i){
                        cont2+= '<option selected>'+i+'</option>';
                    }else{
                        cont2+= '<option>'+i+'</option>';
                    }
                }
            }
            $('#daysel2').removeAttr('readonly','');
            $(".logFileNameChg").html(cont);
            $('#daysel2').html(cont2);
        }
    })
    $('#lastDay2').change(function(){
        if ($("#lastDay2").is(":checked")) {
            $("#lastDay2").val(1);
            var year =new Date($('#startdate').val()).format('yyyy');
            var month = new Date($('#startdate').val()).format('MM');
            var lastDay = ( new Date( year, month, 0) ).getDate();
            var chgDate = new Date($('#startdate').val()).format('yyyyMMdd');
            var cont = '/home/script/log/'+chgDate;
            var cont2 = "";
            if(month ==2 ){
                $('#daysel').val(28);
                $('#dayselDiv').html(28);
            }else if(month==1||month==3||month==5||month==7||month==8||month==10||month==12){
                $('#daysel').val(31);
                $('#dayselDiv').html(31);
            }else{
                $('#daysel').val(30);
                $('#dayselDiv').html(30);
            }
            $('#startdate').val(new Date(year+"-"+month+"-"+lastDay).format('yyyy-MM-dd'));
            $(".logFileNameChg").html(cont);
        } else {
            $("#lastDay2").val(0);
            var month = new Date($('#startdate').val()).format('MM');
            var chgDate = new Date($('#startdate').val()).format('yyyyMMdd');
            var day = new Date($('#startdate').val()).format('dd');

            var cont = '/home/script/log/'+chgDate;
            if(month ==2 ){
                for(var i = 1 ; i<=28;i++){
                    if(day==i){
                        $('#daysel').val(i);
                        $('#dayselDiv').html(i);
                    }
                }
            }else if(month==1||month==3||month==5||month==7||month==8||month==10||month==12){
                for(var i = 1 ; i<=31;i++){
                    if(day==i){
                        $('#daysel').val(i);
                        $('#dayselDiv').html(i);
                    }
                }
            }else{
                for(var i = 1 ; i<=30;i++){
                    if(day==i){
                        $('#daysel').val(i);
                        $('#dayselDiv').html(i);
                    }
                }
            }
            $('#daysel').removeAttr('readonly','');
            $(".logFileNameChg").html(cont);
        }
    })
    $('#daysel2').change(function(){
        var year =new Date($('#startdate').val()).format('yyyy');
        var month = new Date($('#startdate').val()).format('MM');
        $('#startdate').val(new Date(year+"-"+month+"-"+$('#daysel2 option:selected').val()).format('yyyy-MM-dd'));
    })
</script>
    </body>
</html>
