<div class="card shadow">
    <div class="card-header">
        {{-- 프로그램 명 --}}
        <h6 class="font-weight-bold text-primary text-center font-weight-bold text-primary">(잡명, 쉘명이 와야함)</h6>
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
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">잡 상태</div>
            <input type="text" class="col-md-1 text-center align-self-center form-control form-control-sm" value="중분류" readonly>
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">구성 프로그램 개수</div>
            <input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm" value="중분류" readonly>
        </div>
        <div class="row mb-3">
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">잡 등록자</div>
            <input type="text" id="Job_RegID" class="col-md-2 form-control form-control-sm align-self-center" value="112893" readonly>
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">등록일</div>
            <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="" readonly="">
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">최종 수정일</div>
            <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="" readonly="">              
          </div>
        {{-- 예상시간, 최대 예상시간 --}}
        <div class="row mb-3">
            <div class="col-md-6 text-center">
                <div class="d-inline-block col-md-3 text-center align-self-center font-weight-bold text-primary">예상시간</div>
                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">일</div>
                <input type="text" class="d-inline-block col-md-1 form-control form-control-sm align-self-center" id="Job_YesangTime1" placeholder="일" numberonly="" readonly>
                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">시</div>
                <input type="text" class="d-inline-block col-md-1 form-control form-control-sm align-self-center" id="Job_YesangTime1" placeholder="시간" numberonly="" readonly>
                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">분</div>
                <input type="text" class="d-inline-block col-md-1 form-control form-control-sm align-self-center" id="Job_YesangTime1" placeholder="분" numberonly="" readonly>
            </div>
            <div class="col-md-6 text-center">
                <div class="d-inline-block col-md-3 text-center align-self-center font-weight-bold text-primary">최대 예상시간</div>
                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">일</div>
                <input type="text" class="d-inline-block col-md-1 form-control form-control-sm align-self-center" id="Job_YesangMaxTime1" placeholder="일" numberonly="" readonly>
                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">시</div>
                <input type="text" class="d-inline-block col-md-1 form-control form-control-sm align-self-center" id="Job_YesangMaxTime2" placeholder="시간" numberonly="" readonly>
                <div class="d-inline-block col-md-1 text-center align-self-center font-weight-bold text-primary">분</div>
                <input type="text" class="d-inline-block col-md-1 form-control form-control-sm align-self-center" id="Job_YesangMaxTime3" placeholder="분" numberonly="" readonly>
            </div>
        </div>
        {{-- 등록자, 수정자 정보 --}}
        <div class="row mb-3">
            <fieldset class="cistp-fieldset">
                <legend>실행주기</legend>
                <div class="d-inline-table  col-md-2 right-line">
                    <label class="w-100 text-center">
                        <input type="radio" class="mr-3" name="runCycle" value="한 번" checked=true> 한번
                    </label>
                    <label class="w-100 text-center">
                        <input type="radio" class="mr-3" name="runCycle" value="매일"> 매일
                    </label>
                    <label class="w-100 text-center">
                        <input type="radio" class="mr-3" name="runCycle" value="매주"> 매주
                    </label>
                    <label class="w-100 text-center">
                        <input type="radio" class="mr-3" name="runCycle" value="매월"> 매월
                    </label>
                    <label class="w-100 text-center">
                        <input type="radio" class="mr-3" name="runCycle" value="매년"> 매년
                    </label>
                </div>
                <div class="d-inline-table col-md-8">
                    <div class="d-inline-flex w-100 p-2 align-items-center form-control-sm">
                        시간 : 
                        <input type="date" class="form-control col-md-3" value="2000-01-01">
                        <input type="time" class="form-control col-md-3" value="15:31:00">
                    </div>
                    <hr>
                    {{-- 분기 처리 --}}
                    {{-- 밑의 주석 부분 지우는 코드 아님, 분기처리 할 코드임 --}}
                        {{-- 매일 --}}
                        {{-- <div class="d-inline-flex w-100 p-2 align-items-center">
                            매<input type="text" class="col-md-1 form-control form-control-sm" value="1">일 마다
                            {{-- 매주 --}}
                            {{-- <div class="col-md-5 ml-auto">주마다 다음 요일에 :</div>
                        </div> --}}
                        {{-- 매주 --}}
                        {{-- <div class="d-inline-flex w-100 p-2 align-items-center">
                            <label class="mr-3">
                                <input type="checkbox" class="mr-1"> 일요일
                            </label>
                            <label class="mr-3">
                                <input type="checkbox" class="mr-1"> 월요일
                            </label>
                            <label class="mr-3">
                                <input type="checkbox" class="mr-1"> 화요일
                            </label>
                            <label class="mr-3">
                                <input type="checkbox" class="mr-1"> 수요일
                            </label>
                            <label class="mr-3">
                                <input type="checkbox" class="mr-1"> 목요일
                            </label>
                            <label class="mr-3">
                                <input type="checkbox" class="mr-1"> 금요일
                            </label>
                            <label class="mr-3">
                                <input type="checkbox" class="mr-1"> 토요일
                            </label>
                        </div> --}}
                        {{-- 매월 --}}
                        {{-- <div class="d-inline-flex w-100 p-2 align-items-center">
                            매월 
                            <select class="col-md-1 form-control form-control-sm ml-3">
                                <option>1</option>
                                <option>~</option>
                                <option>31</option>
                            </select>
                            일
                        </div> --}}
                        {{-- 매년 --}}
                        <div class="d-inline-flex w-100 p-2 align-items-center">
                            매년
                            <select class="col-md-1 form-control form-control-sm ml-3">
                                <option>1</option>
                                <option>~</option>
                                <option>12</option>
                            </select>
                            월
                            <select class="col-md-1 form-control form-control-sm ml-3">
                                <option>1</option>
                                <option>~</option>
                                <option>31</option>
                            </select>
                            일
                        </div>
                    </fieldst>
                </div>
            </fieldset>
        </div>
        <div class="d-inline-flex col-md-6 p-2 align-items-center form-control-sm">
            <span class="font-weight-bold text-primary mx-auto">종료시간 : </span>
            <input type="date" class="form-control col-md-4" value="2000-01-01">
            <input type="time" class="form-control col-md-4" value="15:31:00">
        </div>
        <hr>
        {{-- 파라미터 --}}
        <div class="row mb-3">
            <fieldset class="cistp-fieldset">
                <legend>파라미터 입력</legend>
                <div class="col-md-12" id="proParams">
                    {{-- input의 placeholder에는 타입에 대한 설명이 나와야 하며 실제로는 파라미터 값을 입력 한다. --}}
                    <div class="d-inline-flex col-md-5 mb-2 ml-5">
                        <div class="col-md-3 small align-self-center text-center font-weight-bold">파라미터</div>
                        <input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm small" value="숫자"" readonly>
                        <input type="text" name="proParamSulmyungInput" class="col-md-7 form-control form-control-sm small" placeholder="설명" value="파라미터">
                    </div>
                    <div class="d-inline-flex col-md-5 mb-2 ml-5">
                        <div class="col-md-3 small align-self-center text-center font-weight-bold">파라미터</div>
                        <input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm small" value="문자" readonly>
                        <input type="text" name="proParamSulmyungInput" class="col-md-7 form-control form-control-sm small" placeholder="설명">
                    </div>
                </div>
            </fieldset>
        </div>
        {{-- 프로그램 --}}
        <div class="row mb-3">
            <fieldset class="cistp-fieldset">
                <legend>구성 프로그램</legend>
                <table class="table table table-bordered">
                    <colgroup>
                        <col width="5%" />
                        <col width="25%" />
                        <col width="62%" />
                        <col width="8%" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th>선택</th>
                            <th>프로그램 명</th>
                            <th>파라미터</th>
                            <th>재작업</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- 반복처리 --}}
                        <tr>
                            <td class="text-center"><input type="checkbox"></td>
                            <td>프로그램명</td>
                            <td class="text-wrap">
                                <div class="d-inline-flex col-md-5 mb-2 ml-3">
                                    <div class="col-md-4 small align-self-center text-center font-weight-bold">파라미터</div>
                                    <input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm small" value="숫자"" readonly>
                                    <input type="text" name="proParamSulmyungInput" class="col-md-7 form-control form-control-sm small" placeholder="설명" value="파라미터">
                                </div>
                                <div class="d-inline-flex col-md-5 mb-2 ml-3">
                                    <div class="col-md-4 small align-self-center text-center font-weight-bold">파라미터</div>
                                    <input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm small" value="문자" readonly>
                                    <input type="text" name="proParamSulmyungInput" class="col-md-7 form-control form-control-sm small" placeholder="설명">
                                </div>
                                <div class="d-inline-flex col-md-5 mb-2 ml-3">
                                    <div class="col-md-4 small align-self-center text-center font-weight-bold">파라미터</div>
                                    <input type="text" class="col-md-2 text-center align-self-center form-control form-control-sm small" value="숫자"" readonly>
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
            </fieldset>
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
</script>
