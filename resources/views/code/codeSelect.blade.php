{{-- 대분류를 클릭하면 workLargeUsedSel 호출하여 중분류를 나타낸다.   --}}
<div class="text-center align-self-center font-weight-bold text-primary mx-2">대분류</div>
<select id="workLargeVal" onchange="workLargeChgSel('{{$WorkMedium}}')" class="form-control form-control-sm">
    @if($WorkLarge=="all")
      <option value="all" selected>전체</option>
      @foreach($usedLarge as $ul)
      <option value="{{$ul->WorkLargeCtg}}">{{$ul->WorkLargeName}}</option>
      @endforeach
    @else
    <option value="all">전체</option>
      @foreach($usedLarge as $ul)
        @if($WorkLarge==$ul->WorkLargeCtg)
          <option value="{{$ul->WorkLargeCtg}}" selected>{{$ul->WorkLargeName}}</option>
        @else
          <option value="{{$ul->WorkLargeCtg}}">{{$ul->WorkLargeName}}</option>
        @endif
      @endforeach
    @endif
  
</select>

<div class="text-center align-self-center font-weight-bold text-primary  mx-2">중분류</div>
@if(isset($usedMedium))
<select id="workMediumVal" onchange="code.workDataSelect()" class="form-control form-control-sm ml-2 mr-5">
  @if($WorkMedium=="all")
    <option value="all" selected>전체</option>
    @foreach($usedMedium as $um)
    <option value="{{$um->WorkMediumCtg}}">{{$um->WorkMediumName}}</option>
    @endforeach
  @else
    <option value="all">전체</option>
    @foreach($usedMedium as $um)
      @if($WorkMedium==$um->WorkMediumCtg)
      <option value="{{$um->WorkMediumCtg}}" selected>{{$um->WorkMediumName}}</option>
      @else
      <option value="{{$um->WorkMediumCtg}}">{{$um->WorkMediumName}}</option>
      @endif
    @endforeach
  @endif
</select>
@elseif(!isset($usedMedium))
  <select id="workMediumVal" onchange="code.workDataSelect()" class="form-control form-control-sm ml-2 mr-5">
  <option value="all" selected>전체</option>
  </select>
@endif

  
