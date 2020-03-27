<!DOCTYPE html>
<html lang="en">
@include('popup.popupCommon.head')
{{-- 팝업 분기 처리  --}}
<body class="bg-gradient-primary">
  @if($_SERVER['REQUEST_URI'] === '/popup/searchBatchPopup')
    @include('popup.popupContent.searchBatchPopup')
  @endif
  @if($_SERVER['REQUEST_URI'] === '/popup/searchProcessPopup')
    @include('popup.popupContent.searchProcessPopup')
  @endif
  @if($_SERVER['REQUEST_URI'] === '/popup/batchDetailInfoPopup')
    @include('popup.popupContent.batchDetailInfoPopup')
  @endif
  @if($_SERVER['REQUEST_URI'] === '/popup/processDetailInfoPopup')
    @include('popup.popupContent.processDetailInfoPopup')
  @endif
{{-- js 라이브러리  --}}
@include('popup.popupCommon.popupJs')

</body>
</html>