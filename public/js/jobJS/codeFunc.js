//공통 코드
const code = {
    //대분류 
    workLargeCtg:function(){
        $.ajax({
            url:"/code/workLargeCtg",
            method:"get",
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
                "WorkLarge":$('#workLargeVal').val()
            },
            success:function(data){
                console.table(data);
                $('#workMediumVal').html(data.returnHTML);
            },error:function(err){
        
            }
        })
    },
    //관리자 공통 코드 검색
    search:function(page){
        var searchWord = $('#searchWord').val();
        location.href="/admin/commonCodeManageView?searchWord="+searchWord;        
    },
    //관리자 공통 코드 등록
    register:function(){
        var Codetype = $('#Codetype option:selected')
        var WorkLarge = $('#WorkLarge');
        var WorkMedium = $('#WorkMedium');
        var CodeShortName =$('#CodeShortName');
        var CodeLongName =$('#CodeLongName');
        var CodeSulmyung =$('#CodeSulmyung');
        var Used = $('#Used option:selected');
       
        if(WorkLarge.val()==""){
            alert("대분류 코드번호가 입력되지 않았습니다.");
            WorkLarge.focus();
            return false;
        }else if(CodeShortName.val()==""){
            alert("코드명이 입력되지 않았습니다.");
            CodeShortName.focus();
            return false;
        }else if(CodeLongName.val()==""){
            alert("코드 전체명이 입력되지 않았습니다.");
            CodeLongName.focus();
            return false;
        }else if(CodeSulmyung.val()==""){
            alert("코드 설명이 입력되지 않았습니다.");
            CodeSulmyung.focus();
            return false;
        }else if(WorkMedium.val()==""){
            var result = confirm("중분류 코드가 입력되지 않으면 대분류 코드로 등록됩니다.");
            if(result){
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"/admin/commonCodeRegister",
                    method:"POST",
                    data:{
                       "Codetype":Codetype.val(),
                       "WorkLarge":WorkLarge.val(),
                       "WorkMedium":"all",
                       "CodeShortName":CodeShortName.val(),
                       "CodeLongName":CodeShortName.val(),
                       "CodeSulmyung":CodeSulmyung.val(),
                       "Used":Used.val()
                    },
                    success:function(data){
                        console.table(data);
                        if(data.msg=="exist"){
                            alert('코드가 존재합니다.');
                            return false;
                        }else if(data.msg=="success"){
                            alert('코드가 등록되었습니다.');
                            location.href ="/admin/commonCodeManageView"
                        }else if(data.msg=="failed"){
                            alert('코드 등록이 실패되었습니다.');
                            location.href ="/admin/commonCodeManageView"
                        }
                    },
                    error:function(error){

                    }
                })
            }else{
                return false;
            }
            
        }else{
            var result = confirm("대분류/중분류 코드를 등록하시겠습니까?");
            if(result){
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"/admin/commonCodeRegister",
                    method:"POST",
                    data:{
                       "Codetype":Codetype.val(),
                       "WorkLarge":WorkLarge.val(),
                       "WorkMedium":WorkMedium.val(),
                       "CodeShortName":CodeShortName.val(),
                       "CodeLongName":CodeShortName.val(),
                       "CodeSulmyung":CodeSulmyung.val(),
                       "Used":Used.val()
                    },
                    success:function(data){
                        console.table(data);
                        if(data.msg=="exist"){
                            alert('코드가 존재합니다.');
                            return false;
                        }else if(data.msg=="success"){
                            alert('코드가 등록되었습니다.');
                            location.href ="/admin/commonCodeManageView"
                        }else if(data.msg=="failed"){
                            alert('코드 등록이 실패되었습니다.');
                            location.href ="/admin/commonCodeManageView"
                        }
                    },
                    error:function(error){

                    }
                })
            }else{
                return false;
            }
        }
    },
    //관리자 코드 존재유무 조회
    commonCodeExist(){
        var Codetype = $('#Codetype option:selected')
        var WorkLarge = $('#WorkLarge');
        var WorkMedium = $('#WorkMedium');

        $.ajax({
            url:'/admin/commonCodeExist',
            method:'get',
            data:{
                "Codetype":Codetype.val(),
                "WorkLarge":WorkLarge.val(),
                "WorkMedium":WorkMedium.val()
            },
            success:function(data){
              $('#commonCodeSearchList').html(data.returnHTML);
            }
          })
    }
    
}