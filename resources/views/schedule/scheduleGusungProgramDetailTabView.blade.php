{{-- @php
$nowDate=new DateTime();
$nowDate=$nowDate->format('Ymd');
$pfilesplit=explode('.php',$data->p_file);
@endphp --}}
<div class="{{$index==0 ? "tab-pane fade active show":"tab-pane fade hide"}}" id="{{$data->p_seq}}" style="padding-top:15px">
    <div class="row w-100 mx-auto" style="padding-bottom:15px">
        <div class="text-center align-self-center font-weight-bold  col-md-2">프로그램 명(한글)</div>
        <input  type="text" class="form-control form-control-sm  col-md-2" value="{{$data->p_name}}" style="cursor:not-allowed" readonly>
        <div class="text-center align-self-center font-weight-bold col-md-2">재작업 여부</div>
        @if(($data->p_reworkyn)==1)
            <div class="form-control form-control-sm col-md-2 text-center" readonly><label class="m-0 font-weight-bold text-primary">가능</label></div>
        @else
            <div class="form-control form-control-sm col-md-2 text-center" readonly><label class="m-0 font-weight-bold text-danger">불가능</label></div>
        @endif
    </div>
    <div class="row w-100 mx-auto" style="padding-bottom:15px">
        <div class="text-center align-self-center font-weight-bold  col-md-2">프로그램 파라미터</div>
        <div class="col-md-10">
            @if(isset($data->jobgusung_parampos))
                @php
                $proParamArr=explode("||",$data->p_params);
                $Job_ParamSulmyungs=explode("||",$data->job_paramsulmyungs);
                $JobGusung_ParamPos=explode("||",$data->jobgusung_parampos);
                for ($i = 0; $i < count($JobGusung_ParamPos); $i++) {
                    echo '<div class="d-inline-flex delYN mb-2 col-md-6">'.intVal($i+1).')';
                if($proParamArr[$i]=="paramNum"){
                    echo '<input type="text" name="pro_Params" class="col-md-5 form-control form-control-sm" placeholder="숫자" readonly/>';
                }else if($proParamArr[$i]=="paramStr"){
                    echo '<input type="text" name="pro_Params" class="col-md-5 form-control form-control-sm" placeholder="문자" readonly/>';
                }
                    echo '<input type="text" name="P_Param" class="col-md-6 form-control form-control-sm" value="'.$Job_ParamSulmyungs[$JobGusung_ParamPos[$i]].'" readonly></div>';
                }
                @endphp
            @endif
        </div>
    </div>
    <div class="row w-100 mx-auto" style="padding-bottom:15px">
        <div class="text-center align-self-center font-weight-bold  col-md-2">프로그램 설명</div>
        <textarea class="form-control form-control-sm col-md-10" disabled>{{$data->p_sulmyung}}</textarea>
    </div>
    {{-- 입력파일 유무 --}}
        @if($data->p_textinputcheck==1)
            <div class="row w-100 mx-auto" style="padding-bottom:15px">
                {{-- 입력파일 txt 의 경로는 프로그램의 업무대분류 중분류를 가져와야함  파일업로드는 나중에 개발 일단은 .txt 파일 서버에있는지 없는지 판단--}}
                <div class="text-center align-self-center font-weight-bold  col-md-2">입력 파일</div>
                <div class="form-control form-control-sm col-md-5" readonly>{{'/home/batch/'.$data->p_worklargectg.'/'.$data->p_workmediumctg.'/data'}}</div><input name="Sc_TextInputFile" class="form-control form-control-sm col-md-5" type="text"  value="" readonly>
            </div>
        @else
            <div class="row w-100 mx-auto" style="padding-bottom:15px">
                <div class="text-center align-self-center font-weight-bold  col-md-2">입력 파일</div>
                <div class="form-control form-control-sm col-md-10" readonly>프로그램에는 입력 받는 파일이 없습니다.</div>
            </div>
        @endif
    {{-- 출력파일 유무 --}}
    @if($data->p_fileoutputcheck==1)
        <div class="row w-100 mx-auto" style="padding-bottom:15px">
            {{-- 출력파일 csv의 경로는 프로그램의 업무대분류 중분류를 가져와야함   나중에 개발 일단은 .csv 파일 서버에있는지 없는지 판단--}}
            <div class="text-center align-self-center font-weight-bold  col-md-2">출력 파일</div>
            <div class="form-control form-control-sm col-md-5" readonly>{{'/home/batch/'.$data->p_worklargectg.'/'.$data->p_workmediumctg.'/result'}}</div><input name="Sc_FileOutputFile" class="form-control form-control-sm col-md-5" type="text"  value="" readonly>
        </div>
         {{-- 개인정보 유무 --}}
        @if($data->p_privatecheck==1)
            <div class="row w-100 mx-auto" style="padding-bottom:15px">
                <div class="text-center align-self-center font-weight-bold  col-md-2" >개인정보</div>
                {{-- (나중에 이런값들을 넣어야됨) --}}
                <div class="form-control form-control-sm col-md-10" readonly>이름 , 주민번호 </div>
            </div>
        @else
            <div class="row w-100 mx-auto" style="padding-bottom:15px">
                <div class="text-center align-self-center font-weight-bold  col-md-2" >개인정보</div>
                {{-- (나중에 이런값들을 넣어야됨) --}}
                <div class="form-control form-control-sm col-md-10" readonly>프로그램에 출력 결과 파일에는 개인정보가 포함되어 있지 않습니다. </div>
            </div>
        @endif
    @else 
        <div class="row w-100 mx-auto" style="padding-bottom:15px">
            <div class="text-center align-self-center font-weight-bold  col-md-2">출력 파일</div>
            <div class="form-control form-control-sm col-md-10" readonly>프로그램에는 출력되는 결과 파일이 없습니다.</div>
        </div>
       
    @endif
    <div class="row w-100 mx-auto" style="padding-bottom:15px">
        <div class="text-center align-self-center font-weight-bold  col-md-2">로그 파일 </div>
        {{-- jobgusungorder 를 pseq로 바꿔야됨 --}}
        <div class="logFileNameChg form-control form-control-sm col-md-5" readonly>/home/script/log</div><input name="Sc_LogFile" class="form-control form-control-sm col-md-5" type="text" value="{{$data->sc_logfile}}" readonly>
    </div>
</div>
