<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;
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
        // 수정자 id $Sc_UpdId
        // 수정자 ip $Sc_UpdIP

        // pSeqArr 
        // scLogFileArr
        // scReworkArr
        // jobSmPStatus
        $pSeqArr = "";
        $scLogFileArr = "";
        $scReworkArr = "";
        $count = 0;
        $delResult = DB::select('CALL Monitor_reWork(?, ?, ?)',[$Job_Seq,$Sc_Seq,$RegDate]);
        foreach ($delResult as $index => $result) {
            if(isset($result->P_Seq)){
                $pSeqArr .= $result->P_Seq.'||';
            }
            if(isset($result->Sc_LogFile)){
                $scLogFileArr .= preg_replace("!/home/script/log/(.*?)/!is","",$result->Sc_LogFile).'||';
            }
            if(isset($result->P_ReworkYN)){
                $scReworkArr .= $result->P_ReworkYN.'||';
            }
        }
        $pSeqArr = substr($pSeqArr,0,-2);
        $scLogFileArr = substr($scLogFileArr,0,-2);
        $scReworkArr = substr($scReworkArr,0,-2);
        $insResult = DB::insert('CALL Schedule_insert(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[
            $delResult[0]->Sc_Crontab, 
            $delResult[0]->Job_Seq, 
            $delResult[0]->Sc_Sulmyung, 
            $delResult[0]->Sc_RegId, 
            $delResult[0]->Sc_RegIP, 
            date("Y-m-d H:i:s"),
            $delResult[0]->Sc_CronEndTime, 
            $delResult[0]->Sc_CronSulmyung, 
            ('30'.$delResult[0]->Sc_Crontab),
            $delResult[0]->Sc_Param, 
            $delResult[0]->Sc_Bungi1, 
            $delResult[0]->Sc_Bungi2, 
            $delResult[0]->Sc_Bungi3,
            '이지흠', // Update ID
            '111.111.111.111', // Update IP
            $Sc_Note,
            $pSeqArr,
            $scLogFileArr,
            $scReworkArr,
            $delResult[0]->Sc_RegDate
        ]);
        return response()->json(array('pSeqArr'=>$pSeqArr,'scLogFileArr'=>$scLogFileArr,'scReworkArr'=>$scReworkArr,'count'=>$count,'$delResult'=>$delResult,200));
    }

}
