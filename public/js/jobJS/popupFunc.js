const popup = {
  // Row 선택시 스타일 변경 및 체크
  selectRow: function (obj) {
    if (obj.tagName == "UL") {
      var checkbox = obj.children[0].children[0];
      if (checkbox.checked) {
        for (var i = 0; i < obj.childElementCount; i++) {
          obj.children[i].style.backgroundColor = "#fff";
        }
        checkbox.checked = false;
      } else {
        for (var i = 0; i < obj.childElementCount; i++) {
          obj.children[i].style.backgroundColor = "#daddeb";
        }
        checkbox.checked = true;
      }
    } else if (obj.tagName == "TR") {
      var checkbox = obj.children[0].children[0];
      if (checkbox.checked) {
        obj.style.backgroundColor = "#fff";
        checkbox.checked = false;
      } else {
        obj.style.backgroundColor = "#daddeb";
        checkbox.checked = true;
      }
    }
  },
  // 구성 리스트 추가 내용
  processGusung: function (i) {
    var jobParm = document.getElementById("jobParm"),
      gusungList = document.getElementById("gusungList"),
      processChecks = document.getElementsByClassName("processChecks"),
      gusungData = document.getElementsByClassName("gusungData");

    var gusungRow = document.createElement('ul'),
      chkList = document.createElement('ll'),
      chk = document.createElement('input'),
      seqList = document.createElement('li'),
      pathList = document.createElement('li'),
      proList = document.createElement('li'),
      nameList = document.createElement('li'),
      parmList = document.createElement('li'),
      parmSelect = document.createElement('select');

    gusungRow.className = "px-0 mb-0 w-100 d-inline-flex gusungData"
    gusungRow.draggable = "true";
    gusungRow.onclick = function () { popup.selectRow(this); };
    chkList.className = "d-none";
    seqList.className = "list-group-item d-inline-flex col-md-1 p-2 rounded-0 text-center h-100 align-items-center justify-content-center";
    pathList.className = "list-group-item d-inline-flex col-md-1 p-2 rounded-0 h-100 align-items-center";
    proList.className = "list-group-item d-inline-flex col-md-1 p-2 rounded-0 h-100 align-items-center";
    nameList.className = "list-group-item d-inline-flex col-md-1 p-2 rounded-0 h-100 align-items-center";
    parmList.className = "list-group-item col-md-8 p-2 rounded-0";
    parmSelect.className = "form-control form-control-sm w-25 d-inline-block parmSelect";
    //체크박스
    chk.className = "gusungChk";
    chk.type = "checkbox";
    chk.value = processChecks[i].value;
    chkList.appendChild(chk);
    //순서
    seqList.innerHTML = gusungData.length + 1;
    // {{-- 경로 --}}
    pathList.innerHTML = processChecks[i].parentElement.parentElement.children[1].textContent;
    // {{-- 프로그램 --}}
    proList.innerHTML = processChecks[i].parentElement.parentElement.children[2].textContent;
    // {{-- 프로그램 명 --}}
    nameList.innerHTML = processChecks[i].parentElement.parentElement.children[3].textContent;
    // {{-- 셀렉트 박스 --}}
    var selectCount = 0;
    for (var j = 0; j < jobParm.childElementCount; j += 2) {
      var option = document.createElement('option');
      if (jobParm.children[j + 1].value) {
        option.value = j == 0 ? 0 : (j / 2);
        option.textContent = jobParm.textContent.trim().split(' ')[selectCount] + ' ' + jobParm.children[j + 1].value;
        parmSelect.appendChild(option);
        selectCount++;
      }
    }
    // {{-- TEXT 설명 --}}
    var label = document.createElement('label');
    label.className = "m-0 w-100"
    for (var k = 0; k < processChecks[i].parentElement.parentElement.children[4].children[0].children[0].childElementCount; k++) {
      var gusungValue = document.createElement('input');
      gusungValue.className = "form-control form-control-sm w-auto d-inline-block border-0 bg-transparent shadow-none"
      gusungValue.type = "text"
      gusungValue.value = (k + 1) + ') ' + processChecks[i].parentElement.parentElement.children[4].children[0].children[0].children[k].value;
      //gusungValue.appendChild(p)
      label.appendChild(gusungValue.cloneNode(true));
      for (var t = 0; t < processChecks[i].parentElement.parentElement.children[4].children[0].children[0].childElementCount; t++) {
        parmSelect[t].removeAttribute("selected")
      }
      parmSelect[k].setAttribute("selected", true)
      label.appendChild(parmSelect.cloneNode(true));
    }
    parmList.appendChild(label);
    gusungRow.appendChild(chkList);
    gusungRow.appendChild(seqList);
    gusungRow.appendChild(pathList);
    gusungRow.appendChild(proList);
    gusungRow.appendChild(nameList);
    gusungRow.appendChild(parmList);
    gusungList.appendChild(gusungRow);
  },
  // 프로세스 추가 스크립트
  processAdd: function () {
    var jobParm = document.getElementById("jobParm"),
      processList = document.getElementById("processList"),
      gusungList = document.getElementById("gusungList"),
      processChecks = document.getElementsByClassName("processChecks"),
      gusungData = document.getElementsByClassName("gusungData");
    // 잡 파라미터 개수 체크
    var jobParmCount = 0;
    for (var i = 1; i < jobParm.childElementCount; i += 2) {
      if (jobParm.children[i].value) {
        jobParmCount++;
      }
    }
    // 중복 체크 변수
    var duplChk = 0;
    // 프로세스 처음 추가 시
    if (gusungList.childElementCount == 0) {
      for (var i = 0; i < processChecks.length; i++) {
        if (processChecks[i].checked) {
          if (jobParmCount < processChecks[i].parentElement.parentElement.children[4].children[0].children[0].childElementCount) {
            alert("파라미터의 개수가 맞지 않습니다.")
            return false;
          } else {
            popup.processGusung(i)
            processChecks[i].parentElement.parentElement.style.backgroundColor = "#fff"
            processChecks[i].checked = false;
          }
        }
      }
    } else {
      var count = 0;
      for (var i = 0; i < processChecks.length; i++) {
        if (processChecks[i].checked) {
          var processVal = processChecks[i].value;
          for (var j = 0; j < gusungList.childElementCount; j++) {
            var gusungVal = gusungList.children[j].children[0].children[0].value;
            if (processVal == gusungVal) {
              count++;
              continue;
            }
          }
        }
      }
      if (count == 0) {
        for (var i = 0; i < processChecks.length; i++) {
          if (processChecks[i].checked) {
            if (jobParmCount < processChecks[i].parentElement.parentElement.children[4].children[0].children[0].childElementCount) {
              alert("파라미터의 개수가 맞지 않습니다.")
              return false;
            } else {
              var processVal = processChecks[i].value;
              for (var j = 0; j < gusungList.childElementCount; j++) {
                var gusungVal = gusungList.children[j].children[0].children[0].value;
                if (processVal == gusungVal) {
                  duplChk++;
                  continue;
                }
                for (var t = 0; t < gusungList.children[j].childElementCount; t++) {
                  gusungList.children[j].children[t].style.backgroundColor = "#fff";
                  gusungList.children[j].children[t].checked = false;
                }
              }
              if (duplChk == 0) {
                popup.processGusung(i);
              }
              processChecks[i].parentElement.parentElement.style.backgroundColor = "#fff"
              processChecks[i].checked = false;
            }
          }
        }
      } else {
        alert("프로그램을 중복 구성할 수 없습니다.")
      }
    }
    Sortable({ els: '.gusungData', type: 'insert' });
  },
  // 프로세스 삭제 스크립트
  processDel: function () {
    const processChecks = document.getElementsByClassName("processChecks"),
      gusungData = document.getElementsByClassName("gusungData"),
      gusungChk = document.querySelectorAll(".gusungChk"),
      gusungArr = [];
    let answer = confirm("구성 해제 하시겠습니까?");
    if (answer) {
      let checkCount = 0;
      for (var i = 0; i < gusungData.length; i++) {
        if (gusungChk[i].checked) {
          gusungArr.push(gusungData[i]);
          checkCount++;
        }
      }
      for (var j = 0; j < gusungArr.length; j++) {
        gusungArr[j].remove();
      }
      for (var k = 0; k < gusungData.length; k++) {
        gusungData[k].children[1].textContent = k + 1;
      }
      for (var t = 0; t < processChecks.length; t++) {
        if (processChecks[t].checked) {
          processChecks[t].parentElement.parentElement.style.backgroundColor = "#fff";
          processChecks[t].checked = false;
        }
      }
      if (checkCount == 0) {
        alert("선택된 프로그램이 없습니다.")
      }
    }
  },
  //검색 스크립트
  search: function (page) {
    var searchWord = $('#searchWord').val();
    var WorkLarge = $('#workLargeVal option:selected').val();
    var WorkMedium = $('#workMediumVal option:selected').val();
    if (searchWord == "") {
      searchWord = "searchWordNot";
    }
    $.ajax({
      url: "/popup/popupPsSearch",
      method: "get",
      data: {
        'page': page,
        'searchWord': searchWord,
        'WorkLarge': WorkLarge,
        'WorkMedium': WorkMedium
      },
      success: function (resp) {
        $('#processdatatable').html(resp.returnHTML)
      }
    })
  },
  // 구성 등록 스크립트
  gusungAdd: function (Job_Seq) {
    var gusungData = []
    var gusungProcess = []
    var gusungDataArr = []
    const addYN = confirm("등록 하시겠습니까?")
    if (addYN) {
      for (var i = 0; i < document.getElementsByClassName("gusungData").length; i++) {
        gusungProcess.push(document.getElementsByClassName("gusungData")[i].children[0].children[0].value);
        gusungDataArr[i] = new Array();
        for (var j = 1; j < document.getElementsByClassName("gusungData")[i].children[5].children[0].childElementCount; j += 2) {
          gusungDataArr[i][parseInt(j / 2)] = document.getElementsByClassName("gusungData")[i].children[5].children[0].children[j].value;
        }
        gusungData.push(gusungDataArr[i].join("||"));
      }
      console.log(Job_Seq)
      console.log(gusungProcess)
      console.log(gusungData)
      $.ajax({
        url: "/popup/jobGusungModify",
        method: "get",
        data: {
          "Job_Seq": Job_Seq,
          "gusungProcess": gusungProcess,
          "gusungData": gusungData
        },
        success: function (data) {
         console.table(data);
          return alert("등록 되었습니다."), window.close();
        }
      })
    } else {
      return false;
    }
  }
}