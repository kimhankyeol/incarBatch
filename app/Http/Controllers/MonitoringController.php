<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;
use PDO;
use DateTime;
class MonitoringController extends Controller
{
    // 모니터링 화면 호출 컨트롤러
    function monitoringView(Request $request){
        $jobStatus = $request->input('jobStatusStr');
        $searchWord = $request->input('searchWord');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        //실행일 기준검색
        $cronStartDate = $request->input('cronStartDate');
        $cronEndDate = $request->input('cronEndDate');
        if($jobStatus==""){
            $jobStatus="20,30,90,40";
        }
        if($searchWord==""){
            $searchWord="searchWordNot";
        }
        if($WorkLarge==""){
            $WorkLarge="all";
        }
        if($WorkMedium==""){
            $WorkMedium="all";
        }
         // 사용중인 것만 조회
        
        $MONITORING = new App\Monitoring;
        $COMMON = new App\Common;
        //  $MonitorContents = DB::select('CALL Monitor_searchList(?,?,?,?,?,?)',[$jobStatus,$searchWord,$WorkLarge,$WorkMedium,$startDate,$endDate]);
        $MonitorContents = $MONITORING->monitoringSearchList($searchWord,$WorkLarge,$WorkMedium,$cronStartDate,$cronEndDate,$jobStatus);
        $COMMON->commonLargeCode(); 
        $usedLarge = $COMMON->commonLargeCode();
        $page=$request->input('page');
        if($page==""){
            $page="1";
        }
         //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
         $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,5,$MonitorContents);
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
         //등록일 시작선택, 끝 미선택
         if($cronStartDate!=""&&$cronEndDate==""){
             $cronStartDate = new DateTime($cronStartDate);
             $cronStartDate = $cronStartDate->format('Y-m-d');
             $searchDate = array( 'cronStartDate' => $cronStartDate,'cronEndDate' => $cronEndDate);
         }
         //등록일 시작선택, 끝 선택
         else if($cronStartDate!=""&&$cronEndDate!=""){
            $cronStartDate = new DateTime($cronStartDate);
            $cronStartDate = $cronStartDate->format('Y-m-d');
            $cronEndDate = new DateTime($cronEndDate);
            $cronEndDate = $cronEndDate->format('Y-m-d');
             $searchDate = array( 'cronStartDate' => $cronStartDate,'cronEndDate' => $cronEndDate);
         }else if($cronStartDate==""&&$cronEndDate==""){
            $cronStartDate = new DateTime();
            $cronStartDate = $cronStartDate->format('Y-m-d');
            $cronEndDate = new DateTime();
            $cronEndDate = $cronEndDate->format('Y-m-d');
            $searchDate = array( 'cronStartDate' => $cronStartDate,'cronEndDate' => $cronEndDate);
         }
         if($WorkLarge!="all"){
            $usedMedium = $COMMON->jpCommonMediumCode($WorkLarge);
             return view('/monitoring/monitoringView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','usedMedium','searchDate','cronStartDate','cronEndDate','jobStatus'));
         }else{
             return view('/monitoring/monitoringView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','searchDate','cronStartDate','cronEndDate','jobStatus'));
         }
    }
    // // 잡을 조회하는 컨트롤러
    // function scheduleList(Request $request){
    //     $jobStatus = $request->input('jobStatus');
    //     $searchWord = $request->input('searchWord');
    //     $WorkLarge = $request->input('WorkLarge');
    //     $WorkMedium = $request->input('WorkMedium');
    //     $cronStartDate = $request->input('cronStartDate');
    //     $cronEndDate = $request->input('cronEndDate');
    //     if($jobStatus==""){
    //         $jobStatus="20,30,90,40";
    //     }
    //     if($searchWord==""){
    //         $searchWord="searchWordNot";
    //     }
    //     if($WorkLarge==""){
    //         $WorkLarge="all";
    //     }
    //     if($WorkMedium==""){
    //         $WorkMedium="all";
    //     }
    //     if($cronStartDate==""){
    //         $cronStartDate=null;
    //     }
    //     if($cronEndDate==""){
    //         $cronEndDate=null;
    //     }
    //      // 사용중인 것만 조회
    //      $MONITORING = new App\Monitoring;
    //      $COMMON = new App\Common;
    //      $MonitorContents = $MONITORING->monitoringSearchList($searchWord,$WorkLarge,$WorkMedium,$cronStartDate,$cronEndDate,$jobStatus);
    //      $COMMON->commonLargeCode(); 
    //      $page=$request->input('page');
    //      if($page==""){
    //         $page="1";
    //     }
    //      //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
    //      $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,5,$MonitorContents);
    //      //페이징 정보를 가져옴
    //      $paginator = $PaginationCustom->getPaging();
    //      //현재 페이지에서 보여주는 조회 정보 리스트를 가져옴
    //      $data =$PaginationCustom->getItemsForCurrentPage();
    //      $searchParams = array( 'searchWord' => $searchWord);
    //      //대분류 , 중분류 전체일 조건  
    //      if($WorkLarge=="all"&&$WorkMedium=="all"){
    //          $searchParams = array( 'searchWord' => $searchWord);
    //      }
    //      //대분류 선택, 중분류 전체
    //      else if($WorkLarge!="all"&&$WorkMedium=="all"){
    //          $searchParams = array( 'searchWord' => $searchWord,'WorkLarge' => $WorkLarge,'WorkMedium'=>'all');
    //      }
    //      //대분류 선택 ,중분류 선택
    //      else if($WorkLarge!="all"&&$WorkMedium!="all"){
    //          $searchParams = array( 'searchWord' => $searchWord,'WorkLarge' => $WorkLarge,'WorkMedium' => $WorkMedium);
    //      }
    //      //등록일 시작선택, 끝 미선택
    //      if($cronStartDate!=""&&$cronEndDate==""){
    //          $searchDate = array( 'cronStartDate' => $cronStartDate,'cronEndDate' => $cronEndDate);
    //      }
    //      //등록일 시작선택, 끝 미선택
    //      else if($cronStartDate!=""&&$cronEndDate!=""){
    //          $searchDate = array( 'cronStartDate' => $cronStartDate,'cronEndDate' => $cronEndDate);
    //      }
    //      if($WorkLarge!="all"){
    //         $usedMedium = $COMMON->jpCommonMediumCode($WorkLarge);
    //          $returnHTML = view('/monitoring/scheduleList',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','usedMedium','searchDate','jobStatus'))->render();
    //      }else{
    //          $returnHTML = view('/monitoring/scheduleList',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','searchDate','jobStatus'))->render();
    //      }
    //      return response()->json(array('returnHTML'=>$returnHTML),200);
    // }
    // 잡 스케줄의 프로세스를 조회하는 컨트롤러
    function scheduleProcessList(Request $request){
        $Job_Seq = $request->input('Job_Seq');
        $Sc_Seq = $request->input('Sc_Seq');
        $MONITORING = new App\Monitoring;
        $processList = $MONITORING->monitoringProcessList($Job_Seq,$Sc_Seq);
        $returnHTML = view('/monitoring/scheduleProcessList',compact('processList'))->render();
        
        return response()->json(array('returnHTML'=>$returnHTML),200);
    }
    // 잡 스케줄 재작업 체크
    function reWorkScheduleChk(Request $request){
        $Sc_Seq = $request->input('Sc_Seq');
        $MONITORING = new App\Monitoring;
        $succesCount = $MONITORING->monitorCompleteCount($Sc_Seq);
        $reWorkCount = $MONITORING->monitorReWorkCount($Sc_Seq);
        return response()->json(array('succesCount'=>$succesCount,'reWorkCount'=>$reWorkCount,200));
    }
    // 잡 스케줄 재작업
    function reWorkSchedule(Request $request){
        $Job_Seq = $request->input('Job_Seq');
        $Sc_Seq = $request->input('Sc_Seq');
        $RegDate = $request->input('RegDate');
        $Sc_Note = $request->input('Sc_Note');
        $Sc_UpdId = $request->input('Sc_UpdId');
        $Sc_UpdIp = $_SERVER["REMOTE_ADDR"];
        // 수정자 id $Sc_UpdId
        // 수정자 ip $Sc_UpdIP

        // pSeqArr 
        // scLogFileArr
        // scReworkArr
        // jobSmPStatus
        $query="begin SCHEDULE_REWORK(:REWORKSCSEQ,:REWORKSCREGDATE,:REWORKJOBSEQ,:SCUPDID,:SCUPDIP,:SCNOTE,:V_RESULT); end;";
    //
        // 성공 1 , 실패 0 
        $v_errmsg="";
        $v_result=0;
        $pdo = DB::connection('oracle')->getPdo();
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':REWORKSCSEQ',$Sc_Seq);
        $stmt->bindParam(':REWORKSCREGDATE',$RegDate);
        $stmt->bindParam(':REWORKJOBSEQ',$Job_Seq);
        $stmt->bindParam(':SCUPDID',$Sc_UpdId);
        $stmt->bindParam(':SCUPDIP',$Sc_UpdIp);
        $stmt->bindParam(':SCNOTE',$Sc_Note);
        $stmt->bindParam(':V_RESULT',$v_result,PDO::PARAM_INT);
        $stmt->bindParam(':V_ERRMSG',$v_errmsg,PDO::PARAM_STR,2000);
        $stmt->execute();
 
        if($v_result==1){
            //성공 
            return response()->json(array('msg'=>'success'));
        }else{
            //실패
            return response()->json(array('msg'=>'failed','msg2'=>$v_errmsg));
        }
    }

}
