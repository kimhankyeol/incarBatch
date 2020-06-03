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
        

        $jobStatusCheck =DB::select('CALL Monitoring_jobStatusCheck(?)',[$Job_Seq]);
        
        //잡상태에 따른 분기 처리
        $exec=$jobStatusCheck[0]->v_exec;
        $yeyak=$jobStatusCheck[0]->v_yeyak;
        $error=$jobStatusCheck[0]->v_error;
        $end=$jobStatusCheck[0]->v_end;

        if($exec==0&&$yeyak==0&&$error==0&&$end==0){
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
            return response()->json(array('count'=>count($gusungProcess),'gusung'=>$gusungCount,"msg"=>'success',"msg2"=>'등록되었습니다.'),200);
        
        } else {
            $msg2 = "잡이 실행,예약,오류,종료 상태이면 수정할 수 없습니다.";
            return response()->json(array('count'=>count($gusungProcess),'gusung'=>$gusungCount,"msg"=>'failed','msg2'=>$msg2),200);
        }
        //return response()->json(array('Job_Seq'=>$Job_Seq,'gusungData'=>$gusungData,'gusungProcess'=>count($gusungProcess),'gusungCount'=>$gusungCount,200)); 
       // return response()->json(array('count'=>count($gusungProcess),'gusung'=>$gusungCount),200);
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
    // 모니터링 - 잡 스케줄 프로세스 상세 팝업
    public function processDetailPopup(Request $request) {
        $Sc_Seq = $request->input('Sc_Seq');
        $p_seq = $request->input('P_Seq');
        //프로시저를 통한 프로세스 상세정보 검색
        $processDetail=DB::select('CALL Monitor_processDetail(?,?)',[$Sc_Seq,$p_seq]);
        return view('popup.processDetailPopup',compact('processDetail'));
    }
    // 모니터링 - 잡 스케줄 프로세스 재작업 변경
    public function reWorkModifi(Request $request) {
        $Sc_P_Seq = $request->input('Sc_P_Seq');
        $result = DB::table('incar.OnlineBatch_ScheduleProcess')->where('Sc_P_Seq',$Sc_P_Seq)->update([
            'Sc_ReworkYN'=>1
        ]);
        return response()->json(array('result'=>$result));
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
        $jobContents = DB::select('CALL Schedule_gusungJobList(?,?,?)',[$searchWord,$WorkLarge,$WorkMedium]);
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
            $usedMedium = DB::select('CALL Common_jobMediumCode(?)',[$WorkLarge]);
            return view('popup.jobSearchView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','usedMedium','handle'));
        }else{
            return view('popup.jobSearchView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','handle'));
        }
    }
    // 작업내역 - 작업상세
    public function historyProcessListPopup(Request $request){
        return view('popup.historyProcessListPopup');
    }
    //모니터링 - 로그 출력
    public function monitoringLogPopup(Request $request){
        $Sc_Seq = $request->input('Sc_Seq');
        $Job_Seq = $request->input('Job_Seq');
        $P_Seq = $request->input('P_Seq');

        return view('popup.monitoringLogPopup',compact('processLog','Job_Seq','Sc_Seq','P_Seq'));
    }
    public function monitoringLogMore(Request $request){
        $Sc_Seq = $request->input('Sc_Seq');
        $Job_Seq = $request->input('Job_Seq');
        $P_Seq = $request->input('P_Seq');
        $loop = $request->input('loop');
        $searchWord = $request->input('searchWord');
        $lineCount = $request->input('lineCount');
        $headTail = $request->input('headTail');
        $setNum = $request->input('setNum');
        $processLog = DB::table('OnlineBatch_ScheduleProcess')
        ->where('Job_Seq','=',$Job_Seq)
        ->where('Sc_Seq','=',$Sc_Seq)
        ->where('P_Seq','=',$P_Seq)
        ->value('Sc_LogFile');
        $processName = DB::table('OnlineBatch_Process')
        ->where('P_Seq','=',$P_Seq)
        ->value('P_Name');
        // $file ='/home/script/log/20200621/susuryo_gyesan_1_1_0.log'; // 불러올 파일명
        $file = $processLog;
        if(isset($file)&&file_exists($file)){
            //최근 수정 시간
            $lastModifiedTimestamp = filemtime($file);
            $lastModifiedDatetime = date("Y년 m월 d일 H:i:s", $lastModifiedTimestamp);
            $fileSize = fileSize($file);
            $fileSize = round($fileSize/1024/1024,2);
            $lineAdd ="";
            $lineCount=$lineCount+$loop;
              //1 최신 0 과거
            if($headTail==1){
                $lineAdd = file_tail($file, $lineCount,$searchWord,$setNum);
            }else{
                $lineAdd = file_head($file, $lineCount,$searchWord,$setNum);
            }
            $msg="success";
            return response()->json(array('Job_Seq'=>$Job_Seq,'Sc_Seq'=>$Sc_Seq,'P_Seq'=>$P_Seq,'lineCount'=>$lineCount,'loop'=>$loop,'lineAdd'=>$lineAdd,'fileName'=>$file,'lastModifiedDatetime'=>$lastModifiedDatetime,'fileSize'=>$fileSize,'processName'=>$processName,'setNum'=>$setNum,'headTail'=>$headTail,'msg'=>$msg));
        }else if(isset($file)&&(!file_exists($file))){
            //디비에는 조회가 되지만 파일이 서버상에 없는경우
            //이 경우는 잡 또는 프로그램이 실행을 하지 않아 로그가 생기지 않았거나 데몬이 안돌았거나 
            $msg="failedOne";
            return response()->json(array('msg'=>$msg));
        }else if(!isset($file)){
            //디비 조회 안된 경우
            $msg="failedTwo";
            return response()->json(array('msg'=>$msg));
        }
      
      
        /////////////////////역순차적///////////////////////////////////////
    }
}
function file_head($file, $lineCount ,$searchWord,$setNum){
    $f = fopen($file, "r");
    fseek($f,0,SEEK_SET);
    $linecounter = $lineCount;
    $i=1;
    $lineAdd="";
    if($searchWord==""){
        while ( ( $line = fgets( $f, 4096 ) ) !== false ) {
            if ( $i == $linecounter ) {
                if($setNum==1){
                    $line="<p class='m-0 text-nowrap'><span class='mr-2 text-primary'>".intVal($i)."</span>".$line."</p>";
                    $lineAdd = $lineAdd.$line;
                }else{
                    $line="<p class='m-0 text-nowrap'>".$line."</p>";
                    $lineAdd = $lineAdd.$line;
                }
                fclose($f);
                return $lineAdd;
            }else{
                if($setNum==1){
                    $line="<p class='m-0 text-nowrap'><span class='mr-2 text-primary'>".intVal($i)."</span>".$line."</p>";
                    $lineAdd = $lineAdd.$line;
                }else{
                    $line="<p class='m-0 text-nowrap'>".$line."</p>";
                    $lineAdd = $lineAdd.$line;
                }
            }
            ++$i;
        }
    }else{
        while ( ( $line = fgets( $f, 4096 ) ) !== false ) {
            if ( $i == $linecounter ) {
                $newvalue = "<span style='color:red'>".$searchWord."</span>";
                $new_text = str_replace($searchWord,$newvalue,$line);
                if($setNum==1){
                    $line="<p class='m-0 text-nowrap'><span class='mr-2 text-primary'>".intVal($i)."</span>".$new_text."</p>";
                    $lineAdd = $lineAdd.$line;
                }else{
                    $line="<p class='m-0 text-nowrap'>".$line."</p>";
                    $lineAdd = $lineAdd.$line;
                }
                fclose($f);
                return $lineAdd;
            }else{
                $newvalue = "<span style='color:red'>".$searchWord."</span>";
                $new_text = str_replace($searchWord,$newvalue,$line);
                if($setNum==1){
                    $line="<p class='m-0 text-nowrap'><span class='mr-2 text-primary'>".intVal($i)."</span>".$new_text."</p>";
                    $lineAdd = $lineAdd.$line;
                }else{
                    $line="<p class='m-0 text-nowrap'>".$new_text."</p>";
                    $lineAdd = $lineAdd.$line;
                }
            }
            ++$i;
        }
    }
  
}
//tail
function file_tail($file, $lineCount ,$searchWord,$setNum) {
    //global $fsize;
    $f = fopen($file, "r");
    $linecounter = $lineCount;
    $pos = -2;
    $beginning = false;
    $text = array();
    if($searchWord==""){
        while ($linecounter > 0) {
            $t = " ";
            while ($t != "\n") {
                if(fseek($f, $pos, SEEK_END) == -1) {
                    $beginning = true;
                    break;
                }
                $t = fgetc($f);
                $pos --;
            }
            $linecounter --;
            if ($beginning) {
                rewind($f);
            }
            $text[$lineCount-$linecounter-1] = fgets($f);
            if ($beginning) break;
        }
    }else{
        while ($linecounter > 0) {
            $t = " ";
            while ($t != "\n") {
                if(fseek($f, $pos, SEEK_END) == -1) {
                    $beginning = true;
                    break;
                }
                $t = fgetc($f);
                $pos --;
            }
            $linecounter --;
            if ($beginning) {
                rewind($f);
            }
            $newvalue = "<span style='color:red'>".$searchWord."</span>";
            $new_text = str_replace($searchWord,$newvalue,fgets($f));
            $text[$lineCount-$linecounter-1] = $new_text;
         
            if ($beginning) break;
        }
    }
   
    fclose ($f);
    $lines=array_reverse($text);
    $lineAdd="";
    foreach ($lines as $index=>$line) {
        if($setNum==1){
            $line="<p class='m-0 text-nowrap'><span class='mr-2 text-primary'>".intVal(count($lines)-$index)."</span>".$line."</p>";
            $lineAdd = $lineAdd.$line;
        }else{
            $line="<p class='m-0 text-nowrap'>".$line."</p>";
            $lineAdd = $lineAdd.$line;
        }
    }
    return $lineAdd;
}
?>