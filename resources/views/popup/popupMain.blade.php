<!DOCTYPE html>
<html lang="en">
@include('popup.popupCommon.head')
{{-- 팝업 분기 처리  --}}
<body class="bg-gradient-primary">
  @if($_SERVER['REQUEST_URI'] === '/popup/processInfo')
    @include('popup.popupContent.processInfo')
  @endif
  @if($_SERVER['REQUEST_URI'] === '/popup/jobGusung')
    @include('popup.popupContent.jobGusung')
  @endif
{{-- js 라이브러리  --}}
  @if($_SERVER['REQUEST_URI'] === '/popup/jobAction')
    @include('popup.popupContent.jobAction')
  @endif
{{-- js 라이브러리  --}}
@include('popup.popupCommon.popupJs')

</body>
</html>