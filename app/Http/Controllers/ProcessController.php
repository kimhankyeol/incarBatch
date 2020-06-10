<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;
class ProcessController extends Controller
{
    //프로세스 리스트/검색 뷰
    public function processListView(Request $request){
        $searchWord = $request -> input('searchWord');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        if($WorkLarge==""){
            $WorkLarge="all";
        }
        if($WorkMedium==""){
            $WorkMedium="all";
        }
        if($searchWord==""){
            $searchWord="searchWordNot";
        }

           //프로그램 정보 조회 maria
            // $processContents = DB::select('CALL Process_searchUsedList(?,?,?)',[$searchWord,$WorkLarge,$WorkMedium]);
            //$usedLarge = DB::select('CALL Common_LargeCode()');
            
            //프로세스 정보 조회 query1
            $query1=
                    "SELECT  obp.*,
                    (SELECT USER_NAME FROM ONLINEBATCH_USER WHERE obp.P_REGID = USER_SAWONNUM ) AS p_regname,   
                    (SELECT owl.SHORTNAME FROM ONLINEBATCH_WORKLARGECODE owl WHERE owl.WORKLARGE = obwmc.WORKLARGE ) as p_worklargename,
                    (SELECT oc.LongName FROM ONLINEBATCH_WORKMEDIUMCODE oc WHERE oc.WORKLARGE =obp.P_WORKLARGECTG AND oc.WORKMEDIUM = obp.P_WORKMEDIUMCTG) as p_workmediumname,
                    (SELECT ow.FilePath FROM ONLINEBATCH_WORKMEDIUMCODE ow WHERE ow.WORKLARGE =obp.P_WORKLARGECTG AND ow.WORKMEDIUM = obp.P_WORKMEDIUMCTG) as p_filename FROM ONLINEBATCH_PROCESS obp 
                    INNER JOIN ONLINEBATCH_WORKMEDIUMCODE obwmc ON obp.P_WORKLARGECTG = obwmc.WORKLARGE AND obp.P_WORKMEDIUMCTG = obwmc.WORKMEDIUM  AND obwmc.USED =1 
                    INNER JOIN ONLINEBATCH_WORKLARGECODE obwlc ON obwlc.WORKLARGE=obwmc.WORKLARGE AND obwlc.Used =1 ";
         
            //검색어 있을떄 
            $queryAnd =" AND obwmc.WORKLARGE BETWEEN 1000 AND 1999 AND obp.P_DELETEYN = 1 ORDER BY obp.P_UPDDATE DESC, obp.P_REGDATE DESC, obp.P_SEQ";
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
          
            
            //공통코드 대분류 조회 query2
            $query2="
            SELECT 
                WORKLARGE AS worklarge,
                LONGNAME AS  worklargename
            FROM ONLINEBATCH_WORKLARGECODE
            WHERE USED IN (0,1)
                  AND WORKLARGE BETWEEN 1000 AND 1999";
            
            // 잡, 프로그램용 공통코드 중분류
            $query3="
             SELECT WORKMEDIUM AS workmediumctg,
                    LONGNAME AS workmediumname 
             FROM ONLINEBATCH_WORKMEDIUMCODE 
             WHERE WORKLARGE = '".$WorkLarge."'";

           
            $processContents = DB::select($query1);
            $usedLarge = DB::select($query2);
            $page=$request->input('page');
                //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
            $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,10,$processContents);
            //페이징 정보를 가져옴
            $paginator = $PaginationCustom->getPaging();
            //현재 페이지에서 보여주는 조회 정보 리스트를 가져옴
            $data =$PaginationCustom->getItemsForCurrentPage();
            $searchParams = array( 'searchWord' => $searchWord);
             //대분류 , 중분류 전체일 조건  
            if($WorkLarge=="all"&&$WorkMedium=="all"){
                $searchParams = array( 'searchWord' => $searchWord);
            }
            //대분류 선택, 중분류 전체
            else if($WorkLarge!="all"&&$WorkMedium=="all"){
                $searchParams = array( 'searchWord' => $searchWord,'WorkLarge' => $WorkLarge,'WorkMedium'=>'all');
            }
            //대분류 선택 ,중분류 선택
            else if($WorkLarge!="all"&&$WorkMedium!="all"){
                $searchParams = array( 'searchWord' => $searchWord,'WorkLarge' => $WorkLarge,'WorkMedium' => $WorkMedium);
            }
            
