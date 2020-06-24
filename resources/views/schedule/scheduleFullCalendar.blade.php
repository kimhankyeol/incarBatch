<!DOCTYPE html>
<html lang="en">
@include('common.head')
<script>document.title="스케줄 상세"</script>
<script>
$(function() {
  //초기 ajax한번 태우고 
  //그 다음에 이전 다음 누르면 ajax
  let dt = new Date().format('yyyy-MM');
  var arr =getScheduleInfo(dt);

  $('#calendar').fullCalendar({
    defaultDate:new Date(),
    locale:'ko',
    selectable: true,
    eventClick:function(e){
      getEventInfo(e.id);
    },
    header:{
      left:'today',
      center:'title',
      right:'cusPrevButton,cusNextButton'
    },
    customButtons:{
      today:{
        text:'오늘',
        click:function(){
          $('#calendar').fullCalendar('today');
          $('#calendar').fullCalendar('removeEventSources');
          let date = moment($('#calendar').fullCalendar('getDate').toString()).format('YYYY-MM');
          arr2 = getScheduleInfo(date);
          $('#calendar').fullCalendar('addEventSource',arr2 );
        }
      },
      cusPrevButton:{
        text:'<',
        click:function(){
          $('#calendar').fullCalendar('prev');
          $('#calendar').fullCalendar('removeEventSources');
          // moment 로 변환
          let date = moment($('#calendar').fullCalendar('getDate').toString()).format('YYYY-MM');
          arr2 = getScheduleInfo(date);
          $('#calendar').fullCalendar('addEventSource',arr2 );
        }
      },
      cusNextButton:{
        text:'>',
        click:function(){
          $('#calendar').fullCalendar('next');
          // moment 로 변환
          let date = moment($('#calendar').fullCalendar('getDate').toString()).format('YYYY-MM');
          arr2 = getScheduleInfo(date);
          $('#calendar').fullCalendar('addEventSource',arr2 );
        }
      }
    },
    //초기값
      events:arr
  })
});

//달마다 출력되는 스케줄 정보
function getScheduleInfo(date){
  var arrResult=[];
  $.ajax({
    url:"/schedule/getScheduleInfo",
    method:"get",
    async: false,
    data:{
      "date":date
    },
    success:function(resp){
      arrResult=resp;
    },
    error:function(err){

    }
  });
  return arrResult;
}
function getEventInfo(scSeq){
  var cont ="";
  var scEvent = $('#scEvent');
  $.ajax({
    url:"/schedule/getEventInfo",
    method:"get",
    async: false,
    data:{
      "scSeq":scSeq
    },
    success:function(resp){
      console.table(resp);
      cont+='<div class="row"><div class="col-md-4 text-center align-self-center font-weight-bold">스케줄 Id</div><input type="text" class="col-md-8 form-control form-control-sm" value="job_'+resp[0].job_worklargectg+'_'+resp[0].job_workmediumctg+'_'+resp[0].job_seq+'_'+resp[0].sc_seq+'.sh" readonly></div>';
      cont+='<br/>';
      cont+='<div class="row"><div class="col-md-4 text-center align-self-center font-weight-bold">잡명</div><input type="text" class="col-md-8 form-control form-control-sm" value="'+resp[0].job_name+'" readonly></div>';
      cont+='<br/>';
      cont+='<div class="row"><div class="col-md-4 text-center align-self-center font-weight-bold">스케줄 상태</div><input type="text" class="col-md-8 form-control form-control-sm align-self-center" value="'+resp[0].sc_status+'" readonly></div>';
      cont+='<br/>';
      cont+='<div class="row"><div class="col-md-4 text-center align-self-center font-weight-bold">스케줄 설명</div><textarea class="col-md-8 form-control form-control-sm align-self-center" value="'+resp[0].sc_sulmyung+'" readonly></textarea></div>';
      cont+='<br/>';
      cont+='<div class="row"><div class="col-md-4 text-center align-self-center font-weight-bold">실행 주기 설명</div><input type="text" class="col-md-8 form-control form-control-sm align-self-center" value="'+resp[0].sc_cronsulmyung+'" readonly></div>';
      cont+='<br/>';
      scEvent.html(cont);
      $('#scEventModal').modal('show');
    },
    error:function(err){

    }
  });
}

</script>
<body id="page-top">
  <div id="wrapper" class="bodyBgImg">
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
          <h4 class="h3 my-4 font-weight-bold" style="color:white">스케줄 달력보기</h4>
          <div class="card shadow mb-4">
            <div class="card-body" style="z-index: 0">
                <div id="calendar"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{--  Modal 모달  --}}
    <div class="modal fade" id="scEventModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold modal-title ">스케줄 정보</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body" id="scEvent">
          </div>
          <div class="modal-footer">
            {{-- <button type="button" class="btn btn-info" onclick="">스케줄 상세보기</button> --}}
            <button type="button" class="btn btn_orange" data-dismiss="modal">취소</button>
          </div>
        </div>
      </div>
    </div>
</body>
</html>

