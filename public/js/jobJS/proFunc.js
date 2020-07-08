//프로세스
const process = {
    //조회
    search: function () {
        var searchWord = $('#searchWord').val();
        var WorkLarge = $('#workLargeVal option:selected').val();
        var WorkMedium = $('#workMediumVal option:selected').val();
        // 대분류 , 중분류 전체 선택일때 아닐떄 경우의 수
        location.href = "/process/processListView?searchWord=" + searchWord + "&WorkLarge=" + WorkLarge + "&WorkMedium=" + WorkMedium +"&page=1"
    },
    //등록
    register: function () {

        $('#workLargeVal').removeAttr("disabled", "disabled");
        $('#workMediumVal').removeAttr("disabled", "disabled");

        //체크박스 체크되어 있으면 1, 아니면 0으로 val설정
        if ($("#retry").is(":checked")) {
            $("#retry").val(1);
        } else {
            $("#retry").val(0);
        }
        if ($("#P_TextInputCheck").is(":checked")) {
            $("#P_TextInputCheck").val(1);
        } else {
            $("#P_TextInputCheck").val(0);
        }
        if ($("#P_FileOutputCheck").is(":checked")) {
            $("#P_FileOutputCheck").val(1);
        } else {
            $("#P_FileOutputCheck").val(0);
        }
        if ($("#P_PrivateCheck").is(":checked")) {
            $("#P_PrivateCheck").val(1);
        } else {
            $("#P_PrivateCheck").val(0);
        }
        P_PrivateCheck
        var WorkLarge = $('#workLargeVal option:selected').val();
        var WorkMedium = $('#workMediumVal option:selected').val();

        var processPath = document.getElementById("processPath").value;
        var processFile = document.getElementById("processFile").value;
        //var UseDb = document.getElementById("UseDb").value;
        var retry = $("#retry").val();

        var programName = document.getElementById("programName").value;
        var programExplain = document.getElementById("programExplain").value;
        // 프로그램 개발자 ID
        var P_DevId = "1611700";
        var P_TextInputCheck = $('#P_TextInputCheck').val();
        var P_FileOutputCheck = $('#P_FileOutputCheck').val();
        var P_PrivateCheck = $('#P_PrivateCheck').val();
     
  
        //시간계산 분단위 ()
        if ($('#Pro_YesangTime1').val() == "") {
            $('#Pro_YesangTime1').val(0);
        }
        if ($('#Pro_YesangTime2').val() == "") {
            $('#Pro_YesangTime2').val(0);
        }
        if ($('#Pro_YesangTime3').val() == "") {
            $('#Pro_YesangTime3').val(0);
        }
        if ($('#Pro_YesangMaxTime1').val() == "") {
            $('#Pro_YesangMaxTime1').val(0);
        }
        if ($('#Pro_YesangMaxTime2').val() == "") {
            $('#Pro_YesangMaxTime2').val(0);
        }
        if ($('#Pro_YesangMaxTime3').val() == "") {
            $('#Pro_YesangMaxTime3').val(0);
        }
        var Pro_YesangTime=parseInt($('#Pro_YesangTime1').val()*1440)+parseInt($('#Pro_YesangTime2').val()*60)+parseInt($('#Pro_YesangTime3').val());
        var Pro_YesangMaxTime=parseInt($('#Pro_YesangMaxTime1').val()*1440)+parseInt($('#Pro_YesangMaxTime2').val()*60)+parseInt($('#Pro_YesangMaxTime3').val());
        //파라미터 getElementsByName처리하는 부분
        var proParamType = document.getElementsByName("proParamType");
        const proParamSulmyungInput = document.getElementsByName("proParamSulmyungInput");
        const res1 = [];
        const res2 = [];

        for (var i = 0; i < proParamType.length; i++) {
            res1.push(proParamType[i].value);
        }
        for (var i = 0; i < proParamSulmyungInput.length; i++) {
            res2.push(proParamSulmyungInput[i].value);
        }
        const Arr1 = res1.join("||"); //type
        const Arr2 = res2.join("||"); //input
        //     //유효성 검사 함수로
        //var provalcheck = process.validation(WorkLarge, WorkMedium, UseDb, processFile, programName, programExplain, Pro_YesangTime, Pro_YesangMaxTime, proParamType, Arr2);
        var provalcheck = process.validation(WorkLarge, WorkMedium, processFile, programName, programExplain, Pro_YesangTime, Pro_YesangMaxTime, proParamType, Arr2);
        if (provalcheck) {
            var con = confirm("프로그램을 등록하시겠습니까?");
            if (con == true) {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    url: "/process/processRegister",
                    async:false,
                    method: "post",
                    data: {
                        WorkLarge: WorkLarge,
                        WorkMedium: WorkMedium,
                        processPath: processPath,
                        processFile: processFile,
                        //UseDb: UseDb,
                        retry: retry,
                        programName: programName,
                        programExplain: programExplain,
                        Pro_YesangTime: Pro_YesangTime,
                        Pro_YesangMaxTime: Pro_YesangMaxTime,
                        proParamType: Arr1,
                        proParamSulmyungInput: Arr2,
                        P_TextInputCheck: P_TextInputCheck,
                        P_FileOutputCheck: P_FileOutputCheck,
                        P_PrivateCheck:P_PrivateCheck,
                        P_DevId: P_DevId
                    },
                    success: function (data) {
                       if(data.msg=="success"){
                            alert('프로그램을 등록하였습니다.');
                            location.href="/process/processListView?page=1"
                       }else if(data.msg=="failed"){
                           var result = confirm('프로그램 등록을 실패했습니다. \n 프로그램 목록화면으로 돌아가겠습니까?');
                           if(result){
                            location.href="/process/processListView?page=1";
                           }else{
                               return false;
                           }
                       }else if(data.msg=="fileNotFound"){
                            var result = confirm('서버내의 프로그램 파일이 존재하지 않습니다. \n 프로그램 목록화면으로 돌아가겠습니까?');
                            if(result){
                                location.href="/process/processListView?page=1";
                            }else{
                                return false;
                            }
                       }
                    },
                });
            }
        }
    },
    //db 업데이트
    update: function (parm) {
        if ($("#retry").is(":checked")) {
            $("#retry").val(1);
        } else {
            $("#retry").val(0);
        }
        var p_seq = $('#P_Seq').val();
        var processFile = $('#processFile').val();
        var programName = $('#programName').val();
        var programExplain = $('#programExplain').val();
        var WorkLarge = $('#P_WorkLargeCtg').val();
        var WorkMedium = $('#P_WorkMediumCtg').val();
        //var UseDb = $('#UseDb').val();
        var retry = $("#retry").val();
        var P_UpdIP = $('#P_UpdIP').val();
        var P_UpDate = $('#P_UpDate').val();
        //시간계산 분단위 ()
        if ($('#Pro_YesangTime1').val() == "") {
            $('#Pro_YesangTime1').val(0);
        }
        if ($('#Pro_YesangTime2').val() == "") {
            $('#Pro_YesangTime2').val(0);
        }
        if ($('#Pro_YesangTime3').val() == "") {
            $('#Pro_YesangTime3').val(0);
        }
        if ($('#Pro_YesangMaxTime1').val() == "") {
            $('#Pro_YesangMaxTime1').val(0);
        }
        if ($('#Pro_YesangMaxTime2').val() == "") {
            $('#Pro_YesangMaxTime2').val(0);
        }
        if ($('#Pro_YesangMaxTime3').val() == "") {
            $('#Pro_YesangMaxTime3').val(0);
        }

        var Pro_YesangTime=parseInt($('#Pro_YesangTime1').val()*1440)+parseInt($('#Pro_YesangTime2').val()*60)+parseInt($('#Pro_YesangTime3').val());
        var Pro_YesangMaxTime=parseInt($('#Pro_YesangMaxTime1').val()*1440)+parseInt($('#Pro_YesangMaxTime2').val()*60)+parseInt($('#Pro_YesangMaxTime3').val());
        //파라미터 getElementsByName처리하는 부분
        // var proParamType = document.getElementsByName("proParamType");
        // const proParamSulmyungInput = document.getElementsByName("proParamSulmyungInput");
        // const res1 = [];
        // const res2 = [];

        // for (var i = 0; i < proParamType.length; i++) {
        //     res1.push(proParamType[i].value);
        // }
        // for (var i = 0; i < proParamSulmyungInput.length; i++) {
        //     res2.push(proParamSulmyungInput[i].value);
        // }
        // const Arr1 = res1.join("||"); //type
        // const Arr2 = res2.join("||"); //input
        //유효성 true로 타기위해
        var proParamType='update';
        var proParamSulmyungInput='update';
        //유효성 검사 함수로
        var provalcheck = process.validation(WorkLarge, WorkMedium, processFile, programName, programExplain, Pro_YesangTime, Pro_YesangMaxTime, proParamType, proParamSulmyungInput);
        if (provalcheck) {
            if (parm == "upd") {
                var con = confirm("프로그램을 수정 하시겠습니까?");
                var P_DeleteYN = "1";
            } else if (parm == "del") {
                var con = confirm("프로그램을 삭제 하시겠습니까?");
                var P_DeleteYN = "0";
            }
            if (con == true) {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    url: "/process/processEdit",
                    method: "post",
                    async:false,
                    data: {
                        p_seq: p_seq,
                        processFile:processFile,
                        P_UpdIP: P_UpdIP,
                        P_UpDate: P_UpDate,
                        retry: retry,
                        // proParamType: Arr1,
                        // proParamSulmyungInput: Arr2,
                        Pro_YesangTime: Pro_YesangTime,
                        Pro_YesangMaxTime: Pro_YesangMaxTime,
                        programName: programName,
                        programExplain:programExplain,
                        P_DeleteYN: P_DeleteYN
                    },
                    success: function (data) {
                        if(data.proUsed=="used"){
                            alert("사용중인 프로그램은 수정이 불가합니다.");
                            return false;
                        }else{
                            if (data.result == 1) {
                                alert("프로그램이 수정되었습니다.");
                            } else {
                                alert("프로그램 변경사항이 없습니다.");
                            }
                            location.href = "/process/processDetailView?P_Seq=" + data.P_Seq;
                        }
                    },
                });
            }
        }
    },
    //프로세스 유효성 검사
    //validation: function (programName, programExplain, workMediumCtg, workLargeCtg, UseDb, processFile, Pro_YesangTime, Pro_YesangMaxTime, proParamType, Arr2) {
    validation: function (WorkLarge, WorkMedium, processFile, programName, programExplain, Pro_YesangTime, Pro_YesangMaxTime, proParamType, proParamSulmyung) {
        var pathHeader = processFile.lastIndexOf("\\");
        var pathMiddle = processFile.lastIndexOf(".");
        var pathEnd = processFile.length;
        var fileName = processFile.substring(pathHeader+1, pathMiddle);
        var extName = processFile.substring(pathMiddle+1, pathEnd);
        if (WorkLarge == "all") {
            alert('업무 대분류를 선택해주세요');
            return false;
        } else if (WorkMedium == "all") {
            alert('업무 중분류를 선택해주세요');
            return false;
        } else if (processFile == "") {
            alert("파일명을 입력하세요");
            return false;
        } else if (extName!="php"){
            alert('파일의 확장자를 확인해주세요 \n 예)program.php');
        } else if (programName == "") {
            alert("프로그램 명을 입력하세요");
            return false;
        } else if (programExplain == "") {
            alert("프로그램 설명을 입력하세요");
            return false;
            // } else if (UseDb == "") {
            //     alert("프로그램 사용 DB를 입력하세요");
            //     return false;
        } else if (Pro_YesangTime == "") {
            alert("프로그램 예상 시간을 입력하세요");
            return false;
        } else if (Pro_YesangMaxTime == "") {
            alert("프로그램 최대 예상 시간을 입력하세요");
            return false;
        } else if (parseInt(Pro_YesangMaxTime) < parseInt(Pro_YesangTime)) {
            alert('프로그램 예상 시간이 프로그램 최대 예상 시간보다 길 수 없습니다. ');
            return false;
        } else if (proParamType.length == 0) {
            var con = confirm("프로그램 파라미터가 없습니다. 이대로 진행하시겠습니까?");
            if (con) {
                return true;
            } else {
                return false;
            }
        } else if (proParamType.length != 0) {
            //Arr2에 /를 기준으로 split하여 저장. split 사용하면 나누어진 문자열은 각각 배열로 들어감
            var Sulmyungs = proParamSulmyung.split("||");
            for (var i = 0; i < Sulmyungs.length; i++) {
                if (Sulmyungs[i] == "") {
                    alert("파라미터 설명을 입력하세요");
                    return false;
                }
            }
        }
        return true;
    },
    // timeCalc: function (d, h, m) {
    //     if (d == 0 && h == 0 && m == 0) {
    //         return 0;
    //     } else if (d != 0 && h == 0 && m == 0) {
    //         return parseInt(d) * 24 * 60;
    //     } else if (d == 0 && h != 0 && m == 0) {
    //         return parseInt(h) * 60
    //     } else if (d == 0 && h == 0 && m != 0) {
    //         return parseInt(m)
    //     } else if (d != 0 && h != 0 && m == 0) {
    //         return parseInt(d) * 24 * 60 + parseInt(h) * 60;
    //     } else if (d == 0 && h != 0 && m != 0) {
    //         return parseInt(h) * 60 + parseInt(m);
    //     } else if (d != 0 && h != 0 && m != 0) {
    //         return parseInt(d) * 24 * 60 + parseInt(h) * 60 + parseInt(m);
    //     }
    // },
    //수정
    edit: function (p_seq) {
        var WorkLarge = $('#WorkLarge').val();
        var WorkMedium = $('#WorkMedium').val();
        location.href = "/process/processEditView" + "?P_Seq=" + p_seq + "&WorkLarge=" + WorkLarge + "&WorkMedium=" + WorkMedium;
    },
    //삭제
    delete: function () { },
    //파라미터 추가
    addDivParam: function () {
        if(document.getElementsByName('proParamType').length>9){
            alert('프로그램 파라미터는 최대 10개 까지 등록가능 합니다.')
            return false;
          }
        var proParamDiv = document.createElement("div");
        var proParamDiv2 = document.createElement("div");
        var delBtnButton = document.createElement("button");
        //onchange 걸어야됨
        var proParamInputText =
            '<select name="proParamType" class="col-md-2 form-control form-control-sm" ><option value="paramNum">숫자</option><option value="paramStr">문자</option>' +
            '<input type="text" name="proParamSulmyungInput" class="col-md-6 form-control form-control-sm" placeholder="설명">';
        proParamDiv.className = "d-inline-flex w-50 delYN mb-2";
        proParamDiv2.className = "col-md-3 small align-self-center text-center";
        proParamDiv2.innerHTML = "파라미터";
        delBtnButton.type = "button";
        delBtnButton.className =
            "btn btn-sm col-md-auto delParam btn-danger form-control-sm text-center";
        delBtnButton.innerText = "삭제";
        proParamDiv.appendChild(proParamDiv2);
        proParamDiv.innerHTML += proParamInputText;
        proParamDiv.appendChild(delBtnButton);
        document.getElementById("proParams").appendChild(proParamDiv);
        document.getElementById("proParams").app
        document.getElementById("proParams").scrollIntoView();
    }
};
