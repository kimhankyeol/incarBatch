
const job = {
    //조회
    search: function(page){
        var searchWord = document.getElementById('searchWord').value
        location.href="/job/jobSearch?searchWord="+searchWord+'&page='+page;
       
        // $.ajax({
        //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //     url:'/job/jobSearch',
        //     method:"get",
        //     data:{
        //         'page':pageNo,
        //         'searchWord': document.getElementById('searchWord').value
        //     },
        //     success:function(resp){
        //         if(resp.msg=="success"){
        //             console.table(resp);
        //             $('#searchContentView').html(resp.html);
        //         }else{
        //             console.log(resp.msg);
        //         }
        //     },error:function(error){
        //         console.error(error);
        //     }
        // })
    },
    //등록
    register:function(){
        var result = confirm("등록하시겠습니까?");
        if (result) {
          console.log("등록 되었습니다.");
        } else {
        console.log("삭제 되었습니다.");
        }
    },
    //수정
    update:function(){

    },
    //삭제
    delete:function(){

    },
    //파라미터 추가
    addDivParam:function(){
        var jobParamDiv = document.createElement('div');
        var jobParamDiv2 = document.createElement('div');
        var delBtnDiv = document.createElement('div');
        var jobParamInputText = '<input type="text" class="col-md-3  form-control form-control-sm" placeholder="파라미터 명">'+
        '<input type="text" class="col-md-4  form-control form-control-sm" placeholder="설명">';
        jobParamDiv.className="row delYN";
        jobParamDiv2.className="col-md-2 small align-self-center text-center"
        jobParamDiv2.innerHTML="잡 파라미터";
        
        delBtnDiv.className="delParam btn btn-danger  form-control form-control-sm col-md-2" ;
        delBtnDiv.onclick=job.deleteDivParam;
        delBtnDiv.innerText="삭제";

        jobParamDiv.appendChild(jobParamDiv2);
        jobParamDiv.innerHTML+=jobParamInputText;
        jobParamDiv.appendChild(delBtnDiv);
       
        document.getElementById('jobParams').appendChild(jobParamDiv);
    },
    //파라미터 삭제
    deleteDivParam:function(){
        var delIndex = $('.delParam').index(this);
        $('.delYN').eq(delIndex).remove();
    }
};

//프로세스
const process ={
    //조회
    search: function(page){
        var searchWord = document.getElementById('searchWord').value;
        location.href="/process/processSearch?searchWord="+searchWord+'&page='+page;
    },
    //등록
    register:function(){
        var result = confirm("등록하시겠습니까?");
        if (result) {
          console.log("등록 되었습니다.");
        } else {
        console.log("삭제 되었습니다.");
        }
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
        var proParamInputText = '<input type="text" class="col-md-3  form-control form-control-sm" placeholder="파라미터 명">'+
        '<input type="text" class="col-md-4  form-control form-control-sm" placeholder="설명">';
        proParamDiv.className="row delYN";
        proParamDiv2.className="col-md-2 small align-self-center text-center"
        proParamDiv2.innerHTML="프로그램 파라미터";
        
        delBtnDiv.className="delParam btn btn-danger  form-control form-control-sm col-md-2" ;
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