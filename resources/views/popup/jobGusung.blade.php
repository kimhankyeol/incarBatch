<!DOCTYPE html>
<html lang="en">
@include('popup.popupCommon.head')
{{-- js 라이브러리  --}}
@include('popup.popupCommon.popupJs')
<body class="bg-gradient-primary">
<div id="content" class="gusung-popup">
    <div class="container-fluid">
      <h4 class="p-2 flex-grow-1 font-weight-bold text-white">잡 구성</h4>
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="row">
            <div class="col-md-8">
              <!-- 프로그램 -->
            <h5 class="mb-4 font-weight-bold text-primary">프로그램</h5>
              <div class="card shadow mb-4">
                <div class="d-flex justify-content-end card-header py-3">
                  <div class="d-none d-sm-inline-block form-inline ml-auto my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group align-items-center">
                        {{-- 대분류 중분류 선택 --}}
                        <div id="codeLargeView" class="list-code"></div>
                        <select class="form-control bg-light border-primary small">
                            <option>
                            프로그램 명
                            </option>
                        </select>
                        {{-- 검색 단어가 있을떄 없을때 구분  --}}
                        @if(!isset($searchWord))
                            <input id="searchWord" type="text" class="form-control bg-light border-primary small" placeholder="조회" aria-label="Search">
                        @elseif(isset($searchWord))
                            <input id="searchWord" type="text" value="{{$searchWord}}" class="form-control bg-light border-primary small" aria-label="Search">
                        @endif
                      <div class="input-group-append">
                          <div class="btn btn-primary cursor-pointer" onclick="popup.popupPsSearch('1')">
                              <i class="fas fa-search fa-sm"></i>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body py-3">
                  <div class="table-responsive">
                    @include('popup.processSearchList')
                  </div>
                </div>
              </div>
              <!-- /프로그램 -->
            </div>
            <div class="col-md-1 align-self-center text-center p-0">
              <button class="btn btn-primary my-2" type="button" onclick="processAdd()"><i class="fa fa-arrow-right"></i></button>
              <button class="btn btn-danger my-2" type="button" onclick="processDel()"><i class="fa fa-arrow-left"></i></button>
            </div>
            <div class="col-md-3">
            <h5 class="mb-4 font-weight-bold text-primary">{{$jobName}}에 대한 구성 리스트</h5>
              <div class="row mx-0 overflow-auto">
                <!-- List -->
                <div class="col-md-3 px-0" style="height:500px">
                  <ul id="gusungNum" class="list-group text-center gusungNum">
                    @if(isset($jobGusungContents))
                      @foreach($jobGusungContents as $jobCont)
                        <li class="list-group-item gusungNum">{{$jobCont->JobGusung_Order}}</li>
                      @endforeach
                    @endIf
                  </ul>
                </div>
                <div class="col-md-9 px-0" style="height:500px">
                  <ul id="gusungList"class="drag-sort-enable list-group">
                    @if(isset($jobGusungContents))
                      @foreach($jobGusungContents as $jobCont)
                        <li class="list-group-item cursor-pointer P_SeqArr" onclick="enableDragSort('drag-sort-enable'); selectRow(this);" value="{{$jobCont->P_Seq}}" draggable="true">{{$jobCont->P_Name}}<input type="checkbox" class="custom-control-input gusungChk" value="{{$jobCont->Job_Seq}}"></li>
                      @endforeach
                    @endIf
                  </ul>
                </div>
              </div>
              <div class="row px-0 justify-content-end">
                <button type="button" class="mr-2 btn btn-info" onclick="jobGusungModify('{{$_GET['Job_Seq']}}')">등록</button>
                <button type="button" class="mr-2 btn btn-danger">취소</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<script>
function jobGusungModify(Job_Seq){
  var P_SeqArr="";
  P_SeqArr = $('.P_SeqArr').map(function(){
                  return $(this).val();
                }).get().join('\|\|');
  console.log(P_SeqArr);
  if(P_SeqArr==0){
    alert('하나의 잡에는 한 개 이상의 잡이 구성되어야합니다.');
    return false;
  }else{
    $.ajax({
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      url : "/popup/jobGusungModify",
      method:'POST',
      data:{
        "Job_Seq":Job_Seq,
        "P_SeqArr":P_SeqArr
      },success:function(resp){
        alert('성공');
        close();

      },error:function(err){

      }
    })
  }
}
  // jobJS/codeFunc 대분류 조회
  code.workLargeCtg();
