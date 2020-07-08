<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Schedule extends Model
{
    //스케줄 검색 목록(전체 포함)
    public function scheduleUsedList($searchWord,$WorkLarge,$WorkMedium){
        $query1="
        SELECT 
            RNUM,
            SC_SEQ,
            JOB_SEQ,
            SC_REGDATE,
            SC_STARTTIME,
            SC_CRONTIME,
            SC_SULMYUNG,
            SC_CRONSULMYUNG,
            SC_DELETEYN,
            SC_REGID,
            JOB_NAME,
            JOB_REGID,
            JOB_REGIP,
            JOB_REGDATE,
            JOB_UPDDATE,
            JOB_DELETEYN,
            JOB_WORKLARGECTG,
            JOB_WORKMEDIUMCTG,
            JOB_WORKLARGENAME,
            JOB_WORKMEDIUMNAME,
            SC_LEVEL,
            SC_PREVSEQ,
            ISLEAF
        FROM (    
            SELECT  
                ROW_NUMBER() OVER(PARTITION BY obs.JOB_SEQ,obs.SC_REGDATE ORDER BY obs.SC_STARTTIME DESC NULLS LAST,obs.SC_SEQ,obs.SC_CRONTIME ASC,obs.JOB_SEQ,obs.SC_REGDATE) AS RNUM,
                obs.SC_SEQ,
                obs.JOB_SEQ,
                obs.SC_REGDATE,
                obs.SC_STARTTIME,
                obs.SC_CRONTIME,
                obs.SC_SULMYUNG,
                obs.SC_CRONSULMYUNG,
                obs.SC_DELETEYN,
                (SELECT USER_NAME FROM ONLINEBATCH_USER ou WHERE ou.USER_SAWONNUM =obs.SC_REGID) AS SC_REGID ,
                obj.JOB_NAME,
                obj.JOB_REGID,
                obj.JOB_REGIP,
                obj.JOB_UPDID,
                obj.JOB_UPDIP,
                obj.JOB_REGDATE,
                obj.JOB_UPDDATE,
                obj.JOB_DELETEYN,
                obj.JOB_WORKLARGECTG,
                obj.JOB_WORKMEDIUMCTG,
                (SELECT owl.SHORTNAME FROM ONLINEBATCH_WORKLARGECODE owl WHERE owl.WORKLARGE = obj.JOB_WORKLARGECTG) AS JOB_WORKLARGENAME,
                (SELECT owm.SHORTNAME FROM ONLINEBATCH_WORKMEDIUMCODE owm WHERE owm.WORKLARGE =obj.JOB_WORKLARGECTG AND owm.WORKMEDIUM = obj.JOB_WORKMEDIUMCTG) AS JOB_WORKMEDIUMNAME,
                obs.SC_LEVEL,
                obs.SC_PREVSEQ,
                CONNECT_BY_ISLEAF as ISLEAF
            FROM ONLINEBATCH_SCHEDULE obs 
            INNER JOIN ONLINEBATCH_JOB obj 
                ON obj.JOB_SEQ = obs.JOB_SEQ
            INNER JOIN ONLINEBATCH_WORKMEDIUMCODE obwmc 
                ON obj.JOB_WORKLARGECTG = obwmc.WORKLARGE AND obj.JOB_WORKMEDIUMCTG = obwmc.WORKMEDIUM 
            INNER JOIN ONLINEBATCH_WORKLARGECODE obwlc 
                ON obwlc.WORKLARGE = obwmc.WORKLARGE AND obwlc.USED=1
            START WITH 
                obs.SC_PREVSEQ IS NULL  
            CONNECT BY PRIOR 
                obs.SC_SEQ = obs.SC_PREVSEQ      
            ) ";
        //검색어 있을떄 
        $queryAnd =" AND JOB_WORKLARGECTG BETWEEN 1000 AND 1999 AND JOB_DELETEYN = '1' AND SC_DELETEYN=1  ORDER BY JOB_UPDDATE DESC, JOB_REGDATE DESC, SC_SEQ ,JOB_SEQ  ";
        if($searchWord!="searchWordNot"  && $WorkLarge !="all"  && $WorkMedium =="all"){

            $query1=$query1." WHERE RNUM=1 AND JOB_NAME like concat('%'||'".$searchWord."','%')  AND JOB_WORKLARGECTG ='".$WorkLarge."' AND ISLEAF =1 ";
            $query1=$query1.$queryAnd;

        }else if($searchWord!="searchWordNot" && $WorkLarge !="all" && $WorkMedium !="all"){

            $query1=$query1." WHERE RNUM=1 AND  JOB_NAME like concat('%'||'".$searchWord."','%') AND JOB_WORKLARGECTG ='".$WorkLarge."' AND JOB_WORKMEDIUMCTG ='".$WorkMedium."' AND ISLEAF =1 ";
            $query1=$query1.$queryAnd;     

        }else if($searchWord!="searchWordNot" && $WorkLarge =="all"&& $WorkMedium =="all"){

            $query1=$query1." WHERE RNUM=1 AND  JOB_NAME like concat('%'||'".$searchWord."','%') AND ISLEAF =1 ";
            $query1=$query1.$queryAnd;

        }
        //검색어 없을때
        if($searchWord=="searchWordNot"  && $WorkLarge !="all" && $WorkMedium =="all"){
            $query1=$query1." WHERE RNUM=1 AND JOB_WORKLARGECTG ='".$WorkLarge."' AND ISLEAF =1 ";
            $query1=$query1.$queryAnd;
        }
        if($searchWord=="searchWordNot" && $WorkLarge =="all" && $WorkMedium =="all"){
            // $query1=$query1." WHERE obp.P_WORKLARGECTG ='".$WorkLarge."' AND obp.P_WORKMEDIUMCTG = '".$WorkMedium."'";
            $query1=$query1."WHERE RNUM=1 AND ISLEAF =1 ".$queryAnd;
        }

        $jobContents=DB::select($query1);
        return $jobContents;
    }
    //스케줄 잡 구성 리스트 
    public function scheduleJobGusungList($searchWord,$WorkLarge,$WorkMedium){
        $query1="
        SELECT 
            obj.*,
            (SELECT owl.SHORTNAME FROM ONLINEBATCH_WORKLARGECODE owl WHERE owl.WORKLARGE = obwmc.WORKLARGE ) as job_worklargename,(SELECT oc.LONGNAME FROM ONLINEBATCH_WORKMEDIUMCODE oc WHERE oc.WORKLARGE =obj.JOB_WORKLARGECTG AND oc.WORKMEDIUM = obj.JOB_WORKMEDIUMCTG) as JOB_WORKMEDIUMNAME 
        FROM 
            ONLINEBATCH_JOB obj
        INNER JOIN 
            ONLINEBATCH_WORKMEDIUMCODE obwmc ON obj.JOB_WORKLARGECTG = obwmc.WORKLARGE AND obj.JOB_WORKMEDIUMCTG = obwmc.WORKMEDIUM  AND obwmc.USED =1 
        INNER JOIN 
            ONLINEBATCH_WORKLARGECODE obwlc ON obwlc.WORKLARGE =obwmc.WORKLARGE AND obwlc.USED =1
        ";
        //검색어 있을떄 
        $queryAnd =" AND obwmc.WorkLarge BETWEEN 1000 AND 1999 AND obj.JOB_DELETEYN = '1' ORDER BY obj.JOB_UPDDATE DESC, obj.JOB_REGDATE DESC, obj.JOB_SEQ";
        if($searchWord!="searchWordNot"  && $WorkLarge !="all"  && $WorkMedium =="all"){

            $query1=$query1."WHERE obj.JOB_NAME like concat('%'||'".$searchWord."','%')  AND obj.JOB_WORKLARGECTG ='".$WorkLarge."'";
            $query1=$query1.$queryAnd;

        }else if($searchWord!="searchWordNot" && $WorkLarge !="all" && $WorkMedium !="all"){

            $query1=$query1."WHERE obj.JOB_NAME like concat('%'||'".$searchWord."','%') AND obj.JOB_WORKLARGECTG ='".$WorkLarge."' AND obj.JOB_WORKMEDIUMCTG ='".$WorkMedium."'";
            $query1=$query1.$queryAnd;     

        }else if($searchWord!="searchWordNot" && $WorkLarge =="all"&& $WorkMedium =="all"){

            $query1=$query1."WHERE obj.JOB_Name like concat('%'||'".$searchWord."','%') ";
            $query1=$query1.$queryAnd;

        }
        //검색어 없을때
        if($searchWord=="searchWordNot"  && $WorkLarge !="all" && $WorkMedium =="all"){
            $query1=$query1."WHERE obj.JOB_WORKLARGECTG ='".$WorkLarge."'";
            $query1=$query1.$queryAnd;
        }
        if($searchWord=="searchWordNot" && $WorkLarge =="all" && $WorkMedium =="all"){
            // $query1=$query1." WHERE obp.P_WORKLARGECTG ='".$WorkLarge."' AND obp.P_WORKMEDIUMCTG = '".$WorkMedium."'";
            $query1=$query1.$queryAnd;
        }

        $jobContents=DB::select($query1);
        return $jobContents;
    }
    //스케줄 프로그램 리스트
    public function scheduleProgramList($jobSeq,$scSeq){
        $query1="
 		SELECT 
            obsp.*,
            op.P_NAME,
            op.P_FILE,
            op.P_PARAMS,
            op.P_PARAMSULMYUNGS,
            op.P_REWORKYN,
            objg.JOBGUSUNG_ORDER as p_order,
            objg.JOBGUSUNG_PARAMPOS,
            op.P_FILEPATH,
            job.JOB_PARAMS,
            job.JOB_PARAMSULMYUNGS,
            op.P_TEXTINPUTCHECK,
            op.P_FILEOUTPUTCHECK,
            op.P_PRIVATECHECK,
            op.P_WORKLARGECTG,
            op.P_WORKMEDIUMCTG,
            op.P_SULMYUNG
        FROM 
            ONLINEBATCH_SCHEDULEPROCESS obsp
        LEFT JOIN 
            ONLINEBATCH_JOB job on job.JOB_SEQ = obsp.JOB_SEQ
        INNER JOIN(
            SELECT * 
            FROM ONLINEBATCH_JOBGUSUNG
            ORDER BY JOBGUSUNG_ORDER 
        ) objg 
            ON obsp.JOB_SEQ = objg.JOB_SEQ
            AND obsp.P_SEQ  = objg.P_SEQ 
            INNER JOIN (
                SELECT 
                    code.FILEPATH  AS P_FILEPATH,
                    op.* 
                FROM 
                    ONLINEBATCH_PROCESS op 
                INNER JOIN 
                    ONLINEBATCH_WORKMEDIUMCODE code  
                ON  op.P_WORKLARGECTG = code.WORKLARGE 
                AND op.P_WORKMEDIUMCTG =code.WORKMEDIUM 
            ) op 
            ON op.P_SEQ =OBJG.P_SEQ  
        WHERE obsp.JOB_SEQ ='".$jobSeq."' AND obsp.SC_SEQ ='".$scSeq."'
        ORDER BY objg.JOBGUSUNG_ORDER 
        ";
        $jobGusungContents=DB::select($query1);
        return $jobGusungContents;
    }
    //스케줄 상세정보 
    public function scheduleDetail($jobSeq,$scSeq){
        $query1="
        SELECT 
            os.*,
            (SELECT owm.Sulmyung FROM OnlineBatch_WorkMediumCode owm WHERE  owm.WorkLarge =substr(os.Sc_Status,1,2) AND owm.WorkMedium =substr(os.Sc_Status,-1)) as Sc_StatusName,
            (SELECT count(*) FROM OnlineBatch_JobGusung objg WHERE objg.Job_Seq='".$jobSeq."') as gusungCount
        FROM 
            OnlineBatch_Schedule os WHERE os.Job_Seq = '".$jobSeq."' AND os.Sc_Seq = '".$scSeq."'
        ";

        $scheduleDetail=DB::select($query1);
        return $scheduleDetail;
    }
    //스케줄 토탈 시간
    public function scheduleTotalTime($jobSeq,$scSeq){
        $query1="
        SELECT 
            obsp.JOB_SEQ AS job_seq , 
            sum(obp.P_YESANGTIME) AS sc_yesangtime,
            sum(obp.P_YESANGMAXTIME) AS sc_yesangmaxtime 
        FROM 
            ONLINEBATCH_SCHEDULEPROCESS obsp
        INNER JOIN 
            ONLINEBATCH_PROCESS obp
            ON obp.P_SEQ = obsp.P_SEQ
        WHERE obsp.JOB_SEQ ='".$jobSeq."' AND obsp.SC_SEQ='".$scSeq."'
        GROUP BY obsp.JOB_SEQ 
        ";
        $scheduleTotalTime=DB::select($query1);
        return $scheduleTotalTime;
    }

    //스케줄 달력 ajax
    public function getScheduleInfo($date){
        $query1="
        SELECT 
            RNUM,
            SC_SEQ,
            JOB_SEQ,
            SC_CRONTIME,
            SC_DELETEYN,
            (SELECT SHORTNAME FROM ONLINEBATCH_WORKMEDIUMCODE WHERE WORKLARGE=SUBSTR(SC_STATUS,1,2) AND WORKMEDIUM = CASE WHEN LENGTH(SC_STATUS)=3 THEN SUBSTR(SC_STATUS,3) ELSE SUBSTR(SC_STATUS,3,LENGTH(SC_STATUS)) END ) AS SC_STATUS,
            JOB_NAME,
            substr(SC_STATUS2,1,2) AS SC_STATUS2
        FROM (    
          SELECT   
              ROW_NUMBER() OVER(PARTITION BY obs.JOB_SEQ,obs.SC_REGDATE ORDER BY obs.SC_STARTTIME DESC NULLS LAST, obs.SC_CRONTIME ASC) AS RNUM,
              obs.SC_SEQ,
              obs.JOB_SEQ,
              obs.SC_CRONTIME,
              obs.SC_DELETEYN,
              obs.SC_STATUS,
              obj.JOB_NAME,
              obs.SC_STATUS AS SC_STATUS2
            FROM 
              ONLINEBATCH_SCHEDULE obs 
            INNER JOIN ONLINEBATCH_JOB obj 
                ON obj.JOB_SEQ = obs.JOB_SEQ  ) SCT WHERE SC_DELETEYN =1 AND TO_CHAR(SC_CRONTIME,'YYYY-MM')='".$date."'";
            $result=DB::select($query1);
            return $result;
    }

    //스케줄 이벤트 정보 출력
    public function getEventInfo($scSeq){
        $query1="
        SELECT 
            SC_SEQ,
            JOB_SEQ,
            SC_CRONTIME,
            SC_DELETEYN,
            (SELECT SHORTNAME FROM ONLINEBATCH_WORKMEDIUMCODE WHERE WORKLARGE=SUBSTR(SC_STATUS,1,2) AND WORKMEDIUM = CASE WHEN LENGTH(SC_STATUS)=3 THEN SUBSTR(SC_STATUS,3) ELSE SUBSTR(SC_STATUS,3,LENGTH(SC_STATUS)) END ) AS SC_STATUS,
            JOB_NAME,
            JOB_WORKLARGECTG,
            JOB_WORKMEDIUMCTG,
            SC_SULMYUNG,
            SC_CRONSULMYUNG,
            SC_STARTTIME,
            SC_ENDTIME
        FROM (    
          SELECT   
              obs.SC_SEQ,
              obs.JOB_SEQ,
              obs.SC_CRONTIME,
              obs.SC_DELETEYN,
              obs.SC_STATUS,
              obj.JOB_NAME,
              obj.JOB_WORKLARGECTG,
              obj.JOB_WORKMEDIUMCTG,
              obs.SC_SULMYUNG,
              obs.SC_CRONSULMYUNG,
              obs.SC_STARTTIME,
              obs.SC_ENDTIME
            FROM 
              ONLINEBATCH_SCHEDULE obs 
            INNER JOIN ONLINEBATCH_JOB obj 
                ON obj.JOB_SEQ = obs.JOB_SEQ  ) SCT WHERE SC_SEQ ='".$scSeq."'";

        $result=DB::select($query1);
        return $result;
    }

    //스케줄 상세 - 스케줄 재작업 히스토리
    public function scheduleReworkHistory($scSeq){
        $query1="
            SELECT 
                RNUM,
                SC_SEQ,
                JOB_SEQ,
                SC_REGDATE,
                SC_STARTTIME,
                SC_ENDTIME,
                SC_CRONTIME,
                SC_CRONENDTIME,
                SC_SULMYUNG,
                SC_CRONSULMYUNG,
                SC_DELETEYN,
                (SELECT SHORTNAME FROM ONLINEBATCH_WORKMEDIUMCODE WHERE WORKLARGE=SUBSTR(SC_STATUS,1,2) AND WORKMEDIUM = CASE WHEN LENGTH(SC_STATUS)=3 THEN SUBSTR(SC_STATUS,3) ELSE SUBSTR(SC_STATUS,3,LENGTH(SC_STATUS)) END ) AS SC_STATUS,
                SC_REGID,
                SC_NOTE,
                SC_LEVEL,
                SC_PREVSEQ
            FROM (    
                SELECT  
                    ROW_NUMBER() OVER(PARTITION BY obs.JOB_SEQ,obs.SC_REGDATE ORDER BY obs.SC_STARTTIME DESC NULLS LAST,obs.SC_SEQ,obs.SC_CRONTIME ASC,obs.JOB_SEQ,obs.SC_REGDATE) AS RNUM,
                    obs.SC_SEQ,
                    obs.JOB_SEQ,
                    obs.SC_REGDATE,
                    obs.SC_STARTTIME,
                    obs.SC_ENDTIME,
                    obs.SC_CRONTIME,
                    obs.SC_CRONENDTIME,
                    obs.SC_SULMYUNG,
                    obs.SC_CRONSULMYUNG,
                    obs.SC_DELETEYN,
                    obs.SC_STATUS,
                    (SELECT USER_NAME FROM ONLINEBATCH_USER ou WHERE ou.USER_SAWONNUM =obs.SC_REGID) AS SC_REGID ,
                    obs.SC_NOTE,
                    obs.SC_LEVEL,
                    obs.SC_PREVSEQ
                FROM ONLINEBATCH_SCHEDULE obs 
                INNER JOIN ONLINEBATCH_JOB obj 
                    ON obj.JOB_SEQ = obs.JOB_SEQ
                INNER JOIN ONLINEBATCH_WORKMEDIUMCODE obwmc 
                    ON obj.JOB_WORKLARGECTG = obwmc.WORKLARGE AND obj.JOB_WORKMEDIUMCTG = obwmc.WORKMEDIUM 
                INNER JOIN ONLINEBATCH_WORKLARGECODE obwlc 
                    ON obwlc.WORKLARGE = obwmc.WORKLARGE AND obwlc.USED=1
                START WITH 
                    obs.SC_SEQ = '".$scSeq."'  
                CONNECT BY PRIOR  
                    obs.SC_PREVSEQ = obs.SC_SEQ 
                ) 
            WHERE RNUM=1 ";
            $result=DB::select($query1);
            return $result;
    }

}

