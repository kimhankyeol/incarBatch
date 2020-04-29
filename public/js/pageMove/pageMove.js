const pageMove={
    //잡에 관한 이동 href
    job:{
        list:function(urlName){
            location.href="/job/"+urlName;
        },
        detail:function(urlName,param1){
            location.href="/job/"+urlName+"?Job_Seq="+param1;
        },
        register:function(urlName){
            location.href="/job/"+urlName;
        },
        update:function(urlName,param1,param2,param3){
            location.href="/job/"+urlName+"?Job_Seq="+param1+"&WorkLarge="+param2+"&WorkMedium="+param3;
        }
    },
    process:{
        list:function(urlName){
            location.href="/process/"+urlName;
        },
        detail:function(urlName,param1){
            location.href="/process/"+urlName+"?P_Seq="+param1;
        }
    },
    login:{
        list:function(urlName){
            location.href="/login/"+urlName;
        }
    },
    //잡실행 href
    jobExecute:{},
     //모니터링
    monitoring:{},
    //잡 히스토리
    jobHistory:{},
    //관리자
    admin:{
        commonCodeLargeDetail:function(WorkLarge){
            location.href="/admin/commonCodeLargeDetailView?WorkLarge="+WorkLarge;
        },
        commonCodeMediumDetail:function(WorkLarge,WorkMedium){
            location.href="/admin/commonCodeMediumDetailView?WorkLarge="+WorkLarge+"&WorkMedium="+WorkMedium;
        },
        commonCodeMediumUpdateView:function(WorkLarge,WorkMedium){
            location.href ="/admin/commonCodeMediumUpdateView?WorkLarge="+WorkLarge+"&WorkMedium="+WorkMedium;
        },
        commonCodeLargeUpdateView:function(WorkLarge){
            location.href="/admin/commonCodeLargeUpdateView?WorkLarge="+WorkLarge;
        },
        register:function(urlName){
            location.href="/admin/"+urlName;
        },
        detail:function(urlName){
            location.href="/admin/"+urlName;
        }
    }
}
