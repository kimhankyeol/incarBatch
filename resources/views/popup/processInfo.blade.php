<!DOCTYPE html>
<html lang="en">
@include('popup.popupCommon.head')
<div class="card shadow">
    <div class="card-header">
        {{-- 프로그램 명 --}}
        <input id="P_Seq" type="hidden" value="{{$processDetail[0]->P_Seq}}"/>
        <h4 class="font-weight-bold text-primary text-center font-weight-bold text-primary">{{$processDetail[0]->P_Name}}</h4>
    </div>
    <div class="card-body">
        {{-- 업무구분, 재작업 유무, 상태 --}}
        <div class="row mb-3 mx-0">
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">대분류</div>
            <input type="text" class="col-md-1 text-center align-self-center form-control form-control-sm" value="{{$processDetail[0]->P_WorkLargeName}}" readonly>
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">중분류</div>
            <input type="text" class="col-md-1 text-center align-self-center form-control form-control-sm" value="{{$processDetail[0]->P_WorkMediumName}}" readonly>
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">프로그램 ID</div>
            <input id ="id1" type="text" class="col-md-2 form-control form-control-sm align-self-center" value="{{$processDetail[0]->P_FileName}}" readonly>
            <input id ="id3" type="text" class="col-md-1 form-control form-control-sm align-self-center" value="{{$processDetail[0]->P_File}}" readonly>
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">사용 DB</div>
            <input type="text" class="col-md-1 text-center align-self-center form-control form-control-sm" value="{{$processDetail[0]->P_UseDbName}}" readonly>
            <div class="col-md-1 custom-control custom-checkbox small align-self-center">
                <input id="retry" type="checkbox" class="custom-control-input" checked="{{ $processDetail[0]->P_ReworkYN }}" onclick = "return false">
                <label class="custom-control-label font-weight-bold text-primary" for="customCheck">재작업</label>
            </div>
        </div>
        {{-- 프로그램 ID, 설명 --}}
        <div class="row mb-3 mx-0">
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">프로그램 명</div>
            <input id="programName" type="text" class="col-md-2 form-control form-control-sm align-self-center" value="{{$processDetail[0]->P_Name}}" readonly>
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary mt-2">설명</div>
            <input id = "programExplain" type="text" class="col-md-4 form-control form-control-sm mt-2" value="{{$processDetail[0]->P_Sulmyung}}" readonly>
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary mt-2">상태</div>
            <input type="text" class="col-md-2 form-control form-control-sm align-self-center mt-2" placeholder="-" readonly>
        </div>
        {{-- 예상시간, 최대 예상시간 --}}
        <div class="row mb-3 mx-0">
            <div class="col-md-6 text-center">
                <fieldset class="cistp-fieldset">
                    <legend>예상시간</legend>
                    <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">일</div>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Job_YesangTime1" placeholder="일" numberonly="">
                    <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">시</div>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Job_YesangTime1" placeholder="시간" numberonly="">
                    <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">분</div>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Job_YesangTime1" placeholder="분" numberonly="">
                </fieldset>
            </div>
            <div class="col-md-6 text-center">
                <fieldset class="cistp-fieldset">
                    <legend>최대 예상시간</legend>
                    <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">일</div>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Job_YesangTime1" placeholder="일" numberonly="">
                    <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">시</div>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Job_YesangTime1" placeholder="시간" numberonly="">
                    <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">분</div>
                    <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" id="Job_YesangTime1" placeholder="분" numberonly="">
                </fieldset>
            </div>
        </div>
        {{-- 등록자, 수정자 정보 --}}
        <div class="row mb-3 mx-0">
            <div class="col-md-6">
                <div class="limit-time-text">등록자</div>
                <input type="text" class="form-control form-control-sm limit-time-input" value="{{intval($processDetail[0]->P_YesangTime/1440)}}" readonly>
                <div class="limit-time-text">등록자IP</div>
                <input type="text" class="form-control form-control-sm limit-time-input" value="{{intval($processDetail[0]->P_YesangTime%1440/60)}}" readonly>
                <div class="limit-time-text">등록일</div>
                <input type="text" class="form-control form-control-sm limit-time-input" value="{{intval($processDetail[0]->P_YesangTime%60)}}" readonly>              
            </div>
            <div class="col-md-6">
                <div class="limit-time-text">수정자</div>
                <input type="text" class="form-control form-control-sm limit-time-input" value="{{intval($processDetail[0]->P_YesangMaxTime/1440)}}" readonly>
                <div class="limit-time-text">수정자IP</div>
                <input type="text" class="form-control form-control-sm limit-time-input" value="{{intval($processDetail[0]->P_YesangMaxTime%1440/60)}}" readonly>
                <div class="limit-time-text">수정일</div>
                <input type="text" class="form-control form-control-sm limit-time-input" value="{{intval($processDetail[0]->P_YesangMaxTime%60)}}" readonly>              
            </div>
        </div>
        <hr>
        {{-- 업무 구분 대분류 중분류 선택 --}}
        <div class="row mb-3 mx-0">
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">파일 입력</div>
            <input id="P_FileInput" type="text" class="col-md-3 form-control form-control-sm align-self-center" value="{{$processDetail[0]->P_FileInput}}" readonly>
            @if(($processDetail[0]->P_FileInputCheck)==1)
            <div class="col-md-2 mx-2 custom-control custom-checkbox small">
                <label class="custom-control-label font-weight-bold text-primary" for="P_FileInputCheck">파일입력여부
                    <input id="retry" type="checkbox" class="custom-control-input" checked="checked" value="{{ $processDetail[0]->P_FileInputCheck }}" onclick = "return false">
                </label>
            </div>
            @else
            <div class="col-md-3 mx-2 custom-control custom-checkbox small">
                <label class="custom-control-label font-weight-bold text-primary" for="P_FileInputCheck">입력여부
                    <input id="retry" type="checkbox" class="custom-control-input" value="{{ $processDetail[0]->P_FileInputCheck }}" onclick = "return false">
                </label>
            </div>
            @endif
        </div>
        <hr>
        {{-- 파라미터 --}}
        <div class="row mb-3 mx-0">
            <fieldset class="cistp-fieldset">
                <legend>프로그램 파라미터 타입</legend>
                <div class="col-md-12" id="proParams">
                    @if(isset($processDetail[0]->P_Params))
                    @php
                      $proParamArr=explode("||",$processDetail[0]->P_Params);
                      $proParamSulArr=explode("||",$processDetail[0]->P_ParamSulmyungs);
                      for ($i = 0; $i < count($proParamArr); $i++) {
                        echo '<div class="d-inline-flex col-md-5 mb-2 ml-5">';
                        echo '<div class="col-md-3 small align-self-center text-center font-weight-bold">파라미터 '.intVal($i+1).'</div>';
                        if($proParamArr[$i]=="paramDate"){
                            echo '<input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm small" value="날짜" readonly>';
                        }else if($proParamArr[$i]=="paramNum"){
                            echo '<input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm small" value="숫자" readonly>';
                        }else if($proParamArr[$i]=="paramStr"){
                            echo '<input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm small" value="문자" readonly>';
                        }else{
                            echo '<input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm small" value="-" readonly>';
                        }
                        echo '<input type="text" name="pro_paramSulmyungs" class="col-md-7 text-center align-self-center form-control form-control-sm small" value="'.$proParamSulArr[$i].'" readonly>';
                        echo '</div>';
                      }
                    @endphp
                  @endif
                </div>
            </fieldset>
        </div>
        <div class="row justify-content-end">
            <button type="button" class="btn btn-primary mr-2" onclick="javascript:submit()">등록</button>
            <button type="button" class="btn btn-danger mr-2" onclick="javascript:submit()">취소</button>
        </div>
    </div>
</div>
<script type="text/javascript">
function submit() {
    window.close();
}
</script>
{{-- js 라이브러리  --}}
@include('popup.popupCommon.popupJs')

</body>
</html>