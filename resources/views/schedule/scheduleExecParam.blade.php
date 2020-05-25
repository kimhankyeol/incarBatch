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
            if($jobParamArr[$i]=="paramNum"){
              echo '<input type="text" name="Job_Params" class="col-md-2 form-control form-control-sm" placeholder="숫자" readonly/>';
              echo '<input type="text" name="Sc_Param" class="col-md-6 form-control form-control-sm" placeholder="'.$jobParamSulArr[$i].'" numberOnly> </div>' ;
            }else if($jobParamArr[$i]=="paramStr"){
              echo '<input type="text" name="Job_Params" class="col-md-2 form-control form-control-sm" placeholder="문자" readonly/>';
              echo '<input type="text" name="Sc_Param" class="col-md-6 form-control form-control-sm" placeholder="'.$jobParamSulArr[$i].'"> </div>' ;
            }
            }
          @endphp
        @endif
      </div>
</fieldset>

{{-- 프로그램 --}}

<fieldset class="cistp-fieldset">
  <legend>구성 프로그램</legend>
  <div class="card-body">
  <table id="datatable" class="table table-bordered" cellspacing="0">
    <colgroup>
      <col width="7%" />
      <col width="6%" />
      <col width="9%" />
      <col width="8%" />
      <col width="32%" />
      <col width="8%" />
      <col width="30%" />
    </colgroup>
    <thead>
      <tr>
        <th>실행여부</th>
        <th>경로</th>
        <th>프로그램</th>
        <th>프로그램 명</th>
        <th>파라미터</th>
        <th>재작업</th>
        <th>로그파일</th>
      </tr>
    </thead>
    <tbody>
      <div id="gusungList" class="row px-0 gusungList">
        @if(isset($jobGusungContents))
          @foreach($jobGusungContents as $data)
            <tr class="gusungData">
              <td>
                <div class="custom-control custom-checkbox small text-center">
                  <input id="sc_p_{{$data->JobGusung_Order}}" name="P_ExecuteYN" type="checkbox" class="custom-control-input" value="{{ $data->P_Seq }}" checked>
                  <label class="custom-control-label font-weight-bold text-primary" for="sc_p_{{$data->JobGusung_Order}}"></label>
                </div>
              </td>
              <td>{{$data->P_FilePath}}</td>
              <td>{{$data->P_File}}</td>
              <td>{{$data->P_Name}}</td>
              <td>
                @if(isset($data->JobGusung_ParamPos))
                  @php
                    $proParamArr=explode("||",$data->P_Params);
                    $Job_ParamSulmyungs=explode("||",$data->Job_ParamSulmyungs);
                    $JobGusung_ParamPos=explode("||",$data->JobGusung_ParamPos);
                    for ($i = 0; $i < count($JobGusung_ParamPos); $i++) {
                      echo '<div class="d-inline-flex w-50 delYN mb-2">'.intVal($i+1).')';
                    if($proParamArr[$i]=="paramNum"){
                      echo '<input type="text" name="pro_Params" class="col-md-5 form-control form-control-sm" placeholder="숫자" readonly/>';
                    }else if($proParamArr[$i]=="paramStr"){
                      echo '<input type="text" name="pro_Params" class="col-md-5 form-control form-control-sm" placeholder="문자" readonly/>';
                    }
                      echo '<input type="text" name="P_Param" class="col-md-6 form-control form-control-sm" value="'.$Job_ParamSulmyungs[$JobGusung_ParamPos[$i]].'" readonly></div>';
                    }
                  @endphp
                @endif
              </td>
              <td>
                @if(($data->P_ReworkYN)==1)
                  <label class="m-0 font-weight-bold text-primary">가능</label>
                @else
                  <label class="m-0  font-weight-bold text-danger">불가능</label>
                @endif
                  <input hidden name="Sc_ReworkYN" value="{{$data->P_ReworkYN}}"/>
              </td>
                @php
                  $nowDate=new DateTime();
                  $nowDate=$nowDate->format('Ymd');
                  $pfilesplit=explode('.php',$data->P_File);
                @endphp
              <td>
                <div><div class="logFileNameChg" >/home/script/log/{{$nowDate}}</div><input name="Sc_LogFile" type="text" value="{{"/".$pfilesplit[0]."_".$data->Job_Seq."_".$data->JobGusung_Order.".log"}}"></div>
              </td>
            </tr>
          @endforeach
        @endIf
      </div>
    </tbody>
  </table>
</div>
</fieldset>




