<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;
use DateTime;
class ExecuteController extends Controller
{
    //잡 로그  tail add
    public function jobTailAdd(Request $request){
        $line = $request->input('line');
        $Job_Seq = $request->input('Job_Seq');
        $P_Seq = $request->input('P_Seq');
        $setNum = $request->input('setNum');
        $headTail = $request->input('headTail');
        $logSearchWord = $request->input('logSearchWord');
        $Sc_Seq = $request->input('Sc_Seq');

        //검색어가 없으면
        if($logSearchWord==""){
            //잡시퀀스를 통해 잡구성 정보 로그파일 이름 가져와야함 잡 테이블 ,잡구성 ,잡상태 모니터링 테이블에서 정보를 가져와야함 
            //로그파일은 job_업무대분류_업무중분류_잡시퀀스_스케줄시퀀스_잡실행날짜  job_1000_100_75_1_20200504.log
            $getJobInfo = DB::select('CALL Execute_jobGusungList(?,?)',[$Job_Seq,$Sc_Seq]);
            //잡의 첫번쨰 프로그램이 실행될떄가 잡이 실행되는 시점
            if(!empty($getJobInfo)){
                
                //만약 상태모니터링 테이블에서 시작시간이 업데이트 된다하면 실행시간 다시 구해야됨
                $JobExecuteDate =  $getJobInfo[0]->Sc_StartTime;
                //2020-05-05 02:20:20 - > 20200505 로 변환해야됨
                $JobExecuteDate = new DateTime($JobExecuteDate);
                $JobExecuteDate = $JobExecuteDate->format('Ymd');

                $WorkLarge =  $getJobInfo[0]->WorkLarge;
                $WorkMedium =  $getJobInfo[0]->WorkMedium;
                
                $logfilename = "program_".$WorkLarge."_".$WorkMedium."_".$Job_Seq."_".$Sc_Seq."_".$P_Seq."_".$JobExecuteDate.".log";
                $logfile = "/home/script/log/".$WorkLarge."/".$WorkMedium."/".$Job_Seq."/".$Sc_Seq."/".$JobExecuteDate."/".$logfilename;
                $lineTotal = shell_exec("wc -l ".$logfile); 
                $lineTotal = explode(" ",$lineTotal)[0];
                $fileSize = filesize($logfile);
                $lastmod = date("Y.m.d H:i:s", filemtime($logfile));
                //라인 수가 없을떄 재검색시 
                if($line==0||$line==""){
                    $line=10;
                }
                // 조회 하면 string 으로 뽑혀오는데 숫자+공백  = 문자열 나와버려서 int형으로 바꿔서 처리함
                $line = intVal($line);
                $lineTotal = intVal($lineTotal);
                // 로그 더보기 라인 갯수가 로그 라인 토탈을 초과하면 안되기 떄문에 분기처리 해줘야함
                if($lineTotal<=$line){
                    $msg = "lineExcess";
                    $returnHTML = view('job.execute.jobTailAddView',compact('line','Job_Seq','JobExecuteDate','WorkLarge','WorkMedium','logfile','lineTotal','msg','setNum','fileSize','headTail','lastmod','logfilename'))->render();
                    return response()->json(array('returnHTML'=>$returnHTML,'lineTotal'=>$lineTotal ),200);
                }else if($lineTotal>$line){
                    $msg = "success";
                    $returnHTML = view('job.execute.jobTailAddView',compact('line','Job_Seq','JobExecuteDate','WorkLarge','WorkMedium','logfile','lineTotal','msg','setNum','fileSize','headTail','lastmod','logfilename'))->render();
                    return response()->json(array('returnHTML'=>$returnHTML,'lineTotal'=>$lineTotal ),200);
                }
            }else{
                // 잡실행을 누른뒤에 상태모니터링 테이블에 정보가 저장되니 프로시저 조회한 값이 없으면 잡실행에 등록이 안된것임
                $msg = "notExec";
                $returnHTML = view('job.execute.jobTailAddView',compact('msg'))->render();
                return response()->json(array('returnHTML'=>$returnHTML ),200);
            }
        }else{
            //검색어가 있으면

            //잡시퀀스를 통해 잡구성 정보 로그파일 이름 가져와야함 잡 테이블 ,잡구성 ,잡상태 모니터링 테이블에서 정보를 가져와야함 
            //로그파일은 job_업무대분류_업무중분류_잡시퀀스_스케줄시퀀스_잡실행날짜  job_1000_100_75_1_20200504.log
            $getJobInfo = DB::select('CALL Execute_jobGusungList(?,?)',[$Job_Seq,$Sc_Seq]);
            //잡의 첫번쨰 프로그램이 실행될떄가 잡이 실행되는 시점
            if(!empty($getJobInfo)){
                
                //만약 상태모니터링 테이블에서 시작시간이 업데이트 된다하면 실행시간 다시 구해야됨
                $JobExecuteDate =  $getJobInfo[0]->Sc_StartTime;
                //2020-05-05 02:20:20 - > 20200505 로 변환해야됨
                $JobExecuteDate = new DateTime($JobExecuteDate);
                $JobExecuteDate = $JobExecuteDate->format('Ymd');

                $WorkLarge =  $getJobInfo[0]->WorkLarge;
                $WorkMedium =  $getJobInfo[0]->WorkMedium;
                
                //폴더명은 log 뒤부터 /업무 대분류/업무 중분류/잡시퀀스/스케줄시퀀스/파일명
                $logfilename = "program_".$WorkLarge."_".$WorkMedium."_".$Job_Seq."_".$Sc_Seq."_".$P_Seq."_".$JobExecuteDate.".log";
                $logfile = "/home/script/log/".$WorkLarge."/".$WorkMedium."/".$Job_Seq."/".$Sc_Seq."/".$JobExecuteDate."/".$logfilename;
                $lineTotal = shell_exec("grep -o ".$logSearchWord." ".$logfile."|wc -w");
                $lineTotal = explode(" ",$lineTotal)[0];
               
                $fileSize = filesize($logfile);      
                $lastmod = date("Y.m.d H:i:s", filemtime($logfile));

                if($line==0||$line==""){
                    $line=10;
                }
                $line = intVal($line);
                $lineTotal = intVal($lineTotal);
                // 로그 더보기 라인 갯수가 로그 라인 토탈을 초과하면 안되기 떄문에 분기처리 해줘야함
                if($lineTotal==0){
                    $msg = "notFound";
                    $returnHTML = view('job.execute.jobTailAddView',compact('line','Job_Seq','JobExecuteDate','WorkLarge','WorkMedium','logfile','lineTotal','msg','setNum','fileSize','headTail','lastmod','logfilename','logSearchWord'))->render();
                    return response()->json(array('returnHTML'=>$returnHTML,'lineTotal'=>$lineTotal ),200);
                }else{
                    if($lineTotal<=$line){
                        $msg = "lineExcess";
                        $returnHTML = view('job.execute.jobTailAddView',compact('line','Job_Seq','JobExecuteDate','WorkLarge','WorkMedium','logfile','lineTotal','msg','setNum','fileSize','headTail','lastmod','logfilename','logSearchWord'))->render();
                        return response()->json(array('returnHTML'=>$returnHTML,'lineTotal'=>$lineTotal ),200);
                    }else if($lineTotal>$line){
                        $msg = "success";
                        $returnHTML = view('job.execute.jobTailAddView',compact('line','Job_Seq','JobExecuteDate','WorkLarge','WorkMedium','logfile','lineTotal','msg','setNum','fileSize','headTail','lastmod','logfilename','logSearchWord'))->render();
                        return response()->json(array('returnHTML'=>$returnHTML,'lineTotal'=>$lineTotal ),200);
                    } 
                }
            }else{
                // 잡실행을 누른뒤에 상태모니터링 테이블에 정보가 저장되니 프로시저 조회한 값이 없으면 잡실행에 등록이 안된것임
                $msg = "notExec";
                $returnHTML = view('job.execute.jobTailAddView',compact('msg'))->render();
                return response()->json(array('returnHTML'=>$returnHTML ),200);
            }
        }
        
    }
}