// SELECT 
// RNUM,
// SC_SEQ,
// JOB_SEQ,
// SC_REGDATE,
// SC_STARTTIME,
// SC_ENDTIME,
// SC_CRONTIME,
// SC_SULMYUNG,
// SC_NOTE,
// SC_DELETEYN,
// SC_PARAM,
// (SELECT SHORTNAME FROM ONLINEBATCH_WORKMEDIUMCODE WHERE WORKLARGE=SUBSTR(SC_STATUS,1,2) AND WORKMEDIUM = CASE WHEN LENGTH(SC_STATUS)=3 THEN SUBSTR(SC_STATUS,3) ELSE SUBSTR(SC_STATUS,3,LENGTH(SC_STATUS)) END ) AS SC_STATUS,
// SC_REGID,
// JOB_NAME,
// JOB_WORKLARGECTG,
// JOB_WORKMEDIUMCTG,
// SC_STATUS2,
// (SELECT COUNT(CASE WHEN substr(obsp.JOBSM_P_STATUS,1,2)='90' THEN 1 END) FROM ONLINEBATCH_SCHEDULEPROCESS obsp WHERE obsp.SC_SEQ=SCT.SC_SEQ) STATUS90,
// (SELECT COUNT(CASE WHEN substr(obsp.JOBSM_P_STATUS,1,2)='10' THEN 1 END) FROM ONLINEBATCH_SCHEDULEPROCESS obsp WHERE obsp.SC_SEQ=SCT.SC_SEQ) STATUS10,
// (SELECT COUNT(CASE WHEN substr(obsp.JOBSM_P_STATUS,1,2)='20' THEN 1 END) FROM ONLINEBATCH_SCHEDULEPROCESS obsp WHERE obsp.SC_SEQ=SCT.SC_SEQ) STATUS20,
// (SELECT COUNT(CASE WHEN substr(obsp.JOBSM_P_STATUS,1,2)='40' THEN 1 END) FROM ONLINEBATCH_SCHEDULEPROCESS obsp WHERE obsp.SC_SEQ=SCT.SC_SEQ) STATUS40      
// FROM (    
// SELECT   
//   ROW_NUMBER() OVER(PARTITION BY obs.JOB_SEQ,obs.SC_REGDATE ORDER BY obs.SC_STARTTIME DESC NULLS LAST, obs.SC_CRONTIME ASC) AS RNUM,
//   obs.SC_SEQ,
//   obs.JOB_SEQ,
//   obs.SC_REGDATE,
//   obs.SC_STARTTIME,
//   obs.SC_ENDTIME,
//   obs.SC_CRONTIME,
//   obs.SC_SULMYUNG,
//   obs.SC_NOTE,
//   obs.SC_DELETEYN,
//   obs.SC_PARAM,
//   obs.SC_STATUS,
//   (SELECT USER_NAME FROM ONLINEBATCH_USER ou WHERE ou.USER_SAWONNUM =obs.SC_REGID) AS SC_REGID ,
//   obj.JOB_NAME,
//   (SELECT owl.SHORTNAME FROM ONLINEBATCH_WORKLARGECODE owl WHERE owl.WORKLARGE = obj.JOB_WORKLARGECTG) AS JOB_WORKLARGENAME,
//   (SELECT owm.SHORTNAME FROM ONLINEBATCH_WORKMEDIUMCODE owm WHERE owm.WORKLARGE =obj.JOB_WORKLARGECTG AND owm.WORKMEDIUM = obj.JOB_WORKMEDIUMCTG) AS JOB_WORKMEDIUMNAME,
//   obj.JOB_WORKLARGECTG,
//   obj.JOB_WORKMEDIUMCTG,
//   substr(obs.SC_STATUS,1,2) AS SC_STATUS2
// FROM 
//   ONLINEBATCH_SCHEDULE obs 
// INNER JOIN ONLINEBATCH_JOB obj 
//     ON obj.JOB_SEQ = obs.JOB_SEQ  ) SCT WHERE RNUM=1 AND SC_DELETEYN =1 AND TO_CHAR(SC_CRONTIME,'YYYY-MM')='".$date."'";