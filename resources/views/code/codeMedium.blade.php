
@if($WorkMedium=="all")
    <option value="all" selected>전체</option>
    @foreach($workMediumCtgData as $workMData)
        <option value="{{$workMData->workmedium}}">{{$workMData->longname}}</option>
    @endforeach
@elseif($WorkMedium!="all")
    <option value="all" selected>전체</option>
    @foreach($workMediumCtgData as $workMData)
    @if($WorkMedium==$workMData->workmedium)
        <option value="{{$workMData->workmedium}}" selected>{{$workMData->longname}}</option>
    @else
        <option value="{{$workMData->workmedium}}">{{$workMData->longname}}</option>
    @endif
    @endforeach
@endif