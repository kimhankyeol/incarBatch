const login = {
    loginCheck : function(){
        var UserId = $('#UserId').val();
        var UserPwd = $('#UserPwd').val();
        alert

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url : "/login/loginCheck",
            method : "get",
            data:{
                'UserId':UserId,
                'UserPwd':UserPwd
            },
            success : function(data){
                if(data.count==1){
                    location.href="/";
                }else if(data.count==0){
                    alert("아이디와 비밀번호가 일치하지 않습니다.");
                }
            }
        });
    },
};