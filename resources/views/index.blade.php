
<!DOCTYPE html>
<html lang="en">
  {{--include 의 경로는 public/resource/view/부터 시작함--}}
{{-- head 부분 --}}
@include('common.head')
<body id="page-top">
  <div id="wrapper">
    {{-- 블레이드 주석 쓰는 법--}}
    {{--사이드바 시작--}}
    @include('common.sidebar')
    {{--사이드바 끝--}}
    {{--content 시작--}}
    {{--이 부분은 요청 경로를 통해 유동적으로 변경--}}
    <div id="content-wrapper" class="d-flex flex-column">
      {{--화면 분기 처리함 --}}
       {{-- @include('job.jobDetailView') --}}

      
      @if($_SERVER['REQUEST_URI'] === '/')
        @include('job.jobListView')
      @endif
      @if($_SERVER['REQUEST_URI'] === '/job/jobRegisterView')
        @include('job.jobRegisterView')
      @endif
      {{-- detailview 대한 요청 확인 --}}
      @if($_SERVER['REQUEST_URI'] === '/job/jobDetailView')
        @include('job.jobDetailView')
      @endif
      @if($_SERVER['REQUEST_URI'] === '/process/processRegisterView')
        @include('process.processRegisterView')
      @endif
      @if($_SERVER['REQUEST_URI'] === '/job/jobProcessRegisterView')
        @include('job.jobProcessRegisterView')
      @endif
      @if($_SERVER['REQUEST_URI'] === '/job/jobExecuteView')
        @include('job.jobExecuteView')
      @endif
      @if($_SERVER['REQUEST_URI'] === '/monitoring/monitoringView')
        @include('monitoring.monitoringView')
      @endif
      @if($_SERVER['REQUEST_URI'] === '/jobHistory/jobHistoryView')
        @include('jobHistory.jobHistoryView')
      @endif
    {{--Footer start  --}}
      @include('common.footer')
      {{--Footer end  --}}
    {{--content 끝--}}
  </div>
  {{-- <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a> --}}
 

</body>
</html>
