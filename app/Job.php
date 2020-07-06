<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Job extends Model
{
    //잡 검색 목록 조회 (전체 조회 포함)
    public function jobSearchUsedList($searchWord,$WorkLarge,$WorkMedium){
        $query1=
        "SELECT obj.*,
                (SELECT USER_NAME FROM ONLINEBATCH_USER WHERE obj.JOB_REGID = USER_SAWONNUM ) AS JOB_REGNAME,
                (SELECT owl.SHORTNAME FROM ONLINEBATCH_WORKLARGECODE owl WHERE owl.WORKLARGE = obwmc.WORKLARGE ) as JOB_WORKLARGENAME,
                (SELECT oc.LONGNAME FROM ONLINEBATCH_WORKMEDIUMCODE oc WHERE oc.WORKLARGE =obj.JOB_WORKLARGECTG AND oc.WORKMEDIUM = obj.JOB_WORKMEDIUMCTG) as JOB_WORKMEDIUMNAME 
         FROM 
            ONLINEBATCH_JOB obj
         INNER JOIN 
            ONLINEBATCH_WORKMEDIUMCODE obwmc ON obj.JOB_WORKLARGECTG = obwmc.WORKLARGE AND obj.JOB_WORKMEDIUMCTG = obwmc.WORKMEDIUM  AND obwmc.USED =1 
         INNER JOIN 
            ONLINEBATCH_WORKLARGECODE obwlc ON obwlc.WORKLARGE=obwmc.WORKLARGE AND obwlc.USED =1
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
    //잡 상세 조회
    public function jobDetail($jobSeq){
        $query1 ="
        SELECT 
            oj.*,
            (SELECT oc.LONGNAME FROM ONLINEBATCH_WORKLARGECODE oc WHERE  oc.WORKLARGE =oj.JOB_WORKLARGECTG) as job_worklargename,
            (SELECT oc.LONGNAME FROM ONLINEBATCH_WORKMEDIUMCODE oc WHERE oc.WORKLARGE =oj.JOB_WORKLARGECTG AND oc.WORKMEDIUM = oj.JOB_WORKMEDIUMCTG) as job_workmediumname,
            (SELECT count(*) FROM ONLINEBATCH_JOBGUSUNG objg WHERE objg.JOB_SEQ='".$jobSeq."') as gusungcount
        FROM 
            ONLINEBATCH_JOB oj WHERE oj.JOB_SEQ = '".$jobSeq."'";

        $jobDetail=DB::select($query1);
        return $jobDetail;
    }
    //잡 예상 최대 시간 토탈 조회
    public function jobTotalTime($jobSeq){
        $query1="
        SELECT 
            objg.JOB_SEQ AS job_seq , 
            sum(obp.P_YESANGTIME) AS job_yesangtime,
            sum(obp.P_YESANGMAXTIME) AS job_yesangmaxtime 
        FROM 
            incar.ONLINEBATCH_JOBGUSUNG objg 
        INNER JOIN 
            ONLINEBATCH_PROCESS obp 
        ON objg.P_SEQ = obp.P_SEQ 
        GROUP BY objg.JOB_SEQ 
        HAVING objg.JOB_SEQ = '".$jobSeq."'";
    }
    //잡 등록 
    public function jobInsert($Job_Name,$Job_Sulmyung,$Job_RegId,$Job_RegIP,$Job_Params,$Job_ParamSulmyungs,$Job_WorkLargeCtg,$Job_WorkMediumCtg){
        $query1="
            INSERT 
            INTO 
                INCAR.ONLINEBATCH_JOB 
                (
                JOB_SEQ, 
                JOB_NAME, 
                JOB_WORKLARGECTG, 
                JOB_WORKMEDIUMCTG, 
                JOB_REGID, 
                JOB_REGIP, 
                JOB_REGDATE, 
                JOB_UPDID, 
                JOB_UPDIP, 
                JOB_UPDDATE, 
                JOB_DELETEYN, 
                JOB_PARAMS, 
                JOB_PARAMSULMYUNGS, 
                JOB_SULMYUNG
                ) VALUES(
                JOB_SEQ.NEXTVAL, 
                '".$Job_Name."',
                '".$Job_WorkLargeCtg."',
                '".$Job_WorkMediumCtg."',
                '".$Job_RegId."',
                '".$Job_RegIP."',
                sysdate,
                '".$Job_RegId."',
                '".$Job_RegIP."',
                sysdate,
                '1',
                '".$Job_Params."',
                '".$Job_ParamSulmyungs."',
                '".$Job_Sulmyung."')";
        $result = DB::insert($query1); 
        return $result;
    }
    //잡 구성 리스트 조회 
    public function jobGusungList($jobSeq){
        $query1="
        SELECT
            gusung.JOBGUSUNG_ORDER,
            process.P_FILEPATH,
            process.P_NAME,
            process.P_FILE,
            job.JOB_PARAMSULMYUNGS,
            gusung.JOBGUSUNG_PARAMPOS,
            process.P_PARAMS,
            process.P_PARAMSULMYUNGS,
            job.JOB_SEQ,
            process.P_SEQ,
            process.P_REWORKYN,
            process.P_EXECOUNT,
            process.P_TEXTINPUTCHECK,
            process.P_FILEOUTPUTCHECK,
            process.P_WORKLARGECTG,
            process.P_WORKMEDIUMCTG,
            process.P_PRIVATECHECK,
            process.P_SULMYUNG
        FROM
            ONLINEBATCH_JOBGUSUNG gusung
        left join ONLINEBATCH_JOB job on
            job.JOB_SEQ = gusung.JOB_SEQ
        left join (
            select
                code.FILEPATH as P_FILEPATH,
                process.*
            FROM
                ONLINEBATCH_PROCESS process
            inner join ONLINEBATCH_WORKMEDIUMCODE code on
                process.P_WORKLARGECTG = code.WORKLARGE
                and process.P_WORKMEDIUMCTG = code.WORKMEDIUM) process on
            process.P_SEQ = gusung.P_SEQ
        WHERE gusung.JOB_SEQ ='".$jobSeq."'
        ORDER BY gusung.JOBGUSUNG_ORDER ASC";
        $jobGusungContents=DB::select($query1);
        return $jobGusungContents;
    }


}
