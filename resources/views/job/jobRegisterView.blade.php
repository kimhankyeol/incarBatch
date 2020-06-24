<!DOCTYPE html>
<html lang="en">
@include('common.head')
<script>document.title="잡 등록"</script>
<body id="page-top"  class="bodyBgImg">
  <div id="wrapper">
    {{-- 블레이드 주석 쓰는 법--}}
    {{--사이드바 시작--}}
    @include('common.sidebar')
    {{--사이드바 끝--}}
    {{--content 시작--}}
    <div class="d-flex flex-column" style="width: 100%">
      <!-- Main Content -->
      <div id="content">
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <!-- DataTales Example -->
          <h4 class="h3 my-4 font-weight-bold" style="color:white">잡 정보 등록</h4>
          <div class="card shadow">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-2 text-center align-self-center font-weight-bold">잡 명</div>
                  <input type="text" id="Job_Name"  class="col-md-8 form-control form-control-sm align-self-center" placeholder="예)손해보험 수수료">
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-2 text-center align-self-center font-weight-bold">설명</div>
                  <div class="col-md-8">
                    <textarea type="text" id="Job_Sulmyung" class="form-control form-control-sm" placeholder="설명" onkeyup="check_text(this);" onkeypress="check_text(this);"></textarea>
                    <span id="text_cnt" class="text_cnt text-gray-500">text_cnt</span>
                  </div>
                </div>
                <hr>
                <div class="row" style="justify-content: space-around">
                  <div class="outher-code">
                    {{-- 업무 구분 대분류 중분류 선택 --}}
                    <div class="text-center align-self-center font-weight-bold mx-2">업무 구분</div>
                    @include("code.codeSelect")
                  </div>
                  <div class="col-md-2 text-center align-self-center font-weight-bold ">잡 등록자</div>
                  <input type="text" id="Job_RegID" class="col-md-2 form-control form-control-sm align-self-center" placeholder="김한결" value="김한결" readonly>
                  {{-- <div class="col-md-2 text-center align-self-center font-weight-bold">잡 상태</div>
                  <input type="text" class="col-md-1 form-control form-control-sm align-self-center" placeholder="-" readonly>
                  <div class="col-md-2 text-center align-self-center font-weight-bold">구성 프로세스 개수</div>
                  <input type="text" class="col-md-1 form-control form-control-sm align-self-center" placeholder="-" readonly>               --}}
                </div>
                <hr>
                <div class="col-md-12 font-weight-bold">
                  잡 파라미터 타입
                </div>
                <hr>
                <div class="row">
                  {{-- 잡변수가 추가되는 부분 --}}
                  <div class="col-md-12" id="jobParams"></div>
                  <div class="col-md-12 text-center">
                    <input type="button" class="mt-3 btn btn_orange " value="잡 변수 추가 +"  onclick="job.addDivParam()"/>
                  </div>
                </div>
                <hr>
              <div class="row justify-content-end">
                <button type="button" class="mt-3 mr-2 btn btn-primary" onclick="job.register()">등록</button>
                <button type="button" class="mt-3 mr-2 btn btn-danger" onclick="location.href = '/job/jobListView'">취소</b>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
   $("input:text[numberOnly]").on("keyup", function() {
    $(this).val($(this).val().replace(/[^0-9]/g,""));
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

  $("#Job_Sulmyung").val('');
      $("#text_cnt").html('0 / 2000 Byte');
      function check_text(obj){
          var text_cnt = $(obj).val().length;
          if(text_cnt > 2000) {
            event.preventDefault();
            alert("2000 Byte 이상 작성할 수 없습니다.");
          } else {
            $("#text_cnt").html(text_cnt+' / 2000 Byte');
          }
      }
  </script>
</body>
</html>

