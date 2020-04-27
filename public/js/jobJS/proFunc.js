//프로세스
const process = {
    //조회
    search: function (page) {
        var searchWord = $('#searchWord').val();
        var WorkLarge = $('#workLargeVal option:selected').val();
        var WorkMedium = $('#workMediumVal option:selected').val();
      // 대분류 , 중분류 전체 선택일때 아닐떄 경우의 수
      location.href="/process/processListView?searchWord="+searchWord+"&WorkLarge="+WorkLarge+"&WorkMedium="+WorkMedium
    },
    //등록
    register: function () {
        $('#workLargeVal').removeAttr("disabled", "disabled");
        $('#workMediumVal').removeAttr("disabled", "disabled");

        //체크박스 체크되어 있으면 1, 아니면 0으로 val설정
        if($("#retry").is(":checked")){
            $("#retry").val(1);
        }else{
            $("#retry").val(0);
        }
        if($("#P_FileInputCheck").is(":checked")){
            $("#P_FileInputCheck").val(1);
        }else{
            $("#P_FileInputCheck").val(0);
        }

        console.log($('#P_FileInputCheck').val());

        var WorkLarge = $('#workLargeVal option:selected').val();
        var WorkMedium = $('#workMediumVal option:selected').val();
        var processPath = document.getElementById("processPath").value; 
        var processFile = document.getElementById("processFile").value;
        var UseDb = document.getElementById("UseDb").value;
        var retry = $("#retry").val();

        var programName = document.getElementById("programName").value;
        var programExplain = document.getElementById("programExplain").value;

        var P_RegId=$('#P_RegId').val();
        var P_DevId="16161616";
        var P_FileInputCheck = $('#P_FileInputCheck').val();
        var P_FileInput=$('#P_FileInput').val();
        
        //시간계산 분단위 ()
      if($('#Pro_YesangTime1').val()==""){
        $('#Pro_YesangTime1').val(0);
      }
      if($('#Pro_YesangTime2').val()==""){
        $('#Pro_YesangTime2').val(0);
      }
      if($('#Pro_YesangTime3').val()==""){
        $('#Pro_YesangTime3').val(0);
      }
      if($('#Pro_YesangMaxTime1').val()==""){
        $('#Pro_YesangMaxTime1').val(0);
      }
      if($('#Pro_YesangMaxTime2').val()==""){
        $('#Pro_YesangMaxTime2').val(0);
      }
      if($('#Pro_YesangMaxTime3').val()==""){
        $('#Pro_YesangMaxTime3').val(0);
      }
        var Pro_YesangTime= process.timeCalc($('#Pro_YesangTime1').val(),$('#Pro_YesangTime2').val(),$('#Pro_YesangTime3').val());
        var Pro_YesangMaxTime= process.timeCalc($('#Pro_YesangMaxTime1').val(),$('#Pro_YesangMaxTime2').val(),$('#Pro_YesangMaxTime3').val());
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
        var provalcheck = process.validation(WorkLarge,WorkMedium,UseDb,processFile,programName,programExplain,Pro_YesangTime,Pro_YesangMaxTime,proParamType,Arr2);
        if(provalcheck){
            var con = confirm("프로그램을 등록하시겠습니까?");
        if (con == true) {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: "/process/processRegister",
                method: "post",
                data: {
                    WorkLarge:WorkLarge,
                    WorkMedium:WorkMedium,
                    processPath : processPath,
                    processFile : processFile,
                    UseDb: UseDb,
                    retry: retry,

                    programName: programName,
                    programExplain: programExplain,

                    Pro_YesangTime : Pro_YesangTime,
                    Pro_YesangMaxTime : Pro_YesangMaxTime,
                    
                    proParamType: Arr1,
                    proParamSulmyungInput: Arr2,
                    
                    P_FileInputCheck:P_FileInputCheck,
                    P_FileInput:P_FileInput,

                    P_DevId:P_DevId,
                    P_RegId:P_RegId
                },
                success: function (data) {
                    if(data.fileResult1==true&&data.count==0){
                        alert("프로그램이 등록되었습니다.");
                        console.log("등록 되었습니다.");
                        location.href = "/process/processDetailView?P_Seq="+data.last_p_seq;
                    }else if(data.count!=0){
                        alert("해당 경로에 이미 같은 이름의 파일이 존재합니다.");
                    }else if(data.fileResult1==false){
                        alert("경로가 존재하지 않습니다.");
                    }
                },
            });
        }
      }
    },
    //db 업데이트
    update : function () {
        
        if($("#retry").is(":checked")){
            $("#retry").val(1);
        }else{
            $("#retry").val(0);
        }
        //console.table($('#P_RegIp').val());
        //alert($('#proParamSulmyungInput').val());
        var p_seq = $('#P_Seq').val();
        var processPath = $('#processPath').val();
        var processFile = $('#processFile').val();
        var programName = $('#programName').val();
        var programExplain = $('#programExplain').val();
        var WorkLarge = $('#workLargeVal option:selected').val();
        var WorkMedium = $('#workMediumVal option:selected').val();
        var UseDb = $('#UseDb').val();
        var retry = $("#retry").val();
        var P_UpdIP= $('#P_UpdIP').val();
        var P_UpDate=$('#P_UpDate').val();
        var P_FileInputCheck = $('#P_FileInputCheck').val();
        var P_FileInput=$('#P_FileInput').val();
        //시간계산 분단위 ()
      if($('#Pro_YesangTime1').val()==""){
        $('#Pro_YesangTime1').val(0);
      }
      if($('#Pro_YesangTime2').val()==""){
        $('#Pro_YesangTime2').val(0);
      }
      if($('#Pro_YesangTime3').val()==""){
        $('#Pro_YesangTime3').val(0);
      }
      if($('#Pro_YesangMaxTime1').val()==""){
        $('#Pro_YesangMaxTime1').val(0);
      }
      if($('#Pro_YesangMaxTime2').val()==""){
        $('#Pro_YesangMaxTime2').val(0);
      }
      if($('#Pro_YesangMaxTime3').val()==""){
        $('#Pro_YesangMaxTime3').val(0);
      }
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
        var provalcheck = process.validation(programName,programExplain,WorkLarge,WorkMedium,UseDb,processFile,Pro_YesangTime,Pro_YesangMaxTime,proParamType,Arr1);
        if(provalcheck){
            var con = confirm("프로그램을 수정 완료 하시겠습니까?");
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
                url: "/process/processEdit",
                method: "post",
                data: {
                    'p_seq' : p_seq,
                    processPath : processPath,
                    processFile : processFile,
                    P_UpdIP : P_UpdIP,
                    P_UpDate : P_UpDate,
                    programName: programName,
                    programExplain: programExplain,
                    WorkMedium:WorkMedium,
                    WorkLarge:WorkLarge,
                    retry: retry,
                    UseDb: UseDb,
                    proParamType: paramStr1,
                    proParamSulmyungInput: paramStr2,
                    Pro_YesangTime : Pro_YesangTime,
                    Pro_YesangMaxTime : Pro_YesangMaxTime,
                    P_FileInputCheck:P_FileInputCheck,
                    P_FileInput:P_FileInput
                },
                success: function (data) {
                    console.table(data);
                    if(data.fileResult1==true&&data.count==0){
                        alert("프로그램이 수정되었습니다.");
                        console.log("수정 되었습니다.");
                        location.href = "/process/processDetailView?P_Seq="+data.P_Seq;
                    }else if(data.count!=0){
                        alert("해당 경로에 이미 같은 이름의 파일이 존재합니다.");
                    }else if(data.fileResult1==false){
                        alert("경로가 존재하지 않습니다.");
                    }
                },
            });
        }
      }
    },
    //프로세스 유효성 검사
    validation:function(programName,programExplain,workMediumCtg,workLargeCtg,UseDb,processFile,Pro_YesangTime,Pro_YesangMaxTime,proParamType,Arr2){
        if(processFile == ""){
            alert("파일명을 입력하세요");
            return false;
        } else if(programName == "") {
            alert("프로그램 명을 입력하세요");
            return false;
        } else if (programExplain == "") {
            alert("프로그램 설명을 입력하세요");
            return false;
        } else if(workLargeCtg=="all"){
            alert('업무 대분류를 선택해주세요');
            return false;
        }else if(workMediumCtg=="all"){
            alert('업무 중분류를 선택해주세요');
            return false;
        }else if (UseDb == "") {
            alert("프로그램 사용 DB를 입력하세요");
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
            var Sulmyungs = Arr2.split("||");
            for (var i = 0; i < Sulmyungs.length; i++) {
                if (Sulmyungs[i] == "") {
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
    edit: function () {
        var p_seq = document.getElementById("P_Seq").value;
        var WorkLarge = $('#WorkLarge').val(); 
        var WorkMedium = $('#WorkMedium').val(); 
        location.href="/process/processEditView"+"?P_Seq="+p_seq+"&WorkLarge="+WorkLarge+"&WorkMedium="+WorkMedium;
    },
    //삭제
    delete: function () {},
    //파라미터 추가
    addDivParam: function () {
        var proParamDiv = document.createElement("div");
        var proParamDiv2 = document.createElement("div");
        var delBtnDiv = document.createElement("div");
        //onchange 걸어야됨
        var proParamInputText =
            '<select name="proParamType" class="col-md-2 form-control form-control-sm" > <option value="paramDate">날짜</option><option value="paramNum">숫자</option><option value="paramStr">문자</option>' +
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