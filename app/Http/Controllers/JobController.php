<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;
use PDO;
class JobController extends Controller
{
    //메인화면
    public function index(Request $request){
        $pointer = $request->input('pointer');
        return view('index');
    }
    //잡 리스트/검색 뷰
    public function jobListView(Request $request){
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
        $JOB = new App\Job;
        $COMMON = new App\Common;

        //잡 검색 목록조회
        $jobContents=$JOB->jobSearchUsedList($searchWord,$WorkLarge,$WorkMedium);
        //공통코드 대분류 조회 
        $usedLarge=$COMMON->commonLargeCode();

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
            // 잡, 프로그램용 공통코드 중분류
            $usedMedium=$COMMON->jpCommonMediumCode($WorkLarge);
            return view('job.jobListView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','usedMedium'));
        }else{
            return view('job.jobListView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge'));
        }
    }
    //잡 상세 뷰
    public function jobDetailView(Request $request){
        $job_seq = $request->input('Job_Seq');
        $JOB = new App\Job;
        //잡 상세조회
        $jobDetail =$JOB->jobDetail($job_seq);
        //잡 예상 최대시간 토탈 조회
        $jobTotalTime=$JOB->jobTotalTime($job_seq);
    
        //잡 상태 체크 프로시저 
        $query="begin JOBSTATUSCHECK(:jobSeq,:v_end,:v_error,:v_yeyak,:v_exec,:v_wait,:v_result); end;";
        $WorkLarge = $jobDetail[0]->job_worklargectg;
        $WorkMedium = $jobDetail[0]->job_workmediumctg;
        
        
        //잡 상태 체크 완료, 오류 ,예약, 실행 ,대기
        $v_end=0;
        $v_error=0;
        $v_yeyak=0;
        $v_exec=0;
        $v_wait=0;
        // 성공 1 , 실패 0 
        $v_result=0;
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':jobSeq',$job_seq);
        $stmt->bindParam(':v_end',$v_end,PDO::PARAM_INT);
        $stmt->bindParam(':v_error',$v_error,PDO::PARAM_INT);
        $stmt->bindParam(':v_yeyak',$v_yeyak,PDO::PARAM_INT);
        $stmt->bindParam(':v_exec',$v_exec,PDO::PARAM_INT);
        $stmt->bindParam(':v_wait',$v_wait,PDO::PARAM_INT);
        $stmt->bindParam(':v_result',$v_result,PDO::PARAM_INT);
        $stmt->execute();
       
        if($v_result==1){
            //실행 하고 나면 결과값을 반환 받음
            $jobStatusCheck=array(
                "v_end"=>$v_end,
                "v_error"=>$v_error,
                "v_yeyak"=>$v_yeyak,
                "v_exec"=>$v_exec,
                "v_wait"=>$v_wait
            );
           return view('job.jobDetailView',compact('jobDetail','jobTotalTime','WorkLarge','WorkMedium','jobStatusCheck'));
        }else{
            $msg="잡 상세보기를 조회의 오류가 있습니다.";
            $url="/job/jobListView?page=1";
            return view('common.redirect',compact('msg','url'));
        }
    }
    //잡 등록 뷰
    public function jobRegisterView(){
        //Job_searchUsedLargeCode 프로시저를 실행하기 위한 변수선언
        $searchWord="searchWordNot";
        $WorkLarge="all";
        $WorkMedium="all";
        $COMMON = new App\Common;
        $usedLarge = $COMMON->usedWorkLarge();
        return view('job.jobRegisterView',compact('usedLarge','WorkMedium','WorkLarge'));
    }
    //잡 수정 뷰
    public function jobUpdateView(Request $request){
        $job_seq = $request->input('Job_Seq');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        //잡 상세조회
        $JOB = new App\Job;
        $jobDetail =$JOB->jobDetail($job_seq);
        $WorkLarge = $jobDetail[0]->job_worklargectg;
        $WorkMedium = $jobDetail[0]->job_workmediumctg;
        //잡 예상 최대시간 토탈 조회
        $jobTotalTime=$JOB->jobTotalTime($job_seq);
        //잡 상태 체크 프로시저 
        $query3="begin JOBSTATUSCHECK(:jobSeq,:v_end,:v_error,:v_yeyak,:v_exec,:v_wait,:v_result); end;";
      
         //잡 상태 체크 완료, 오류 ,예약, 실행 ,대기
        $v_end=0;
        $v_error=0;
        $v_yeyak=0;
        $v_exec=0;
        $v_wait=0;
        // 성공 1 , 실패 0 
        $v_result=0;
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare($query3);
        $stmt->bindParam(':jobSeq',$job_seq,PDO::PARAM_INT);
        $stmt->bindParam(':v_end',$v_end,PDO::PARAM_INT);
        $stmt->bindParam(':v_error',$v_error,PDO::PARAM_INT);
        $stmt->bindParam(':v_yeyak',$v_yeyak,PDO::PARAM_INT);
        $stmt->bindParam(':v_exec',$v_exec,PDO::PARAM_INT);
        $stmt->bindParam(':v_wait',$v_wait,PDO::PARAM_INT);
        $stmt->bindParam(':v_result',$v_result,PDO::PARAM_INT);
        $stmt->execute();
        if($v_result==1){
            //실행 하고 나면 결과값을 반환 받음
            $jobStatusCheck=array(
                "v_end"=>$v_end,
                "v_error"=>$v_error,
                "v_yeyak"=>$v_yeyak,
                "v_exec"=>$v_exec,
                "v_wait"=>$v_wait
            );
            //잡상태에 따른 분기 처리
            if($v_exec==0&&$v_yeyak==0&&$v_error==0&&$v_end==0){
                return view('job.jobUpdateView',compact('jobDetail','WorkLarge','WorkMedium','jobTotalTime','jobStatusCheck'));
            } else {
                $msg = "잡이 실행,예약,오류,종료 상태이면 수정할 수 없습니다.";
                $url = "/job/jobDetailView?Job_Seq=".$job_seq;
                return view('common.redirect',compact('msg','url'));
            }
        }else{
            $msg="잡 수정 상세 조회의 오류가 있습니다.";
            $url = "/job/jobDetailView?Job_Seq=".$job_seq;
            return view('common.redirect',compact('msg','url'));
        }
        
        
    }
    //잡 등록
    public function jobRegister(Request $request){
        $Job_Name=$request->input('Job_Name');
        $Job_Sulmyung = $request->input('Job_Sulmyung');
        $Job_RegId = $request->input('Job_RegId');
        $Job_RegIP = $_SERVER["REMOTE_ADDR"];

        $Job_Params = $request->input('Job_Params');
        $Job_ParamSulmyungs = $request->input('Job_ParamSulmyungs');
        //업무 대분류 중분류
        $Job_WorkLargeCtg=$request->input('Job_WorkLargeCtg');
        $Job_WorkMediumCtg=$request->input('Job_WorkMediumCtg');
         //DB INSERT
        $JOB = new App\Job;
        $result = $JOB->jobInsert($Job_Name,$Job_Sulmyung,$Job_RegId,$Job_RegIP,$Job_Params,$Job_ParamSulmyungs,$Job_WorkLargeCtg,$Job_WorkMediumCtg);
        //등록이 되었으면
        if($result>0){
            $msg="success"; 
            return response()->json(array('msg'=>$msg),200);
        }else{
            $msg="failed";
            return response()->json(array('msg'=>$msg));
        }
    }
    //잡 수정
    public function jobUpdate(Request $request){
        $Job_Seq=$request->input('Job_Seq');
        $Job_Name=$request->input('Job_Name');
        $Job_Sulmyung = $request->input('Job_Sulmyung');
        $Job_UpdId = $request->input('Job_RegId');
        $Job_UpdIP = $_SERVER["REMOTE_ADDR"];
        $Job_Params = $request->input('Job_Params');
        $Job_ParamSulmyungs = $request->input('Job_ParamSulmyungs');
        //업무 대분류 중분류
        $Job_WorkLargeCtg=$request->input('Job_WorkLargeCtg');
        $Job_WorkMediumCtg=$request->input('Job_WorkMediumCtg');
        $query1="begin JOBSTATUSCHECK(:jobSeq,:v_end,:v_error,:v_yeyak,:v_exec,:v_wait,:v_result); end;";
        //잡상태에 따른 분기 처리
        $v_end=0;
        $v_error=0;
        $v_yeyak=0;
        $v_exec=0;
        $v_wait=0;
        // 성공 1 , 실패 0 
        $v_result=0;
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare($query1);
        $stmt->bindParam(':jobSeq',$job_seq,PDO::PARAM_INT);
        $stmt->bindParam(':v_end',$v_end,PDO::PARAM_INT);
        $stmt->bindParam(':v_error',$v_error,PDO::PARAM_INT);
        $stmt->bindParam(':v_yeyak',$v_yeyak,PDO::PARAM_INT);
        $stmt->bindParam(':v_exec',$v_exec,PDO::PARAM_INT);
        $stmt->bindParam(':v_wait',$v_wait,PDO::PARAM_INT);
        $stmt->bindParam(':v_result',$v_result,PDO::PARAM_INT);
        $stmt->execute();
        //v_result 1 프로시저 성공 0 실패
        if($v_result==1){
            if($v_exec==0&&$v_yeyak==0&&$v_error==0&&$v_end==0){
                $result = DB::table('incar.OnlineBatch_Job')->where('Job_Seq',$Job_Seq)->update([
                    'Job_Name'=>$Job_Name,
                    'Job_Sulmyung'=>$Job_Sulmyung,
                    'Job_UpdId'=>$Job_UpdId,
                    'Job_UpdIP'=>$Job_UpdIP,
                    'Job_UpdDate'=>now(),
                    'Job_Params'=>$Job_Params,
                    'Job_ParamSulmyungs'=>$Job_ParamSulmyungs
                ]);
                 //변경사항이 있는지 없는지
                if($result!=0){
                    $msg="success";
                    return response()->json(array('msg'=>$msg),200);
                }else {
                    $msg="notChg";
                    return response()->json(array('msg'=>$msg),200);
                }
            }else {
                $msg = "jobStatus";
                return response()->json(array('msg'=>$msg),200);
            }
        }else{
            //프로시저 실행후 에러 났을때 실패 
            $msg = "procedureError";
            return response()->json(array('msg'=>$msg),200);
        }
       
    }
}
