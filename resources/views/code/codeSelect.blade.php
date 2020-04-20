<div class="text-center align-self-center font-weight-bold text-primary mx-2">업무구분</div>
<div class="text-center align-self-center font-weight-bold text-primary mx-2">대분류</div>
{{-- jobJs/codeFunc.js --}}
<select onchange="code.workMediumCtg()" id="workLargeVal" class="form-control form-control-sm">
    <option value="all">전체</option>
    @foreach($workLargeCtgData as $workLData)
    <option value="{{$workLData->WorkLarge}}">{{$workLData->LongName}}</option>
    @endforeach
</select>

<div class="text-center align-self-center font-weight-bold text-primary  mx-2">중분류</div>
<select id="workMediumVal" class="form-control form-control-sm ml-2 mr-5">
    <option value="all" selected>전체</option>
</select> 
