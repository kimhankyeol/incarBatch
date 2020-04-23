

@if(preg_match_all("/".str_replace("/","\\/","/admin/commonCodeMediumManageView" )."/","/".$URI."/"))
    <div class="text-center align-self-center font-weight-bold text-primary mx-2">코드 구분</div>
@else
    <div class="text-center align-self-center font-weight-bold text-primary mx-2">업무 구분</div>
@endif

<div class="text-center align-self-center font-weight-bold text-primary mx-2">대분류</div>
{{-- jobJs/codeFunc.js --}}
{{-- 대분류를 클릭하면 code.workMediumCtg 호출하여 중분류를 나타낸다.   --}}
<select onchange="code.workMediumCtg()" id="workLargeVal" class="form-control form-control-sm">
        @if($WorkLarge=="all")
            <option value="all" selected>전체</option>
            @foreach($workLargeCtgData as $workLData)
                <option value="{{$workLData->WorkLarge}}">{{$workLData->LongName}}</option>
            @endforeach
        @elseif($WorkLarge!="all")
            <option value="all">전체</option>
            @foreach($workLargeCtgData as $workLData)
                @if($WorkLarge == $workLData->WorkLarge )
                    <option value="{{$workLData->WorkLarge}}" selected>{{$workLData->LongName}}</option>
                @else
                    <option value="{{$workLData->WorkLarge}}">{{$workLData->LongName}}</option>
                @endif
            @endforeach
        @endif
</select>
<div class="text-center align-self-center font-weight-bold text-primary  mx-2">중분류</div>
<select id="workMediumVal" onchange="code.workDataSelect()" class="form-control form-control-sm ml-2 mr-5">
    <option value="all" selected>전체</option>
</select> 