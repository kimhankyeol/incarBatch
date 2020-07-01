//공통 코드
const code = {
    //대분류 즉시 조회 
    workLargeCtg:function(WorkLarge,WorkMedium){
        $.ajax({
            url:"/code/workLargeCtg",
            method:"get",
            data:{
                "WorkLarge":WorkLarge,
                "WorkMedium":WorkMedium,
            },
            success:function(data){
                console.table(data);
                $('#codeLargeView').html(data.returnHTML);
                code.workMediumCtg2(WorkLarge,WorkMedium)
            },error:function(err){
        
            }
        })
    },
    //중분류
    workMediumCtg:function(WorkMedium){
        $.ajax({
            url:"/code/workMediumCtg",
            method:"get",
            data:{
                "WorkLarge":$('#workLargeVal').val(),
                "WorkMedium":WorkMedium
            },
            success:function(data){
                $('#workMediumVal').html(data.returnHTML);
            },error:function(err){
            }
        })
    },//관리자 대분류 공통 코드 검색
    largeSearch:function(page){
        var searchWord = $('#searchWord').val();
        location.href="/admin/commonCodeLargeManageView?searchWord="+searchWord;        
    },
    //관리자 중분류 공통 코드 검색
    search:function(page){
        var searchWord = $('#searchWord').val();
        var WorkLarge = $('#workLargeVal').val();
        var Used = $('#Used').val();
        location.href="/admin/commonCodeMediumManageView?searchWord="+searchWord+"&WorkLarge="+WorkLarge+"&Used="+Used+"&page="+page;        
    },
    //관리자 대분류 공통 코드 등록
    largeRegister:function(){
        var WorkLarge = $('#WorkLarge');
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
        }else{
            var result = confirm("대분류 코드를 등록하시겠습니까?");
            if(result){
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"/admin/commonCodeLargeRegister",
                    method:"POST",
                    async:false,
                    data:{
                       "WorkLarge":WorkLarge.val(),
                       "CodeShortName":CodeShortName.val(),
                       "CodeLongName":CodeLongName.val(),
                       "CodeSulmyung":CodeSulmyung.val(),
                       "Used":Used.val()
                    },
                    success:function(data){
                        if(data.msg=="exist"){
                            alert('코드가 존재합니다.');
                            return false;
                        }else if(data.msg=="success"){
                            alert('코드가 등록되었습니다.');
                            location.href ="/admin/commonCodeLargeManageView?page=1"
                        }else if(data.msg=="failed"){
                            alert('코드 등록이 실패되었습니다.');
                            location.href ="/admin/commonCodeLargeManageView?page=1"
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
    //관리자 중분류 공통 코드 등록
    register:function(){
       
        var WorkLarge = $('#WorkLarge option:selected');
        var WorkMedium = $('#WorkMedium');
        var CodeShortName =$('#CodeShortName');
        var CodeLongName =$('#CodeLongName');
        var CodeSulmyung =$('#CodeSulmyung');
        var FilePath = $('#FilePath');
        var Used = $('#Used option:selected');
        if(WorkLarge.val()==""){
            alert("대분류 코드번호가 입력되지 않았습니다.");
            WorkLarge.focus();
            return false;
        }else if(WorkMedium.val()==""){
            alert("중분류 코드번호가 입력되지 않았습니다.");
            WorkMedium.focus();
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
        }
        if(parseInt(WorkLarge.val())>=1000&&parseInt(WorkLarge.val()<2000)){
            if(FilePath.val()==""){
                alert("경로가 입력되지 않았습니다.");
                FilePath.focus();
                return false;
            }
        }else{
            var result = confirm("대분류/중분류 코드를 등록하시겠습니까?");
            if(result){
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"/admin/commonCodeMediumRegister",
                    method:"POST",
                    async:false,
                    data:{
                       "WorkLarge":WorkLarge.val(),
                       "WorkMedium":WorkMedium.val(),
                       "CodeShortName":CodeShortName.val(),
                       "CodeLongName":CodeLongName.val(),
                       "CodeSulmyung":CodeSulmyung.val(),
                       "FilePath":FilePath.val(),
                       "Used":Used.val()
                    },
                    success:function(data){
                        console.table(data);
                        if(data.msg=="exist"){
                            alert('코드가 존재합니다.');
                            return false;
                        }else if(data.msg=="success"){
                            alert('코드가 등록되었습니다.');
                            location.href ="/admin/commonCodeMediumManageView?page=1"
                        }else if(data.msg=="failed"){
                            alert('코드 등록이 실패되었습니다.');
                            location.href ="/admin/commonCodeMediumManageView?page=1"
                        }else if(data.msg=="folderExist"){
                            alert('이미 폴더경로를 사용중인 코드가 있습니다.');
                            return false;
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
    //관리자 중분류 코드 수정
    update:function(){
        var WorkLarge =$('#WorkLarge');
        var WorkMedium =$('#WorkMedium');
        var CodeShortName =$('#CodeShortName');
        var CodeLongName =$('#CodeLongName');
        var CodeSulmyung =$('#CodeSulmyung');
        var FilePath = $('#FilePath');
        var Used = $('#Used option:selected');
       if(CodeShortName.val()==""){
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
        }
        if(parseInt(WorkLarge.val())>=1000&&parseInt(WorkLarge.val()<2000)){
            if(FilePath.val()==""){
                alert("경로가 입력되지 않았습니다.");
                FilePath.focus();
                return false;
            }
        }else{
            var result = confirm("중분류 코드를 수정 하시겠습니까?");
            if(result){
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"/admin/commonCodeMediumUpdate",
                    method:"POST",
                    async:false,
                    data:{
                       "WorkLarge":WorkLarge.val(),
                       "WorkMedium":WorkMedium.val(),
                       "CodeShortName":CodeShortName.val(),
                       "CodeLongName":CodeLongName.val(),
                       "CodeSulmyung":CodeSulmyung.val(),
                       "FilePath":FilePath.val(),
                       "Used":Used.val()
                    },
                    success:function(data){
                        if(data.msg=="success"){
                            alert('중분류 코드를 수정하였습니다.');
                            location.href="/admin/commonCodeMediumManageView?page=1";
                        }else{
                            alert('코드 수정에 실패했습니다.');
                             location.href="/admin/commonCodeMediumManageView?page=1";
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
    //관리자 대분류 코드 존재유무 조회
    commonLargeCodeExist:function(){
        var WorkLarge = $('#WorkLarge');
        $.ajax({
            url:'/admin/commonLargeCodeExist',
            method:'get',
            data:{
                "WorkLarge":WorkLarge.val(),
            },
            success:function(data){
              $('#commonCodeSearchList').html(data.returnHTML);
            }
          })
    },
    //관리자 중분류 onchange
    workMediumInfo:function(){
        var WorkLarge = $('#WorkLarge option:selected');
        if(WorkLarge.val()==""){
            WorkLarge.val('all');
        }
        //업무구분 코드 1000~1999 까지는 업무구분 코드여서 경로가 필요하고 2000부터는 경로 필요없음
        if(WorkLarge.val()>=2000||WorkLarge.val()<1000){
            $('#FilePathDiv').hide();
            $('#FilePath').hide();
            $('#FilePath').val("");
        }else if(WorkLarge.val()>=1000&&WorkLarge.val()<2000){
            $('#FilePathDiv').show();
            $('#FilePath').show();
            $('#FilePath').val("");
        }
        $.ajax({
            url:'/admin/commonCodeExist',
            method:'get',
            data:{
                "WorkLarge":WorkLarge.val(),
                "WorkMedium":"all"
            },
            success:function(data){
                if($('#WorkLarge').val()=="all"){
                    $('#WorkLarge').val('');
                }
                if($('#WorkMedium').val()=="all"){
                $('#WorkMedium').val('');
                }
              $('#commonCodeSearchList').html(data.returnHTML);
            }
          })
    },
    //관리자 대분류 초기 조회
    commonCodeLargeInfo:function(){
        var WorkLarge = $('#WorkLarge');
        if(WorkLarge.val()==""){
            WorkLarge.val('all');
        }
        $.ajax({
            url:'/admin/commonCodeLargeExist',
            method:'get',
            data:{
                "WorkLarge":WorkLarge.val(),
            },
            success:function(data){
                if($('#WorkLarge').val()=="all"){
                    $('#WorkLarge').val('');
                }
              $('#commonCodeSearchList').html(data.returnHTML);
            }
          })
    },
     //관리자 대분류 코드 존재유무 조회
     commonCodeLargeExist:function(){
        var WorkLarge = $('#WorkLarge');
        if(WorkLarge.val()==""){
            WorkLarge.val('all');
        }
        $.ajax({
            url:'/admin/commonCodeLargeExist',
            method:'get',
            data:{
                "WorkLarge":WorkLarge.val(),
            },
            success:function(data){
                if($('#WorkLarge').val()=="all"){
                    $('#WorkLarge').val('');
                }
              $('#commonCodeSearchList').html(data.returnHTML);
            }
          })
    },
    //관리자 중분류 코드 존재유무 조회
    commonCodeExist:function(){
        var WorkLarge = $('#WorkLarge option:selected');
        var WorkMedium = $('#WorkMedium');
        if(WorkLarge.val()==""){
            WorkLarge.val('all');
        }
        if(WorkMedium.val()==""){
            WorkMedium.val('all');
        }
        $.ajax({
            url:'/admin/commonCodeExist',
            method:'get',
            data:{
                "WorkLarge":WorkLarge.val(),
                "WorkMedium":WorkMedium.val()
            },
            success:function(data){
                if($('#WorkLarge').val()=="all"){
                    $('#WorkLarge').val('');
                }
                if($('#WorkMedium').val()=="all"){
                $('#WorkMedium').val('');
                }
              $('#commonCodeSearchList').html(data.returnHTML);
            }
          })
    },
    //업무 분류별 경로
    workDataSelect:function(){
        console.log($('#workLargeVal option:selected').val());
        console.log($('#workMediumVal option:selected').val());
        $.ajax({
            url:"/code/workDataSelect",
            method:"get",
            data:{
                workLargeVal : $('#workLargeVal option:selected').val(),
                workMediumVal : $('#workMediumVal option:selected').val()
            },
            success:function(data){
                $('#processPath').val(data.workFilePath[0].filepath);
                if($('#P_TextInputCheck').is(":checked")){
                    $('#P_TextInputFilePath').val(data.workFilePath[0].filepath);
                }
            },error:function(err){
            }
        })
    },
    //관리자 대분류 수정
    largeUpdate:function(){
        var WorkLarge =$('#WorkLarge');
        var CodeShortName =$('#CodeShortName');
        var CodeLongName =$('#CodeLongName');
        var CodeSulmyung =$('#CodeSulmyung');
        var Used = $('#Used option:selected');
        if(CodeShortName.val()==""){
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
        }else{
            var result = confirm("대분류 코드를 수정 하시겠습니까?");
            if(result){
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"/admin/commonCodeLargeUpdate",
                    method:"POST",
                    async:false,
                    data:{
                       "WorkLarge":WorkLarge.val(),
                       "CodeShortName":CodeShortName.val(),
                       "CodeLongName":CodeLongName.val(),
                       "CodeSulmyung":CodeSulmyung.val(),
                       "Used":Used.val()
                    },
                    success:function(data){
                        if(data.msg=="success"){
                            alert('대분류 코드를 수정하였습니다.');
                            location.href="/admin/commonCodeLargeManageView?page=1";
                        }else{
                            alert('코드 수정에 실패했습니다.');
                             location.href="/admin/commonCodeLargeManageView?page=1";
                        }
                    },
                    error:function(error){

                    }
                })
            }else{
                return false;
            }
        }
    }
}