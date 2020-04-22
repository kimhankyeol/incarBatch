<!DOCTYPE html>
<html lang="en">
@include('popup.popupCommon.head')
{{-- js 라이브러리  --}}
@include('popup.popupCommon.popupJs')
<body class="bg-gradient-primary">
  <div id="content" class="gusung-popup">
    <div class="container-fluid">
      <h4 class="p-2 flex-grow-1 font-weight-bold text-white">잡-프로그램 구성</h4>
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="row">
            <div class="card shadow w-100 mb-2">
              <div class="card-body py-3">
                <div class="row">
                  <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">ID</div>
                  <input type="text" id="Job_UniqueName" class="col-md-2 form-control form-control-sm align-self-center" placeholder="job_10_02_15" readonly="">
                  <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">잡 명</div>
                  <input type="text" id="Job_Name" class="col-md-2 form-control form-control-sm align-self-center" value="job241" readonly="">
                  <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">설명</div>
                  <textarea type="text" id="Job_Sulmyung" class="col-md-5 form-control form-control-sm" readonly=""></textarea>
                </div>
              </div>
              <hr>
              <div class="card-body py-3">
                <div id="jobParm" class="row mx-auto">
                  <p class="my-auto px-1 small  jobParmNum"> 1 :</p>
                  <input type="text" class="form-control form-control-sm col-md-2" placeholder="YYYY" value="yyyy"/>
                  <p class="my-auto px-1 small  jobParmNum"> 2 :</p>
                  <input type="text" class="form-control form-control-sm col-md-2" placeholder="YYYY" value="mm"/>
                  <p class="my-auto px-1 small  jobParmNum"> 3 :</p>
                  <input type="text" class="form-control form-control-sm col-md-2" placeholder="YYYY" value="dd"/>
                  <p class="my-auto px-1 small  jobParmNum"> 4 :</p>
                  <input type="text" class="form-control form-control-sm col-md-2" placeholder="YYYY" value="tt"/>
                  {{-- <p class="my-auto px-1 small  jobParmNum"> 5 :</p>
                  <input type="text" class="form-control form-control-sm col-md-2" placeholder="YYYY" value="argv5"/>
                  <p class="my-auto px-1 small  jobParmNum"> 6 :</p>
                  <input type="text" class="form-control form-control-sm col-md-2" placeholder="YYYY" value="argv6"/>
                  <p class="my-auto px-1 small  jobParmNum"> 7 :</p>
                  <input type="text" class="form-control form-control-sm col-md-2" placeholder="YYYY" value="argv7"/>
                  <p class="my-auto px-1 small  jobParmNum"> 8 :</p>
                  <input type="text" class="form-control form-control-sm col-md-2" placeholder="YYYY" value="argv8"/>
                  <p class="my-auto px-1 small  jobParmNum"> 9 :</p>
                  <input type="text" class="form-control form-control-sm col-md-2" placeholder="YYYY" value="argv9"/>
                  <p class="my-auto px-1 small jobParmNum">10 :</p>
                  <input type="text" class="form-control form-control-sm col-md-2" placeholder="YYYY" value="argv10"/> --}}
                </div>
              </div>
            </div>
          </div>
          <div class="row">
              <!-- 프로그램 -->
              <div class="card shadow mb-2">
                <div class="d-flex justify-content-end card-header py-3">
                  <div class="d-none d-sm-inline-block form-inline ml-auto my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group align-items-center">
                        {{-- 대분류 중분류 선택 --}}
                        <h5 class="mb-0 font-weight-bold text-primary">프로그램</h5>
                        <div id="codeLargeView"></div>
                        <select class="form-control bg-light border-primary small">
                            <option>
                            프로그램 명
                            </option>
                            <option>
                            등록자
                            </option>
                        </select>
                        {{-- 검색 단어가 있을떄 없을때 구분  --}}
                        @if(!isset($searchWord))
                            <input id="searchWord" type="text" class="form-control bg-light border-primary small" placeholder="조회" aria-label="Search">
                        @elseif(isset($searchWord))
                            <input id="searchWord" type="text" value="{{$searchWord}}" class="form-control bg-light border-primary small" aria-label="Search">
                        @endif
                      <div class="input-group-append">
                          <div class="btn btn-primary cursor-pointer" onclick="process.popupSearch('1')">
                              <i class="fas fa-search fa-sm"></i>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body py-3">
                  <div class="table-responsive">
                    <table id="processList" class="table table-bordered" width="100%" cellspacing="0">
                      <colgroup>
                        <col width="0px" />
                        <col width="100px" />
                        <col width="100px" />
                        <col width="400px" />
                        <col width="100px" />
                      </colgroup>
                      <thead>
                        <tr>
                          <th></th>
                          <th>ID</th>
                          <th>프로그램 명</th>
                          <th>파라미터</th>
                          <th>등록자</th>
                        </tr>
                      </thead>
                      <tbody >
                        {{-- 내용 --}}
                        <tr onclick="selectRow(this)">
                          <td><input type="checkbox" class="list-group-item processChecks" value="ps_10_02_test"></td>
                          <td>ps_10_02_test</td>
                          <td>테스트</td>
                          <td>
                            <li class="d-block col-md-8 p-2 rounded-0" value="1" draggable="true">
                              <label class="m-0">
                                <input type="text" class="form-control form-control-sm w-auto d-inline-block" placeholder="YYYY"  value="YYYY" readonly>
                              </label>
                              <label class="m-0">
                                <input type="text" class="form-control form-control-sm w-auto d-inline-block" placeholder="MM"  value="MM" readonly>
                              </label>
                            </li>
                          </td>
                          <td>이지흠</td>
                        </tr>
                        <tr onclick="selectRow(this)">
                          <td><input type="checkbox" class="list-group-item processChecks" value="ps_10_02_addr"></td>
                          <td>ps_10_02_addr</td>
                          <td>추가</td>
                          <td>
                            <li class="d-block col-md-8 p-2 rounded-0" value="1" draggable="true">
                              <label class="m-0">
                                <input type="text" class="form-control form-control-sm w-auto d-inline-block" placeholder="YYYY" value="YYYY" readonly>
                              </label>
                              <label class="m-0">
                                <input type="text" class="form-control form-control-sm w-auto d-inline-block" placeholder="MM"  value="MM" readonly>
                              </label>
                              <label class="m-0">
                                <input type="text" class="form-control form-control-sm w-auto d-inline-block" placeholder="삼성화재 코드"  value="DD" readonly>
                              </label>
                            </li>
                          </td>
                          <td>이수연</td>
                        </tr>
                        <tr onclick="selectRow(this)">
                          <td><input type="checkbox" class="list-group-item processChecks" value="ps_10_02_del"></td>
                          <td>ps_10_02_del</td>
                          <td>삭제 프로그램</td>
                          <td>
                            <li class="d-block col-md-8 p-2 rounded-0" value="1" draggable="true">
                              <label class="m-0">
                                <input type="text" class="form-control form-control-sm w-auto d-inline-block" placeholder="YYYY" value="YYYY" readonly>
                              </label>
                            </li>
                          </td>
                          <td>김한결</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- /프로그램 -->
          </div>
          <div class="row">
            <div class="col-md-12 text-center">
              <button class="btn btn-primary" type="button" onclick="processAdd()"><i class="fa fa-arrow-down"></i></button>
              <button class="btn btn-danger" type="button" onclick="processDel()"><i class="fa fa-arrow-up"></i></button>
            </div>
          </div>
          <div class="row">
              <h5 class="mb-4 font-weight-bold text-primary">구성 리스트</h5>
              <div class="card shadow w-100 mb-2">
                <!-- List -->
                <div class="card-body">
                  {{-- 타이틀 --}}
                  <div class="row text-center">
                    <div class="right-line col-md-1 p-2 bg-primary text-white font-weight-bold rounded-0">순서</div>
                    <div class="right-line col-md-3 p-2 bg-primary text-white font-weight-bold rounded-0">프로그램 명</div>
                    <div class="right-line col-md-8 p-2 bg-primary text-white font-weight-bold rounded-0">파라미터</div>
                  </div>
                  <div id="gusungList"class="row px-0 gusungList">
                    {{-- 구성 리스트 --}}
                    <ul class="px-0 mb-0 w-100 d-inline-flex gusungData" draggable="true" onclick="selectRow(this)"><ll class="d-none"><input class="gusungChk" type="checkbox" value="ps_10_02_test"></ll><li class="list-group-item col-md-1 p-2 rounded-0 text-center h-100 align-self-center">1</li><li class="list-group-item col-md-3 p-2 rounded-0 h-100 align-self-center">테스트</li><li class="list-group-item col-md-8 p-2 rounded-0"><label class="m-0">YYYY<select class="form-control form-control-sm w-auto mx-3 d-inline-block"><option value="yyyy">yyyy</option><option value="mm">mm</option><option value="dd">dd</option><option value="tt">tt</option></select>MM<select class="form-control form-control-sm w-auto mx-3 d-inline-block"><option value="yyyy">yyyy</option><option value="mm">mm</option><option value="dd">dd</option><option value="tt">tt</option></select></label></li></ul>
                    <ul class="px-0 mb-0 w-100 d-inline-flex gusungData" draggable="true" onclick="selectRow(this)"><ll class="d-none"><input class="gusungChk" type="checkbox" value="ps_10_02_addr"></ll><li class="list-group-item col-md-1 p-2 rounded-0 text-center h-100 align-self-center">2</li><li class="list-group-item col-md-3 p-2 rounded-0 h-100 align-self-center">추가</li><li class="list-group-item col-md-8 p-2 rounded-0"><label class="m-0">YYYY<select class="form-control form-control-sm w-auto mx-3 d-inline-block"><option value="yyyy">yyyy</option><option value="mm">mm</option><option value="dd">dd</option><option value="tt">tt</option></select>MM<select class="form-control form-control-sm w-auto mx-3 d-inline-block"><option value="yyyy">yyyy</option><option value="mm">mm</option><option value="dd">dd</option><option value="tt">tt</option></select>DD<select class="form-control form-control-sm w-auto mx-3 d-inline-block"><option value="yyyy">yyyy</option><option value="mm">mm</option><option value="dd">dd</option><option value="tt">tt</option></select></label></li></ul>
                  </div>
                </div>
              </div>
              <div class="col-md-12 text-center">
                <button type="button" class="btn btn-info">등록</button>
                <button type="button" class="btn btn-danger">취소</button>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- 구성 추가 --}}
  <script>
  // 드래그 이동
    Sortable({
      els: '.gusungData',
      type: 'insert'
    });
    // Row 선택시 스타일 변경 및 체크
    function selectRow(obj) {
      if(obj.tagName == "UL") {
        var checkbox = obj.children[0].children[0];
        if (checkbox.checked) {
          for(var i=0; i< obj.childElementCount; i++) {
            obj.children[i].style.backgroundColor= "#fff";
          }
          checkbox.checked = false;
        } else {
          for(var i=0; i< obj.childElementCount; i++) {
            obj.children[i].style.backgroundColor= "#daddeb";
          }
          checkbox.checked = true;
        }
      } else if(obj.tagName == "TR"){
        var checkbox = obj.children[0].children[0];
        if (checkbox.checked) {
          obj.style.backgroundColor= "#fff";
          checkbox.checked = false;
        } else {
          obj.style.backgroundColor= "#daddeb";
          checkbox.checked = true;
        }
      }
    }

