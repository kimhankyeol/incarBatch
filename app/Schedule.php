<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Schedule extends Model
{
    //스케줄 검색 목록(전체 포함)
    public function scheduleUsedList($searchWord,$WorkLarge,$WorkMedium){
        $query1="
        SELECT RNUM,SC_SEQ,JOB_SEQ,SC_REGDATE,SC_STARTTIME,SC_CRONTIME,SC_SULMYUNG,SC_CRONSULMYUNG,SC_REGID,JOB_NAME,JOB_REGID,JOB_REGIP,JOB_REGDATE,JOB_UPDDATE,JOB_DELETEYN,JOB_WORKLARGECTG,JOB_WORKMEDIUMCTG,JOB_WORKLARGENAME,JOB_WORKMEDIUMNAME
        FROM (    
            SELECT  
                ROW_NUMBER() OVER(PARTITION BY obs.JOB_SEQ,obs.SC_REGDATE ORDER BY obs.SC_SEQ,obs.SC_STARTTIME DESC, obs.SC_CRONTIME ASC,obs.JOB_SEQ,obs.SC_REGDATE) AS RNUM,
                obs.SC_SEQ,
                obs.JOB_SEQ,
                obs.SC_REGDATE,
                obs.SC_STARTTIME,
                obs.SC_CRONTIME,
                obs.SC_SULMYUNG,
                obs.SC_CRONSULMYUNG,
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
                (SELECT owm.SHORTNAME FROM ONLINEBATCH_WORKMEDIUMCODE owm WHERE owm.WORKLARGE =obj.JOB_WORKLARGECTG AND owm.WORKMEDIUM = obj.JOB_WORKMEDIUMCTG) AS JOB_WORKMEDIUMNAME
        FROM ONLINEBATCH_SCHEDULE obs 
        INNER JOIN ONLINEBATCH_JOB obj 
            ON obj.JOB_SEQ = obs.JOB_SEQ
        INNER JOIN ONLINEBATCH_WORKMEDIUMCODE obwmc 
            ON obj.JOB_WORKLARGECTG = obwmc.WORKLARGE AND obj.JOB_WORKMEDIUMCTG = obwmc.WORKMEDIUM 
        INNER JOIN ONLINEBATCH_WORKLARGECODE obwlc 
            ON obwlc.WORKLARGE = obwmc.WORKLARGE AND obwlc.USED=1
         ) 
        ";
        //검색어 있을떄 
        $queryAnd =" AND JOB_WORKLARGECTG BETWEEN 1000 AND 1999 AND JOB_DELETEYN = '1' ORDER BY JOB_UPDDATE DESC, JOB_REGDATE DESC, SC_SEQ ,JOB_SEQ  ";
        if($searchWord!="searchWordNot"  && $WorkLarge !="all"  && $WorkMedium =="all"){

            $query1=$query1." WHERE RNUM=1 AND JOB_NAME like concat('%'||'".$searchWord."','%')  AND JOB_WORKLARGECTG ='".$WorkLarge."'";
            $query1=$query1.$queryAnd;

        }else if($searchWord!="searchWordNot" && $WorkLarge !="all" && $WorkMedium !="all"){

            $query1=$query1." WHERE RNUM=1 AND  JOB_NAME like concat('%'||'".$searchWord."','%') AND JOB_WORKLARGECTG ='".$WorkLarge."' AND JOB_WORKMEDIUMCTG ='".$WorkMedium."'";
            $query1=$query1.$queryAnd;     

        }else if($searchWord!="searchWordNot" && $WorkLarge =="all"&& $WorkMedium =="all"){

            $query1=$query1." WHERE RNUM=1 AND  JOB_NAME like concat('%'||'".$searchWord."','%') ";
            $query1=$query1.$queryAnd;

        }
        //검색어 없을때
        if($searchWord=="searchWordNot"  && $WorkLarge !="all" && $WorkMedium =="all"){
            $query1=$query1." WHERE RNUM=1 AND JOB_WORKLARGECTG ='".$WorkLarge."'";
            $query1=$query1.$queryAnd;
        }
        if($searchWord=="searchWordNot" && $WorkLarge =="all" && $WorkMedium =="all"){
            // $query1=$query1." WHERE obp.P_WORKLARGECTG ='".$WorkLarge."' AND obp.P_WORKMEDIUMCTG = '".$WorkMedium."'";
            $query1=$query1."WHERE RNUM=1".$queryAnd;
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
            process.P_NAME,
            process.P_FILE,
            process.P_PARAMS,
            process.P_PARAMSULMYUNGS,
            process.P_REWORKYN,
            objg.JOBGUSUNG_ORDER as p_order,
            objg.JOBGUSUNG_PARAMPOS,
            process.P_FILEPATH,
            job.JOB_PARAMS,
            job.JOB_PARAMSULMYUNGS
        FROM 
            ONLINEBATCH_SCHEDULEPROCESS obsp
        left join 
            ONLINEBATCH_JOB job on job.JOB_SEQ = obsp.JOB_SEQ
        INNER JOIN ONLINEBATCH_JOBGUSUNG objg ON
            obsp.JOB_SEQ = objg.JOB_SEQ
            AND obsp.P_SEQ = objg.P_SEQ
        INNER JOIN (
            select
                code.FILEPATH as p_filepath,
                process.*
            FROM
                ONLINEBATCH_PROCESS process
            inner join ONLINEBATCH_WORKMEDIUMCODE code on
                process.P_WORKLARGECTG = code.WORKLARGE
                and process.P_WORKLARGECTG = code.WORKMEDIUM) process on
            process.P_SEQ = objg.P_SEQ
            WHERE obsp.JOB_SEQ ='".$jobSeq."' AND obsp.SC_SEQ ='".$scSeq."'
            ORDER BY objg.JOBGUSUNG_ORDER;
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
            OnlineBatch_Schedule os WHERE os.Job_Seq = '".$jobSeq."' AND os.Sc_Seq = '".$scSeq."';
        ";

        $scheduleDetail=DB::select($query1);
        return $scheduleDetail;
    }


}
 // SELECT 
        //     obsc.*,
        //     obj.*,
        //     (SELECT owl.SHORTNAME FROM ONLINEBATCH_WORKLARGECODE owl WHERE owl.WORKLARGE = obwmc.WORKLARGE ) as job_worklargename,(SELECT oc.LONGNAME FROM ONLINEBATCH_WORKMEDIUMCODE oc WHERE oc.WORKLARGE =obj.JOB_WORKLARGECTG AND oc.WORKMEDIUM = obj.JOB_WORKMEDIUMCTG) as JOB_WORKMEDIUMNAME 
        // FROM 
        //     ONLINEBATCH_SCHEDULE obsc
        // INNER JOIN 
        //     ONLINEBATCH_JOB obj ON obj.JOB_SEQ = obsc.JOB_SEQ
        // INNER JOIN 
        //     ONLINEBATCH_WORKMEDIUMCODE obwmc ON obj.JOB_WORKLARGECTG = obwmc.WORKLARGE AND obj.JOB_WORKMEDIUMCTG = obwmc.WORKMEDIUM  AND obwmc.USED =1 
        // INNER JOIN 
        //     ONLINEBATCH_WORKLARGECODE obwlc ON obwlc.WORKLARGE =obwmc.WORKLARGE AND obwlc.USED =1