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
    //잡실행 href
    jobExecute:{},
     //모니터링
    monitoring:{},
    //잡 히스토리
    jobHistory:{},
    //관리자
    admin:{
        commonCodeManageDetail:function(Codetype,WorkLarge,WorkMedium){
            location.href="/admin/commonCodeDetailView?Codetype="+Codetype+"&WorkLarge="+WorkLarge+"&WorkMedium="+WorkMedium;
        },
        register:function(urlName){
            location.href="/admin/"+urlName;
        },
        detail:function(urlName){
            location.href="/admin/"+urlName;
        }
    }
}
