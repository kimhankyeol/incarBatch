const login = {
    loginCheck : function(){
        var USER_SAWONNUM = $('#USER_SAWONNUM').val();
        var USER_PASSWORD = $('#USER_PASSWORD').val();
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url : "/api/auth/login",
            method : "post",
            data:{
                'USER_SAWONNUM':USER_SAWONNUM,
                'USER_PASSWORD':USER_PASSWORD
            },
            success : function(data){
                console.table(data);
                // if(data.count==1){
                //     location.href="/";
                // }else if(data.count==0){
                //     alert("아이디와 비밀번호가 일치하지 않습니다.");
                // }
            }
        });
    },
};