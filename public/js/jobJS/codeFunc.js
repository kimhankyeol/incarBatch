//공통 코드
const code = {
    //대분류 
    workLargeCtg:function(){
        $.ajax({
            url:"/code/workLargeCtg",
            method:"get",
            data:{
                "CodeType":"B",
                "WorkMedium":"all"
            },
            success:function(data){
                console.table(data);
                $('#codeLargeView').html(data.returnHTML);
            },error:function(err){
        
            }
        })
    },
    //중분류
    workMediumCtg:function(){
        $.ajax({
            url:"/code/workMediumCtg",
            method:"get",
            data:{
                //코드타입
                "CodeType":"B",
                "WorkLarge":$('#workLargeVal').val()
            },
            success:function(data){
                console.table(data);
                $('#workMediumVal').html(data.returnHTML);
            },error:function(err){
        
            }
        })
    }
}