const pageMove={
    //잡에 관한 이동 href
    job:{
        list:function(urlName){
            location.href="/job/"+urlName;
        },
        detail:function(urlName,param1){
            location.href="/job/"+urlName+"?job_seq="+param1;
        }
    },
    process:{
        list:function(urlName){
            location.href="/process/"+urlName;
        },
        detail:function(urlName,param1){
            location.href="/process/"+urlName+"?p_seq="+param1;
        }
    },
    //잡실행 href
    jobExecute:{},
     //모니터링
    monitoring:{},
    //잡 히스토리
    jobHistory:{}
}
