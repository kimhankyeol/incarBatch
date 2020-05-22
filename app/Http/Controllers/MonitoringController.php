<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;
class MonitoringController extends Controller
{
    // 모니터링 화면 호출 컨트롤러
    function monitoringView(Request $request){
        $jobStatus = $request->input('jobStatus');
        $searchWord = $request->input('searchWord');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
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
         $MonitorContents = DB::select('CALL Monitor_searchList(?,?,?,?,?,?)',[$jobStatus,$searchWord,$WorkLarge,$WorkMedium,$startDate,$endDate]);
         $usedLarge = DB::select('CALL Common_LargeCode()');
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
         if($startDate!=""&&$endDate==""){
             $searchDate = array( 'startDate' => $startDate,'endDate' => $endDate);
         }
         //등록일 시작선택, 끝 미선택
         else if($startDate!=""&&$endDate!=""){
             $searchDate = array( 'startDate' => $startDate,'endDate' => $endDate);
         }
         if($WorkLarge!="all"){
             $usedMedium = DB::select('CALL Common_MediumCode(?)',[$WorkLarge]);
             return view('/monitoring/monitoringView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','usedMedium','searchDate'));
         }else{
             return view('/monitoring/monitoringView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','searchDate'));
         }
    }
    // 잡을 조회하는 컨트롤러
    function monitorJobSearchList(Request $request){
        $jobStatus = $request->input('jobStatus');
        $searchWord = $request->input('searchWord');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        
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
        if($startDate==""){
            $startDate=null;
        }
        if($endDate==""){
            $endDate=null;
        }
         // 사용중인 것만 조회
         #$MonitorContents = DB::select('CALL Monitor_searchList("0/0/0/0", "2", "all", "all", "2020-04-01", "2020-05-11")');
         #$MonitorContents = DB::select('CALL Monitor_searchList(?,?,?,?,?,?)',[$jobStatus,$searchWord,$WorkLarge,$WorkMedium,$startDate,$endDate]);
         $MonitorContents = DB::select('CALL Monitor_searchList(?, ?, ?, ?, ? ,?)',[$jobStatus,$searchWord,$WorkLarge,$WorkMedium,$startDate,$endDate]);
         $usedLarge = DB::select('CALL Common_LargeCode()');
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
         if($startDate!=""&&$endDate==""){
             $searchDate = array( 'startDate' => $startDate,'endDate' => $endDate);
         }
         //등록일 시작선택, 끝 미선택
         else if($startDate!=""&&$endDate!=""){
             $searchDate = array( 'startDate' => $startDate,'endDate' => $endDate);
         }
         if($WorkLarge!="all"){
             $usedMedium = DB::select('CALL Common_MediumCode(?)',[$WorkLarge]);
             $returnHTML = view('/monitoring/monitorJobSearchList',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','usedMedium','searchDate','jobStatus'))->render();
         }else{
             $returnHTML = view('/monitoring/monitorJobSearchList',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','searchDate','jobStatus'))->render();
         }
         return response()->json(array('returnHTML'=>$returnHTML),200);
    }
    // 잡 스케줄을 조회하는 컨트롤러
    function monitorJobDetailList(Request $request){
        $Job_Seq = $request->input('Job_Seq');
        $JobDetailList = DB::select('CALL Monitor_detailList(?)',[$Job_Seq]);
        $page1 = $request->input('page');
        //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
        $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page1,5,$JobDetailList);
        //페이징 정보를 가져옴
        $paginator1 = $PaginationCustom->getPaging();
        //현재 페이지에서 보여주는 조회 정보 리스트를 가져옴
        $detailList =$PaginationCustom->getItemsForCurrentPage();
        
        $searchParams = array( 'Job_Seq' => $Job_Seq);

        $returnHTML = view('/monitoring/monitorJobDetailList',compact('detailList','paginator1','searchParams','page1'))->render();
        
        return response()->json(array('returnHTML'=>$returnHTML,200));
    }

    // 잡 스케줄의 프로세스를 조회하는 컨트롤러
    function scheduleProcessList(Request $request){
        $Job_Seq = $request->input('Job_Seq');
        $Sc_Seq = $request->input('Sc_Seq');
        $processList = DB::select('CALL Monitor_processList(?,?)',[$Job_Seq,$Sc_Seq]);
        $returnHTML = view('/monitoring/scheduleProcessList',compact('processList'))->render();
        
        return response()->json(array('returnHTML'=>$returnHTML,200));
    }
    // 잡 스케줄 재작업
    function reWorkSchedule(Request $request){
        $Sc_Seq = $request->input('Sc_Seq');

        $succesCount = DB::table('OnlineBatch_Schedule')
        ->join('OnlineBatch_ScheduleProcess', 'OnlineBatch_Schedule.Sc_Seq', '=', 'OnlineBatch_ScheduleProcess.Sc_Seq')
        ->join('OnlineBatch_Process', 'OnlineBatch_ScheduleProcess.P_Seq', '=', 'OnlineBatch_Process.P_Seq')
        ->where('OnlineBatch_Schedule.Sc_Seq', '=', $Sc_Seq)
        ->where(DB::raw('LEFT(OnlineBatch_ScheduleProcess.JobSM_P_Status,2)'), '!=', '90')
        ->count('OnlineBatch_ScheduleProcess.JobSM_P_Status');
        
        $reWorkCount = DB::table('OnlineBatch_Schedule')
        ->join('OnlineBatch_ScheduleProcess', 'OnlineBatch_Schedule.Sc_Seq', '=', 'OnlineBatch_ScheduleProcess.Sc_Seq')
        ->join('OnlineBatch_Process', 'OnlineBatch_ScheduleProcess.P_Seq', '=', 'OnlineBatch_Process.P_Seq')
        ->where('OnlineBatch_Schedule.Sc_Seq', '=', $Sc_Seq)
        ->where('OnlineBatch_ScheduleProcess.Sc_ReworkYN', '=', '0')
        ->count('OnlineBatch_ScheduleProcess.Sc_ReworkYN');
        
        return response()->json(array('succesCount'=>$succesCount,'reWorkCount'=>$reWorkCount,200));
    }
}