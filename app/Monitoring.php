<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTime;
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
        (SELECT SHORTNAME FROM ONLINEBATCH_WORKMEDIUMCODE WHERE WORKLARGE=SUBSTR(SC_STATUS,1,2) AND WORKMEDIUM = CASE WHEN LENGTH(SC_STATUS)=3 THEN SUBSTR(SC_STATUS,3) ELSE SUBSTR(SC_STATUS,3,LENGTH(SC_STATUS)) END ) AS SC_STATUS,
          SC_REGID,
          JOB_NAME,
          JOB_WORKLARGECTG,
          JOB_WORKMEDIUMCTG,
          SC_VERSION,
          SC_REBUTTON,
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
                obj.JOB_WORKMEDIUMCTG,
                obs.SC_VERSION,
                obs.SC_REBUTTON
              FROM 
                ONLINEBATCH_SCHEDULE obs 
            INNER JOIN ONLINEBATCH_JOB obj 
              ON obj.JOB_SEQ = obs.JOB_SEQ  ) SCT WHERE RNUM=1 AND SC_DELETEYN =1";

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
    //모니터링 프로그램 목록 조회
    public function monitoringProcessList($jobSeq,$scSeq){
      $query1 = "
        SELECT
          OBSP.JOB_SEQ,
          OBSP.SC_SEQ,
          OBSP.P_SEQ,
          OBSP.SC_P_SEQ,
          OBP.P_FILE,
          OBP.P_NAME,
          OBP.P_SULMYUNG,
          (
            SELECT 
              OBWMC.LONGNAME 
            FROM 
              ONLINEBATCH_WORKMEDIUMCODE OBWMC 
            WHERE 
              SUBSTR(OBSP.JOBSM_P_STATUS,1,2) = OBWMC.WORKLARGE 
              AND CASE WHEN LENGTH(OBSP.JOBSM_P_STATUS)=3 THEN SUBSTR(OBSP.JOBSM_P_STATUS,3) ELSE SUBSTR(OBSP.JOBSM_P_STATUS,3,LENGTH(OBSP.JOBSM_P_STATUS)) END = OBWMC.WORKMEDIUM) AS JOBSM_P_STATUS,
          OBSP.JOBSM_P_STARTTIME,
          OBSP.JOBSM_P_ENDTIME,
          OBJ.JOB_PARAMS,
          OBJ.JOB_PARAMSULMYUNGS,
          OBJG.JOBGUSUNG_PARAMPOS,
          OBS.SC_PARAM,
          OBP.P_PARAMS,
          OBP.P_PARAMSULMYUNGS,
          OBP.P_YESANGTIME,
          OBP.P_YESANGMAXTIME,
          (SELECT CASE WHEN OBSP.SC_REWORKYN='1' THEN 'Y' ELSE 'N'END AS SC_REWORKYN FROM DUAL) AS SC_REWORKYN
        FROM
          ONLINEBATCH_SCHEDULEPROCESS OBSP
        INNER JOIN ONLINEBATCH_SCHEDULE OBS ON
          OBSP.SC_SEQ =OBS.SC_SEQ
        INNER JOIN ONLINEBATCH_JOBGUSUNG OBJG ON
          OBSP.JOB_SEQ = OBJG.JOB_SEQ
          AND	OBSP.P_SEQ = OBJG.P_SEQ
        INNER JOIN ONLINEBATCH_PROCESS OBP ON
          OBSP.P_SEQ = OBP.P_SEQ
        INNER JOIN ONLINEBATCH_JOB OBJ ON
          OBSP.JOB_SEQ = OBJ.JOB_SEQ
        WHERE OBSP.JOB_SEQ = '".$jobSeq."'
        AND OBSP.SC_SEQ ='".$scSeq."'
        ORDER BY OBJG.JOBGUSUNG_ORDER
      ";
      $processList=DB::select($query1);
      return $processList;
    }
    //모니터링 프로세스 상세보기
    public function monitorProcessDetail($scSeq,$pSeq){
        $query1="
        SELECT
          OBP.*,
          OBSP.JOB_SEQ,
          OBSP.SC_SEQ,
          OBSP.SC_P_SEQ,
          OBSP.JOBSM_P_STARTTIME,
          OBSP.JOBSM_P_ENDTIME,
          OBSP.JOBSM_P_STATUS,
          OBSP.SC_LOGFILE,
          OBSP.SC_REWORKYN,
          (SELECT OBWL.LONGNAME FROM INCAR.ONLINEBATCH_WORKLARGECODE OBWL WHERE OBP.P_WORKLARGECTG = OBWL.WORKLARGE) AS P_WORKLARGENAME,
          (SELECT OBWM.LONGNAME FROM INCAR.ONLINEBATCH_WORKMEDIUMCODE OBWM WHERE OBP.P_WORKLARGECTG = OBWM.WORKLARGE AND OBP.P_WORKMEDIUMCTG = OBWM.WORKMEDIUM) AS P_WORKMEDIUMNAME,
          (SELECT OBWM.FILEPATH FROM INCAR.ONLINEBATCH_WORKMEDIUMCODE OBWM WHERE OBP.P_WORKLARGECTG = OBWM.WORKLARGE AND OBP.P_WORKMEDIUMCTG = OBWM.WORKMEDIUM) AS FILEPATH,
          (SELECT OBWM.LONGNAME FROM INCAR.ONLINEBATCH_WORKMEDIUMCODE OBWM WHERE SUBSTR(OBSP.JOBSM_P_STATUS,1,2) = OBWM.WORKLARGE AND CASE WHEN LENGTH(OBSP.JOBSM_P_STATUS)=3 THEN SUBSTR(OBSP.JOBSM_P_STATUS,3) ELSE SUBSTR(OBSP.JOBSM_P_STATUS,3,LENGTH(OBSP.JOBSM_P_STATUS)) END = OBWM.WORKMEDIUM) AS JOBSM_P_STATUS
        FROM
          INCAR.ONLINEBATCH_PROCESS OBP
        INNER JOIN INCAR.ONLINEBATCH_SCHEDULEPROCESS OBSP ON
          OBP.P_SEQ = OBSP.P_SEQ
        WHERE OBSP.SC_SEQ = '".$scSeq."'
        AND	OBP.P_SEQ = '".$pSeq."'
        ";
        $processDetail=DB::select($query1);
        return $processDetail;
    }
    //모니터링 재작업 체크 성공 카운트 (완료된거 제외한 카운트)
    public function monitorCompleteCount($scSeq){
    $query1="SELECT  
              COUNT(obsp.JOBSM_P_STATUS)
            FROM 
              ONLINEBATCH_SCHEDULE os
            INNER JOIN 
              ONLINEBATCH_SCHEDULEPROCESS obsp 
              ON os.SC_SEQ = obsp.SC_SEQ 
            INNER JOIN 
              ONLINEBATCH_PROCESS obp 
              ON obsp.P_SEQ=obp.P_SEQ
            WHERE 
              SUBSTR(obsp.JOBSM_P_STATUS ,1,2) != '90'  
              AND obsp.SC_SEQ ='".$scSeq."'
            GROUP BY 
              obsp.JOBSM_P_STATUS
              ";
      $successCount=DB::select($query1);
      return $successCount;
    }
    //프로그램별 재작업 카운트 
    public function monitorReWorkCount($scSeq){
    $query1="SELECT COUNT(SC_REWORKYN)
            FROM ONLINEBATCH_SCHEDULE os 
            INNER JOIN ONLINEBATCH_SCHEDULEPROCESS obsp ON os.SC_SEQ =obsp.SC_SEQ 
            INNER JOIN ONLINEBATCH_PROCESS op ON obsp.P_SEQ =op.P_SEQ 
            WHERE os.SC_SEQ = '".$scSeq."' AND obsp.SC_REWORKYN = 0
            GROUP BY obsp.SC_REWORKYN";
     $reWorkCount=DB::select($query1);
     return $reWorkCount;
    }
    //모니터링 차트 데이터 
    public function chartViewData($date){
      $query1 = "
        SELECT 
          RNUM,
          SC_SEQ,
          JOB_SEQ,
          (SELECT SHORTNAME FROM ONLINEBATCH_WORKMEDIUMCODE WHERE WORKLARGE=SUBSTR(SC_STATUS,1,2) AND WORKMEDIUM = CASE WHEN LENGTH(SC_STATUS)=3 THEN SUBSTR(SC_STATUS,3) ELSE SUBSTR(SC_STATUS,3,LENGTH(SC_STATUS)) END ) AS SC_STATUS,
          ISLEAF,
          SC_CRONTIME,
          SC_DELETEYN
        FROM (    
          SELECT   
              ROW_NUMBER() OVER(PARTITION BY obs.JOB_SEQ,obs.SC_REGDATE ORDER BY obs.SC_STARTTIME DESC NULLS LAST, obs.SC_CRONTIME ASC) AS RNUM,
              obs.SC_SEQ,
              obs.JOB_SEQ,
              obs.SC_STATUS,
              CONNECT_BY_ISLEAF as ISLEAF,
              obs.SC_CRONTIME,
              obs.SC_DELETEYN 
            FROM 
              ONLINEBATCH_SCHEDULE obs 
            INNER JOIN ONLINEBATCH_JOB obj 
              ON obj.JOB_SEQ = obs.JOB_SEQ  
            START WITH 
              obs.SC_PREVSEQ IS NULL  
            CONNECT BY PRIOR 
              obs.SC_SEQ = obs.SC_PREVSEQ    
          ) SCT 
          WHERE 
            RNUM=1 AND SC_DELETEYN =1 AND ISLEAF=1 AND TO_CHAR(SC_CRONTIME,'YYYY-MM-DD') = '".$date."'";
      $result=DB::select($query1);
      $newArrResult ="";
      $newArrResult2 = "";
      if(count($result)!=0){
        foreach ($result as $row){
          $newArrResult =$this->monitoringScheduleProcessGusung($row->job_seq,$row->sc_seq);
          if($newArrResult!="notSearchData"){
            $newArrResult2 = $newArrResult2.substr($newArrResult,0,strlen($newArrResult)-1).",";
          }else{
            return "notSearchData";
          }
        }
      }else if(count($result)==0){
        return "notSearchData";
      }
      return "[".substr($newArrResult2,0,strlen($newArrResult2)-1)."]";
    }
     //모니터링 차트  프로그램 시간 ,정보 구하는 메서드
    public function monitoringScheduleProcessGusung($jobSeq,$scSeq){
      $query1="
        SELECT 
            obsp.SC_SEQ,
            obsp.P_SEQ,
            obsp.JOB_SEQ,
            obsp.JOBSM_P_STARTTIME,
            obsp.JOBSM_P_ENDTIME,
            SUBSTR(obsp.JOBSM_P_STATUS,1,2) AS JOBSM_P_STATUS,
            TO_CHAR(obs.SC_CRONTIME,'YYYY-MM-DD HH24:MI') AS SC_CRONTIME,
            (SELECT obp.P_Name FROM OnlineBatch_Process obp WHERE obp.P_Seq=objg.P_Seq) as P_Name,
            (SELECT obj.Job_WorkLargeCtg FROM OnlineBatch_Job obj WHERE obj.Job_Seq = objg.Job_Seq ) AS WorkLarge,
            (SELECT obj.Job_WorkMediumCtg FROM OnlineBatch_Job obj WHERE obj.Job_Seq = objg.Job_Seq ) AS WorkMedium,
            objg.JobGusung_Order AS JobGusung_Order,
             (SELECT owm.LongName FROM OnlineBatch_WorkMediumCode owm WHERE  owm.WorkLarge =substr(obsp.JOBSM_P_STATUS,1,2) AND owm.WorkMedium =substr(obsp.JOBSM_P_STATUS,-1)) as JOBSM_P_STATUSNAME,
            (SELECT obp.P_YESANGTIME FROM OnlineBatch_Process obp WHERE obp.P_Seq=objg.P_Seq) as P_YESANGTIME,
            (SELECT obp.P_YESANGMAXTIME FROM OnlineBatch_Process obp WHERE obp.P_Seq=objg.P_Seq) as P_YESANGMAXTIME,
            (SELECT obp.P_FILE FROM OnlineBatch_Process obp WHERE obp.P_Seq=objg.P_Seq) as P_FILE
        FROM 
            OnlineBatch_ScheduleProcess obsp
        INNER JOIN 
            OnlineBatch_JobGusung objg 
            ON objg.Job_Seq = obsp.Job_Seq AND objg.P_Seq =obsp.P_Seq 
        INNER JOIN 
            OnlineBatch_Schedule obs
            ON obs.Job_Seq =obsp.Job_Seq AND obs.Sc_Seq =obsp.Sc_Seq 
        WHERE 
            obsp.Job_Seq ='".$jobSeq."' AND obsp.Sc_Seq ='".$scSeq."'
        ORDER BY 
            objg.JobGusung_Order";
   
    $programStartTime = "";
    $programEndTime ="";
    $arrResult="";
    $arrResult2="";
    $result=DB::select($query1);
    if(count($result)!=0){
      foreach($result as $i => $row){
        if($i==0){
          //프로그램의 시작시간과 종료시간이 값이 둘다 있을떄는 진행시간을 구할수 있지만 없을떄는 예상시간으로 프로그램 예상 진행시간을 구해서 나타냄
          if($row->jobsm_p_starttime!=null && $row->jobsm_p_endtime!=null){
            $programStartTime = $row->jobsm_p_starttime;
            $programEndTime = $row->jobsm_p_endtime;
          }else{
            $programStartTime = $row->sc_crontime;
            $programEndTime = strtotime("+".$row->p_yesangmaxtime." minutes ".$programStartTime);
            $programEndTime = date("Y-m-d H:i",$programEndTime );
          }
        }else{ 
          if($row->jobsm_p_starttime!=null && $row->jobsm_p_endtime!=null){
            $programStartTime = $row->jobsm_p_starttime;
            $programEndTime = $row->jobsm_p_endtime;
          }else{
            $programStartTime = $programEndTime;
            $programEndTime = strtotime("+".$row->p_yesangmaxtime." minutes ".$programStartTime);
            $programEndTime = date("Y-m-d H:i",$programEndTime);
          }
        }
        if($row->jobsm_p_status=='10'){
          $arrResult = $arrResult.'{"name":"'.$row->sc_seq.'","start":"'.$programStartTime.'","end":"'.$programEndTime.'","color":"#FFCF32","pstatus":"'.$row->jobsm_p_statusname.'","pfile":"'.$row->p_file.'"},';
        }
        if($row->jobsm_p_status=='20'){
          $arrResult = $arrResult.'{"name":"'.$row->sc_seq.'","start":"'.$programStartTime.'","end":"'.$programEndTime.'","color":"#2E84BB","pstatus":"'.$row->jobsm_p_statusname.'","pfile":"'.$row->p_file.'"},';
        }
        if($row->jobsm_p_status=='40'){
          $arrResult = $arrResult.'{"name":"'.$row->sc_seq.'","start":"'.$programStartTime.'","end":"'.$programEndTime.'","color":"#F0002B","pstatus":"'.$row->jobsm_p_statusname.'","pfile":"'.$row->p_file.'"},';
        }
        if($row->jobsm_p_status=='90'){
          $arrResult = $arrResult.'{"name":"'.$row->sc_seq.'","start":"'.$programStartTime.'","end":"'.$programEndTime.'","color":"#992CC0","pstatus":"'.$row->jobsm_p_statusname.'","pfile":"'.$row->p_file.'"},';
        }
  
        $arrResult2=$arrResult2.$arrResult;
        $i++;
      }
    }else {
      $arrResult2="notSearchData";
    }
    return $arrResult2;
  }
}
