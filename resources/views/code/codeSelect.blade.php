<div class="col-md-1 text-center align-self-center font-weight-bold text-primary mx-2">업무구분</div>
<div class="col-md-1 text-center align-self-center font-weight-bold text-primary mx-2">대분류</div>
<select onchange="workMediumCtg()" id="workLargeVal" class="form-control form-control-sm">
    <option value="all">전체</option>
    @foreach($workLargeCtgData as $workLData)
    <option value="{{$workLData->Code}}">{{$workLData->Long_name}}</option>
    @endforeach
</select>

<div class="col-md-1 text-center align-self-center font-weight-bold text-primary  mx-2">중분류</div>
<select id="workMediumVal" class="form-control form-control-sm ml-2 mr-5">
    <option value="all" selected>전체</option>
</select> 
