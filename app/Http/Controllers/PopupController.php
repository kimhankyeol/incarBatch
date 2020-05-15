<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;
use Monolog\Handler\PHPConsoleHandler;

class PopupController extends Controller
{
    //팝업- 프로세스 상세
    public function processInfo(){
        return view('/popup/processInfo');
    }
    //팝업- 잡 구성
    public function jobGusung(Request $request){
        $Job_Seq = $request->input('Job_Seq');
        $jobGusungContents = DB::select('CALL JobGusung_List(?)',[$Job_Seq]);
        $jobDetail = DB::select('CALL Job_detail(?)',[$Job_Seq]);
        $jobName = DB::table('OnlineBatch_Job')->where("Job_Seq",$Job_Seq)->get();
        $jobName = $jobName[0]->Job_Name;

        //////// 최초 및 검색 시 필요한 조건 
        $searchWord = $request -> input('searchWord');
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

        $data = DB::select('CALL Process_searchUsedList(?,?,?)',[$searchWord,$WorkLarge,$WorkMedium]);
        $usedLarge = DB::select('CALL Common_LargeCode()');
        $page=$request->input('page');
          //////// 최초 및 검색 시 필요한 조건 
        return view('/popup/jobGusung',compact('jobGusungContents','jobName','jobDetail','data','searchWord','WorkLarge','WorkMedium','usedLarge'));
    }
    //팝업- 잡 구성 수정/ 등록
    public function jobGusungModify(Request $request){
        $Job_Seq = $request->input('Job_Seq');
        $gusungProcess = $request->input('gusungProcess');
        $gusungData = $request->input('gusungData');
        $JobSM_IP = $_SERVER["REMOTE_ADDR"];

        $gusungCount = DB::table('OnlineBatch_JobGusung')->where('Job_Seq',$Job_Seq);
        $gusungCount = $gusungCount->count();
        
        if($gusungCount!=0){
            DB::table('OnlineBatch_JobGusung')->where('Job_Seq',$Job_Seq)->delete();
            // DB::table('OnlineBatch_StatusMonitoring')->where('Job_Seq',$Job_Seq)->delete();
        }
        for($i = 0; $i<count($gusungProcess);$i++){
            # 잡 구성
            DB::table('OnlineBatch_JobGusung')->insert(['Job_Seq'=>$Job_Seq,'P_Seq'=>$gusungProcess[$i],'JobGusung_Order'=>$i+1,'JobGusung_ParamPos'=>$gusungData[$i]]);
            //모니터링
            // DB::table('OnlineBatch_StatusMonitoring')->insert(['Job_Seq'=>$Job_Seq,'P_Seq'=>$gusungProcess[$i],'JobSM_P_Status'=>'102','JobSM_IP'=>$JobSM_IP]);
        }
        //return response()->json(array('Job_Seq'=>$Job_Seq,'gusungData'=>$gusungData,'gusungProcess'=>count($gusungProcess),'gusungCount'=>$gusungCount,200)); 
        return response()->json(array('count'=>count($gusungProcess),'gusung'=>$gusungCount),200);
    }
    //팝업 프로세스 검색조회
    public function popupPsSearch(Request $request){
        $searchWord = $request -> input('searchWord');
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
        //이렇게 할거면 프로시저에서 if 문으로 쿼리 따로주자
        // $data=DB::table('OnlineBatch_Job')->where('OnlineBatch_Job.Job_Name','like',"%$searchWord%")->paginate(10);
        $processContents = DB::select('CALL Process_searchUsedList(?,?,?)',[$searchWord,$WorkLarge, $WorkMedium]);
        $page=$request->input('page');
            //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
        $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,5,$processContents);
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
        $returnHTML = view('/popup/gusungProcessSearchListView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium'))->render();

        return response()->json(array('returnHTML'=>$returnHTML,200));
        //return $data;

    }
    //팝업- 잡 실행
    public function jobAction(Request $request){
        $Job_Seq = $request->input('Job_Seq');
        $jobGusungContents = DB::select('CALL JobGusung_List(?)',[$Job_Seq]);
        $jobDetail = DB::select('CALL Job_detail(?)',[$Job_Seq]);
        $jobName = DB::table('OnlineBatch_Job')->where("Job_Seq",$Job_Seq)->get();
        $jobName = $jobName[0]->Job_Name;

        //////// 최초 및 검색 시 필요한 조건 
        $searchWord = $request -> input('searchWord');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        $WorkLargeDetail = $jobDetail[0]->Job_WorkLargeCtg;
        $WorkMediumDetail = $jobDetail[0]->Job_WorkMediumCtg;
        $jobTotalTime=DB::select('CALL Job_totalTime(?)',[$Job_Seq]);
        if($searchWord==""){
            $searchWord="searchWordNot";
        }
        if($WorkLarge==""){
            $WorkLarge="all";
        }
        if($WorkMedium==""){
            $WorkMedium="all";
        }

        $data = DB::select('CALL Process_searchUsedList(?,?,?)',[$searchWord,$WorkLarge,$WorkMedium]);
        $usedLarge = DB::select('CALL Common_LargeCode()');
        $page=$request->input('page');
          //////// 최초 및 검색 시 필요한 조건 
        return view('popup.jobAction',compact('jobGusungContents','jobTotalTime','jobName','jobDetail','data','searchWord','WorkLarge','WorkMedium','WorkLargeDetail','WorkMediumDetail','usedLarge'));
    }
    // 모니터링- 잡 상세 팝업
    public function jobDetailPopup(Request $request) {
        $job_seq = $request->input('Job_Seq');
        //프로시저를 통한 잡 상세정보 검색
        $jobDetail=DB::select('CALL Job_detail(?)',[$job_seq]);
        $WorkLarge = $jobDetail[0]->Job_WorkLargeCtg;
        $WorkMedium = $jobDetail[0]->Job_WorkMediumCtg;
        $jobTotalTime=DB::select('CALL Job_totalTime(?)',[$job_seq]);
        return view('popup.jobDetailPopup',compact('jobDetail','jobTotalTime','WorkLarge','WorkMedium'));
    }
    // 모니터링- 잡 스케줄 상세 팝업
    public function scheduleDetailPopup(Request $request) {
        $job_seq = $request->input('Job_Seq');
        $sc_seq = $request->input('Sc_Seq');
        $jobGusungContents = DB::select('CALL Schedule_programList(?,?)',[$job_seq,$sc_seq]);
        //$jobGusungContents = DB::table('OnlineBatch_ScheduleProcess')->where('Job_Seq',$job_seq)->where('Sc_Seq',$sc_seq);
        //프로시저를 통한 잡 상세정보 검색
        $jobDetail=DB::select('CALL Job_detail(?)',[$job_seq]);
        //프로시저를 통한 스케줄러 상세정보 검색
        $scheduleDetail=DB::select('CALL Schedule_detail(?,?)',[$sc_seq,$job_seq]);

        $WorkLarge = $jobDetail[0]->Job_WorkLargeCtg;
        $WorkMedium = $jobDetail[0]->Job_WorkMediumCtg;
        $jobTotalTime=DB::select('CALL Job_totalTime(?)',[$job_seq]);
        return view('popup.scheduleDetailPopup',compact('jobDetail','jobGusungContents','scheduleDetail','jobTotalTime','WorkLarge','WorkMedium'));
    }
    // 모니터링 - 잡 스케줄 프로세ㅔ스 상세 팝업
    public function processDetailPopup(Request $request) {
        $p_seq = $request->input('P_Seq');
        //프로시저를 통한 프로세스 상세정보 검색
        $processDetail=DB::select('CALL Process_detail(?)',[$p_seq]);
        return view('popup.processDetailPopup',compact('processDetail'));
    }
    // 팝업 - 잡 검색
    public function jobSearchView(Request $request){
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

        // 사용중인 것만 조회
        $jobContents = DB::select('CALL Job_searchUsedList(?,?,?)',[$searchWord,$WorkLarge,$WorkMedium]);
        $usedLarge = DB::select('CALL Common_LargeCode()');

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
            $usedMedium = DB::select('CALL Common_MediumCode(?)',[$WorkLarge]);
            return view('popup.jobSearchView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','usedMedium','handle'));
        }else{
            return view('popup.jobSearchView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','handle'));
        }
    }
}