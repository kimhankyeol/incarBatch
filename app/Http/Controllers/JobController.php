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
        $workLargeCtg = $request->input('workLargeCtg');
        $workMediumCtg = $request->input('workMediumCtg');

        // $data=DB::table('OnlineBatch_Job')->where('OnlineBatch_Job.Job_Name','like',"%$searchWord%")->paginate(10);
        $jobContents = DB::select('CALL searchJobList(?,?,?)',[$searchWord,$workLargeCtg, $workMediumCtg]);
        $page=$request->input('page');
        //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
        $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,10,$jobContents);
        //페이징 정보를 가져옴
        $paginator = $PaginationCustom->getPaging();
        //현재 페이지에서 보여주는 조회 정보 리스트를 가져옴
        $data =$PaginationCustom->getItemsForCurrentPage();
        $searchParams = array( 'searchWord' => $searchWord);
               
        //대분류 , 중분류 전체일 조건  
        if($workLargeCtg=="all"&&$workMediumCtg=="all"){
            $searchParams = array( 'searchWord' => $searchWord);
        }
        //대분류 선택, 중분류 전체
        else if($workLargeCtg!="all"&&$workMediumCtg=="all"){
            $searchParams = array( 'searchWord' => $searchWord,'workLargeCtg' => $workLargeCtg,'workMediumCtg'=>'all');
        }
        //대분류 선택 ,중분류 선택
        else if($workLargeCtg!="all"&&$workMediumCtg!="all"){
            $searchParams = array( 'searchWord' => $searchWord,'workLargeCtg' => $workLargeCtg,'workMediumCtg' => $workMediumCtg);
        }
        return view('job.jobListView',compact('data','searchWord','searchParams','paginator'));
         
    }
    //잡 상세 뷰
    public function jobDetailView(Request $request){
        $job_seq = $request->input('Job_Seq');
        $Codetype = "B";
        //프로시저를 통한 잡 상세정보 검색
        $jobDetail=DB::select('CALL jobDetail(?,?)',[$job_seq,$Codetype]);
        return view('job.jobDetailView',compact('jobDetail'));
    }
    //잡 등록 뷰
    public function jobRegisterView(){
        return view('job.jobRegisterView');
    }
    //잡 등록
    public function jobRegister(Request $request){
        $Job_Name=$request->input('Job_Name');
        $Job_Sulmyung = $request->input('Job_Sulmyung');
        $Job_RegId = $request->input('Job_RegId');
        $Job_RegIP = $_SERVER["REMOTE_ADDR"];
        $Job_YesangTime = $request->input('Job_YesangTime');
        $Job_YesangMaxTime = $request->input('Job_YesangMaxTime');
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
            'Job_RegIP'=>ip2long($Job_RegIP),
            'Job_YesangTime'=>$Job_YesangTime,
            'Job_YesangMaxTime'=>$Job_YesangMaxTime,
            'Job_Params'=>$Job_Params,
            'Job_ParamSulmyungs'=>$Job_ParamSulmyungs,
            'Job_DeleteYN'=>$Job_DeleteYN,
            'Job_GusungVersion'=>$Job_GusungVersion,
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
}
