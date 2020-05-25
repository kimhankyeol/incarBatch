<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;

class JobController extends Controller
{
    //메인화면
    public function index(){
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
             $usedMedium = DB::select('CALL Common_jobMediumCode(?)',[$WorkLarge]);
            // $usedMedium = DB::select('CALL Common_MediumCode(?)',[$WorkLarge]);
            // $usedMedium =  DB::table('OnlineBatch_WorkMediumCode')->where('WorkLarge', $WorkLarge)->get();
            return view('job.jobListView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','usedMedium'));
        }else{
            return view('job.jobListView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge'));
        }
    }
    //잡 상세 뷰
    public function jobDetailView(Request $request){
        $job_seq = $request->input('Job_Seq');
        //프로시저를 통한 잡 상세정보 검색
        $jobDetail=DB::select('CALL Job_detail(?)',[$job_seq]);
        $WorkLarge = $jobDetail[0]->Job_WorkLargeCtg;
        $WorkMedium = $jobDetail[0]->Job_WorkMediumCtg;
        $jobTotalTime=DB::select('CALL Job_totalTime(?)',[$job_seq]);
        $jobStatusCheck =DB::select('CALL Monitoring_jobStatusCheck(?)',[$job_seq]);
        return view('job.jobDetailView',compact('jobDetail','jobTotalTime','WorkLarge','WorkMedium','jobStatusCheck'));
    }
    //잡 등록 뷰
    public function jobRegisterView(){
        //Job_searchUsedLargeCode 프로시저를 실행하기 위한 변수선언
        $searchWord="searchWordNot";
        $WorkLarge="all";
        $WorkMedium="all";
        $usedLarge = DB::select('CALL Job_RegViewLargeCode');
        return view('job.jobRegisterView',compact('usedLarge','WorkMedium','WorkLarge'));
    }
    //잡 수정 뷰
    public function jobUpdateView(Request $request){
        $job_seq = $request->input('Job_Seq');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        //프로시저를 통한 잡 상세정보 검색
        $jobDetail=DB::select('CALL Job_detail(?)',[$job_seq]);
        $jobTotalTime=DB::select('CALL Job_totalTime(?)',[$job_seq]);
        $jobStatusCheck =DB::select('CALL Monitoring_jobStatusCheck(?)',[$job_seq]);
        
        //잡상태에 따른 분기 처리
        $exec=$jobStatusCheck[0]->v_exec;
        $yeyak=$jobStatusCheck[0]->v_yeyak;
        $error=$jobStatusCheck[0]->v_error;
        $end=$jobStatusCheck[0]->v_end;

        if($exec==0&&$yeyak==0&&$error==0&&$end==0){
            return view('job.jobUpdateView',compact('jobDetail','WorkLarge','WorkMedium','jobTotalTime','jobStatusCheck'));
        } else {
            $msg = "잡이 실행,예약,오류,종료 상태이면 수정할 수 없습니다.";
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
        $Job_DeleteYN = "n";
        $Job_GusungVersion = 0;
        //업무 대분류 중분류
        $Job_WorkLargeCtg=$request->input('Job_WorkLargeCtg');
        $Job_WorkMediumCtg=$request->input('Job_WorkMediumCtg');

     
        //insert 된 last seq 를 조회 해야됨
        //등록일 CURRENT_TIMESTAMP  db에서 지정
        $last_job_seq = DB::table('OnlineBatch_Job')->insertGetId(
            ['Job_Name' => $Job_Name,
            'Job_Sulmyung'=> $Job_Sulmyung,
            'Job_RegId'=>$Job_RegId,
            'Job_RegIP'=>$Job_RegIP,
            'Job_RegDate'=>now(),
            'Job_Params'=>$Job_Params,
            'Job_ParamSulmyungs'=>$Job_ParamSulmyungs,
            'Job_DeleteYN'=>$Job_DeleteYN,
            'Job_WorkLargeCtg'=>$Job_WorkLargeCtg,
            'Job_WorkMediumCtg'=>$Job_WorkMediumCtg
            ]
        );
        //등록이 되었으면
        if($last_job_seq!=""){
            $msg="success"; 
            return response()->json(array('msg'=>$msg,'lastJobSeq'=>$last_job_seq,'Job_Name'=>$Job_Name),200);
        }else{
            $msg="failed";
            return response()->json(array('msg'=>$msg),403);
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
        $jobStatusCheck =DB::select('CALL Monitoring_jobStatusCheck(?)',[$Job_Seq]);
        
        //잡상태에 따른 분기 처리
        $exec=$jobStatusCheck[0]->v_exec;
        $yeyak=$jobStatusCheck[0]->v_yeyak;
        $error=$jobStatusCheck[0]->v_error;
        $end=$jobStatusCheck[0]->v_end;

        if($exec==0&&$yeyak==0&&$error==0&&$end==0){
            $result = DB::table('incar.OnlineBatch_Job')->where('Job_Seq',$Job_Seq)->update([
                'Job_Name'=>$Job_Name,
                'Job_Sulmyung'=>$Job_Sulmyung,
                'Job_UpdId'=>$Job_UpdId,
                'Job_UpdIP'=>$Job_UpdIP,
                'Job_Params'=>$Job_Params,
                'Job_ParamSulmyungs'=>$Job_ParamSulmyungs,
                'Job_WorkLargeCtg'=>$Job_WorkLargeCtg,
                'Job_WorkMediumCtg'=>$Job_WorkMediumCtg
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
    }
}
