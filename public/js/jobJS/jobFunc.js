const job = {
    //조회
    search: function(){
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:'/job/jobSearch',
            method:"get",
            data:{
                'searchWord': document.getElementById('searchWord').value
            },
            success:function(resp){
                if(resp.msg=="success"){
                    console.table(resp);
                   $('#searchContentView').html(resp.html);
                }else{
                    console.log(resp.msg);
                }
            },error:function(error){
                console.error(error);
            }
        })
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

    }
};

//프로세스
const process ={
    //조회
    search: function(){
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:'/process/processSearch',
            method:"get",
            data:{
                'searchWord': document.getElementById('searchWord').value
            },
            success:function(resp){
                if(resp.msg=="success"){
                   $('#searchContentView').html(resp.html);
                }else{
                    console.log(resp.msg);
                }
            },error:function(error){
                console.error(error);
            }
        })
    }
}