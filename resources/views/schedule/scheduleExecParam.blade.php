<link rel="stylesheet" href="/css/tab.css">
<script>
function tabHideShow(pSeq){
  $('.tab-pane').removeClass('active show');
  $('.gpLi').removeClass('active')
  $('#'+pSeq).addClass('active show');
  $('#gpLi'+pSeq).addClass('active');
}
</script>
<fieldset class="cistp-fieldset">
  <legend>파라미터 입력</legend>
  <div class="col-md-12">
        @if(isset($jobDetail[0]->job_params))
          @php
            $jobParamArr=explode("||",$jobDetail[0]->job_params);
            $jobParamSulArr=explode("||",$jobDetail[0]->job_paramsulmyungs);
            for ($i = 0; $i < count($jobParamArr); $i++) {
            echo '<div class="d-inline-flex w-50 delYN mb-2">';
            echo '<div class="col-md-3 small align-self-center text-center">잡 파라미터 '.intVal($i+1).')</div>';
            if($jobParamArr[$i]=="paramNum"){
              echo '<input type="text" class="col-md-2  form-control form-control-sm" placeholder="숫자" readonly/>';
              echo '<input type="text" name="Sc_Param" class="col-md-6 form-control form-control-sm" placeholder="'.$jobParamSulArr[$i].'" numberonly> </div>' ;
              echo '<input type="hidden" name="Job_Params"  value="'.$jobParamArr[$i].'"/>';
              echo '<input type="hidden" name="jobParamSulArr" value="'.$jobParamSulArr[$i].'"/>';
            }else if($jobParamArr[$i]=="paramStr"){
              echo '<input type="text" class="col-md-2 form-control form-control-sm" placeholder="문자" readonly/>';
              echo '<input type="text" name="Sc_Param" class="col-md-6 form-control form-control-sm" placeholder="'.$jobParamSulArr[$i].'"> </div>' ;
              echo '<input type="hidden" name="Job_Params"  value="'.$jobParamArr[$i].'"/>';
              echo '<input type="hidden" name="jobParamSulArr" value="'.$jobParamSulArr[$i].'"/>';
            }
            }
          @endphp
        @endif
      </div>
</fieldset>
<fieldset class="cistp-fieldset">
  <legend>구성 프로그램</legend>
  @if(isset($jobGusungContents))
    <ul class="nav nav-tabs">
      @foreach($jobGusungContents as $index => $data)
        @if($index==0)
          <li id="{{'gpLi'.$data->p_seq}}" class="active gpLi"><a class="active" href="{{'#'.$data->p_seq}}"  onclick="tabHideShow('{{$data->p_seq}}')"  data-toggle="tab">{{intVal($index+1)."번 프로그램 : ".$data->p_file}}</a></li>
        @else
          <li id="{{'gpLi'.$data->p_seq}}" class="gpLi"><a href="{{'#'.$data->p_seq}}" data-toggle="tab"  onclick="tabHideShow('{{$data->p_seq}}')">{{intVal($index+1)."번 프로그램 : ".$data->p_file}}</a></li>
        @endif
      @endforeach
    </ul>
    <div class="tab-content">
      @foreach($jobGusungContents as $index => $data)
        @include('schedule.scheduleGusungProgramTabView')
      @endforeach
    </div>
    <input hidden class="scExecJob" value='{{$jobGusungContents[0]->job_seq}}'>
  @endif
</fieldset>
    