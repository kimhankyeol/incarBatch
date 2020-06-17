<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Monitoring extends Model
{
    //모니터링 조회
    public function monitoringSearchList($searchWord,$WorkLarge,$WorkMedium,$cronStartDate,$cronEndDate,$status){
        $query1 = "
        SELECT 
        RNUM,
        SC_SEQ,
        JOB_SEQ,
        SC_REGDATE,
        SC_STARTTIME,
        SC_ENDTIME,
        SC_CRONTIME,
        SC_SULMYUNG,
        SC_NOTE,
        SC_DELETEYN,
        SC_PARAM,
        SC_STATUS,
        SC_REGID,
        JOB_NAME,
        JOB_WORKLARGECTG,
        JOB_WORKMEDIUMCTG,
        (SELECT COUNT(CASE WHEN substr(obsp.JOBSM_P_STATUS,1,2)='90' THEN 1 END) FROM ONLINEBATCH_SCHEDULEPROCESS obsp WHERE obsp.SC_SEQ=SCT.SC_SEQ) STATUS90,
        (SELECT COUNT(CASE WHEN substr(obsp.JOBSM_P_STATUS,1,2)='10' THEN 1 END) FROM ONLINEBATCH_SCHEDULEPROCESS obsp WHERE obsp.SC_SEQ=SCT.SC_SEQ) STATUS10,
        (SELECT COUNT(CASE WHEN substr(obsp.JOBSM_P_STATUS,1,2)='20' THEN 1 END) FROM ONLINEBATCH_SCHEDULEPROCESS obsp WHERE obsp.SC_SEQ=SCT.SC_SEQ) STATUS20,
        (SELECT COUNT(CASE WHEN substr(obsp.JOBSM_P_STATUS,1,2)='40' THEN 1 END) FROM ONLINEBATCH_SCHEDULEPROCESS obsp WHERE obsp.SC_SEQ=SCT.SC_SEQ) STATUS40
        FROM (    
          SELECT   
              ROW_NUMBER() OVER(PARTITION BY obs.JOB_SEQ,obs.SC_REGDATE ORDER BY obs.SC_STARTTIME DESC NULLS LAST, obs.SC_CRONTIME ASC) AS RNUM,
              obs.SC_SEQ,
              obs.JOB_SEQ,
              obs.SC_REGDATE,
              obs.SC_STARTTIME,
              obs.SC_ENDTIME,
              obs.SC_CRONTIME,
              obs.SC_SULMYUNG,
              obs.SC_NOTE,
              obs.SC_DELETEYN,
              obs.SC_PARAM,
              obs.SC_STATUS,
              (SELECT USER_NAME FROM ONLINEBATCH_USER ou WHERE ou.USER_SAWONNUM =obs.SC_REGID) AS SC_REGID ,
              obj.JOB_NAME,
              (SELECT owl.SHORTNAME FROM ONLINEBATCH_WORKLARGECODE owl WHERE owl.WORKLARGE = obj.JOB_WORKLARGECTG) AS JOB_WORKLARGENAME,
              (SELECT owm.SHORTNAME FROM ONLINEBATCH_WORKMEDIUMCODE owm WHERE owm.WORKLARGE =obj.JOB_WORKLARGECTG AND owm.WORKMEDIUM = obj.JOB_WORKMEDIUMCTG) AS JOB_WORKMEDIUMNAME,
              obj.JOB_WORKLARGECTG,
              obj.JOB_WORKMEDIUMCTG
            FROM ONLINEBATCH_SCHEDULE obs 
          INNER JOIN ONLINEBATCH_JOB obj 
              ON obj.JOB_SEQ = obs.JOB_SEQ  ) SCT WHERE RNUM=1 AND SC_DELETEYN =1 ";

        //검색어 있을떄 
        // $queryAnd =" AND obwmc.WorkLarge BETWEEN 1000 AND 1999 AND obj.JOB_DELETEYN = '1' ORDER BY obj.JOB_UPDDATE DESC, obj.JOB_REGDATE DESC, obj.JOB_SEQ";
        if($searchWord!="searchWordNot"  && $WorkLarge !="all"  && $WorkMedium =="all"){
            $query1=$query1." AND JOB_NAME LIKE CONCAT('%'||'".$searchWord."','%')  AND JOB_WORKLARGECTG ='".$WorkLarge."'";
        }else if($searchWord!="searchWordNot" && $WorkLarge !="all" && $WorkMedium !="all"){
            $query1=$query1." AND JOB_NAME LIKE CONCAT('%'||'".$searchWord."','%') AND JOB_WORKLARGECTG ='".$WorkLarge."' AND JOB_WORKMEDIUMCTG ='".$WorkMedium."'";
        }else if($searchWord!="searchWordNot" && $WorkLarge =="all"&& $WorkMedium =="all"){
            $query1=$query1." AND JOB_NAME LIKE CONCAT('%'||'".$searchWord."','%') ";
        }
        //검색어 없을때
        if($searchWord=="searchWordNot"  && $WorkLarge !="all" && $WorkMedium =="all"){
            $query1=$query1." AND JOB_WORKLARGECTG ='".$WorkLarge."'";
        }else if($searchWord=="searchWordNot" && $WorkLarge !="all" && $WorkMedium !="all"){
          // $query1=$query1." WHERE obp.P_WORKLARGECTG ='".$WorkLarge."' AND obp.P_WORKMEDIUMCTG = '".$WorkMedium."'";
          $query1=$query1." AND JOB_WORKLARGECTG ='".$WorkLarge."' AND JOB_WORKMEDIUMCTG='".$WorkMedium."'" ;
        }else if($searchWord=="searchWordNot" && $WorkLarge =="all" && $WorkMedium =="all"){
            // $query1=$query1." WHERE obp.P_WORKLARGECTG ='".$WorkLarge."' AND obp.P_WORKMEDIUMCTG = '".$WorkMedium."'";
            $query1=$query1;
        }

        // 실행일 기준 
        if($cronStartDate == null && $cronEndDate != null){
        $query1 = $query1." AND TO_DATE(TO_CHAR(SC_CRONTIME,'YYYY-MM-DD'),'YYYY-MM-DD') <= TO_DATE('".$cronEndDate."','YYYY-MM-DD') ";
        }else if($cronStartDate != null && $cronEndDate != null){
          $query1 = $query1." AND TO_DATE(TO_CHAR(SC_CRONTIME,'YYYY-MM-DD'),'YYYY-MM-DD') BETWEEN TO_DATE('".$cronStartDate."','YYYY-MM-DD') AND TO_DATE('".$cronEndDate."','YYYY-MM-DD') ";
        }else if($cronStartDate != null && $cronEndDate == null){
          $query1 = $query1." AND TO_DATE(TO_CHAR(SC_CRONTIME,'YYYY-MM-DD'),'YYYY-MM-DD') >= TO_DATE('".$cronStartDate."','YYYY-MM-DD') ";
        }else if($cronStartDate == null && $cronEndDate == null){
          $query1 = $query1."  AND TO_DATE(TO_CHAR(SC_CRONTIME,'YYYY-MM-DD'),'YYYY-MM-DD') = TO_DATE(TO_CHAR(sysdate,'YYYY-MM-DD'),'YYYY-MM-DD') ";
        }
       
        if($status != '0,0,0,0'){
          $statusExplode=explode(',',$status);
          $query2 = "AND ( ";
          $query1 = $query1.$query2;
          $count = 0;
          if($statusExplode[0]=='20'){
            if($count!=0){
              $query2=" OR ";
            }else {
              $query2="";
            }
            $query1 = $query1.$query2."  SC_STATUS LIKE '".substr($statusExplode[0],0,3)."%'";
            $count = $count+1;
          }
          if($statusExplode[1]=='30'){
            if($count!=0){
              $query2=" OR ";
            }else {
              $query2="";
            }
            $query1 = $query1.$query2."  SC_STATUS LIKE '".substr($statusExplode[1],0,3)."%'";
            $count = $count+1;
          }
          if($statusExplode[2]=='90'){
            if($count!=0){
              $query2=" OR ";
            }else {
              $query2="";
            }
            $query1 = $query1.$query2."  SC_STATUS LIKE '".substr($statusExplode[2],0,3)."%'";
            $count = $count+1;
          }
          if($statusExplode[3]=='40'){
            if($count!=0){
              $query2=" OR ";
            }else {
              $query2="";
            }
            $query1 = $query1.$query2."  SC_STATUS LIKE '".substr($statusExplode[3],0,3)."%'";
            $count = $count+1;
          }
          $query1=$query1.")";
        }
        $MonitorContents=DB::select($query1);
        return $MonitorContents;
    }

}