            if($WorkLarge!="all"){
                // $usedMedium = DB::select('CALL Common_jobMediumCode(?)',[$WorkLarge]);
                   $usedMedium =  DB::select($query3);
                return view('process.processListView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','usedMedium'));
            }else{
                return view('process.processListView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge'));
            }
    }
    //프로세스 상세 뷰
    public function processDetailView(Request $request){
        $p_seq = $request->input('P_Seq');
        //프로시저를 통한 프로세스 상세정보 검색
        //$processDetail=DB::select('CALL Process_detail(?)',[$p_seq]);
        //상세정보 
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
            obp.P_SEQ = '".$p_seq."'";
            
        //사용 미사용  //조회된게 없으면 미사용처리
        $query2="
        SELECT 
            P_SEQ,
            SUM(CASE WHEN substr(JOBSM_P_STATUS,1,2)!=90 THEN 0
			WHEN substr(JOBSM_P_STATUS,1,2)=90 THEN 1 END) AS usedtotal
        FROM   
            ONLINEBATCH_SCHEDULEPROCESS
        WHERE
            P_SEQ = ".$p_seq."
        GROUP BY
            P_SEQ";
            
        $processDetail=DB::select($query1);
        $processUsed=DB::select($query2);
        if(empty($processUsed)){
            $proUsed = "미사용";
        }else{
            $proUsed = $processUsed[0]->usedtotal == 0 ? "미사용":"사용";
        }
        return view('process.processDetailView',compact('processDetail','proUsed'));
    }
    //프로세스 등록 뷰
    public function processRegisterView(){
        $searchWord="searchWordNot";
        $WorkLarge="all";
        $WorkMedium="all";
        //$usedLarge = DB::select('CALL Job_RegViewLargeCode');
        //잡 , 프로그램 공통코드 사용중인 것만 조회
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
        $db_list = DB::table('ONLINEBATCH_WORKMEDIUMCODE')->where('WorkLarge','3000')->where('Used','1')->get();
        return view('process.processRegisterView',compact('db_list','WorkLarge','WorkMedium','usedLarge'));
    }
    //프로세스 등록 저장
    public function processRegister(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        $processPath = $request->input('processPath');//경로
        $processFile = $request->input('processFile');//파일명
        $UseDb=$request->input('UseDb');
        $retry=$request->input('retry');

        $programName = $request->input('programName');
        $programExplain = $request->input('programExplain');

        $Pro_YesangTime=$request->input('Pro_YesangTime');
        $Pro_YesangMaxTime=$request->input('Pro_YesangMaxTime');

        $proParamType=$request->input('proParamType');
        $proParamSulmyungInput=$request->input('proParamSulmyungInput');
        $P_DevId=$request->input('P_DevId');
        $P_RegIp = $_SERVER["REMOTE_ADDR"];
        $P_TextInputCheck=$request->input('P_TextInputCheck');
        $P_TextInput=$request->input('P_TextInput');
       
        //고정경로 + 대분류 중분류에 따른 경로(processPath) + 파일(processFile)
        $P_FilePath="/home/incar/work".$processPath."/".$processFile;
        //서버에 해당 경로가 존재하는지, 경로 속에 파일이 있는지
        $fileResult1 = file_exists($P_FilePath); 
        $count = DB::table('ONLINEBATCH_PROCESS')->where('P_WORKLARGECTG',$WorkLarge)->where('P_WORKMEDIUMCTG',$WorkMedium)->where('P_FILE',$processFile)->count();
        $count2 = DB::table('ONLINEBATCH_PROCESS')->where('P_FILE',$processFile)->count();
        
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
                P_TEXTINPUT, 
                P_TEXTINPUTCHECK, 
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
                '1611698',
                '1611698',
                sysdate,
                '1611698',
                sysdate,
                '1',
                '".$proParamType."',
                '".$proParamSulmyungInput."',
                '".$processFile."',
                '".$P_TextInput."',
                '".$P_TextInputCheck."',
                0
            )";
        
        
        if($fileResult1){// 경로+파일이 존재하는가?
            if($count==0){
               $result = DB::insert($query1);
                return response()->json(array('result'=>$result, 'fileResult1'=>$fileResult1, 'count'=>$count, 'count2'=>$count2));//성공
            }else{
                return response()->json(array('count'=>$count));
            }
        }else{
            return response()->json(array('count'=>$count,'fileResult1'=>$fileResult1));
        }
    }
    //프로세스 수정
    public function processEdit(Request $request){
        $p_seq = $request->input('p_seq');
        $P_ReworkYN=$request->input('retry');
        // $P_UseDB=$request->input('UseDb');
        $P_YesangTime=$request->input('Pro_YesangTime');
        $P_YesangMaxTime=$request->input('Pro_YesangMaxTime');
        $P_Params=$request->input('proParamType');
        $P_ParamSulmyungs=$request->input('proParamSulmyungInput');
        $P_UpdIP=$request->input('P_UpdIP');
        $P_UpDate = $request->input('P_UpDate');
        $P_TextInputCheck = $request->input('P_TextInputCheck');
        $P_TextInput=$request->input('P_TextInput');
        $P_DeleteYN=$request->input('P_DeleteYN');
        //프로그램이 사용중이면 수정x
        //사용 미사용  //조회된게 없으면 미사용처리
        $query1="
        SELECT 
            P_SEQ,
            SUM(CASE WHEN substr(JOBSM_P_STATUS,1,2)!=90 THEN 0
			WHEN substr(JOBSM_P_STATUS,1,2)=90 THEN 1 END) AS usedtotal
        FROM   
            ONLINEBATCH_SCHEDULEPROCESS
        WHERE
            P_SEQ = ".$p_seq."
        GROUP BY
            P_SEQ";
            
        $processUsed=DB::select($query1);
        if(empty($processUsed)){
            $proUsed = "unused";
        }else{
            $proUsed = $processUsed[0]->usedtotal == 0 ? "unused":"used";
            if($proUsed=="used"){
                return response()->json(array('P_Seq'=>$p_seq,'proUsed'=>$proUsed));//성공
            }
        }

        //수정자  ID 넣어야함
        if(intVal($P_TextInputCheck)==1){
            $result = DB::table('ONLINEBATCH_PROCESS')->where('P_SEQ',$p_seq)->update([
                'P_REWORKYN'=>$P_ReworkYN,
                'P_YESANGTIME'=>$P_YesangTime,
                'P_YESANGMAXTIME'=>$P_YesangMaxTime,
                'P_PARAMS'=>$P_Params,
                'P_PARAMSULMYUNGS'=>$P_ParamSulmyungs,
                'P_UPDIP'=>$P_UpdIP,
                'P_UPDDATE'=>now(),
                'P_TEXTUNPUT'=>$P_TextInput,
                'P_TEXTINPUTCHECK'=>$P_TextInputCheck
            ]);
        }else if(intVal($P_TextInputCheck)==0){
            $result = DB::table('ONLINEBATCH_PROCESS')->where('P_SEQ',$p_seq)->update([
                'P_REWORKYN'=>$P_ReworkYN,
                'P_YESANGTIME'=>$P_YesangTime,
                'P_YESANGMAXTIME'=>$P_YesangMaxTime,
                'P_PARAMS'=>$P_Params,
                'P_PARAMSULMYUNGS'=>$P_ParamSulmyungs,
                'P_UPDIP'=>$P_UpdIP,
                'P_UPDDATE'=>now(),
                'P_TEXTINPUTCHECK'=>$P_TextInputCheck
            ]);
        }
        
        return response()->json(array('result'=>$result,'P_Seq'=>$p_seq,'proUsed'=>$proUsed));//성공
    }
    //프로세스 등록 수정 뷰
    public function processEditView(Request $request){
        $p_seq = $request->input('P_Seq');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        $db_list = DB::table('ONLINEBATCH_WORKMEDIUMCODE')->where('WORKLARGE','3000')->get();
        //프로시저를 통한 프로세스 상세정보 검색
        //$processDetail=DB::select('CALL Process_Detail(?)',[$p_seq]);
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
            obp.P_SEQ = '".$p_seq."'";
            
        //사용 미사용  //조회된게 없으면 미사용처리
        $query2="
        SELECT 
            P_SEQ,
            SUM(CASE WHEN substr(JOBSM_P_STATUS,1,2)!=90 THEN 0
			WHEN substr(JOBSM_P_STATUS,1,2)=90 THEN 1 END) AS usedtotal
        FROM   
            ONLINEBATCH_SCHEDULEPROCESS
        WHERE
            P_SEQ = ".$p_seq."
        GROUP BY
            P_SEQ";
            
        $processDetail=DB::select($query1);
        $processUsed=DB::select($query2);
        if(empty($processUsed)){
            $proUsed = "미사용";
        }else{
            $proUsed = $processUsed[0]->usedtotal== 0 ? "미사용":"사용";
        }
        
        return view('process.processEditView',compact('processDetail','db_list','WorkLarge','WorkMedium','proUsed'));
    }
}