<div id="jobparams">
    <fieldset class="cistp-fieldset">
        <legend>파라미터 입력</legend>
        <div class="col-md-12">
              @if(isset($jobDetail[0]->Job_Params))
                @php
                  $jobParamArr=explode("||",$jobDetail[0]->Job_Params);
                  $jobParamSulArr=explode("||",$jobDetail[0]->Job_ParamSulmyungs);
                  for ($i = 0; $i < count($jobParamArr); $i++) {
                  echo '<div class="d-inline-flex w-50 delYN mb-2">';
                  echo '<div class="col-md-3 small align-self-center text-center">잡 파라미터</div>';
                  echo '<select name="Job_Params" class="col-md-2 form-control form-control-sm" readonly>';
                  if($jobParamArr[$i]=="paramDate"){
                    echo '<option value="'.$jobParamArr[$i].'" selected>날짜</option></select>';
                  }else if($jobParamArr[$i]=="paramNum"){
                    echo '<option value="'.$jobParamArr[$i].'" selected>숫자</option></select>';
                  }else if($jobParamArr[$i]=="paramStr"){
                    echo '<option value="'.$jobParamArr[$i].'" selected>문자</option></select>';
                  }
                  echo '<input type="text" name="Sc_Param" class="col-md-6 form-control form-control-sm" placeholder="'.$jobParamSulArr[$i].'"> </div>' ;
                  }
                @endphp
              @endif
            </div>
    </fieldset>
    
    {{-- 프로그램 --}}
    
    <fieldset class="cistp-fieldset">
        <legend>구성 프로그램</legend>
        <div class="card-body">
        {{-- 타이틀 --}}
        <div class="row text-center">
          <div class="right-line col-md-1 p-2 bg-primary text-white font-weight-bold rounded-0">실행 여부
          </div>
          <div class="right-line col-md-1 p-2 bg-primary text-white font-weight-bold rounded-0">순서
          </div>
          <div class="right-line col-md-2 p-2 bg-primary text-white font-weight-bold rounded-0">
            경로</div>
          <div class="right-line col-md-1 p-2 bg-primary text-white font-weight-bold rounded-0">
            프로그램</div>
          <div class="right-line col-md-2 p-2 bg-primary text-white font-weight-bold rounded-0">
            프로그램 명</div>
          <div class="right-line col-md-4 p-2 bg-primary text-white font-weight-bold rounded-0">
            파라미터</div>
            <div class="right-line col-md-1 p-2 bg-primary text-white font-weight-bold rounded-0">
            재작업</div>
        </div>
        <div id="gusungList" class="row px-0 gusungList">
            @if(isset($jobGusungContents))
              @foreach($jobGusungContents as $data)
              <ul class="px-0 mb-0 w-100 d-inline-flex gusungData">
                {{-- <li class="d-none"><input class="gusungChk" type="checkbox" value="{{$data->P_Seq}}"></li> --}}
                <li class="list-group-item d-inline-flex col-md-1 p-2 rounded-0 text-center h-100 align-items-center justify-content-center"><label><input type="checkbox" name="P_ExecuteYN" checked="checked"></label></li>
                <li class="list-group-item d-inline-flex col-md-1 p-2 rounded-0 text-center h-100 align-items-center justify-content-center">{{$data->JobGusung_Order}}</li>
                <li class="list-group-item d-inline-flex col-md-2 p-2 rounded-0 h-100 align-items-center">{{$data->P_FilePath}}</li>
                <li class="list-group-item d-inline-flex col-md-1 p-2 rounded-0 h-100 align-items-center">{{$data->P_File}}</li>
                <li class="list-group-item d-inline-flex col-md-2 p-2 rounded-0 h-100 align-items-center">{{$data->P_Name}}</li>
                <li class="list-group-item col-md-4 p-2 rounded-0">
                  <label class="m-0 w-100">
                    @if(isset($data->P_Params))
                        @php
                        $proParamArr=explode("||",$data->P_Params);
                        $proParamSulArr=explode("||",$data->P_ParamSulmyungs);
                        for ($i = 0; $i < count($proParamArr); $i++) {
                            echo '<div class="d-inline-flex w-50 delYN mb-2">';
                            echo '<select name="pro_Params" class="col-md-3 form-control form-control-sm" readonly>';
                            if($proParamArr[$i]=="paramDate"){
                                echo '<option value="'.$proParamArr[$i].'" selected>날짜</option></select>';
                                }else if($proParamArr[$i]=="paramNum"){
                                echo '<option value="'.$proParamArr[$i].'" selected>숫자</option></select>';
                                }else if($proParamArr[$i]=="paramStr"){
                                echo '<option value="'.$proParamArr[$i].'" selected>문자</option></select>';
                                }
                                echo '<input type="text" class="col-md-6 form-control form-control-sm" value="'.$proParamSulArr[$i].'" readonly></div>';
                            }
                            @endphp
                    @endif
                  </label>
                </li>
                <li class="list-group-item d-inline-flex col-md-1 p-2 rounded-0 text-center h-100 align-items-center justify-content-center">
                  @if(($data->P_ReworkYN)==1)
                      <label><input type="checkbox" checked="checked" onclick = "return false"></label>
                  @else
                      <label><input type="checkbox"onclick = "return false"></label>
                  @endif
                </li>
              </ul>
              @endforeach
            @endIf
        </div>
      </div>
    </fieldset>
</div>