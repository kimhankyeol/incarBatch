<div class="text-center align-self-center font-weight-bold mx-2">코드 구분</div>
<div class="text-center align-self-center font-weight-bold mx-2">대분류</div>
<select onchange="code.workMediumCtg()" id="workLargeVal" class="form-control form-control-sm">
       @if($WorkLarge=="all")
<option value="all" selected>전체</option>
@foreach($usedLarge as $workLData)
    <option value="{{$workLData->worklarge}}">{{$workLData->longname}}</option>
@endforeach
@elseif($WorkLarge!="all")
<option value="all">전체</option>
@foreach($usedLarge as $workLData)
    @if($WorkLarge == $workLData->worklarge )
        <option value="{{$workLData->worklarge}}" selected>{{$workLData->longname}}</option>
    @else
        <option value="{{$workLData->worklarge}}">{{$workLData->longname}}</option>
    @endif
@endforeach
@endif
</select>
