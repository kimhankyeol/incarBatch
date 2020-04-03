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
    //프로세스 이동 href
    process:function(){

    },
    //잡실행 href
    jobExecute:function(){

    },
    //모니터링
    monitoring:function(){

    },
    //잡 히스토리
    jobHistory:function(){

    }
}