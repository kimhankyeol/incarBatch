<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;
use DateTime;

class scheduleController extends Controller
{
    //스케줄 리스트 화면  -- 여기 바뀌어야함 
    public function scheduleListView(Request $request){
        $searchWord = $request->input('searchWord');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        if($searchWord==""){
            $searchWord="searchWordNot";
        }
        if($WorkLarge==""){
            $WorkLarge="all";
        }
        if($WorkMedium==""){
            $WorkMedium="all";
        }
        $SCHEDULE = new App\Schedule;
        $COMMON = new App\Common;
        // 사용중인 것만 조회  
        $jobContents = $SCHEDULE->scheduleUsedList($searchWord,$WorkLarge,$WorkMedium);
        $usedLarge = $COMMON->commonLargeCode();
        $page=$request->input('page');
        //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
        $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,10,$jobContents);
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
            $usedMedium = $COMMON->jpCommonMediumCode($WorkLarge);
            return view('schedule.scheduleListView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','usedMedium'));
        }else{
            return view('schedule.scheduleListView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge'));
        }
    }
    //스케줄 등록 화면
    public function scheduleRegisterView(Request $request){
        return view("schedule.scheduleRegisterView");
    }
    //스케줄 등록
    public function scheduleRegister(Request $request){
        // $date = new DateTime($request->input('Sc_CronEndTime'));
        // $Sc_CronEndTime = $date->format('YYYY-MM-DD H:i:s');
        $Sc_Crontab = $request->input('Sc_Crontab'); //주기 번호 
        $Job_Seq = $request->input('job_seq');
        $Sc_Sulmyung = $request->input('Sc_Sulmyung');
        $Sc_Param = $request->input('Sc_Param');
        $Sc_Status=$request->input('Sc_Status');
        $Sc_RegId=$request->input('Sc_RegId');
        $Sc_RegIP = $_SERVER["REMOTE_ADDR"];
        $Sc_DeleteYN=1;
        $Sc_CronSulmyung=$request->input('Sc_CronSulmyung');
        $P_Seq = $request->input('P_Seq');//1,2
        $Sc_CronTime = $request->input('Sc_CronTime');
        $Sc_CronTimeYmd = new DateTime($request->input('Sc_CronTime'));
        $Sc_CronTimeYmd = $Sc_CronTimeYmd->format('Ymd');
        $Sc_CronEndTime = $request->input('Sc_CronEndTime');
        $Log_File = $request->input('Log_File');//log1,log2
        $Sc_ReworkYN = $request->input('Sc_ReworkYN');
        $Sc_Bungi1 =$request->input('Sc_Bungi1'); //주기번호에 따른 파라미터(분기 처리 할거)
        $Sc_Bungi2 =$request->input('Sc_Bungi2');//주기번호에 따른 파라미터(분기 처리 할거)
        $Sc_Bungi3 =$request->input('Sc_Bungi3');//주기번호에 따른 파라미터(분기 처리 할거)
        if($Sc_Bungi1==""){
            $Sc_Bungi1=null;
        }
        if($Sc_Bungi2==""){
            $Sc_Bungi2=null;
        }
        if($Sc_Bungi3==""){
            $Sc_Bungi3=null;
        }
        $Sc_UpdId=null;
        $Sc_UpdIP=null;
        $Sc_Note=null;
        $Sc_Regdate=new DateTime();
        $Sc_Regdate = $Sc_Regdate->format('Y-m-d H:i:s');
       

        //스케줄 등록 프로시저 
        //첫 등록시에는 SCREGDATE,SCNOTE, 를 넣을 필요없음 재작업돌릴시  SCHEDULEINSERT 프로시저 다시 돌아가는데 그때 넣어줘야됨
        $query="begin SCHEDULEINSERT(:JUGI,:JOBSEQ,:SCSULMYUNG,:SCREGID,:SCREGIP,:SCCRONTIME,:SCCRONENDTIME,:SCCRONSULMYUNG,:SCSTATUS,:SCPARAM,:SCBUNGI1,:SCBUNGI2,:SCBUNGI3,:SCUPDID,:SCUPDIP,:SCNOTE,:PSEQARR,:SCLOGFILEARR,:SCREWORKARR,:SCREGDATE,:V_RESULT); end;";
    //
        // 성공 1 , 실패 0 
        // $v_errmsg="";
        $v_result=0;
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':JUGI',$Sc_Crontab);
        $stmt->bindParam(':JOBSEQ',$Job_Seq);
        $stmt->bindParam(':SCSULMYUNG',$Sc_Sulmyung);
        $stmt->bindParam(':SCREGID',$Sc_RegId);
        $stmt->bindParam(':SCREGIP',$Sc_RegIP);
        $stmt->bindParam(':SCCRONTIME',$Sc_CronTime);
        $stmt->bindParam(':SCCRONENDTIME',$Sc_CronEndTime);
        $stmt->bindParam(':SCCRONSULMYUNG',$Sc_CronSulmyung);
        $stmt->bindParam(':SCSTATUS',$Sc_Status);
        $stmt->bindParam(':SCPARAM',$Sc_Param);
        $stmt->bindParam(':SCBUNGI1',$Sc_Bungi1);
        $stmt->bindParam(':SCBUNGI2',$Sc_Bungi2);
        $stmt->bindParam(':SCBUNGI3',$Sc_Bungi3);
        $stmt->bindParam(':SCUPDID',$Sc_UpdId);
        $stmt->bindParam(':SCUPDIP',$Sc_UpdIp);
        $stmt->bindParam(':SCNOTE',$Sc_Note);
        $stmt->bindParam(':PSEQARR',$P_Seq);
        $stmt->bindParam(':SCLOGFILEARR',$Log_File);
        $stmt->bindParam(':SCREWORKARR',$Sc_ReworkYN);
        $stmt->bindParam(':SCREGDATE',$Sc_Regdate);
        $stmt->bindParam(':V_RESULT',$v_result);
        // $stmt->bindParam(':V_ERRMSG',$v_errmsg);
        $stmt->execute();
 
        if($v_result==1){
            //성공 
            return response()->json(array('msg'=>'success'));
        }else{
            //실패
            return response()->json(array('msg'=>'failed'));
        }
    }
        
    // 실행할 잡의 파라미터 불러오기
    public function jobselect(Request $request){
        $Job_Seq = $request->input('job_seq');
        $JOB = new App\Job;
        //잡 구성 리스트 조회 
        $jobGusungContents = $JOB->jobGusungList($Job_Seq);
        $jobDetail = $JOB->jobDetail($Job_Seq);
        $jobName = DB::table('ONLINEBATCH_JOB')->where("JOB_SEQ",$Job_Seq)->get();
        $jobName = $jobName[0]->job_name;

        $returnHTML=view('schedule.scheduleExecParam',compact('jobGusungContents','jobDetail','jobName'))->render();
        return response()->json(array('returnHTML'=>$returnHTML),200);
    }
    //스케줄 상세
    public function scheduleDetailView(Request $request){
        $job_seq = $request->input('Job_Seq');
        $sc_seq = $request->input('Sc_Seq');
        
        //삭제한것인지 아닌지 삭제된것은 0 사용중인것은 1
        $SC_DELETEYN = DB::TABLE('ONLINEBATCH_SCHEDULE')->where('SC_SEQ',$sc_seq)->value('SC_DELETEYN');
        if(intVal($SC_DELETEYN) == 0){
            $msg='삭제된 스케줄입니다.';
            $url='/schedule/scheduleListView?page=1';
            return view('common.redirect',compact('msg','url'));
        }

        //$jobGusungContents = DB::table('OnlineBatch_ScheduleProcess')->where('Job_Seq',$job_seq)->where('Sc_Seq',$sc_seq);
        //프로시저를 통한 잡 상세정보 검색
        $JOB = new App\Job;
        $SCHEDULE = new App\Schedule;
        $jobGusungContents = $SCHEDULE->scheduleProgramList($job_seq,$sc_seq);
        
        $jobDetail = $JOB->jobDetail($job_seq);
        //프로시저를 통한 스케줄러 상세정보 검색
        
        $scheduleDetail=$SCHEDULE->scheduleDetail($job_seq,$sc_seq);

        $WorkLarge = $jobDetail[0]->job_worklargectg;
        $WorkMedium = $jobDetail[0]->job_workmediumctg;
        $jobTotalTime = $JOB->jobTotalTime($job_seq);
        return view('schedule.scheduleDetailView',compact('jobDetail','jobGusungContents','scheduleDetail','jobTotalTime','WorkLarge','WorkMedium'));
    }
    public function scheduleDump(Request $request){
        $Sc_UpdIP = $_SERVER["REMOTE_ADDR"];
        $Sc_UpdID = $request->input('Sc_UpdID');
        $Sc_Seq = $request->input('Sc_Seq');
        $Sc_Status = DB::table('ONLINEBATCH_SCHEDULE')->where('SC_SEQ',$Sc_Seq)->value('SC_STATUS');
        $Sc_Status2 = DB::table('ONLINEBATCH_SCHEDULEPROCESS')->where('SC_SEQ',$Sc_Seq)->where('JOBSM_P_STATUS','NOT LIKE','10%')->count();
        //30 예약상태 거나 90 종료 상태 
        if(preg_match("/^30/",$Sc_Status)||preg_match("/^90/",$Sc_Status)){
            if($Sc_Status2==0){
                DB::table('OnlineBatch_Schedule')->where('SC_SEQ',$Sc_Seq)->update([
                    'SC_UPDID'=>'1611670',
                    'SC_UPDIP'=>$Sc_UpdIP,
                    'Sc_DeleteYN'=>0
                ]);
                return response()->json(array('msg'=>'success'));
            }else{
                return response()->json(array('msg'=>'failed'));
            }
        }else{
            return response()->json(array('msg'=>'failed'));
        }
       
       
    }
}
