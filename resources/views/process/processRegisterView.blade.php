<!DOCTYPE html>
<html lang="en">
@include('common.head')
<script>document.title="프로그램 등록"</script>
<body id="page-top" class="bodyBgImg">
  <div id="wrapper">
    {{-- 블레이드 주석 쓰는 법--}}
    {{--사이드바 시작--}}
    @include('common.sidebar')
    {{--사이드바 끝--}}
    {{--content 시작--}}
    <div class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <div class="container-fluid">
            <h4 class="h3 my-4 font-weight-bold" style="color:white">프로그램 정보 등록</h4>
                <input id="P_RegIp" type="hidden" value="{{$_SERVER["REMOTE_ADDR"]}}"/>
                <input id="P_RegId" type="hidden" value="1611698"/>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="custom-row">
                            {{-- 업무 구분 대분류 중분류 선택 --}}
                            <div class="text-center align-self-center font-weight-bold mx-2">업무 구분</div>
                            @include("code.codeSelect")
                            {{-- <div class="text-center align-self-center font-weight-bold mx-2">프로그램 ID</div> --}}
                            <div class="text-center align-self-center font-weight-bold">프로그램 경로</div>
                            <input id ="processPath" type="text" class="form-control form-control-sm align-self-center"readonly>
                            <input id ="processFile" type="text" class="form-control form-control-sm align-self-center" placeholder="파일명">
                            <div class="mx-1 custom-control custom-checkbox small align-middle">
                                <input id="retry" type="checkbox" class="custom-control-input" value="0" checked>
                                <label class="custom-control-label font-weight-bold " for="retry">재작업</label>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-2 text-center align-self-center font-weight-bold ">프로그램 명</div>
                            <input id="programName" type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="프로그램 명">
                            <div class="col-md-2 text-center align-self-center font-weight-bold  mt-2">프로그램 설명</div>
                            <textarea id = "programExplain"  class="col-md-6 form-control form-control-sm mt-2" placeholder="설명"> </textarea>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <div class="col-md-12 text-center align-self-center font-weight-bold ">배치 작업 평균 소요시간</div>
                                <div class="d-inline-block col-md-3 text-center align-self-center font-weight-bold ">일 / 시 / 분</div>
                                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime1" value="0" numberOnly>
                                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime2" value="0" numberOnly>
                                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangTime3" value="0" numberOnly>
                            </div>
                            <div class="col-md-6 text-center">
                                <div class="col-md-12 text-center align-self-center font-weight-bold ">배치 작업 최대 소요시간</div>
                                <div class="d-inline-block col-md-3 text-center align-self-center font-weight-bold ">일 / 시 / 분</div>
                                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime1" value="0" numberOnly>
                                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime2" value="0" numberOnly>
                                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Pro_YesangMaxTime3" value="0" numberOnly>
                            </div>
                        </div>
                        <hr>
                        <div class="row align-items-center">
                             {{-- 업무 구분 대분류 중분류 선택 --}}
                            <div class="col-md-2 text-center align-self-center font-weight-bold ">텍스트 파일</div>
                            <div class="col-md-2 custom-control custom-checkbox small">
                                <input id="P_TextInputCheck" type="checkbox" class="custom-control-input">
                                <label class="custom-control-label font-weight-bold " for="P_TextInputCheck">텍스트 파일 여부</label>
                            </div>
                            <input id="P_TextInputFilePath"  type="text" class="col-md-3 form-control form-control-sm align-self-center mt-2" value="" disabled style="margin-right: 10px" >
                            <input id="P_TextInputFileName"  type="text" class="col-md-3 form-control form-control-sm align-self-center mt-2" value="" disabled >
                        </div>
                        <div class="row">
                           
                        </div>
                        <hr>
                        <div class="row w-100 mx-auto">
                        {{-- program 변수가 추가되는 부분 --}}
                            <h6 class="col-md-12 font-weight-bold ">프로그램 파라미터 타입</h6>
                            <div class="col-md-12" id="proParams"></div>
                            <div class="col-md-12 text-center">
                                <input type="button" class="mt-3 btn btn_orange" value="프로그램 변수 추가 +"  onclick="process.addDivParam()"/>
                            </div>
                        </div>
                        <hr>
                        <div class="row justify-content-end">
                            <input type="button" class="mt-3 mr-2 btn btn-primary" value="등록" onclick="process.register()" />
                            {{-- <input type="button" class="mt-3 mr-2 btn btn-info" value="수정"/> --}}
                            <input type="button" class="mt-3 mr-2 btn btn-danger" value="취소" onclick="location.href = '/process/processListView'"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--content 끝--}}
      </div>
    </div>
  </body>
  </html>
  <script>
    $("input:text[numberOnly]").on("keyup", function() {
    $(this).val($(this).val().replace(/[^0-9]/g,""));
    }); 
   $('#P_TextInputCheck').click(function(){
        if($('#processPath').val()==""){
            alert('대분류 및 중분류를 선택해주세요')
            return false;
        }else{
            var chk = $(this).is(":checked");
            if(chk){
                $('#P_TextInputFilePath').val($('#processPath').val());
                $('#P_TextInputFileName').removeAttr("disabled", "");
                $('#P_TextInput').val();
            }else{
                $('#P_TextInputFilePath').attr("disabled","disabled");
                $('#P_TextInputFileName').attr("disabled","disabled");
                $('#P_TextInputFilePath').val("");
                $('#P_TextInputFileName').val("");
            }
        }
   });
   function workLargeChgSel(){
     var WorkLarge =  $('#workLargeVal').val();
          $.ajax({
            url:"/code/workMediumCtg2",
            method:"get",
            data:{
              "WorkLarge":$('#workLargeVal').val()
            },
            success:function(resp){
              $("#workMediumVal").html(resp.returnHTML);
            },
            error:function(error){
  
            }
          })
    }
  </script>

