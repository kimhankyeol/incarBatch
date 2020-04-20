<div class="card shadow info-popup">
    <div class="card-header">
        {{-- 프로그램 명 --}}
        <h6 class="font-weight-bold text-primary text-center font-weight-bold text-primary">(프로그램 명 와야함)</h6>
    </div>
    <div class="card-body">
        {{-- 프로그램 ID, 설명 --}}
        <div class="row mb-3">
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">프로그램 ID</div>
            <input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm" value="" readonly>
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">설명</div>
            <textarea class="col-md-6 form-control form-control-sm small" readonly></textarea>
        </div>
        {{-- 업무구분, 재작업 유무, 상태 --}}
        <div class="row mb-3">
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">업무구분</div>
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">대분류</div>
            <input type="text" class="col-md-1 text-center align-self-center form-control form-control-sm" value="대분류" readonly>
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">중분류</div>
            <input type="text" class="col-md-1 text-center align-self-center form-control form-control-sm" value="중분류" readonly>
            <div class="col-md-1 mx-4 custom-control custom-checkbox small align-self-center">
                <input type="checkbox" class="custom-control-input" id="customCheck">
                <label class="custom-control-label font-weight-bold text-primary" for="customCheck">재작업</label>
            </div>
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">프로그램 상태</div>
            <input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm" value="중분류" readonly>
        </div>
        {{-- 사용DB, 경로 --}}
        <div class="row mb-3">
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">사용 DB</div>
            <input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm" value="사용 DB" readonly>
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">경로</div>
            <input type="text" class="col-md-6 text-center align-self-center form-control form-control-sm" value="PATH" readonly>
        </div>
        {{-- 예상시간, 최대 예상시간 --}}
        <div class="row mb-3">
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
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary small p-0">등록자</div>
                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" placeholder="11111111" readonly="">
                <div class="d-inline-block col-md-2 text-center align-self-center font-weight-bold text-primary small p-0">등록자IP</div>
                <input type="text" class="d-inline-block w-auto col-md-3 form-control form-control-sm align-self-center" placeholder="192.168.168.168" readonly="">
                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary small p-0">등록일</div>
                <input type="text" class="d-inline-block col-md-3 form-control form-control-sm align-self-center" placeholder="2020-02-02" readonly="">              
            </div>
            <div class="col-md-6">
                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary small p-0">수정자</div>
                <input type="text" class="d-inline-block col-md-2 form-control form-control-sm align-self-center" placeholder="11111111" readonly="">
                <div class="d-inline-block col-md-2 text-center align-self-center font-weight-bold text-primary small p-0">수정자IP</div>
                <input type="text" class="d-inline-block w-auto col-md-3 form-control form-control-sm align-self-center" placeholder="192.168.168.168" readonly="">
                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary small p-0">수정일</div>
                <input type="text" class="d-inline-block col-md-3 form-control form-control-sm align-self-center" placeholder="2020-02-02" readonly="">              
            </div>
        </div>
        <hr>
        {{-- 파라미터 --}}
        <div class="row mb-3">
            <fieldset class="cistp-fieldset">
                <legend>프로그램 파라미터 타입</legend>
                <div class="col-md-12" id="proParams">
                    <div class="d-inline-flex col-md-5 mb-2 ml-5">
                        <div class="col-md-3 small align-self-center text-center font-weight-bold">파라미터</div>
                        <input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm small" value="타입" readonly>
                        <input type="text" name="proParamSulmyungInput" class="col-md-7 form-control form-control-sm small" placeholder="설명" readonly>
                    </div>
                    <div class="d-inline-flex col-md-5 mb-2 ml-5">
                        <div class="col-md-3 small align-self-center text-center font-weight-bold">파라미터</div>
                        <input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm small" value="타입" readonly>
                        <input type="text" name="proParamSulmyungInput" class="col-md-7 form-control form-control-sm small" placeholder="설명" readonly>
                    </div>
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
