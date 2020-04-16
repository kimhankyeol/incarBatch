//프로세스
const process = {
    //조회
    search: function (page) {
        var searchWord = document.getElementById("searchWord").value;
        location.href =
            "/process/processListView?searchWord=" +
            searchWord +
            "&page=" +
            page;
    },
    //등록
    register: function () {
        var programName = document.getElementById("programName").value;
        var programExplain = document.getElementById("programExplain").value;
        var UseDb = document.getElementById("UseDb").value;
        console.log(programName);
        var path = "/home/incar/incarproject/program/"+programName;
        //var path = document.getElementById("path").value;
        //var gojungPath = "/home/incar/incarproject/";
        var Pro_YesangTime= process.timeCalc($('#Pro_YesangTime1').val(),$('#Pro_YesangTime2').val(),$('#Pro_YesangTime3').val());
        var Pro_YesangMaxTime= process.timeCalc($('#Pro_YesangMaxTime1').val(),$('#Pro_YesangMaxTime2').val(),$('#Pro_YesangMaxTime3').val());
        //파라미터 getElementsByName처리하는 부분
        var proParamType = document.getElementsByName("proParamType");
        const proParamSulmyungInput = document.getElementsByName("proParamSulmyungInput");
        const res1 = [];
        for (var i = 0; i < proParamSulmyungInput.length; i++) {
            res1.push(proParamSulmyungInput[i].value);
        }
        const Arr1 = res1.join("||");
        //유효성 검사 함수로
        var provalcheck = process.validation(programName,programExplain,UseDb,path,Pro_YesangTime,Pro_YesangMaxTime,proParamType,Arr1);
        if(provalcheck){
            var con = confirm("프로그램을 등록하시겠습니까?");
        if (con == true) {
            const paramArr1 = document.getElementsByName("proParamType");
            const paramArr2 = document.getElementsByName("proParamSulmyungInput");
            const res1 = [];
            const res2 = [];
            for (var i = 0; i < paramArr1.length; i++) {
                res1.push(paramArr1[i].value);
            }
            for (var i = 0; i < paramArr2.length; i++) {
                res2.push(paramArr2[i].value);
            }
            const paramStr1 = res1.join("\|\|");
            const paramStr2 = res2.join("\|\|");
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: "/process/processRegister",
                method: "post",
                data: {
                    programName: document.getElementById("programName").value,
                    programExplain: document.getElementById("programExplain").value,
                    retry: document.getElementById("retry").value,
                    UseDb: document.getElementById("UseDb").value,
                    path: path,
                    proParamType: paramStr1,
                    proParamSulmyungInput: paramStr2,
                    Pro_YesangTime : Pro_YesangTime,
                    Pro_YesangMaxTime : Pro_YesangMaxTime
                },
                success: function (data) {
                    console.table(data);
                    if(data.result==1&&data.fileResult==1){
                        location.href = "/process/processListView";
                        console.log("등록 되었습니다.");
                        console.table(data);
                    }else{
                        alert("경로에 파일이 존재하지 않습니다.");
                    }
                },
            });
        }
      }
    },
    //프로세스 유효성 검사
    validation:function(programName,programExplain,UseDb,path,Pro_YesangTime,Pro_YesangMaxTime,proParamType,Arr1){
        if (programName == "") {
            alert("프로그램 명을 입력하세요");
            return false;
        } else if (programExplain == "") {
            alert("프로그램 설명을 입력하세요");
            return false;
        } else if (UseDb == "") {
            alert("프로그램 사용 DB를 입력하세요");
            return false;
        } else if (path == "") {
            alert("프로그램 경로를 입력하세요");
            return false;
        } else if (Pro_YesangTime == "") {
            alert("프로그램 예상 시간을 입력하세요");
            return false;
        } else if (Pro_YesangMaxTime == "") {
            alert("프로그램 최대 예상 시간을 입력하세요");
            return false;
        } else if(parseInt(Pro_YesangMaxTime)<parseInt(Pro_YesangTime)){
            alert('프로그램 예상 시간이 프로그램 최대 예상 시간보다 길 수 없습니다. ');
            return false;
        } else if(proParamType.length == 0){
            var con = confirm("프로그램 파라미터가 없습니다. 이대로 진행하시겠습니까?");
            if (con) {
                return true;
            }else{
                return false;
            }
        } else if (proParamType.length != 0) {
            //Arr2에 /를 기준으로 split하여 저장. split 사용하면 나누어진 문자열은 각각 배열로 들어감
            var Arr2 = Arr1.split("||");
            for (var i = 0; i < Arr2.length; i++) {
                if (Arr2[i] == "") {
                    alert("파라미터 설명을 입력하세요");
                    return false;
                }
            }
        }
        return true;
    },
    timeCalc:function(d,h,m){
        if(d==""&&h==""&&m==""){
          return 0;
        }else if(d!=""&&h==""&&m==""){
          return parseInt(d)*24*60;
        }else if(d==""&&h!=""&&m==""){
          return parseInt(h)*60
        }else if(d==""&&h==""&&m!=""){
          return parseInt(m)
        }else if(d!=""&&h!=""&&m==""){
          return parseInt(d)*24*60+parseInt(h)*60;
        }else if(d==""&&h!=""&&m!=""){
          return parseInt(h)*60+parseInt(m);
        }else if(d!=""&&h!=""&&m!=""){
          return parseInt(d)*24*60+parseInt(h)*60+parseInt(m);
        }
      },
    //수정
    update: function () {},
    //삭제
    delete: function () {},
    //파라미터 추가
    addDivParam: function () {
        var proParamDiv = document.createElement("div");
        var proParamDiv2 = document.createElement("div");
        var delBtnDiv = document.createElement("div");
        //onchange 걸어야됨
        var proParamInputText =
            '<select name="proParamType" class="col-md-2 form-control form-control-sm" > <option value="paramDate">날짜</option><option value="paramNum">숫자</option><option value="paramStr">문자</option></select>' +
            '<input type="text" name="proParamSulmyungInput" class="col-md-6 form-control form-control-sm" placeholder="설명">';
        proParamDiv.className = "d-inline-flex w-50 delYN mb-2";
        proParamDiv2.className = "col-md-3 small align-self-center text-center";
        proParamDiv2.innerHTML = "파라미터";
        delBtnDiv.className =
            "delParam btn-danger  form-control form-control-sm col-md-1 text-center";
        delBtnDiv.onclick = process.deleteDivParam;
        delBtnDiv.innerText = "삭제";
        proParamDiv.appendChild(proParamDiv2);
        proParamDiv.innerHTML += proParamInputText;
        proParamDiv.appendChild(delBtnDiv);
        document.getElementById("proParams").appendChild(proParamDiv);
        document.getElementById("proParams").scrollIntoView();
    },
    //파라미터 삭제
    deleteDivParam: function () {
        var delIndex = $(".delParam").index(this);
        $(".delYN").eq(delIndex).remove();
    },
};