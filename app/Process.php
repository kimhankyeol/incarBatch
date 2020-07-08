<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Process extends Model
{
    //프로그램 검색 조회 (전체 포함)

    public function processSearchUsedList($searchWord,$WorkLarge,$WorkMedium){
        $query1=
        "SELECT  obp.*,
        (SELECT USER_NAME FROM ONLINEBATCH_USER WHERE obp.P_REGID = USER_SAWONNUM ) AS p_regname,   
        (SELECT owl.SHORTNAME FROM ONLINEBATCH_WORKLARGECODE owl WHERE owl.WORKLARGE = obwmc.WORKLARGE ) as p_worklargename,
        (SELECT oc.LongName FROM ONLINEBATCH_WORKMEDIUMCODE oc WHERE oc.WORKLARGE =obp.P_WORKLARGECTG AND oc.WORKMEDIUM = obp.P_WORKMEDIUMCTG) as p_workmediumname,
        (SELECT ow.FilePath FROM ONLINEBATCH_WORKMEDIUMCODE ow WHERE ow.WORKLARGE =obp.P_WORKLARGECTG AND ow.WORKMEDIUM = obp.P_WORKMEDIUMCTG) as p_filename FROM ONLINEBATCH_PROCESS obp 
        INNER JOIN ONLINEBATCH_WORKMEDIUMCODE obwmc ON obp.P_WORKLARGECTG = obwmc.WORKLARGE AND obp.P_WORKMEDIUMCTG = obwmc.WORKMEDIUM  AND obwmc.USED =1 
        INNER JOIN ONLINEBATCH_WORKLARGECODE obwlc ON obwlc.WORKLARGE=obwmc.WORKLARGE AND obwlc.Used =1 ";

        //검색어 있을떄 
        $queryAnd =" AND obwmc.WORKLARGE BETWEEN 1000 AND 1999 AND obp.P_DELETEYN = '1' ORDER BY obp.P_UPDDATE DESC, obp.P_REGDATE DESC, obp.P_SEQ";
        if($searchWord!="searchWordNot"  && $WorkLarge !="all"  && $WorkMedium =="all"){

            $query1=$query1."WHERE obp.P_NAME like concat('%'||'".$searchWord."','%')  AND obp.P_WORKLARGECTG ='".$WorkLarge."'";
            $query1=$query1.$queryAnd;

        }else if($searchWord!="searchWordNot" && $WorkLarge !="all" && $WorkMedium !="all"){

            $query1=$query1."WHERE obp.P_NAME like concat('%'||'".$searchWord."','%') AND obp.P_WORKLARGECTG ='".$WorkLarge."' AND obp.P_WORKMEDIUMCTG ='".$WorkMedium."'";
            $query1=$query1.$queryAnd;     

        }else if($searchWord!="searchWordNot" && $WorkLarge =="all"&& $WorkMedium =="all"){

            $query1=$query1."WHERE obp.P_Name like concat('%'||'".$searchWord."','%') ";
            $query1=$query1.$queryAnd;

        }

        //검색어 없을때
        if($searchWord=="searchWordNot"  && $WorkLarge !="all" && $WorkMedium =="all"){
            $query1=$query1."WHERE obp.P_WorkLargeCtg ='".$WorkLarge."'";
            $query1=$query1.$queryAnd;
        }
        if($searchWord=="searchWordNot" && $WorkLarge =="all" && $WorkMedium =="all"){
            // $query1=$query1." WHERE obp.P_WORKLARGECTG ='".$WorkLarge."' AND obp.P_WORKMEDIUMCTG = '".$WorkMedium."'";
            $query1=$query1.$queryAnd;
        }
        if($searchWord=="searchWordNot"  && $WorkLarge !="all" && $WorkMedium !="all"){
            $query1=$query1."WHERE obp.P_WorkLargeCtg ='".$WorkLarge."' AND obp.P_WorkMediumCtg='".$WorkMedium."'";
            $query1=$query1.$queryAnd;
        }
        $processContents = DB::select($query1);
        return $processContents;
    }
    //프로세스 상세 조회
    public function processDetail($pSeq){
        $query1="
        SELECT
            obp.*,
            obwl.LONGNAME as p_worklargename,
            obwm.LONGNAME as P_workmediumname,
            obwm.FILEPATH as filepath
        FROM
            incar.ONLINEBATCH_PROCESS obp
        INNER JOIN ONLINEBATCH_WORKLARGECODE obwl ON
            obp.P_WORKLARGECTG = obwl.WORKLARGE
        INNER JOIN incar.OnlineBatch_WorkMediumCode obwm ON
            obp.P_WORKLARGECTG = obwm.WORKLARGE 
            AND obp.P_WORKMEDIUMCTG = obwm.WORKMEDIUM
        WHERE 
            obp.P_SEQ = '".$pSeq."'";
        $processDetail=DB::select($query1);
        return $processDetail;

    }
    //프로세스 사용 미사용 조회
    public function processUsed($pSeq){
        //사용 미사용  //조회된게 없으면 미사용처리
        $query1="
        SELECT 
            P_SEQ,
            SUM(CASE WHEN substr(JOBSM_P_STATUS,1,2)!=20 THEN 0
            WHEN substr(JOBSM_P_STATUS,1,2)=20 THEN 1 END) AS usedtotal
        FROM   
            ONLINEBATCH_SCHEDULEPROCESS
        WHERE
            P_SEQ = ".$pSeq."
        GROUP BY
            P_SEQ";
        $processUsed=DB::select($query1);
        return $processUsed;
    }
    //프로세스 파일 DB 유무 체크 
    public function processFileDBExist($WorkLarge,$WorkMedium,$processFile){
        $count = DB::table('ONLINEBATCH_PROCESS')->where('P_WORKLARGECTG',$WorkLarge)->where('P_WORKMEDIUMCTG',$WorkMedium)->where('P_FILE',$processFile)->count();
        return $count;
    }
    //프로세스 등록
    public function processInsert($WorkLarge,$WorkMedium,$processFile,$retry,$programName,$programExplain ,$Pro_YesangTime,$Pro_YesangMaxTime,$proParamType,$proParamSulmyungInput,$P_DevId,$P_RegIp,$P_TextInputCheck,$P_FileOutputCheck,$P_PrivateCheck,$P_RegId){
        $query1="
        INSERT INTO 
            ONLINEBATCH_PROCESS 
            (
                P_SEQ, 
                P_NAME, 
                P_SULMYUNG, 
                P_REWORKYN, 
                P_YESANGTIME, 
                P_YESANGMAXTIME, 
                P_REGIP, 
                P_UPDIP, 
                P_WORKLARGECTG, 
                P_WORKMEDIUMCTG, 
                P_DEVID, 
                P_REGID, 
                P_REGDATE, 
                P_UPDID, 
                P_UPDDATE, 
                P_DELETEYN, 
                P_PARAMS, 
                P_PARAMSULMYUNGS, 
                P_FILE, 
                P_TEXTINPUTCHECK, 
                P_FILEOUTPUTCHECK, 
                P_PRIVATECHECK,
                P_EXECOUNT
            ) VALUES(
                P_SEQ.NEXTVAL,
                '".$programName."', 
                '".$programExplain."',
                '".$retry."',
                '".$Pro_YesangTime."',
                '".$Pro_YesangMaxTime."',
                '".$P_RegIp."',
                '".$P_RegIp."',
                '".$WorkLarge."',
                '".$WorkMedium."',
                '".$P_RegId."',
                '".$P_RegId."',
                sysdate,
                '".$P_RegId."',
                sysdate,
                '1',
                '".$proParamType."',
                '".$proParamSulmyungInput."',
                '".$processFile."',
                '".$P_TextInputCheck."',
                '".$P_FileOutputCheck."',
                '".$P_PrivateCheck."',
                0
            )";
        $result = DB::insert($query1);
        return $result;
    }
}
