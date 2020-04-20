<option value="all" selected>전체</option>
@foreach($workMediumCtgData as $workMData)
<option value="{{$workMData->WorkMedium}}">{{$workMData->LongName}}</option>
@endforeach
