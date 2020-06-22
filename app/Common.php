<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Common extends Model
{
    //공통코드 대분류 조회
    public function commonLargeCode(){
        $query1="
        SELECT 
            WORKLARGE AS worklarge,
            LONGNAME AS  worklargename
        FROM 
            ONLINEBATCH_WORKLARGECODE
        WHERE 
            USED IN (0,1)
            AND WORKLARGE BETWEEN 1000 AND 1999";
        $usedLarge=DB::select($query1);
        return $usedLarge;
    }
     // 잡, 프로그램용 공통코드 중분류
    public function jpCommonMediumCode($WorkLarge){
        $query1="
        SELECT 
            WORKMEDIUM AS workmediumctg,
            LONGNAME AS workmediumname 
        FROM 
            ONLINEBATCH_WORKMEDIUMCODE 
        WHERE WORKLARGE = '".$WorkLarge."'";
        $usedMedium=DB::select($query1);
        return $usedMedium;
    }
    //잡 , 프로그램 등록시 사용중인 공통코드 대분류
    public function usedWorkLarge(){
        $query1="
        SELECT 
            WORKLARGE AS worklarge,
            LONGNAME AS  worklargename
        FROM 
            ONLINEBATCH_WORKLARGECODE
        WHERE 
            USED = 1 
            AND WORKLARGE BETWEEN 1000 AND 1999";
        $usedLarge=DB::select($query1);
        return $usedLarge;
    }
    //관리자용 공통코드 대분류
    public function commonLargeCode2(){
        $query1="
        SELECT
            obwlc.WorkLarge AS WORKLARGE,obwlc.LONGNAME AS LONGNAME
        FROM 
            OnlineBatch_WorkMediumCode obwmc 
        RIGHT JOIN 
            OnlineBatch_WorkLargeCode obwlc ON obwmc.Used IN (0,1) GROUP BY obwlc.WorkLarge,obwlc.LongName
        ORDER BY TO_NUMBER(obwlc.WORKLARGE)  
        ";

        $usedLarge=DB::SELECT($query1);
        return $usedLarge;

    }
    //관리자용 공통코드 대분류 존재유무 검색
    public function commonLargeCodeExist($workLarge){
        if($workLarge==""||$workLarge=="all"){ 
            $query1="
            SELECT 
                *
            FROM
                ONLINEBATCH_WORKLARGECODE
            ORDER BY 
                WORKLARGE
            ";
        }else{
            $query1="
            SELECT 
                *
            FROM
                ONLINEBATCH_WORKLARGECODE
            WHERE 
                WORKLARGE LIKE CONCAT('%'||'".$workLarge."','%') 
            ORDER BY 
                WORKLARGE
            ";
        }
        $data = DB::SELECT($query1);
        return $data;
    }
    //관리자용 공통코드 대분류 등록
    public function commonLargeCodeRegister($WorkLarge,$CodeShortName,$CodeLongName,$CodeSulmyung,$Used){
        $query1="
        INSERT INTO 
            ONLINEBATCH_WORKLARGECODE
            (
                WORKLARGE,
                SHORTNAME,
                LONGNAME,
                SULMYUNG,
                USED
            ) VALUES (
                '".$WorkLarge."',
                '".$CodeShortName."',
                '".$CodeLongName."',
                '".$CodeSulmyung."',
                '".$Used."'
            )";
        $result = DB::INSERT($query1);
        return $result;
    }

    //관리자용 공통코드 중분류 목록 
    public function commonCodeMediumManageView($used,$workLarge,$searchWord){
        $query1="
        SELECT 
            OBWMC.WORKLARGE AS WORKLARGE, 
            OBWMC.WORKMEDIUM AS WORKMEDIUM,
            OBWMC.SHORTNAME AS SHORTNAME,
            OBWMC.LONGNAME AS LONGNAME,
            OBWMC.SULMYUNG AS SULMYUNG,
            OBWMC.USED AS USED,
            OBWMC.FILEPATH AS FILEPATH,
            OBWLC.USED AS LARGEUSED,
            (SELECT OWL.SHORTNAME FROM ONLINEBATCH_WORKLARGECODE OWL WHERE OWL.WORKLARGE = OBWMC.WORKLARGE ) AS WORKLARGENAME 
        FROM 
            ONLINEBATCH_WORKMEDIUMCODE OBWMC
        ";
        //searchword 유무 , Used 여부
        if($used == 'all'){
            $query1 = $query1." INNER JOIN ONLINEBATCH_WORKLARGECODE OBWLC ON OBWMC.WORKLARGE = OBWLC.WORKLARGE AND OBWMC.USED IN (0,1) AND OBWLC.USED = 1 ";
            //searchword 유
            if($searchWord!="searchWordNot" && $workLarge!="all"){
                $query1 = $query1." WHERE OBWMC.LONGNAME like concat('%'||'".$searchWord."','%') AND OBWMC.WORKLARGE = '".$workLarge."'";
            }
            if($searchWord!="searchWordNot" && $workLarge=="all" ){
                $query1 = $query1." WHERE OBWMC.LONGNAME like concat('%'||'".$searchWord."','%')";
            }
            //searchword 무
            if($searchWord=="searchWordNot" && $workLarge!="all"){
                $query1 = $query1." WHERE OBWMC.WORKLARGE='".$workLarge."'";
            }
            if($searchWord=="searchWordNot" && $workLarge=="all" ){
                $query1 = $query1;
            }
        }else if($used != 'all'){
            $query1 = $query1." INNER JOIN ONLINEBATCH_WORKLARGECODE OBWLC ON OBWMC.WORKLARGE = OBWLC.WORKLARGE AND OBWMC.USED = '".$used."' AND OBWLC.USED IN (0,1) ";
            if($searchWord!="searchWordNot" && $workLarge!="all"){
                $query1 = $query1." WHERE OBWMC.LONGNAME like concat('%'||'".$searchWord."','%') AND OBWMC.WORKLARGE = '".$workLarge."'";
            }
            if($searchWord!="searchWordNot" && $workLarge=="all" ){
                $query1 = $query1." WHERE OBWMC.LONGNAME like concat('%'||'".$searchWord."','%')";
            }
            if($searchWord=="searchWordNot" && $workLarge!="all"){
                $query1 = $query1." WHERE OBWMC.WORKLARGE='".$workLarge."'";
            }
            if($searchWord=="searchWordNot" && $workLarge=="all" ){
                $query1 = $query1;
            }
            $query1=$query1." ORDER BY TO_NUMBER(OBWMC.WORKLARGE),TO_NUMBER(OBWMC.WORKMEDIUM)";
        }
        $data = DB::select($query1);
        return $data;
    }
    //관리자용 중분류 상세
    public function commonCodeDetail($searchWord,$workLarge,$workMedium){
        $query1="
        SELECT 
            WORKLARGE, 
            WORKMEDIUM,
            SHORTNAME,
            LONGNAME,
            (SELECT owl.SHORTNAME FROM ONLINEBATCH_WORKLARGECODE owl WHERE owl.WORKLARGE = owm.WORKLARGE ) as WORKLARGENAME,
            (SELECT owl.USED FROM ONLINEBATCH_WORKLARGECODE owl WHERE owl.WORKLARGE = owm.WORKLARGE ) as LARGEUSED,
            USED,
            SULMYUNG,
            FILEPATH 
        FROM 
            ONLINEBATCH_WORKMEDIUMCODE owm 
        ";

        #searchWord 유 무 
        #유
        if($searchWord!="searchWordNot" && $workLarge=="all" && $workMedium=="all"){
            $query1=$query1." WHERE owm.LONGNAME like concat('%'||'".$searchWord."','%')";
        }
        if($searchWord!="searchWordNot" && $workLarge!="all" && $workMedium=="all"){
            $query1=$query1." WHERE owm.LONGNAME like concat('%'||'".$searchWord."','%') AND owm.WORKLARGE='".$workLarge."'";
        }
        if($searchWord!="searchWordNot" && $workLarge=="all" && $workMedium!="all"){
            $query1=$query1." WHERE owm.LONGNAME like concat('%'||'".$searchWord."','%') AND owm.WORKMEDIUM='".$workMedium."'";
        }
        if($searchWord!="searchWordNot" && $workLarge!="all" && $workMedium!="all"){
            $query1=$query1." WHERE owm.LONGNAME like concat('%'||'".$searchWord."','%') AND owm.WORKLARGE='".$workLarge."' AND owm.WORKMEDIUM='".$workMedium."'";
        }

        #무
        if($searchWord=="searchWordNot" && $workLarge=="all" && $workMedium=="all"){
            $query1=$query1;
        }
        if($searchWord=="searchWordNot" && $workLarge!="all" && $workMedium=="all"){
            $query1=$query1." WHERE owm.WORKLARGE='".$workLarge."'";
        }
        if($searchWord=="searchWordNot" && $workLarge=="all" && $workMedium!="all"){
            $query1=$query1." WHERE owm.WORKMEDIUM='".$workMedium."'";
        }
        if($searchWord=="searchWordNot" && $workLarge!="all" && $workMedium!="all"){
            $query1=$query1." WHERE owm.WORKLARGE='".$workLarge."' AND owm.WORKMEDIUM='".$workMedium."'";
        }

        $commonCodeDetail = DB::SELECT($query1);
        return $commonCodeDetail;
    }

    //관리자용 중분류 등록 (경로 있음 )
    public function commonCodeMediumRegister($WorkLarge,$WorkMedium,$CodeShortName,$CodeLongName,$CodeSulmyung,$Used,$FilePath){
       if($FilePath!=""){
        $query1="
        INSERT INTO
            ONLINEBATCH_WORKMEDIUMCODE(
                WORKLARGE,
                WORKMEDIUM,
                SHORTNAME,
                LONGNAME,
                SULMYUNG,
                USED,
                FILEPATH
            ) VALUES (
                '".$WorkLarge."',
                '".$WorkMedium."',
                '".$CodeShortName."',
                '".$CodeLongName."',
                '".$CodeSulmyung."',
                '".$Used."',
                '".$FilePath."',
            )

        ";
       }else{
        $query1="
        INSERT INTO
            ONLINEBATCH_WORKMEDIUMCODE(
                WORKLARGE,
                WORKMEDIUM,
                SHORTNAME,
                LONGNAME,
                SULMYUNG,
                USED
            ) VALUES (
                '".$WorkLarge."',
                '".$WorkMedium."',
                '".$CodeShortName."',
                '".$CodeLongName."',
                '".$CodeSulmyung."',
                '".$Used."'
            )

        ";
       }
    $result = DB::INSERT($query1);
    return $result;
    }
}