// 구성 리스트 추가 내용
    function processGusung(i) {
      var jobParm = document.getElementById("jobParm"),
      processList = document.getElementById("processList"),
      gusungList = document.getElementById("gusungList"),
      processChecks = document.getElementsByClassName("processChecks"),
      gusungData = document.getElementsByClassName("gusungData");
      
      var gusungRow = document.createElement('ul');
      var chkList = document.createElement('ll');
      var chk = document.createElement('input');
      var seqList = document.createElement('li');
      var nameList = document.createElement('li');
      var parmList = document.createElement('li');
      var parmSelect = document.createElement('select');

      gusungRow.className = "px-0 mb-0 w-100 d-inline-flex gusungData";
      gusungRow.draggable = "true";
      gusungRow.onclick = function () {selectRow(this)};
      chkList.className = "d-none";
      seqList.className = "list-group-item col-md-1 p-2 rounded-0 text-center h-100 align-self-center";
      nameList.className = "list-group-item col-md-3 p-2 rounded-0 h-100 align-self-center";
      parmList.className = "list-group-item col-md-8 p-2 rounded-0";
      parmSelect.className = "form-control form-control-sm w-auto mx-3 d-inline-block";
      {{-- 체크박스 --}}
      chk.className = "gusungChk";
      chk.type = "checkbox";
      chk.value = processChecks[i].value;
      chkList.appendChild(chk);
      {{-- 순서 --}}
      seqList.innerHTML = gusungData.length+1;
      {{-- 프로그램 명 --}}
      nameList.innerHTML = processChecks[i].parentElement.parentElement.children[2].textContent;
      {{-- 셀렉트 박스 --}}
      for(var j=1; j<jobParm.childElementCount; j=j+2) {
        var option = document.createElement('option');
        option.value = jobParm.children[j].value;
        option.textContent = jobParm.children[j].value;
        parmSelect.appendChild(option);
      }
      {{-- TEXT 설명 --}}
      var label = document.createElement('label');
      label.className = "m-0"
      for(var k=0; k < processChecks[i].parentElement.parentElement.children[3].children[0].childElementCount; k++) {
        var p = document.createTextNode(processChecks[i].parentElement.parentElement.children[3].children[0].children[k].children[0].value);
        label.appendChild(p.cloneNode(true));
        label.appendChild(parmSelect.cloneNode(true));
      }
      parmList.appendChild(label);
      gusungRow.appendChild(chkList);
      gusungRow.appendChild(seqList);
      gusungRow.appendChild(nameList);
      gusungRow.appendChild(parmList);
      gusungList.appendChild(gusungRow);
    }
