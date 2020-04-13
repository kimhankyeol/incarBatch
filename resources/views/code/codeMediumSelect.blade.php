<option value="all" selected>전체</option>
@foreach($workMediumCtgData as $workMData)
<option value="{{$workMData->Code}}">{{$workMData->Long_name}}</option>
@endforeach

