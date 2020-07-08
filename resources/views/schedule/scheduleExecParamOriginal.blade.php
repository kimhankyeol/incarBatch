  <fieldset class="cistp-fieldset ">
    <legend>파라미터 입력</legend>
    <div class="col-md-12">
          @if(isset($jobDetail[0]->job_params))
            @php
              $jobParamArr=explode("||",$jobDetail[0]->job_params);
              $jobParamSulArr=explode("||",$jobDetail[0]->job_paramsulmyungs);
              for ($i = 0; $i < count($jobParamArr); $i++) {
              echo '<div class="d-inline-flex w-50 delYN mb-2">';
              echo '<div class="col-md-3 small align-self-center text-center">잡 파라미터</div>';
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

  {{-- 프로그램 --}}

  <fieldset class="cistp-fieldset">
    <legend>구성 프로그램</legend>
      <div class="card-body">
        <table id="datatable" class="table table-bordered" cellspacing="0">
          <colgroup>
            <col width="7.5%" />
            <col width="7.5%" />
            <col width="9%" />
            <col width="20%" />
            <col width="6%" />
            <col width="20%" />
            <col width="20%" />
          </colgroup>
          <thead>
            <tr>
              <th>실행여부</th>
              <th>프로그램</th>
              <th>프로그램 명</th>
              <th>파라미터</th>
              <th>재작업</th>
              <th>로그파일</th>
              <th>입력 파일</th>
            </tr>
          </thead>
          <tbody>
            {{-- <div id="gusungList" class="row px-0 gusungList"> --}}
              @if(isset($jobGusungContents))
                @foreach($jobGusungContents as $data)
                  <tr class="gusungData">
                    <td>
                      <div class="custom-control custom-checkbox small text-center">
                        <input id="sc_p_{{$data->jobgusung_order}}" name="P_ExecuteYN" type="checkbox" class="custom-control-input" value="{{ $data->p_seq }}" checked>
                        <label class="custom-control-label font-weight-bold text-primary" for="sc_p_{{$data->jobgusung_order}}"></label>
                      </div>
                    </td>
                    <td>{{$data->p_file}}</td>
                    <td>{{$data->p_name}}</td>
                    <td style="overflow-x:scroll">
                      @if(isset($data->jobgusung_parampos))
                        @php
                          $proParamArr=explode("||",$data->p_params);
                          $Job_ParamSulmyungs=explode("||",$data->job_paramsulmyungs);
                          $JobGusung_ParamPos=explode("||",$data->jobgusung_parampos);
                          for ($i = 0; $i < count($JobGusung_ParamPos); $i++) {
                            echo '<div class="d-inline-flex w-100 delYN mb-2">'.intVal($i+1).')';
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
                    <td style="text-align: center">
                      @if(($data->p_reworkyn)==1)
                        <label class="m-0 font-weight-bold text-primary">가능</label>
                      @else
                        <label class="m-0  font-weight-bold text-danger">불가능</label>
                      @endif
                        <input hidden name="Sc_ReworkYN" value="{{$data->p_reworkyn}}"/>
                    </td>
                      @php
                        $nowDate=new DateTime();
                        $nowDate=$nowDate->format('Ymd');
                        $pfilesplit=explode('.php',$data->p_file);
                      @endphp
                    <td>
                      {{-- jobgusungorder 를 pseq로 바꿔야됨 --}}
                      <div><div class="logFileNameChg" >/home/script/log/{{$nowDate}}/스케줄 번호</div><input name="Sc_LogFile" style="width:100%" type="text" value="{{"/".$pfilesplit[0]."_".$data->job_seq."_".$data->p_seq."_".$data->p_execount.".log"}}"></div>
                    </td>
                    <td class="text-center">
                      @if($data->p_textinputcheck==1)
                    
                      @else
                      -
                      @endif
                    </td>
                  </tr>
                  <input hidden class="scExecJob" value='{{$data->job_seq}}'>
                @endforeach
              @endIf
            {{-- </div> --}}
          </tbody>
        </table>
      </div>
  </fieldset>
  <link rel="stylesheet" href="/css/tab.css">
  <div style="margin:10px;">
    <!-- Tab 영역 태그는 ul이고 클래스는 nav와 nav-tabs를 설정한다. -->
    <ul class="nav nav-tabs">
    <!-- Tab 아이템이다. 태그는 li과 li > a이다. li태그에 active는 현재 선택되어 있는 탭 메뉴이다. -->
    <li class="active"><a href="#home" data-toggle="tab">Home</a></li>
    <!-- a 태그의 href는 아래의 tab-content 영역의 id를 설정하고 data-toggle 속성을 tab으로 설정한다. -->
    <li><a href="#profile" data-toggle="tab">Profile</a></li>
    <li><a href="#messages" data-toggle="tab">Messages</a></li>
    <li><a href="#settings" data-toggle="tab">Settings</a></li>
    </ul>
    <!-- Tab이 선택되면 내용이 보여지는 영역이다. -->
    <!-- 태그는 div이고 class는 tab-content로 설정한다. -->
    <div class="tab-content">
    <!-- 각 탭이 선택되면 보여지는 내용이다. 태그는 div이고 클래스는 tab-pane이다. -->
    <!-- active 클래스는 현재 선택되어 있는 탭 영역이다. -->
    <div class="tab-pane fade active show" id="home">Home 메뉴</div>
    <!-- id는 고유한 이름으로 설정하고 tab의 href와 연결되어야 한다. -->
    <div class="tab-pane fade" id="profile">Profile 메뉴</div>
    <div class="tab-pane fade" id="messages">Messages 메뉴</div>
    <div class="tab-pane fade" id="settings">Settings 메뉴</div>
    </div>
    </div>
    
    