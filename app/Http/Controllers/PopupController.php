<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;
use PDO;
// use Monolog\Handler\PHPConsoleHandler;

class PopupController extends Controller
{
    //팝업- 프로세스 상세
    public function processInfo(){
        return view('/popup/processInfo');
    }
    //팝업- 잡 구성
    public function jobGusung(Request $request){
        $Job_Seq = $request->input('Job_Seq');
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
   
        $JOB = new App\Job;
        $PROCESS = new App\Process;
        $COMMON = new App\Common;
        //잡 구성 리스트 조회 
        $jobGusungContents = $JOB->jobGusungList($Job_Seq);
        //잡 상세
        $jobDetail = $JOB->jobDetail($Job_Seq);
        //프로그램 검색 조회 (전체 포함)
        $data = $PROCESS->processSearchUsedList($searchWord,$WorkLarge,$WorkMedium);
        $usedLarge = $COMMON->commonLargeCode();
        //잡 명 조회
        $jobName = DB::table('ONLINEBATCH_JOB')->where("JOB_SEQ",$Job_Seq)->get();
        $jobName = $jobName[0]->job_name;
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
        $gusungCount = DB::table('ONLINEBATCH_JOBGUSUNG')->where('Job_Seq',$Job_Seq);
        if(!empty($gusungCount)){
            $gusungCount = $gusungCount->count();
        }
       //잡 상태 체크 프로시저 
       $query="begin JOBSTATUSCHECK(:jobSeq,:v_end,:v_error,:v_yeyak,:v_exec,:v_wait,:v_result); end;";
       
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
           //잡상태에 따른 분기 처리
           if($v_exec==0&&$v_yeyak==0&&$v_error==0&&$v_end==0){
                if(!empty($gusungCount)){
                    if(!empty($gusungProcess)){
                        DB::table('ONLINEBATCH_JOBGUSUNG')->where('JOB_SEQ',$Job_Seq)->delete();
                        for($i = 0; $i<count($gusungProcess);$i++){
                            # 잡 구성
                            DB::table('ONLINEBATCH_JOBGUSUNG')->insert(['JOB_SEQ'=>$Job_Seq,'P_SEQ'=>$gusungProcess[$i],'JOBGUSUNG_ORDER'=>$i+1,'JOBGUSUNG_PARAMPOS'=>$gusungData[$i]]);
                        }
                    }else{
                        return response()->json(array("msg"=>'count0',"msg2"=>'수정시 잡 구성 개수가 0개 일 수 없습니다.'),200);
                    }
                }else {
                    for($i = 0; $i<count($gusungProcess);$i++){
                        # 잡 구성
                        DB::table('ONLINEBATCH_JOBGUSUNG')->insert(['JOB_SEQ'=>$Job_Seq,'P_SEQ'=>$gusungProcess[$i],'JOBGUSUNG_ORDER'=>$i+1,'JOBGUSUNG_PARAMPOS'=>$gusungData[$i]]);
                    }
                }
                return response()->json(array('count'=>count($gusungProcess),'gusung'=>$gusungCount,"msg"=>'success',"msg2"=>'등록되었습니다.'),200);
           }else{
                $msg2 = "잡이 실행,예약,오류,종료 상태이면 수정할 수 없습니다.";
                return response()->json(array('count'=>count($gusungProcess),'gusung'=>$gusungCount,"msg"=>'failed','msg2'=>$msg2),200);
           }
       }else{
            $msg2="프로시저 오류";
            return response()->json(array("msg"=>'procedureError','msg2'=>$msg2),200);
       }
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
        $PROCESS = new App\Process;
        //프로그램 검색 조회 (전체 포함)
        $processContents = $PROCESS->processSearchUsedList($searchWord,$WorkLarge,$WorkMedium);
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

    }
    //팝업- 잡 실행
    public function jobAction(Request $request){
        $Job_Seq = $request->input('Job_Seq');
        //잡 구성 리스트 
        $JOB = new App\Job;
        //잡 구성 리스트 조회 
        $jobGusungContents = $JOB->jobGusungList($Job_Seq);
        $jobDetail = $JOB->jobDetail($Job_Seq);
        $jobName = DB::table('ONLINEBATCH_JOB')->where("JOB_SEQ",$Job_Seq)->get();
        $jobName = $jobName[0]->job_name;

        //////// 최초 및 검색 시 필요한 조건 
        $searchWord = $request -> input('searchWord');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        $WorkLargeDetail = $jobDetail[0]->job_worklargectg;
        $WorkMediumDetail = $jobDetail[0]->job_workmediumctg;
        $jobTotalTime=$JOB->jobTotalTime($Job_Seq);
        if($searchWord==""){
            $searchWord="searchWordNot";
        }
        if($WorkLarge==""){
            $WorkLarge="all";
        }
        if($WorkMedium==""){
            $WorkMedium="all";
        }

        $PROCESS = new App\Process;
        $COMMON = new App\Common;
        //프로그램 검색 조회 (전체 포함)
        $data = $PROCESS->processSearchUsedList($searchWord,$WorkLarge,$WorkMedium);
        $usedLarge = $COMMON->commonLargeCode();
        $page=$request->input('page');
          //////// 최초 및 검색 시 필요한 조건 
        return view('popup.jobAction',compact('jobGusungContents','jobTotalTime','jobName','jobDetail','data','searchWord','WorkLarge','WorkMedium','WorkLargeDetail','WorkMediumDetail','usedLarge'));
    }
    // 모니터링- 잡 상세 팝업
    public function jobDetailPopup(Request $request) {
        $job_seq = $request->input('Job_Seq');
        $JOB = new App\Job;
        //잡 상세조회
        $jobDetail =$JOB->jobDetail($job_seq);
        $WorkLarge = $jobDetail[0]->job_worklargectg;
        $WorkMedium = $jobDetail[0]->job_workmediumctg;
        //잡 예상 최대시간 토탈 조회
        $jobTotalTime=$JOB->jobTotalTime($job_seq);
        return view('popup.jobDetailPopup',compact('jobDetail','jobTotalTime','WorkLarge','WorkMedium'));
    }
    
    // 모니터링- 잡 스케줄 상세 팝업
    public function scheduleDetailPopup(Request $request) {
        $job_seq = $request->input('Job_Seq');
        $sc_seq = $request->input('Sc_Seq');
        $JOB = new App\Job;
        $SCHEDULE = new App\Schedule;
        $jobGusungContents = $SCHEDULE->scheduleProgramList($job_seq,$sc_seq);
        //잡 상세정보 
        $jobDetail=$JOB->jobDetail($job_seq);
        //스케줄러 상세정보pu
        $scheduleDetail=$SCHEDULE->scheduleDetail($job_seq,$sc_seq);

        $WorkLarge = $jobDetail[0]->job_worklargectg;
        $WorkMedium = $jobDetail[0]->job_workmediumctg;
        $scheduleTotalTime=$SCHEDULE->scheduleTotalTime($job_seq,$sc_seq);
        return view('popup.scheduleDetailPopup',compact('jobDetail','jobGusungContents','scheduleDetail','$scheduleTotalTime','WorkLarge','WorkMedium'));
    }
    ////////////////////////////kimh
    // 모니터링 - 잡 스케줄 프로세스 상세 팝업
    public function processDetailPopup(Request $request) {
        $Sc_Seq = $request->input('Sc_Seq');
        $p_seq = $request->input('P_Seq');
        //프로시저를 통한 프로세스 상세정보 검색
        $MONITORING = new App\Monitoring;
        $processDetail = $MONITORING->monitorProcessDetail($Sc_Seq,$p_seq);
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
        $PROCESS = new App\Process;
        $SCHEDULE = new App\Schedule;
        $COMMON = new App\Common;
        // 사용중인 것만 조회
        $jobContents = $SCHEDULE->scheduleJobGusungList($searchWord,$WorkLarge,$WorkMedium);
        //프로그램 검색 조회 (전체 포함)
        $data = $PROCESS->processSearchUsedList($searchWord,$WorkLarge,$WorkMedium);
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

//스케줄 프로그램 텍스트 변수 수정 팝업
function scProgramTextInputUpdatePopup(Request $request){
    $P_Seq = $request->input('P_Seq');
    
}
?>