</script>

  <!-- Sort Table -->
  <script type="text/javascript">
    function enableDragSort(listClass) {
      const sortableLists = document.getElementsByClassName(listClass);
      Array.prototype.map.call(sortableLists, (list) => {
        enableDragList(list)
      });
    }
  
    function enableDragList(list) {
      Array.prototype.map.call(list.children, (item) => {
        enableDragItem(item)
      });
    }
  
    function enableDragItem(item) {
      item.setAttribute('draggable', true)
      item.ondrag = handleDrag;
      item.ondragend = handleDrop;
    }
  
    function handleDrag(item) {
      const selectedItem = item.target,
        list = selectedItem.parentNode,
        x = event.clientX,
        y = event.clientY;
  
      selectedItem.classList.add('drag-sort-active');
      let swapItem = document.elementFromPoint(x, y) === null ? selectedItem : document.elementFromPoint(x, y);
  
      if (list === swapItem.parentNode) {
        swapItem = swapItem !== selectedItem.nextSibling ? swapItem : swapItem.nextSibling;
        list.insertBefore(selectedItem, swapItem);
      }
    }
  
    function handleDrop(item) {
      item.target.classList.remove('drag-sort-active');
    }
    (() => {
      enableDragSort('drag-sort-enable')
    })();
  </script>
  {{-- 구성 추가 --}}
  <script>
    function selectRow(obj) {
      if(obj.tagName == "LI") {
        var checkbox = obj.children[0];
        if (checkbox.checked) {
          obj.style.backgroundColor= "#fff";
          checkbox.checked = false;
        } else {
          obj.style.backgroundColor= "#daddeb";
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
  // 프로세스 추가 스크립트
    function processAdd() {
      var processList = document.getElementById("processList"),
      gusungNum = document.getElementById("gusungNum"),
      gusungList = document.getElementById("gusungList"),
      checkboxes = document.getElementsByClassName("list-group-item"),
      listItems = document.getElementsByClassName("gusungNum");
      var duplSum = 0;
      // 프로세스 처음 추가 시
      if(gusungList.childElementCount == 0) {
        checkedCount = 1;
        for(var i = 0; i < checkboxes.length; i++) {
            if(checkboxes[i].checked) {
              const processSeq = checkboxes[i].parentNode.parentNode.children[1].textContent;
              const processName = checkboxes[i].parentNode.parentNode.children[2].textContent;
              const newNum = document.createElement("li");
              newNum.setAttribute("class","list-group-item gusungNum");
              newNum.appendChild(document.createTextNode(listItems.length));
              const newLi = document.createElement("li");
              newLi.setAttribute("class","list-group-item cursor-pointer P_SeqArr");
              newLi.setAttribute("onclick","enableDragSort('drag-sort-enable'); selectRow(this);");
              newLi.setAttribute("value",processSeq);
              newLi.appendChild(document.createTextNode(processName));
              const newCheck = document.createElement("input");
              newCheck.setAttribute("type","checkbox");
              newCheck.setAttribute("class","custom-control-input gusungChk");
              newCheck.setAttribute("value",processSeq);
              gusungNum.appendChild(newNum);
              newLi.appendChild(newCheck);
              gusungList.appendChild(newLi);
            }
        }
      } else {
        for(var i = 0; i < checkboxes.length; i++) {
          if(checkboxes[i].checked) {
            var duplCount = 0;
            const processSeq = checkboxes[i].parentNode.parentNode.children[1].textContent;
            const processName = checkboxes[i].parentNode.parentNode.children[2].textContent;
            for(var j = 0; j < gusungList.childElementCount; j++) {
              const gusungSeq = gusungList.children[j].value;
              if(gusungSeq == processSeq) {
                duplCount++;
                continue;
              }
            }
            if(duplCount==0) {
              const newNum = document.createElement("li");
              newNum.setAttribute("class","list-group-item gusungNum");
              newNum.appendChild(document.createTextNode(listItems.length));
              const newLi = document.createElement("li");
              newLi.setAttribute("class","list-group-item cursor-pointer  P_SeqArr");
              newLi.setAttribute("onclick","enableDragSort('drag-sort-enable'); selectRow(this);");
              newLi.setAttribute("value",processSeq);
              newLi.appendChild(document.createTextNode(processName));
              const newCheck = document.createElement("input");
              newCheck.setAttribute("type","checkbox");
              newCheck.setAttribute("class","custom-control-input gusungChk");
              newCheck.setAttribute("value",processSeq);

              gusungNum.appendChild(newNum);
              newLi.appendChild(newCheck);
              gusungList.appendChild(newLi);
              listItems.length++;
            } else {
              alert("프로그램을 중복 구성 할 수 없습니다.");
              return false;
            }
          }
        }
      }
      for(var i = 0; i < checkboxes.length; i++) {
        if(checkboxes[i].checked) {
          checkboxes[i].checked = false;
          checkboxes[i].parentNode.parentNode.style.backgroundColor= "#fff";
        }
      }
      enableDragSort('drag-sort-enable')
    }
// 프로세스 삭제 스크립트
    function processDel() {
      const gusungNum = document.getElementsByClassName("gusungNum");
      const gusungChk = document.getElementsByClassName("gusungChk");
      const gusungChk2 = document.querySelectorAll(".gusungChk");
      const gusungChkLen = document.getElementsByClassName("gusungChk").length;
      let answer = confirm("구성 해제 하시겠습니까?");
      if(answer) {
        let checkCount = 0;
        for(var i = 0; i < gusungChk.length; i++) {
          if(gusungChk[i].checked) {
            checkCount++;
          }
        }
        while(checkCount>0) {
          gusungNum[(gusungNum.length-1)].remove();
          checkCount--;
        }
        for(var k in gusungChk2) {
          if(gusungChk2[k].checked == true) {
            gusungChk2[k].parentNode.remove();
          }
        }
      }
    }
  </script>


</body>
</html>