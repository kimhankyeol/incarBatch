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
}