// 프로세스 추가 스크립트
    function processAdd() {
      var jobParm = document.getElementById("jobParm"),
      processList = document.getElementById("processList"),
      gusungList = document.getElementById("gusungList"),
      processChecks = document.getElementsByClassName("processChecks"),
      gusungData = document.getElementsByClassName("gusungData");
      // 중복 체크 변수
      var duplChk = 0;
      // 프로세스 처음 추가 시
      if(gusungList.childElementCount == 0) {
        for(var i = 0; i < processChecks.length; i++) {
            if(processChecks[i].checked) {
              processGusung(i)
              processChecks[i].parentElement.parentElement.style.backgroundColor = "#fff"
              processChecks[i].checked = false;
            }
        }
      } else {
        var count = 0;
        for(var i = 0; i < processChecks.length; i++) {
          if(processChecks[i].checked) {
            var processVal = processChecks[i].value;
            for(var j =0; j< gusungList.childElementCount; j++) {
              var gusungVal = gusungList.children[j].children[0].children[0].value;
              if(processVal == gusungVal) {
                count++;
                continue;
              }
            }
          }
        }
        if(count == 0) {
          for(var i = 0; i < processChecks.length; i++) {
            if(processChecks[i].checked) {
              var processVal = processChecks[i].value;
              for(var j =0; j< gusungList.childElementCount; j++) {
                var gusungVal = gusungList.children[j].children[0].children[0].value;
                if(processVal == gusungVal) {
                  duplChk++;
                  continue;
                }
                for(var t = 0; t < gusungList.children[j].childElementCount; t++) {
                  gusungList.children[j].children[t].style.backgroundColor ="#fff";
                  gusungList.children[j].children[t].checked = false;
                }
              }
              if (duplChk == 0 ) {
                processGusung(i);
              }
              processChecks[i].parentElement.parentElement.style.backgroundColor = "#fff"
              processChecks[i].checked = false;
            }
          }
        } else {
          alert("프로그램을 중복 구성할 수 없습니다.")
        }
        
      }
    }
// 프로세스 삭제 스크립트
    function processDel() {
      const processChecks = document.getElementsByClassName("processChecks");
      const gusungData = document.getElementsByClassName("gusungData");
      const gusungChk = document.querySelectorAll(".gusungChk");
      const gusungArr = [];
      let answer = confirm("구성 해제 하시겠습니까?");
      if(answer) {
        let checkCount = 0;
        for(var i = 0; i < gusungData.length; i++) {
          if(gusungChk[i].checked) {
            gusungArr.push(gusungData[i]);
            checkCount++;
          }
        }
        for (var j=0; j < gusungArr.length; j++) {
          gusungArr[j].remove();
        }
        //gusungData[i].remove();
        for (var k = 0; k < gusungData.length; k++) {
          gusungData[k].children[1].textContent = k+1;
        }
        for(var t=0; t < processChecks.length; t++) {
          if(processChecks[t].checked){
            processChecks[t].parentElement.parentElement.style.backgroundColor = "#fff";
            processChecks[t].checked = false;
          }
        }
        if(checkCount == 0) {
          alert("선택된 프로그램이 없습니다.")
        }
      }
    }
  </script>

</body>
</html>