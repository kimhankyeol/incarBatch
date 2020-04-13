//프로세스
const process ={
    //조회
    search: function(page){
        var searchWord = document.getElementById('searchWord').value;
        location.href="/process/processListView?searchWord="+searchWord+'&page='+page;
    },
    //등록
    register:function(){
        const proParamSulmyungInput = document.getElementsByName("proParamSulmyungInput");
        const res1 = [];
        for(var i=0; i<proParamSulmyungInput.length; i++){
            res1.push(proParamSulmyungInput[i].value);
        }
        // const t1 = document.getElementsByName("proParamSulmyungInput");
        // for(var i =0 ; i < t1.length; i++) {
        //     if(t1[i].value != "") {
        //         alert("값이 없습니다.");
        //         return false;
        //     }
        // }
        //getElementsByName으로 한번에 받은 배열을 /로 나눈어 합친다.
        const Arr1 = res1.join('\|\|');
        if(document.getElementById('programName').value == ""){
            alert("프로그램 명을 입력하세요");
            return false;
        }else if(document.getElementById('programExplain').value ==""){
            alert("프로그램 설명을 입력하세요");
            return false;
        }else if(document.getElementById('UseDb').value==""){
            alert("프로그램 사용 DB를 입력하세요");
            return false;
        }else if(document.getElementById('yaeTime').value==""){
            alert("프로그램 예상 시간을 입력하세요");
            return false;
        }else if(document.getElementById('yaeMaxTime').value==""){
            alert("프로그램 최대 예상 시간을 입력하세요");
            return false;
        }else if(document.getElementById('path').value==""){
            alert("경로를 입력하세요");
            return false;
        }else if(document.getElementsByName("proParamType").length != 0){
            //Arr2에 /를 기준으로 split하여 저장. split 사용하면 나누어진 문자열은 각각 배열로 들어감
            var Arr2 = Arr1.split('\|\|');
            for(var i=0; i<Arr2.length;i++){
                if(Arr2[i]==""){
                    alert("파라미터 설명을 입력하세요");
                    return false;
                }
            }
        }
        var con = confirm("프로그램을 등록하시겠습니까?");
        if (con == true) {
            const paramArr1 = document.getElementsByName("proParamType");
            const paramArr2 = document.getElementsByName("proParamSulmyungInput");
            const res1 = [];
            const res2 = [];
            for(var i=0; i<paramArr1.length; i++){
                res1.push(paramArr1[i].value);
            }
            for(var i=0; i<paramArr2.length; i++){
                res2.push(paramArr2[i].value);
            }
            const paramStr1 = res1.join('\|\|');
            const paramStr2 = res2.join('\|\|');
          $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:'/process/processRegister',
            method:"post",
            data:{
                'programName' : document.getElementById('programName').value,
                'programExplain' : document.getElementById('programExplain').value,
                'retry' : document.getElementById('retry').value,
                'UseDb' : document.getElementById('UseDb').value,
                'yaeTime' : document.getElementById('yaeTime').value,
                'yaeMaxTime' : document.getElementById('yaeMaxTime').value,
                'path' : document.getElementById('path').value,
                'proParamType' : paramStr1,
                'proParamSulmyungInput' : paramStr2
            },
            success : function(data){
                console.log("등록 되었습니다.");
                console.table(data);
                location.href="/process/processListView";
            }
        })}
    },
    //수정
    update:function(){
    },
    //삭제
    delete:function(){
    },
    //파라미터 추가
    addDivParam:function(){
        var proParamDiv = document.createElement('div');
        var proParamDiv2 = document.createElement('div');
        var delBtnDiv = document.createElement('div');
        //onchange 걸어야됨
        var proParamInputText = '  <select name="proParamType" class="col-md-3  form-control form-control-sm" > <option value="paramDate">날짜</option><option value="paramNum">숫자</option><option value="paramStr">문자</option></select>'+
        '<input type="text" name="proParamSulmyungInput" class="col-md-4  form-control form-control-sm" placeholder="설명">';
        proParamDiv.className="row delYN";
        proParamDiv.style.paddingBottom="10px";
        proParamDiv2.className="col-md-2 small align-self-center text-center"
        proParamDiv2.innerHTML="프로그램 파라미터";
        delBtnDiv.className="delParam btn-danger  form-control form-control-sm col-md-2 text-center" ;
        delBtnDiv.onclick=process.deleteDivParam;
        delBtnDiv.innerText="삭제";
        proParamDiv.appendChild(proParamDiv2);
        proParamDiv.innerHTML+=proParamInputText;
        proParamDiv.appendChild(delBtnDiv);
        document.getElementById('proParams').appendChild(proParamDiv);
    },
    //파라미터 삭제
    deleteDivParam:function(){
        var delIndex = $('.delParam').index(this);
        $('.delYN').eq(delIndex).remove();
    }
}