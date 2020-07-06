<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
    <img class="incar" src="/img/logo.png" alt="" style = "height: 50px; width: auto;">
    </a>
    <hr class="sidebar-divider my-0">
    {{--사이드바 배열로 돌리기 위해서 array 안에 array 이중으로 --}}
    {{--$_SERVER['REQUEST_URI']  요청경로 확인--}}
    {{--foreach문은 배열에 입력한 순서대로 나옴--}}
    {{--for문은 1,2,3,4 인덱스 순으로 나옴 --}}

    <li class="nav-item"> 
      <a class="nav-link" href="/process/processListView?page=1">
        <i></i><span>프로그램 등록</span>
      </a>
    </li>
    <li class="nav-item"> 
      <a class="nav-link" href="/job/jobListView?page=1">
        <i></i><span>잡 등록</span>
      </a>
    </li>
    <li class="nav-item"> 
      <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">        
        <i></i><span>스케줄 관리</span>
      </a>
      <div id="collapsePages" class="collapse hide" aria-labelledby="headingPages" data-parent="#accordionSidebar" style="">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">스케줄 보기</h6>
          <a class="collapse-item" href="/schedule/scheduleListView?page=1">리스트 보기</a>
          <a class="collapse-item" href="/schedule/scheduleCalendarView">달력 보기</a>
        </div>
      </div>
    </li>
    <li class="nav-item"> 
      <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages2" aria-expanded="true" aria-controls="collapsePages2">
        <i class=""></i>
        <span>모니터링</span>
      </a>
      <div id="collapsePages2" class="collapse hide " aria-labelledby="headingPages" data-parent="#accordionSidebar" style="">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">목록</h6>
          <a class="collapse-item" href="/monitoring/monitoringView?page=1">리스트 보기</a>
          <a class="collapse-item" href="/monitoring/monitoringChartView">모니터링 상태 차트로 보기</a>
        </div>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages3" aria-expanded="true" aria-controls="collapsePages3">
        <i class=""></i>
        <span>관리자</span>
      </a>
      <div id="collapsePages3" class="collapse hide " aria-labelledby="headingPages" data-parent="#accordionSidebar" style="">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">목록</h6>
          <a class="collapse-item" href="/admin/commonCodeLargeManageView?page=1">대분류 설정</a>
          <a class="collapse-item" href="/admin/commonCodeMediumManageView?page=1">중분류 설정</a>
        </div>
      </div>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
</ul>
