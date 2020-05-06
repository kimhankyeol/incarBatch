<!DOCTYPE html>
<html lang="en">
@include('popup.popupCommon.head')
@include('popup.popupCommon.popupJs')
<div class="card shadow">
    <div class="card-header">
        {{-- 프로그램 명 --}}
        <h6 class="font-weight-bold text-primary text-center font-weight-bold text-primary">{{'job_'.$jobDetail[0]->Job_WorkLargeCtg.'_'.$jobDetail[0]->Job_WorkMediumCtg.'_'.$jobDetail[0]->Job_Seq}}</h6>
    </div>
    <div class="card-body">
        {{-- 프로그램 ID, 설명 --}}
        <div class="row mb-3">
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">잡명</div>
            <input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm" value="{{$jobDetail[0]->Job_Name}}" readonly>
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">설명</div>
            <textarea class="col-md-6 form-control form-control-sm small" value="" readonly>{{$jobDetail[0]->Job_Sulmyung}}</textarea>
        </div>
        {{-- 업무구분, 재작업 유무, 상태 --}}
        <div class="row mb-3">
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">업무구분</div>
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">대분류</div>
            <input type="text" class="col-md-1 text-center align-self-center form-control form-control-sm" value="{{$jobDetail[0]->Job_WorkLargeName}}" readonly>
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">중분류</div>
            <input type="text" class="col-md-1 text-center align-self-center form-control form-control-sm" value="{{$jobDetail[0]->Job_WorkMediumName}}" readonly>
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">잡 상태</div>
            <input type="text" class="col-md-1 text-center align-self-center form-control form-control-sm" value="실행중" readonly>
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">구성 프로그램 개수</div>
            <input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm" value="{{$jobDetail[0]->gusungCount}}" readonly>
        </div>
        <div class="row mb-3">
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">잡 등록자</div>
            <input type="text" id="Job_RegID" class="col-md-2 form-control form-control-sm align-self-center" value="112893" readonly>
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">등록일</div>
            <input type="text" class="col-md-2 form-control form-control-sm align-self-center" value="{{$jobDetail[0]->Job_RegDate}}" readonly="">
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">최종 수정일</div>
            <input type="text" class="col-md-2 form-control form-control-sm align-self-center" value="{{$jobDetail[0]->Job_UpdDate}}" readonly="">              
          </div>
        {{-- 예상시간, 최대 예상시간 --}}
        <div class="row mb-3">
            <div class="col-md-6 text-center">
                <div class="d-inline-block col-md-3 text-center align-self-center font-weight-bold text-primary">예상시간</div>
                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">일</div>
                <input type="text" class="d-inline-block col-md-1 form-control form-control-sm align-self-center" id="Job_YesangTime1" value="{{empty($jobTotalTime[0]->Job_YesangTime) ? 0:intval($jobTotalTime[0]->Job_YesangTime/1440)}}" numberonly="" readonly>
                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">시</div>
                <input type="text" class="d-inline-block col-md-1 form-control form-control-sm align-self-center" id="Job_YesangTime2" value="{{empty($jobTotalTime[0]->Job_YesangTime) ? 0:intval($jobTotalTime[0]->Job_YesangTime%1440/60)}}" numberonly="" readonly>
                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">분</div>
                <input type="text" class="d-inline-block col-md-1 form-control form-control-sm align-self-center" id="Job_YesangTime3" value="{{empty($jobTotalTime[0]->Job_YesangTime) ? 0:intval($jobTotalTime[0]->Job_YesangTime%60)}}" numberonly="" readonly>
            </div>
            <div class="col-md-6 text-center">
                <div class="d-inline-block col-md-3 text-center align-self-center font-weight-bold text-primary">최대 예상시간</div>
                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">일</div>
                <input type="text" class="d-inline-block col-md-1 form-control form-control-sm align-self-center" id="Job_YesangMaxTime1" value="{{empty($jobTotalTime[0]->Job_YesangMaxTime) ? 0:intval($jobTotalTime[0]->Job_YesangMaxTime/1440)}}" numberonly="" readonly>
                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">시</div>
                <input type="text" class="d-inline-block col-md-1 form-control form-control-sm align-self-center" id="Job_YesangMaxTime2" value="{{empty($jobTotalTime[0]->Job_YesangMaxTime) ? 0:intval($jobTotalTime[0]->Job_YesangMaxTime%1440/60)}}" numberonly="" readonly>
                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">분</div>
                <input type="text" class="d-inline-block col-md-1 form-control form-control-sm align-self-center" id="Job_YesangMaxTime3" value="{{empty($jobTotalTime[0]->Job_YesangMaxTime) ? 0:intval($jobTotalTime[0]->Job_YesangMaxTime%60)}}" numberonly="" readonly>
            </div>
        </div>
        {{-- 등록자, 수정자 정보 --}}
        <div class="row mb-3">
            <fieldset class="cistp-fieldset">
                <legend>실행주기</legend>
                <div class="d-inline-table  col-md-2 right-line">
                    {{-- <select class="col-md-10 form-control form-control-sm ml-3" onchange="handler()">
                        <option value="1">한번</option>
                        <option value="2">매일</option>
                        <option value="3">매주</option>
                        <option value="4">매월</option>
                        <option value="5">매년</option>
                    </select> --}}
                    <label class="w-100 text-center">
                        <input id="Oneday" type="radio" class="mr-3" name="runCycle" value="1" checked=true onchange="handler()"> 한번
                    </label>
                    <hr>
                    <label class="w-100 text-center">
                        <input id="Everyday" type="radio" class="mr-3" name="runCycle" value="2" onchange="handler()"> 매일
                    </label>
                    <hr>
                    <label class="w-100 text-center">
                        <input id="Everyweek" type="radio" class="mr-3" name="runCycle" value="3" onchange="handler()"> 매주
                    </label>
                    <hr>
                    <label class="w-100 text-center">
                        <input id="Everymonth" type="radio" class="mr-3" name="runCycle" value="4" onchange="handler()"> 매월
                    </label>
                    <hr>
                    <label class="w-100 text-center">
                        <input id="Everyyear" type="radio" class="mr-3" name="runCycle" value="5" onchange="handler()"> 매년
                    </label>
                </div>
                <div class="d-inline-table col-md-8">
                    <div class="d-inline-flex w-100  align-items-center form-control-sm" id="StartTime">
                        시작 시간 : 
                        
                        <input type="date" class="form-control col-md-3" value="{{date("Y-m-d")}}">
                        <input type="time" class="form-control col-md-3" value="{{date("H:i:s")}}">
                    </div>
                    <div class="d-inline-flex w-100  align-items-center"></div>
                    {{-- 분기 처리 --}}
                    {{-- 밑의 주석 부분 지우는 코드 아님, 분기처리 할 코드임 --}}
                        {{-- 매일 --}}
                        <div class="d-inline-flex w-100  align-items-center">
                            <label class="Day">
                                매
                            </label>
                            <label class="Day">   
                                <input  type="text" class="col-md-10 form-control form-control-sm Day" value="1">
                            </label>
                            <label class="Day">
                                일 마다
                            </label>
                            {{-- 매주 --}}
                            <label class="week">
                                <div class="col-md-5 ml-auto Action">주마다 다음 요일에 :</div>
                            </label>
                        </div>
                        
                        {{-- 매주 --}}
                        <div class="d-inline-flex w-100  align-items-center">
                            <label class="mr-3 week">
                                <input type="checkbox" class="mr-1 week"> 일요일
                            </label>
                            <label class="mr-3 week">
                                <input type="checkbox" class="mr- week"> 월요일
                            </label>
                            <label class="mr-3 week">
                                <input type="checkbox" class="mr- week"> 화요일
                            </label>
                            <label class="mr-3 week">
                                <input type="checkbox" class="mr- week"> 수요일
                            </label>
                            <label class="mr-3 week">
                                <input type="checkbox" class="mr- week"> 목요일
                            </label>
                            <label class="mr-3 week">
                                <input type="checkbox" class="mr- week"> 금요일
                            </label>
                            <label class="mr-3 week">
                                <input type="checkbox" class="mr-1 week"> 토요일
                            </label>
                        </div>
                        {{-- 매월 --}}
                        <div class="d-inline-flex w-100  align-items-center">
                            <label class="month">
                                매월
                            </label>
                            <label class="month"> 
                                <select class="col-md-10 form-control form-control-sm ml-3">
                                    <option>1</option><option>2</option><option>3</option>
                                    <option>4</option><option>5</option><option>6</option>
                                    <option>7</option><option>8</option><option>9</option>
                                    <option>10</option><option>11</option><option>12</option>
                                    <option>13</option><option>14</option><option>15</option>
                                    <option>16</option><option>17</option><option>18</option>
                                    <option>19</option><option>20</option><option>21</option>
                                    <option>22</option><option>23</option><option>24</option>
                                    <option>25</option><option>26</option><option>27</option>
                                    <option>28</option><option>29</option><option>30</option><option>31</option>
                                </select>
                            </label>
                            <label class="month"> 
                                일
                            </label>
                        </div>
                        {{-- 매년 --}}
                        <div class="d-inline-flex w-100  align-items-center">
                            <label class="year">
                                매년
                            </label>
                            <label class="year">
                                <select class="col-md-10 form-control form-control-sm ml-3">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                    <option>11</option>
                                    <option>12</option>
                                </select>
                            </label>
                            <label class="year">
                                월
                            </label>
                            <label class="year">
                                <select class="col-md-10 form-control form-control-sm ml-3">
                                    <option>1</option><option>2</option><option>3</option>
                                    <option>4</option><option>5</option><option>6</option>
                                    <option>7</option><option>8</option><option>9</option>
                                    <option>10</option><option>11</option><option>12</option>
                                    <option>13</option><option>14</option><option>15</option>
                                    <option>16</option><option>17</option><option>18</option>
                                    <option>19</option><option>20</option><option>21</option>
                                    <option>22</option><option>23</option><option>24</option>
                                    <option>25</option><option>26</option><option>27</option>
                                    <option>28</option><option>29</option><option>30</option><option>31</option>
                                </select>
                            </label>
                            <label class="year">
                                일
                            </label>
                        </div>
                    </fieldset>
                </div>
            </fieldset>
        </div>
        <div class="d-inline-flex col-md-6  align-items-center form-control-sm">
            <span class="font-weight-bold text-primary mx-auto">종료시간 : </span>
            <input type="date" class="form-control col-md-4" value="2100-12-31">
            <input type="time" class="form-control col-md-4" value="00:00:00">
        </div>
        <hr>
        {{-- 파라미터 --}}
        <div class="row mb-3">
            <fieldset class="cistp-fieldset">
                <legend>파라미터 입력</legend>
                <div class="col-md-12" id="jobParams">
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
                          echo '<input type="text" name="Job_paramSulmyungs" class="col-md-6 form-control form-control-sm" placeholder="'.$jobParamSulArr[$i].'"> </div>' ;
                          }
                        @endphp
                      @endif
                    </div>
            </fieldset>
        </div>
        {{-- 프로그램 --}}
        <div class="row mb-3">
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
                      @include('popup.jobexecuteGusungList')
                    @endIf
                </div>
              </div>
            </fieldset>
            {{-- <fieldset class="cistp-fieldset">
                <legend>구성 프로그램</legend>
                <table class="table table table-bordered">
                    <colgroup>
                        <col width="5%" />
                        <col width="5%" />
                        <col width="10%" />
                        <col width="10%" />
                        <col width="15%" />
                        <col width="30%" />
                        <col width="20%" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th>선택</th>
                            <th>순서</th>
                            <th>경로</th>
                            <th>프로그램</th>
                            <th>프로그램 명</th>
                            <th>파라미터</th>
                            <th>재작업</th>
                        </tr>
                    </thead>
                    <tbody> --}}
                        {{-- 반복처리 --}}
                        {{-- <tr>
                            <td class="text-center"><input type="checkbox"></td>
                            <td>프로그램명</td>
                            <td class="text-wrap">
                                <div class="d-inline-flex col-md-5 mb-2 ml-3">
                                    <div class="col-md-4 small align-self-center text-center font-weight-bold">파라미터</div>
                                    <input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm small" value="숫자" readonly>
                                    <input type="text" name="proParamSulmyungInput" class="col-md-7 form-control form-control-sm small" placeholder="설명" value="파라미터">
                                </div>
                                <div class="d-inline-flex col-md-5 mb-2 ml-3">
                                    <div class="col-md-4 small align-self-center text-center font-weight-bold">파라미터</div>
                                    <input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm small" value="문자" readonly>
                                    <input type="text" name="proParamSulmyungInput" class="col-md-7 form-control form-control-sm small" placeholder="설명">
                                </div>
                                <div class="d-inline-flex col-md-5 mb-2 ml-3">
                                    <div class="col-md-4 small align-self-center text-center font-weight-bold">파라미터</div>
                                    <input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm small" value="숫자" readonly>
                                    <input type="text" name="proParamSulmyungInput" class="col-md-7 form-control form-control-sm small" placeholder="설명">
                                </div>
                                <div class="d-inline-flex col-md-5 mb-2 ml-3">
                                    <div class="col-md-4 small align-self-center text-center font-weight-bold">파라미터</div>
                                    <input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm small" value="문자" readonly>
                                    <input type="text" name="proParamSulmyungInput" class="col-md-7 form-control form-control-sm small" placeholder="설명">
                                </div>
                                <div class="d-inline-flex col-md-5 mb-2 ml-3">
                                    <div class="col-md-4 small align-self-center text-center font-weight-bold">파라미터</div>
                                    <input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm small" value="문자" readonly>
                                    <input type="text" name="proParamSulmyungInput" class="col-md-7 form-control form-control-sm small" placeholder="설명">
                                </div>
                            </td>
                            <td class="text-center">
                                Y
                            </td>
                        </tr>
                    </tbody>
                </table>
            </fieldset> --}}
        </div>

        <div class="row justify-content-end">
            <button type="button" class="btn btn-primary mr-2" onclick="javascript:submit()">실행</button>
            <button type="button" class="btn btn-danger mr-2" onclick="javascript:submit()">취소</button>
        </div>
    </div>
</div>
<script type="text/javascript">

function submit() {
    window.close();
}

function handler(){
    if(event.target.value==1){
        $('#StartTime').show();
        $('.Day').hide();
        $('.week').hide();
        $('.month').hide();
        $('.year').hide();
    }else if(event.target.value==2){
        $('#StartTime').show();
        $('.Day').show();
        $('.week').hide();
        $('.month').hide();
        $('.year').hide();
    }else if(event.target.value==3){
        $('#StartTime').show();
        $('.Day').show();
        $('.week').show();
        $('.month').hide();
        $('.year').hide();
    }else if(event.target.value==4){
        $('#StartTime').show();
        $('.Day').hide();
        $('.week').hide();
        $('.month').show();
        $('.year').hide();
    }else if(event.target.value==5){
        $('#StartTime').show();
        $('.Day').hide();
        $('.week').hide();
        $('.month').hide();
        $('.year').show();
    }
}

</script>
</body>
</html>