<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Monitoring extends Model
{
    //모니터링 조회
    public function monitoringSearchList(){
        $query = "
        SELECT RNUM,SC_SEQ,JOB_SEQ,SC_REGDATE,SC_STARTTIME,SC_CRONTIME,SC_SULMYUNG,SC_CRONSULMYUNG,SC_NOTE,SC_DELETEYN,SC_REGID,JOB_NAME,JOB_REGID,JOB_REGIP,JOB_REGDATE,JOB_UPDDATE,JOB_DELETEYN,JOB_WORKLARGECTG,JOB_WORKMEDIUMCTG,JOB_WORKLARGENAME,JOB_WORKMEDIUMNAME,STATUS90,STATUS10,STATUS20,STATUS40
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
                obs.SC_NOTE,
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
                (SELECT count(decode(substr(obsp.JOBSM_P_STATUS,1,2),'90',1))  FROM ONLINEBATCH_SCHEDULEPROCESS obsp WHERE obsp.SC_SEQ=obs.SC_SEQ) AS STATUS90,
                (SELECT count(decode(substr(obsp.JOBSM_P_STATUS,1,2),'10',1))  FROM ONLINEBATCH_SCHEDULEPROCESS obsp WHERE obsp.SC_SEQ=obs.SC_SEQ) AS STATUS10,
                (SELECT count(decode(substr(obsp.JOBSM_P_STATUS,1,2),'20',1))  FROM ONLINEBATCH_SCHEDULEPROCESS obsp WHERE obsp.SC_SEQ=obs.SC_SEQ) AS STATUS20,
                (SELECT count(decode(substr(obsp.JOBSM_P_STATUS,1,2),'40',1))  FROM ONLINEBATCH_SCHEDULEPROCESS obsp WHERE obsp.SC_SEQ=obs.SC_SEQ) AS STATUS40
            FROM ONLINEBATCH_SCHEDULE obs 
            INNER JOIN ONLINEBATCH_JOB obj 
                ON obj.JOB_SEQ = obs.JOB_SEQ
         )  WHERE RNUM=1 AND obs.SC_DELETEYN =1
        ";
    }

}
